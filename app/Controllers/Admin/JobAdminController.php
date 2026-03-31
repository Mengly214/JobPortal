<?php
require_once BASE_PATH . '/app/Models/Job.php';

class Admin_JobAdminController extends Controller {

    public function index(): void {
        requireRole('admin');
        $model = new Job();
        if (isset($_GET['toggle']))  { $model->toggleStatus((int)$_GET['toggle']);   redirect('admin/jobs'); }
        if (isset($_GET['delete']))  { $model->delete((int)$_GET['delete']);         redirect('admin/jobs'); }
        if (isset($_GET['feature'])) { $model->toggleFeatured((int)$_GET['feature']); redirect('admin/jobs'); }

        $this->view('admin/jobs', [
            'adminTitle' => 'Manage Jobs',
            'adminPage'  => 'jobs',
            'jobs'       => $model->getAll(clean($_GET['search'] ?? ''), clean($_GET['status'] ?? '')),
            'search'     => clean($_GET['search'] ?? ''),
            'status'     => clean($_GET['status'] ?? ''),
        ]);
    }

    public function edit(int $id): void {
        requireRole('admin');
        $model      = new Job();
        $categories = $model->getCategories();
        $job        = $model->find($id);
        $error      = '';

        if (!$job) { redirect('admin/jobs'); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title    = clean($_POST['title'] ?? '');
            $desc     = clean($_POST['description'] ?? '');
            $city     = clean($_POST['location_city'] ?? '');
            $job_type = clean($_POST['job_type'] ?? '');

            if (!$title || !$desc || !$city || !$job_type) {
                $error = 'Please fill in all required fields.';
            } else {
                $job_image = $job['job_image'] ?? '';
                if (!empty($_FILES['job_image']['name'])) {
                    $allowed   = ['image/jpeg','image/png','image/gif','image/webp'];
                    $file_type = $_FILES['job_image']['type'];
                    if (!in_array($file_type, $allowed)) {
                        $error = 'Invalid image type.';
                    } elseif ($_FILES['job_image']['size'] > 2 * 1024 * 1024) {
                        $error = 'Image too large. Max 2MB.';
                    } else {
                        $ext       = pathinfo($_FILES['job_image']['name'], PATHINFO_EXTENSION);
                        $new_img   = 'job_' . time() . '_' . rand(100,999) . '.' . $ext;
                        $dest      = BASE_PATH . '/public/uploads/jobs/' . $new_img;
                        if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0755, true);
                        if (move_uploaded_file($_FILES['job_image']['tmp_name'], $dest)) {
                            if ($job_image && file_exists(BASE_PATH . '/public/uploads/jobs/' . $job_image))
                                @unlink(BASE_PATH . '/public/uploads/jobs/' . $job_image);
                            $job_image = $new_img;
                        } else { $error = 'Failed to upload image.'; }
                    }
                }

                if (!$error) {
                    $conn     = $GLOBALS['conn'];
                    $deadline = clean($_POST['application_deadline'] ?? '');
                    $dlSql    = $deadline ? "'" . $conn->real_escape_string($deadline) . "'" : 'NULL';
                    $conn->query("
                        UPDATE jobs SET
                            title               = '" . $conn->real_escape_string($title) . "',
                            description         = '" . $conn->real_escape_string($desc) . "',
                            requirements        = '" . $conn->real_escape_string(clean($_POST['requirements'] ?? '')) . "',
                            benefits            = '" . $conn->real_escape_string(clean($_POST['benefits'] ?? '')) . "',
                            job_type            = '" . $conn->real_escape_string($job_type) . "',
                            work_mode           = '" . $conn->real_escape_string(clean($_POST['work_mode'] ?? 'on-site')) . "',
                            experience_level    = '" . $conn->real_escape_string(clean($_POST['experience_level'] ?? 'mid')) . "',
                            salary_min          = " . (int)($_POST['salary_min'] ?? 0) . ",
                            salary_max          = " . (int)($_POST['salary_max'] ?? 0) . ",
                            salary_currency     = '" . $conn->real_escape_string(clean($_POST['salary_currency'] ?? 'USD')) . "',
                            location_city       = '" . $conn->real_escape_string($city) . "',
                            location_country    = '" . $conn->real_escape_string(clean($_POST['location_country'] ?? '')) . "',
                            deadline            = $dlSql,
                            status              = '" . $conn->real_escape_string(clean($_POST['status'] ?? 'draft')) . "',
                            is_featured         = " . (isset($_POST['is_featured']) ? 1 : 0) . ",
                            category_id         = " . (int)($_POST['category_id'] ?? 0) . ",
                            employer_id         = " . (int)($_POST['employer_id'] ?? $job['employer_id']) . ",
                            job_image           = '" . $conn->real_escape_string($job_image) . "'
                        WHERE id = $id
                    ");
                    redirect('admin/jobs?updated=1');
                }
            }
        }

        $this->view('admin/job-edit', [
            'adminTitle' => 'Edit Job — ' . ($job['title'] ?? ''),
            'adminPage'  => 'jobs',
            'categories' => $categories,
            'job'        => $job,
            'error'      => $error,
        ]);
    }

    public function create(): void {
        $model      = new Job();
        $categories = $model->getCategories();
        $error      = '';
        $success    = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title    = clean($_POST['title'] ?? '');
            $desc     = clean($_POST['description'] ?? '');
            $city     = clean($_POST['location_city'] ?? '');
            $country  = clean($_POST['location_country'] ?? '');
            $job_type = clean($_POST['job_type'] ?? '');
            $status   = clean($_POST['status'] ?? 'draft');

            if (!$title || !$desc || !$city || !$job_type) {
                $error = 'Please fill in all required fields.';
            } else {
// Handle image upload
$job_image = '';
if (!empty($_FILES['job_image']['name'])) {
    $allowed   = ['image/jpeg','image/png','image/gif','image/webp'];
    $file_type = $_FILES['job_image']['type'];
    $file_size = $_FILES['job_image']['size'];

    if (!in_array($file_type, $allowed)) {
        $error = 'Invalid image type. Only JPG, PNG, GIF, WEBP allowed.';
    } elseif ($file_size > 2 * 1024 * 1024) {
        $error = 'Image too large. Max size is 2MB.';
    } else {
        $ext       = pathinfo($_FILES['job_image']['name'], PATHINFO_EXTENSION);
        $job_image = 'job_' . time() . '_' . rand(100,999) . '.' . $ext;
        $dest      = BASE_PATH . '/public/uploads/jobs/' . $job_image;

        if (!is_dir(BASE_PATH . '/public/uploads/jobs/')) {
            mkdir(BASE_PATH . '/public/uploads/jobs/', 0755, true);
        }

        if (!move_uploaded_file($_FILES['job_image']['tmp_name'], $dest)) {
            $error     = 'Failed to upload image.';
            $job_image = '';
        } else {
            // Resize image to 720x480
            list($width, $height) = getimagesize($dest);
            $newWidth  = 720;
            $newHeight = 480;

            $src = null;
            switch ($file_type) {
                case 'image/jpeg':
                case 'image/jpg':
                    $src = imagecreatefromjpeg($dest);
                    break;
                case 'image/png':
                    $src = imagecreatefrompng($dest);
                    break;
                case 'image/gif':
                    $src = imagecreatefromgif($dest);
                    break;
                case 'image/webp':
                    $src = imagecreatefromwebp($dest);
                    break;
            }

            if ($src) {
                $dst = imagecreatetruecolor($newWidth, $newHeight);
                // Preserve transparency for PNG/GIF
                if ($file_type == 'image/png' || $file_type == 'image/gif') {
                    imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                }

                imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Save resized image
                switch ($file_type) {
                    case 'image/jpeg':
                    case 'image/jpg':
                        imagejpeg($dst, $dest, 90);
                        break;
                    case 'image/png':
                        imagepng($dst, $dest);
                        break;
                    case 'image/gif':
                        imagegif($dst, $dest);
                        break;
                    case 'image/webp':
                        imagewebp($dst, $dest);
                        break;
                }

                imagedestroy($src);
                imagedestroy($dst);
            }
        }
    }
}

                if (!$error) {
                    $ok = $model->create([
                        'employer_id'          => (int)($_POST['employer_id'] ?? 0),
                        'category_id'          => (int)($_POST['category_id'] ?? 0),
                        'title'                => $title,
                        'description'          => $desc,
                        'requirements'         => clean($_POST['requirements'] ?? ''),
                        'benefits'             => clean($_POST['benefits'] ?? ''),
                        'job_type'             => $job_type,
                        'work_mode'            => clean($_POST['work_mode'] ?? 'on-site'),
                        'experience_level'     => clean($_POST['experience_level'] ?? 'mid'),
                        'salary_min'           => (int)($_POST['salary_min'] ?? 0),
                        'salary_max'           => (int)($_POST['salary_max'] ?? 0),
                        'salary_currency'      => clean($_POST['salary_currency'] ?? 'USD'),
                        'location_city'        => $city,
                        'location_country'     => $country,
                        'application_deadline' => clean($_POST['application_deadline'] ?? ''),
                        'status'               => $status,
                        'is_featured'          => isset($_POST['is_featured']) ? 1 : 0,
                        'job_image'            => $job_image,
                    ]);
                    if ($ok) redirect('admin/jobs');
                    else $error = 'Failed to save job. Please try again.';
                }
            }
        }

        $this->view('admin/job-form', [
            'adminTitle' => 'Add Job',
            'adminPage'  => 'jobs',
            'categories' => $categories,
            'error'      => $error,
            'success'    => $success,
        ]);
    }
}