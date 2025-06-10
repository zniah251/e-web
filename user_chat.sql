
-- Tạo bảng user_chat để lưu trữ tin nhắn chat với admin
CREATE TABLE IF NOT EXISTS `user_chat` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_user_message` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: tin nhắn từ user, 0: tin nhắn từ admin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `chat_id` (`chat_id`),
  KEY `uid` (`uid`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `fk_user_chat_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm comment cho bảng
ALTER TABLE `user_chat` COMMENT = 'Bảng lưu trữ tin nhắn chat giữa user và admin';

-- Thêm index để tối ưu hiệu suất truy vấn
CREATE INDEX `idx_user_chat_chat_id_uid` ON `user_chat` (`chat_id`, `uid`);
CREATE INDEX `idx_user_chat_created_at` ON `user_chat` (`created_at` DESC); 