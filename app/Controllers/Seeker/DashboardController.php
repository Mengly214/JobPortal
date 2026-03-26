<?php
require_once BASE_PATH . '/app/Models/User.php';
require_once BASE_PATH . '/app/Models/Application.php';

class Seeker_DashboardController extends Controller
{
    public function index(): void
    {
        requireAuth();
        $userId = (int)$_SESSION['user_id'];

        $userModel = new User();
        $appModel = new Application();

        $seeker = $userModel->findById($userId);

        // --- DYNAMIC CALCULATION (No more hardcoded 80!) ---
        $strength = 0;
        if (!empty($seeker['email']))      $strength += 20; // Account
        if (!empty($seeker['bio']))        $strength += 20; // Bio text
        if (!empty($seeker['skills']))     $strength += 20; // Skills text
        if (!empty($seeker['experience'])) $strength += 20; // Experience text
        if (!empty($seeker['cv_file']))    $strength += 20; // CV filename

        $this->view('seeker/dashboard', [
            'strength'     => $strength,
            'totalApplied' => $appModel->countBySeeker($userId),
            'recentApps'   => $appModel->recentBySeeker($userId, 5),
            'seeker'       => $seeker // Always good to pass this to the view
        ]);
    }

    // You can keep this or delete it if you don't use a separate applications page
    public function applications(): void
    {
        requireAuth();
        $userId = (int)$_SESSION['user_id'];
        $appModel = new Application();

        // Fetch the FULL list for the applications page
        $data['applications'] = $appModel->recentBySeeker($userId, 50);

        // LOAD THE SPECIFIC VIEW YOU SHARED EARLIER
        $this->view('seeker/applications', $data);
    }
}
