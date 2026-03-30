<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- PAGE HERO -->
<div class="rpt-hero">
    <div class="rpt-hero__photo"></div>
    <div class="rpt-hero__overlay"></div>
    <div class="container rpt-hero__inner">
        <div class="rpt-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/employer/dashboard">Dashboard</a>
            <i class="fa fa-angle-right"></i>
            <span>Company Report</span>
        </div>
        <div class="rpt-hero__row">
            <div class="rpt-hero__left">
                <!-- Company logo -->
                <?php
                $logoSrc = !empty($ep['logo'])
                    ? SITE_URL . '/uploads/logos/' . clean($ep['logo'])
                    : 'https://ui-avatars.com/api/?name=' . urlencode($ep['company_name'] ?? 'Co') . '&size=80&background=3f51b5&color=fff&bold=true';
                ?>
                <img src="<?= $logoSrc ?>" alt="Logo" class="rpt-hero__logo">
                <div>
                    <h1 class="rpt-hero__title"><?= clean($ep['company_name'] ?? 'Company Report') ?></h1>
                    <p class="rpt-hero__sub"><i class="fa fa-bar-chart"></i> Hiring &amp; Performance Report &nbsp;·&nbsp; <?= date('d M Y') ?></p>
                </div>
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

    <!-- ══ LEFT COLUMN ══════════════════════════════════════ -->
    <div class="rpt-col-left">

        <!-- 1. Company Information -->
        <div class="rpt-card" id="sec-company">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--indigo"><i class="fa fa-building"></i></div>
                <h2>Company Information</h2>
            </div>

            <div class="rpt-info-table">
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-building-o"></i> Company</span>
                    <span class="rpt-info-val rpt-info-val--strong"><?= clean($ep['company_name'] ?? '—') ?></span>
                </div>
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-envelope-o"></i> Email</span>
                    <span class="rpt-info-val"><?= clean($ep['email'] ?? '—') ?></span>
                </div>
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-phone"></i> Contact</span>
                    <span class="rpt-info-val"><?= clean($ep['full_name'] ?? '—') ?></span>
                </div>
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-map-marker"></i> Location</span>
                    <span class="rpt-info-val">
                        <?php
                        $loc = array_filter([$ep['location_city'] ?? '', $ep['location_country'] ?? '']);
                        echo $loc ? clean(implode(', ', $loc)) : '—';
                        ?>
                    </span>
                </div>
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-industry"></i> Industry</span>
                    <span class="rpt-info-val"><?= clean($ep['industry'] ?? '—') ?></span>
                </div>
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-users"></i> Size</span>
                    <span class="rpt-info-val"><?= clean($ep['company_size'] ?? '—') ?></span>
                </div>
                <?php if (!empty($ep['website'])): ?>
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-globe"></i> Website</span>
                    <span class="rpt-info-val">
                        <a href="<?= clean($ep['website']) ?>" target="_blank" class="rpt-link"><?= clean($ep['website']) ?></a>
                    </span>
                </div>
                <?php endif; ?>
                <div class="rpt-info-row">
                    <span class="rpt-info-key"><i class="fa fa-calendar"></i> Joined</span>
                    <span class="rpt-info-val"><?= isset($ep['joined_at']) ? date('d M Y', strtotime($ep['joined_at'])) : '—' ?></span>
                </div>
            </div>

            <?php if (!empty($ep['description'])): ?>
            <div class="rpt-company-desc">
                <div class="rpt-summary-block__label"><i class="fa fa-info-circle"></i> About</div>
                <p><?= clean(substr($ep['description'], 0, 300)) ?><?= strlen($ep['description']) > 300 ? '…' : '' ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- 5. Employer Activity -->
        <div class="rpt-card" id="sec-activity">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--teal"><i class="fa fa-line-chart"></i></div>
                <h2>Employer Activity</h2>
            </div>

            <div class="rpt-activity-grid">
                <div class="rpt-activity-item">
                    <div class="rpt-activity-item__num"><?= $jobStats['total'] ?></div>
                    <div class="rpt-activity-item__label"><i class="fa fa-briefcase"></i> Jobs Posted</div>
                </div>
                <div class="rpt-activity-item">
                    <div class="rpt-activity-item__num"><?= $appStats['total'] ?></div>
                    <div class="rpt-activity-item__label"><i class="fa fa-users"></i> Total Applicants</div>
                </div>
                <div class="rpt-activity-item">
                    <div class="rpt-activity-item__num"><?= number_format($totalViews) ?></div>
                    <div class="rpt-activity-item__label"><i class="fa fa-eye"></i> Job Views</div>
                </div>
                <div class="rpt-activity-item rpt-activity-item--<?= $responseRate >= 70 ? 'green' : ($responseRate >= 40 ? 'amber' : 'red') ?>">
                    <div class="rpt-activity-item__num"><?= $responseRate ?>%</div>
                    <div class="rpt-activity-item__label"><i class="fa fa-reply"></i> Response Rate</div>
                </div>
            </div>

            <!-- Response rate bar -->
            <div class="rpt-rate-row">
                <div class="rpt-rate-row__label">Applications reviewed</div>
                <div class="rpt-rate-row__track">
                    <div class="rpt-rate-row__fill" style="width:<?= $responseRate ?>%;background:<?= $responseRate >= 70 ? '#2e7d32' : ($responseRate >= 40 ? '#b45309' : '#e53935') ?>"></div>
                </div>
                <div class="rpt-rate-row__val"><?= $responseRate ?>%</div>
            </div>

            <div class="rpt-info-row" style="margin-top:14px">
                <span class="rpt-info-key"><i class="fa fa-clock-o"></i> Last Active</span>
                <span class="rpt-info-val"><?= $lastActive ? date('d M Y', strtotime($lastActive)) : '—' ?></span>
            </div>
        </div>

        <!-- 6. Hiring Funnel (visual) -->
        <div class="rpt-card" id="sec-funnel">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--purple"><i class="fa fa-filter"></i></div>
                <h2>Hiring Funnel</h2>
            </div>
            <?php if ($appStats['total'] > 0):
                $funnelSteps = [
                    ['label'=>'Applied',      'key'=>'total',        'cls'=>'ff-blue'],
                    ['label'=>'In Review',    'key'=>'reviewing',    'cls'=>'ff-blue2'],
                    ['label'=>'Shortlisted',  'key'=>'shortlisted',  'cls'=>'ff-purple'],
                    ['label'=>'Interview',    'key'=>'interview',    'cls'=>'ff-orange'],
                    ['label'=>'Offered',      'key'=>'offered',      'cls'=>'ff-indigo'],
                    ['label'=>'Hired',        'key'=>'hired',        'cls'=>'ff-green'],
                ];
            ?>
            <div class="rpt-funnel">
                <?php foreach ($funnelSteps as $step):
                    $val = $appStats[$step['key']];
                    $pct = $appStats['total'] > 0 ? round($val / $appStats['total'] * 100) : 0;
                ?>
                <div class="rpt-funnel__row">
                    <div class="rpt-funnel__label"><?= $step['label'] ?></div>
                    <div class="rpt-funnel__bar-wrap">
                        <div class="rpt-funnel__bar <?= $step['cls'] ?>" style="width:<?= max($pct, 4) ?>%"></div>
                    </div>
                    <div class="rpt-funnel__val"><?= $val ?> <span>(<?= $pct ?>%)</span></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="rpt-empty-note"><i class="fa fa-info-circle"></i> No applications yet.</div>
            <?php endif; ?>
        </div>

    </div><!-- /.rpt-col-left -->

    <!-- ══ RIGHT COLUMN ═════════════════════════════════════ -->
    <div class="rpt-col-right">

        <!-- 3. Applicants Overview (stat chips) -->
        <div class="rpt-card" id="sec-apps">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--green"><i class="fa fa-pie-chart"></i></div>
                <h2>Applicants Overview</h2>
            </div>

            <div class="rpt-stat-total">
                <div class="rpt-stat-total__num"><?= $appStats['total'] ?></div>
                <div class="rpt-stat-total__label">Total Applications</div>
            </div>

            <div class="rpt-stat-grid">
                <?php
                $chipRows = [
                    ['key'=>'submitted',   'label'=>'Pending',     'icon'=>'fa-clock-o',      'cls'=>'sc-teal'],
                    ['key'=>'reviewing',   'label'=>'Reviewing',   'icon'=>'fa-search',       'cls'=>'sc-blue'],
                    ['key'=>'shortlisted', 'label'=>'Shortlisted', 'icon'=>'fa-star',         'cls'=>'sc-purple'],
                    ['key'=>'interview',   'label'=>'Interview',   'icon'=>'fa-calendar',     'cls'=>'sc-orange'],
                    ['key'=>'offered',     'label'=>'Offered',     'icon'=>'fa-envelope',     'cls'=>'sc-indigo'],
                    ['key'=>'hired',       'label'=>'Hired',       'icon'=>'fa-trophy',       'cls'=>'sc-green'],
                    ['key'=>'rejected',    'label'=>'Rejected',    'icon'=>'fa-times-circle', 'cls'=>'sc-red'],
                    ['key'=>'withdrawn',   'label'=>'Withdrawn',   'icon'=>'fa-minus-circle', 'cls'=>'sc-gray'],
                ];
                foreach ($chipRows as $chip): ?>
                <div class="rpt-stat-chip <?= $chip['cls'] ?>">
                    <div class="rpt-stat-chip__icon"><i class="fa <?= $chip['icon'] ?>"></i></div>
                    <div class="rpt-stat-chip__num"><?= $appStats[$chip['key']] ?></div>
                    <div class="rpt-stat-chip__label"><?= $chip['label'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 2. Job Postings -->
        <div class="rpt-card" id="sec-jobs">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--orange"><i class="fa fa-briefcase"></i></div>
                <h2>Job Postings</h2>
                <div class="rpt-card__heading-chips">
                    <span class="rpt-mini-chip rpt-mini-chip--green"><?= $jobStats['active'] ?> Active</span>
                    <span class="rpt-mini-chip rpt-mini-chip--gray"><?= $jobStats['paused'] + $jobStats['closed'] ?> Closed</span>
                </div>
                <a href="<?= SITE_URL ?>/employer/jobs" class="rpt-card__heading-link"><i class="fa fa-external-link"></i> Manage</a>
            </div>

            <?php if (empty($jobs)): ?>
            <div class="rpt-empty-note"><i class="fa fa-info-circle"></i> No jobs posted yet. <a href="<?= SITE_URL ?>/employer/jobs/create" class="rpt-link">Post your first job →</a></div>
            <?php else: ?>
            <div class="rpt-table-wrap">
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Views</th>
                            <th>Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $jobStatusPills = [
                            'active' => ['sc-green-pill', 'Active'],
                            'paused' => ['sc-amber-pill', 'Paused'],
                            'closed' => ['sc-gray-pill',  'Closed'],
                            'draft'  => ['sc-blue-pill',  'Draft'],
                        ];
                        foreach ($jobs as $job):
                            [$jPill, $jLabel] = $jobStatusPills[$job['status']] ?? ['sc-gray-pill', ucfirst($job['status'])];
                        ?>
                        <tr>
                            <td>
                                <div class="rpt-table__job"><?= htmlspecialchars($job['title']) ?></div>
                                <?php if (!empty($job['location_city'])): ?>
                                <div class="rpt-table__type"><i class="fa fa-map-marker"></i> <?= clean($job['location_city']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td><span class="rpt-pill <?= $jPill ?>"><?= $jLabel ?></span></td>
                            <td><span class="rpt-type-tag"><?= ucfirst(str_replace('_',' ', $job['job_type'] ?? '')) ?></span></td>
                            <td class="rpt-table__num"><?= number_format($job['views'] ?? 0) ?></td>
                            <td class="rpt-table__date"><?= date('d M Y', strtotime($job['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- 4. Hiring Performance (per job) -->
        <div class="rpt-card" id="sec-perf">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--amber"><i class="fa fa-trophy"></i></div>
                <h2>Hiring Performance</h2>
            </div>

            <?php if (empty($jobs)): ?>
            <div class="rpt-empty-note"><i class="fa fa-info-circle"></i> No jobs to show performance for.</div>
            <?php else: ?>
            <div class="rpt-table-wrap">
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th class="rpt-th-center">Applicants</th>
                            <th class="rpt-th-center">Interview</th>
                            <th class="rpt-th-center">Hired</th>
                            <th class="rpt-th-center">Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job):
                            $convRate = $job['total_apps'] > 0
                                ? round($job['hired_count'] / $job['total_apps'] * 100)
                                : 0;
                            $rateClass = $convRate >= 20 ? 'rpt-rate--green' : ($convRate >= 5 ? 'rpt-rate--amber' : 'rpt-rate--gray');
                        ?>
                        <tr>
                            <td>
                                <div class="rpt-table__job"><?= htmlspecialchars($job['title']) ?></div>
                            </td>
                            <td class="rpt-td-center">
                                <span class="rpt-perf-num"><?= $job['total_apps'] ?></span>
                            </td>
                            <td class="rpt-td-center">
                                <span class="rpt-perf-num rpt-perf-num--orange"><?= $job['interview_count'] ?></span>
                            </td>
                            <td class="rpt-td-center">
                                <span class="rpt-perf-num rpt-perf-num--green"><?= $job['hired_count'] ?></span>
                            </td>
                            <td class="rpt-td-center">
                                <span class="rpt-rate-badge <?= $rateClass ?>"><?= $convRate ?>%</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Job Status summary pills -->
        <div class="rpt-card rpt-card--compact" id="sec-jobstats">
            <div class="rpt-card__heading">
                <div class="rpt-card__heading-icon rpt-icon--blue"><i class="fa fa-bar-chart"></i></div>
                <h2>Job Status Breakdown</h2>
            </div>
            <div class="rpt-jobstat-grid">
                <?php foreach ([
                    ['key'=>'total',  'label'=>'Total',  'cls'=>'sc-blue',   'icon'=>'fa-list'],
                    ['key'=>'active', 'label'=>'Active', 'cls'=>'sc-green',  'icon'=>'fa-check-circle'],
                    ['key'=>'paused', 'label'=>'Paused', 'cls'=>'sc-amber',  'icon'=>'fa-pause-circle'],
                    ['key'=>'closed', 'label'=>'Closed', 'cls'=>'sc-gray',   'icon'=>'fa-times-circle'],
                ] as $js): ?>
                <div class="rpt-jobstat-chip <?= $js['cls'] ?>">
                    <i class="fa <?= $js['icon'] ?>"></i>
                    <div class="rpt-jobstat-chip__num"><?= $jobStats[$js['key']] ?></div>
                    <div class="rpt-jobstat-chip__label"><?= $js['label'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
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
.rpt-hero{position:relative;margin-top:-70px;padding-top:130px;padding-bottom:40px;overflow:hidden;min-height:230px;display:flex;align-items:flex-end}
.rpt-hero__photo{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&q=60&fit=crop&crop=top') center/cover no-repeat;transform:scale(1.03)}
.rpt-hero__overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(5,14,30,.92) 0%,rgba(40,50,140,.85) 60%,rgba(5,14,30,.72) 100%)}
.rpt-hero__inner{position:relative;z-index:2}
.rpt-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.50);margin-bottom:14px}
.rpt-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}
.rpt-breadcrumb a:hover{color:#fff}
.rpt-breadcrumb span{color:rgba(255,255,255,.85)}
.rpt-breadcrumb i{font-size:11px}
.rpt-hero__row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px}
.rpt-hero__left{display:flex;align-items:center;gap:18px}
.rpt-hero__logo{width:64px;height:64px;border-radius:14px;object-fit:cover;border:3px solid rgba(255,255,255,.3);flex-shrink:0;background:#fff}
.rpt-hero__title{font-size:30px;font-weight:800;color:#fff;letter-spacing:-.5px;margin:0 0 6px;line-height:1.1}
.rpt-hero__sub{font-size:14px;color:rgba(255,255,255,.65);margin:0;display:flex;align-items:center;gap:8px}
.rpt-print-btn{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.3);color:#fff;font-size:13px;font-weight:700;padding:10px 20px;border-radius:10px;cursor:pointer;transition:.2s;backdrop-filter:blur(4px)}
.rpt-print-btn:hover{background:rgba(255,255,255,.22)}

/* ── Layout ─────────────────────────────────────────────── */
.rpt-section{padding:36px 0 70px;background:#f5f7fb;min-height:400px}
.rpt-grid{display:grid;grid-template-columns:1fr 1.5fr;gap:22px;align-items:start}

/* ── Cards ──────────────────────────────────────────────── */
.rpt-card{background:#fff;border:1.5px solid #e8edf5;border-radius:16px;padding:24px;margin-bottom:20px;box-shadow:0 2px 10px rgba(10,50,120,.05)}
.rpt-card--compact{margin-bottom:0}
.rpt-card__heading{display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid #f0f4f8}
.rpt-card__heading h2{font-size:15px;font-weight:700;color:#1a1a2e;margin:0;flex:1}
.rpt-card__heading-icon{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.rpt-icon--indigo{background:#eef2ff;color:#3730a3}
.rpt-icon--teal{background:#e0f7f0;color:#0d7a57}
.rpt-icon--purple{background:#f0ebff;color:#6c3fc5}
.rpt-icon--green{background:#e8f5e9;color:#2e7d32}
.rpt-icon--orange{background:#fff4e5;color:#b45309}
.rpt-icon--amber{background:#fef3e2;color:#d68910}
.rpt-icon--blue{background:#eef3fd;color:#0a65cc}
.rpt-card__heading-chips{display:flex;gap:6px;margin-left:auto}
.rpt-card__heading-link{font-size:12px;color:#0a65cc;text-decoration:none;font-weight:600;white-space:nowrap;margin-left:6px}
.rpt-card__heading-link:hover{text-decoration:underline}

/* ── Mini chips in heading ───────────────────────────────── */
.rpt-mini-chip{font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px}
.rpt-mini-chip--green{background:#e8f5e9;color:#2e7d32}
.rpt-mini-chip--gray{background:#f1f5f9;color:#64748b}

/* ── Info table ─────────────────────────────────────────── */
.rpt-info-table{display:flex;flex-direction:column;gap:0}
.rpt-info-row{display:flex;align-items:flex-start;gap:10px;padding:9px 0;border-bottom:1px solid #f8fafc}
.rpt-info-row:last-child{border-bottom:none}
.rpt-info-key{min-width:96px;font-size:11px;font-weight:700;color:#94a3b8;display:flex;align-items:center;gap:6px;flex-shrink:0;text-transform:uppercase;letter-spacing:.4px}
.rpt-info-key i{color:#3730a3;width:14px;text-align:center}
.rpt-info-val{font-size:13px;color:#1a1a2e;font-weight:500;word-break:break-all}
.rpt-info-val--strong{font-weight:700;font-size:14px}
.rpt-link{color:#0a65cc;text-decoration:none;font-weight:600}
.rpt-link:hover{text-decoration:underline}
.rpt-company-desc{margin-top:16px;padding-top:14px;border-top:1px solid #f0f4f8}
.rpt-company-desc p{font-size:13px;color:#64748b;line-height:1.7;margin:6px 0 0}
.rpt-summary-block__label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:4px;display:flex;align-items:center;gap:5px}
.rpt-summary-block__label i{color:#3730a3}
.rpt-empty-note{font-size:13px;color:#94a3b8;display:flex;align-items:center;gap:8px;padding:8px 0}

/* ── Activity grid ──────────────────────────────────────── */
.rpt-activity-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:16px}
.rpt-activity-item{background:#f8fafc;border:1.5px solid #e8edf5;border-radius:12px;padding:14px;text-align:center}
.rpt-activity-item__num{font-size:28px;font-weight:800;color:#1a1a2e;line-height:1}
.rpt-activity-item__label{font-size:11px;font-weight:600;color:#94a3b8;margin-top:4px;display:flex;align-items:center;justify-content:center;gap:5px}
.rpt-activity-item--green .rpt-activity-item__num{color:#2e7d32}
.rpt-activity-item--green{border-color:#c0e4c2;background:#f0fdf4}
.rpt-activity-item--amber .rpt-activity-item__num{color:#b45309}
.rpt-activity-item--amber{border-color:#fde4b0;background:#fffbf0}
.rpt-activity-item--red .rpt-activity-item__num{color:#e53935}
.rpt-activity-item--red{border-color:#f9c9c9;background:#fff5f5}
.rpt-rate-row{display:flex;align-items:center;gap:10px;margin-bottom:4px}
.rpt-rate-row__label{font-size:11px;font-weight:700;color:#64748b;min-width:140px;text-transform:uppercase;letter-spacing:.3px}
.rpt-rate-row__track{flex:1;height:10px;background:#f0f4f8;border-radius:20px;overflow:hidden}
.rpt-rate-row__fill{height:100%;border-radius:20px;transition:width .8s cubic-bezier(.22,1,.36,1)}
.rpt-rate-row__val{min-width:40px;font-size:12px;font-weight:700;color:#1a1a2e;text-align:right}

/* ── Stats chips ────────────────────────────────────────── */
.rpt-stat-total{text-align:center;padding:14px 0 18px;border-bottom:1px solid #f0f4f8;margin-bottom:14px}
.rpt-stat-total__num{font-size:50px;font-weight:900;color:#1a1a2e;line-height:1}
.rpt-stat-total__label{font-size:12px;color:#94a3b8;font-weight:600;margin-top:4px;text-transform:uppercase;letter-spacing:.5px}
.rpt-stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
.rpt-stat-chip{border-radius:12px;padding:10px 6px;text-align:center;border:1.5px solid transparent}
.rpt-stat-chip__icon{font-size:16px;margin-bottom:4px}
.rpt-stat-chip__num{font-size:20px;font-weight:800;line-height:1}
.rpt-stat-chip__label{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-top:2px}
.sc-teal{background:#e0f7f0;border-color:#b2e8d8;color:#0d7a57}.sc-teal .rpt-stat-chip__icon{color:#0d7a57}
.sc-blue{background:#e8f0fe;border-color:#c0d7f9;color:#0a65cc}.sc-blue .rpt-stat-chip__icon{color:#0a65cc}
.sc-purple{background:#f0ebff;border-color:#d4c8f8;color:#6c3fc5}.sc-purple .rpt-stat-chip__icon{color:#6c3fc5}
.sc-orange{background:#fff4e5;border-color:#fde4b0;color:#b45309}.sc-orange .rpt-stat-chip__icon{color:#b45309}
.sc-indigo{background:#eef2ff;border-color:#c7d2fe;color:#3730a3}.sc-indigo .rpt-stat-chip__icon{color:#3730a3}
.sc-green{background:#e8f5e9;border-color:#c0e4c2;color:#2e7d32}.sc-green .rpt-stat-chip__icon{color:#2e7d32}
.sc-red{background:#fef2f2;border-color:#f9c9c9;color:#e53935}.sc-red .rpt-stat-chip__icon{color:#e53935}
.sc-gray{background:#f1f5f9;border-color:#dde4ee;color:#64748b}.sc-gray .rpt-stat-chip__icon{color:#64748b}
.sc-amber{background:#fef3e2;border-color:#fde9b0;color:#d68910}.sc-amber .rpt-stat-chip__icon{color:#d68910}

/* ── Funnel ─────────────────────────────────────────────── */
.rpt-funnel{display:flex;flex-direction:column;gap:9px}
.rpt-funnel__row{display:flex;align-items:center;gap:10px}
.rpt-funnel__label{min-width:82px;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.3px}
.rpt-funnel__bar-wrap{flex:1;height:22px;background:#f0f4f8;border-radius:6px;overflow:hidden}
.rpt-funnel__bar{height:100%;border-radius:6px;transition:width .8s cubic-bezier(.22,1,.36,1)}
.rpt-funnel__val{min-width:60px;font-size:12px;font-weight:700;color:#1a1a2e;text-align:right}
.rpt-funnel__val span{font-weight:400;color:#94a3b8}
.ff-blue{background:#0a65cc}.ff-blue2{background:#2e86de}.ff-purple{background:#6c3fc5}
.ff-orange{background:#b45309}.ff-indigo{background:#3730a3}.ff-green{background:#2e7d32}

/* ── Tables ─────────────────────────────────────────────── */
.rpt-table-wrap{overflow-x:auto;border-radius:10px;border:1px solid #f0f4f8}
.rpt-table{width:100%;border-collapse:collapse;font-size:13px}
.rpt-table thead th{background:#f8fafd;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;padding:9px 12px;border-bottom:1.5px solid #e8edf5;white-space:nowrap}
.rpt-th-center{text-align:center}
.rpt-table tbody tr{border-bottom:1px solid #f0f4f8;transition:background .15s}
.rpt-table tbody tr:last-child{border-bottom:none}
.rpt-table tbody tr:hover{background:#f7faff}
.rpt-table td{padding:10px 12px;vertical-align:middle;color:#475569}
.rpt-td-center{text-align:center}
.rpt-table__job{font-weight:700;color:#1a1a2e;font-size:13px}
.rpt-table__type{font-size:11px;color:#94a3b8;margin-top:1px;display:flex;align-items:center;gap:4px}
.rpt-table__num{font-size:12px;color:#94a3b8;font-weight:700;width:44px;text-align:center}
.rpt-table__date{font-size:12px;color:#94a3b8;white-space:nowrap}
.rpt-type-tag{font-size:10px;font-weight:700;background:#f0f4f8;color:#64748b;padding:2px 8px;border-radius:20px;white-space:nowrap}

/* ── Perf numbers ────────────────────────────────────────── */
.rpt-perf-num{font-size:16px;font-weight:800;color:#1a1a2e}
.rpt-perf-num--orange{color:#b45309}
.rpt-perf-num--green{color:#2e7d32}
.rpt-rate-badge{display:inline-block;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px}
.rpt-rate--green{background:#e8f5e9;color:#2e7d32}
.rpt-rate--amber{background:#fff4e5;color:#b45309}
.rpt-rate--gray{background:#f1f5f9;color:#64748b}

/* ── Status pills ────────────────────────────────────────── */
.rpt-pill{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:10px;font-weight:700;white-space:nowrap}
.sc-green-pill{background:#e8f5e9;color:#2e7d32}
.sc-amber-pill{background:#fef3e2;color:#d68910}
.sc-gray-pill{background:#f1f5f9;color:#64748b}
.sc-blue-pill{background:#e8f0fe;color:#0a65cc}

/* ── Job stat chips (bottom right card) ─────────────────── */
.rpt-jobstat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
.rpt-jobstat-chip{border-radius:12px;padding:12px 8px;text-align:center;border:1.5px solid transparent;display:flex;flex-direction:column;align-items:center;gap:4px}
.rpt-jobstat-chip > i{font-size:18px}
.rpt-jobstat-chip__num{font-size:22px;font-weight:800;line-height:1}
.rpt-jobstat-chip__label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px}

/* ── Print ───────────────────────────────────────────────── */
@media print{
    .rpt-hero__photo,.rpt-hero__overlay,.rpt-print-btn,nav,.header,.footer{display:none!important}
    .rpt-hero{background:#1a1a2e!important;-webkit-print-color-adjust:exact;print-color-adjust:exact;padding:16px 0;margin-top:0}
    .rpt-section{padding:14px 0}
    .rpt-card{box-shadow:none;border:1px solid #e0e6f0;break-inside:avoid;margin-bottom:10px}
    .rpt-grid{grid-template-columns:1fr 1.5fr;gap:12px}
}

/* ── Responsive ──────────────────────────────────────────── */
@media(max-width:991px){.rpt-grid{grid-template-columns:1fr}}
@media(max-width:767px){
    .rpt-hero{padding-top:110px;padding-bottom:26px}
    .rpt-hero__title{font-size:22px}
    .rpt-hero__left{flex-wrap:wrap}
    .rpt-hero__row{flex-direction:column;align-items:flex-start}
    .rpt-stat-grid{grid-template-columns:repeat(2,1fr)}
    .rpt-jobstat-grid{grid-template-columns:repeat(2,1fr)}
    .rpt-activity-grid{grid-template-columns:repeat(2,1fr)}
}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>