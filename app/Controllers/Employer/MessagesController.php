<?php
require_once BASE_PATH . '/app/Models/Application.php';
require_once BASE_PATH . '/app/Models/Message.php';

class Employer_MessagesController extends Controller
{
    private int $employerId;

    public function __construct()
    {
        requireRole('employer');
        $this->employerId = (int)$_SESSION['user_id'];
    }

    /**
     * Conversation thread for one application
     * GET /employer/messages/:appId
     */
    public function thread(int $appId): void
    {
        $conn    = $GLOBALS['conn'];
        $appId   = (int)$appId;

        // Security: application must belong to one of our jobs
        $app = $conn->query("
            SELECT a.*, j.title AS job_title, j.id AS job_id,
                   u.full_name AS applicant_name, u.email AS applicant_email,
                   u.avatar AS applicant_avatar,
                   ep.company_name, ep.logo AS company_logo
            FROM applications a
            JOIN jobs j       ON a.job_id = j.id
            JOIN users u      ON a.applicant_id = u.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE a.id = $appId AND j.employer_id = {$this->employerId}
            LIMIT 1
        ")->fetch_assoc();

        if (!$app) {
            header('Location: ' . SITE_URL . '/employer/applications');
            exit;
        }

        $msgModel = new Message();
        $msgModel->markRead($appId, 'employer');   // mark seeker's messages as read
        $messages = $msgModel->getByApplication($appId);

        $this->view('employer/messages/thread', [
            'pageTitle'  => 'Message — ' . $app['applicant_name'],
            'activePage' => '',
            'app'        => $app,
            'messages'   => $messages,
        ]);
    }

    /**
     * Send message  POST /employer/messages/send
     */
    public function send(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . SITE_URL . '/employer/applications');
            exit;
        }

        $appId   = (int)($_POST['app_id'] ?? 0);
        $message = trim($_POST['message'] ?? '');
        $conn    = $GLOBALS['conn'];

        // Verify ownership
        $check = $conn->query("
            SELECT a.id FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE a.id = $appId AND j.employer_id = {$this->employerId}
            LIMIT 1
        ")->fetch_assoc();

        if ($check && $message !== '') {
            $msgModel = new Message();
            $msgModel->send($appId, $this->employerId, 'employer', $message);
        }

        header('Location: ' . SITE_URL . '/employer/messages/' . $appId);
        exit;
    }
}