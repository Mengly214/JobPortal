<?php
require_once BASE_PATH . '/app/Models/User.php';

class Employer_ReportController extends Controller
{
    public function index(): void
    {
        requireRole('employer');
        $employerId = (int)$_SESSION['user_id'];
        $conn       = $GLOBALS['conn'];

        // ── Company / employer profile ───────────────────────
        $ep = $conn->query("
            SELECT ep.*, u.email, u.full_name, u.avatar, u.created_at AS joined_at
            FROM employer_profiles ep
            JOIN users u ON ep.user_id = u.id
            WHERE ep.user_id = $employerId
            LIMIT 1
        ")->fetch_assoc();

        // ── All jobs posted ──────────────────────────────────
        $jobs = $conn->query("
            SELECT j.id, j.title, j.status, j.job_type, j.location_city,
                   j.salary_min, j.salary_max, j.salary_currency,
                   j.views, j.created_at, j.application_deadline,
                   (SELECT COUNT(*) FROM applications a WHERE a.job_id = j.id) AS total_apps,
                   (SELECT COUNT(*) FROM applications a WHERE a.job_id = j.id AND a.status IN ('interview','shortlisted')) AS interview_count,
                   (SELECT COUNT(*) FROM applications a WHERE a.job_id = j.id AND a.status = 'hired') AS hired_count
            FROM jobs j
            WHERE j.employer_id = $employerId
            ORDER BY j.created_at DESC
        ")->fetch_all(MYSQLI_ASSOC);

        // ── Job count stats ──────────────────────────────────
        $jobStats = ['total'=>0,'active'=>0,'paused'=>0,'closed'=>0,'draft'=>0];
        foreach ($jobs as $j) {
            $jobStats['total']++;
            if (isset($jobStats[$j['status']])) $jobStats[$j['status']]++;
        }

        // ── Application stats across all jobs ────────────────
        $appRows = $conn->query("
            SELECT a.status, COUNT(*) AS cnt
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE j.employer_id = $employerId
            GROUP BY a.status
        ")->fetch_all(MYSQLI_ASSOC);

        $appStats = [
            'total'=>0,'submitted'=>0,'reviewing'=>0,'shortlisted'=>0,
            'interview'=>0,'offered'=>0,'hired'=>0,'rejected'=>0,'withdrawn'=>0,
        ];
        foreach ($appRows as $row) {
            $appStats['total']      += $row['cnt'];
            if (isset($appStats[$row['status']])) $appStats[$row['status']] += $row['cnt'];
        }

        // ── Total views across all jobs ───────────────────────
        $totalViews = (int)$conn->query("
            SELECT COALESCE(SUM(views),0) c FROM jobs WHERE employer_id=$employerId
        ")->fetch_assoc()['c'];

        // ── Response rate: reviewed / total apps ─────────────
        $reviewed = $appStats['total'] - $appStats['submitted'];
        $responseRate = $appStats['total'] > 0
            ? round($reviewed / $appStats['total'] * 100)
            : 0;

        // ── Last active (most recent application update on their jobs) ─
        $lastActiveRow = $conn->query("
            SELECT MAX(a.updated_at) AS last_active
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE j.employer_id = $employerId
        ")->fetch_assoc();
        $lastActive = $lastActiveRow['last_active'] ?? ($ep['joined_at'] ?? null);

        $this->view('employer/report', [
            'ep'           => $ep,
            'jobs'         => $jobs,
            'jobStats'     => $jobStats,
            'appStats'     => $appStats,
            'totalViews'   => $totalViews,
            'responseRate' => $responseRate,
            'lastActive'   => $lastActive,
        ]);
    }
}