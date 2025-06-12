const PDFDocument = require('pdfkit');
const fs = require('fs');
const path = require('path');

function generateInvoice(orderData, orderId) {
  try {
    const doc = new PDFDocument({ margin: 40 });
    doc.font('Helvetica');

    const filePath = path.join(__dirname, `invoice_${orderId}.pdf`);
    const writeStream = fs.createWriteStream(filePath);
    doc.pipe(writeStream);

    const customer = orderData[0];
    const invoiceDate = new Date(customer.create_at).toLocaleDateString('en-GB');

    // ===== HEADER =====
    doc.fontSize(16).text('SALES INVOICE', { align: 'center', underline: true });
    doc.moveDown(0.5);

    doc.fontSize(10);
    doc.text(`Order ID: ${orderId}`);
    doc.text(`Invoice Date: ${invoiceDate}`);
    doc.moveDown();

    // ===== CUSTOMER INFO =====
    doc.font('Helvetica-Bold').text('Customer Information');
    doc.font('Helvetica');
    doc.text(`Name: ${customer.customer_name}`);
    doc.text(`Email: ${customer.customer_email}`);
    doc.text(`Phone: ${customer.customer_phone || 'N/A'}`);
    doc.text(`Address: ${customer.customer_address || 'N/A'}`);
    doc.moveDown();

    // ===== TABLE STRUCTURE =====
    const colWidths = [30, 140, 60, 60, 40, 80, 80]; // Total ~490 pts
    const startX = 50;
    let startY = doc.y;
    const rowHeight = 25;

    // ===== TABLE HEADER =====
    const headers = ['No.', 'Product Name', 'Size', 'Color', 'Qty', 'Unit Price', 'Amount'];
    doc.font('Helvetica-Bold');
    headers.forEach((text, i) => {
      const x = startX + colWidths.slice(0, i).reduce((a, b) => a + b, 0);
      doc.rect(x, startY, colWidths[i], rowHeight).stroke();
      doc.text(text, x + 3, startY + 7, { width: colWidths[i] - 6, align: 'center' });
    });

    // ===== TABLE BODY =====
    doc.font('Helvetica');
    startY += rowHeight;
    let index = 1;

    orderData.forEach(item => {
      const amount = item.quantity * item.unit_price;
      const values = [
        index++,
        item.product_name,
        item.size || '',
        item.color || '',
        item.quantity.toString(),
        item.unit_price.toLocaleString('en-US'),
        amount.toLocaleString('en-US')
      ];

      values.forEach((text, i) => {
        const x = startX + colWidths.slice(0, i).reduce((a, b) => a + b, 0);
        doc.rect(x, startY, colWidths[i], rowHeight).stroke();
        doc.text(text, x + 3, startY + 7, { width: colWidths[i] - 6, align: 'center' });
      });

      startY += rowHeight;
    });

    // ===== TOTAL =====
    doc.font('Helvetica-Bold');
    doc.text('Total Amount:', startX + 370, startY + 10, { width: 80, align: 'right' });
    doc.text(customer.total_price.toLocaleString('en-US'), startX + 460, startY + 10, {
      width: 70,
      align: 'right'
    });

    // ===== FOOTER =====
    doc.moveDown(4);
    doc.font('Helvetica').text('Thank you!', { align: 'center' });

    doc.end();

    return new Promise((resolve, reject) => {
      writeStream.on('finish', () => {
        console.log(`✅ PDF generated: ${filePath}`);
        resolve(filePath);
      });
      writeStream.on('error', (err) => {
        console.error(`PDF generation error: ${err.message}`);
        reject(err);
      });
    });
  } catch (err) {
    console.error(`Unexpected error: ${err.message}`);
    throw err;
  }
}

module.exports = { generateInvoice };
