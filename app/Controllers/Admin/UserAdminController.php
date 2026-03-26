<?php
require_once BASE_PATH . '/app/Models/User.php';

class Admin_UserAdminController extends Controller {

    public function index(): void {
        requireRole('admin');
        $this->view('admin/users', [
            'adminTitle'  => 'Manage Users',
            'adminPage'   => 'users',
            'users'       => (new User())->getAll(clean($_GET['search'] ?? ''), clean($_GET['role'] ?? '')),
            'search'      => clean($_GET['search'] ?? ''),
            'roleFilter'  => clean($_GET['role'] ?? ''),
        ]);
    }

    public function toggle(string $id): void
    {
        requireRole('admin');
        (new User())->toggleActive((int)$id);
        $_SESSION['success'] = "User status updated successfully."; // Professional feedback
        redirect('admin/users');
    }

    public function delete(string $id): void
    {
        requireRole('admin');
        // Before deleting, you might want to check if they have pending applications
        (new User())->delete((int)$id);
        $_SESSION['success'] = "User account removed.";
        redirect('admin/users');
    }
    
}
