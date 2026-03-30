<?php
require_once BASE_PATH . '/app/Models/Application.php';
require_once BASE_PATH . '/app/Models/Message.php';

class Seeker_MessagesController extends Controller
{
    private int $seekerId;

    public function __construct()
    {
        requireRole('job_seeker');
        $this->seekerId = (int)$_SESSION['user_id'];
    }

    /**
     * Conversation thread for one application
     * GET /seeker/messages/:appId
     */
    public function thread(int $appId): void
    {
        $conn  = $GLOBALS['conn'];
        $appId = (int)$appId;

        // Security: application must belong to this seeker
        $app = $conn->query("
            SELECT a.*, j.title AS job_title, j.id AS job_id,
                   ep.company_name, ep.logo AS company_logo,
                   eu.full_name AS employer_name
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            LEFT JOIN users eu ON j.employer_id = eu.id
            WHERE a.id = $appId AND a.applicant_id = {$this->seekerId}
            LIMIT 1
        ")->fetch_assoc();

        if (!$app) {
            header('Location: ' . SITE_URL . '/seeker/applications');
            exit;
        }

        $msgModel = new Message();
        $msgModel->markRead($appId, 'job_seeker');  // mark employer's messages as read
        $messages = $msgModel->getByApplication($appId);

        $this->view('seeker/messages/thread', [
            'pageTitle'  => 'Message — ' . ($app['company_name'] ?? 'Employer'),
            'activePage' => '',
            'app'        => $app,
            'messages'   => $messages,
        ]);
    }

    /**
     * Send message  POST /seeker/messages/send
     */
    public function send(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . SITE_URL . '/seeker/applications');
            exit;
        }

        $appId   = (int)($_POST['app_id'] ?? 0);
        $message = trim($_POST['message'] ?? '');
        $conn    = $GLOBALS['conn'];

        // Verify ownership
        $check = $conn->query("
            SELECT id FROM applications
            WHERE id = $appId AND applicant_id = {$this->seekerId}
            LIMIT 1
        ")->fetch_assoc();

        if ($check && $message !== '') {
            $msgModel = new Message();
            $msgModel->send($appId, $this->seekerId, 'job_seeker', $message);
        }

        header('Location: ' . SITE_URL . '/seeker/messages/' . $appId);
        exit;
    }
}