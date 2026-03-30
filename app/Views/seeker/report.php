<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- PAGE HERO -->
<div class="rpt-hero">
    <div class="rpt-hero__photo"></div>
    <div class="rpt-hero__overlay"></div>
    <div class="container rpt-hero__inner">
        <div class="rpt-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/seeker/dashboard">Dashboard</a>
            <i class="fa fa-angle-right"></i>
            <span>My Report</span>
        </div>
        <div class="rpt-hero__row">
            <div>
                <h1 class="rpt-hero__title"><i class="fa fa-bar-chart"></i> My Career Report</h1>
                <p class="rpt-hero__sub">A full snapshot of your profile, applications and progress</p>
            </div>
            <button onclick="window.print()" class="rpt-print-btn">
                <i class="fa fa-print"></i> Print / Save PDF
            </button>
        </div>
    </div>
</div>

<!-- REPORT BODY -->
<section class="rpt-section">
<div class="container">
<div class="rpt-grid">

    <!-- ══════════════════════════════════════════
         LEFT COLUMN
    ══════════════════════════════════════════ -->
    <div class="rpt-col-left">

        <!-- 1. Basic Information -->
        <div class="rpt-card" id="sec-info">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--blue"><i class="fa fa-user"></i></div>
                <h2>Basic Information</h2>
            </div>
            <div class="rpt-info-list">
                <?php
                $avatar = !empty($seeker['avatar'])
                    ? SITE_URL . '/uploads/avatars/' . clean($seeker['avatar'])
                    : 'https://ui-avatars.com/api/?name=' . urlencode($seeker['full_name'] ?? $seeker['email']) . '&size=120&background=0a65cc&color=fff&bold=true';
                ?>
                <div class="rpt-avatar-row">
                    <img src="<?= $avatar ?>" alt="Avatar" class="rpt-avatar">
                    <div>
                        <div class="rpt-avatar-name"><?= clean($seeker['full_name'] ?? '—') ?></div>
                        <div class="rpt-avatar-badge"><i class="fa fa-briefcase"></i> Job Seeker</div>
                    </div>
                </div>
                <div class="rpt-info-table">
                    <div class="rpt-info-row">
                        <span class="rpt-info-key"><i class="fa fa-envelope-o"></i> Email</span>
                        <span class="rpt-info-val"><?= clean($seeker['email'] ?? '—') ?></span>
                    </div>
                    <div class="rpt-info-row">
                        <span class="rpt-info-key"><i class="fa fa-phone"></i> Phone</span>
                        <span class="rpt-info-val"><?= clean($seeker['phone'] ?? '—') ?></span>
                    </div>
                    <div class="rpt-info-row">
                        <span class="rpt-info-key"><i class="fa fa-map-marker"></i> Location</span>
                        <span class="rpt-info-val">
                            <?php
                            $loc = array_filter([
                                $seeker['seeker_city']        ?? '',
                                $seeker['location_country']   ?? '',
                            ]);
                            echo $loc ? clean(implode(', ', $loc)) : '—';
                            ?>
                        </span>
                    </div>
                    <div class="rpt-info-row">
                        <span class="rpt-info-key"><i class="fa fa-calendar"></i> Joined</span>
                        <span class="rpt-info-val"><?= isset($seeker['created_at']) ? date('d M Y', strtotime($seeker['created_at'])) : '—' ?></span>
                    </div>
                    <?php if (!empty($seeker['linkedin_url'])): ?>
                    <div class="rpt-info-row">
                        <span class="rpt-info-key"><i class="fa fa-linkedin"></i> LinkedIn</span>
                        <span class="rpt-info-val"><a href="<?= clean($seeker['linkedin_url']) ?>" target="_blank" class="rpt-link"><?= clean($seeker['linkedin_url']) ?></a></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($seeker['portfolio_url'])): ?>
                    <div class="rpt-info-row">
                        <span class="rpt-info-key"><i class="fa fa-globe"></i> Portfolio</span>
                        <span class="rpt-info-val"><a href="<?= clean($seeker['portfolio_url']) ?>" target="_blank" class="rpt-link"><?= clean($seeker['portfolio_url']) ?></a></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($seeker['github_url'])): ?>
                    <div class="rpt-info-row">
                        <span class="rpt-info-key"><i class="fa fa-github"></i> GitHub</span>
                        <span class="rpt-info-val"><a href="<?= clean($seeker['github_url']) ?>" target="_blank" class="rpt-link"><?= clean($seeker['github_url']) ?></a></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- 2. Profile Summary -->
        <div class="rpt-card" id="sec-summary">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--purple"><i class="fa fa-graduation-cap"></i></div>
                <h2>Profile Summary</h2>
            </div>

            <?php if (!empty($seeker['headline'])): ?>
            <div class="rpt-summary-headline"><?= clean($seeker['headline']) ?></div>
            <?php endif; ?>

            <?php if (!empty($seeker['bio'])): ?>
            <div class="rpt-summary-block">
                <div class="rpt-summary-block__label">Bio</div>
                <div class="rpt-summary-block__text"><?= clean($seeker['bio']) ?></div>
            </div>
            <?php endif; ?>

            <?php if (!empty($seeker['experience'])): ?>
            <div class="rpt-summary-block">
                <div class="rpt-summary-block__label"><i class="fa fa-briefcase"></i> Experience</div>
                <div class="rpt-summary-block__text"><?= nl2br(clean($seeker['experience'])) ?></div>
            </div>
            <?php endif; ?>

            <?php if (!empty($seeker['education'])): ?>
            <div class="rpt-summary-block">
                <div class="rpt-summary-block__label"><i class="fa fa-book"></i> Education</div>
                <div class="rpt-summary-block__text"><?= nl2br(clean($seeker['education'])) ?></div>
            </div>
            <?php endif; ?>

            <?php if (!empty($seeker['skills'])): ?>
            <div class="rpt-summary-block">
                <div class="rpt-summary-block__label"><i class="fa fa-tags"></i> Skills</div>
                <div class="rpt-skills-wrap">
                    <?php foreach (array_filter(array_map('trim', explode(',', $seeker['skills']))) as $skill): ?>
                        <span class="rpt-skill-tag"><?= clean($skill) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (empty($seeker['bio']) && empty($seeker['skills']) && empty($seeker['experience']) && empty($seeker['education'])): ?>
            <div class="rpt-empty-note">
                <i class="fa fa-info-circle"></i> Profile not yet filled in.
                <a href="<?= SITE_URL ?>/seeker/profile" class="rpt-link">Complete your profile →</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- 5. Profile Strength -->
        <div class="rpt-card" id="sec-strength">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--amber"><i class="fa fa-bolt"></i></div>
                <h2>Profile Strength</h2>
            </div>

            <div class="rpt-strength-row">
                <div class="rpt-strength-ring">
                    <svg viewBox="0 0 80 80" width="80" height="80">
                        <circle cx="40" cy="40" r="34" fill="none" stroke="#e8edf5" stroke-width="8"/>
                        <circle cx="40" cy="40" r="34" fill="none"
                            stroke="<?= $strength >= 80 ? '#2e7d32' : ($strength >= 50 ? '#0a65cc' : '#e53935') ?>"
                            stroke-width="8" stroke-linecap="round"
                            stroke-dasharray="<?= round(2 * 3.14159 * 34 * $strength / 100, 1) ?> 999"
                            transform="rotate(-90 40 40)"/>
                        <text x="40" y="44" text-anchor="middle" font-size="16" font-weight="700"
                              fill="<?= $strength >= 80 ? '#2e7d32' : ($strength >= 50 ? '#0a65cc' : '#e53935') ?>">
                            <?= $strength ?>%
                        </text>
                    </svg>
                </div>
                <div class="rpt-strength-checks">
                    <?php foreach ($checks as $check): ?>
                    <div class="rpt-check <?= $check['done'] ? 'rpt-check--done' : 'rpt-check--missing' ?>">
                        <i class="fa <?= $check['done'] ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                        <?= $check['label'] ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($strength < 100): ?>
            <a href="<?= SITE_URL ?>/seeker/profile" class="rpt-cta-link">
                <i class="fa fa-pencil"></i> Complete your profile to reach 100%
            </a>
            <?php endif; ?>
        </div>

        <!-- 6. Documents -->
        <div class="rpt-card" id="sec-docs">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--teal"><i class="fa fa-paperclip"></i></div>
                <h2>Documents</h2>
            </div>
            <div class="rpt-doc-list">
                <div class="rpt-doc <?= !empty($seeker['cv_file']) ? 'rpt-doc--present' : 'rpt-doc--missing' ?>">
                    <div class="rpt-doc__icon"><i class="fa fa-file-pdf-o"></i></div>
                    <div class="rpt-doc__body">
                        <div class="rpt-doc__label">CV / Resume</div>
                        <?php if (!empty($seeker['cv_file'])): ?>
                            <div class="rpt-doc__name"><?= clean($seeker['cv_file']) ?></div>
                            <a href="<?= SITE_URL ?>/uploads/resumes/<?= clean($seeker['cv_file']) ?>"
                               target="_blank" class="rpt-doc__link">
                               <i class="fa fa-download"></i> Download
                            </a>
                        <?php else: ?>
                            <div class="rpt-doc__missing">Not uploaded</div>
                        <?php endif; ?>
                    </div>
                    <div class="rpt-doc__badge"><?= !empty($seeker['cv_file']) ? '<i class="fa fa-check"></i> Uploaded' : '<i class="fa fa-times"></i> Missing' ?></div>
                </div>

                <div class="rpt-doc <?= !empty($seeker['portfolio_url']) ? 'rpt-doc--present' : 'rpt-doc--missing' ?>">
                    <div class="rpt-doc__icon"><i class="fa fa-globe"></i></div>
                    <div class="rpt-doc__body">
                        <div class="rpt-doc__label">Portfolio</div>
                        <?php if (!empty($seeker['portfolio_url'])): ?>
                            <a href="<?= clean($seeker['portfolio_url']) ?>" target="_blank" class="rpt-doc__link">
                                <i class="fa fa-external-link"></i> <?= clean($seeker['portfolio_url']) ?>
                            </a>
                        <?php else: ?>
                            <div class="rpt-doc__missing">Not added</div>
                        <?php endif; ?>
                    </div>
                    <div class="rpt-doc__badge"><?= !empty($seeker['portfolio_url']) ? '<i class="fa fa-check"></i> Added' : '<i class="fa fa-times"></i> Missing' ?></div>
                </div>
            </div>
        </div>

    </div><!-- /.rpt-col-left -->

    <!-- ══════════════════════════════════════════
         RIGHT COLUMN
    ══════════════════════════════════════════ -->
    <div class="rpt-col-right">

        <!-- 4. Application Statistics -->
        <div class="rpt-card" id="sec-stats">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--green"><i class="fa fa-pie-chart"></i></div>
                <h2>Application Statistics</h2>
            </div>

            <!-- Big total -->
            <div class="rpt-stat-total">
                <div class="rpt-stat-total__num"><?= $stats['total'] ?></div>
                <div class="rpt-stat-total__label">Total Applications</div>
            </div>

            <!-- Stat chips grid -->
            <div class="rpt-stat-grid">
                <?php
                $statRows = [
                    ['key'=>'pending',     'label'=>'Pending',     'icon'=>'fa-clock-o',     'cls'=>'sc-teal'],
                    ['key'=>'reviewing',   'label'=>'In Review',   'icon'=>'fa-search',      'cls'=>'sc-blue'],
                    ['key'=>'shortlisted', 'label'=>'Shortlisted', 'icon'=>'fa-star',        'cls'=>'sc-purple'],
                    ['key'=>'interview',   'label'=>'Interview',   'icon'=>'fa-calendar',    'cls'=>'sc-orange'],
                    ['key'=>'offered',     'label'=>'Offered',     'icon'=>'fa-envelope',    'cls'=>'sc-indigo'],
                    ['key'=>'hired',       'label'=>'Hired',       'icon'=>'fa-trophy',      'cls'=>'sc-green'],
                    ['key'=>'rejected',    'label'=>'Rejected',    'icon'=>'fa-times-circle','cls'=>'sc-red'],
                    ['key'=>'withdrawn',   'label'=>'Withdrawn',   'icon'=>'fa-minus-circle','cls'=>'sc-gray'],
                ];
                foreach ($statRows as $row): ?>
                <div class="rpt-stat-chip <?= $row['cls'] ?>">
                    <div class="rpt-stat-chip__icon"><i class="fa <?= $row['icon'] ?>"></i></div>
                    <div class="rpt-stat-chip__num"><?= $stats[$row['key']] ?></div>
                    <div class="rpt-stat-chip__label"><?= $row['label'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Bar chart -->
            <?php if ($stats['total'] > 0): ?>
            <div class="rpt-bar-chart">
                <?php foreach ($statRows as $row):
                    if ($stats[$row['key']] === 0) continue;
                    $pct = round($stats[$row['key']] / $stats['total'] * 100);
                ?>
                <div class="rpt-bar-row">
                    <div class="rpt-bar-row__label"><?= $row['label'] ?></div>
                    <div class="rpt-bar-row__track">
                        <div class="rpt-bar-row__fill <?= $row['cls'] ?>-bar" style="width:<?= $pct ?>%"></div>
                    </div>
                    <div class="rpt-bar-row__val"><?= $stats[$row['key']] ?> <span>(<?= $pct ?>%)</span></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- 3. Applications History -->
        <div class="rpt-card" id="sec-history">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--orange"><i class="fa fa-history"></i></div>
                <h2>Application History</h2>
                <a href="<?= SITE_URL ?>/seeker/applications" class="rpt-card__heading-link">
                    <i class="fa fa-external-link"></i> Track all
                </a>
            </div>

            <?php if (empty($applications)): ?>
            <div class="rpt-empty-note"><i class="fa fa-info-circle"></i> No applications yet. <a href="<?= SITE_URL ?>/jobs" class="rpt-link">Browse jobs →</a></div>
            <?php else: ?>
            <div class="rpt-table-wrap">
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $statusPills = [
                            'submitted'   => ['status-teal',   'Application Received'],
                            'reviewing'   => ['status-blue',   'In Review'],
                            'shortlisted' => ['status-purple', 'Shortlisted'],
                            'interview'   => ['status-orange', 'Interview'],
                            'offered'     => ['status-indigo', 'Offered'],
                            'hired'       => ['status-green',  'Hired'],
                            'rejected'    => ['status-red',    'Not Selected'],
                            'withdrawn'   => ['status-gray',   'Withdrawn'],
                        ];
                        foreach ($applications as $i => $app):
                            [$pillCls, $pillLabel] = $statusPills[$app['status']] ?? ['status-gray', ucfirst($app['status'])];
                        ?>
                        <tr>
                            <td class="rpt-table__num"><?= $i + 1 ?></td>
                            <td>
                                <div class="rpt-table__job"><?= htmlspecialchars($app['job_title']) ?></div>
                                <div class="rpt-table__type"><?= ucfirst(str_replace('_',' ',$app['job_type'] ?? '')) ?></div>
                            </td>
                            <td>
                                <div class="rpt-table__company-wrap">
                                    <?php if (!empty($app['company_logo'])): ?>
                                        <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($app['company_logo']) ?>" class="rpt-co-logo" alt="">
                                    <?php else: ?>
                                        <div class="rpt-co-initial"><?= strtoupper(substr($app['company_name'] ?? 'C', 0, 1)) ?></div>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($app['company_name'] ?? '—') ?></span>
                                </div>
                            </td>
                            <td><span class="rpt-pill <?= $pillCls ?>"><?= $pillLabel ?></span></td>
                            <td class="rpt-table__date"><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

    </div><!-- /.rpt-col-right -->

</div><!-- /.rpt-grid -->
</div>
</section>

<!-- ======================================================
     STYLES
====================================================== -->
<style>
/* ── Hero ──────────────────────────────────────────────── */
.rpt-hero{position:relative;margin-top:-70px;padding-top:140px;padding-bottom:44px;overflow:hidden;min-height:240px;display:flex;align-items:flex-end}
.rpt-hero__photo{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=1600&q=60&fit=crop&crop=top') center/cover no-repeat;transform:scale(1.03)}
.rpt-hero__overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(5,14,30,.92) 0%,rgba(10,60,130,.84) 60%,rgba(5,14,30,.72) 100%)}
.rpt-hero__inner{position:relative;z-index:2}
.rpt-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.50);margin-bottom:14px}
.rpt-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}
.rpt-breadcrumb a:hover{color:#fff}
.rpt-breadcrumb span{color:rgba(255,255,255,.85)}
.rpt-breadcrumb i{font-size:11px}
.rpt-hero__row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px}
.rpt-hero__title{font-size:36px;font-weight:800;color:#fff;letter-spacing:-1px;margin:0 0 8px;line-height:1.1}
.rpt-hero__title i{font-size:30px;margin-right:8px;color:#7ec8fa}
.rpt-hero__sub{font-size:15px;color:rgba(255,255,255,.65);margin:0}
.rpt-print-btn{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.3);color:#fff;font-size:13px;font-weight:700;padding:10px 20px;border-radius:10px;cursor:pointer;transition:.2s;backdrop-filter:blur(4px)}
.rpt-print-btn:hover{background:rgba(255,255,255,.22)}

/* ── Section & Grid ────────────────────────────────────── */
.rpt-section{padding:36px 0 70px;background:#f5f7fb;min-height:400px}
.rpt-grid{display:grid;grid-template-columns:1fr 1.4fr;gap:22px;align-items:start}

/* ── Cards ─────────────────────────────────────────────── */
.rpt-card{background:#fff;border:1.5px solid #e8edf5;border-radius:16px;padding:26px;margin-bottom:20px;box-shadow:0 2px 10px rgba(10,50,120,.05)}
.rpt-card__heading{display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #f0f4f8}
.rpt-card__heading h2{font-size:16px;font-weight:700;color:#1a1a2e;margin:0;flex:1}
.rpt-card__heading-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0}
.rpt-icon--blue{background:#eef3fd;color:#0a65cc}
.rpt-icon--purple{background:#f0ebff;color:#6c3fc5}
.rpt-icon--green{background:#e8f5e9;color:#2e7d32}
.rpt-icon--amber{background:#fef3e2;color:#d68910}
.rpt-icon--teal{background:#e0f7f0;color:#0d7a57}
.rpt-icon--orange{background:#fff4e5;color:#b45309}
.rpt-card__heading-link{font-size:12px;color:#0a65cc;text-decoration:none;font-weight:600;white-space:nowrap}
.rpt-card__heading-link:hover{text-decoration:underline}

/* ── Basic Info ────────────────────────────────────────── */
.rpt-avatar-row{display:flex;align-items:center;gap:16px;margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid #f0f4f8}
.rpt-avatar{width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #0a65cc;flex-shrink:0}
.rpt-avatar-name{font-size:18px;font-weight:800;color:#1a1a2e;margin-bottom:4px}
.rpt-avatar-badge{display:inline-flex;align-items:center;gap:5px;background:#eef3fd;color:#0a65cc;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px}
.rpt-info-table{display:flex;flex-direction:column;gap:0}
.rpt-info-row{display:flex;align-items:flex-start;gap:10px;padding:9px 0;border-bottom:1px solid #f8fafc}
.rpt-info-row:last-child{border-bottom:none}
.rpt-info-key{min-width:110px;font-size:12px;font-weight:700;color:#94a3b8;display:flex;align-items:center;gap:6px;flex-shrink:0;text-transform:uppercase;letter-spacing:.4px}
.rpt-info-key i{color:#0a65cc;width:14px;text-align:center}
.rpt-info-val{font-size:13px;color:#1a1a2e;font-weight:500;word-break:break-all}
.rpt-link{color:#0a65cc;text-decoration:none;font-weight:600}
.rpt-link:hover{text-decoration:underline}

/* ── Profile Summary ───────────────────────────────────── */
.rpt-summary-headline{font-size:15px;font-weight:700;color:#0a65cc;margin-bottom:14px;padding:10px 14px;background:#f0f6ff;border-radius:8px;border-left:3px solid #0a65cc}
.rpt-summary-block{margin-bottom:14px}
.rpt-summary-block__label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:6px;display:flex;align-items:center;gap:6px}
.rpt-summary-block__label i{color:#0a65cc}
.rpt-summary-block__text{font-size:13px;color:#475569;line-height:1.7}
.rpt-skills-wrap{display:flex;flex-wrap:wrap;gap:6px}
.rpt-skill-tag{display:inline-block;font-size:12px;font-weight:600;background:#eef3fd;color:#0a65cc;border:1px solid #d4e6fb;padding:3px 11px;border-radius:20px}
.rpt-empty-note{font-size:13px;color:#94a3b8;display:flex;align-items:center;gap:8px;padding:12px 0}

/* ── Stats ─────────────────────────────────────────────── */
.rpt-stat-total{text-align:center;padding:16px 0 20px;border-bottom:1px solid #f0f4f8;margin-bottom:16px}
.rpt-stat-total__num{font-size:52px;font-weight:900;color:#1a1a2e;line-height:1}
.rpt-stat-total__label{font-size:13px;color:#94a3b8;font-weight:600;margin-top:4px;text-transform:uppercase;letter-spacing:.5px}
.rpt-stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:20px}
.rpt-stat-chip{border-radius:12px;padding:12px 8px;text-align:center;border:1.5px solid transparent}
.rpt-stat-chip__icon{font-size:18px;margin-bottom:5px}
.rpt-stat-chip__num{font-size:22px;font-weight:800;line-height:1}
.rpt-stat-chip__label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-top:2px}
.sc-teal{background:#e0f7f0;border-color:#b2e8d8;color:#0d7a57}.sc-teal .rpt-stat-chip__icon{color:#0d7a57}
.sc-blue{background:#e8f0fe;border-color:#c0d7f9;color:#0a65cc}.sc-blue .rpt-stat-chip__icon{color:#0a65cc}
.sc-purple{background:#f0ebff;border-color:#d4c8f8;color:#6c3fc5}.sc-purple .rpt-stat-chip__icon{color:#6c3fc5}
.sc-orange{background:#fff4e5;border-color:#fde4b0;color:#b45309}.sc-orange .rpt-stat-chip__icon{color:#b45309}
.sc-indigo{background:#eef2ff;border-color:#c7d2fe;color:#3730a3}.sc-indigo .rpt-stat-chip__icon{color:#3730a3}
.sc-green{background:#e8f5e9;border-color:#c0e4c2;color:#2e7d32}.sc-green .rpt-stat-chip__icon{color:#2e7d32}
.sc-red{background:#fef2f2;border-color:#f9c9c9;color:#e53935}.sc-red .rpt-stat-chip__icon{color:#e53935}
.sc-gray{background:#f1f5f9;border-color:#dde4ee;color:#64748b}.sc-gray .rpt-stat-chip__icon{color:#64748b}

/* Bar chart */
.rpt-bar-chart{display:flex;flex-direction:column;gap:8px;padding-top:4px}
.rpt-bar-row{display:flex;align-items:center;gap:10px}
.rpt-bar-row__label{min-width:82px;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.3px}
.rpt-bar-row__track{flex:1;height:10px;background:#f0f4f8;border-radius:20px;overflow:hidden}
.rpt-bar-row__fill{height:100%;border-radius:20px;transition:width .8s cubic-bezier(.22,1,.36,1)}
.rpt-bar-row__val{min-width:52px;font-size:12px;font-weight:700;color:#1a1a2e;text-align:right}
.rpt-bar-row__val span{font-weight:400;color:#94a3b8}
.sc-teal-bar{background:#0d7a57}.sc-blue-bar{background:#0a65cc}.sc-purple-bar{background:#6c3fc5}
.sc-orange-bar{background:#b45309}.sc-indigo-bar{background:#3730a3}.sc-green-bar{background:#2e7d32}
.sc-red-bar{background:#e53935}.sc-gray-bar{background:#94a3b8}

/* ── Strength ───────────────────────────────────────────── */
.rpt-strength-row{display:flex;align-items:flex-start;gap:20px;margin-bottom:14px}
.rpt-strength-ring{flex-shrink:0}
.rpt-strength-checks{display:flex;flex-direction:column;gap:6px;flex:1}
.rpt-check{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600}
.rpt-check--done{color:#2e7d32}.rpt-check--done i{color:#2e7d32}
.rpt-check--missing{color:#e53935}.rpt-check--missing i{color:#e53935}
.rpt-cta-link{display:inline-flex;align-items:center;gap:7px;margin-top:10px;font-size:13px;font-weight:700;color:#0a65cc;text-decoration:none;padding:9px 16px;background:#f0f6ff;border-radius:8px;border:1.5px solid #d4e6fb;transition:.2s}
.rpt-cta-link:hover{background:#e4effc;border-color:#0a65cc}

/* ── Documents ──────────────────────────────────────────── */
.rpt-doc-list{display:flex;flex-direction:column;gap:10px}
.rpt-doc{display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:12px;border:1.5px solid #e8edf5;transition:.2s}
.rpt-doc--present{background:#f0fdf8;border-color:#b2e8d8}
.rpt-doc--missing{background:#fff5f5;border-color:#f9c9c9}
.rpt-doc__icon{font-size:24px;flex-shrink:0}
.rpt-doc--present .rpt-doc__icon{color:#0d7a57}
.rpt-doc--missing .rpt-doc__icon{color:#e53935}
.rpt-doc__body{flex:1;min-width:0}
.rpt-doc__label{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#94a3b8;margin-bottom:2px}
.rpt-doc__name{font-size:13px;color:#1a1a2e;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.rpt-doc__link{font-size:12px;color:#0a65cc;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:4px;margin-top:2px}
.rpt-doc__link:hover{text-decoration:underline}
.rpt-doc__missing{font-size:12px;color:#e53935;font-weight:600}
.rpt-doc__badge{font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;white-space:nowrap;flex-shrink:0}
.rpt-doc--present .rpt-doc__badge{background:#ccf2e5;color:#0d7a57}
.rpt-doc--missing .rpt-doc__badge{background:#fcd5d4;color:#e53935}

/* ── History Table ──────────────────────────────────────── */
.rpt-table-wrap{overflow-x:auto;border-radius:10px;border:1px solid #f0f4f8}
.rpt-table{width:100%;border-collapse:collapse;font-size:13px}
.rpt-table thead th{background:#f8fafd;color:#64748b;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;padding:10px 12px;border-bottom:1.5px solid #e8edf5;white-space:nowrap}
.rpt-table tbody tr{border-bottom:1px solid #f0f4f8;transition:background .15s}
.rpt-table tbody tr:last-child{border-bottom:none}
.rpt-table tbody tr:hover{background:#f7faff}
.rpt-table td{padding:11px 12px;vertical-align:middle;color:#475569}
.rpt-table__num{font-size:12px;color:#94a3b8;font-weight:700;width:30px}
.rpt-table__job{font-weight:700;color:#1a1a2e;font-size:13px}
.rpt-table__type{font-size:11px;color:#94a3b8;margin-top:1px}
.rpt-table__company-wrap{display:flex;align-items:center;gap:8px}
.rpt-co-logo{width:28px;height:28px;border-radius:6px;object-fit:cover;border:1px solid #e8edf5;flex-shrink:0}
.rpt-co-initial{width:28px;height:28px;border-radius:6px;background:linear-gradient(135deg,#0a65cc,#14a077);color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.rpt-table__date{font-size:12px;color:#94a3b8;white-space:nowrap}
.rpt-pill{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:10px;font-weight:700;white-space:nowrap}
.status-teal{background:#e0f7f0;color:#0d7a57}
.status-blue{background:#e8f0fe;color:#0a65cc}
.status-purple{background:#f0ebff;color:#6c3fc5}
.status-orange{background:#fff4e5;color:#b45309}
.status-indigo{background:#eef2ff;color:#3730a3}
.status-green{background:#e8f5e9;color:#2e7d32}
.status-red{background:#fef2f2;color:#e53935}
.status-gray{background:#f1f5f9;color:#64748b}

/* ── Print styles ───────────────────────────────────────── */
@media print {
    .rpt-hero__photo,.rpt-hero__overlay,.rpt-print-btn,.jg-page-hero,.header,.footer,
    nav,.jg-filterbar-wrap{display:none!important}
    .rpt-hero{background:#1a1a2e!important;-webkit-print-color-adjust:exact;print-color-adjust:exact;padding:20px 0 16px;margin-top:0}
    .rpt-section{padding:16px 0}
    .rpt-card{box-shadow:none;border:1px solid #e0e6f0;break-inside:avoid;margin-bottom:12px}
    .rpt-grid{grid-template-columns:1fr 1.4fr;gap:12px}
    body{font-size:12px}
    .rpt-stat-grid{grid-template-columns:repeat(4,1fr)}
}

/* ── Responsive ─────────────────────────────────────────── */
@media(max-width:991px){.rpt-grid{grid-template-columns:1fr}}
@media(max-width:767px){
    .rpt-hero{padding-top:110px;padding-bottom:30px}
    .rpt-hero__title{font-size:26px}
    .rpt-stat-grid{grid-template-columns:repeat(2,1fr)}
    .rpt-hero__row{flex-direction:column;align-items:flex-start}
}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>