<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- ======================================================
     PAGE HERO
====================================================== -->
<div class="jg-page-hero">
    <div class="jg-page-hero__photo"></div>
    <div class="jg-page-hero__overlay"></div>
    <div class="container jg-page-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?php echo SITE_URL; ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <span>Jobs</span>
        </div>
        <h1 class="jg-page-hero__title">Browse Jobs</h1>
        <p class="jg-page-hero__sub">
            Find your perfect role from
            <strong><?php echo number_format($totalRows); ?></strong> available positions
        </p>
    </div>
</div>

<!-- ======================================================
     FILTER BAR
====================================================== -->
<div class="jg-filterbar-wrap">
    <div class="container">
        <form action="<?php echo SITE_URL; ?>/jobs" method="get" class="jg-filterbar">
            <div class="jg-filterbar__field jg-filterbar__field--grow">
                <i class="fa fa-search"></i>
                <input type="text" name="keyword" placeholder="Job title or keyword"
                       value="<?php echo htmlspecialchars($keyword); ?>">
            </div>
            <div class="jg-filterbar__sep"></div>
            <div class="jg-filterbar__field">
                <i class="fa fa-map-marker"></i>
                <input type="text" name="location" placeholder="City or country"
                       value="<?php echo htmlspecialchars($location); ?>">
            </div>
            <div class="jg-filterbar__sep"></div>
            <div class="jg-filterbar__field jg-filterbar__field--select">
                <i class="fa fa-th-list"></i>
                <select name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $category == $cat['id'] ? 'selected' : ''; ?>>
                        <?php echo clean($cat['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="jg-filterbar__sep"></div>
            <div class="jg-filterbar__field jg-filterbar__field--select">
                <i class="fa fa-clock-o"></i>
                <select name="job_type">
                    <option value="">All Types</option>
                    <?php foreach (['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contract','freelance'=>'Freelance','internship'=>'Internship'] as $v=>$l): ?>
                    <option value="<?php echo $v; ?>" <?php echo $job_type===$v?'selected':''; ?>><?php echo $l; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="jg-filterbar__sep"></div>
            <div class="jg-filterbar__field jg-filterbar__field--select">
                <i class="fa fa-laptop"></i>
                <select name="work_mode">
                    <option value="">All Modes</option>
                    <?php foreach (['on_site'=>'On Site','remote'=>'Remote','hybrid'=>'Hybrid'] as $v=>$l): ?>
                    <option value="<?php echo $v; ?>" <?php echo $work_mode===$v?'selected':''; ?>><?php echo $l; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="jg-filterbar__btn">
                <i class="fa fa-search"></i> Search
            </button>
            <?php if ($keyword || $location || $category || $job_type || $work_mode): ?>
            <a href="<?php echo SITE_URL; ?>/jobs" class="jg-filterbar__clear" title="Clear filters">
                <i class="fa fa-times"></i>
            </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- ======================================================
     RESULTS
====================================================== -->
<section class="jg-jobs-section">
    <div class="container">

        <?php if (empty($jobs)): ?>
        <!-- Empty state -->
        <div class="jg-empty">
            <div class="jg-empty__icon"><i class="fa fa-search"></i></div>
            <h3>No Jobs Found</h3>
            <p>Try adjusting your search criteria or <a href="<?php echo SITE_URL; ?>/jobs">clear all filters</a>.</p>
        </div>

        <?php else: ?>

        <div class="jg-results-bar">
            <p class="jg-results-bar__count">
                Showing <strong><?php echo count($jobs); ?></strong> of
                <strong><?php echo number_format($totalRows); ?></strong> jobs
                <?php if ($currentPage > 1): ?>
                — Page <strong><?php echo $currentPage; ?></strong> of <strong><?php echo $totalPages; ?></strong>
                <?php endif; ?>
            </p>
            <!-- active filter chips -->
            <?php if ($keyword || $location || $category || $job_type || $work_mode): ?>
            <div class="jg-filter-chips">
                <?php if ($keyword): ?><span class="jg-chip"><?php echo htmlspecialchars($keyword); ?> <a href="?<?php echo http_build_query(array_merge($_GET,['keyword'=>'','page'=>1])); ?>"><i class="fa fa-times"></i></a></span><?php endif; ?>
                <?php if ($location): ?><span class="jg-chip"><?php echo htmlspecialchars($location); ?> <a href="?<?php echo http_build_query(array_merge($_GET,['location'=>'','page'=>1])); ?>"><i class="fa fa-times"></i></a></span><?php endif; ?>
                <?php if ($job_type): ?><span class="jg-chip"><?php echo ucfirst(str_replace('_',' ',$job_type)); ?> <a href="?<?php echo http_build_query(array_merge($_GET,['job_type'=>'','page'=>1])); ?>"><i class="fa fa-times"></i></a></span><?php endif; ?>
                <?php if ($work_mode): ?><span class="jg-chip"><?php echo ucfirst(str_replace('_',' ',$work_mode)); ?> <a href="?<?php echo http_build_query(array_merge($_GET,['work_mode'=>'','page'=>1])); ?>"><i class="fa fa-times"></i></a></span><?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Job Cards -->
        <div class="jg-job-list">
            <?php foreach ($jobs as $i => $job): ?>
            <div class="jg-job-card <?php echo $job['is_featured'] ? 'jg-job-card--featured' : ''; ?> js-reveal"
                 data-reveal-delay="<?php echo ($i % 5) * 60; ?>">
                <?php if ($job['is_featured']): ?>
                <div class="jg-job-card__featured-badge">
                    <i class="fa fa-star"></i> Featured
                </div>
                <?php endif; ?>

                <!-- logo -->
                <div class="jg-job-card__logo">
                    <?php if (!empty($job['logo'])): ?>
                        <img src="<?php echo SITE_URL.'/uploads/logos/'.clean($job['logo']); ?>" alt="">
                    <?php elseif (!empty($job['job_image'])): ?>
                        <img src="<?php echo SITE_URL.'/uploads/jobs/'.clean($job['job_image']); ?>" alt="">
                    <?php else: ?>
                        <span class="jg-job-card__logo-placeholder">
                            <?php echo strtoupper(substr($job['company_name'] ?? $job['title'],0,1)); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- body -->
                <div class="jg-job-card__body">
                    <h4>
                        <a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>">
                            <?php echo clean($job['title']); ?>
                        </a>
                    </h4>
                    <p><?php echo clean(substr(strip_tags($job['description']??''),0,110)); ?>...</p>
                    <div class="jg-job-card__meta">
                        <?php if (!empty($job['company_name'])): ?>
                        <span><i class="fa fa-building-o"></i> <?php echo clean($job['company_name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($job['salary_min'])): ?>
                        <span><i class="fa fa-money"></i> $<?php echo number_format($job['salary_min']); ?><?php if ($job['salary_max']): ?>–$<?php echo number_format($job['salary_max']); ?><?php endif; ?></span>
                        <?php endif; ?>
                        <span><i class="fa fa-map-marker"></i> <?php echo clean($job['location_city']??'Remote'); ?></span>
                        <span><i class="fa fa-calendar"></i> <?php echo date('d M Y',strtotime($job['created_at'])); ?></span>
                    </div>
                </div>

                <!-- actions -->
                <div class="jg-job-card__actions">
                    <a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>"
                       class="jg-btn jg-btn--primary jg-btn--sm">Apply</a>
                    <span class="jg-badge jg-badge--<?php echo strtolower(str_replace(['_',' '],'-',$job['job_type']??'full-time')); ?>">
                        <?php echo ucfirst(str_replace('_',' ',$job['job_type']??'Full Time')); ?>
                    </span>
                    <?php if (!empty($job['work_mode']) && $job['work_mode'] !== 'on_site'): ?>
                    <span class="jg-badge jg-badge--remote">
                        <?php echo ucfirst(str_replace('_',' ',$job['work_mode'])); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="jg-pagination">
            <?php if ($currentPage > 1): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET,['page'=>$currentPage-1])); ?>"
               class="jg-page-btn jg-page-btn--arrow">
                <i class="fa fa-chevron-left"></i>
            </a>
            <?php endif; ?>

            <?php for ($p = max(1,$currentPage-2); $p <= min($totalPages,$currentPage+2); $p++): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET,['page'=>$p])); ?>"
               class="jg-page-btn <?php echo $p===$currentPage?'active':''; ?>">
                <?php echo $p; ?>
            </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET,['page'=>$currentPage+1])); ?>"
               class="jg-page-btn jg-page-btn--arrow">
                <i class="fa fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</section>

<!-- ======================================================
     STYLES
====================================================== -->
<style>
/* ─── PAGE HERO (shared pattern) ─────────────────────── */
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
    transition: transform .1s linear;
}
.jg-page-hero__overlay {
    position: absolute; inset: 0;
    background:
        linear-gradient(135deg, rgba(5,14,30,.90) 0%, rgba(10,60,130,.82) 60%, rgba(5,14,30,.70) 100%);
}
.jg-page-hero__inner {
    position: relative; z-index: 2;
}
.jg-breadcrumb {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: rgba(255,255,255,.55); margin-bottom: 14px;
}
.jg-breadcrumb a { color: rgba(255,255,255,.65); text-decoration: none; transition: color .2s; }
.jg-breadcrumb a:hover { color: #fff; }
.jg-breadcrumb i { font-size: 11px; }
.jg-breadcrumb span { color: rgba(255,255,255,.85); }
.jg-page-hero__title {
    font-size: 40px; font-weight: 800; color: #fff;
    letter-spacing: -1.5px; margin: 0 0 10px; line-height: 1.1;
    animation: pgTitleIn .65s .1s cubic-bezier(.22,1,.36,1) both;
}
.jg-page-hero__sub {
    font-size: 16px; color: rgba(255,255,255,.70); margin: 0;
    animation: pgTitleIn .65s .22s cubic-bezier(.22,1,.36,1) both;
}
.jg-page-hero__sub strong { color: #4db8ff; }
@keyframes pgTitleIn { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }

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
.jg-filterbar__field i {
    color: #0a65cc; font-size: 15px; margin-right: 10px; flex-shrink: 0;
}
.jg-filterbar__field input,
.jg-filterbar__field select {
    border: none; outline: none; background: transparent;
    font-size: 14px; color: #333; width: 100%;
    -webkit-appearance: none; appearance: none;
    cursor: pointer;
}
.jg-filterbar__field input::placeholder { color: #aaa; }
.jg-filterbar__field--select { min-width: 150px; }
.jg-filterbar__sep {
    width: 1px; align-self: stretch;
    background: #e8edf5; margin: 10px 0; flex-shrink: 0;
}
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

/* ─── JOBS SECTION ────────────────────────────────────── */
.jg-jobs-section { padding: 36px 0 70px; background: #f5f7fb; min-height: 400px; }

/* ─── RESULTS BAR ─────────────────────────────────────── */
.jg-results-bar {
    display: flex; align-items: center; flex-wrap: wrap;
    gap: 12px; margin-bottom: 22px;
}
.jg-results-bar__count { font-size: 14px; color: #666; margin: 0; flex-shrink: 0; }
.jg-results-bar__count strong { color: #1a1a2e; }

/* filter chips */
.jg-filter-chips { display: flex; flex-wrap: wrap; gap: 8px; }
.jg-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: #e8f0fe; color: #0a65cc; font-size: 12px; font-weight: 600;
    padding: 4px 12px; border-radius: 20px;
    border: 1px solid #c7d9f9;
}
.jg-chip a { color: #0a65cc; text-decoration: none; opacity: .6; transition: opacity .15s; }
.jg-chip a:hover { opacity: 1; }

/* ─── JOB CARDS ───────────────────────────────────────── */
.jg-job-list { display: flex; flex-direction: column; gap: 14px; }

.jg-job-card {
    background: #fff;
    border: 1.5px solid #e8edf5;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px 24px;
    transition: border-color .2s, box-shadow .2s, transform .2s;
    position: relative;
    overflow: hidden;
}
.jg-job-card::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0;
    width: 3px; background: transparent; border-radius: 14px 0 0 14px;
    transition: background .2s;
}
.jg-job-card:hover {
    border-color: #bdd0f5;
    box-shadow: 0 6px 28px rgba(10,101,204,.10);
    transform: translateY(-2px);
}
.jg-job-card:hover::before { background: #0a65cc; }

.jg-job-card--featured {
    border-color: #c7d9f9;
    background: linear-gradient(to right, #f7faff, #fff);
  

}
.jg-job-card--featured::before { background: #0a65cc; }

.jg-job-card__featured-badge {
    position: absolute; top: 14px; right: 18px;
    background: linear-gradient(135deg, #0a65cc, #14a077);
    color: #fff; font-size: 11px; font-weight: 700;
    letter-spacing: .5px; padding: 3px 10px; border-radius: 20px;
    display: flex; align-items: center; gap: 4px;
    margin-right: 100px;
    margin-top: 15px;
}

/* logo */
.jg-job-card__logo {
    width: 60px; height: 60px; flex-shrink: 0;
    border-radius: 12px; overflow: hidden;
    border: 1.5px solid #e8edf5;
    display: flex; align-items: center; justify-content: center;
    background: #f8fafd;
}
.jg-job-card__logo img { width: 100%; height: 100%; object-fit: cover; }
.jg-job-card__logo-placeholder {
    width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
    font-size: 22px; font-weight: 800; color: #fff;
    background: linear-gradient(135deg, #0a65cc, #14a077);
}

/* body */
.jg-job-card__body { flex: 1; min-width: 0; }
.jg-job-card__body h4 { font-size: 16px; font-weight: 700; margin: 0 0 5px; }
.jg-job-card__body h4 a { color: #1a1a2e; text-decoration: none; transition: color .2s; }
.jg-job-card__body h4 a:hover { color: #0a65cc; }
.jg-job-card__body > p { font-size: 13px; color: #888; margin: 0 0 10px; line-height: 1.55; }
.jg-job-card__meta {
    display: flex; flex-wrap: wrap; gap: 12px;
    font-size: 13px; color: #666;
}
.jg-job-card__meta span { display: flex; align-items: center; gap: 5px; }
.jg-job-card__meta i { color: #0a65cc; font-size: 12px; }

/* actions */
.jg-job-card__actions {
    display: flex; flex-direction: column;
    align-items: flex-end; gap: 8px; flex-shrink: 0;
}

/* ─── BADGES ──────────────────────────────────────────── */
.jg-badge {
    display: inline-block; font-size: 11px; font-weight: 700;
    padding: 3px 10px; border-radius: 20px; white-space: nowrap;
}
.jg-badge--full-time   { background:#e8f4fd; color:#0a65cc; }
.jg-badge--part-time   { background:#fef3e2; color:#d68910; }
.jg-badge--contract    { background:#fdebd0; color:#ca6f1e; }
.jg-badge--freelance   { background:#e8f8f5; color:#148a68; }
.jg-badge--internship  { background:#f4ecf7; color:#7d3c98; }
.jg-badge--remote      { background:#e8f8f5; color:#148a68; }
.jg-badge--hybrid      { background:#eaf2fb; color:#2471a3; }

/* ─── BUTTONS ─────────────────────────────────────────── */
.jg-btn { display:inline-flex; align-items:center; gap:7px; font-weight:700; text-decoration:none; border-radius:8px; border:none; cursor:pointer; transition:.2s; }
.jg-btn--primary { background:#0a65cc; color:#fff; padding:10px 22px; font-size:14px; }
.jg-btn--primary:hover { background:#084fa3; color:#fff; }
.jg-btn--outline { background:transparent; color:#0a65cc; padding:9px 20px; font-size:14px; border:2px solid #0a65cc; }
.jg-btn--outline:hover { background:#0a65cc; color:#fff; }
.jg-btn--sm { padding:7px 16px; font-size:13px; }

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
.jg-empty a  { color: #0a65cc; font-weight: 600; }

/* ─── PAGINATION ──────────────────────────────────────── */
.jg-pagination {
    display: flex; align-items: center; justify-content: center;
    gap: 6px; margin-top: 44px; flex-wrap: wrap;
}
.jg-page-btn {
    display: flex; align-items: center; justify-content: center;
    width: 40px; height: 40px; border-radius: 10px;
    font-size: 14px; font-weight: 600; color: #555;
    background: #fff; border: 1.5px solid #e8edf5;
    text-decoration: none; transition: .2s;
}
.jg-page-btn:hover       { border-color: #0a65cc; color: #0a65cc; background: #f0f5ff; }
.jg-page-btn.active      { background: #0a65cc; color: #fff; border-color: #0a65cc; }
.jg-page-btn--arrow      { color: #888; }

/* ─── REVEAL ANIMATION ────────────────────────────────── */
.js-reveal {
    opacity: 0; transform: translateY(24px);
    transition: opacity .55s cubic-bezier(.22,1,.36,1), transform .55s cubic-bezier(.22,1,.36,1);
}
.js-reveal.visible { opacity: 1; transform: translateY(0); }

/* ─── RESPONSIVE ──────────────────────────────────────── */
@media (max-width: 991px) {
    .jg-filterbar { border-radius: 10px; }
    .jg-filterbar__field--select { min-width: 120px; }
}
@media (max-width: 767px) {
    .jg-page-hero { padding-top: 120px; padding-bottom: 40px; }
    .jg-page-hero__title { font-size: 28px; }
    .jg-filterbar { flex-direction: column; border-radius: 10px; }
    .jg-filterbar__field { width: 100%; min-height: 50px; padding: 0 16px; border-bottom: 1px solid #e8edf5; }
    .jg-filterbar__sep { display: none; }
    .jg-filterbar__btn { width: 100%; justify-content: center; border-radius: 0 0 8px 8px; }
    .jg-filterbar__clear { margin: 8px auto; }
    .jg-job-card { flex-wrap: wrap; padding: 16px; }
    .jg-job-card__actions { flex-direction: row; width: 100%; justify-content: flex-start; }
    .jg-job-card__featured-badge { top: 10px; right: 12px; }
    .jg-filterbar-wrap { position: static; }
}
</style>

<script>
(function(){
    /* Reveal on scroll */
    var els = document.querySelectorAll('.js-reveal');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if (e.isIntersecting) {
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

    /* Parallax on page hero photo */
    var ph = document.querySelector('.jg-page-hero__photo');
    if (ph) {
        window.addEventListener('scroll', function(){
            ph.style.transform = 'scale(1.03) translateY(' + (window.scrollY * .06) + 'px)';
        }, { passive: true });
    }
})();
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>