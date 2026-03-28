<?php
require_once BASE_PATH . '/app/Models/Job.php';
require_once BASE_PATH . '/app/Models/Application.php';

class ApplicationController extends Controller
{

    public function store(string $jobId): void
    {
        $jobId = (int)$jobId;
        $model = new Job();
        $job   = $model->find($jobId);
        if (!$job) {
            $this->redirect('jobs');
            return;
        }

        $appSuccess = $appError = '';

        if (!isLoggedIn()) {
            $appError = 'Please <a href="' . SITE_URL . '/login">log in</a> to apply for this job.';
        } elseif (userRole() !== 'job_seeker') {
            $appError = 'Only job seekers can apply for jobs.';
        } else {
            $appModel = new Application();
            if ($appModel->alreadyApplied($jobId, (int)$_SESSION['user_id'])) {
                $appError = 'You have already applied for this job.';
            } else {
                $cover = clean($_POST['cover_letter'] ?? '');
                $ok    = $appModel->create($jobId, (int)$_SESSION['user_id'], $cover);
                $appSuccess = $ok ? 'Application submitted successfully!' : 'Something went wrong. Please try again.';
            }
        }

        $this->view('jobs/detail', [
            'pageTitle'  => clean($job['title']),
            'activePage' => 'jobs',
            'job'        => $job,
            'skills'     => $model->getSkills($jobId),
            'appSuccess' => $appSuccess,
            'appError'   => $appError,
        ]);
    }
  
    // Add this inside your Controller
    public function withdraw(): void
    {
        // 1. Make sure it's a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 2. Get the IDs
            $applicationId = (int)$_POST['application_id'];
            $seekerId = $_SESSION['user_id']; // Assuming you store the logged-in user ID here

            // 3. Run the deletion
            $appModel = new Application(); // Or whatever your model is named
            $success = $appModel->withdraw($applicationId, $seekerId);

            // 4. Set a success or error message (if you are using flash messages)
            if ($success) {
                // Application withdrawn!
            }
        }

        // 5. Send them right back to the applications page
        header("Location: " . SITE_URL . "/seeker/applications");
        exit;
    }

}
