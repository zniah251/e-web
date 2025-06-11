const { getOrderData, getCustomerInfo } = require('./db');
const { generateInvoice } = require('./generateInvoice');
const { sendMailWithInvoice } = require('./sendMail');
const mysql = require('mysql2/promise');

// Function để tạo bảng log nếu chưa tồn tại
async function createInvoiceLogTable() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'e-web'
  });

  try {
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS invoice_sent_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        email VARCHAR(255),
        status ENUM('success', 'failed') DEFAULT 'success',
        error_message TEXT,
        INDEX (order_id)
      )
    `);
    console.log('✅ Bảng invoice_sent_log đã được tạo/kiểm tra');
  } catch (error) {
    console.error('❌ Lỗi tạo bảng invoice_sent_log:', error.message);
  } finally {
    await connection.end();
  }
}

// Function để lấy danh sách đơn hàng đã confirm nhưng chưa gửi email
async function getConfirmedOrders() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'e-web'
  });

  try {
    // Đầu tiên tạo bảng log nếu chưa có
    await createInvoiceLogTable();

    // Lấy các đơn hàng có trạng thái Confirmed
    const [rows] = await connection.execute(`
      SELECT 
        o.oid,
        o.create_at,
        o.destatus,
        o.paystatus,
        u.uname,
        u.email
      FROM orders o
      JOIN users u ON o.uid = u.uid
      WHERE o.destatus = 'Confirmed'
      AND o.oid NOT IN (
        SELECT order_id FROM invoice_sent_log WHERE sent_at IS NOT NULL
      )
      ORDER BY o.create_at DESC
    `);

    return rows;
  } catch (error) {
    console.error('❌ Lỗi khi lấy danh sách đơn hàng confirmed:', error.message);
    return [];
  } finally {
    await connection.end();
  }
}

// Function để đánh dấu đã gửi email
async function markInvoiceAsSent(orderId) {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'e-web'
  });

  try {
    // Ghi log đã gửi
    await connection.execute(`
      INSERT INTO invoice_sent_log (order_id, email, status)
      SELECT o.oid, u.email, 'success'
      FROM orders o
      JOIN users u ON o.uid = u.uid
      WHERE o.oid = ?
    `, [orderId]);

    console.log(`✅ Đã đánh dấu đơn hàng #${orderId} đã gửi email`);
  } catch (error) {
    console.error(`❌ Lỗi khi đánh dấu đơn hàng #${orderId}:`, error.message);
  } finally {
    await connection.end();
  }
}

// Function để ghi log lỗi
async function logInvoiceError(orderId, errorMessage) {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'e-web'
  });

  try {
    await connection.execute(`
      INSERT INTO invoice_sent_log (order_id, email, status, error_message)
      SELECT o.oid, u.email, 'failed', ?
      FROM orders o
      JOIN users u ON o.uid = u.uid
      WHERE o.oid = ?
    `, [errorMessage, orderId]);
  } catch (error) {
    console.error(`❌ Lỗi khi ghi log lỗi cho đơn hàng #${orderId}:`, error.message);
  } finally {
    await connection.end();
  }
}

// Function chính để xử lý tự động gửi hóa đơn
async function processConfirmedOrders() {
  console.log('🔄 Bắt đầu kiểm tra đơn hàng đã confirm...');
  
  try {
    const confirmedOrders = await getConfirmedOrders();
    
    if (confirmedOrders.length === 0) {
      console.log('ℹ️ Không có đơn hàng nào cần gửi hóa đơn.');
      console.log('💡 Lý do có thể là:');
      console.log('   - Không có đơn hàng nào có trạng thái "Confirmed"');
      console.log('   - Tất cả đơn hàng confirmed đã được gửi hóa đơn');
      console.log('   - Chưa có đơn hàng nào trong database');
      return;
    }

    console.log(`📋 Tìm thấy ${confirmedOrders.length} đơn hàng cần gửi hóa đơn:`);
    
    for (const order of confirmedOrders) {
      console.log(`\n📦 Xử lý đơn hàng #${order.oid} - ${order.uname} (${order.email})`);
      
      try {
        // Gửi hóa đơn
        const result = await handleSendInvoice(order.oid);
        
        if (result) {
          await markInvoiceAsSent(order.oid);
          console.log(`✅ Đã gửi hóa đơn thành công cho đơn hàng #${order.oid}`);
        } else {
          await logInvoiceError(order.oid, 'Gửi email thất bại');
          console.log(`❌ Không thể gửi hóa đơn cho đơn hàng #${order.oid}`);
        }
      } catch (error) {
        await logInvoiceError(order.oid, error.message);
        console.error(`💥 Lỗi xử lý đơn hàng #${order.oid}:`, error.message);
      }
      
      // Delay 2 giây giữa các lần gửi để tránh spam
      await new Promise(resolve => setTimeout(resolve, 2000));
    }
    
    console.log('\n✅ Hoàn thành xử lý tất cả đơn hàng confirmed!');
    
  } catch (error) {
    console.error('💥 Lỗi trong quá trình xử lý:', error.message);
  }
}

// Function để gửi hóa đơn cho một đơn hàng cụ thể (từ file sendInvoice,js)
async function handleSendInvoice(orderId) {
  try {
    if (!orderId || isNaN(orderId)) {
      console.log('❌ ID đơn hàng không hợp lệ.');
      return false;
    }

    const customerInfo = await getCustomerInfo(orderId);
    if (!customerInfo) {
      console.log('❌ Không tìm thấy thông tin khách hàng.');
      return false;
    }

    if (!customerInfo.email || !customerInfo.email.includes('@')) {
      console.log(`❌ Email không hợp lệ: ${customerInfo.email}`);
      return false;
    }

    const orderData = await getOrderData(orderId);
    if (!orderData || orderData.length === 0) {
      console.log('❌ Không tìm thấy chi tiết đơn hàng.');
      return false;
    }

    // Tạo PDF với async/await
    const filePath = await generateInvoice(orderData, orderId);
    console.log(`📄 Đã tạo file PDF: ${filePath}`);
    
    const emailSent = await sendMailWithInvoice(customerInfo.email, orderId, filePath);
    
    return emailSent;
  } catch (error) {
    console.error('⚠️ Lỗi:', error.message);
    return false;
  }
}

// Export các function
module.exports = { 
  processConfirmedOrders, 
  handleSendInvoice,
  getConfirmedOrders,
  markInvoiceAsSent
};

// Chạy tự động nếu file được execute trực tiếp
if (require.main === module) {
  processConfirmedOrders();
} 