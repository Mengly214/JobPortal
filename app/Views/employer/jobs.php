<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero" style="background:linear-gradient(135deg,rgba(10,22,40,.88),rgba(10,101,204,.82)),url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1400&q=60&fit=crop') center/cover no-repeat;margin-top:-70px;padding-top:150px;padding-bottom:52px">
    <div class="container" style="position:relative;z-index:2">
        <div class="jg-breadcrumb"><a href="<?= SITE_URL ?>/">Home</a> <i class="fa fa-angle-right"></i> <a href="<?= SITE_URL ?>/employer/dashboard">Dashboard</a> <i class="fa fa-angle-right"></i> <span>My Jobs</span></div>
        <h1 class="jg-page-hero__title">My Job Listings</h1>
        <p style="color:rgba(255,255,255,.72);margin:0;font-size:16px">Manage, edit and track all your posted positions</p>
    </div>
</div>

<section style="padding:36px 0 70px;background:#f5f7fb;min-height:400px">
<div class="container">

    <!-- Toolbar -->
    <div class="emp-toolbar">
        <form method="GET" action="<?= SITE_URL ?>/employer/jobs" class="emp-toolbar__filters">
            <div class="emp-search-wrap">
                <i class="fa fa-search"></i>
                <input type="text" name="search" placeholder="Search job title..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <select name="status" class="emp-select">
                <option value="">All Status</option>
                <?php foreach(['active'=>'Active','draft'=>'Draft','paused'=>'Paused','closed'=>'Closed'] as $v=>$l): ?>
                <option value="<?= $v ?>" <?= $status===$v?'selected':'' ?>><?= $l ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort" class="emp-select">
                <option value="created_at" <?= $sort==='created_at'?'selected':'' ?>>Newest First</option>
                <option value="title"      <?= $sort==='title'     ?'selected':'' ?>>A–Z Title</option>
                <option value="views"      <?= $sort==='views'     ?'selected':'' ?>>Most Viewed</option>
            </select>
            <button type="submit" class="jg-btn jg-btn--outline jg-btn--sm"><i class="fa fa-filter"></i> Filter</button>
            <?php if ($search || $status): ?>
            <a href="<?= SITE_URL ?>/employer/jobs" class="jg-btn jg-btn--sm" style="border:1.5px solid #e0e6f0;color:#888;background:#fff">Clear</a>
            <?php endif; ?>
        </form>
        <a href="<?= SITE_URL ?>/employer/jobs/create" class="jg-btn jg-btn--primary">
            <i class="fa fa-plus-circle"></i> Post New Job
        </a>
    </div>

    <!-- Job cards -->
    <?php if (empty($jobs)): ?>
    <div class="emp-empty-state">
        <i class="fa fa-briefcase"></i>
        <h3>No jobs found</h3>
        <p><?= $search || $status ? 'Try clearing your filters.' : "You haven't posted any jobs yet." ?></p>
        <a href="<?= SITE_URL ?>/employer/jobs/create" class="jg-btn jg-btn--primary"><i class="fa fa-plus"></i> Post Your First Job</a>
    </div>
    <?php else: ?>
    <div class="emp-job-list">
        <?php foreach ($jobs as $job):
            $statusClass = ['active'=>'pill-green','draft'=>'pill-gray','paused'=>'pill-orange','closed'=>'pill-red'][$job['status']] ?? 'pill-gray';
            $imgSrc = !empty($job['job_image']) ? SITE_URL.'/uploads/jobs/'.clean($job['job_image']) : null;
        ?>
        <div class="emp-job-row">
            <div class="emp-job-row__img">
                <?php if ($imgSrc): ?>
                <img src="<?= $imgSrc ?>" alt="">
                <?php else: ?>
                <div class="emp-job-row__initials"><?= strtoupper(substr($job['title'],0,1)) ?></div>
                <?php endif; ?>
            </div>
            <div class="emp-job-row__body">
                <div class="emp-job-row__top">
                    <div>
                        <h4><a href="<?= SITE_URL ?>/jobs/<?= $job['id'] ?>" target="_blank"><?= htmlspecialchars($job['title']) ?></a></h4>
                        <div class="emp-job-row__meta">
                            <?php if (!empty($job['location_city'])): ?><span><i class="fa fa-map-marker"></i> <?= htmlspecialchars($job['location_city']) ?></span><?php endif; ?>
                            <span><i class="fa fa-clock-o"></i> <?= ucfirst(str_replace('_',' ',$job['job_type']??'')) ?></span>
                            <?php if (!empty($job['category_name'])): ?><span><i class="fa fa-th-large"></i> <?= htmlspecialchars($job['category_name']) ?></span><?php endif; ?>
                            <span><i class="fa fa-calendar"></i> <?= date('d M Y', strtotime($job['created_at'])) ?></span>
                        </div>
                    </div>
                    <div class="emp-job-row__badges">
                        <span class="status-pill <?= $statusClass ?>"><?= ucfirst($job['status']) ?></span>
                        <?php if ($job['is_featured']): ?><span class="status-pill pill-blue">Featured</span><?php endif; ?>
                    </div>
                </div>
                <div class="emp-job-row__stats">
                    <div><i class="fa fa-eye"></i> <?= number_format($job['views']??0) ?> views</div>
                    <div><i class="fa fa-users"></i>
                        <a href="<?= SITE_URL ?>/employer/applications?job=<?= $job['id'] ?>">
                            <?= $job['app_count'] ?> application<?= $job['app_count']!=1?'s':'' ?>
                        </a>
                    </div>
                    <?php if (!empty($job['application_deadline'])): ?>
                    <div><i class="fa fa-hourglass-end"></i> Deadline: <?= date('d M Y', strtotime($job['application_deadline'])) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="emp-job-row__actions">
                <a href="<?= SITE_URL ?>/employer/jobs/edit/<?= $job['id'] ?>" class="act-btn" title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                <a href="<?= SITE_URL ?>/employer/applications?job=<?= $job['id'] ?>" class="act-btn" title="Applications"><i class="fa fa-file-text"></i> Apps</a>
                <a href="<?= SITE_URL ?>/employer/jobs/toggle/<?= $job['id'] ?>" class="act-btn" title="Toggle Status"
                   onclick="return confirm('Toggle job status?')">
                    <i class="fa fa-<?= $job['status']==='active'?'pause':'play' ?>"></i>
                </a>
                <a href="<?= SITE_URL ?>/employer/jobs/delete/<?= $job['id'] ?>" class="act-btn act-btn--danger"
                   onclick="return confirm('Delete this job permanently?')" title="Delete"><i class="fa fa-trash"></i></a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div style="margin-top:16px;font-size:13px;color:#94a3b8">Showing <?= count($jobs) ?> job<?= count($jobs)!=1?'s':'' ?></div>
    <?php endif; ?>

</div>
</section>

<style>
.jg-page-hero__title{font-size:32px;font-weight:800;color:#fff;margin:0 0 8px;letter-spacing:-.5px}
.jg-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.55);margin-bottom:12px}
.jg-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb i{font-size:10px}.jg-breadcrumb span{color:rgba(255,255,255,.85)}
/* Toolbar */
.emp-toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:24px;background:#fff;padding:14px 18px;border-radius:12px;border:1px solid #e8edf5;box-shadow:0 2px 12px rgba(10,50,120,.05)}
.emp-toolbar__filters{display:flex;align-items:center;gap:10px;flex-wrap:wrap;flex:1}
.emp-search-wrap{position:relative;display:flex;align-items:center;min-width:200px;flex:1}
.emp-search-wrap i{position:absolute;left:12px;color:#aaa;font-size:13px}
.emp-search-wrap input{border:1.5px solid #e8edf5;border-radius:8px;padding:9px 12px 9px 34px;font-size:13px;outline:none;width:100%;transition:.2s}
.emp-search-wrap input:focus{border-color:#0a65cc}
.emp-select{border:1.5px solid #e8edf5;border-radius:8px;padding:9px 12px;font-size:13px;outline:none;background:#fafbfd;color:#555;cursor:pointer;transition:.2s}
.emp-select:focus{border-color:#0a65cc}
/* Job rows */
.emp-job-list{display:flex;flex-direction:column;gap:14px}
.emp-job-row{background:#fff;border:1.5px solid #e8edf5;border-radius:14px;padding:18px 20px;display:flex;align-items:center;gap:18px;transition:.2s;box-shadow:0 2px 10px rgba(10,50,120,.04)}
.emp-job-row:hover{border-color:#0a65cc;box-shadow:0 4px 20px rgba(10,101,204,.10)}
.emp-job-row__img{width:56px;height:56px;border-radius:10px;overflow:hidden;flex-shrink:0;border:1px solid #e8edf5;display:flex;align-items:center;justify-content:center}
.emp-job-row__img img{width:100%;height:100%;object-fit:cover}
.emp-job-row__initials{width:56px;height:56px;background:linear-gradient(135deg,#0a65cc,#14a077);color:#fff;font-size:22px;font-weight:800;display:flex;align-items:center;justify-content:center;border-radius:10px}
.emp-job-row__body{flex:1;min-width:0}
.emp-job-row__top{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:8px}
.emp-job-row__top h4{margin:0 0 5px;font-size:16px;font-weight:700}
.emp-job-row__top h4 a{color:#1a1a2e;text-decoration:none}.emp-job-row__top h4 a:hover{color:#0a65cc}
.emp-job-row__badges{display:flex;gap:6px;flex-shrink:0;flex-wrap:wrap}
.emp-job-row__meta{display:flex;flex-wrap:wrap;gap:12px;font-size:12px;color:#94a3b8}
.emp-job-row__meta span{display:flex;align-items:center;gap:4px}
.emp-job-row__stats{display:flex;gap:18px;font-size:13px;color:#64748b}
.emp-job-row__stats a{color:#0a65cc;text-decoration:none;font-weight:600}.emp-job-row__stats a:hover{text-decoration:underline}
.emp-job-row__actions{display:flex;gap:6px;flex-shrink:0;flex-wrap:wrap}
.act-btn{display:inline-flex;align-items:center;gap:5px;background:#fff;border:1.5px solid #e8edf5;color:#64748b;font-size:12px;font-weight:600;padding:6px 12px;border-radius:8px;text-decoration:none;transition:.2s;cursor:pointer}
.act-btn:hover{background:#f5f7fb;color:#1a1a2e;border-color:#c5d0e0;text-decoration:none}
.act-btn--danger{color:#e53935;border-color:#fee2e2}.act-btn--danger:hover{background:#fef2f2;color:#c62828;border-color:#fca5a5}
.status-pill{display:inline-block;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap}
.pill-green{background:#e8f5e9;color:#2e7d32}.pill-gray{background:#f1f5f9;color:#64748b}
.pill-orange{background:#fff3e0;color:#e65100}.pill-red{background:#fef2f2;color:#e53935}
.pill-blue{background:#e8f0fe;color:#0a65cc}
.jg-btn{display:inline-flex;align-items:center;gap:7px;font-weight:700;text-decoration:none;border-radius:8px;border:2px solid transparent;cursor:pointer;transition:.2s;padding:10px 22px;font-size:14px}
.jg-btn--primary{background:#0a65cc;color:#fff;border-color:#0a65cc}.jg-btn--primary:hover{background:#084fa3;color:#fff}
.jg-btn--outline{background:#fff;color:#0a65cc;border-color:#0a65cc}.jg-btn--outline:hover{background:#0a65cc;color:#fff}
.jg-btn--sm{padding:8px 16px;font-size:13px}
/* Empty state */
.emp-empty-state{text-align:center;padding:80px 20px;color:#aaa;background:#fff;border-radius:14px;border:1.5px dashed #e8edf5}
.emp-empty-state i{font-size:48px;color:#c5d5e8;display:block;margin-bottom:16px}
.emp-empty-state h3{font-size:20px;font-weight:700;color:#888;margin-bottom:8px}
.emp-empty-state p{margin-bottom:20px;font-size:14px}
@media(max-width:767px){
    .emp-toolbar{flex-direction:column;align-items:stretch}
    .emp-job-row{flex-wrap:wrap}
    .emp-job-row__actions{width:100%}
    .emp-job-row__img{display:none}
}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
