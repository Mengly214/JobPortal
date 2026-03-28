<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- ======================================================
     PAGE HERO
====================================================== -->
<div class="jg-page-hero">
    <div class="jg-page-hero__photo"></div>
    <div class="jg-page-hero__overlay"></div>
    <div class="container jg-page-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <span>My Applications</span>
        </div>
        <h1 class="jg-page-hero__title">My Applications</h1>
        <p class="jg-page-hero__sub">Track every application, status, and deadline in one place.</p>
    </div>
</div>

<!-- ======================================================
     FILTER BAR
====================================================== -->
<div class="jg-filterbar-wrap">
    <div class="container">
        <form action="<?= SITE_URL ?>/seeker/applications" method="GET" class="jg-filterbar">
            <div class="jg-filterbar__field jg-filterbar__field--grow">
                <i class="fa fa-search"></i>
                <input type="text" name="search" placeholder="Search job or company..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="jg-filterbar__sep"></div>
            <div class="jg-filterbar__field jg-filterbar__field--select">
                <i class="fa fa-filter"></i>
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="submitted" <?= (($_GET['status'] ?? '') === 'submitted') ? 'selected' : '' ?>>Application Received</option>
                    <option value="reviewing" <?= (($_GET['status'] ?? '') === 'reviewing') ? 'selected' : '' ?>>In Review</option>
                    <option value="hired" <?= (($_GET['status'] ?? '') === 'hired')     ? 'selected' : '' ?>>Hired</option>
                    <option value="rejected" <?= (($_GET['status'] ?? '') === 'rejected')  ? 'selected' : '' ?>>Rejected</option>
                </select>
            </div>
            <button type="submit" class="jg-filterbar__btn">
                <i class="fa fa-search"></i> Filter
            </button>
            <?php if (!empty($_GET['search']) || !empty($_GET['status'])): ?>
                <a href="<?= SITE_URL ?>/seeker/applications" class="jg-filterbar__clear" title="Clear filters">
                    <i class="fa fa-times"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- ======================================================
     MAIN CONTENT
====================================================== -->
<section class="jg-apps-section">
    <div class="container">

        <?php if (empty($data['applications'])): ?>
            <div class="jg-empty">
                <div class="jg-empty__icon"><i class="fa fa-file-text-o"></i></div>
                <h3>No Applications Yet</h3>
                <p>You haven't applied to any jobs yet. Start exploring opportunities!</p>
                <a href="<?= SITE_URL ?>/jobs" class="jg-btn jg-btn--primary" style="margin-top:16px;">
                    <i class="fa fa-search"></i> Browse Jobs
                </a>
            </div>

        <?php else: ?>

            <!-- Results bar -->
            <div class="jg-results-bar">
                <p class="jg-results-bar__count">
                    Showing <strong><?= count($data['applications']) ?></strong> application(s)
                </p>
            </div>

            <!-- Table -->
            <div class="jg-apps-table-wrap js-reveal">
                <table class="jg-apps-table">
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
                        <?php
                        $i = 0;
                        foreach ($data['applications'] as $app):
                            $accentClass = ($i % 2 == 0) ? 'accent-yellow' : 'accent-blue';
                            $i++;

                            $status = $app['status'];
                            $statusClass = match ($status) {
                                'submitted'            => 'status-teal',
                                'reviewing'            => 'status-blue',
                                'hired'                => 'status-green',
                                'rejected', 'withdrawn' => 'status-red',
                                default                => 'status-gray'
                            };
                            $displayStatus = match ($status) {
                                'submitted' => 'Received',
                                'reviewing' => 'In Review',
                                'hired'     => 'Hired',
                                'rejected'  => 'Rejected',
                                'withdrawn' => 'Withdrawn',
                                default     => ucfirst($status)
                            };

                            // Deadline
                            $deadlineStr   = $app['application_deadline'] ?? null;
                            $deadlineLabel = '';
                            $deadlineClass = '';
                            if ($deadlineStr) {
                                $today       = new DateTime();
                                $deadlineObj = new DateTime($deadlineStr);
                                $daysLeft    = (int)$today->diff($deadlineObj)->format('%r%a');
                                if ($daysLeft < 0) {
                                    $deadlineLabel = 'Expired';
                                    $deadlineClass = 'dl-red';
                                } elseif ($daysLeft <= 7) {
                                    $deadlineLabel = $daysLeft . ' day' . ($daysLeft === 1 ? '' : 's') . ' left';
                                    $deadlineClass = 'dl-red';
                                } else {
                                    $deadlineLabel = $daysLeft . ' days left';
                                    $deadlineClass = 'dl-green';
                                }
                            }
                        ?>
                            <tr class="<?= $accentClass ?>">

                                <!-- Job -->
                                <td>
                                    <strong class="job-title"><?= htmlspecialchars($app['job_title']) ?></strong>
                                    <a href="<?= SITE_URL ?>/jobs/<?= $app['job_id'] ?? 0 ?>" class="job-link">
                                        <i class="fa fa-external-link"></i> View job
                                    </a>
                                </td>

                                <!-- Company -->
                                <td>
                                    <div class="company-cell">
                                        <?php if (!empty($app['company_logo'])): ?>
                                            <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($app['company_logo']) ?>"
                                                class="company-logo" alt="">
                                        <?php else: ?>
                                            <div class="company-initial">
                                                <?= strtoupper(substr($app['company_name'] ?? 'C', 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                        <span><?= htmlspecialchars($app['company_name'] ?? 'N/A') ?></span>
                                    </div>
                                </td>

                                <!-- Applied -->
                                <td>
                                    <span class="date-text">
                                        <?= date('d M, Y', strtotime($app['applied_at'] ?? $app['created_at'])) ?>
                                    </span>
                                </td>

                                <!-- Deadline -->
                                <td>
                                    <?php if ($deadlineStr): ?>
                                        <span class="date-text"><?= date('d M, Y', strtotime($deadlineStr)) ?></span>
                                        <span class="dl-badge <?= $deadlineClass ?>"><?= $deadlineLabel ?></span>
                                    <?php else: ?>
                                        <span class="date-text" style="color:#ccc;">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Status -->
                                <td>
                                    <span class="status-pill <?= $statusClass ?>"><?= $displayStatus ?></span>
                                </td>

                                <!-- Actions -->
                                <td>
                                    <form action="<?= SITE_URL ?>/seeker/withdraw" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to withdraw this application? This cannot be undone.');">
                                        <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 12px;">
                                            <i class="fa fa-times"></i> Withdraw
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>
</section>

<script>
    (function() {
        var els = document.querySelectorAll('.js-reveal');
        if ('IntersectionObserver' in window) {
            var obs = new IntersectionObserver(function(entries) {
                entries.forEach(function(e) {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        obs.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.08
            });
            els.forEach(function(el) {
                obs.observe(el);
            });
        } else {
            els.forEach(function(el) {
                el.classList.add('visible');
            });
        }

        var ph = document.querySelector('.jg-page-hero__photo');
        if (ph) {
            window.addEventListener('scroll', function() {
                ph.style.transform = 'scale(1.03) translateY(' + (window.scrollY * .06) + 'px)';
            }, {
                passive: true
            });
        }
    })();
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>