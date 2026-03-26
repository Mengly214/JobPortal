<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<style>
    /* Table */
    .table-container {
        background: #ffffff;
        border-radius: var(--jg-radius);
        border: 1px solid var(--jg-border);
        box-shadow: var(--jg-shadow);
        overflow: hidden;
    }

    .custom-table th {
        background-color: var(--jg-gray);
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--jg-border);
    }

    .custom-table td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid var(--jg-border);
        color: #64748b;
        font-size: 14px;
    }

    /* Row left-border colors */
    .row-border-yellow { border-left: 4px solid #f59e0b; }
    .row-border-blue   { border-left: 4px solid var(--jg-primary); }

    /* Action buttons */
    .action-btn {
        background: white;
        border: 1px solid var(--jg-border);
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: 0.2s;
        margin-right: 4px;
        margin-bottom: 4px;
        cursor: pointer;
    }
    .action-btn:hover {
        background: var(--jg-gray);
        color: var(--jg-dark);
        text-decoration: none;
        border-color: #c0cfe0;
    }
    .action-btn i { font-size: 11px; }

    .btn-withdraw-outline {
        border-color: #fca5a5;
        color: #ef4444;
    }
    .btn-withdraw-outline:hover {
        background: #fef2f2;
        border-color: #ef4444;
        color: #dc2626;
    }

    /* Status badges */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }
    .bg-teal      { background-color: #14a077; }
    .bg-blue      { background-color: var(--jg-primary); }
    .bg-success   { background-color: #2e7d32; }
    .bg-danger    { background-color: #e53935; }
    .bg-secondary { background-color: #888; }

    /* Deadline badges */
    .deadline-badge {
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        margin-top: 4px;
    }
    .deadline-red   { background: #fef2f2; color: #ef4444; }
    .deadline-green { background: #e8f5e9; color: #2e7d32; }
</style>

<!-- Hero -->
<div class="jg-page-hero">
    <div class="container">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <span>My Applications</span>
        </div>
        <h1>My Applications</h1>
        <p>Track every application, status, and deadline in one place.</p>
    </div>
</div>

<div class="jg-section">
    <div class="container">

        <!-- Filter -->
        <div class="jg-filter-box" style="margin-bottom:30px;">
            <form action="<?= SITE_URL ?>/seeker/applications" method="GET">
                <div class="jg-filter-box__row">
                    <div class="jg-filter-field jg-filter-field--wide">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search"
                               placeholder="Search job or company..."
                               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="jg-filter-field">
                        <i class="fa fa-filter"></i>
                        <select name="status">
                            <option value="">All statuses</option>
                            <option value="submitted" <?= (($_GET['status'] ?? '') === 'submitted') ? 'selected' : '' ?>>Application Received</option>
                            <option value="reviewing" <?= (($_GET['status'] ?? '') === 'reviewing') ? 'selected' : '' ?>>In Review</option>
                            <option value="hired"     <?= (($_GET['status'] ?? '') === 'hired')     ? 'selected' : '' ?>>Hired</option>
                            <option value="rejected"  <?= (($_GET['status'] ?? '') === 'rejected')  ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="jg-btn jg-btn--primary">
                        <i class="fa fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table custom-table mb-0">
                    <thead>
                        <tr>
                            <th>Job</th>
                            <th>Company</th>
                            <th>Applied</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['applications'])): ?>
                            <?php
                            $i = 0;
                            foreach ($data['applications'] as $app):
                                $borderClass = ($i % 2 == 0) ? 'row-border-yellow' : 'row-border-blue';
                                $i++;

                                $status = $app['status'];
                                $statusClass = match ($status) {
                                    'submitted'            => 'bg-teal',
                                    'reviewing'            => 'bg-blue',
                                    'hired'                => 'bg-success',
                                    'rejected','withdrawn' => 'bg-danger',
                                    default                => 'bg-secondary'
                                };
                                $displayStatus = match ($status) {
                                    'submitted' => 'Application Received',
                                    'reviewing' => 'In Review',
                                    'hired'     => 'Hired',
                                    'rejected'  => 'Rejected',
                                    'withdrawn' => 'Withdrawn',
                                    default     => ucfirst($status)
                                };

                                // Deadline calculation
                                $deadlineStr   = $app['deadline'] ?? null;
                                $deadlineLabel = '';
                                $deadlineBadge = '';
                                if ($deadlineStr) {
                                    $today       = new DateTime();
                                    $deadlineObj = new DateTime($deadlineStr);
                                    $diff        = $today->diff($deadlineObj);
                                    $daysLeft    = (int)$diff->format('%r%a');
                                    if ($daysLeft < 0) {
                                        $deadlineLabel = 'Expired';
                                        $deadlineBadge = 'deadline-red';
                                    } elseif ($daysLeft <= 7) {
                                        $deadlineLabel = $daysLeft . ' day' . ($daysLeft === 1 ? '' : 's') . ' left';
                                        $deadlineBadge = 'deadline-red';
                                    } else {
                                        $deadlineLabel = $daysLeft . ' days left';
                                        $deadlineBadge = 'deadline-green';
                                    }
                                }
                            ?>
                            <tr class="<?= $borderClass ?>">

                                <td>
                                    <strong style="color:var(--jg-dark);display:block;margin-bottom:2px;">
                                        <?= htmlspecialchars($app['job_title']) ?>
                                    </strong>
                                    <a href="<?= SITE_URL ?>/jobs/view/<?= $app['job_id'] ?? 0 ?>"
                                       style="color:var(--jg-primary);font-size:13px;text-decoration:none;">
                                        View job
                                    </a>
                                </td>

                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <?php if (!empty($app['company_logo'])): ?>
                                            <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($app['company_logo']) ?>"
                                                 alt="<?= htmlspecialchars($app['company_name'] ?? '') ?>"
                                                 style="width:38px;height:38px;border-radius:8px;object-fit:cover;border:1px solid var(--jg-border);flex-shrink:0;">
                                        <?php else: ?>
                                            <div style="width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,var(--jg-primary),#0a9acc);color:#fff;font-size:15px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <?= strtoupper(substr($app['company_name'] ?? 'C', 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                        <span><?= htmlspecialchars($app['company_name'] ?? 'Company Name') ?></span>
                                    </div>
                                </td>

                                <td>
                                    <span style="color:#94a3b8;">
                                        <?= date('d M, Y', strtotime($app['applied_at'] ?? $app['created_at'])) ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if ($deadlineStr): ?>
                                        <span style="color:#94a3b8;display:block;">
                                            <?= date('d M, Y', strtotime($deadlineStr)) ?>
                                        </span>
                                        <span class="deadline-badge <?= $deadlineBadge ?>">
                                            <?= $deadlineLabel ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color:#cbd5e1;">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="status-badge <?= $statusClass ?>"><?= $displayStatus ?></span>
                                </td>

                                <td>
                                    <?php if (!empty($app['cv_file'])): ?>
                                    <a href="<?= SITE_URL ?>/uploads/cvs/<?= htmlspecialchars($app['cv_file']) ?>"
                                       download class="action-btn">
                                        <i class="fa fa-download"></i> Resume
                                    </a>
                                    <?php endif; ?>

                                    <a href="<?= SITE_URL ?>/jobs/view/<?= $app['job_id'] ?? 0 ?>" class="action-btn">
                                        <i class="fa fa-eye"></i> View
                                    </a>

                                    <?php if (in_array($status, ['submitted', 'reviewing', 'shortlisted'])): ?>
                                    <form action="<?= SITE_URL ?>/applications/cancel/<?= $app['id'] ?>"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to withdraw this application?');"
                                          style="display:inline;">
                                        <button type="submit" class="action-btn btn-withdraw-outline">
                                            <i class="fa fa-times"></i> Withdraw
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    <div class="jg-empty">
                                        <i class="fa fa-file-text-o"></i>
                                        <h3>No Applications Yet</h3>
                                        <p>You haven't applied to any jobs yet.</p>
                                        <a href="<?= SITE_URL ?>/jobs" class="jg-btn jg-btn--primary" style="margin-top:12px;">
                                            Browse Jobs
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>