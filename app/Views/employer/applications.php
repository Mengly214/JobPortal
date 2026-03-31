<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- PAGE HERO -->
<div class="ea-hero">
    <div class="ea-hero__photo"></div>
    <div class="ea-hero__overlay"></div>
    <div class="container ea-hero__inner">
        <div class="ea-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/employer/dashboard">Dashboard</a>
            <i class="fa fa-angle-right"></i>
            <span>Applications</span>
        </div>
        <h1 class="ea-hero__title">Applications Received</h1>
        <p class="ea-hero__sub">Review and manage all candidate applications</p>
    </div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="ea-toast" class="ea-toast" role="status" aria-live="polite"></div>

<!-- MAIN -->
<section class="ea-section">
<div class="container">

    <!-- Filter bar -->
    <div class="ea-toolbar">
        <form method="GET" action="<?= SITE_URL ?>/employer/applications" class="ea-toolbar__filters">
            <div class="ea-filter-wrap">
                <i class="fa fa-briefcase"></i>
                <select name="job" class="ea-select">
                    <option value="">All Jobs</option>
                    <?php foreach ($myJobs as $j): ?>
                    <option value="<?= $j['id'] ?>" <?= $jobFilter == $j['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($j['title']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ea-filter-wrap">
                <i class="fa fa-filter"></i>
                <select name="status" class="ea-select">
                    <option value="">All Statuses</option>
                    <?php foreach ([
                        'submitted'   => 'Received',
                        'reviewing'   => 'In Review',
                        'shortlisted' => 'Shortlisted',
                        'interview'   => 'Interview',
                        'offered'     => 'Offered',
                        'hired'       => 'Hired',
                        'rejected'    => 'Rejected',
                        'withdrawn'   => 'Withdrawn',
                    ] as $v => $l): ?>
                    <option value="<?= $v ?>" <?= $statusFilter === $v ? 'selected' : '' ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="ea-btn ea-btn--primary"><i class="fa fa-search"></i> Filter</button>
            <?php if ($jobFilter || $statusFilter): ?>
            <a href="<?= SITE_URL ?>/employer/applications" class="ea-btn ea-btn--ghost">
                <i class="fa fa-times"></i> Clear
            </a>
            <?php endif; ?>
        </form>
        <div class="ea-toolbar__count">
            <strong><?= count($applications) ?></strong> result<?= count($applications) != 1 ? 's' : '' ?>
        </div>
    </div>

    <!-- Empty state -->
    <?php if (empty($applications)): ?>
    <div class="ea-empty">
        <div class="ea-empty__icon"><i class="fa fa-inbox"></i></div>
        <h3>No applications found</h3>
        <p><?= $jobFilter || $statusFilter ? 'Try clearing your filters to see all applications.' : 'No candidates have applied to your jobs yet.' ?></p>
        <a href="<?= SITE_URL ?>/employer/jobs" class="ea-btn ea-btn--primary">
            <i class="fa fa-briefcase"></i> View My Jobs
        </a>
    </div>

    <?php else: ?>
    <div class="ea-list">
        <?php
        $statusMeta = [
            'submitted'   => ['cls'=>'sp-teal',   'label'=>'Received',    'icon'=>'fa-paper-plane'],
            'reviewing'   => ['cls'=>'sp-blue',   'label'=>'In Review',   'icon'=>'fa-search'],
            'shortlisted' => ['cls'=>'sp-purple', 'label'=>'Shortlisted', 'icon'=>'fa-star'],
            'interview'   => ['cls'=>'sp-orange', 'label'=>'Interview',   'icon'=>'fa-calendar'],
            'offered'     => ['cls'=>'sp-indigo', 'label'=>'Offered',     'icon'=>'fa-envelope'],
            'hired'       => ['cls'=>'sp-green',  'label'=>'Hired',       'icon'=>'fa-trophy'],
            'rejected'    => ['cls'=>'sp-red',    'label'=>'Rejected',    'icon'=>'fa-times-circle'],
            'withdrawn'   => ['cls'=>'sp-gray',   'label'=>'Withdrawn',   'icon'=>'fa-minus-circle'],
        ];
        require_once BASE_PATH . '/app/Models/Message.php';
        $msgModel = new Message();
        foreach ($applications as $app):
            $sm      = $statusMeta[$app['status']] ?? $statusMeta['submitted'];
            $initial = strtoupper(substr($app['applicant_name'] ?? $app['applicant_email'] ?? '?', 0, 1));
            $unread  = $msgModel->countUnreadForApp((int)$app['id'], 'employer');
        ?>

        <div class="ea-card <?= $unread > 0 ? 'ea-card--has-msg' : '' ?>" id="card-<?= $app['id'] ?>">

            <!-- ── LEFT: applicant ───────────────────── -->
            <div class="ea-card__applicant">
                <div class="ea-card__avatar"><?= $initial ?></div>
                <div class="ea-card__who">
                    <div class="ea-card__name"><?= htmlspecialchars($app['applicant_name'] ?? 'Applicant') ?></div>
                    <div class="ea-card__email"><?= htmlspecialchars($app['applicant_email']) ?></div>
                    <?php if (!empty($app['seeker_city'])): ?>
                    <div class="ea-card__loc"><i class="fa fa-map-marker"></i> <?= htmlspecialchars($app['seeker_city']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ── MIDDLE: job + cover + skills ──────── -->
            <div class="ea-card__body">
                <div class="ea-card__job-row">
                    <div class="ea-card__job-label">Applied for</div>
                    <div class="ea-card__job-title"><?= htmlspecialchars($app['job_title']) ?></div>
                    <div class="ea-card__job-date"><i class="fa fa-calendar-o"></i> <?= date('d M Y', strtotime($app['applied_at'])) ?></div>
                </div>

                <?php if (!empty($app['cover_letter'])): ?>
                <div class="ea-card__cover">
                    <?= htmlspecialchars(substr($app['cover_letter'], 0, 140)) ?><?= strlen($app['cover_letter']) > 140 ? '…' : '' ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($app['skills'])): ?>
                <div class="ea-card__skills">
                    <?php foreach (array_slice(array_filter(array_map('trim', explode(',', $app['skills']))), 0, 5) as $sk): ?>
                    <span class="ea-skill"><?= htmlspecialchars($sk) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Unread message strip — only shown when there are unread messages -->
                <?php if ($unread > 0): ?>
                <div class="ea-msg-strip">
                    <i class="fa fa-envelope"></i>
                    <strong><?= $unread ?> unread message<?= $unread > 1 ? 's' : '' ?></strong>
                    from this applicant
                </div>
                <?php endif; ?>
            </div>

            <!-- ── RIGHT: status + actions ───────────── -->
            <div class="ea-card__actions">

                <!-- Current status badge -->
                <span class="ea-status-pill <?= $sm['cls'] ?>" id="pill-<?= $app['id'] ?>">
                    <i class="fa <?= $sm['icon'] ?>"></i>
                    <span id="pill-label-<?= $app['id'] ?>"><?= $sm['label'] ?></span>
                </span>

                <!-- Status updater -->
                <div class="ea-status-updater">
                    <select class="ea-status-select" id="sel-<?= $app['id'] ?>"
                            data-app-id="<?= $app['id'] ?>"
                            data-job-id="<?= $app['job_id'] ?? 0 ?>"
                            onchange="updateStatus(this)">
                        <?php foreach ([
                            'submitted'   => 'Mark: Received',
                            'reviewing'   => 'Mark: In Review',
                            'shortlisted' => 'Mark: Shortlisted',
                            'interview'   => 'Mark: Interview',
                            'offered'     => 'Mark: Offered',
                            'hired'       => 'Mark: Hired',
                            'rejected'    => 'Mark: Rejected',
                        ] as $sv => $sl): ?>
                        <option value="<?= $sv ?>" <?= $app['status'] === $sv ? 'selected' : '' ?>><?= $sl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Action buttons row -->
                <div class="ea-action-row">
                    <a href="<?= SITE_URL ?>/employer/seeker/<?= $app['applicant_id'] ?>"
                       class="ea-action-btn ea-action-btn--profile" title="View Applicant Profile">
                        <i class="fa fa-user"></i> Profile
                    </a>

                    <a href="<?= SITE_URL ?>/employer/messages/<?= $app['id'] ?>"
                       class="ea-action-btn ea-action-btn--msg <?= $unread > 0 ? 'ea-action-btn--msg-unread' : '' ?>"
                       title="<?= $unread > 0 ? $unread . ' unread message' . ($unread > 1 ? 's' : '') : 'Message Applicant' ?>">
                        <i class="fa fa-envelope"></i>
                        <?php if ($unread > 0): ?>
                            <span class="ea-msg-badge"><?= $unread > 99 ? '99+' : $unread ?></span>
                        <?php else: ?>
                            Msg
                        <?php endif; ?>
                    </a>

                    <?php if (!empty($app['cv_file'])): ?>
                    <a href="<?= SITE_URL ?>/uploads/resumes/<?= htmlspecialchars($app['cv_file']) ?>"
                       download class="ea-action-btn ea-action-btn--cv" title="Download CV">
                        <i class="fa fa-download"></i> CV
                    </a>
                    <?php else: ?>
                    <span class="ea-action-btn ea-action-btn--nocv" title="No CV uploaded">
                        <i class="fa fa-file-o"></i> No CV
                    </span>
                    <?php endif; ?>
                </div>

            </div><!-- /.ea-card__actions -->
        </div><!-- /.ea-card -->

        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>
</section>

<!-- ======================================================
     STYLES
====================================================== -->
<style>
/* ── Hero ──────────────────────────────────────────────── */
.ea-hero{position:relative;margin-top:-70px;padding-top:140px;padding-bottom:48px;overflow:hidden;min-height:240px;display:flex;align-items:flex-end}
.ea-hero__photo{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1400&q=60&fit=crop') center/cover no-repeat;transform:scale(1.03)}
.ea-hero__overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,22,40,.90) 0%,rgba(10,101,204,.84) 60%,rgba(10,22,40,.72) 100%)}
.ea-hero__inner{position:relative;z-index:2}
.ea-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.50);margin-bottom:12px}
.ea-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}.ea-breadcrumb a:hover{color:#fff}
.ea-breadcrumb i{font-size:10px}.ea-breadcrumb span{color:rgba(255,255,255,.85)}
.ea-hero__title{font-size:34px;font-weight:800;color:#fff;margin:0 0 8px;letter-spacing:-.5px}
.ea-hero__sub{font-size:15px;color:rgba(255,255,255,.68);margin:0}

/* ── Toast ─────────────────────────────────────────────── */
.ea-toast{position:fixed;top:24px;right:24px;z-index:9999;min-width:280px;max-width:380px;padding:14px 18px;border-radius:12px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:10px;box-shadow:0 8px 32px rgba(0,0,0,.18);transform:translateY(-16px) scale(.96);opacity:0;pointer-events:none;transition:all .3s cubic-bezier(.22,1,.36,1)}
.ea-toast.show{transform:translateY(0) scale(1);opacity:1;pointer-events:auto}
.ea-toast--success{background:#1a5c1d;color:#fff;border-left:4px solid #4caf50}
.ea-toast--info{background:#084fa3;color:#fff;border-left:4px solid #7ec8fa}
.ea-toast--error{background:#c0392b;color:#fff;border-left:4px solid #f9c9c9}
.ea-toast__close{margin-left:auto;background:none;border:none;color:rgba(255,255,255,.7);font-size:18px;cursor:pointer;line-height:1;padding:0 2px;flex-shrink:0}
.ea-toast__close:hover{color:#fff}

/* ── Section ───────────────────────────────────────────── */
.ea-section{padding:32px 0 70px;background:#f5f7fb;min-height:400px}

/* ── Toolbar ───────────────────────────────────────────── */
.ea-toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;background:#fff;padding:14px 18px;border-radius:14px;border:1.5px solid #e8edf5;box-shadow:0 2px 12px rgba(10,50,120,.05);margin-bottom:22px}
.ea-toolbar__filters{display:flex;align-items:center;gap:10px;flex-wrap:wrap;flex:1}
.ea-filter-wrap{display:flex;align-items:center;gap:8px;background:#f8fafc;border:1.5px solid #e0e6f0;border-radius:8px;padding:0 12px;min-height:40px}
.ea-filter-wrap i{color:#0a65cc;font-size:13px;flex-shrink:0}
.ea-select{border:none;outline:none;background:transparent;font-size:13px;color:#475569;cursor:pointer;min-width:130px;padding:8px 0}
.ea-select:focus{color:#0a65cc}
.ea-toolbar__count{font-size:13px;color:#94a3b8;white-space:nowrap}
.ea-toolbar__count strong{color:#1a1a2e}

/* ── Buttons ───────────────────────────────────────────── */
.ea-btn{display:inline-flex;align-items:center;gap:7px;font-weight:700;text-decoration:none;border-radius:8px;border:none;cursor:pointer;transition:.2s;font-size:13px;padding:9px 16px}
.ea-btn--primary{background:#0a65cc;color:#fff}.ea-btn--primary:hover{background:#084fa3;color:#fff}
.ea-btn--ghost{background:#fff;color:#64748b;border:1.5px solid #e0e6f0}.ea-btn--ghost:hover{background:#f5f7fb;color:#1a1a2e}

/* ── Empty ─────────────────────────────────────────────── */
.ea-empty{text-align:center;padding:80px 20px;background:#fff;border-radius:16px;border:1.5px dashed #d0daea}
.ea-empty__icon{width:72px;height:72px;border-radius:50%;background:#f0f5ff;margin:0 auto 18px;display:flex;align-items:center;justify-content:center;font-size:28px;color:#0a65cc}
.ea-empty h3{font-size:20px;font-weight:700;color:#1a1a2e;margin-bottom:8px}
.ea-empty p{color:#94a3b8;font-size:14px;margin-bottom:20px}

/* ── Card list ─────────────────────────────────────────── */
.ea-list{display:flex;flex-direction:column;gap:14px}

/* ── Application card ──────────────────────────────────── */
.ea-card{background:#fff;border:1.5px solid #e8edf5;border-radius:16px;padding:20px 22px;display:grid;grid-template-columns:220px 1fr 200px;gap:20px;align-items:start;transition:.2s;box-shadow:0 2px 10px rgba(10,50,120,.04)}
.ea-card:hover{border-color:#b8d0f5;box-shadow:0 6px 24px rgba(10,101,204,.09)}
/* Card with unread messages gets a red left accent */
.ea-card--has-msg{border-left:4px solid #e53935}

/* applicant column */
.ea-card__applicant{display:flex;align-items:flex-start;gap:12px}
.ea-card__avatar{width:46px;height:46px;min-width:46px;border-radius:50%;background:linear-gradient(135deg,#0a65cc,#14a077);color:#fff;font-size:19px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.ea-card__who{display:flex;flex-direction:column;gap:2px;min-width:0}
.ea-card__name{font-size:14px;font-weight:700;color:#1a1a2e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ea-card__email{font-size:12px;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ea-card__loc{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:4px;margin-top:2px}
.ea-card__loc i{color:#0a65cc;font-size:10px}

/* body column */
.ea-card__body{display:flex;flex-direction:column;gap:8px;min-width:0}
.ea-card__job-row{display:flex;flex-direction:column;gap:2px}
.ea-card__job-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8}
.ea-card__job-title{font-size:14px;font-weight:700;color:#1a1a2e}
.ea-card__job-date{font-size:11px;color:#b0bac8;display:flex;align-items:center;gap:4px;margin-top:1px}
.ea-card__cover{font-size:13px;color:#64748b;line-height:1.6;border-left:3px solid #e0e6f0;padding-left:10px}
.ea-card__skills{display:flex;flex-wrap:wrap;gap:4px}
.ea-skill{background:#f0f5ff;color:#0a65cc;font-size:11px;font-weight:600;padding:2px 9px;border-radius:20px}

/* Unread message strip inside card body */
.ea-msg-strip{display:flex;align-items:center;gap:7px;background:#fff5f5;border:1px solid #fca5a5;border-radius:8px;padding:7px 12px;font-size:12px;color:#e53935;font-weight:600;animation:pulseBorder 2s ease-in-out infinite}
.ea-msg-strip i{font-size:13px;flex-shrink:0}
@keyframes pulseBorder{0%,100%{box-shadow:0 0 0 0 rgba(229,57,53,.2)}50%{box-shadow:0 0 0 4px rgba(229,57,53,0)}}

/* actions column */
.ea-card__actions{display:flex;flex-direction:column;align-items:stretch;gap:10px}

/* status pill */
.ea-status-pill{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700;white-space:nowrap;transition:all .3s}
.sp-teal{background:#e0f7f0;color:#0d7a57}
.sp-blue{background:#e8f0fe;color:#0a65cc}
.sp-purple{background:#f0ebff;color:#6c3fc5}
.sp-orange{background:#fff4e5;color:#b45309}
.sp-indigo{background:#eef2ff;color:#3730a3}
.sp-green{background:#e8f5e9;color:#2e7d32}
.sp-red{background:#fef2f2;color:#e53935}
.sp-gray{background:#f1f5f9;color:#64748b}

/* status selector */
.ea-status-updater{position:relative}
.ea-status-select{width:100%;border:1.5px solid #e0e6f0;border-radius:10px;padding:8px 12px;font-size:12px;font-weight:600;color:#475569;background:#fafbfd;cursor:pointer;outline:none;transition:.2s;-webkit-appearance:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2394a3b8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:28px}
.ea-status-select:hover{border-color:#0a65cc;color:#0a65cc}
.ea-status-select:focus{border-color:#0a65cc;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
.ea-status-select.loading{opacity:.6;pointer-events:none}

/* action buttons row */
.ea-action-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:7px}
.ea-action-btn{display:flex;align-items:center;justify-content:center;gap:5px;padding:8px 0;border-radius:9px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:.2s;white-space:nowrap;position:relative}
.ea-action-btn--profile{background:#eef3fd;color:#0a65cc;border:1.5px solid #c8daf9}
.ea-action-btn--profile:hover{background:#0a65cc;color:#fff;border-color:#0a65cc}
/* Message button — normal state */
.ea-action-btn--msg{background:#f0ebff;color:#6c3fc5;border:1.5px solid #d4c8f8}
.ea-action-btn--msg:hover{background:#6c3fc5;color:#fff;border-color:#6c3fc5}
/* Message button — unread state */
.ea-action-btn--msg-unread{background:#fff0f0;color:#e53935;border:1.5px solid #fca5a5;animation:pulseMsg 2s ease-in-out infinite}
.ea-action-btn--msg-unread:hover{background:#e53935;color:#fff;border-color:#e53935;animation:none}
@keyframes pulseMsg{0%,100%{box-shadow:0 0 0 0 rgba(229,57,53,.35)}50%{box-shadow:0 0 0 5px rgba(229,57,53,0)}}
/* Badge inside the message button */
.ea-msg-badge{display:inline-flex;align-items:center;justify-content:center;background:#e53935;color:#fff;border-radius:20px;font-size:10px;font-weight:800;min-width:18px;padding:0 5px;height:16px;line-height:1}
.ea-action-btn--msg-unread .ea-msg-badge{background:#fff;color:#e53935}

.ea-action-btn--cv{background:#e8f5e9;color:#2e7d32;border:1.5px solid #b7e5c4}
.ea-action-btn--cv:hover{background:#2e7d32;color:#fff;border-color:#2e7d32}
.ea-action-btn--nocv{background:#f8fafc;color:#b0bac8;border:1.5px solid #e8edf5;cursor:default;font-size:11px}

/* ── Responsive ────────────────────────────────────────── */
@media(max-width:1100px){.ea-card{grid-template-columns:200px 1fr 190px}}
@media(max-width:900px) {.ea-card{grid-template-columns:1fr 1fr}}
@media(max-width:640px) {
    .ea-card{grid-template-columns:1fr;gap:14px}
    .ea-card__actions{flex-direction:row;flex-wrap:wrap;align-items:center}
    .ea-action-row{flex:1;grid-template-columns:1fr 1fr 1fr}
    .ea-hero__title{font-size:26px}
    .ea-toolbar{flex-direction:column;align-items:stretch}
    .ea-toolbar__filters{flex-direction:column}
    .ea-filter-wrap{width:100%}
}
</style>

<!-- ======================================================
     SCRIPTS — AJAX status update + toast
====================================================== -->
<script>
var STATUS_META = {
    submitted:   { cls: 'sp-teal',   label: 'Received',    icon: 'fa-paper-plane',  toast: 'info',    msg: 'Marked as Received' },
    reviewing:   { cls: 'sp-blue',   label: 'In Review',   icon: 'fa-search',       toast: 'info',    msg: 'Moved to In Review' },
    shortlisted: { cls: 'sp-purple', label: 'Shortlisted', icon: 'fa-star',         toast: 'info',    msg: '⭐ Candidate shortlisted!' },
    interview:   { cls: 'sp-orange', label: 'Interview',   icon: 'fa-calendar',     toast: 'info',    msg: '📅 Interview scheduled.' },
    offered:     { cls: 'sp-indigo', label: 'Offered',     icon: 'fa-envelope',     toast: 'info',    msg: '📨 Offer sent to candidate.' },
    hired:       { cls: 'sp-green',  label: 'Hired',       icon: 'fa-trophy',       toast: 'success', msg: '🎉 Candidate marked as Hired!' },
    rejected:    { cls: 'sp-red',    label: 'Rejected',    icon: 'fa-times-circle', toast: 'error',   msg: 'Candidate marked as Not Selected.' },
    withdrawn:   { cls: 'sp-gray',   label: 'Withdrawn',   icon: 'fa-minus-circle', toast: 'info',    msg: 'Application withdrawn.' },
};

var ALL_PILL_CLS = Object.values(STATUS_META).map(function(m){ return m.cls; });

function updateStatus(sel) {
    var appId  = sel.dataset.appId;
    var jobId  = sel.dataset.jobId;
    var status = sel.value;
    var meta   = STATUS_META[status];
    if (!meta) return;

    sel.classList.add('loading');

    var fd = new FormData();
    fd.append('app_id', appId);
    fd.append('status', status);
    fd.append('job_id', jobId);

    fetch('<?= SITE_URL ?>/employer/applications/updateStatus', { method: 'POST', body: fd })
    .then(function(r) {
        if (r.ok) {
            var pill  = document.getElementById('pill-' + appId);
            var label = document.getElementById('pill-label-' + appId);
            if (pill) {
                ALL_PILL_CLS.forEach(function(c){ pill.classList.remove(c); });
                pill.classList.add(meta.cls);
                pill.querySelector('i').className = 'fa ' + meta.icon;
            }
            if (label) label.textContent = meta.label;

            var card = document.getElementById('card-' + appId);
            if (card) {
                card.style.transition = 'background .25s';
                card.style.background = status === 'hired' ? '#f0fdf4'
                                      : status === 'rejected' ? '#fff5f5' : '#f0f6ff';
                setTimeout(function(){ card.style.background = ''; }, 1200);
            }
            showToast(meta.toast, meta.msg);
        } else {
            showToast('error', 'Update failed. Please try again.');
        }
    })
    .catch(function() { showToast('error', 'Connection error. Please try again.'); })
    .finally(function() { sel.classList.remove('loading'); });
}

var _toastTimer = null;
function showToast(type, msg) {
    var t = document.getElementById('ea-toast');
    if (!t) return;
    clearTimeout(_toastTimer);
    t.className = 'ea-toast ea-toast--' + type + ' show';
    t.innerHTML = '<i class="fa ' + (type==='success'?'fa-check-circle':type==='error'?'fa-exclamation-circle':'fa-info-circle') + '"></i>'
                + '<span>' + msg + '</span>'
                + '<button class="ea-toast__close" onclick="hideToast()">&times;</button>';
    _toastTimer = setTimeout(hideToast, 4500);
}
function hideToast() {
    var t = document.getElementById('ea-toast');
    if (t) t.classList.remove('show');
}
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>