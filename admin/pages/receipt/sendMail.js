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
    from: '"KAIRA Shop" <your_email@gmail.com>',
    to: email, // ĐÚNG: dùng biến email truyền vào
    subject: `Your Invoice for Order #${orderId} from KAIRA Shop`,
    text: `
Dear Valued Customer,

Thank you for shopping with KAIRA Shop!

We are pleased to inform you that your order (#${orderId}) has been successfully confirmed. Attached to this email is the official invoice for your purchase. Please review the invoice for order details including items, quantity, pricing, and delivery information.

If you have any questions regarding your order, payment, or shipment, feel free to reply directly to this email. Our customer support team is always happy to assist you.

We truly appreciate your trust in KAIRA Shop and hope to serve you again soon.

Warm regards,  
KAIRA Shop Team  
www.kairashop.vn
    `.trim(),
    attachments: [
      {
        filename: `invoice_${orderId}.pdf`,
        path: filePath
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