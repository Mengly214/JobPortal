<?php
require_once BASE_PATH . '/app/Models/User.php';
require_once BASE_PATH . '/app/Models/Application.php';

class Seeker_ReportController extends Controller
{
    public function index(): void
    {
        requireRole('job_seeker');
        $userId = (int)$_SESSION['user_id'];
        $conn   = $GLOBALS['conn'];

        // ── Seeker profile ──────────────────────────────────
        $userModel = new User();
        $seeker    = $userModel->findById($userId);

        // ── All applications with job + company detail ──────
        $applications = $conn->query("
            SELECT a.id, a.status, a.applied_at,
                   j.title AS job_title, j.job_type, j.location_city,
                   ep.company_name, ep.logo AS company_logo
            FROM applications a
            JOIN jobs j        ON a.job_id       = j.id
            LEFT JOIN employer_profiles ep ON j.employer_id = ep.user_id
            WHERE a.applicant_id = $userId
            ORDER BY a.applied_at DESC
        ")->fetch_all(MYSQLI_ASSOC);

        // ── Stats ───────────────────────────────────────────
        $stats = [
            'total'       => 0,
            'interview'   => 0,
            'hired'       => 0,
            'rejected'    => 0,
            'reviewing'   => 0,
            'shortlisted' => 0,
            'offered'     => 0,
            'withdrawn'   => 0,
            'pending'     => 0,   // submitted = pending
        ];
        foreach ($applications as $app) {
            $stats['total']++;
            $s = $app['status'];
            if ($s === 'submitted')                    $stats['pending']++;
            elseif (isset($stats[$s]))                 $stats[$s]++;
        }

        // ── Profile strength ────────────────────────────────
        $checks = [
            'email'      => ['label' => 'Account email',      'done' => !empty($seeker['email'])],
            'bio'        => ['label' => 'Bio / Summary',       'done' => !empty($seeker['bio'])],
            'skills'     => ['label' => 'Skills listed',       'done' => !empty($seeker['skills'])],
            'experience' => ['label' => 'Experience added',    'done' => !empty($seeker['experience'])],
            'cv_file'    => ['label' => 'CV uploaded',         'done' => !empty($seeker['cv_file'])],
            'education'  => ['label' => 'Education added',     'done' => !empty($seeker['education'])],
            'portfolio'  => ['label' => 'Portfolio URL',       'done' => !empty($seeker['portfolio_url'])],
            'phone'      => ['label' => 'Phone number',        'done' => !empty($seeker['phone'])],
        ];
        $doneCount = count(array_filter($checks, fn($c) => $c['done']));
        $strength  = (int)round($doneCount / count($checks) * 100);

        $this->view('seeker/report', [
            'seeker'       => $seeker,
            'applications' => $applications,
            'stats'        => $stats,
            'checks'       => $checks,
            'strength'     => $strength,
        ]);
    }
}