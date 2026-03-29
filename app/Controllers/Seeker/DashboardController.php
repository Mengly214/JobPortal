<?php
require_once BASE_PATH . '/app/Models/User.php';
require_once BASE_PATH . '/app/Models/Application.php';
require_once BASE_PATH . '/app/Models/Job.php';

class Seeker_DashboardController extends Controller
{
    public function index(): void
    {
        requireAuth();
        $userId = (int)$_SESSION['user_id'];

        $userModel = new User();
        $appModel  = new Application();
        $jobModel  = new Job();

        $seeker          = $userModel->findById($userId);
        $recommendedJobs = $jobModel->getRecommendedJobs(5);

        $strength = 0;
        if (!empty($seeker['email']))      $strength += 20;
        if (!empty($seeker['bio']))        $strength += 20;
        if (!empty($seeker['skills']))     $strength += 20;
        if (!empty($seeker['experience'])) $strength += 20;
        if (!empty($seeker['cv_file']))    $strength += 20;

        $this->view('seeker/dashboard', [
            'strength'     => $strength,
            'totalApplied' => $appModel->countBySeeker($userId),
            'recentApps'   => $appModel->recentBySeeker($userId, 3),
            'seeker'       => $seeker,
            'jobs'         => $recommendedJobs,
        ]);
    }

    public function applications(): void
    {
        requireAuth();
        $userId = (int)$_SESSION['user_id'];
        $conn   = $GLOBALS['conn'];

        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $where = ["a.applicant_id = $userId"];
        if ($status) $where[] = "a.status = '" . $conn->real_escape_string($status) . "'";
        if ($search) {
            $s       = $conn->real_escape_string($search);
            $where[] = "(j.title LIKE '%$s%' OR ep.company_name LIKE '%$s%')";
        }
        $w = implode(' AND ', $where);

        $applications = $conn->query("
            SELECT a.id, a.status, a.applied_at, a.job_id, a.applicant_id,
                   j.title AS job_title, j.job_type, j.location_city,
                   j.deadline AS application_deadline, j.employer_id,
                   ep.company_name, ep.logo AS company_logo
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE $w
            ORDER BY a.applied_at DESC
            LIMIT 100
        ")->fetch_all(MYSQLI_ASSOC);

        $this->view('seeker/applications', ['applications' => $applications]);
    }

    /**
     * Standalone status-tracking page for a single application.
     * URL: /seeker/application/{id}
     */
    public function viewStatus(int $appId): void
    {
        requireAuth();
        $userId = (int)$_SESSION['user_id'];
        $conn   = $GLOBALS['conn'];

        $appId = (int)$appId;

        $result = $conn->query("
            SELECT a.id, a.status, a.applied_at, a.job_id, a.applicant_id,
                   j.title AS job_title, j.job_type, j.location_city,
                   j.deadline AS application_deadline, j.employer_id,
                   ep.company_name, ep.logo AS company_logo
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE a.id = $appId AND a.applicant_id = $userId
            LIMIT 1
        ");

        if (!$result || $result->num_rows === 0) {
            // Not found or doesn't belong to this seeker — redirect back
            header('Location: ' . SITE_URL . '/seeker/applications');
            exit;
        }

        $application = $result->fetch_assoc();

        $this->view('seeker/application-status', [
            'pageTitle'   => 'Application Status — ' . $application['job_title'],
            'activePage'  => '',
            'application' => $application,
        ]);
    }

    public function viewEmployer(int $employerId): void
    {
        requireAuth();
        $conn = $GLOBALS['conn'];

        $employer = $conn->query("
            SELECT u.id, u.full_name, u.email, u.avatar, u.created_at,
                   ep.company_name, ep.logo, ep.location_city, ep.website,
                   ep.industry, ep.company_size, ep.description AS company_desc
            FROM users u
            JOIN employer_profiles ep ON u.id = ep.user_id
            WHERE u.id = $employerId AND u.role = 'employer' AND u.is_active = 1
            LIMIT 1
        ")->fetch_assoc();

        if (!$employer) {
            header('Location: ' . SITE_URL . '/seeker/applications');
            exit;
        }

        $jobs = $conn->query("
            SELECT j.id, j.title, j.job_type, j.location_city, j.salary_min,
                   j.salary_max, j.salary_currency, j.created_at, j.deadline,
                   c.name AS category_name
            FROM jobs j
            LEFT JOIN categories c ON j.category_id = c.id
            WHERE j.employer_id = $employerId AND j.status = 'active'
            ORDER BY j.created_at DESC
            LIMIT 10
        ")->fetch_all(MYSQLI_ASSOC);

        $this->view('seeker/employer-profile', [
            'pageTitle'  => ($employer['company_name'] ?? 'Company') . ' — Profile',
            'activePage' => '',
            'employer'   => $employer,
            'jobs'       => $jobs,
        ]);
    }

    public function withdraw(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {
            $applicationId = (int)$_POST['application_id'];
            $seekerId      = $_SESSION['user_id'] ?? 0;

            require_once BASE_PATH . '/app/Models/Application.php';
            $appModel = new Application();
            $appModel->withdraw($applicationId, $seekerId);
        }

        header('Location: ' . SITE_URL . '/seeker/applications');
        exit;
    }
}