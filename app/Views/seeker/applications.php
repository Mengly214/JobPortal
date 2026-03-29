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
        <p class="jg-page-hero__sub">Click any application to track its full progress.</p>
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
                    <?php foreach ([
                        'submitted'   => 'Application Received',
                        'reviewing'   => 'In Review',
                        'shortlisted' => 'Shortlisted',
                        'interview'   => 'Interview',
                        'offered'     => 'Offer Received',
                        'hired'       => 'Hired',
                        'rejected'    => 'Not Selected',
                    ] as $val => $lbl): ?>
                    <option value="<?= $val ?>" <?= (($_GET['status'] ?? '') === $val) ? 'selected' : '' ?>><?= $lbl ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="jg-filterbar__btn"><i class="fa fa-search"></i> Filter</button>
            <?php if (!empty($_GET['search']) || !empty($_GET['status'])): ?>
                <a href="<?= SITE_URL ?>/seeker/applications" class="jg-filterbar__clear" title="Clear"><i class="fa fa-times"></i></a>
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
            <a href="<?= SITE_URL ?>/jobs" class="jg-btn jg-btn--primary" style="margin-top:16px">
                <i class="fa fa-search"></i> Browse Jobs
            </a>
        </div>
    <?php else: ?>

        <div class="jg-results-bar">
            <p class="jg-results-bar__count">
                Showing <strong><?= count($applications) ?></strong> application(s)
                &nbsp;·&nbsp;
                <span style="color:#0a65cc;font-size:12px"><i class="fa fa-hand-pointer-o"></i> Click a card to track its status</span>
            </p>
        </div>

        <?php
        $pipeline = ['submitted','reviewing','shortlisted','interview','offered','hired'];

        $pipelineLabels = [
            'submitted'   => ['icon'=>'fa-paper-plane','label'=>'Submitted'],
            'reviewing'   => ['icon'=>'fa-search',     'label'=>'In Review'],
            'shortlisted' => ['icon'=>'fa-star',        'label'=>'Shortlisted'],
            'interview'   => ['icon'=>'fa-calendar',    'label'=>'Interview'],
            'offered'     => ['icon'=>'fa-envelope',    'label'=>'Offered'],
            'hired'       => ['icon'=>'fa-trophy',      'label'=>'Hired'],
        ];

        $statusConfig = [
            'submitted'   => ['pill'=>'status-teal',  'icon'=>'fa-paper-plane',  'label'=>'Application Received','border'=>'#0d7a57'],
            'reviewing'   => ['pill'=>'status-blue',  'icon'=>'fa-search',       'label'=>'Under Review',        'border'=>'#0a65cc'],
            'shortlisted' => ['pill'=>'status-purple','icon'=>'fa-star',         'label'=>'Shortlisted',         'border'=>'#6c3fc5'],
            'interview'   => ['pill'=>'status-orange','icon'=>'fa-calendar',     'label'=>'Interview Scheduled', 'border'=>'#b45309'],
            'offered'     => ['pill'=>'status-indigo','icon'=>'fa-envelope-open','label'=>'Offer Received',      'border'=>'#3730a3'],
            'hired'       => ['pill'=>'status-green', 'icon'=>'fa-trophy',       'label'=>'Hired',               'border'=>'#2e7d32'],
            'rejected'    => ['pill'=>'status-red',   'icon'=>'fa-times-circle', 'label'=>'Not Selected',        'border'=>'#e53935'],
            'withdrawn'   => ['pill'=>'status-gray',  'icon'=>'fa-minus-circle', 'label'=>'Withdrawn',           'border'=>'#94a3b8'],
        ];
        ?>

        <div class="jg-apps-cards js-reveal">
        <?php foreach ($applications as $app):
            $status     = $app['status'];
            $cfg        = $statusConfig[$status] ?? $statusConfig['submitted'];
            $appId      = $app['id'];
            $currentIdx = array_search($status, $pipeline);
            $isTerminal = in_array($status, ['rejected','withdrawn']);

            $deadlineStr = $app['application_deadline'] ?? null;
            $deadlineLbl = $deadlineCls = '';
            if ($deadlineStr) {
                $daysLeft = (int)(new DateTime())->diff(new DateTime($deadlineStr))->format('%r%a');
                if ($daysLeft < 0)      { $deadlineLbl = 'Expired';           $deadlineCls = 'dl-red'; }
                elseif ($daysLeft <= 7) { $deadlineLbl = $daysLeft.'d left';  $deadlineCls = 'dl-red'; }
                else                    { $deadlineLbl = $daysLeft.'d left';  $deadlineCls = 'dl-green'; }
            }
        ?>

        <!-- Application Card — whole card is a link to the status page -->
        <a class="app-card" href="<?= SITE_URL ?>/seeker/application/<?= $appId ?>"
           style="border-left-color:<?= $cfg['border'] ?>"
           aria-label="View status for <?= htmlspecialchars($app['job_title']) ?>">

            <div class="app-card__top">
                <div class="app-card__logo">
                    <?php if (!empty($app['company_logo'])): ?>
                        <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($app['company_logo']) ?>" alt="">
                    <?php else: ?>
                        <div class="app-card__initial"><?= strtoupper(substr($app['company_name'] ?? 'C', 0, 1)) ?></div>
                    <?php endif; ?>
                </div>

                <div class="app-card__info">
                    <div class="app-card__job-title"><?= htmlspecialchars($app['job_title']) ?></div>
                    <div class="app-card__company-name"><?= htmlspecialchars($app['company_name'] ?? 'N/A') ?></div>
                    <div class="app-card__meta">
                        <span><i class="fa fa-calendar-o"></i> <?= date('d M Y', strtotime($app['applied_at'])) ?></span>
                        <?php if ($deadlineStr): ?>
                            <span class="app-card__meta-sep">·</span>
                            <span class="dl-badge <?= $deadlineCls ?>"><?= $deadlineLbl ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="app-card__right">
                    <span class="status-pill <?= $cfg['pill'] ?>">
                        <i class="fa <?= $cfg['icon'] ?>"></i> <?= $cfg['label'] ?>
                    </span>
                    <div class="app-card__track-hint"><i class="fa fa-arrow-right"></i> Track Status</div>
                </div>
            </div>

            <!-- Mini pipeline strip -->
            <?php if (!$isTerminal): ?>
            <div class="app-card__pipeline">
                <?php foreach ($pipeline as $i => $step):
                    $done    = ($currentIdx !== false) && $i <= $currentIdx;
                    $current = ($currentIdx !== false) && $i === $currentIdx;
                    $pl      = $pipelineLabels[$step];
                ?>
                    <div class="pip-step <?= $done ? 'pip-done' : '' ?> <?= $current ? 'pip-current' : '' ?>">
                        <div class="pip-dot"><i class="fa <?= $pl['icon'] ?>"></i></div>
                        <div class="pip-label"><?= $pl['label'] ?></div>
                    </div>
                    <?php if ($i < count($pipeline) - 1): ?>
                        <div class="pip-line <?= ($currentIdx !== false && $i < $currentIdx) ? 'pip-line--done' : '' ?>"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php elseif ($status === 'rejected'): ?>
            <div class="app-card__terminal app-card__terminal--red">
                <i class="fa fa-times-circle"></i> This application was not selected. Keep going!
            </div>
            <?php elseif ($status === 'withdrawn'): ?>
            <div class="app-card__terminal app-card__terminal--gray">
                <i class="fa fa-minus-circle"></i> You withdrew this application.
            </div>
            <?php endif; ?>

        </a><!-- /.app-card -->

        <?php endforeach; ?>
        </div><!-- /.jg-apps-cards -->
    <?php endif; ?>
    </div>
</section>

<style>
.jg-apps-cards{display:flex;flex-direction:column;gap:14px}
.jg-results-bar{display:flex;align-items:center;margin-bottom:18px}
.jg-results-bar__count{font-size:14px;color:#666;margin:0}
.jg-results-bar__count strong{color:#1a1a2e}

/* App Card — now an <a> tag */
.app-card{display:block;background:#fff;border-radius:14px;border:1.5px solid #e8edf5;border-left:4px solid #e8edf5;box-shadow:0 2px 10px rgba(10,50,120,.05);overflow:hidden;text-decoration:none;color:inherit;transition:box-shadow .2s,transform .15s,border-color .2s}
.app-card:hover{box-shadow:0 8px 28px rgba(10,50,120,.14);transform:translateY(-2px);color:inherit;text-decoration:none}
.app-card:focus-visible{outline:3px solid #0a65cc;outline-offset:2px}

.app-card__top{display:flex;align-items:flex-start;gap:14px;padding:18px 20px 14px}
.app-card__logo img,.app-card__initial{width:50px;height:50px;border-radius:10px;flex-shrink:0;object-fit:cover;border:1.5px solid #e8edf5;display:flex;align-items:center;justify-content:center}
.app-card__initial{background:linear-gradient(135deg,#0a65cc,#14a077);color:#fff;font-size:19px;font-weight:700}
.app-card__info{flex:1;min-width:0}
.app-card__job-title{font-size:15px;font-weight:700;color:#1a1a2e;margin-bottom:3px}
.app-card__company-name{font-size:12px;color:#64748b;margin-bottom:5px}
.app-card__meta{display:flex;align-items:center;flex-wrap:wrap;gap:5px;font-size:11px;color:#94a3b8}
.app-card__meta i{color:#0a65cc}
.app-card__meta-sep{color:#d0d9e8}
.app-card__right{flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:8px}
.app-card__track-hint{font-size:11px;color:#0a65cc;font-weight:700;display:flex;align-items:center;gap:5px;opacity:0;transition:opacity .2s,gap .2s}
.app-card:hover .app-card__track-hint{opacity:1;gap:8px}

/* Status pills */
.status-pill{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap}
.status-pill i{font-size:10px}
.status-teal  {background:#e0f7f0;color:#0d7a57}
.status-blue  {background:#e8f0fe;color:#0a65cc}
.status-purple{background:#f0ebff;color:#6c3fc5}
.status-orange{background:#fff4e5;color:#b45309}
.status-indigo{background:#eef2ff;color:#3730a3}
.status-green {background:#e8f5e9;color:#2e7d32}
.status-red   {background:#fef2f2;color:#e53935}
.status-gray  {background:#f1f5f9;color:#64748b}

/* Mini pipeline */
.app-card__pipeline{display:flex;align-items:center;padding:12px 20px 14px;border-top:1px solid #f0f4f8;gap:0;overflow-x:auto}
.pip-step{display:flex;flex-direction:column;align-items:center;gap:4px;flex-shrink:0;min-width:56px}
.pip-dot{width:28px;height:28px;border-radius:50%;border:2px solid #d0daea;background:#f5f7fb;color:#c0cad8;display:flex;align-items:center;justify-content:center;font-size:11px;transition:.25s}
.pip-label{font-size:9px;font-weight:700;color:#b0bac8;text-align:center;text-transform:uppercase;letter-spacing:.4px;transition:.25s}
.pip-line{flex:1;height:2px;background:#e0e6f0;min-width:14px;margin-bottom:16px;transition:.25s}
.pip-done .pip-dot{background:#e8f5e9;border-color:#2e7d32;color:#2e7d32}
.pip-done .pip-label{color:#2e7d32}
.pip-current .pip-dot{background:#0a65cc;border-color:#0a65cc;color:#fff;box-shadow:0 0 0 4px rgba(10,101,204,.15)}
.pip-current .pip-label{color:#0a65cc;font-weight:800}
.pip-line--done{background:linear-gradient(90deg,#2e7d32,#0a65cc)}

/* Terminal */
.app-card__terminal{padding:10px 20px 12px;font-size:12px;font-weight:600;display:flex;align-items:center;gap:8px;border-top:1px solid #f0f4f8}
.app-card__terminal--red {background:#fff5f5;color:#c0392b}
.app-card__terminal--gray{background:#f8fafc;color:#64748b}

/* Deadline */
.dl-badge{display:inline-block;padding:2px 7px;border-radius:20px;font-size:10px;font-weight:700}
.dl-green{background:#e8f5e9;color:#2e7d32}
.dl-red  {background:#fef2f2;color:#e53935}

/* Hero */
.jg-page-hero{position:relative;margin-top:-70px;padding-top:150px;padding-bottom:60px;overflow:hidden;min-height:280px;display:flex;align-items:flex-end}
.jg-page-hero__photo{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1600&q=60&fit=crop&crop=top') center/cover no-repeat;transform:scale(1.03)}
.jg-page-hero__overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(5,14,30,.90) 0%,rgba(10,60,130,.82) 60%,rgba(5,14,30,.70) 100%)}
.jg-page-hero__inner{position:relative;z-index:2}
.jg-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.55);margin-bottom:14px}
.jg-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}
.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb span{color:rgba(255,255,255,.85)}
.jg-breadcrumb i{font-size:11px}
.jg-page-hero__title{font-size:40px;font-weight:800;color:#fff;letter-spacing:-1.5px;margin:0 0 10px;line-height:1.1}
.jg-page-hero__sub{font-size:16px;color:rgba(255,255,255,.70);margin:0}

/* Filter bar */
.jg-filterbar-wrap{background:#fff;border-bottom:1px solid #e8edf5;box-shadow:0 4px 24px rgba(10,50,120,.07);position:sticky;top:70px;z-index:800}
.jg-filterbar{display:flex;align-items:center;flex-wrap:wrap;gap:0;min-height:62px;border:1.5px solid #e0e6f0;border-radius:12px;overflow:hidden;margin:14px 0;background:#fff}
.jg-filterbar__field{display:flex;align-items:center;flex:0 0 auto;padding:0 18px;min-height:62px}
.jg-filterbar__field--grow{flex:1 1 180px}
.jg-filterbar__field i{color:#0a65cc;font-size:15px;margin-right:10px;flex-shrink:0}
.jg-filterbar__field input,.jg-filterbar__field select{border:none;outline:none;background:transparent;font-size:14px;color:#333;width:100%;-webkit-appearance:none;appearance:none;cursor:pointer}
.jg-filterbar__field--select{min-width:180px}
.jg-filterbar__sep{width:1px;align-self:stretch;background:#e8edf5;margin:10px 0;flex-shrink:0}
.jg-filterbar__btn{background:linear-gradient(135deg,#0a65cc,#0853aa);color:#fff;border:none;font-size:14px;font-weight:700;padding:0 28px;min-height:62px;cursor:pointer;white-space:nowrap;transition:.2s;display:flex;align-items:center;gap:8px;border-radius:0 10px 10px 0}
.jg-filterbar__btn:hover{background:linear-gradient(135deg,#084fa3,#063d82)}
.jg-filterbar__clear{display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:8px;margin:0 8px;color:#aaa;font-size:14px;text-decoration:none;border:1.5px solid #e8edf5;transition:.2s;flex-shrink:0}
.jg-filterbar__clear:hover{border-color:#e74c3c;color:#e74c3c;background:#fef2f2}

.jg-apps-section{padding:36px 0 70px;background:#f5f7fb;min-height:400px}
.jg-empty{text-align:center;padding:80px 20px;background:#fff;border-radius:16px;border:1.5px dashed #d0daea}
.jg-empty__icon{width:72px;height:72px;border-radius:50%;background:#f0f5ff;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;font-size:26px;color:#0a65cc}
.jg-empty h3{font-size:22px;font-weight:700;color:#1a1a2e;margin-bottom:10px}
.jg-empty p{color:#888;font-size:15px}
.js-reveal{opacity:0;transform:translateY(20px);transition:opacity .5s cubic-bezier(.22,1,.36,1),transform .5s cubic-bezier(.22,1,.36,1)}
.js-reveal.visible{opacity:1;transform:translateY(0)}

@media(max-width:767px){
    .jg-page-hero{padding-top:120px;padding-bottom:40px}
    .jg-page-hero__title{font-size:28px}
    .jg-filterbar{flex-direction:column;border-radius:10px}
    .jg-filterbar__field{width:100%;min-height:50px;padding:0 16px;border-bottom:1px solid #e8edf5}
    .jg-filterbar__sep{display:none}
    .jg-filterbar__btn{width:100%;justify-content:center;border-radius:0 0 8px 8px}
    .app-card__top{flex-wrap:wrap}
    .app-card__right{order:-1;width:100%;flex-direction:row;justify-content:space-between;align-items:center}
    .app-card__track-hint{opacity:1}
}
</style>

<script>
(function(){
    var els = document.querySelectorAll('.js-reveal');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(e){
            e.forEach(function(x){ if(x.isIntersecting){ x.target.classList.add('visible'); obs.unobserve(x.target); } });
        }, { threshold:.05 });
        els.forEach(function(el){ obs.observe(el); });
    } else {
        els.forEach(function(el){ el.classList.add('visible'); });
    }
    var ph = document.querySelector('.jg-page-hero__photo');
    if (ph) {
        window.addEventListener('scroll', function(){
            ph.style.transform = 'scale(1.03) translateY(' + (window.scrollY * .06) + 'px)';
        }, { passive:true });
    }
})();
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>