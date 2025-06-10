// Import các thư viện cần thiết
const express = require('express');
const { GoogleGenerativeAI } = require('@google/generative-ai');
require('dotenv').config(); // Để đọc file .env
const cors = require('cors');
const mysql = require('mysql2/promise'); // Import mysql2 với chế độ promise để dùng async/await

// Khởi tạo ứng dụng Express
const app = express();

// Cấu hình CORS để cho phép frontend truy cập
// Đảm bảo 'http://localhost:8080' khớp với URL frontend của bạn
app.use(cors({ origin: 'http://localhost:8080' }));
app.use(express.json()); // Cho phép server đọc JSON từ request body

// Cấu hình kết nối cơ sở dữ liệu từ biến môi trường
const dbConfig = {
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
};

let connection; // Biến để lưu trữ kết nối cơ sở dữ liệu

// Hàm để kết nối đến cơ sở dữ liệu
async function connectToDatabase() {
    try {
        connection = await mysql.createConnection(dbConfig);
        console.log('Đã kết nối thành công tới cơ sở dữ liệu MySQL!');
    } catch (err) {
        console.error('Lỗi khi kết nối tới cơ sở dữ liệu:', err.message);
    }
}

connectToDatabase();

const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);

async function queryProducts(searchTerm, maxPrice = null, requestedSize = null) {
    if (!connection) {
        console.error('Chưa có kết nối cơ sở dữ liệu. Vui lòng kiểm tra lỗi kết nối DB.');
        return [];
    }
    try {
        let query = 'SELECT pid, title, price, stock, description, size, size2, size3 FROM product WHERE title LIKE ?';
        const params = [`%${searchTerm}%`];

        if (maxPrice !== null && !isNaN(maxPrice)) {
            query += ' AND price <= ?';
            params.push(maxPrice);
        }

        if (requestedSize !== null && requestedSize.trim() !== '') {
            query += ' AND (size = ? OR size2 = ? OR size3 = ?)';
            params.push(requestedSize.toUpperCase(), requestedSize.toUpperCase(), requestedSize.toUpperCase());
        }

        query += ' LIMIT 5';

        console.log('Debug: SQL Query:', query);
        console.log('Debug: SQL Params:', params);

        const [rows] = await connection.execute(query, params);
        return rows;
    } catch (error) {
        console.error('Lỗi khi truy vấn sản phẩm:', error.message);
        return [];
    }
}

app.post('/api/chat', async (req, res) => {
    try {
        const userInput = req.body.message;
        if (!userInput) {
            return res.status(400).json({ error: 'Message is required' });
        }

        const model = genAI.getGenerativeModel({ model: 'gemini-1.5-flash' });

        let dynamicInfo = '';
        let initialPrompt = `
            Bạn là một trợ lý ảo của Kaira Shop, một cửa hàng bán lẻ thời trang nam và nữ.
            Hãy trả lời câu hỏi của khách hàng một cách thân thiện, dễ mến, hài hước và ngắn gọn, có thể thêm icon cho sinh động. 
            Thông tin của shop:
            - Chính sách đổi trả: trong 7 ngày nếu có lỗi từ nhà sản xuất, cần có video unbox.
            - Phí ship: 30.000đ toàn quốc.
            - Thời gian giao hàng: 2-5 ngày.
            - Liên hệ: email contact@kairashop.com hoặc hotline 0901 234 567.
            - Khuyến mãi: Hiện có voucher freeship và giảm 10% cho đơn từ 300k.
            - Địa chỉ: 123 Đường Lê Lợi, TP.HCM.
            - Nếu khách hàng hỏi về giá của một sản phẩm cụ thểm hãy nhờ khách hàng xem trên website nhé, vì đã có chi tiết giá cả trên đó.
        `;

        const productKeywordsRegex = [
            /\bsản phẩm\b/i, /\báo\b/i, /\bquần\b/i, /\bđầm\b/i, /\bváy\b/i,
            /\bmẫu\b/i, /\bmặt hàng\b/i, /\bitem\b/i, /\bgiày\b/i, /\bphụ kiện\b/i
        ];
        const isProductQuery = productKeywordsRegex.some(regex =>
            regex.test(userInput)
        );

        let extractedMaxPrice = null;
        const priceMatch = userInput.match(/(\d{1,3}(?:[\.,]\d{3})*|\d+)\s*(k|ngàn|nghìn|đ)?/i); 
        if (priceMatch && priceMatch[1]) {
            const priceString = priceMatch[1].replace(/[\.,]/g, '');
            extractedMaxPrice = parseInt(priceString, 10);
            if (priceMatch[2] && priceMatch[2].toLowerCase() !== 'đ') {
                extractedMaxPrice *= 1000;
            }
            console.log(` Phát hiện giá tối đa: ${extractedMaxPrice} VNĐ`);
        }
        console.log(`Debug: extractedMaxPrice = ${extractedMaxPrice}`);

        let requestedSize = null;
        let protectedInput = userInput.toLowerCase();

        const sizeMatch = protectedInput.match(/\b(?:size|kích thước)?\s*(s|m|l|xl)\b/i);
        if (sizeMatch) {
            requestedSize = sizeMatch[1];
            console.log(`📏 Phát hiện kích thước: "${requestedSize}"`);
            protectedInput = protectedInput.replace(sizeMatch[0], '__SIZE__');
        }

        console.log(`Debug: requestedSize = "${requestedSize}"`);

        const genericQueryPhrasesRegex = [ 
            /\bcòn hàng không\b/i, /\bcó không\b/i, /\bgiá bao nhiêu\b/i,
            /\b(mình )?tìm (kiếm )?\b/i, /\btôi (muốn )?tìm\b/i, /\bgợi ý (cho mình )?\b/i,
            /\bcó (sản phẩm )?nào\b/i, /\bmua\b/i, /\bgiới thiệu\b/i,
            /\bbáo giá\b/i, /\bcó gì\b/i, /\bcó thể\b/i, /\blà gì\b/i, /\bhỏi về\b/i,
            /\bcủa shop\b/i, /\bcác loại\b/i, /\bmình muốn\b/i, /\bvề\b/i,
            /\bcòn\b/i, /\bkhông\b/i, /\bnhé\b/i, /\bạ\b/i, /\bmình\b/i, /\bcho\b/i, 
            /\blàm ơn\b/i, /\bvui lòng\b/i, /\bxem\b/i, /\bkiểm tra\b/i,
            /\bnữ\b/i, /\bnam\b/i, 
            /\bkích thước\b/i, 
            /\bdưới\b/i, /\btrên\b/i, /\bvừa\b/i, /\bmấy\b/i, /\bbị\b/i, /\blỗi\b/i, 
            /\bnhư\b/i, /\bnày\b/i, /\bvậy\b/i, /\btổng hợp\b/i
        ];

        for (const regex of genericQueryPhrasesRegex) {
            protectedInput = protectedInput.replace(regex, ' ');
        }

        let searchTerm = protectedInput.replace('__SIZE__', '').trim().replace(/\s+/g, ' ');

        if (searchTerm === '' && (isProductQuery || extractedMaxPrice !== null || requestedSize !== null)) {
            searchTerm = 'sản phẩm';
        } else if (searchTerm === '') {
            searchTerm = userInput; 
        }

        console.log(` Từ khóa tìm kiếm cuối cùng (đã làm sạch): "${searchTerm}"`);
        console.log(`Debug: searchTerm trước khi gọi queryProducts = "${searchTerm}"`);

        const products = await queryProducts(searchTerm, extractedMaxPrice, requestedSize);
        console.log('Debug: Kết quả sản phẩm từ database:', products);

        if (products.length > 0) {
            dynamicInfo += '\n\nThông tin chi tiết các sản phẩm tìm thấy trong cơ sở dữ liệu:\n';
            products.forEach((p, index) => {
                dynamicInfo += `Sản phẩm ${index + 1}:\n`;
                dynamicInfo += `  - Tên: ${p.title || 'Đang cập nhật'}\n`;
                if (p.price !== undefined && p.price !== null) {
                    dynamicInfo += `  - Giá: ${new Intl.NumberFormat('vi-VN').format(p.price)} VNĐ\n`;
                } else {
                    dynamicInfo += `  - Giá: Đang cập nhật\n`;
                }
                if (p.stock !== undefined && p.stock !== null) {
                    dynamicInfo += `  - Tồn kho: ${p.stock}\n`;
                } else {
                    dynamicInfo += `  - Tồn kho: Đang cập nhật\n`;
                }
                if (p.description) {
                    dynamicInfo += `  - Mô tả: ${p.description.substring(0, 200)}${p.description.length > 200 ? '...' : ''}\n`;
                }
                let availableSizes = [];
                if (p.size) availableSizes.push(p.size);
                if (p.size2) availableSizes.push(p.size2);
                if (p.size3) availableSizes.push(p.size3);
                if (availableSizes.length > 0) {
                    dynamicInfo += `  - Kích thước có sẵn: ${availableSizes.join(', ')}\n`;
                }
                dynamicInfo += '\n';
            });
            dynamicInfo += '\nDựa vào danh sách sản phẩm trên, hãy liệt kê cụ thể các sản phẩm tìm thấy...';
        } else {
            dynamicInfo += '\n\nKhông tìm thấy sản phẩm nào...';
        }

        const finalPrompt = `${initialPrompt}${dynamicInfo}\n\nDựa vào những thông tin trên, hãy trả lời câu hỏi sau của khách hàng: "${userInput}"`;

        const result = await model.generateContent(finalPrompt);
        const response = await result.response;
        const text = response.text();

        res.json({ reply: text });

    } catch (error) {
        console.error('Lỗi trong xử lý chat:', error.message);
        res.status(500).json({ error: 'Có lỗi xảy ra, vui lòng thử lại.' });
    }
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
