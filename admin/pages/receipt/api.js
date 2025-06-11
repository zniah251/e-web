const express = require('express');
const { handleSendInvoice, processConfirmedOrders } = require('./autoSendInvoice');
const mysql = require('mysql2/promise');

const router = express.Router();

// API endpoint để gửi hóa đơn cho một đơn hàng cụ thể
router.post('/send-invoice/:orderId', async (req, res) => {
  try {
    const orderId = parseInt(req.params.orderId);
    
    if (!orderId || isNaN(orderId)) {
      return res.status(400).json({
        success: false,
        message: 'ID đơn hàng không hợp lệ'
      });
    }

    console.log(`📧 API: Gửi hóa đơn cho đơn hàng #${orderId}`);
    
    const result = await handleSendInvoice(orderId);
    
    if (result) {
      res.json({
        success: true,
        message: `Đã gửi hóa đơn thành công cho đơn hàng #${orderId}`
      });
    } else {
      res.status(500).json({
        success: false,
        message: `Không thể gửi hóa đơn cho đơn hàng #${orderId}`
      });
    }
  } catch (error) {
    console.error('❌ API Error:', error.message);
    res.status(500).json({
      success: false,
      message: 'Lỗi server: ' + error.message
    });
  }
});

// API endpoint để xử lý tất cả đơn hàng confirmed
router.post('/process-confirmed-orders', async (req, res) => {
  try {
    console.log('📧 API: Xử lý tất cả đơn hàng confirmed');
    
    await processConfirmedOrders();
    
    res.json({
      success: true,
      message: 'Đã xử lý tất cả đơn hàng confirmed'
    });
  } catch (error) {
    console.error('❌ API Error:', error.message);
    res.status(500).json({
      success: false,
      message: 'Lỗi server: ' + error.message
    });
  }
});

// API endpoint để kiểm tra trạng thái đơn hàng và gửi hóa đơn nếu cần
router.post('/check-and-send/:orderId', async (req, res) => {
  try {
    const orderId = parseInt(req.params.orderId);
    
    if (!orderId || isNaN(orderId)) {
      return res.status(400).json({
        success: false,
        message: 'ID đơn hàng không hợp lệ'
      });
    }

    // Kiểm tra trạng thái đơn hàng
    const connection = await mysql.createConnection({
      host: 'localhost',
      user: 'root',
      password: '',
      database: 'e-web'
    });

    const [rows] = await connection.execute(`
      SELECT oid, destatus, paystatus
      FROM orders 
      WHERE oid = ?
    `, [orderId]);

    await connection.end();

    if (rows.length === 0) {
      return res.status(404).json({
        success: false,
        message: 'Không tìm thấy đơn hàng'
      });
    }

    const order = rows[0];
    
    if (order.destatus !== 'Confirmed') {
      return res.json({
        success: false,
        message: `Đơn hàng #${orderId} chưa được xác nhận (trạng thái: ${order.destatus})`
      });
    }

    // Kiểm tra xem đã gửi hóa đơn chưa
    const logConnection = await mysql.createConnection({
      host: 'localhost',
      user: 'root',
      password: '',
      database: 'e-web'
    });

    const [logRows] = await logConnection.execute(`
      SELECT id FROM invoice_sent_log 
      WHERE order_id = ? AND status = 'success'
    `, [orderId]);

    await logConnection.end();

    if (logRows.length > 0) {
      return res.json({
        success: false,
        message: `Đơn hàng #${orderId} đã được gửi hóa đơn trước đó`
      });
    }

    // Gửi hóa đơn
    console.log(`📧 API: Gửi hóa đơn cho đơn hàng #${orderId} (Confirmed)`);
    const result = await handleSendInvoice(orderId);
    
    if (result) {
      res.json({
        success: true,
        message: `Đã gửi hóa đơn thành công cho đơn hàng #${orderId}`
      });
    } else {
      res.status(500).json({
        success: false,
        message: `Không thể gửi hóa đơn cho đơn hàng #${orderId}`
      });
    }
  } catch (error) {
    console.error('❌ API Error:', error.message);
    res.status(500).json({
      success: false,
      message: 'Lỗi server: ' + error.message
    });
  }
});

// API endpoint để lấy danh sách đơn hàng đã gửi hóa đơn
router.get('/sent-invoices', async (req, res) => {
  try {
    const connection = await mysql.createConnection({
      host: 'localhost',
      user: 'root',
      password: '',
      database: 'e-web'
    });

    const [rows] = await connection.execute(`
      SELECT 
        l.id,
        l.order_id,
        l.sent_at,
        l.email,
        l.status,
        l.error_message,
        o.destatus,
        o.paystatus,
        u.uname
      FROM invoice_sent_log l
      JOIN orders o ON l.order_id = o.oid
      JOIN users u ON o.uid = u.uid
      ORDER BY l.sent_at DESC
      LIMIT 50
    `);

    await connection.end();

    res.json({
      success: true,
      data: rows
    });
  } catch (error) {
    console.error('❌ API Error:', error.message);
    res.status(500).json({
      success: false,
      message: 'Lỗi server: ' + error.message
    });
  }
});

module.exports = router; 