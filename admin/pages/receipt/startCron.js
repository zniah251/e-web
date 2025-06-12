const { startCronJob, runNow } = require('./cron');

console.log('Khởi động hệ thống tự động gửi hóa đơn...');

// Chạy ngay lập tức lần đầu
console.log('Chạy ngay lập tức lần đầu...');
runNow().then(() => {
  console.log('Hoàn thành chạy lần đầu');
  
  // Bắt đầu cron job
  startCronJob();
  
  console.log('Hệ thống đã sẵn sàng! Cron job sẽ chạy mỗi 1 phút.');
  console.log('Nhấn Ctrl+C để dừng hệ thống');
  
}).catch((error) => {
  console.error('Lỗi khởi động:', error.message);
  process.exit(1);
});

// Xử lý khi tắt chương trình
process.on('SIGINT', () => {
  console.log('\nĐang dừng hệ thống...');
  process.exit(0);
});

process.on('SIGTERM', () => {
  console.log('\nĐang dừng hệ thống...');
  process.exit(0);
}); 