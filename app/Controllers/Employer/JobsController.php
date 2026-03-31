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
            'pageTitle'  => 'My Jobs',
            'activePage' => '',
            'jobs'       => $jobs,
            'search'     => $search,
            'status'     => $status,
            'sort'       => $sort,
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
        $job  = $conn->query("SELECT status FROM jobs WHERE id=$id AND employer_id={$this->employerId} LIMIT 1")->fetch_assoc();
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
        $job  = $conn->query("SELECT id FROM jobs WHERE id=$id AND employer_id={$this->employerId} LIMIT 1")->fetch_assoc();
        if ($job) {
            $conn->query("DELETE FROM applications WHERE job_id=$id");
            $conn->query("DELETE FROM jobs WHERE id=$id AND employer_id={$this->employerId}");
        }
        header('Location: ' . SITE_URL . '/employer/jobs');
        exit;
    }

    /* ═══════════════════════════════════════════════════
       PRIVATE HELPERS
    ═══════════════════════════════════════════════════ */

    /**
     * Generate a URL-safe slug from a title and guarantee it is
     * unique in the jobs table.  Pass $excludeId when editing so
     * the current row does not conflict with itself.
     */
    private function makeSlug(mysqli $conn, string $title, ?int $excludeId = null): string {
        // 1. Basic slug conversion
        $slug = mb_strtolower(trim($title), 'UTF-8');
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);  // keep only a-z 0-9 space hyphen
        $slug = preg_replace('/[\s-]+/', '-', $slug);         // collapse spaces/hyphens
        $slug = trim($slug, '-');                             // strip leading/trailing hyphens

        // 2. Hard fallback if title was entirely non-latin characters
        if ($slug === '') {
            $slug = 'job';
        }

        // 3. Enforce max length (most slug columns are varchar 255)
        $slug = substr($slug, 0, 200);

        // 4. Ensure uniqueness — append -2, -3 … until free
        $base   = $slug;
        $suffix = 1;
        while (true) {
            $safe   = $conn->real_escape_string($slug);
            $excl   = $excludeId ? "AND id != $excludeId" : '';
            $result = $conn->query("SELECT id FROM jobs WHERE slug = '$safe' $excl LIMIT 1");
            if (!$result || $result->num_rows === 0) {
                break;          // slug is free
            }
            $suffix++;
            $slug = $base . '-' . $suffix;
        }

        return $slug;
    }

    /* ── Shared INSERT / UPDATE logic ─────────────────── */
    private function saveJob(mysqli $conn, ?int $id): array {
        $title       = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');
        $error = $success = '';
        $old   = $_POST;

        if (!$title || !$description) {
            return ['Job title and description are required.', '', $old];
        }

        // ── Generate unique slug ───────────────────────
        $slug = $this->makeSlug($conn, $title, $id);
        $slug_esc = $conn->real_escape_string($slug);

        // ── Sanitise all other fields ──────────────────
        $category_id      = (int)($_POST['category_id']      ?? 0);
        $cat_val          = $category_id > 0 ? $category_id : 'NULL';
        $job_type         = $conn->real_escape_string(trim($_POST['job_type']         ?? 'full_time'));
        $experience_level = $conn->real_escape_string(trim($_POST['experience_level'] ?? ''));
        $location_city    = $conn->real_escape_string(trim($_POST['location_city']    ?? ''));
        $location_country = $conn->real_escape_string(trim($_POST['location_country'] ?? ''));
        $is_remote        = isset($_POST['is_remote']) ? 1 : 0;
        $salary_min       = (int)($_POST['salary_min'] ?? 0);
        $salary_max       = (int)($_POST['salary_max'] ?? 0);
        $salary_currency  = $conn->real_escape_string(trim($_POST['salary_currency']  ?? 'USD'));
        $deadline         = $conn->real_escape_string(trim($_POST['deadline']         ?? ''));
        $deadline_val     = $deadline ? "'$deadline'" : 'NULL';
        $status           = $conn->real_escape_string(trim($_POST['status']           ?? 'active'));
        $is_featured      = isset($_POST['is_featured']) ? 1 : 0;
        $requirements     = $conn->real_escape_string(trim($_POST['requirements']     ?? ''));
        $benefits         = $conn->real_escape_string(trim($_POST['benefits']         ?? ''));
        $title_esc        = $conn->real_escape_string($title);
        $desc_esc         = $conn->real_escape_string($description);

        // ── Image upload ───────────────────────────────
        $job_image = '';
        if (!empty($_FILES['job_image']['name'])) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (in_array($_FILES['job_image']['type'], $allowed)
                && $_FILES['job_image']['size'] <= 3 * 1024 * 1024) {
                $ext       = pathinfo($_FILES['job_image']['name'], PATHINFO_EXTENSION);
                $job_image = 'job_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $dir       = BASE_PATH . '/public/uploads/jobs/';
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                move_uploaded_file($_FILES['job_image']['tmp_name'], $dir . $job_image);
            }
        }

        if ($id) {
            // ── UPDATE ────────────────────────────────
            // Only update slug if title changed (avoids pointless churn)
            $imgClause  = $job_image ? ", job_image='$job_image'" : '';
            $conn->query("
                UPDATE jobs SET
                    title            = '$title_esc',
                    slug             = '$slug_esc',
                    description      = '$desc_esc',
                    category_id      = $cat_val,
                    job_type         = '$job_type',
                    experience_level = '$experience_level',
                    location_city    = '$location_city',
                    location_country = '$location_country',
                    is_remote        = $is_remote,
                    salary_min       = $salary_min,
                    salary_max       = $salary_max,
                    salary_currency  = '$salary_currency',
                    deadline         = $deadline_val,
                    status           = '$status',
                    is_featured      = $is_featured,
                    requirements     = '$requirements',
                    benefits         = '$benefits'
                    $imgClause
                WHERE id = $id AND employer_id = {$this->employerId}
            ");
            $success = 'Job updated successfully.';
            $old     = [];

        } else {
            // ── INSERT ────────────────────────────────
            $img_val = $job_image ? "'$job_image'" : 'NULL';
            $conn->query("
                INSERT INTO jobs (
                    employer_id, title, slug, description,
                    category_id, job_type, experience_level,
                    location_city, location_country, is_remote,
                    salary_min, salary_max, salary_currency,
                    deadline, status, is_featured,
                    requirements, benefits, job_image, created_at
                ) VALUES (
                    {$this->employerId}, '$title_esc', '$slug_esc', '$desc_esc',
                    $cat_val, '$job_type', '$experience_level',
                    '$location_city', '$location_country', $is_remote,
                    $salary_min, $salary_max, '$salary_currency',
                    $deadline_val, '$status', $is_featured,
                    '$requirements', '$benefits', $img_val, NOW()
                )
            ");
            $success = 'Job posted successfully!';
            $old     = [];
        }

        return [$error, $success, $old];
    }
}