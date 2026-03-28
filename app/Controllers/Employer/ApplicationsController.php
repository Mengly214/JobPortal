<?php
require_once BASE_PATH . '/app/Models/Application.php';

class Employer_ApplicationsController extends Controller
{
    // Show all applications for employer
    public function index(): void
    {
        requireRole('employer');
        $employerId = $_SESSION['user_id'] ?? 0;

        $appModel = new Application();
        $applications = $appModel->getByEmployer($employerId);

        $this->view('employer/applications/index1', [
            'applications' => $applications,
            'pageTitle' => 'Applications',
        ]);
    }

    // Show single application
    public function show(int $id): void
{
    requireRole('employer');

    $application = (new Application())->find($id);
    if (!$application) {
        redirect('/employer/applications'); // go back if not found
    }

    $this->view('employer/applications/show1', [
        'application' => $application,
        'pageTitle' => 'Application Details',
    ]);
}

    // Update status
    public function updateStatus(): void
    {
        requireRole('employer');

        $id = $_POST['application_id'] ?? 0;
        $status = $_POST['status'] ?? 'submitted';

        (new Application())->updateStatus($id, $status);

        redirect('/employer/applications');
    }
}