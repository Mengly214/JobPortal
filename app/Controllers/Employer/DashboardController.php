<?php
class Employer_DashboardController extends Controller {

    public function index(): void {
        requireRole('employer');

        $employerId = (int)$_SESSION['user_id'];
        $conn       = $GLOBALS['conn'];

        // ── Employer profile
        $ep = $conn->query("SELECT ep.*, u.email, u.full_name, u.avatar FROM employer_profiles ep JOIN users u ON ep.user_id=u.id WHERE ep.user_id=$employerId LIMIT 1")->fetch_assoc();

        // ── My jobs stats
        $totalJobs  = (int)$conn->query("SELECT COUNT(*) c FROM jobs WHERE employer_id=$employerId")->fetch_assoc()['c'];
        $activeJobs = (int)$conn->query("SELECT COUNT(*) c FROM jobs WHERE employer_id=$employerId AND status='active'")->fetch_assoc()['c'];
        $draftJobs  = (int)$conn->query("SELECT COUNT(*) c FROM jobs WHERE employer_id=$employerId AND status='draft'")->fetch_assoc()['c'];
        $closedJobs = (int)$conn->query("SELECT COUNT(*) c FROM jobs WHERE employer_id=$employerId AND status='closed'")->fetch_assoc()['c'];

        // ── Applications stats
        $totalApps = (int)$conn->query("SELECT COUNT(*) c FROM applications a JOIN jobs j ON a.job_id=j.id WHERE j.employer_id=$employerId")->fetch_assoc()['c'];
        $newApps   = (int)$conn->query("SELECT COUNT(*) c FROM applications a JOIN jobs j ON a.job_id=j.id WHERE j.employer_id=$employerId AND a.status='submitted'")->fetch_assoc()['c'];
        $hiredApps = (int)$conn->query("SELECT COUNT(*) c FROM applications a JOIN jobs j ON a.job_id=j.id WHERE j.employer_id=$employerId AND a.status='hired'")->fetch_assoc()['c'];

        // ── Total views on my jobs
        $totalViews = (int)$conn->query("SELECT COALESCE(SUM(views),0) c FROM jobs WHERE employer_id=$employerId")->fetch_assoc()['c'];

        // ── Recent jobs (5)
        $recentJobs = $conn->query("SELECT * FROM jobs WHERE employer_id=$employerId ORDER BY created_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

        // ── Recent applications on my jobs (6)
        $recentApps = $conn->query("SELECT a.*, j.title AS job_title, u.email AS applicant_email, u.full_name AS applicant_name, sp.cv_file FROM applications a JOIN jobs j ON a.job_id=j.id JOIN users u ON a.applicant_id=u.id LEFT JOIN job_seeker_profiles sp ON u.id=sp.user_id WHERE j.employer_id=$employerId ORDER BY a.applied_at DESC LIMIT 6")->fetch_all(MYSQLI_ASSOC);

        // ── Applications by status breakdown
        $appsByStatus = $conn->query("SELECT a.status, COUNT(*) total FROM applications a JOIN jobs j ON a.job_id=j.id WHERE j.employer_id=$employerId GROUP BY a.status")->fetch_all(MYSQLI_ASSOC);

        $this->view('employer/dashboard', [
            'pageTitle'    => 'Employer Dashboard',
            'activePage'   => '',
            'ep'           => $ep,
            'totalJobs'    => $totalJobs,
            'activeJobs'   => $activeJobs,
            'draftJobs'    => $draftJobs,
            'closedJobs'   => $closedJobs,
            'totalApps'    => $totalApps,
            'newApps'      => $newApps,
            'hiredApps'    => $hiredApps,
            'totalViews'   => $totalViews,
            'recentJobs'   => $recentJobs,
            'recentApps'   => $recentApps,
            'appsByStatus' => $appsByStatus,
        ]);
    }
}