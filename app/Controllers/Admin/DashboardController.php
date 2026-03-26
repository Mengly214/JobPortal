<?php
require_once BASE_PATH . '/app/Models/Job.php';
require_once BASE_PATH . '/app/Models/User.php';
require_once BASE_PATH . '/app/Models/Application.php';
require_once BASE_PATH . '/app/Models/Blog.php';
require_once BASE_PATH . '/app/Models/ContactMessage.php';

class Admin_DashboardController extends Controller {

    public function index(): void
    {
        requireRole('admin');

        // 1. Create instances
        $jobs = new Job();
        $users = new User();
        $apps = new Application();
        $blog = new Blog();
        $msgs = new ContactMessage();

        // 2. TEMPORARILY bypass the count methods to see if it loads
        $this->view('admin/dashboard', [
            'adminTitle'   => 'Dashboard',
            'adminPage'    => 'dashboard',
            'stats' => [
                'active_jobs'     => 0, // Hardcode for testing
                'total_jobs'      => 0,
                'total_seekers'   => 0,
                'total_employers' => 0,
                'total_apps'      => 0,
                'new_apps'        => 0,
                'unread_messages' => 0,
                'total_blog'      => 0,
            ],
            'recentJobs'   => [],
            'recentApps'   => [],
            'recentUsers'  => [],
            'jobsByStatus' => [],
        ]);
    }
}
