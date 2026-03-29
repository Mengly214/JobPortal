<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero" style="background:linear-gradient(135deg,rgba(10,22,40,.88),rgba(10,101,204,.82)),url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1400&q=60&fit=crop') center/cover no-repeat;margin-top:-70px;padding-top:150px;padding-bottom:52px">
    <div class="container" style="position:relative;z-index:2">
        <div class="jg-breadcrumb"><a href="<?= SITE_URL ?>/">Home</a> <i class="fa fa-angle-right"></i> <a href="<?= SITE_URL ?>/employer/dashboard">Dashboard</a> <i class="fa fa-angle-right"></i> <span>Applications</span></div>
        <h1 class="jg-page-hero__title">Applications Received</h1>
        <p style="color:rgba(255,255,255,.72);margin:0;font-size:16px">Review and manage all candidate applications</p>
    </div>
</div>

<section style="padding:36px 0 70px;background:#f5f7fb;min-height:400px">
<div class="container">

    <?php if (isset($_GET['updated'])): ?>
    <div class="pj-alert pj-alert--success" style="margin-bottom:20px"><i class="fa fa-check-circle"></i> Application status updated successfully.</div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="emp-toolbar" style="margin-bottom:24px">
        <form method="GET" action="<?= SITE_URL ?>/employer/applications" class="emp-toolbar__filters">
            <select name="job" class="emp-select">
                <option value="">All Jobs</option>
                <?php foreach ($myJobs as $j): ?>
                <option value="<?= $j['id'] ?>" <?= $jobFilter==$j['id']?'selected':'' ?>><?= htmlspecialchars($j['title']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="status" class="emp-select">
                <option value="">All Statuses</option>
                <?php foreach(['submitted'=>'Received','reviewing'=>'In Review','shortlisted'=>'Shortlisted','interview'=>'Interview','offered'=>'Offered','hired'=>'Hired','rejected'=>'Rejected','withdrawn'=>'Withdrawn'] as $v=>$l): ?>
                <option value="<?= $v ?>" <?= $statusFilter===$v?'selected':'' ?>><?= $l ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="jg-btn jg-btn--outline jg-btn--sm"><i class="fa fa-filter"></i> Filter</button>
            <?php if ($jobFilter || $statusFilter): ?>
            <a href="<?= SITE_URL ?>/employer/applications" class="jg-btn jg-btn--sm" style="border:1.5px solid #e0e6f0;color:#888;background:#fff">Clear</a>
            <?php endif; ?>
        </form>
        <div style="font-size:13px;color:#94a3b8;white-space:nowrap">
            <?= count($applications) ?> result<?= count($applications)!=1?'s':'' ?>
        </div>
    </div>

    <?php if (empty($applications)): ?>
    <div class="emp-empty-state">
        <i class="fa fa-file-text-o"></i>
        <h3>No applications found</h3>
        <p><?= $jobFilter||$statusFilter ? 'Try clearing your filters.' : 'No one has applied to your jobs yet.' ?></p>
        <a href="<?= SITE_URL ?>/employer/jobs" class="jg-btn jg-btn--primary"><i class="fa fa-briefcase"></i> View My Jobs</a>
    </div>
    <?php else: ?>

    <div class="app-list">
        <?php foreach ($applications as $app):
            $statusConfig = [
                'submitted'   => ['pill-blue',   'Received',    'fa-inbox'],
                'reviewing'   => ['pill-purple',  'In Review',   'fa-eye'],
                'shortlisted' => ['pill-orange',  'Shortlisted', 'fa-star'],
                'interview'   => ['pill-orange',  'Interview',   'fa-calendar'],
                'offered'     => ['pill-teal',    'Offered',     'fa-envelope-o'],
                'hired'       => ['pill-green',   'Hired',       'fa-check-circle'],
                'rejected'    => ['pill-red',     'Rejected',    'fa-times-circle'],
                'withdrawn'   => ['pill-gray',    'Withdrawn',   'fa-undo'],
            ];
            [$sClass, $sLabel, $sIcon] = $statusConfig[$app['status']] ?? ['pill-gray','Unknown','fa-question'];
            $initials = strtoupper(substr($app['applicant_name'] ?? $app['applicant_email'], 0, 1));
        ?>
        <div class="app-card">
            <div class="app-card__left">
                <div class="app-card__avatar"><?= $initials ?></div>
                <div class="app-card__info">
                    <strong><?= htmlspecialchars($app['applicant_name'] ?? 'Applicant') ?></strong>
                    <span><?= htmlspecialchars($app['applicant_email']) ?></span>
                    <?php if (!empty($app['seeker_city'])): ?>
                    <span><i class="fa fa-map-marker"></i> <?= htmlspecialchars($app['seeker_city']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="app-card__job">
                <div class="app-card__label">Applied for</div>
                <strong><?= htmlspecialchars($app['job_title']) ?></strong>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px">
                    <i class="fa fa-calendar"></i> <?= date('d M Y', strtotime($app['applied_at'])) ?>
                </div>
            </div>

            <?php if (!empty($app['cover_letter'])): ?>
            <div class="app-card__cover">
                <div class="app-card__label">Cover Letter</div>
                <p><?= htmlspecialchars(substr($app['cover_letter'], 0, 120)) ?><?= strlen($app['cover_letter'])>120?'...':'' ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($app['skills'])): ?>
            <div class="app-card__skills hidden-xs">
                <div class="app-card__label">Skills</div>
                <div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:4px">
                    <?php foreach (array_slice(explode(',', $app['skills']), 0, 4) as $sk): ?>
                    <span class="app-skill"><?= htmlspecialchars(trim($sk)) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="app-card__actions">
                <span class="status-pill <?= $sClass ?>"><i class="fa <?= $sIcon ?>"></i> <?= $sLabel ?></span>

                <!-- View Applicant Profile -->
                <a href="<?= SITE_URL ?>/employer/seeker/<?= $app['applicant_id'] ?>" class="act-btn act-btn--profile" style="margin-top:6px;width:100%;justify-content:center">
                    <i class="fa fa-user"></i> View Profile
                </a>

                <!-- Status update dropdown -->
                <form method="POST" action="<?= SITE_URL ?>/employer/applications/status" style="margin-top:8px">
                    <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                    <div style="display:flex;gap:6px">
                        <select name="status" class="emp-select" style="flex:1;font-size:12px;padding:6px 8px">
                            <?php foreach(['submitted'=>'Received','reviewing'=>'In Review','shortlisted'=>'Shortlisted','interview'=>'Interview','offered'=>'Offered','hired'=>'Hired','rejected'=>'Rejected'] as $sv=>$sl): ?>
                            <option value="<?= $sv ?>" <?= $app['status']===$sv?'selected':'' ?>><?= $sl ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="act-btn" title="Update Status" style="padding:6px 10px"><i class="fa fa-check"></i></button>
                    </div>
                </form>

                <?php if (!empty($app['cv_file'])): ?>
                <a href="<?= SITE_URL ?>/uploads/resumes/<?= htmlspecialchars($app['cv_file']) ?>" download class="act-btn" style="margin-top:6px;width:100%;justify-content:center">
                    <i class="fa fa-download"></i> Download CV
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>
</section>

<style>
.jg-page-hero__title{font-size:32px;font-weight:800;color:#fff;margin:0 0 8px;letter-spacing:-.5px}
.jg-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.55);margin-bottom:12px}
.jg-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb i{font-size:10px}.jg-breadcrumb span{color:rgba(255,255,255,.85)}
.pj-alert{padding:14px 18px;border-radius:10px;font-size:14px;display:flex;align-items:center;gap:10px}
.pj-alert--success{background:#e8f5e9;color:#2e7d32;border-left:4px solid #4caf50}
.emp-toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;background:#fff;padding:14px 18px;border-radius:12px;border:1px solid #e8edf5;box-shadow:0 2px 12px rgba(10,50,120,.05)}
.emp-toolbar__filters{display:flex;align-items:center;gap:10px;flex-wrap:wrap;flex:1}
.emp-select{border:1.5px solid #e8edf5;border-radius:8px;padding:9px 12px;font-size:13px;outline:none;background:#fafbfd;color:#555;cursor:pointer}
.emp-select:focus{border-color:#0a65cc}
.app-list{display:flex;flex-direction:column;gap:14px}
.app-card{background:#fff;border:1.5px solid #e8edf5;border-radius:14px;padding:20px 22px;display:flex;align-items:flex-start;gap:20px;transition:.2s;box-shadow:0 2px 10px rgba(10,50,120,.04);flex-wrap:wrap}
.app-card:hover{border-color:#0a65cc;box-shadow:0 4px 20px rgba(10,101,204,.10)}
.app-card__left{display:flex;align-items:flex-start;gap:14px;flex-shrink:0;min-width:200px}
.app-card__avatar{width:48px;height:48px;min-width:48px;border-radius:50%;background:linear-gradient(135deg,#0a65cc,#14a077);color:#fff;font-size:20px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.app-card__info{display:flex;flex-direction:column;gap:2px}
.app-card__info strong{font-size:15px;font-weight:700;color:#1a1a2e}
.app-card__info span{font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:4px}
.app-card__job{flex:1;min-width:160px}
.app-card__cover{flex:2;min-width:180px}
.app-card__skills{flex:1;min-width:140px}
.app-card__label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:5px}
.app-card__job strong{font-size:14px;font-weight:700;color:#1a1a2e}
.app-card__cover p{font-size:13px;color:#555;line-height:1.6;margin:0}
.app-card__actions{display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0;min-width:160px}
.app-skill{background:#f0f5ff;color:#0a65cc;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px}
.status-pill{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap}
.pill-green{background:#e8f5e9;color:#2e7d32}.pill-blue{background:#e8f0fe;color:#0a65cc}
.pill-purple{background:#f3e5f5;color:#6a1b9a}.pill-teal{background:#e0f7f0;color:#0d7a57}
.pill-orange{background:#fff3e0;color:#e65100}.pill-red{background:#fef2f2;color:#e53935}
.pill-gray{background:#f1f5f9;color:#64748b}
.act-btn{display:inline-flex;align-items:center;gap:5px;background:#fff;border:1.5px solid #e8edf5;color:#64748b;font-size:12px;font-weight:600;padding:6px 12px;border-radius:8px;text-decoration:none;transition:.2s;cursor:pointer}
.act-btn:hover{background:#f5f7fb;color:#1a1a2e;border-color:#c5d0e0;text-decoration:none}
.act-btn--profile{background:#f0f5ff;color:#0a65cc;border-color:#c8daf9}.act-btn--profile:hover{background:#0a65cc;color:#fff;border-color:#0a65cc}
.jg-btn{display:inline-flex;align-items:center;gap:7px;font-weight:700;text-decoration:none;border-radius:8px;border:2px solid transparent;cursor:pointer;transition:.2s;padding:10px 22px;font-size:14px}
.jg-btn--primary{background:#0a65cc;color:#fff;border-color:#0a65cc}.jg-btn--primary:hover{background:#084fa3;color:#fff}
.jg-btn--outline{background:#fff;color:#0a65cc;border-color:#0a65cc}.jg-btn--outline:hover{background:#0a65cc;color:#fff}
.jg-btn--sm{padding:8px 16px;font-size:13px}
.emp-empty-state{text-align:center;padding:80px 20px;color:#aaa;background:#fff;border-radius:14px;border:1.5px dashed #e8edf5}
.emp-empty-state i{font-size:48px;color:#c5d5e8;display:block;margin-bottom:16px}
.emp-empty-state h3{font-size:20px;font-weight:700;color:#888;margin-bottom:8px}
.emp-empty-state p{margin-bottom:20px;font-size:14px}
@media(max-width:767px){
    .app-card{flex-direction:column}
    .app-card__actions{align-items:flex-start;width:100%}
    .app-card__left{min-width:auto}
}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
