const mysql = require('mysql2/promise');

async function getOrderData(orderId) {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'e-web'
  });

  try {
    // Query để lấy thông tin đơn hàng và khách hàng
    const [rows] = await connection.execute(`
      SELECT 
        o.oid AS order_id,
        o.create_at,
        o.totalfinal AS total_price,
        o.destatus,
        o.paystatus,
        o.paymethod,
        u.uid AS customer_id,
        u.uname AS customer_name,
        u.email AS customer_email,
        u.phonenumber AS customer_phone,
        u.address AS customer_address,
        p.pid AS product_id,
        p.title AS product_name,
        p.thumbnail AS product_image,
        od.quantity,
        od.price AS unit_price,
        od.size,
        od.color
      FROM orders o
      JOIN users u ON o.uid = u.uid
      JOIN order_detail od ON od.oid = o.oid
      JOIN product p ON od.pid = p.pid
      WHERE o.oid = ?
      ORDER BY od.did ASC
    `, [orderId]);

    // Kiểm tra xem có dữ liệu không
    if (rows.length === 0) {
      console.log(`Không tìm thấy đơn hàng với ID: ${orderId}`);
      return null;
    }

    console.log(`✅ Tìm thấy đơn hàng #${orderId} của khách hàng: ${rows[0].customer_name} (${rows[0].customer_email})`);
    
    return rows;
  } catch (error) {
    console.error('Lỗi khi truy vấn database:', error.message);
    throw error;
  } finally {
    await connection.end();
  }
}

// Thêm function để lấy thông tin khách hàng riêng biệt
async function getCustomerInfo(orderId) {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'e-web'
  });

  try {
    const [rows] = await connection.execute(`
      SELECT 
        u.uid,
        u.uname,
        u.email,
        u.phonenumber,
        u.address
      FROM orders o
      JOIN users u ON o.uid = u.uid
      WHERE o.oid = ?
    `, [orderId]);

    return rows[0] || null;
  } catch (error) {
    console.error('Lỗi khi lấy thông tin khách hàng:', error.message);
    throw error;
  } finally {
    await connection.end();
  }
}

module.exports = { getOrderData, getCustomerInfo };
