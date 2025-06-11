const nodemailer = require('nodemailer');

async function sendMailWithInvoice(to, orderId, filePath) {
  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: 'your_email@gmail.com',
      pass: 'your_app_password' // dùng App Password nếu có bật 2FA
    }
  });

  const info = await transporter.sendMail({
  from: '"KAIRA Shop" <your_email@gmail.com>',
  to: to,
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
});

  console.log(`📧 Email đã gửi đến ${to} | Mã gửi: ${info.messageId}`);
}

module.exports = { sendMailWithInvoice };



