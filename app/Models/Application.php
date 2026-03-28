<?php
require_once BASE_PATH . '/core/Model.php';

class Application extends Model
{
    // Check if user already applied
    public function alreadyApplied(int $jobId, int $userId): bool
    {
        $stmt = $this->conn->prepare("SELECT id FROM applications WHERE job_id=? AND applicant_id=?");
        $stmt->bind_param('ii', $jobId, $userId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Create application
    public function create(int $jobId, int $userId, string $cover): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO applications (job_id, applicant_id, cover_letter, status, applied_at) VALUES (?,?,?, 'submitted', NOW())");
        $stmt->bind_param('iis', $jobId, $userId, $cover);
        return $stmt->execute();
    }

    // Get applications for employer
    public function getByEmployer(int $employerId): array
    {
        $stmt = $this->conn->prepare("
            SELECT a.*, 
                   j.title AS job_title,
                   u.full_name AS applicant_name,
                   u.email AS applicant_email
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN users u ON a.applicant_id = u.id
            WHERE j.employer_id = ?
            ORDER BY a.applied_at DESC
        ");
        $stmt->bind_param('i', $employerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Find single application
    public function find(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT a.*, 
                   j.title AS job_title,
                   u.full_name AS applicant_name,
                   u.email AS applicant_email
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            JOIN users u ON a.applicant_id = u.id
            WHERE a.id = ?
            LIMIT 1
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    // Update status
    public function updateStatus(int $id, string $status): bool
    {
        $allowed = ['submitted', 'reviewing', 'shortlisted', 'interview', 'offered', 'hired', 'rejected', 'withdrawn'];
        if (!in_array($status, $allowed)) return false;

        $stmt = $this->conn->prepare("UPDATE applications SET status=? WHERE id=?");
        $stmt->bind_param('si', $status, $id);
        return $stmt->execute();
    }

    // Count total applications
    public function countByEmployer(int $employerId): int
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) AS c
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE j.employer_id = ?
        ");
        $stmt->bind_param('i', $employerId);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['c'];
    }

    // Count new applications
    public function countNewByEmployer(int $employerId): int
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) AS c
            FROM applications a
            JOIN jobs j ON a.job_id = j.id
            WHERE j.employer_id = ? AND a.status='submitted'
        ");
        $stmt->bind_param('i', $employerId);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['c'];
    }

        public function count(): int
    {
        return (int)$this->conn->query("SELECT COUNT(*) c FROM applications")->fetch_assoc()['c'];
    }

    public function countNew(): int
    {
        return (int)$this->conn->query("SELECT COUNT(*) c FROM applications WHERE status='submitted'")->fetch_assoc()['c'];
    }

    public function recent(int $limit = 8): array
    {
        return $this->conn->query("SELECT a.*, j.title AS job_title, j.application_deadline, u.email AS applicant_email, ep.company_name, ep.logo AS company_logo
        FROM applications a 
        JOIN jobs j ON a.job_id=j.id 
        JOIN users u ON a.applicant_id=u.id 
        LEFT JOIN employer_profiles ep ON j.employer_id=ep.user_id 
        ORDER BY a.applied_at DESC LIMIT $limit")->fetch_all(MYSQLI_ASSOC);
    }
    // Add these to your Application class
    public function countBySeeker(int $userId): int
    {
        $s = $this->conn->prepare("SELECT COUNT(*) as c FROM applications WHERE applicant_id = ?");
        $s->bind_param('i', $userId);
        $s->execute();
        return (int)$s->get_result()->fetch_assoc()['c'];
    }

    public function recentBySeeker(int $userId, int $limit = 3): array
    {
        $s = $this->conn->prepare("SELECT a.*, j.title AS job_title, j.application_deadline, ep.company_name, ep.logo AS company_logo
        FROM applications a 
        JOIN jobs j ON a.job_id = j.id 
        LEFT JOIN employer_profiles ep ON j.employer_id=ep.user_id
        WHERE a.applicant_id = ? 
        ORDER BY a.applied_at DESC 
        LIMIT ?");
        $s->bind_param('ii', $userId, $limit);
        $s->execute();
        return $s->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Add this inside your Application model class
    public function withdraw(int $applicationId, int $seekerId): bool
    {
        // We changed 'seeker_id' to 'applicant_id' right here!
        $sql = "DELETE FROM applications WHERE id = ? AND applicant_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $applicationId, $seekerId);

        return $stmt->execute();
    }
}