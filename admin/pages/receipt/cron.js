const { processConfirmedOrders } = require('./autoSendInvoice');

const INTERVAL = 10 * 1000; // 20 giây

console.log(' Khởi động cron job để tự động gửi hóa đơn...');
console.log(` Lịch chạy: mỗi 20 giây`);

let intervalId = null;

function startCronJob() {
  if (intervalId) return;
  intervalId = setInterval(async () => {
    const now = new Date().toLocaleString('vi-VN');
    console.log(`\n[${now}] Cron job bắt đầu chạy...`);
    try {
      await processConfirmedOrders();
      console.log(`[${now}] Cron job hoàn thành`);
    } catch (error) {
      console.error(`[${now}] Cron job lỗi:`, error.message);
    }
  }, INTERVAL);
  console.log('Cron job đã được bắt đầu');
}

function stopCronJob() {
  if (intervalId) {
    clearInterval(intervalId);
    intervalId = null;
    console.log('Cron job đã được dừng');
  }
}

async function runNow() {
  console.log('Chạy ngay lập tức...');
  await processConfirmedOrders();
}

module.exports = {
  startCronJob,
  stopCronJob,
  runNow
};

if (require.main === module) {
  runNow().then(() => {
    console.log('✅ Hoàn thành chạy ngay lập tức');
    process.exit(0);
  }).catch((error) => {
    console.error('Lỗi:', error.message);
    process.exit(1);
  });
}