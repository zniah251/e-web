const mysql = require('mysql2/promise');

async function checkOrders() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'e-web'
  });

  try {
    console.log('🔍 Kiểm tra trạng thái đơn hàng trong database...\n');

    // Kiểm tra tổng số đơn hàng
    const [totalOrders] = await connection.execute(`
      SELECT COUNT(*) as total FROM orders
    `);
    console.log(`📊 Tổng số đơn hàng: ${totalOrders[0].total}`);

    // Kiểm tra đơn hàng theo trạng thái
    const [statusCount] = await connection.execute(`
      SELECT 
        destatus,
        COUNT(*) as count
      FROM orders 
      GROUP BY destatus
      ORDER BY count DESC
    `);

    console.log('\n📈 Phân bố theo trạng thái:');
    statusCount.forEach(row => {
      console.log(`   ${row.destatus}: ${row.count} đơn hàng`);
    });

    // Kiểm tra đơn hàng confirmed
    const [confirmedOrders] = await connection.execute(`
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
      ORDER BY o.create_at DESC
      LIMIT 10
    `);

    console.log(`\n✅ Đơn hàng có trạng thái "Confirmed" (${confirmedOrders.length} đơn):`);
    if (confirmedOrders.length > 0) {
      confirmedOrders.forEach(order => {
        console.log(`   #${order.oid} - ${order.uname} (${order.email}) - ${order.create_at}`);
      });
    } else {
      console.log('   Không có đơn hàng nào có trạng thái "Confirmed"');
    }

    // Kiểm tra bảng log
    const [logCount] = await connection.execute(`
      SELECT COUNT(*) as total FROM invoice_sent_log
    `);
    console.log(`\n📝 Số bản ghi trong invoice_sent_log: ${logCount[0].total}`);

    if (logCount[0].total > 0) {
      const [recentLogs] = await connection.execute(`
        SELECT 
          order_id,
          sent_at,
          status,
          email
        FROM invoice_sent_log
        ORDER BY sent_at DESC
        LIMIT 5
      `);

      console.log('\n📧 5 bản ghi gửi hóa đơn gần nhất:');
      recentLogs.forEach(log => {
        console.log(`   Đơn #${log.order_id} - ${log.email} - ${log.status} - ${log.sent_at}`);
      });
    }

    // Kiểm tra đơn hàng confirmed chưa gửi hóa đơn
    const [pendingInvoices] = await connection.execute(`
      SELECT 
        o.oid,
        u.uname,
        u.email
      FROM orders o
      JOIN users u ON o.uid = u.uid
      WHERE o.destatus = 'Confirmed'
      AND o.oid NOT IN (
        SELECT order_id FROM invoice_sent_log WHERE sent_at IS NOT NULL
      )
    `);

    console.log(`\n📬 Đơn hàng confirmed chưa gửi hóa đơn: ${pendingInvoices.length}`);
    if (pendingInvoices.length > 0) {
      pendingInvoices.forEach(order => {
        console.log(`   #${order.oid} - ${order.uname} (${order.email})`);
      });
    }

  } catch (error) {
    console.error('❌ Lỗi khi kiểm tra:', error.message);
  } finally {
    await connection.end();
  }
}

// Chạy kiểm tra
checkOrders(); 