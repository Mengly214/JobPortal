<?php
/**
 * Lightweight JSON API for the messaging thread.
 * Handles both employer and seeker — role is verified per request.
 *
 * Routes to add in index.php:
 *   $router->get('/api/messages/:id',  'MessagesApiController', 'poll');
 *   $router->post('/api/messages/:id', 'MessagesApiController', 'send');
 */

require_once BASE_PATH . '/app/Models/Message.php';

class MessagesApiController extends Controller
{
    private function json(mixed $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function authAndGetApp(int $appId): array
    {
        if (!isLoggedIn()) {
            $this->json(['error' => 'Unauthenticated'], 401);
        }

        $conn   = $GLOBALS['conn'];
        $userId = (int)$_SESSION['user_id'];
        $role   = $_SESSION['role'] ?? '';

        if ($role === 'employer') {
            $app = $conn->query("
                SELECT a.id, a.applicant_id, j.employer_id,
                       u.full_name AS applicant_name, u.avatar AS applicant_avatar,
                       ep.company_name, ep.logo AS company_logo
                FROM applications a
                JOIN jobs j ON a.job_id = j.id
                JOIN users u ON a.applicant_id = u.id
                LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
                WHERE a.id = $appId AND j.employer_id = $userId
                LIMIT 1
            ")->fetch_assoc();
        } else {
            $app = $conn->query("
                SELECT a.id, a.applicant_id, j.employer_id,
                       ep.company_name, ep.logo AS company_logo,
                       eu.full_name AS employer_name
                FROM applications a
                JOIN jobs j ON a.job_id = j.id
                LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
                LEFT JOIN users eu ON j.employer_id = eu.id
                WHERE a.id = $appId AND a.applicant_id = $userId
                LIMIT 1
            ")->fetch_assoc();
        }

        if (!$app) {
            $this->json(['error' => 'Forbidden'], 403);
        }

        return [$app, $userId, $role];
    }

    /**
     * GET /api/messages/:id?after=LAST_MSG_ID
     * Returns only messages newer than `after`, formatted as HTML bubbles.
     */
    public function poll(int $appId): void
    {
        [$app, $userId, $role] = $this->authAndGetApp($appId);

        $afterId  = (int)($_GET['after'] ?? 0);
        $conn     = $GLOBALS['conn'];
        $msgModel = new Message();

        // Mark incoming messages as read
        $msgModel->markRead($appId, $role === 'employer' ? 'employer' : 'job_seeker');

        // Fetch only new messages
        $rows = $conn->query("
            SELECT m.id, m.sender_id, m.sender_role, m.message, m.is_read, m.created_at,
                   u.full_name AS sender_name, u.avatar AS sender_avatar
            FROM application_messages m
            JOIN users u ON m.sender_id = u.id
            WHERE m.application_id = $appId AND m.id > $afterId
            ORDER BY m.created_at ASC
        ")->fetch_all(MYSQLI_ASSOC);

        // Build the avatar/initial for the other side
        $otherAvatar = '';
        $otherInit   = 'E';
        if ($role === 'employer') {
            $otherInit = strtoupper(substr($app['applicant_name'] ?? 'A', 0, 1));
            $otherAvatar = $app['applicant_avatar'] ?? '';
        } else {
            $otherInit = strtoupper(substr($app['company_name'] ?? 'E', 0, 1));
            $otherAvatar = $app['company_logo'] ?? '';
            $avatarIsLogo = true;
        }

        $html    = '';
        $lastId  = $afterId;
        $siteUrl = SITE_URL;

        foreach ($rows as $m) {
            $isMe    = ((int)$m['sender_id'] === $userId);
            $cls     = $isMe ? 'msg-bubble--me' : 'msg-bubble--them';
            $text    = nl2br(htmlspecialchars($m['message']));
            $time    = date('d M Y, g:i a', strtotime($m['created_at']));
            $name    = $isMe ? 'You' : htmlspecialchars($m['sender_name']);
            $read    = ($isMe && $m['is_read']) ? '<i class="fa fa-check-circle" style="color:#14a077;margin-left:4px" title="Read"></i>' : '';
            $lastId  = max($lastId, (int)$m['id']);

            $avHtml = '';
            if (!$isMe) {
                if ($otherAvatar) {
                    $folder  = isset($avatarIsLogo) ? 'logos' : 'avatars';
                    $radius  = isset($avatarIsLogo) ? 'border-radius:6px' : '';
                    $avHtml  = "<div class=\"msg-bubble__av\"><img src=\"{$siteUrl}/uploads/{$folder}/{$otherAvatar}\" style=\"{$radius}\" alt=\"\"></div>";
                } else {
                    $avHtml = "<div class=\"msg-bubble__av\"><div class=\"msg-bubble__av-init\">{$otherInit}</div></div>";
                }
            }

            $html .= "
<div class=\"msg-bubble {$cls}\" data-id=\"{$m['id']}\">
    {$avHtml}
    <div class=\"msg-bubble__body\">
        <div class=\"msg-bubble__text\">{$text}</div>
        <div class=\"msg-bubble__meta\">{$name} &nbsp;·&nbsp; {$time}{$read}</div>
    </div>
</div>";
        }

        $this->json(['html' => $html, 'lastId' => $lastId, 'count' => count($rows)]);
    }

    /**
     * POST /api/messages/:id
     * Send a message, returns the rendered bubble immediately.
     */
    public function send(int $appId): void
    {
        [$app, $userId, $role] = $this->authAndGetApp($appId);

        $message = trim($_POST['message'] ?? '');
        if ($message === '') {
            $this->json(['error' => 'Empty message'], 400);
        }

        $senderRole = $role === 'employer' ? 'employer' : 'job_seeker';
        $msgModel   = new Message();
        $msgModel->send($appId, $userId, $senderRole, $message);

        // Return the new message rendered as a bubble
        $conn = $GLOBALS['conn'];
        $row  = $conn->query("
            SELECT m.id, m.sender_id, m.sender_role, m.message, m.is_read, m.created_at,
                   u.full_name AS sender_name
            FROM application_messages m
            JOIN users u ON m.sender_id = u.id
            WHERE m.application_id = $appId AND m.sender_id = $userId
            ORDER BY m.id DESC LIMIT 1
        ")->fetch_assoc();

        $text   = nl2br(htmlspecialchars($row['message']));
        $time   = date('d M Y, g:i a', strtotime($row['created_at']));

        $html = "
<div class=\"msg-bubble msg-bubble--me\" data-id=\"{$row['id']}\">
    <div class=\"msg-bubble__body\">
        <div class=\"msg-bubble__text\">{$text}</div>
        <div class=\"msg-bubble__meta\">You &nbsp;·&nbsp; {$time}</div>
    </div>
</div>";

        $this->json(['html' => $html, 'lastId' => (int)$row['id']]);
    }
}