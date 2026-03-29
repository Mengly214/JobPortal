<?php
require_once BASE_PATH . '/app/Models/Job.php';

class Employer_JobsController extends Controller {

    private int $employerId;

    public function __construct() {
        requireRole('employer');
        $this->employerId = (int)$_SESSION['user_id'];
    }

    /* ── LIST MY JOBS ─────────────────────────────────── */
    public function index(): void {
        $conn   = $GLOBALS['conn'];
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');
        $sort   = in_array($_GET['sort'] ?? '', ['title', 'views']) ? $_GET['sort'] : 'created_at';

        $where = ["j.employer_id = {$this->employerId}"];
        if ($status) $where[] = "j.status = '" . $conn->real_escape_string($status) . "'";
        if ($search) {
            $s = $conn->real_escape_string($search);
            $where[] = "j.title LIKE '%$s%'";
        }
        $w = implode(' AND ', $where);

        $jobs = $conn->query("
            SELECT j.*, c.name AS category_name,
                   (SELECT COUNT(*) FROM applications a WHERE a.job_id = j.id) AS app_count
            FROM jobs j
            LEFT JOIN categories c ON j.category_id = c.id
            WHERE $w
            ORDER BY j.$sort DESC
        ")->fetch_all(MYSQLI_ASSOC);

        $this->view('employer/jobs', [
            'pageTitle' => 'My Jobs',
            'activePage' => '',
            'jobs'   => $jobs,
            'search' => $search,
            'status' => $status,
            'sort'   => $sort,
        ]);
    }

    /* ── CREATE JOB (GET = form, POST = save) ─────────── */
    public function create(): void {
        $conn       = $GLOBALS['conn'];
        $categories = $conn->query("SELECT id, name FROM categories ORDER BY name")->fetch_all(MYSQLI_ASSOC);
        $error      = $success = '';
        $old        = [];
        $job        = null;
        $editMode   = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$error, $success, $old] = $this->saveJob($conn, null);
        }

        $this->view('employer/post-job', [
            'pageTitle'  => 'Post a Job',
            'activePage' => '',
            'categories' => $categories,
            'error'      => $error,
            'success'    => $success,
            'old'        => $old,
            'job'        => $job,
            'editMode'   => $editMode,
        ]);
    }

    /* ── EDIT JOB (GET = form, POST = update) ─────────── */
    public function edit(int $id): void {
        $conn       = $GLOBALS['conn'];
        $categories = $conn->query("SELECT id, name FROM categories ORDER BY name")->fetch_all(MYSQLI_ASSOC);
        $error      = $success = '';
        $old        = [];
        $editMode   = true;

        // Verify ownership
        $job = $conn->query("SELECT * FROM jobs WHERE id=$id AND employer_id={$this->employerId} LIMIT 1")->fetch_assoc();
        if (!$job) {
            header('Location: ' . SITE_URL . '/employer/jobs');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$error, $success, $old] = $this->saveJob($conn, $id);
            // Refresh job data after update
            if (!$error) {
                $job = $conn->query("SELECT * FROM jobs WHERE id=$id LIMIT 1")->fetch_assoc();
            }
        }

        $this->view('employer/post-job', [
            'pageTitle'  => 'Edit Job',
            'activePage' => '',
            'categories' => $categories,
            'error'      => $error,
            'success'    => $success,
            'old'        => $old,
            'job'        => $job,
            'editMode'   => $editMode,
        ]);
    }

    /* ── TOGGLE STATUS ────────────────────────────────── */
    public function toggle(int $id): void {
        $conn = $GLOBALS['conn'];
        // Verify ownership first
        $job = $conn->query("SELECT status FROM jobs WHERE id=$id AND employer_id={$this->employerId} LIMIT 1")->fetch_assoc();
        if ($job) {
            $newStatus = $job['status'] === 'active' ? 'paused' : 'active';
            $conn->query("UPDATE jobs SET status='$newStatus' WHERE id=$id AND employer_id={$this->employerId}");
        }
        header('Location: ' . SITE_URL . '/employer/jobs');
        exit;
    }

    /* ── DELETE JOB ───────────────────────────────────── */
    public function delete(int $id): void {
        $conn = $GLOBALS['conn'];
        // Verify ownership, then delete (applications cascade if FK set, else delete manually)
        $job = $conn->query("SELECT id FROM jobs WHERE id=$id AND employer_id={$this->employerId} LIMIT 1")->fetch_assoc();
        if ($job) {
            $conn->query("DELETE FROM applications WHERE job_id=$id");
            $conn->query("DELETE FROM jobs WHERE id=$id AND employer_id={$this->employerId}");
        }
        header('Location: ' . SITE_URL . '/employer/jobs');
        exit;
    }

    /* ── PRIVATE: shared save logic ──────────────────── */
    private function saveJob($conn, ?int $id): array {
        $title       = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');
        $error = $success = '';
        $old   = $_POST;

        if (!$title || !$description) {
            return ['Job title and description are required.', '', $old];
        }

        $category_id       = (int)($_POST['category_id']       ?? 0) ?: 'NULL';
        $job_type          = $conn->real_escape_string(trim($_POST['job_type']          ?? 'full_time'));
        $experience_level  = $conn->real_escape_string(trim($_POST['experience_level']  ?? ''));
        $location_city     = $conn->real_escape_string(trim($_POST['location_city']     ?? ''));
        $location_country  = $conn->real_escape_string(trim($_POST['location_country']  ?? ''));
        $is_remote         = isset($_POST['is_remote']) ? 1 : 0;
        $salary_min        = (int)($_POST['salary_min'] ?? 0);
        $salary_max        = (int)($_POST['salary_max'] ?? 0);
        $salary_currency   = $conn->real_escape_string(trim($_POST['salary_currency']   ?? 'USD'));
        $deadline          = $conn->real_escape_string(trim($_POST['deadline'] ?? ''));
        $deadline_val      = $deadline ? "'$deadline'" : 'NULL';
        $status            = $conn->real_escape_string(trim($_POST['status'] ?? 'active'));
        $is_featured       = isset($_POST['is_featured']) ? 1 : 0;
        $requirements      = $conn->real_escape_string(trim($_POST['requirements']      ?? ''));
        $benefits          = $conn->real_escape_string(trim($_POST['benefits']          ?? ''));
        $title_esc         = $conn->real_escape_string($title);
        $desc_esc          = $conn->real_escape_string($description);
        $cat_val           = is_int($category_id) ? $category_id : 'NULL';

        // Image upload
        $job_image = '';
        if (!empty($_FILES['job_image']['name'])) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (in_array($_FILES['job_image']['type'], $allowed) && $_FILES['job_image']['size'] <= 3 * 1024 * 1024) {
                $ext       = pathinfo($_FILES['job_image']['name'], PATHINFO_EXTENSION);
                $job_image = 'job_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $dir       = BASE_PATH . '/public/uploads/jobs/';
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                move_uploaded_file($_FILES['job_image']['tmp_name'], $dir . $job_image);
            }
        }

        if ($id) {
            // UPDATE
            $imgClause = $job_image ? ", job_image='$job_image'" : '';
            $conn->query("
                UPDATE jobs SET
                    title='$title_esc', description='$desc_esc',
                    category_id=$cat_val, job_type='$job_type',
                    experience_level='$experience_level',
                    location_city='$location_city', location_country='$location_country',
                    is_remote=$is_remote, salary_min=$salary_min, salary_max=$salary_max,
                    salary_currency='$salary_currency',
                    deadline=$deadline_val,
                    status='$status', is_featured=$is_featured,
                    requirements='$requirements', benefits='$benefits'
                    $imgClause
                WHERE id=$id AND employer_id={$this->employerId}
            ");
            $success = 'Job updated successfully.';
            $old = [];
        } else {
            // INSERT
            $img_val = $job_image ? "'$job_image'" : 'NULL';
            $conn->query("
                INSERT INTO jobs (employer_id, title, description, category_id, job_type,
                    experience_level, location_city, location_country, is_remote,
                    salary_min, salary_max, salary_currency, deadline,
                    status, is_featured, requirements, benefits, job_image, created_at)
                VALUES ({$this->employerId}, '$title_esc', '$desc_esc', $cat_val, '$job_type',
                    '$experience_level', '$location_city', '$location_country', $is_remote,
                    $salary_min, $salary_max, '$salary_currency', $deadline_val,
                    '$status', $is_featured, '$requirements', '$benefits', $img_val, NOW())
            ");
            $success = 'Job posted successfully!';
            $old = [];
        }

        return [$error, $success, $old];
    }
}
