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

        $jobs = new Job();
        $users = new User();
        $apps = new Application();
        $blog = new Blog();
        $msgs = new ContactMessage();

        $this->view('admin/dashboard', [
            'adminTitle'   => 'Dashboard',
            'adminPage'    => 'dashboard',
            'stats' => [
                'active_jobs'     => $jobs->countActive(),
                'total_jobs'      => $jobs->countAll(),
                'total_seekers'   => $users->count('job_seeker'),
                'total_employers' => $users->count('employer'),
                'total_apps'      => $apps->count(),
                'new_apps'        => $apps->countNew(),
                'unread_messages' => $msgs->countUnread(),
                'total_blog'      => $blog->countPublished(),
            ],
            'recentJobs'   => $jobs->recent(8),
            'recentApps'   => $apps->recent(8),
            'recentUsers'  => $users->recent(6),
            'jobsByStatus' => $jobs->countByStatus(),
        ]);
    }
}