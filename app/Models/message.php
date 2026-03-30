<?php
require_once BASE_PATH . '/core/Model.php';

class Message extends Model
{
    /** All messages for one application, oldest first */
    public function getByApplication(int $appId): array
    {
        $stmt = $this->conn->prepare("
            SELECT m.*, u.full_name AS sender_name, u.avatar AS sender_avatar
            FROM application_messages m
            JOIN users u ON m.sender_id = u.id
            WHERE m.application_id = ?
            ORDER BY m.created_at ASC
        ");
        $stmt->bind_param('i', $appId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Send a message */
    public function send(int $appId, int $senderId, string $role, string $message): bool
    {
        $message = trim($message);
        if ($message === '') return false;

        $stmt = $this->conn->prepare("
            INSERT INTO application_messages
                (application_id, sender_id, sender_role, message)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param('iiss', $appId, $senderId, $role, $message);
        return $stmt->execute();
    }

    /** Mark all messages in an application as read for a given recipient role */
    public function markRead(int $appId, string $recipientRole): void
    {
        // Mark messages sent by the OTHER role as read
        $senderRole = $recipientRole === 'employer' ? 'job_seeker' : 'employer';
        $stmt = $this->conn->prepare("
            UPDATE application_messages
            SET is_read = 1
            WHERE application_id = ? AND sender_role = ? AND is_read = 0
        ");
        $stmt->bind_param('is', $appId, $senderRole);
        $stmt->execute();
    }

    /** Count unread messages for a user across all their applications */
    public function countUnread(int $userId, string $role): int
    {
        // Unread = messages sent by the OTHER side that this user hasn't read
        $senderRole = $role === 'employer' ? 'job_seeker' : 'employer';

        if ($role === 'employer') {
            // Messages from seekers on jobs owned by this employer
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS c
                FROM application_messages m
                JOIN applications a ON m.application_id = a.id
                JOIN jobs j ON a.job_id = j.id
                WHERE j.employer_id = ? AND m.sender_role = ? AND m.is_read = 0
            ");
        } else {
            // Messages from employers on applications by this seeker
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS c
                FROM application_messages m
                JOIN applications a ON m.application_id = a.id
                WHERE a.applicant_id = ? AND m.sender_role = ? AND m.is_read = 0
            ");
        }
        $stmt->bind_param('is', $userId, $senderRole);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['c'];
    }

    /** Count unread messages for one specific application (from the other side) */
    public function countUnreadForApp(int $appId, string $readerRole): int
    {
        $senderRole = $readerRole === 'employer' ? 'job_seeker' : 'employer';
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) AS c FROM application_messages
            WHERE application_id = ? AND sender_role = ? AND is_read = 0
        ");
        $stmt->bind_param('is', $appId, $senderRole);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['c'];
    }
}