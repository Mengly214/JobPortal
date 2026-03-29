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
        $appModel = new Application();
        $jobModel = new Job();

        $seeker = $userModel->findById($userId);
        $recommendedJobs = $jobModel->getRecommendedJobs(5);

        // --- DYNAMIC CALCULATION (No more hardcoded 80!) ---
        $strength = 0;
        if (!empty($seeker['email']))      $strength += 20; // Account
        if (!empty($seeker['bio']))        $strength += 20; // Bio text
        if (!empty($seeker['skills']))     $strength += 20; // Skills text
        if (!empty($seeker['experience'])) $strength += 20; // Experience text
        if (!empty($seeker['cv_file']))    $strength += 20; // CV filename

        $this->view('seeker/dashboard', [
            'strength'     => $strength,
            'totalApplied' => $appModel->countBySeeker($userId),
            'recentApps'   => $appModel->recentBySeeker($userId, 3),
            'seeker'       => $seeker, // Always good to pass this to the view
            'jobs'         => $recommendedJobs
        ]);
    }

    // You can keep this or delete it if you don't use a separate applications page
    public function applications(): void
    {
        requireAuth();
        $userId   = (int)$_SESSION['user_id'];
        $conn     = $GLOBALS['conn'];

        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $where  = ["a.applicant_id = $userId"];
        if ($status) $where[] = "a.status = '" . $conn->real_escape_string($status) . "'";
        if ($search) {
            $s = $conn->real_escape_string($search);
            $where[] = "(j.title LIKE '%$s%' OR ep.company_name LIKE '%$s%')";
        }
        $w = implode(' AND ', $where);

        $applications = $conn->query("
            SELECT a.*, j.title AS job_title, j.id AS job_id,
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

        // Active jobs from this employer
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
        // 1. Check if it is a secure POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {

            $applicationId = (int)$_POST['application_id'];

            // Make sure you use whatever session variable stores your logged-in user's ID!
            $seekerId = $_SESSION['user_id'] ?? 0;

            // 2. Load the Application model (make sure the path matches your structure)
            require_once BASE_PATH . '/app/Models/Application.php';
            $appModel = new Application();

            // 3. Delete the application
            $appModel->withdraw($applicationId, $seekerId);
        }

        // 4. Redirect the user back to the applications dashboard
        header("Location: " . SITE_URL . "/seeker/applications");
        exit;
    }

}
