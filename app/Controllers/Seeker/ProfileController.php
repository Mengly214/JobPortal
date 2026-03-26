<?php
require_once BASE_PATH . '/app/Models/User.php';

class Seeker_ProfileController extends Controller {

    public function index(): void {
        requireRole('job_seeker');
        $model = new User();
        $user  = $model->findById((int)$_SESSION['user_id']);
        $error = $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name'] ?? '');
            $email     = trim($_POST['email']     ?? '');
            $password  = $_POST['password']  ?? '';
            $confirm   = $_POST['password2'] ?? '';

            if (!$email)                                        $error = 'Email is required.';
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Invalid email address.';
            elseif ($password && strlen($password) < 8)         $error = 'Password must be at least 8 characters.';
            elseif ($password && $password !== $confirm)        $error = 'Passwords do not match.';
            else {
                // Avatar upload
                $avatar = $user['avatar'] ?? '';
                if (!empty($_FILES['avatar']['name'])) {
                    $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
                    if (in_array($_FILES['avatar']['type'], $allowed) && $_FILES['avatar']['size'] <= 2*1024*1024) {
                        $ext    = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                        $avatar = 'avatar_'.$_SESSION['user_id'].'_'.time().'.'.$ext;
                        $dir    = BASE_PATH . '/public/uploads/avatars/';
                        if (!is_dir($dir)) mkdir($dir, 0755, true);
                        move_uploaded_file($_FILES['avatar']['tmp_name'], $dir . $avatar);
                    }
                }

                // CV upload
                $cv_file = $user['cv_file'] ?? '';
                if (!empty($_FILES['cv_file']['name'])) {
                    $allowed = ['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                    if (in_array($_FILES['cv_file']['type'], $allowed) && $_FILES['cv_file']['size'] <= 5*1024*1024) {
                        $ext     = pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION);
                        $cv_file = 'cv_'.$_SESSION['user_id'].'_'.time().'.'.$ext;
                        $dir     = BASE_PATH . '/public/uploads/resumes/';
                        if (!is_dir($dir)) mkdir($dir, 0755, true);
                        move_uploaded_file($_FILES['cv_file']['tmp_name'], $dir . $cv_file);
                    }
                }

                $ok = $model->updateSeekerProfile((int)$_SESSION['user_id'], [
                    'full_name'   => $full_name,
                    'email'       => $email,
                    'password'    => $password,
                    'avatar'      => $avatar,
                    'seeker_city' => trim($_POST['seeker_city'] ?? ''),
                    'bio'         => trim($_POST['bio']         ?? ''),
                    'skills'      => trim($_POST['skills']      ?? ''),
                    'experience'  => trim($_POST['experience']  ?? ''),
                    'education'   => trim($_POST['education']   ?? ''),
                    'cv_file'     => $cv_file,
                ]);

                if ($ok) {
                    $_SESSION['email'] = $email;
                    $success = 'Profile updated successfully.';
                    $user    = $model->findById((int)$_SESSION['user_id']);
                } else {
                    $error = 'Update failed. Please try again.';
                }
            }
        }

        $this->view('seeker/profile', [
            'pageTitle'  => 'My Profile',
            'activePage' => '',
            'user'       => $user,
            'error'      => $error,
            'success'    => $success,
        ]);
    }
    public function update(): void
    {
        requireAuth();
        $userId = (int)$_SESSION['user_id'];
        $userModel = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name'   => clean($_POST['full_name']),
                'email'       => clean($_POST['email']),
                'seeker_city' => clean($_POST['location_city']),
                'bio'         => clean($_POST['bio']),
                'skills'      => clean($_POST['skills']),
                'experience'  => clean($_POST['experience']),
                'education'   => clean($_POST['education']),
                'avatar'      => $_POST['old_avatar'],
                'cv_file'     => $_POST['old_cv']
            ];

            // Handle CV Upload
            if (!empty($_FILES['cv_file']['name'])) {
                $fileName = time() . '_' . $_FILES['cv_file']['name'];
                move_uploaded_file($_FILES['cv_file']['tmp_name'], "uploads/cvs/$fileName");
                $data['cv_file'] = $fileName;
            }

            if ($userModel->updateSeekerProfile($userId, $data)) {
                $_SESSION['success'] = "Profile updated! Check your dashboard for 100% strength.";
                redirect('seeker/dashboard');
            }
        }
    }
}
