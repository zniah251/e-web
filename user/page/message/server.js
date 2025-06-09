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
        console.log('✅ Đã kết nối thành công tới cơ sở dữ liệu MySQL!');
    } catch (err) {
        console.error('❌ Lỗi khi kết nối tới cơ sở dữ liệu:', err.message);
        // Tùy chọn: Nếu kết nối DB là bắt buộc, bạn có thể cân nhắc thoát ứng dụng hoặc thực hiện lại
        // process.exit(1); // Thoát ứng dụng nếu không kết nối được DB
    }
}

// Gọi hàm kết nối khi ứng dụng khởi động
// Đảm bảo kết nối được thiết lập trước khi các route bắt đầu nhận request
connectToDatabase();

// Lấy API key từ file .env
const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);

/**
 * Hàm truy vấn sản phẩm từ cơ sở dữ liệu.
 * @param {string} searchTerm - Từ khóa tìm kiếm sản phẩm (dùng cho title).
 * @param {number|null} maxPrice - Giá tối đa của sản phẩm (nếu có).
 * @param {string|null} requestedSize - Kích thước sản phẩm được yêu cầu (nếu có).
 * @returns {Array} - Mảng các đối tượng sản phẩm tìm được.
 */
async function queryProducts(searchTerm, maxPrice = null, requestedSize = null) {
    if (!connection) {
        console.error('Chưa có kết nối cơ sở dữ liệu. Vui lòng kiểm tra lỗi kết nối DB.');
        return [];
    }
    try {
        // SỬ DỤNG 'pid' và 'title' theo cấu trúc bảng của bạn. LOẠI BỎ 'url' nếu không có.
        let query = 'SELECT pid, title, price, stock, description, size, size2, size3 FROM product WHERE title LIKE ?';
        const params = [`%${searchTerm}%`];

        if (maxPrice !== null && !isNaN(maxPrice)) {
            query += ' AND price <= ?'; // Thêm điều kiện lọc giá
            params.push(maxPrice);
        }

        // THÊM ĐIỀU KIỆN LỌC THEO KÍCH THƯỚC
        if (requestedSize !== null && requestedSize.trim() !== '') {
            query += ' AND (size = ? OR size2 = ? OR size3 = ?)';
            params.push(requestedSize.toUpperCase(), requestedSize.toUpperCase(), requestedSize.toUpperCase()); // Chuyển sang chữ hoa để khớp (nếu DB cũng lưu chữ hoa)
        }

        query += ' LIMIT 5'; // Giới hạn 5 kết quả

        console.log('Debug: SQL Query:', query); // Log câu truy vấn SQL
        console.log('Debug: SQL Params:', params); // Log các tham số

        const [rows] = await connection.execute(query, params);
        return rows;
    } catch (error) {
        console.error('❌ Lỗi khi truy vấn sản phẩm:', error.message);
        return [];
    }
}

// Tạo một "route" để xử lý yêu cầu chat
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
            Hãy trả lời câu hỏi của khách hàng một cách thân thiện, dễ mến, chuyên nghiệp và ngắn gọn, có thể thêm icon cho sinh động.
            Thông tin của shop:
            - Chính sách đổi trả: trong 7 ngày nếu có lỗi từ nhà sản xuất, cần có video unbox.
            - Phí ship: 30.000đ toàn quốc.
            - Thời gian giao hàng: 2-5 ngày.
            - Liên hệ: email contact@kairashop.com hoặc hotline 0901 234 567.
            - Khuyến mãi: Hiện có voucher freeship và giảm 10% cho đơn từ 300k.
            - Địa chỉ: 123 Đường Lê Lợi, TP.HCM.
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
            console.log(`💰 Phát hiện giá tối đa: ${extractedMaxPrice} VNĐ`);
        }
        console.log(`Debug: extractedMaxPrice = ${extractedMaxPrice}`);

        let requestedSize = null;
        const sizeMatch = userInput.match(/\bsize\s*([a-zA-Z0-9]+)\b|\b([smlxl]{1,3})\b/i);
        if (sizeMatch) {
            requestedSize = sizeMatch[1] || sizeMatch[2]; 
            console.log(`📏 Phát hiện kích thước: "${requestedSize}"`);
        }
        console.log(`Debug: requestedSize = "${requestedSize}"`);

        // DANH SÁCH CÁC CỤM TỪ HỎI THÔNG THƯỜNG CẦN LOẠI BỎ KHỎI SEARCHTERM
        const commonQuestionPhrasesRegex = [
            /\bcòn hàng không\b/i, /\bcó không\b/i, /\bgiá bao nhiêu\b/i,
            /\b(mình )?tìm (kiếm )?\b/i, /\btôi (muốn )?tìm\b/i, /\bgợi ý (cho mình )?\b/i,
            /\bcó (sản phẩm )?nào\b/i, /\b(còn )?size\b/i, /\b(size )?[smlxl]{1,3}\b/i, // Loại bỏ kích thước đã trích xuất
            /\d{1,3}(?:[\.,]\d{3})*\s*(k|ngàn|nghìn|đ)?/i, // Loại bỏ giá đã trích xuất
            /\bmua\b/i, /\bgiới thiệu\b/i
        ];


        // Kích hoạt truy vấn sản phẩm nếu có từ khóa sản phẩm, giá hoặc kích thước
        if (isProductQuery || extractedMaxPrice !== null || requestedSize !== null) {
            let tempUserInput = userInput.toLowerCase(); 

            // Bước 1: Loại bỏ giá và kích thước đã trích xuất
            tempUserInput = tempUserInput.replace(/(\d{1,3}(?:[\.,]\d{3})*|\d+)\s*(k|ngàn|nghìn|đ)?/i, '').trim();
            tempUserInput = tempUserInput.replace(/\bsize\s*([a-zA-Z0-9]+)\b|\b([smlxl]{1,3})\b/i, '').trim();

            // Bước 2: Loại bỏ các từ khóa sản phẩm chung
            for (const regex of productKeywordsRegex) {
                tempUserInput = tempUserInput.replace(regex, '').trim();
            }

            // Bước 3: Loại bỏ các cụm từ hỏi thông thường
            for (const regex of commonQuestionPhrasesRegex) {
                tempUserInput = tempUserInput.replace(regex, '').trim();
            }

            let searchTerm = tempUserInput;
            searchTerm = searchTerm.replace(/\s+/g, ' ').trim(); // Chuẩn hóa khoảng trắng


            // Bước 4: Đặt searchTerm dự phòng nếu quá trống rỗng
            if (searchTerm === '' || ['gì', 'nào', 'có', 'dưới', 'bao nhiêu'].includes(searchTerm)) {
                if (!isProductQuery && extractedMaxPrice === null && requestedSize === null) {
                    searchTerm = userInput; // Dùng input gốc nếu không có từ khóa SP, giá, hay size để Gemini tự xử lý
                } else {
                    searchTerm = 'sản phẩm'; // Nếu có bất kỳ điều kiện nào (SP, giá, size), dùng 'sản phẩm' làm từ khóa dự phòng
                }
            }
            console.log(`🔍 Từ khóa tìm kiếm cuối cùng: "${searchTerm}"`);
            console.log(`Debug: searchTerm trước khi gọi queryProducts = "${searchTerm}"`);

            // TRUYỀN CẢ GIÁ VÀ KÍCH THƯỚC VÀO HÀM TRUY VẤN
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
                    console.log(`Debug: Stock của ${p.title}: ${p.stock}`);

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
                dynamicInfo += '\nDựa vào danh sách sản phẩm trên, hãy liệt kê cụ thể các sản phẩm tìm thấy (nếu có), bao gồm tên, giá, và nếu có thể, một mô tả ngắn. Đặc biệt, hãy nhấn mạnh tình trạng tồn kho và các kích thước có sẵn. Nếu có nhiều hơn 3 sản phẩm, bạn có thể chọn lọc những sản phẩm phù hợp nhất. Hạn chế gợi ý khách hàng truy cập website nếu đã có đủ thông tin liệt kê. Sử dụng các emoji phù hợp. Ví dụ: "Chào bạn! 😍 Kaira Shop có các mẫu đầm nữ size S sau:\n- Đầm Maxi Họa Tiết (149.000đ): Còn 10 sản phẩm. Kiểu dáng nhẹ nhàng.\n- Đầm Suông Basic (120.000đ): Còn 20 sản phẩm. Đơn giản, dễ phối đồ.\n"\n';
            } else {
                dynamicInfo += '\n\nKhông tìm thấy sản phẩm nào trong cơ sở dữ liệu theo yêu cầu của khách hàng, đặc biệt là với các tiêu chí tìm kiếm (tên, giá, kích thước). Hãy thông báo nhẹ nhàng và gợi ý khách hàng thử tìm kiếm với từ khóa hoặc mức giá/kích thước khác, hoặc liên hệ trực tiếp để được tư vấn chi tiết hơn. Đừng quên nhắc về các khuyến mãi hiện có! 😉';
            }
        }

        const finalPrompt = `${initialPrompt}${dynamicInfo}\n\nDựa vào những thông tin trên, hãy trả lời câu hỏi sau của khách hàng: "${userInput}"`;

        const result = await model.generateContent(finalPrompt);
        const response = await result.response;
        const text = response.text();

        res.json({ reply: text });

    } catch (error) {
        console.error('❌ Lỗi trong xử lý chat:', error.message);
        res.status(500).json({ error: 'Có lỗi xảy ra, vui lòng thử lại.' });
    }
});

// Khởi động server
const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
