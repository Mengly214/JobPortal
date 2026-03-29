<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- PAGE HERO -->
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

<!-- FILTER BAR -->
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
                    <option value="submitted"   <?= (($_GET['status'] ?? '') === 'submitted')   ? 'selected' : '' ?>>Application Received</option>
                    <option value="reviewing"   <?= (($_GET['status'] ?? '') === 'reviewing')   ? 'selected' : '' ?>>In Review</option>
                    <option value="shortlisted" <?= (($_GET['status'] ?? '') === 'shortlisted') ? 'selected' : '' ?>>Shortlisted</option>
                    <option value="interview"   <?= (($_GET['status'] ?? '') === 'interview')   ? 'selected' : '' ?>>Interview</option>
                    <option value="offered"     <?= (($_GET['status'] ?? '') === 'offered')     ? 'selected' : '' ?>>Offer Received</option>
                    <option value="hired"       <?= (($_GET['status'] ?? '') === 'hired')       ? 'selected' : '' ?>>Hired</option>
                    <option value="rejected"    <?= (($_GET['status'] ?? '') === 'rejected')    ? 'selected' : '' ?>>Rejected</option>
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

<!-- MAIN CONTENT -->
<section class="jg-apps-section">
    <div class="container">

        <?php if (empty($applications)): ?>
            <div class="jg-empty">
                <div class="jg-empty__icon"><i class="fa fa-file-text-o"></i></div>
                <h3>No Applications Yet</h3>
                <p>You haven't applied to any jobs yet. Start exploring opportunities!</p>
                <a href="<?= SITE_URL ?>/jobs" class="jg-btn jg-btn--primary" style="margin-top:16px;">
                    <i class="fa fa-search"></i> Browse Jobs
                </a>
            </div>

        <?php else: ?>

            <div class="jg-results-bar">
                <p class="jg-results-bar__count">
                    Showing <strong><?= count($applications) ?></strong> application(s)
                </p>
            </div>

            <div class="jg-apps-cards js-reveal">
                <?php foreach ($applications as $app):

                    $status = $app['status'];

                    $statusConfig = match($status) {
                        'submitted' => [
                            'pill'    => 'status-teal',
                            'label'   => 'Application Received',
                            'icon'    => 'fa-paper-plane',
                            'banner'  => 'banner-teal',
                            'heading' => 'Your application was received!',
                            'message' => 'The employer has received your application and will review it soon. Hang tight!',
                            'tip'     => null,
                        ],
                        'reviewing' => [
                            'pill'    => 'status-blue',
                            'label'   => 'Under Review',
                            'icon'    => 'fa-search',
                            'banner'  => 'banner-blue',
                            'heading' => 'Your application is being reviewed.',
                            'message' => 'The employer is actively looking at your profile. This is a great sign — they are interested!',
                            'tip'     => 'Make sure your profile is complete and up to date.',
                        ],
                        'shortlisted' => [
                            'pill'    => 'status-purple',
                            'label'   => 'Shortlisted',
                            'icon'    => 'fa-star',
                            'banner'  => 'banner-purple',
                            'heading' => 'You\'ve been shortlisted! ⭐',
                            'message' => 'The employer has added you to their shortlist. You are among the top candidates for this role!',
                            'tip'     => 'Be ready — an interview invitation may follow soon.',
                        ],
                        'interview' => [
                            'pill'    => 'status-orange',
                            'label'   => 'Interview Scheduled',
                            'icon'    => 'fa-calendar',
                            'banner'  => 'banner-orange',
                            'heading' => 'Interview Scheduled!',
                            'message' => 'The employer is interested in you! They will contact you via email or phone to arrange the interview details.',
                            'tip'     => 'Check your email regularly and keep your phone on. Prepare well!',
                        ],
                        'offered' => [
                            'pill'    => 'status-indigo',
                            'label'   => 'Offer Received',
                            'icon'    => 'fa-envelope-open',
                            'banner'  => 'banner-indigo',
                            'heading' => 'You received a job offer! 🎉',
                            'message' => 'Congratulations! The employer has extended an offer to you. Review the details carefully and respond promptly.',
                            'tip'     => 'Check your email for the official offer letter.',
                        ],
                        'hired' => [
                            'pill'    => 'status-green',
                            'label'   => 'Hired',
                            'icon'    => 'fa-trophy',
                            'banner'  => 'banner-green',
                            'heading' => 'Congratulations — you got the job! 🎉',
                            'message' => 'You have been selected for this position. The employer will be in touch with onboarding details soon. Well done!',
                            'tip'     => null,
                        ],
                        'rejected' => [
                            'pill'    => 'status-red',
                            'label'   => 'Not Selected',
                            'icon'    => 'fa-times-circle',
                            'banner'  => 'banner-red',
                            'heading' => 'Application not selected.',
                            'message' => 'Unfortunately, the employer decided to move forward with other candidates. Do not give up — keep applying!',
                            'tip'     => 'Every rejection brings you closer to the right opportunity.',
                        ],
                        'withdrawn' => [
                            'pill'    => 'status-gray',
                            'label'   => 'Withdrawn',
                            'icon'    => 'fa-minus-circle',
                            'banner'  => 'banner-gray',
                            'heading' => 'You withdrew this application.',
                            'message' => 'You chose to withdraw from this role. You can always explore similar positions.',
                            'tip'     => null,
                        ],
                        default => [
                            'pill'    => 'status-gray',
                            'label'   => ucfirst($status),
                            'icon'    => 'fa-circle',
                            'banner'  => 'banner-gray',
                            'heading' => 'Status updated.',
                            'message' => '',
                            'tip'     => null,
                        ],
                    };

                    // Deadline
                    $deadlineStr   = $app['application_deadline'] ?? null;
                    $deadlineLabel = '';
                    $deadlineClass = '';
                    if ($deadlineStr) {
                        $today       = new DateTime();
                        $deadlineObj = new DateTime($deadlineStr);
                        $daysLeft    = (int)$today->diff($deadlineObj)->format('%r%a');
                        if ($daysLeft < 0)       { $deadlineLabel = 'Expired';  $deadlineClass = 'dl-red'; }
                        elseif ($daysLeft <= 7)  { $deadlineLabel = $daysLeft . ' day' . ($daysLeft === 1 ? '' : 's') . ' left'; $deadlineClass = 'dl-red'; }
                        else                     { $deadlineLabel = $daysLeft . ' days left'; $deadlineClass = 'dl-green'; }
                    }
                ?>

                <!-- Application Card -->
                <div class="app-card <?= $statusConfig['banner'] ?>">

                    <!-- Top: company + job info -->
                    <div class="app-card__top">

                        <div class="app-card__logo">
                            <?php if (!empty($app['company_logo'])): ?>
                                <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($app['company_logo']) ?>"
                                     alt="<?= htmlspecialchars($app['company_name'] ?? '') ?>">
                            <?php else: ?>
                                <div class="app-card__initial">
                                    <?= strtoupper(substr($app['company_name'] ?? 'C', 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="app-card__info">
                            <div class="app-card__job-title"><?= htmlspecialchars($app['job_title']) ?></div>
                            <div class="app-card__company-name">
                                <?= htmlspecialchars($app['company_name'] ?? 'N/A') ?>
                                <?php if (!empty($app['employer_id'])): ?>
                                    <a href="<?= SITE_URL ?>/seeker/employer/<?= $app['employer_id'] ?>" class="app-card__company-link">
                                        <i class="fa fa-external-link"></i> View Company
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="app-card__meta">
                                <span><i class="fa fa-calendar-o"></i> Applied: <?= date('d M Y', strtotime($app['applied_at'])) ?></span>
                                <?php if ($deadlineStr): ?>
                                    <span class="app-card__meta-sep">·</span>
                                    <span>Deadline: <?= date('d M Y', strtotime($deadlineStr)) ?></span>
                                    <span class="dl-badge <?= $deadlineClass ?>"><?= $deadlineLabel ?></span>
                                <?php endif; ?>
                                <a href="<?= SITE_URL ?>/jobs/<?= $app['job_id'] ?? 0 ?>" class="app-card__view-job">
                                    <i class="fa fa-external-link"></i> View Job
                                </a>
                            </div>
                        </div>

                        <div class="app-card__status-wrap">
                            <span class="status-pill <?= $statusConfig['pill'] ?>">
                                <i class="fa <?= $statusConfig['icon'] ?>"></i>
                                <?= $statusConfig['label'] ?>
                            </span>
                        </div>

                    </div><!-- /.app-card__top -->

                    <!-- Status banner -->
                    <div class="app-card__banner">
                        <div class="app-card__banner-icon">
                            <i class="fa <?= $statusConfig['icon'] ?>"></i>
                        </div>
                        <div class="app-card__banner-body">
                            <div class="app-card__banner-heading"><?= $statusConfig['heading'] ?></div>
                            <div class="app-card__banner-msg"><?= $statusConfig['message'] ?></div>
                            <?php if (!empty($statusConfig['tip'])): ?>
                                <div class="app-card__banner-tip">
                                    <i class="fa fa-lightbulb-o"></i> <?= $statusConfig['tip'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer: actions -->
                    <div class="app-card__footer">
                        <?php if (!in_array($status, ['hired', 'rejected', 'withdrawn'])): ?>
                            <form action="<?= SITE_URL ?>/seeker/withdraw" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Are you sure you want to withdraw this application?');">
                                <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                <button type="submit" class="act-btn act-btn--danger">
                                    <i class="fa fa-times"></i> Withdraw
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="app-card__footer-note">No further actions available.</span>
                        <?php endif; ?>
                    </div>

                </div><!-- /.app-card -->

            <?php endforeach; ?>
            </div><!-- /.jg-apps-cards -->

        <?php endif; ?>
    </div>
</section>

<style>
.jg-apps-cards { display:flex; flex-direction:column; gap:16px; }

/* Card shell */
.app-card { background:#fff; border-radius:14px; border:1.5px solid #e8edf5; box-shadow:0 2px 12px rgba(10,50,120,.05); overflow:hidden; transition:box-shadow .2s; }
.app-card:hover { box-shadow:0 6px 24px rgba(10,50,120,.10); }

/* Top row */
.app-card__top { display:flex; align-items:flex-start; gap:16px; padding:20px 22px 16px; }
.app-card__logo img, .app-card__initial { width:52px; height:52px; border-radius:10px; flex-shrink:0; object-fit:cover; border:1.5px solid #e8edf5; display:flex; align-items:center; justify-content:center; }
.app-card__initial { background:linear-gradient(135deg,#0a65cc,#14a077); color:#fff; font-size:20px; font-weight:700; }
.app-card__info { flex:1; min-width:0; }
.app-card__job-title { font-size:16px; font-weight:700; color:#1a1a2e; margin-bottom:3px; }
.app-card__company-name { font-size:13px; color:#64748b; display:flex; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:6px; }
.app-card__company-link { font-size:11px; color:#0a65cc; text-decoration:none; font-weight:600; }
.app-card__company-link:hover { text-decoration:underline; }
.app-card__meta { display:flex; align-items:center; flex-wrap:wrap; gap:6px; font-size:12px; color:#94a3b8; }
.app-card__meta i { color:#0a65cc; }
.app-card__meta-sep { color:#d0d9e8; }
.app-card__view-job { font-size:12px; color:#0a65cc; text-decoration:none; font-weight:600; margin-left:4px; }
.app-card__view-job:hover { text-decoration:underline; }
.app-card__status-wrap { flex-shrink:0; padding-top:2px; }

/* Status pills */
.status-pill { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; }
.status-pill i { font-size:10px; }
.status-teal   { background:#e0f7f0; color:#0d7a57; }
.status-blue   { background:#e8f0fe; color:#0a65cc; }
.status-purple { background:#f0ebff; color:#6c3fc5; }
.status-orange { background:#fff4e5; color:#b45309; }
.status-indigo { background:#eef2ff; color:#3730a3; }
.status-green  { background:#e8f5e9; color:#2e7d32; }
.status-red    { background:#fef2f2; color:#e53935; }
.status-gray   { background:#f1f5f9; color:#64748b; }

/* Banners */
.app-card__banner { display:flex; align-items:flex-start; gap:14px; padding:14px 22px; border-top:1px solid #f0f4f9; border-left:5px solid #ccc; }
.app-card__banner-icon { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; margin-top:2px; }
.app-card__banner-body { flex:1; }
.app-card__banner-heading { font-size:14px; font-weight:700; margin-bottom:3px; }
.app-card__banner-msg { font-size:13px; line-height:1.6; }
.app-card__banner-tip { margin-top:7px; font-size:12px; font-weight:600; display:flex; align-items:center; gap:5px; }

.banner-teal   .app-card__banner { border-left-color:#0d7a57; background:#f0fdf8; }
.banner-teal   .app-card__banner-icon { background:#ccf2e5; color:#0d7a57; }
.banner-teal   .app-card__banner-heading { color:#0d7a57; }
.banner-teal   .app-card__banner-msg { color:#2e7d60; }
.banner-teal   .app-card__banner-tip { color:#0d7a57; }

.banner-blue   .app-card__banner { border-left-color:#0a65cc; background:#f0f6ff; }
.banner-blue   .app-card__banner-icon { background:#d4e6fb; color:#0a65cc; }
.banner-blue   .app-card__banner-heading { color:#084fa3; }
.banner-blue   .app-card__banner-msg { color:#2a5090; }
.banner-blue   .app-card__banner-tip { color:#0a65cc; }

.banner-purple .app-card__banner { border-left-color:#6c3fc5; background:#f7f3ff; }
.banner-purple .app-card__banner-icon { background:#e4d9fb; color:#6c3fc5; }
.banner-purple .app-card__banner-heading { color:#6c3fc5; }
.banner-purple .app-card__banner-msg { color:#5a35a8; }
.banner-purple .app-card__banner-tip { color:#6c3fc5; }

.banner-orange .app-card__banner { border-left-color:#b45309; background:#fffbf0; }
.banner-orange .app-card__banner-icon { background:#fde9b8; color:#b45309; }
.banner-orange .app-card__banner-heading { color:#92400e; }
.banner-orange .app-card__banner-msg { color:#7c3c0c; }
.banner-orange .app-card__banner-tip { color:#b45309; }

.banner-indigo .app-card__banner { border-left-color:#3730a3; background:#f1f0ff; }
.banner-indigo .app-card__banner-icon { background:#d4d3f8; color:#3730a3; }
.banner-indigo .app-card__banner-heading { color:#3730a3; }
.banner-indigo .app-card__banner-msg { color:#312e81; }
.banner-indigo .app-card__banner-tip { color:#3730a3; }

.banner-green  .app-card__banner { border-left-color:#2e7d32; background:#f0fdf4; }
.banner-green  .app-card__banner-icon { background:#bbf7c5; color:#2e7d32; }
.banner-green  .app-card__banner-heading { color:#1a5c1d; }
.banner-green  .app-card__banner-msg { color:#2d6a31; }
.banner-green  .app-card__banner-tip { color:#2e7d32; }

.banner-red    .app-card__banner { border-left-color:#e53935; background:#fff5f5; }
.banner-red    .app-card__banner-icon { background:#fcd5d4; color:#e53935; }
.banner-red    .app-card__banner-heading { color:#c0392b; }
.banner-red    .app-card__banner-msg { color:#a93226; }
.banner-red    .app-card__banner-tip { color:#e53935; }

.banner-gray   .app-card__banner { border-left-color:#94a3b8; background:#f8fafc; }
.banner-gray   .app-card__banner-icon { background:#e2e8f0; color:#64748b; }
.banner-gray   .app-card__banner-heading { color:#475569; }
.banner-gray   .app-card__banner-msg { color:#64748b; }
.banner-gray   .app-card__banner-tip { color:#64748b; }

/* Footer */
.app-card__footer { padding:12px 22px; border-top:1px solid #f0f4f9; background:#fafbfc; display:flex; align-items:center; gap:8px; }
.app-card__footer-note { font-size:12px; color:#94a3b8; font-style:italic; }

/* Deadline badges */
.dl-badge { display:inline-block; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:700; }
.dl-green { background:#e8f5e9; color:#2e7d32; }
.dl-red   { background:#fef2f2; color:#e53935; }

/* Action buttons */
.act-btn { display:inline-flex; align-items:center; gap:5px; background:#fff; border:1.5px solid #e8edf5; color:#64748b; font-size:12px; font-weight:600; padding:5px 13px; border-radius:6px; cursor:pointer; transition:.2s; }
.act-btn:hover { background:#f5f7fb; color:#1a1a2e; border-color:#c5d0e0; }
.act-btn--danger { border-color:#fca5a5; color:#e53935; }
.act-btn--danger:hover { background:#fef2f2; border-color:#e53935; color:#c0392b; }

/* Reveal */
.js-reveal { opacity:0; transform:translateY(20px); transition:opacity .5s cubic-bezier(.22,1,.36,1),transform .5s cubic-bezier(.22,1,.36,1); }
.js-reveal.visible { opacity:1; transform:translateY(0); }

@media (max-width:767px) {
    .app-card__top { flex-wrap:wrap; }
    .app-card__status-wrap { order:-1; width:100%; }
    .app-card__banner { flex-direction:column; }
}
</style>

<script>
(function(){
    var els = document.querySelectorAll('.js-reveal');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.05 });
        els.forEach(function(el){ obs.observe(el); });
    } else { els.forEach(function(el){ el.classList.add('visible'); }); }

    var ph = document.querySelector('.jg-page-hero__photo');
    if (ph) { window.addEventListener('scroll', function(){ ph.style.transform = 'scale(1.03) translateY('+(window.scrollY*.06)+'px)'; }, { passive:true }); }
})();
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>