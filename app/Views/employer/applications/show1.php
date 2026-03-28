<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">
    <h1 class="mb-4 text-primary"><?= $pageTitle ?></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Applicant: <?= htmlspecialchars($application['applicant_name']) ?></h5>
            <p>Email: <?= htmlspecialchars($application['applicant_email']) ?></p>
            <p>Job Title: <?= htmlspecialchars($application['job_title']) ?></p>
            <p>Status: <span class="badge <?= 'status-' . $application['status'] ?>"><?= ucfirst($application['status']) ?></span></p>
            <p>Applied At: <?= date('d M Y H:i', strtotime($application['applied_at'])) ?></p>
            <p>Cover Letter:</p>
            <div class="border p-3"><?= nl2br(htmlspecialchars($application['cover_letter'])) ?></div>
        </div>
    </div>

    <a href="<?= SITE_URL ?>/employer/applications" class="btn btn-primary mt-3">Back to Applications</a>
</div>