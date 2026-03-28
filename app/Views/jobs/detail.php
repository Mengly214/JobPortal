<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- ======================================================
     PAGE HERO
====================================================== -->
<div class="jg-page-hero jg-page-hero--detail">
    <div class="jg-page-hero__photo"></div>
    <div class="jg-page-hero__overlay"></div>
    <div class="container jg-page-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?php echo SITE_URL; ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?php echo SITE_URL; ?>/jobs">Jobs</a>
            <i class="fa fa-angle-right"></i>
            <span><?php echo clean($job['title']); ?></span>
        </div>
        <h1 class="jg-page-hero__title"><?php echo clean($job['title']); ?></h1>
        <?php if (!empty($job['company_name'])): ?>
        <p class="jg-page-hero__sub">
            <i class="fa fa-building-o"></i> <?php echo clean($job['company_name']); ?>
            &ensp;·&ensp;
            <i class="fa fa-map-marker"></i> <?php echo clean($job['location_city']??'Remote'); ?>
            &ensp;·&ensp;
            <i class="fa fa-clock-o"></i> <?php echo ucfirst(str_replace('_',' ',$job['job_type'])); ?>
        </p>
        <?php endif; ?>
    </div>
</div>

<!-- ======================================================
     MAIN LAYOUT
====================================================== -->
<section class="jg-detail-section">
<div class="container">
<div class="row">

    <!-- ── LEFT COLUMN ───────────────────────────────── -->
    <div class="col-md-8">

        <!-- Job Header Card -->
        <div class="jg-card jg-card--header js-reveal">
            <div class="jg-card-header__logo">
                <?php if (!empty($job['job_image'])): ?>
                    <img src="<?php echo SITE_URL.'/uploads/jobs/'.clean($job['job_image']); ?>" alt="">
                <?php elseif (!empty($job['logo'])): ?>
                    <img src="<?php echo SITE_URL.'/uploads/logos/'.clean($job['logo']); ?>" alt="">
                <?php else: ?>
                    <span class="jg-card-header__initial">
                        <?php echo strtoupper(substr($job['company_name']??$job['title'],0,1)); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="jg-card-header__info">
                <?php if ($job['is_featured']): ?>
                <span class="jg-featured-pill"><i class="fa fa-star"></i> Featured</span>
                <?php endif; ?>
                <h2><?php echo clean($job['title']); ?></h2>
                <?php if (!empty($job['company_name'])): ?>
                <p class="jg-card-header__company">
                    <i class="fa fa-building-o"></i> <?php echo clean($job['company_name']); ?>
                </p>
                <?php endif; ?>
                <div class="jg-meta-row">
                    <span class="jg-meta-chip"><i class="fa fa-map-marker"></i> <?php echo clean($job['location_city']??'Remote'); ?></span>
                    <span class="jg-meta-chip"><i class="fa fa-clock-o"></i> <?php echo ucfirst(str_replace('_',' ',$job['job_type'])); ?></span>
                    <span class="jg-meta-chip"><i class="fa fa-laptop"></i> <?php echo ucfirst(str_replace('_',' ',$job['work_mode'])); ?></span>
                    <?php if ($job['salary_visible'] && $job['salary_min']): ?>
                    <span class="jg-meta-chip jg-meta-chip--green">
                        <i class="fa fa-money"></i>
                        $<?php echo number_format($job['salary_min']); ?><?php if ($job['salary_max']): ?>–$<?php echo number_format($job['salary_max']); ?><?php endif; ?>
                        / <?php echo $job['salary_period']??'year'; ?>
                    </span>
                    <?php endif; ?>
                    <span class="jg-meta-chip"><i class="fa fa-eye"></i> <?php echo number_format($job['views']??0); ?> views</span>
                </div>
                <?php if (!empty($skills)): ?>
                <div class="jg-skills">
                    <?php foreach ($skills as $s): ?>
                    <span class="jg-skill <?php echo $s['is_required']?'jg-skill--required':''; ?>">
                        <?php echo clean($s['name']); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <div class="jg-card js-reveal" data-reveal-delay="60">
            <div class="jg-card__section-title">
                <div class="jg-card__section-icon"><i class="fa fa-align-left"></i></div>
                Job Description
            </div>
            <div class="jg-prose"><?php echo nl2br(clean($job['description'])); ?></div>

            <?php if (!empty($job['requirements'])): ?>
            <div class="jg-card__section-title" style="margin-top:32px">
                <div class="jg-card__section-icon jg-card__section-icon--amber"><i class="fa fa-list-ul"></i></div>
                Requirements
            </div>
            <div class="jg-prose"><?php echo nl2br(clean($job['requirements'])); ?></div>
            <?php endif; ?>

            <?php if (!empty($job['benefits'])): ?>
            <div class="jg-card__section-title" style="margin-top:32px">
                <div class="jg-card__section-icon jg-card__section-icon--green"><i class="fa fa-gift"></i></div>
                Benefits
            </div>
            <div class="jg-prose"><?php echo nl2br(clean($job['benefits'])); ?></div>
            <?php endif; ?>
        </div>

        <!-- Apply Form -->
        <div class="jg-card jg-card--apply js-reveal" data-reveal-delay="120" id="apply">
            <div class="jg-card__section-title">
                <div class="jg-card__section-icon jg-card__section-icon--blue"><i class="fa fa-paper-plane"></i></div>
                Apply for this Job
            </div>

            <?php if ($appSuccess): ?>
            <div class="jg-alert jg-alert--success">
                <i class="fa fa-check-circle"></i> <?php echo $appSuccess; ?>
            </div>
            <?php elseif ($appError): ?>
            <div class="jg-alert jg-alert--danger">
                <i class="fa fa-times-circle"></i> <?php echo $appError; ?>
            </div>
            <?php endif; ?>

            <?php if (!$appSuccess): ?>
            <form action="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>/apply" method="post">
                <div class="jg-form-group">
                    <label class="jg-form-label">
                        Cover Letter
                        <span class="jg-form-label__opt">optional</span>
                    </label>
                    <textarea name="cover_letter" class="jg-form-control" rows="7"
                              placeholder="Introduce yourself and explain why you're a great fit..."></textarea>
                </div>
                <?php if (isLoggedIn() && userRole()==='job_seeker'): ?>
                <button type="submit" class="jg-btn jg-btn--primary jg-btn--lg">
                    <i class="fa fa-paper-plane"></i> Submit Application
                </button>
                <?php else: ?>
                <a href="<?php echo SITE_URL; ?>/login" class="jg-btn jg-btn--primary jg-btn--lg">
                    <i class="fa fa-sign-in"></i> Login to Apply
                </a>
                <?php endif; ?>
            </form>
            <?php endif; ?>
        </div>

        <a href="<?php echo SITE_URL; ?>/jobs" class="jg-back-link">
            <i class="fa fa-arrow-left"></i> Back to Jobs
        </a>
    </div>

    <!-- ── SIDEBAR ────────────────────────────────────── -->
    <div class="col-md-4">

        <!-- Apply CTA (sticky) -->
        <div class="jg-sidebar-sticky">

            <!-- Job Overview -->
            <div class="jg-card jg-card--sidebar js-reveal" data-reveal-delay="80">
                <div class="jg-card__section-title">
                    <div class="jg-card__section-icon"><i class="fa fa-info-circle"></i></div>
                    Job Overview
                </div>
                <ul class="jg-overview-list">
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-calendar"></i></div>
                        <div><small>Posted</small><strong><?php echo date('d M Y',strtotime($job['created_at'])); ?></strong></div>
                    </li>
                    <?php if (!empty($job['application_deadline'])): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--red"><i class="fa fa-hourglass-end"></i></div>
                        <div><small>Deadline</small><strong><?php echo date('d M Y',strtotime($job['application_deadline'])); ?></strong></div>
                    </li>
                    <?php endif; ?>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-briefcase"></i></div>
                        <div><small>Job Type</small><strong><?php echo ucfirst(str_replace('_',' ',$job['job_type'])); ?></strong></div>
                    </li>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-laptop"></i></div>
                        <div><small>Work Mode</small><strong><?php echo ucfirst(str_replace('_',' ',$job['work_mode'])); ?></strong></div>
                    </li>
                    <?php if (!empty($job['experience_level'])): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--amber"><i class="fa fa-star"></i></div>
                        <div><small>Experience</small><strong><?php echo ucfirst(str_replace('_',' ',$job['experience_level'])); ?></strong></div>
                    </li>
                    <?php endif; ?>
                    <?php if ($job['salary_visible'] && $job['salary_min']): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--green"><i class="fa fa-money"></i></div>
                        <div>
                            <small>Salary</small>
                            <strong>$<?php echo number_format($job['salary_min']); ?><?php if ($job['salary_max']): ?>–$<?php echo number_format($job['salary_max']); ?><?php endif; ?></strong>
                        </div>
                    </li>
                    <?php endif; ?>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-map-marker"></i></div>
                        <div>
                            <small>Location</small>
                            <strong>
                                <?php echo clean($job['location_city']??'Remote'); ?>
                                <?php if (!empty($job['location_country'])): ?>, <?php echo clean($job['location_country']); ?><?php endif; ?>
                            </strong>
                        </div>
                    </li>
                </ul>
                <a href="#apply" class="jg-btn jg-btn--primary jg-btn--full">
                    <i class="fa fa-paper-plane"></i> Apply Now
                </a>
            </div>

            <!-- Company Info -->
            <div class="jg-card jg-card--sidebar js-reveal" data-reveal-delay="160">
                <div class="jg-card__section-title">
                    <div class="jg-card__section-icon"><i class="fa fa-building"></i></div>
                    About <?php echo clean($job['company_name']??'the Company'); ?>
                </div>
                <?php if (!empty($job['company_desc'])): ?>
                <p class="jg-company-desc"><?php echo clean(substr($job['company_desc'],0,200)); ?>...</p>
                <?php endif; ?>
                <ul class="jg-company-stats">
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-industry"></i></div>
                        <div><small>Industry</small><strong><?php echo clean($job['industry']??'–'); ?></strong></div>
                    </li>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-users"></i></div>
                        <div><small>Company Size</small><strong><?php echo clean($job['company_size']??'–'); ?></strong></div>
                    </li>
                    <?php if (!empty($job['website'])): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--blue"><i class="fa fa-globe"></i></div>
                        <div>
                            <small>Website</small>
                            <strong>
                                <a href="<?php echo clean($job['website']); ?>" target="_blank" rel="noopener" class="jg-link">
                                    <?php echo clean($job['website']); ?>
                                </a>
                            </strong>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div><!-- /.jg-sidebar-sticky -->
    </div>

</div>
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
    padding-bottom: 56px;
    overflow: hidden;
    min-height: 300px;
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
    font-size: 13px; color: rgba(255,255,255,.50); margin-bottom: 14px;
}
.jg-breadcrumb a { color: rgba(255,255,255,.60); text-decoration: none; transition: color .2s; }
.jg-breadcrumb a:hover { color: #fff; }
.jg-breadcrumb span { color: rgba(255,255,255,.85); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 260px; }
.jg-breadcrumb i { font-size: 11px; flex-shrink: 0; }
.jg-page-hero__title {
    font-size: 36px; font-weight: 800; color: #fff;
    letter-spacing: -1px; margin: 0 0 12px; line-height: 1.15;
    animation: pgTitleIn .65s .1s cubic-bezier(.22,1,.36,1) both;
}
.jg-page-hero__sub {
    font-size: 15px; color: rgba(255,255,255,.65); margin: 0;
    display: flex; align-items: center; flex-wrap: wrap; gap: 6px;
    animation: pgTitleIn .65s .22s cubic-bezier(.22,1,.36,1) both;
}
.jg-page-hero__sub i { color: rgba(255,255,255,.45); }
@keyframes pgTitleIn { from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)} }

/* ─── SECTION LAYOUT ──────────────────────────────────── */
.jg-detail-section { padding: 40px 0 80px; background: #f5f7fb; }

/* ─── CARDS ───────────────────────────────────────────── */
.jg-card {
    background: #fff;
    border: 1.5px solid #e8edf5;
    border-radius: 16px;
    padding: 28px 30px;
    margin-bottom: 22px;
    transition: box-shadow .25s;
}
.jg-card:hover { box-shadow: 0 4px 24px rgba(10,60,130,.07); }
.jg-card--sidebar { padding: 24px 22px; }
.jg-card--apply { border-top: 3px solid #0a65cc; }

/* card section title */
.jg-card__section-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 17px; font-weight: 700; color: #1a1a2e;
    margin-bottom: 22px;
}
.jg-card__section-icon {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: #eef3fd; color: #0a65cc;
    display: flex; align-items: center; justify-content: center; font-size: 14px;
}
.jg-card__section-icon--amber { background: #fef3e2; color: #d68910; }
.jg-card__section-icon--green { background: #e8f8f5; color: #148a68; }
.jg-card__section-icon--blue  { background: #eef3fd; color: #0a65cc; }

/* ─── HEADER CARD ─────────────────────────────────────── */
.jg-card--header {
    display: flex; align-items: flex-start; gap: 22px;
    border-left: 4px solid #0a65cc;
}
.jg-card-header__logo {
    width: 80px; height: 80px; flex-shrink: 0;
    border-radius: 14px; overflow: hidden;
    border: 1.5px solid #e8edf5;
    display: flex; align-items: center; justify-content: center;
    background: #f8fafd;
}
.jg-card-header__logo img { width: 100%; height: 100%; object-fit: cover; }
.jg-card-header__initial {
    width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
    font-size: 28px; font-weight: 800; color: #fff;
    background: linear-gradient(135deg, #0a65cc, #14a077);
}
.jg-card-header__info { flex: 1; min-width: 0; }
.jg-card-header__info h2 { font-size: 22px; font-weight: 800; color: #1a1a2e; margin: 6px 0 8px; }
.jg-card-header__company { font-size: 14px; color: #666; margin: 0 0 12px; display: flex; align-items: center; gap: 6px; }

.jg-featured-pill {
    display: inline-flex; align-items: center; gap: 5px;
    background: linear-gradient(135deg, #0a65cc, #14a077);
    color: #fff; font-size: 11px; font-weight: 700;
    letter-spacing: .5px; padding: 3px 10px; border-radius: 20px;
    margin-bottom: 4px;
}

/* meta chips */
.jg-meta-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 14px; }
.jg-meta-chip {
    display: inline-flex; align-items: center; gap: 5px;
    background: #f0f5ff; color: #0a65cc; font-size: 12px; font-weight: 600;
    padding: 4px 12px; border-radius: 20px; border: 1px solid #dce9fb;
}
.jg-meta-chip--green { background: #e8f8f5; color: #148a68; border-color: #b7e5d8; }

/* skills */
.jg-skills { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.jg-skill {
    display: inline-block; font-size: 12px; font-weight: 600;
    background: #f5f7fb; color: #555; border: 1px solid #e0e6f0;
    padding: 3px 12px; border-radius: 20px; transition: .15s;
}
.jg-skill--required {
    background: #fff3e0; color: #d68910; border-color: #fac87a;
}
.jg-skill:hover { border-color: #0a65cc; color: #0a65cc; background: #f0f5ff; }

/* ─── PROSE ───────────────────────────────────────────── */
.jg-prose {
    font-size: 15px; line-height: 1.80; color: #444;
}
.jg-prose p { margin: 0 0 14px; }
.jg-prose ul, .jg-prose ol { padding-left: 22px; margin-bottom: 14px; }
.jg-prose li { margin-bottom: 6px; }

/* ─── ALERTS ──────────────────────────────────────────── */
.jg-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 18px; border-radius: 10px; font-size: 14px; font-weight: 600;
    margin-bottom: 20px;
}
.jg-alert--success { background: #e8f8f5; color: #148a68; border: 1px solid #b7e5d8; }
.jg-alert--danger  { background: #fdeced; color: #c0392b; border: 1px solid #f4b8bb; }

/* ─── FORM ────────────────────────────────────────────── */
.jg-form-group { margin-bottom: 18px; }
.jg-form-label {
    display: block; font-size: 14px; font-weight: 700; color: #1a1a2e;
    margin-bottom: 8px;
}
.jg-form-label__opt { font-weight: 400; color: #aaa; margin-left: 6px; font-size: 12px; }
.jg-form-control {
    width: 100%; border: 1.5px solid #e0e6f0; border-radius: 10px;
    padding: 13px 16px; font-size: 14px; outline: none; transition: .2s;
    background: #fafbfd; font-family: inherit; resize: vertical;
    color: #333;
}
.jg-form-control:focus { border-color: #0a65cc; background: #fff; box-shadow: 0 0 0 3px rgba(10,101,204,.08); }
.jg-form-control::placeholder { color: #bbb; }

/* ─── BUTTONS ─────────────────────────────────────────── */
.jg-btn {
    display: inline-flex; align-items: center; gap: 8px;
    font-weight: 700; text-decoration: none; border-radius: 10px;
    border: none; cursor: pointer; transition: .2s; font-size: 14px;
}
.jg-btn--primary { background: #0a65cc; color: #fff; padding: 11px 24px; }
.jg-btn--primary:hover { background: #084fa3; color: #fff; }
.jg-btn--outline { background: transparent; color: #0a65cc; padding: 10px 22px; border: 2px solid #0a65cc; }
.jg-btn--outline:hover { background: #0a65cc; color: #fff; }
.jg-btn--lg { padding: 13px 28px; font-size: 15px; }
.jg-btn--full { width: 100%; justify-content: center; margin-top: 14px; }

/* ─── OVERVIEW LIST (sidebar) ─────────────────────────── */
.jg-overview-list, .jg-company-stats {
    list-style: none; padding: 0; margin: 0 0 4px;
    display: flex; flex-direction: column; gap: 0;
}
.jg-overview-list li, .jg-company-stats li {
    display: flex; align-items: center; gap: 14px;
    padding: 11px 0;
    border-bottom: 1px solid #f0f4f8;
}
.jg-overview-list li:last-child, .jg-company-stats li:last-child { border-bottom: none; }
.jg-overview-list__icon {
    width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
    background: #eef3fd; color: #0a65cc;
    display: flex; align-items: center; justify-content: center; font-size: 13px;
}
.jg-overview-list__icon--red   { background: #fdeced; color: #c0392b; }
.jg-overview-list__icon--amber { background: #fef3e2; color: #d68910; }
.jg-overview-list__icon--green { background: #e8f8f5; color: #148a68; }
.jg-overview-list__icon--blue  { background: #eef3fd; color: #0a65cc; }
.jg-overview-list small { display: block; font-size: 11px; color: #aaa; line-height: 1; margin-bottom: 3px; }
.jg-overview-list strong, .jg-company-stats strong { font-size: 14px; font-weight: 700; color: #1a1a2e; display: block; }

.jg-company-desc { font-size: 13px; color: #777; line-height: 1.7; margin-bottom: 14px; }
.jg-link { color: #0a65cc; text-decoration: none; word-break: break-all; }
.jg-link:hover { text-decoration: underline; }

/* ─── STICKY SIDEBAR ──────────────────────────────────── */
.jg-sidebar-sticky { position: sticky; top: 88px; }

/* ─── BACK LINK ───────────────────────────────────────── */
.jg-back-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 14px; font-weight: 600; color: #666; text-decoration: none;
    padding: 10px 0; margin-bottom: 10px; transition: color .2s;
}
.jg-back-link:hover { color: #0a65cc; }

/* ─── REVEAL ──────────────────────────────────────────── */
.js-reveal {
    opacity: 0; transform: translateY(22px);
    transition: opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1);
}
.js-reveal.visible { opacity: 1; transform: translateY(0); }

/* ─── RESPONSIVE ──────────────────────────────────────── */
@media (max-width: 991px) {
    .jg-sidebar-sticky { position: static; margin-top: 24px; }
}
@media (max-width: 767px) {
    .jg-page-hero { padding-top: 120px; padding-bottom: 36px; }
    .jg-page-hero__title { font-size: 26px; }
    .jg-card--header { flex-wrap: wrap; }
    .jg-card-header__logo { width: 60px; height: 60px; }
    .jg-card { padding: 20px 18px; }
    .jg-breadcrumb span { max-width: 160px; }
}
</style>

<script>
(function(){
    /* Reveal */
    var els = document.querySelectorAll('.js-reveal');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if (e.isIntersecting){
                    var el = e.target;
                    setTimeout(function(){ el.classList.add('visible'); }, parseInt(el.dataset.revealDelay||0));
                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.08 });
        els.forEach(function(el){ obs.observe(el); });
    } else {
        els.forEach(function(el){ el.classList.add('visible'); });
    }

    /* Hero parallax */
    var ph = document.querySelector('.jg-page-hero__photo');
    if (ph) {
        window.addEventListener('scroll', function(){
            ph.style.transform = 'scale(1.03) translateY(' + (window.scrollY * .05) + 'px)';
        }, { passive: true });
    }

    /* Ripple on primary buttons */
    document.querySelectorAll('.jg-btn--primary').forEach(function(btn){
        btn.style.position = 'relative';
        btn.style.overflow = 'hidden';
        btn.addEventListener('click', function(e){
            var rect = btn.getBoundingClientRect();
            var r = document.createElement('span');
            var size = Math.max(rect.width, rect.height);
            r.style.cssText = [
                'position:absolute','border-radius:50%','pointer-events:none',
                'background:rgba(255,255,255,.30)',
                'width:'+size+'px','height:'+size+'px',
                'left:'+(e.clientX-rect.left-size/2)+'px',
                'top:'+(e.clientY-rect.top-size/2)+'px',
                'transform:scale(0)',
                'animation:rippleOut .55s linear'
            ].join(';');
            btn.appendChild(r);
            setTimeout(function(){ r.remove(); }, 600);
        });
    });

    /* Inject ripple keyframe once */
    if (!document.getElementById('jg-ripple-style')) {
        var st = document.createElement('style');
        st.id = 'jg-ripple-style';
        st.textContent = '@keyframes rippleOut{to{transform:scale(4);opacity:0}}';
        document.head.appendChild(st);
    }
})();
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>