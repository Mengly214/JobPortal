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
                    <option value="hired"     <?= (($_GET['status'] ?? '') === 'hired')     ? 'selected' : '' ?>>Hired</option>
                    <option value="rejected"  <?= (($_GET['status'] ?? '') === 'rejected')  ? 'selected' : '' ?>>Rejected</option>
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
                            'rejected','withdrawn' => 'status-red',
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
                        $deadlineStr   = $app['deadline'] ?? null;
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
                            <a href="<?= SITE_URL ?>/jobs/view/<?= $app['job_id'] ?? 0 ?>" class="job-link">
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
                                <span><?= htmlspecialchars($app['company_name'] ?? 'Company Name') ?></span>
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
                            <?php if (!empty($app['cv_file'])): ?>
                            <a href="<?= SITE_URL ?>/uploads/cvs/<?= htmlspecialchars($app['cv_file']) ?>"
                               download class="act-btn">
                                <i class="fa fa-download"></i> Resume
                            </a>
                            <?php endif; ?>

                            <a href="<?= SITE_URL ?>/jobs/view/<?= $app['job_id'] ?? 0 ?>" class="act-btn">
                                <i class="fa fa-eye"></i> View
                            </a>

                            <?php if (in_array($status, ['submitted', 'reviewing', 'shortlisted'])): ?>
                            <form action="<?= SITE_URL ?>/applications/cancel/<?= $app['id'] ?>"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to withdraw this application?');"
                                  style="display:inline;">
                                <button type="submit" class="act-btn act-btn--danger">
                                    <i class="fa fa-times"></i> Withdraw
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>
    </div>
</section>

<!-- ======================================================
     STYLES
====================================================== -->
<style>
/* ─── PAGE HERO ───────────────────────────────────────── */
.jg-page-hero {
    position: relative;
    margin-top: -70px;
    padding-top: 150px;
    padding-bottom: 60px;
    overflow: hidden;
    min-height: 280px;
    display: flex;
    align-items: flex-end;
}
.jg-page-hero__photo {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1600&q=60&fit=crop&crop=top')
                center center / cover no-repeat;
    transform: scale(1.03);
}
.jg-page-hero__overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(5,14,30,.90) 0%, rgba(10,60,130,.82) 60%, rgba(5,14,30,.70) 100%);
}
.jg-page-hero__inner { position: relative; z-index: 2; }
.jg-breadcrumb {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: rgba(255,255,255,.55); margin-bottom: 14px;
}
.jg-breadcrumb a { color: rgba(255,255,255,.65); text-decoration: none; }
.jg-breadcrumb a:hover { color: #fff; }
.jg-breadcrumb i { font-size: 11px; }
.jg-breadcrumb span { color: rgba(255,255,255,.85); }
.jg-page-hero__title {
    font-size: 40px; font-weight: 800; color: #fff;
    letter-spacing: -1.5px; margin: 0 0 10px; line-height: 1.1;
}
.jg-page-hero__sub { font-size: 16px; color: rgba(255,255,255,.70); margin: 0; }

/* ─── FILTER BAR ──────────────────────────────────────── */
.jg-filterbar-wrap {
    background: #fff;
    border-bottom: 1px solid #e8edf5;
    box-shadow: 0 4px 24px rgba(10,50,120,.07);
    position: sticky; top: 70px; z-index: 800;
}
.jg-filterbar {
    display: flex; align-items: center;
    flex-wrap: wrap; gap: 0;
    min-height: 62px;
    border: 1.5px solid #e0e6f0;
    border-radius: 12px;
    overflow: hidden;
    margin: 14px 0;
    background: #fff;
}
.jg-filterbar__field {
    display: flex; align-items: center;
    flex: 0 0 auto; padding: 0 18px;
    min-height: 62px;
}
.jg-filterbar__field--grow { flex: 1 1 180px; }
.jg-filterbar__field i { color: #0a65cc; font-size: 15px; margin-right: 10px; flex-shrink: 0; }
.jg-filterbar__field input,
.jg-filterbar__field select {
    border: none; outline: none; background: transparent;
    font-size: 14px; color: #333; width: 100%;
    -webkit-appearance: none; appearance: none; cursor: pointer;
}
.jg-filterbar__field input::placeholder { color: #aaa; }
.jg-filterbar__field--select { min-width: 180px; }
.jg-filterbar__sep { width: 1px; align-self: stretch; background: #e8edf5; margin: 10px 0; flex-shrink: 0; }
.jg-filterbar__btn {
    background: linear-gradient(135deg, #0a65cc, #0853aa);
    color: #fff; border: none; font-size: 14px; font-weight: 700;
    padding: 0 28px; min-height: 62px; cursor: pointer;
    white-space: nowrap; transition: .2s;
    display: flex; align-items: center; gap: 8px;
    border-radius: 0 10px 10px 0;
}
.jg-filterbar__btn:hover { background: linear-gradient(135deg, #084fa3, #063d82); }
.jg-filterbar__clear {
    display: flex; align-items: center; justify-content: center;
    width: 40px; height: 40px; border-radius: 8px; margin: 0 8px;
    color: #aaa; font-size: 14px; text-decoration: none;
    border: 1.5px solid #e8edf5; transition: .2s; flex-shrink: 0;
}
.jg-filterbar__clear:hover { border-color: #e74c3c; color: #e74c3c; background: #fef2f2; }

/* ─── SECTION ─────────────────────────────────────────── */
.jg-apps-section { padding: 36px 0 70px; background: #f5f7fb; min-height: 400px; }

/* ─── RESULTS BAR ─────────────────────────────────────── */
.jg-results-bar { display: flex; align-items: center; margin-bottom: 18px; }
.jg-results-bar__count { font-size: 14px; color: #666; margin: 0; }
.jg-results-bar__count strong { color: #1a1a2e; }

/* ─── TABLE ───────────────────────────────────────────── */
.jg-apps-table-wrap {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #e8edf5;
    box-shadow: 0 4px 24px rgba(10,50,120,.06);
    overflow: hidden;
}
.jg-apps-table { width: 100%; border-collapse: collapse; }
.jg-apps-table thead th {
    background: #f8fafd;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 14px 18px;
    border-bottom: 1.5px solid #e8edf5;
    white-space: nowrap;
}
.jg-apps-table tbody tr {
    border-bottom: 1px solid #f0f4f9;
    transition: background .15s;
}
.jg-apps-table tbody tr:last-child { border-bottom: none; }
.jg-apps-table tbody tr:hover { background: #f7faff; }
.jg-apps-table tbody tr.accent-yellow { border-left: 4px solid #f59e0b; }
.jg-apps-table tbody tr.accent-blue   { border-left: 4px solid #0a65cc; }
.jg-apps-table td { padding: 16px 18px; vertical-align: middle; font-size: 14px; color: #64748b; }

/* ─── JOB CELL ────────────────────────────────────────── */
.job-title { display: block; font-weight: 700; color: #1a1a2e; margin-bottom: 3px; font-size: 14px; }
.job-link { font-size: 12px; color: #0a65cc; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
.job-link:hover { text-decoration: underline; }
.job-link i { font-size: 10px; }

/* ─── COMPANY CELL ────────────────────────────────────── */
.company-cell { display: flex; align-items: center; gap: 10px; }
.company-logo {
    width: 36px; height: 36px; border-radius: 8px;
    object-fit: cover; border: 1.5px solid #e8edf5; flex-shrink: 0;
}
.company-initial {
    width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #0a65cc, #14a077);
    color: #fff; font-size: 15px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}

/* ─── DATE ────────────────────────────────────────────── */
.date-text { display: block; color: #94a3b8; font-size: 13px; }

/* ─── DEADLINE BADGE ──────────────────────────────────── */
.dl-badge {
    display: inline-block; margin-top: 4px;
    padding: 2px 8px; border-radius: 20px;
    font-size: 11px; font-weight: 700;
}
.dl-green { background: #e8f5e9; color: #2e7d32; }
.dl-red   { background: #fef2f2; color: #e53935; }

/* ─── STATUS PILL ─────────────────────────────────────── */
.status-pill {
    display: inline-block; padding: 5px 12px;
    border-radius: 20px; font-size: 11px;
    font-weight: 700; white-space: nowrap;
}
.status-teal  { background: #e0f7f0; color: #0d7a57; }
.status-blue  { background: #e8f0fe; color: #0a65cc; }
.status-green { background: #e8f5e9; color: #2e7d32; }
.status-red   { background: #fef2f2; color: #e53935; }
.status-gray  { background: #f1f5f9; color: #64748b; }

/* ─── ACTION BUTTONS ──────────────────────────────────── */
.act-btn {
    display: inline-flex; align-items: center; gap: 5px;
    background: #fff; border: 1.5px solid #e8edf5;
    color: #64748b; font-size: 12px; font-weight: 600;
    padding: 5px 11px; border-radius: 6px;
    text-decoration: none; cursor: pointer;
    transition: .2s; margin-right: 4px; margin-bottom: 4px;
}
.act-btn:hover { background: #f5f7fb; color: #1a1a2e; border-color: #c5d0e0; text-decoration: none; }
.act-btn i { font-size: 11px; }
.act-btn--danger { border-color: #fca5a5; color: #e53935; }
.act-btn--danger:hover { background: #fef2f2; border-color: #e53935; color: #c0392b; }

/* ─── EMPTY STATE ─────────────────────────────────────── */
.jg-empty {
    text-align: center; padding: 80px 20px;
    background: #fff; border-radius: 16px;
    border: 1.5px dashed #d0daea;
}
.jg-empty__icon {
    width: 72px; height: 72px; border-radius: 50%;
    background: #f0f5ff; margin: 0 auto 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; color: #0a65cc;
}
.jg-empty h3 { font-size: 22px; font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
.jg-empty p  { color: #888; font-size: 15px; }

/* ─── BUTTONS ─────────────────────────────────────────── */
.jg-btn { display: inline-flex; align-items: center; gap: 7px; font-weight: 700; text-decoration: none; border-radius: 8px; border: none; cursor: pointer; transition: .2s; }
.jg-btn--primary { background: #0a65cc; color: #fff; padding: 10px 22px; font-size: 14px; }
.jg-btn--primary:hover { background: #084fa3; color: #fff; }

/* ─── REVEAL ──────────────────────────────────────────── */
.js-reveal { opacity: 0; transform: translateY(20px); transition: opacity .5s cubic-bezier(.22,1,.36,1), transform .5s cubic-bezier(.22,1,.36,1); }
.js-reveal.visible { opacity: 1; transform: translateY(0); }

/* ─── RESPONSIVE ──────────────────────────────────────── */
@media (max-width: 767px) {
    .jg-page-hero { padding-top: 120px; padding-bottom: 40px; }
    .jg-page-hero__title { font-size: 28px; }
    .jg-filterbar { flex-direction: column; border-radius: 10px; }
    .jg-filterbar__field { width: 100%; min-height: 50px; padding: 0 16px; border-bottom: 1px solid #e8edf5; }
    .jg-filterbar__sep { display: none; }
    .jg-filterbar__btn { width: 100%; justify-content: center; border-radius: 0 0 8px 8px; }
    .jg-filterbar__clear { margin: 8px auto; }
    .jg-apps-table-wrap { overflow-x: auto; }
    .jg-apps-table { min-width: 700px; }
}
</style>

<script>
(function(){
    var els = document.querySelectorAll('.js-reveal');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.08 });
        els.forEach(function(el){ obs.observe(el); });
    } else {
        els.forEach(function(el){ el.classList.add('visible'); });
    }

    var ph = document.querySelector('.jg-page-hero__photo');
    if (ph) {
        window.addEventListener('scroll', function(){
            ph.style.transform = 'scale(1.03) translateY(' + (window.scrollY * .06) + 'px)';
        }, { passive: true });
    }
})();
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>