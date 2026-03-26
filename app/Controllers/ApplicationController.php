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
    public function cancel(string $id): void
    {
        requireAuth();
        $applicationId = (int)$id;
        $userId = (int)$_SESSION['user_id'];

        $appModel = new Application();

        if ($appModel->withdraw($applicationId, $userId)) {
            $_SESSION['success'] = "Application withdrawn successfully.";
        } else {
            $_SESSION['error'] = "Unable to withdraw application.";
        }

        $this->redirect('seeker/dashboard');
    }
}
