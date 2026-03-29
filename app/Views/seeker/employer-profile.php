<?php
$employer = $employer ?? [];
$jobs     = $jobs     ?? [];
?>
<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero" style="background:linear-gradient(135deg,rgba(10,22,40,.90),rgba(10,101,204,.82)),url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&q=60&fit=crop') center/cover no-repeat;margin-top:-70px;padding-top:140px;padding-bottom:50px">
    <div class="container" style="position:relative;z-index:2">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/seeker/applications">My Applications</a>
            <i class="fa fa-angle-right"></i>
            <span><?= htmlspecialchars($employer['company_name'] ?? 'Company Profile') ?></span>
        </div>
        <h1 class="jg-page-hero__title"><?= htmlspecialchars($employer['company_name'] ?? 'Company') ?></h1>
        <?php if (!empty($employer['industry'])): ?>
        <p style="color:rgba(255,255,255,.72);margin:0;font-size:16px">
            <i class="fa fa-th-large"></i> <?= htmlspecialchars($employer['industry']) ?>
            <?php if (!empty($employer['location_city'])): ?>
            &ensp;·&ensp;<i class="fa fa-map-marker"></i> <?= htmlspecialchars($employer['location_city']) ?>
            <?php endif; ?>
        </p>
        <?php endif; ?>
    </div>
</div>

<section style="padding:36px 0 70px;background:#f5f7fb;min-height:500px">
<div class="container">
<div class="row">

    <!-- LEFT: Company Card -->
    <div class="col-md-4">

        <div class="ep-card">
            <!-- Logo -->
            <div class="ep-logo-wrap">
                <?php if (!empty($employer['logo'])): ?>
                    <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($employer['logo']) ?>" alt="" class="ep-logo">
                <?php else: ?>
                    <div class="ep-logo-initial">
                        <?= strtoupper(substr($employer['company_name'] ?? 'C', 0, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="ep-company-name"><?= htmlspecialchars($employer['company_name'] ?? 'Company') ?></div>

            <!-- Meta info -->
            <div class="ep-meta-list">
                <?php if (!empty($employer['industry'])): ?>
                <div class="ep-meta-item"><i class="fa fa-th-large"></i> <?= htmlspecialchars($employer['industry']) ?></div>
                <?php endif; ?>
                <?php if (!empty($employer['location_city'])): ?>
                <div class="ep-meta-item"><i class="fa fa-map-marker"></i> <?= htmlspecialchars($employer['location_city']) ?></div>
                <?php endif; ?>
                <?php if (!empty($employer['company_size'])): ?>
                <div class="ep-meta-item"><i class="fa fa-users"></i> <?= htmlspecialchars($employer['company_size']) ?> employees</div>
                <?php endif; ?>
                <?php if (!empty($employer['website'])): ?>
                <div class="ep-meta-item">
                    <i class="fa fa-globe"></i>
                    <a href="<?= htmlspecialchars($employer['website']) ?>" target="_blank" rel="noopener" class="ep-website">
                        <?= htmlspecialchars(preg_replace('#^https?://#', '', $employer['website'])) ?>
                    </a>
                </div>
                <?php endif; ?>
                <div class="ep-meta-item"><i class="fa fa-calendar"></i> On JobPortal since <?= date('M Y', strtotime($employer['created_at'])) ?></div>
            </div>

            <div class="ep-divider"></div>

            <a href="<?= SITE_URL ?>/seeker/applications" class="ep-btn ep-btn--outline">
                <i class="fa fa-arrow-left"></i> Back to Applications
            </a>
            <a href="<?= SITE_URL ?>/jobs" class="ep-btn ep-btn--primary" style="margin-top:8px">
                <i class="fa fa-search"></i> Browse All Jobs
            </a>
        </div>

    </div>

    <!-- RIGHT: About + Jobs -->
    <div class="col-md-8">

        <!-- About -->
        <?php if (!empty($employer['company_desc'])): ?>
        <div class="ep-detail-card">
            <h5 class="ep-section-title"><i class="fa fa-building-o"></i> About <?= htmlspecialchars($employer['company_name'] ?? 'the Company') ?></h5>
            <p class="ep-body-text"><?= nl2br(htmlspecialchars($employer['company_desc'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Open Positions -->
        <div class="ep-detail-card">
            <h5 class="ep-section-title">
                <i class="fa fa-briefcase"></i> Open Positions
                <span class="ep-job-count"><?= count($jobs) ?></span>
            </h5>

            <?php if (empty($jobs)): ?>
            <div class="ep-no-jobs">
                <i class="fa fa-briefcase"></i>
                <p>No active job openings at this time.</p>
            </div>
            <?php else: ?>
            <div class="ep-job-list">
                <?php foreach ($jobs as $j): ?>
                <div class="ep-job-row">
                    <div class="ep-job-row__info">
                        <a href="<?= SITE_URL ?>/jobs/<?= $j['id'] ?>" class="ep-job-title"><?= htmlspecialchars($j['title']) ?></a>
                        <div class="ep-job-meta">
                            <?php if (!empty($j['location_city'])): ?>
                            <span><i class="fa fa-map-marker"></i> <?= htmlspecialchars($j['location_city']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($j['job_type'])): ?>
                            <span><i class="fa fa-clock-o"></i> <?= ucfirst(str_replace('_', ' ', $j['job_type'])) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($j['category_name'])): ?>
                            <span><i class="fa fa-th-large"></i> <?= htmlspecialchars($j['category_name']) ?></span>
                            <?php endif; ?>
                            <?php if ($j['salary_min'] > 0): ?>
                            <span><i class="fa fa-money"></i>
                                <?= htmlspecialchars($j['salary_currency'] ?? 'USD') ?>
                                <?= number_format($j['salary_min']) ?>
                                <?php if ($j['salary_max'] > 0): ?>– <?= number_format($j['salary_max']) ?><?php endif; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="ep-job-row__actions">
                        <?php if (!empty($j['deadline'])): ?>
                        <div class="ep-deadline">
                            <i class="fa fa-hourglass-end"></i>
                            <?= date('d M Y', strtotime($j['deadline'])) ?>
                        </div>
                        <?php endif; ?>
                        <a href="<?= SITE_URL ?>/jobs/<?= $j['id'] ?>" class="ep-apply-btn">
                            View & Apply <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>
</div>
</section>

<style>
.jg-page-hero__title{font-size:32px;font-weight:800;color:#fff;margin:0 0 8px;letter-spacing:-.5px}
.jg-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.55);margin-bottom:12px}
.jg-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb i{font-size:10px}.jg-breadcrumb span{color:rgba(255,255,255,.85)}

/* Company card */
.ep-card{background:#fff;border-radius:14px;border:1.5px solid #e8edf5;padding:28px 24px;box-shadow:0 2px 12px rgba(10,50,120,.05);text-align:center}
.ep-logo-wrap{margin-bottom:18px}
.ep-logo{width:96px;height:96px;border-radius:12px;object-fit:contain;border:2px solid #e8edf5;padding:6px;background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.08)}
.ep-logo-initial{width:96px;height:96px;border-radius:12px;background:linear-gradient(135deg,#0a65cc,#14a077);color:#fff;font-size:40px;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto}
.ep-company-name{font-size:20px;font-weight:800;color:#1a1a2e;margin-bottom:14px}
.ep-meta-list{display:flex;flex-direction:column;gap:8px;text-align:left}
.ep-meta-item{font-size:13px;color:#64748b;display:flex;align-items:center;gap:8px}
.ep-meta-item i{color:#0a65cc;width:14px;text-align:center;flex-shrink:0}
.ep-website{color:#0a65cc;text-decoration:none;font-weight:600}.ep-website:hover{text-decoration:underline}
.ep-divider{border-top:1px solid #f0f4f9;margin:20px 0}
.ep-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px 20px;border-radius:9px;font-size:13px;font-weight:700;text-decoration:none;transition:.2s;border:2px solid transparent}
.ep-btn--primary{background:#0a65cc;color:#fff;border-color:#0a65cc}.ep-btn--primary:hover{background:#084fa3;color:#fff}
.ep-btn--outline{background:#fff;color:#0a65cc;border-color:#0a65cc}.ep-btn--outline:hover{background:#f0f5ff}

/* Detail cards */
.ep-detail-card{background:#fff;border-radius:14px;border:1.5px solid #e8edf5;padding:24px;margin-bottom:16px;box-shadow:0 2px 12px rgba(10,50,120,.04)}
.ep-section-title{font-size:14px;font-weight:700;color:#1a1a2e;margin:0 0 16px;padding-bottom:10px;border-bottom:1px solid #f0f4f9;display:flex;align-items:center;gap:8px}
.ep-section-title i{color:#0a65cc}
.ep-job-count{background:#f0f5ff;color:#0a65cc;font-size:12px;padding:2px 9px;border-radius:20px;margin-left:auto}
.ep-body-text{font-size:14px;color:#475569;line-height:1.75;margin:0;white-space:pre-line}

/* Job list */
.ep-job-list{display:flex;flex-direction:column;gap:12px}
.ep-job-row{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;padding:14px 16px;background:#fafbfd;border-radius:10px;border:1.5px solid #e8edf5;transition:.2s;flex-wrap:wrap}
.ep-job-row:hover{border-color:#0a65cc;background:#f0f5ff}
.ep-job-title{font-size:14px;font-weight:700;color:#1a1a2e;text-decoration:none;display:block;margin-bottom:6px}.ep-job-title:hover{color:#0a65cc}
.ep-job-meta{display:flex;flex-wrap:wrap;gap:10px}
.ep-job-meta span{font-size:12px;color:#64748b;display:flex;align-items:center;gap:4px}
.ep-job-meta i{color:#0a65cc}
.ep-job-row__actions{display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0}
.ep-deadline{font-size:11px;color:#94a3b8;white-space:nowrap}
.ep-apply-btn{display:inline-flex;align-items:center;gap:6px;background:#0a65cc;color:#fff;font-size:12px;font-weight:700;padding:7px 16px;border-radius:7px;text-decoration:none;transition:.2s;white-space:nowrap}
.ep-apply-btn:hover{background:#084fa3;color:#fff}
.ep-no-jobs{text-align:center;padding:40px 20px;color:#aaa}
.ep-no-jobs i{font-size:36px;color:#c5d5e8;display:block;margin-bottom:12px}
.ep-no-jobs p{margin:0;font-size:14px}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
