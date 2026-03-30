-- ============================================================
--  Messaging system for JobPortal
--  Run this in your MySQL / phpMyAdmin
-- ============================================================

CREATE TABLE IF NOT EXISTS application_messages (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id INT UNSIGNED NOT NULL,
    sender_id   INT UNSIGNED NOT NULL,        -- user who sent it
    sender_role ENUM('employer','job_seeker') NOT NULL,
    message     TEXT NOT NULL,
    is_read     TINYINT(1) NOT NULL DEFAULT 0,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_application (application_id),
    INDEX idx_sender (sender_id),
    INDEX idx_unread (application_id, is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;