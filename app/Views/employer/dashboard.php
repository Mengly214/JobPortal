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
            <span>Employer Dashboard</span>
        </div>
        <h1 class="jg-page-hero__title">
            Welcome back, <?= htmlspecialchars($ep['company_name'] ?? $ep['full_name'] ?? 'Employer') ?>!
        </h1>
        <p class="jg-page-hero__sub">Manage your job listings and track applicants all in one place.</p>
    </div>
</div>

<!-- ======================================================
     MAIN CONTENT
====================================================== -->
<section class="emp-dash-section">
<div class="container">

    <?php if ($newApps > 0): ?>
    <div class="emp-alert">
        <i class="fa fa-bell"></i>
        You have <strong><?= $newApps ?></strong> new application<?= $newApps > 1 ? 's' : '' ?> waiting for review.
        <a href="<?= SITE_URL ?>/employer/applications">Review now &rarr;</a>
    </div>
    <?php endif; ?>

    <!-- ── STAT CARDS ── -->
    <div class="row emp-stats">
        <div class="col-md-3 col-sm-6">
            <div class="emp-stat-card emp-stat-card--blue">
                <div class="emp-stat-card__icon"><i class="fa fa-briefcase"></i></div>
                <div class="emp-stat-card__info">
                    <strong><?= $activeJobs ?></strong>
                    <span>Active Jobs</span>
                </div>
                <a href="<?= SITE_URL ?>/employer/jobs" class="emp-stat-card__link"></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="emp-stat-card emp-stat-card--teal">
                <div class="emp-stat-card__icon"><i class="fa fa-file-text"></i></div>
                <div class="emp-stat-card__info">
                    <strong><?= $totalApps ?></strong>
                    <span>Total Applications</span>
                </div>
                <a href="<?= SITE_URL ?>/employer/applications" class="emp-stat-card__link"></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="emp-stat-card emp-stat-card--green">
                <div class="emp-stat-card__icon"><i class="fa fa-eye"></i></div>
                <div class="emp-stat-card__info">
                    <strong><?= number_format($totalViews) ?></strong>
                    <span>Total Job Views</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="emp-stat-card emp-stat-card--orange">
                <div class="emp-stat-card__icon"><i class="fa fa-check-circle"></i></div>
                <div class="emp-stat-card__info">
                    <strong><?= $hiredApps ?></strong>
                    <span>Hired</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ── QUICK ACTIONS ── -->
    <div class="emp-quick-actions">
        <a href="<?= SITE_URL ?>/employer/jobs/create" class="jg-btn jg-btn--primary">
            <i class="fa fa-plus-circle"></i> Post a New Job
        </a>
        <a href="<?= SITE_URL ?>/employer/jobs" class="jg-btn jg-btn--outline">
            <i class="fa fa-list"></i> My Jobs
        </a>
        <a href="<?= SITE_URL ?>/employer/applications" class="jg-btn jg-btn--outline">
            <i class="fa fa-file-text"></i> Applications
            <?php if ($newApps > 0): ?>
            <span class="emp-badge-pill"><?= $newApps ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= SITE_URL ?>/employer/profile" class="jg-btn jg-btn--outline">
            <i class="fa fa-building"></i> Company Profile
        </a>
    </div>

    <div class="row">

        <!-- ── LEFT: Recent Jobs ── -->
        <div class="col-md-7">
            <div class="emp-card">
                <div class="emp-card__head">
                    <h4><i class="fa fa-briefcase"></i> My Recent Jobs</h4>
                    <a href="<?= SITE_URL ?>/employer/jobs" class="emp-card__head-link">View All</a>
                </div>

                <?php if (empty($recentJobs)): ?>
                <div class="emp-empty">
                    <i class="fa fa-briefcase"></i>
                    <p>You haven't posted any jobs yet.</p>
                    <a href="<?= SITE_URL ?>/employer/post-job" class="jg-btn jg-btn--primary jg-btn--sm">
                        <i class="fa fa-plus"></i> Post Your First Job
                    </a>
                </div>
                <?php else: ?>
                <table class="emp-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Type</th>
                            <th>Applications</th>
                            <th>Status</th>
                            <th>Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentJobs as $job):
                            $appCount = (int)$GLOBALS['conn']->query("SELECT COUNT(*) c FROM applications WHERE job_id={$job['id']}")->fetch_assoc()['c'];
                            $statusClass = match($job['status']) {
                                'active' => 'pill-green',
                                'draft'  => 'pill-gray',
                                'closed' => 'pill-red',
                                'paused' => 'pill-orange',
                                default  => 'pill-gray'
                            };
                        ?>
                        <tr>
                            <td>
                                <strong class="job-name"><?= htmlspecialchars($job['title']) ?></strong>
                                <div class="job-meta-small">
                                    <i class="fa fa-map-marker"></i> <?= htmlspecialchars($job['location_city'] ?? 'Remote') ?>
                                </div>
                            </td>
                            <td><span class="jg-badge jg-badge--<?= str_replace('_','-',$job['job_type'] ?? 'full-time') ?>"><?= ucfirst(str_replace('_',' ',$job['job_type'] ?? 'Full Time')) ?></span></td>
                            <td>
                                <a href="<?= SITE_URL ?>/employer/applications?job=<?= $job['id'] ?>" class="app-count">
                                    <i class="fa fa-users"></i> <?= $appCount ?>
                                </a>
                            </td>
                            <td><span class="status-pill <?= $statusClass ?>"><?= ucfirst($job['status']) ?></span></td>
                            <td class="date-col"><?= date('d M Y', strtotime($job['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── RIGHT: Stats + Company ── -->
        <div class="col-md-5">

            <!-- Applications by status -->
            <div class="emp-card" style="margin-bottom:20px;">
                <div class="emp-card__head">
                    <h4><i class="fa fa-bar-chart"></i> Applications Breakdown</h4>
                </div>
                <div class="emp-card__body">
                    <?php if (empty($appsByStatus)): ?>
                    <p style="color:#aaa;font-size:13px;text-align:center;padding:20px 0;">No applications yet.</p>
                    <?php else:
                        $totalA = array_sum(array_column($appsByStatus, 'total'));
                        $colors = [
                            'submitted'  => '#0a65cc',
                            'reviewing'  => '#7c3aed',
                            'shortlisted'=> '#f59e0b',
                            'interview'  => '#f97316',
                            'offered'    => '#14a077',
                            'hired'      => '#16a34a',
                            'rejected'   => '#e53935',
                            'withdrawn'  => '#94a3b8',
                        ];
                        foreach ($appsByStatus as $row):
                            $pct = $totalA > 0 ? round($row['total'] / $totalA * 100) : 0;
                            $col = $colors[$row['status']] ?? '#94a3b8';
                            $label = match($row['status']) {
                                'submitted'   => 'Received',
                                'reviewing'   => 'In Review',
                                'shortlisted' => 'Shortlisted',
                                'interview'   => 'Interview',
                                'offered'     => 'Offered',
                                'hired'       => 'Hired',
                                'rejected'    => 'Rejected',
                                'withdrawn'   => 'Withdrawn',
                                default       => ucfirst($row['status'])
                            };
                    ?>
                    <div class="app-bar-row">
                        <div class="app-bar-label">
                            <span><?= $label ?></span>
                            <strong><?= $row['total'] ?></strong>
                        </div>
                        <div class="app-bar-track">
                            <div class="app-bar-fill" style="width:<?= $pct ?>%;background:<?= $col ?>"></div>
                        </div>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>

            <!-- Company Profile card -->
            <div class="emp-card">
                <div class="emp-card__head">
                    <h4><i class="fa fa-building"></i> Company Profile</h4>
                    <a href="<?= SITE_URL ?>/employer/profile" class="emp-card__head-link">Edit</a>
                </div>
                <div class="emp-card__body emp-profile-summary">
                    <?php if (!empty($ep['logo'])): ?>
                        <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($ep['logo']) ?>" class="emp-profile-logo" alt="">
                    <?php else: ?>
                        <div class="emp-profile-logo-initial">
                            <?= strtoupper(substr($ep['company_name'] ?? 'C', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <strong><?= htmlspecialchars($ep['company_name'] ?? '—') ?></strong>
                        <span><?= htmlspecialchars($ep['industry'] ?? 'Industry not set') ?></span>
                        <?php if (!empty($ep['location_city'])): ?>
                        <span><i class="fa fa-map-marker"></i> <?= htmlspecialchars($ep['location_city']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($ep['website'])): ?>
                        <a href="<?= htmlspecialchars($ep['website']) ?>" target="_blank" class="emp-website">
                            <i class="fa fa-globe"></i> <?= htmlspecialchars($ep['website']) ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="emp-card__footer">
                    <div class="emp-job-counters">
                        <div><strong><?= $totalJobs ?></strong><span>Total Jobs</span></div>
                        <div><strong><?= $activeJobs ?></strong><span>Active</span></div>
                        <div><strong><?= $draftJobs ?></strong><span>Draft</span></div>
                        <div><strong><?= $closedJobs ?></strong><span>Closed</span></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ── Recent Applications ── -->
    <div class="emp-card" style="margin-top:20px;">
        <div class="emp-card__head">
            <h4><i class="fa fa-file-text"></i> Recent Applications</h4>
            <a href="<?= SITE_URL ?>/employer/applications" class="emp-card__head-link">View All</a>
        </div>

        <?php if (empty($recentApps)): ?>
        <div class="emp-empty">
            <i class="fa fa-file-text-o"></i>
            <p>No applications received yet.</p>
        </div>
        <?php else: ?>
        <table class="emp-table">
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Job Applied For</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentApps as $app):
                    $statusClass = match($app['status']) {
                        'submitted'   => 'pill-blue',
                        'reviewing'   => 'pill-purple',
                        'shortlisted' => 'pill-orange',
                        'interview'   => 'pill-orange',
                        'offered'     => 'pill-teal',
                        'hired'       => 'pill-green',
                        'rejected'    => 'pill-red',
                        'withdrawn'   => 'pill-gray',
                        default       => 'pill-gray'
                    };
                    $displayStatus = match($app['status']) {
                        'submitted' => 'Received',
                        'reviewing' => 'In Review',
                        default     => ucfirst($app['status'])
                    };
                ?>
                <tr>
                    <td>
                        <strong class="job-name"><?= htmlspecialchars($app['applicant_name'] ?? $app['applicant_email']) ?></strong>
                        <div class="job-meta-small"><?= htmlspecialchars($app['applicant_email']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($app['job_title']) ?></td>
                    <td class="date-col"><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                    <td><span class="status-pill <?= $statusClass ?>"><?= $displayStatus ?></span></td>
                    <td>
                        <?php if (!empty($app['cv_file'])): ?>
                        <a href="<?= SITE_URL ?>/uploads/resumes/<?= htmlspecialchars($app['cv_file']) ?>"
                           download class="act-btn"><i class="fa fa-download"></i> CV</a>
                        <?php endif; ?>
                        <a href="<?= SITE_URL ?>/employer/applications/<?= $app['id'] ?>" class="act-btn">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

</div>
</section>

<!-- ======================================================
     STYLES
====================================================== -->
<style>
/* ─── PAGE HERO ───────────────────────────────────────── */
.jg-page-hero {
    position: relative; margin-top: -70px;
    padding-top: 150px; padding-bottom: 60px;
    overflow: hidden; min-height: 280px;
    display: flex; align-items: flex-end;
}
.jg-page-hero__photo {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&q=60&fit=crop&crop=top')
                center center / cover no-repeat;
    transform: scale(1.03);
}
.jg-page-hero__overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(5,14,30,.92) 0%, rgba(10,60,130,.84) 60%, rgba(5,14,30,.72) 100%);
}
.jg-page-hero__inner { position: relative; z-index: 2; }
.jg-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: rgba(255,255,255,.55); margin-bottom: 14px; }
.jg-breadcrumb a { color: rgba(255,255,255,.65); text-decoration: none; }
.jg-breadcrumb a:hover { color: #fff; }
.jg-breadcrumb i { font-size: 11px; }
.jg-breadcrumb span { color: rgba(255,255,255,.85); }
.jg-page-hero__title { font-size: 36px; font-weight: 800; color: #fff; letter-spacing: -1px; margin: 0 0 10px; line-height: 1.15; }
.jg-page-hero__sub { font-size: 16px; color: rgba(255,255,255,.70); margin: 0; }

/* ─── SECTION ─────────────────────────────────────────── */
.emp-dash-section { padding: 36px 0 70px; background: #f5f7fb; min-height: 400px; }

/* ─── ALERT ───────────────────────────────────────────── */
.emp-alert {
    background: #fffbeb; border: 1px solid #fde68a;
    border-left: 4px solid #f59e0b;
    border-radius: 10px; padding: 14px 18px;
    font-size: 14px; color: #92400e;
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 24px;
}
.emp-alert i { color: #f59e0b; font-size: 16px; }
.emp-alert a { color: #0a65cc; font-weight: 600; text-decoration: none; margin-left: auto; }
.emp-alert a:hover { text-decoration: underline; }

/* ─── STAT CARDS ──────────────────────────────────────── */
.emp-stats { margin-bottom: 20px; }
.emp-stat-card {
    border-radius: 14px; padding: 22px 20px;
    display: flex; align-items: center; gap: 16px;
    margin-bottom: 20px; position: relative;
    overflow: hidden; transition: transform .2s, box-shadow .2s;
    cursor: pointer;
}
.emp-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,.12); }
.emp-stat-card__link { position: absolute; inset: 0; }
.emp-stat-card__icon {
    width: 52px; height: 52px; min-width: 52px;
    border-radius: 12px; background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
}
.emp-stat-card__info strong { display: block; font-size: 28px; font-weight: 800; color: #fff; line-height: 1; }
.emp-stat-card__info span  { font-size: 13px; color: rgba(255,255,255,.8); margin-top: 4px; display: block; }
.emp-stat-card--blue   { background: linear-gradient(135deg, #0a65cc, #0a9acc); }
.emp-stat-card--teal   { background: linear-gradient(135deg, #14a077, #1abc9c); }
.emp-stat-card--green  { background: linear-gradient(135deg, #16a34a, #22c55e); }
.emp-stat-card--orange { background: linear-gradient(135deg, #f59e0b, #f97316); }

/* ─── QUICK ACTIONS ───────────────────────────────────── */
.emp-quick-actions {
    display: flex; flex-wrap: wrap; gap: 10px;
    margin-bottom: 28px; align-items: center;
}
.jg-btn { display: inline-flex; align-items: center; gap: 7px; font-weight: 700; text-decoration: none; border-radius: 8px; border: 2px solid transparent; cursor: pointer; transition: .2s; }
.jg-btn--primary { background: #0a65cc; color: #fff; padding: 10px 22px; font-size: 14px; border-color: #0a65cc; }
.jg-btn--primary:hover { background: #084fa3; border-color: #084fa3; color: #fff; }
.jg-btn--outline { background: #fff; color: #0a65cc; padding: 9px 20px; font-size: 14px; border-color: #0a65cc; }
.jg-btn--outline:hover { background: #0a65cc; color: #fff; }
.jg-btn--sm { padding: 7px 16px; font-size: 13px; }
.emp-badge-pill {
    background: #ef4444; color: #fff;
    font-size: 10px; font-weight: 800;
    padding: 2px 7px; border-radius: 20px;
    line-height: 1.4;
}

/* ─── CARDS ───────────────────────────────────────────── */
.emp-card {
    background: #fff; border-radius: 14px;
    border: 1.5px solid #e8edf5;
    box-shadow: 0 4px 20px rgba(10,50,120,.06);
    overflow: hidden; margin-bottom: 20px;
}
.emp-card__head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px; border-bottom: 1px solid #f0f4f9;
}
.emp-card__head h4 { margin: 0; font-size: 15px; font-weight: 700; color: #1a1a2e; display: flex; align-items: center; gap: 8px; }
.emp-card__head h4 i { color: #0a65cc; }
.emp-card__head-link { font-size: 13px; color: #0a65cc; text-decoration: none; font-weight: 600; }
.emp-card__head-link:hover { text-decoration: underline; }
.emp-card__body { padding: 18px 20px; }
.emp-card__footer { padding: 14px 20px; border-top: 1px solid #f0f4f9; background: #fafbfd; }

/* ─── TABLE ───────────────────────────────────────────── */
.emp-table { width: 100%; border-collapse: collapse; }
.emp-table thead th {
    background: #f8fafd; color: #64748b;
    font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .4px;
    padding: 12px 16px; border-bottom: 1.5px solid #e8edf5;
    white-space: nowrap;
}
.emp-table tbody tr { border-bottom: 1px solid #f0f4f9; transition: background .15s; }
.emp-table tbody tr:last-child { border-bottom: none; }
.emp-table tbody tr:hover { background: #f7faff; }
.emp-table td { padding: 14px 16px; vertical-align: middle; font-size: 14px; color: #64748b; }
.job-name { display: block; font-weight: 700; color: #1a1a2e; font-size: 14px; }
.job-meta-small { font-size: 12px; color: #94a3b8; margin-top: 2px; }
.date-col { font-size: 13px; color: #94a3b8; white-space: nowrap; }
.app-count { color: #0a65cc; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
.app-count:hover { text-decoration: underline; }

/* ─── STATUS / BADGE PILLS ────────────────────────────── */
.status-pill { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }
.pill-green  { background: #e8f5e9; color: #2e7d32; }
.pill-blue   { background: #e8f0fe; color: #0a65cc; }
.pill-purple { background: #f3e5f5; color: #6a1b9a; }
.pill-teal   { background: #e0f7f0; color: #0d7a57; }
.pill-orange { background: #fff3e0; color: #e65100; }
.pill-red    { background: #fef2f2; color: #e53935; }
.pill-gray   { background: #f1f5f9; color: #64748b; }

.jg-badge { display: inline-block; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; white-space: nowrap; }
.jg-badge--full-time  { background: #e8f4fd; color: #0a65cc; }
.jg-badge--part-time  { background: #fef3e2; color: #d68910; }
.jg-badge--contract   { background: #fdebd0; color: #ca6f1e; }
.jg-badge--freelance  { background: #e8f8f5; color: #148a68; }
.jg-badge--internship { background: #f4ecf7; color: #7d3c98; }

/* ─── APPLICATION BAR ─────────────────────────────────── */
.app-bar-row { margin-bottom: 14px; }
.app-bar-label { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 13px; }
.app-bar-label span { color: #555; }
.app-bar-label strong { color: #1a1a2e; }
.app-bar-track { background: #f0f4f9; border-radius: 10px; height: 7px; }
.app-bar-fill  { height: 7px; border-radius: 10px; transition: width .6s ease; }

/* ─── COMPANY PROFILE ─────────────────────────────────── */
.emp-profile-summary { display: flex; align-items: flex-start; gap: 16px; }
.emp-profile-logo { width: 60px; height: 60px; border-radius: 10px; object-fit: cover; border: 1.5px solid #e8edf5; flex-shrink: 0; }
.emp-profile-logo-initial {
    width: 60px; height: 60px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg, #0a65cc, #14a077);
    color: #fff; font-size: 24px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
}
.emp-profile-summary > div { display: flex; flex-direction: column; gap: 3px; }
.emp-profile-summary strong { font-size: 15px; font-weight: 700; color: #1a1a2e; }
.emp-profile-summary span { font-size: 13px; color: #64748b; }
.emp-website { font-size: 12px; color: #0a65cc; text-decoration: none; }
.emp-website:hover { text-decoration: underline; }
.emp-job-counters { display: flex; gap: 0; }
.emp-job-counters > div { flex: 1; text-align: center; padding: 8px 4px; border-right: 1px solid #e8edf5; }
.emp-job-counters > div:last-child { border-right: none; }
.emp-job-counters strong { display: block; font-size: 18px; font-weight: 800; color: #0a65cc; }
.emp-job-counters span { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; }

/* ─── ACTION BUTTONS ──────────────────────────────────── */
.act-btn {
    display: inline-flex; align-items: center; gap: 5px;
    background: #fff; border: 1.5px solid #e8edf5;
    color: #64748b; font-size: 12px; font-weight: 600;
    padding: 5px 11px; border-radius: 6px;
    text-decoration: none; cursor: pointer;
    transition: .2s; margin-right: 4px;
}
.act-btn:hover { background: #f5f7fb; color: #1a1a2e; border-color: #c5d0e0; text-decoration: none; }
.act-btn i { font-size: 11px; }

/* ─── EMPTY ───────────────────────────────────────────── */
.emp-empty { text-align: center; padding: 40px 20px; color: #aaa; }
.emp-empty i { font-size: 36px; margin-bottom: 12px; display: block; color: #c5d5e8; }
.emp-empty p { font-size: 14px; margin-bottom: 14px; }

/* ─── RESPONSIVE ──────────────────────────────────────── */
@media (max-width: 767px) {
    .jg-page-hero { padding-top: 120px; padding-bottom: 40px; }
    .jg-page-hero__title { font-size: 26px; }
    .emp-quick-actions { gap: 8px; }
    .emp-card__head { flex-direction: column; align-items: flex-start; gap: 8px; }
    .emp-profile-summary { flex-direction: column; }
}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>