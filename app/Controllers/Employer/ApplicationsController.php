<?php
require_once BASE_PATH . '/app/Models/Application.php';

class Employer_ApplicationsController extends Controller {

    private int $employerId;

    public function __construct() {
        requireRole('employer');
        $this->employerId = (int)$_SESSION['user_id'];
    }

    /* ── LIST ALL APPLICATIONS FOR MY JOBS ──────────── */
    public function index(): void {
        $conn   = $GLOBALS['conn'];
        $jobFilter    = (int)($_GET['job']    ?? 0);
        $statusFilter = clean($_GET['status'] ?? '');

        $where = ["j.employer_id = {$this->employerId}"];
        if ($jobFilter)    $where[] = "a.job_id = $jobFilter";
        if ($statusFilter) $where[] = "a.status = '".addslashes($statusFilter)."'";
        $w = implode(' AND ', $where);

        $applications = $conn->query("
            SELECT a.*, a.applicant_id, j.title AS job_title, j.id AS job_id,
                   u.email AS applicant_email, u.full_name AS applicant_name,
                   sp.cv_file, sp.bio, sp.skills, sp.location_city AS seeker_city
            FROM applications a
            JOIN jobs j       ON a.job_id       = j.id
            JOIN users u      ON a.applicant_id  = u.id
            LEFT JOIN job_seeker_profiles sp ON u.id = sp.user_id
            WHERE $w
            ORDER BY a.applied_at DESC
        ")->fetch_all(MYSQLI_ASSOC);

        // Jobs dropdown for filter
        $myJobs = $conn->query("SELECT id, title FROM jobs WHERE employer_id={$this->employerId} ORDER BY title")->fetch_all(MYSQLI_ASSOC);

        $this->view('employer/applications', [
            'pageTitle'    => 'Applications',
            'activePage'   => '',
            'applications' => $applications,
            'myJobs'       => $myJobs,
            'jobFilter'    => $jobFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    /* ── VIEW SEEKER PUBLIC PROFILE ──────────────────── */
    public function viewSeeker(int $seekerId): void {
        $conn = $GLOBALS['conn'];

        // Security: only allow if this seeker applied to one of our jobs
        $check = $conn->query("
            SELECT a.id FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE a.applicant_id = $seekerId AND j.employer_id = {$this->employerId}
            LIMIT 1
        ")->fetch_assoc();

        if (!$check) {
            header('Location: ' . SITE_URL . '/employer/applications');
            exit;
        }

        $seeker = $conn->query("
            SELECT u.id, u.full_name, u.email, u.avatar, u.created_at,
                   sp.location_city, sp.bio, sp.skills, sp.experience, sp.education, sp.cv_file
            FROM users u
            LEFT JOIN job_seeker_profiles sp ON u.id = sp.user_id
            WHERE u.id = $seekerId AND u.role = 'job_seeker'
            LIMIT 1
        ")->fetch_assoc();

        if (!$seeker) {
            header('Location: ' . SITE_URL . '/employer/applications');
            exit;
        }

        // Their applications to MY jobs
        $appliedJobs = $conn->query("
            SELECT a.status, a.applied_at, j.title AS job_title, j.id AS job_id
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE a.applicant_id = $seekerId AND j.employer_id = {$this->employerId}
            ORDER BY a.applied_at DESC
        ")->fetch_all(MYSQLI_ASSOC);

        $this->view('employer/seeker-profile', [
            'pageTitle'   => 'Applicant Profile',
            'activePage'  => '',
            'seeker'      => $seeker,
            'appliedJobs' => $appliedJobs,
        ]);
    }


    public function show(int $id): void {
        $conn = $GLOBALS['conn'];

        $app = $conn->query("
            SELECT a.*, j.title AS job_title, j.id AS job_id,
                   u.email AS applicant_email, u.full_name AS applicant_name,
                   sp.cv_file, sp.bio, sp.skills, sp.experience, sp.education,
                   sp.location_city AS seeker_city
            FROM applications a
            JOIN jobs j       ON a.job_id       = j.id
            JOIN users u      ON a.applicant_id  = u.id
            LEFT JOIN job_seeker_profiles sp ON u.id = sp.user_id
            WHERE a.id = $id AND j.employer_id = {$this->employerId}
            LIMIT 1
        ")->fetch_assoc();

        if (!$app) {
            header('Location: ' . SITE_URL . '/employer/applications');
            exit;
        }

        $this->view('employer/applications', [
            'pageTitle'    => 'Application Detail',
            'activePage'   => '',
            'singleApp'    => $app,
            'applications' => [],
            'myJobs'       => [],
            'jobFilter'    => 0,
            'statusFilter' => '',
        ]);
    }

    /* ── UPDATE APPLICATION STATUS ───────────────────── */
    public function updateStatus(): void {
        $conn   = $GLOBALS['conn'];
        $appId  = (int)($_POST['app_id'] ?? 0);
        $status = clean($_POST['status'] ?? '');
        $jobId  = (int)($_POST['job_id'] ?? 0);

        $allowed = ['submitted','reviewing','shortlisted','interview','offered','hired','rejected','withdrawn'];
        if ($appId && in_array($status, $allowed)) {
            $conn->query("
                UPDATE applications a
                JOIN jobs j ON a.job_id = j.id
                SET a.status = '" . addslashes($status) . "'
                WHERE a.id = $appId AND j.employer_id = {$this->employerId}
            ");
        }

        $redirect = SITE_URL . '/employer/applications';
        if ($jobId) $redirect .= '?job=' . $jobId;
        $redirect .= (strpos($redirect, '?') !== false ? '&' : '?') . 'updated=1';
        header('Location: ' . $redirect);
        exit;
    }
}
