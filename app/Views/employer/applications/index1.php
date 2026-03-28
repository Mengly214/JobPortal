<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Optional: custom blue colors for status badges */
    .status-submitted { background-color: #6c757d; } /* gray */
    .status-reviewing { background-color: #0dcaf0; color: #000; } /* cyan */
    .status-shortlisted { background-color: #0d6efd; } /* primary blue */
    .status-interview { background-color: #0d6efd; color: #fff; } /* blue */
    .status-offered { background-color: #198754; } /* green */
    .status-hired { background-color: #0d6efd; } /* blue */
    .status-rejected { background-color: #dc3545; } /* red */
    .status-withdrawn { background-color: #343a40; } /* dark */
</style>

<div class="container my-5">
    <h1 class="mb-4 text-primary"><?= $pageTitle ?></h1>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Applicant</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Applied At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><?= $app['id'] ?></td>
                        <td><?= htmlspecialchars($app['applicant_name']) ?></td>
                        <td><?= htmlspecialchars($app['applicant_email']) ?></td>
                        <td><?= htmlspecialchars($app['job_title']) ?></td>
                        <td>
                            <span class="badge 
                                <?php
                                    switch ($app['status']) {
                                        case 'submitted': echo 'status-submitted'; break;
                                        case 'reviewing': echo 'status-reviewing'; break;
                                        case 'shortlisted': echo 'status-shortlisted'; break;
                                        case 'interview': echo 'status-interview'; break;
                                        case 'offered': echo 'status-offered'; break;
                                        case 'hired': echo 'status-hired'; break;
                                        case 'rejected': echo 'status-rejected'; break;
                                        case 'withdrawn': echo 'status-withdrawn'; break;
                                        default: echo 'bg-light text-dark';
                                    }
                                ?>
                            "><?= ucfirst($app['status']) ?></span>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($app['applied_at'])) ?></td>
                        <td>
                            <a href="<?= SITE_URL ?>/employer/applications/show/<?= $app['id'] ?>" class="btn btn-sm btn-outline-primary mb-1">View</a>
                            <form action="<?= SITE_URL ?>/employer/applications/updateStatus" method="POST" class="d-inline">
                                <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                <select name="status" class="form-select form-select-sm d-inline w-auto mb-1">
                                    <option value="submitted">Submitted</option>
                                    <option value="reviewing">Reviewing</option>
                                    <option value="shortlisted">Shortlisted</option>
                                    <option value="interview">Interview</option>
                                    <option value="offered">Offered</option>
                                    <option value="hired">Hired</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="withdrawn">Withdrawn</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary mb-1">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>