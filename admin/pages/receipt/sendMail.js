const nodemailer = require('nodemailer');
const fs = require('fs');

async function sendMailWithInvoice(email, orderId, filePath) {
  // Tạo transporter (cấu hình email)
  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: 'dieeuannh@gmail.com', // Thay bằng email của bạn
      pass: 'supdamwzyrgdxwjc'     // Thay bằng app password của bạn
    }
  });

  // Đọc file PDF
  const attachment = fs.readFileSync(filePath);

  // Cấu hình email
  const mailOptions = {
    from: 'dieeuannh@gmail.com',
    to: email,
    subject: `Hóa đơn đơn hàng #${orderId} - Kaira`,
    html: `
      <h2>Hóa đơn đơn hàng #${orderId}</h2>
      <p>Xin chào,</p>
      <p>Cảm ơn bạn đã mua hàng tại Kaira. Dưới đây là hóa đơn chi tiết cho đơn hàng của bạn.</p>
      <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
      <br>
      <p>Trân trọng,</p>
      <p>Đội ngũ Kaira</p>
    `,
    attachments: [
      {
        filename: `invoice_${orderId}.pdf`,
        content: attachment
      }
    ]
  };

  try {
    const info = await transporter.sendMail(mailOptions);
    console.log('✅ Email đã được gửi thành công:', info.messageId);
    
    // Xóa file PDF sau khi gửi
    fs.unlinkSync(filePath);
    console.log('✅ File PDF đã được xóa');
    
    return true;
  } catch (error) {
    console.error('❌ Lỗi gửi email:', error.message);
    return false;
  }
}

module.exports = { sendMailWithInvoice }; 