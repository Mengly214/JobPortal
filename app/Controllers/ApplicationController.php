<?php
require_once BASE_PATH . '/app/Models/Job.php';
require_once BASE_PATH . '/app/Models/Application.php';
require_once BASE_PATH . '/app/Models/User.php';

class ApplicationController extends Controller
{
    public function store(string $jobId): void
    {
        $jobId = (int)$jobId;

        // Must be a POST from the modal
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('jobs/' . $jobId);
            return;
        }

        $jobModel = new Job();
        $job      = $jobModel->find($jobId);

        if (!$job) {
            $this->redirect('jobs');
            return;
        }

        $appError = $appSuccess = '';

        if (!isLoggedIn()) {
            $appError = 'Please <a href="' . SITE_URL . '/login">log in</a> to apply for this job.';
        } elseif (userRole() !== 'job_seeker') {
            $appError = 'Only job seekers can apply for jobs.';
        } else {
            $userId   = (int)$_SESSION['user_id'];
            $appModel = new Application();

            if ($appModel->alreadyApplied($jobId, $userId)) {
                $appError = 'You have already applied for this job.';
            } else {
                $cover = clean($_POST['cover_letter'] ?? '');

                // Handle new CV upload
                $cv_file = '';
                $cvChoice = $_POST['cv_choice'] ?? 'existing';

                if ($cvChoice === 'new' && !empty($_FILES['cv_file']['name'])) {
                    $allowed = [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];
                    $fileType = $_FILES['cv_file']['type'];
                    $fileSize = $_FILES['cv_file']['size'];

                    if (!in_array($fileType, $allowed)) {
                        $appError = 'CV must be a PDF or Word document.';
                    } elseif ($fileSize > 5 * 1024 * 1024) {
                        $appError = 'CV file size must be under 5MB.';
                    } else {
                        $ext     = pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION);
                        $cv_file = 'cv_app_' . $userId . '_' . time() . '.' . $ext;
                        $dir     = BASE_PATH . '/public/uploads/resumes/';
                        if (!is_dir($dir)) mkdir($dir, 0755, true);
                        if (!move_uploaded_file($_FILES['cv_file']['tmp_name'], $dir . $cv_file)) {
                            $appError = 'Failed to upload CV. Please try again.';
                            $cv_file  = '';
                        }
                    }
                }

                if (!$appError) {
                    // If "use existing", pull cv_file from profile
                    if ($cvChoice === 'existing') {
                        $userModel = new User();
                        $seeker    = $userModel->findById($userId);
                        $cv_file   = $seeker['cv_file'] ?? '';
                    }

                    $ok = $appModel->createWithCv($jobId, $userId, $cover, $cv_file);
                    if ($ok) {
                        $appSuccess = 'success';
                    } else {
                        $appError = 'Something went wrong. Please try again.';
                    }
                }
            }
        }

        // If AJAX request, return JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            if ($appSuccess) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $appError]);
            }
            exit;
        }

        // Normal POST — reload job detail with flash
        $userModel = new User();
        $seeker    = isLoggedIn() ? $userModel->findById((int)$_SESSION['user_id']) : null;

        $this->view('jobs/detail', [
            'pageTitle'  => clean($job['title']),
            'activePage' => 'jobs',
            'job'        => $job,
            'skills'     => $jobModel->getSkills($jobId),
            'appSuccess' => $appSuccess,
            'appError'   => $appError,
            'seeker'     => $seeker,
            'alreadyApplied' => false,
        ]);
    }

    public function withdraw(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $applicationId = (int)$_POST['application_id'];
            $seekerId      = (int)($_SESSION['user_id'] ?? 0);
            if ($seekerId) {
                $appModel = new Application();
                $appModel->withdraw($applicationId, $seekerId);
            }
        }
        header('Location: ' . SITE_URL . '/seeker/applications');
        exit;
    }
}