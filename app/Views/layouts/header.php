<?php
$navItems = [
    'home'    => ['Home',       SITE_URL . '/'],
    'jobs'    => ['Browse Jobs',SITE_URL . '/jobs'],
    'about'   => ['About Us',   SITE_URL . '/about'],
    'blog'    => ['Blog',       SITE_URL . '/blog'],
    'contact' => ['Contact',    SITE_URL . '/contact'],
];
$moreItems = [
    'team'         => ['Team',         SITE_URL . '/team'],
    'testimonials' => ['Testimonials', SITE_URL . '/testimonials'],
    'terms'        => ['Terms',        SITE_URL . '/terms'],
];
$moreActive = array_key_exists($activePage ?? '', $moreItems);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($pageTitle ?? SITE_NAME); ?> | <?php echo SITE_NAME; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/jg-styles.css">
    <style>
    /* ===== JOBGRIDS NAVBAR ===== */
    .jg-nav {
        position: fixed; top: 0; left: 0; right: 0; z-index: 9999;
        background: #fff;
        box-shadow: 0 2px 16px rgba(10,101,204,.10);
        height: 70px;
        display: flex; align-items: center;
        transition: background .3s, box-shadow .3s;
    }
    .jg-nav.scrolled { box-shadow: 0 4px 24px rgba(10,101,204,.16); }
    .jg-nav__inner { display: flex; align-items: center; justify-content: space-between; width: 100%; }
    .jg-nav__brand { font-size: 22px; font-weight: 800; color: #0a65cc; text-decoration: none; letter-spacing: -0.5px; display: flex; align-items: center; gap: 8px; }
    .jg-nav__brand:hover { color: #084fa3; }
    .jg-nav__brand-dot { width: 8px; height: 8px; background: #14a077; border-radius: 50%; display: inline-block; }
    .jg-nav__links { display: flex; align-items: center; gap: 4px; margin: 0; padding: 0; list-style: none; }
    .jg-nav__links > li > a {
        display: flex; align-items: center; gap: 4px;
        padding: 8px 14px; border-radius: 6px;
        font-size: 14px; font-weight: 500; color: #444;
        text-decoration: none; transition: .2s;
    }
    .jg-nav__links > li > a:hover,
    .jg-nav__links > li.active > a { color: #0a65cc; background: #f0f5ff; }

    /* ── Dropdown (CSS hover) ── */
    .jg-nav__links .jg-dropdown { position: relative; }
    .jg-nav__links .jg-dropdown-menu {
        display: block;
        position: absolute; top: 100%; left: 0;
        background: #fff;
        border: 1px solid #e0e6f0;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(10,101,204,.12);
        min-width: 180px;
        padding: 8px 0;
        z-index: 1000;
        margin-top: 0;
        /* Invisible top border acts as bridge over the gap */
        border-top: 8px solid transparent;
        background-clip: padding-box;
        opacity: 0; pointer-events: none;
        transition: opacity .15s ease, transform .15s ease;
        transform: translateY(-4px);
    }
    .jg-nav__links .jg-dropdown:hover .jg-dropdown-menu {
        opacity: 1; transform: translateY(0);
        pointer-events: auto;
    }
    .jg-nav__links .jg-dropdown-menu li { list-style: none; }
    .jg-nav__links .jg-dropdown-menu li a {
        display: block; padding: 9px 18px; font-size: 13px; color: #555;
        text-decoration: none; transition: .15s;
    }
    .jg-nav__links .jg-dropdown-menu li a:hover { background: #f0f5ff; color: #0a65cc; }

    /* Auth buttons */
    .jg-nav__actions { display: flex; align-items: center; gap: 10px; }
    .jg-nav__btn-login {
        padding: 8px 20px; border-radius: 6px; font-size: 14px; font-weight: 600;
        color: #0a65cc; background: transparent; border: 2px solid #0a65cc;
        text-decoration: none; transition: .2s;
    }
    .jg-nav__btn-login:hover { background: #0a65cc; color: #fff; }
    .jg-nav__btn-signup {
        padding: 8px 20px; border-radius: 6px; font-size: 14px; font-weight: 600;
        color: #fff; background: #0a65cc; border: 2px solid #0a65cc;
        text-decoration: none; transition: .2s;
    }
    .jg-nav__btn-signup:hover { background: #084fa3; border-color: #084fa3; }

    /* ── User dropdown (CSS hover) ── */
    .jg-nav__user { position: relative; cursor: pointer; }
    .jg-nav__user-trigger {
        display: flex; align-items: center; gap: 9px;
        padding: 6px 14px 6px 6px; border-radius: 30px;
        border: 1px solid #e0e6f0; background: #f8fafd;
        transition: .2s; font-size: 14px; font-weight: 500; color: #333;
        user-select: none;
    }
    .jg-nav__user-trigger:hover { border-color: #0a65cc; background: #f0f5ff; }
    .jg-nav__avatar {
        width: 34px; height: 34px; border-radius: 50%; object-fit: cover;
        border: 2px solid #0a65cc;
    }
    .jg-nav__avatar-initials {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, #0a65cc, #14a077);
        color: #fff; font-weight: 700; font-size: 14px;
        display: flex; align-items: center; justify-content: center;
    }
    .jg-nav__user-menu {
        display: block;
        position: absolute; top: 100%; right: 0;
        background: #fff;
        border: 1px solid #e0e6f0;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(10,101,204,.12);
        min-width: 220px;
        padding: 8px 0;
        z-index: 1000;
        border-top: 10px solid transparent;
        background-clip: padding-box;
        opacity: 0; pointer-events: none;
        transition: opacity .15s ease, transform .15s ease;
        transform: translateY(-4px);
    }
    .jg-nav__user:hover .jg-nav__user-menu {
        opacity: 1; transform: translateY(0);
        pointer-events: auto;
    }
    /* Visible card */
    .jg-nav__user-menu::before {
        content: '';
        display: block;
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #fff;
        border: 1px solid #e0e6f0;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(10,101,204,.12);
        z-index: -1;
    }
    .jg-nav__user-header { padding: 10px 18px 12px; border-bottom: 1px solid #f0f4f8; }
    .jg-nav__user-header small { display: block; font-size: 12px; color: #aaa; }
    .jg-nav__user-header strong { font-size: 14px; color: #222; }
    .jg-nav__user-menu a {
        display: flex; align-items: center; gap: 10px; padding: 10px 18px;
        font-size: 13px; color: #555; text-decoration: none; transition: .15s;
    }
    .jg-nav__user-menu a:hover { background: #f0f5ff; color: #0a65cc; }
    .jg-nav__user-menu a i { width: 16px; text-align: center; }
    .jg-nav__user-menu .divider { height: 1px; background: #f0f4f8; margin: 6px 0; }
    .jg-nav__user-menu a.logout { color: #e74c3c; }
    .jg-nav__user-menu a.logout:hover { background: #fef2f2; color: #c0392b; }
    .jg-nav__user-menu a:last-child { margin-bottom: 8px; }

    /* Mobile toggle */
    .jg-nav__toggle { display: none; background: none; border: none; cursor: pointer; padding: 6px; }
    .jg-nav__toggle span { display: block; width: 24px; height: 2px; background: #333; margin: 5px 0; border-radius: 2px; transition: .3s; }

    @media (max-width: 991px) {
        .jg-nav__toggle { display: block; }
        .jg-nav__links, .jg-nav__actions { display: none; }
        .jg-nav__links.open, .jg-nav__actions.open { display: flex; }
        .jg-nav__inner { flex-wrap: wrap; padding: 10px 0; }
        .jg-nav__links {
            flex-direction: column; align-items: flex-start; width: 100%;
            padding: 10px 0; border-top: 1px solid #f0f4f8; gap: 0;
        }
        .jg-nav__links > li { width: 100%; }
        .jg-nav__links > li > a { padding: 10px 4px; }
        /* Mobile: dropdown hidden by default, toggled by JS */
        .jg-nav__links .jg-dropdown-menu {
            display: none;
            position: static; box-shadow: none; border: none;
            border-left: 2px solid #e0e6f0; margin-left: 16px;
            opacity: 1; transform: none; pointer-events: auto;
        }
        .jg-nav__links .jg-dropdown-menu.open { display: block; }
        .jg-nav__actions { flex-direction: row; width: 100%; padding: 10px 0; border-top: 1px solid #f0f4f8; }
    }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="jg-nav" id="jg-nav">
    <div class="container">
        <div class="jg-nav__inner">
            <a href="<?php echo SITE_URL; ?>/" class="jg-nav__brand">
                <span class="jg-nav__brand-dot"></span>
                <?php echo SITE_NAME; ?>
            </a>

            <button class="jg-nav__toggle" id="jg-toggle" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>

            <ul class="jg-nav__links" id="jg-links">
                <?php foreach ($navItems as $key => [$label, $href]): ?>
                <li class="<?php echo ($activePage ?? '') === $key ? 'active' : ''; ?>">
                    <a href="<?php echo $href; ?>"><?php echo $label; ?></a>
                </li>
                <?php endforeach; ?>

                <!-- More dropdown -->
                <li class="jg-dropdown <?php echo $moreActive ? 'active' : ''; ?>">
                    <a href="#" class="jg-dropdown-trigger" aria-haspopup="true" aria-expanded="false">
                        More <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="jg-dropdown-menu" role="menu">
                        <?php foreach ($moreItems as $key => [$label, $href]): ?>
                        <li><a href="<?php echo $href; ?>" role="menuitem"><?php echo $label; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>

            <div class="jg-nav__actions" id="jg-actions">
                <?php if (isLoggedIn()): ?>
                <?php
                $navUser   = $GLOBALS['conn']->query("SELECT avatar, full_name FROM users WHERE id=".(int)$_SESSION['user_id']." LIMIT 1")->fetch_assoc();
                $navAvatar = $navUser['avatar'] ?? '';
                $navName   = $navUser['full_name'] ?? '';
                $firstName = $navName
                    ? htmlspecialchars(explode(' ', trim($navName))[0])
                    : (['admin'=>'Admin','employer'=>'Employer','job_seeker'=>'Account'][$_SESSION['role']] ?? 'Account');
                ?>
                <div class="jg-nav__user" id="jg-user-dropdown">
                    <div class="jg-nav__user-trigger" id="jg-user-trigger" aria-haspopup="true" aria-expanded="false">
                        <?php if ($navAvatar): ?>
                            <img src="<?php echo SITE_URL.'/uploads/avatars/'.htmlspecialchars($navAvatar); ?>" class="jg-nav__avatar" alt="">
                        <?php else: ?>
                            <div class="jg-nav__avatar-initials"><?php echo strtoupper(substr($_SESSION['email'], 0, 1)); ?></div>
                        <?php endif; ?>
                        <?php echo $firstName; ?>
                        <i class="fa fa-caret-down" style="font-size:12px;color:#aaa"></i>
                    </div>
                    <div class="jg-nav__user-menu" id="jg-user-menu" role="menu">
                        <div class="jg-nav__user-header">
                            <small>Signed in as</small>
                            <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong>
                        </div>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="<?php echo SITE_URL; ?>/admin"><i class="fa fa-tachometer"></i> Admin Dashboard</a>
                        <a href="<?php echo SITE_URL; ?>/admin/jobs"><i class="fa fa-briefcase"></i> Manage Jobs</a>
                        <a href="<?php echo SITE_URL; ?>/admin/users"><i class="fa fa-users"></i> Manage Users</a>
                        <div class="divider"></div>
                        <a href="<?php echo SITE_URL; ?>/admin/profile"><i class="fa fa-user-circle"></i> My Profile</a>
                        <?php elseif ($_SESSION['role'] === 'employer'): ?>
                        <a href="<?php echo SITE_URL; ?>/employer/dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                        <a href="<?php echo SITE_URL; ?>/employer/post-job"><i class="fa fa-plus-circle"></i> Post a Job</a>
                        <div class="divider"></div>
                        <a href="<?php echo SITE_URL; ?>/employer/profile"><i class="fa fa-user-circle"></i> My Profile</a>
                        <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/seeker/dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                        <a href="<?php echo SITE_URL; ?>/seeker/applications"><i class="fa fa-file-text"></i> My Applications</a>
                        <div class="divider"></div>
                        <a href="<?php echo SITE_URL; ?>/seeker/profile"><i class="fa fa-user-circle"></i> My Profile</a>
                        <?php endif; ?>
                        <div class="divider"></div>
                        <a href="<?php echo SITE_URL; ?>/logout" class="logout"><i class="fa fa-sign-out"></i> Logout</a>
                    </div>
                </div>
                <?php else: ?>
                <a href="<?php echo SITE_URL; ?>/login" class="jg-nav__btn-login">Log In</a>
                <a href="<?php echo SITE_URL; ?>/register" class="jg-nav__btn-signup">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
(function () {
    /* ── Mobile menu toggle ── */
    document.getElementById('jg-toggle').addEventListener('click', function () {
        document.getElementById('jg-links').classList.toggle('open');
        document.getElementById('jg-actions').classList.toggle('open');
    });

    /* ── Mobile: More dropdown click toggle ── */
    var moreTrigger = document.querySelector('.jg-dropdown-trigger');
    if (moreTrigger) {
        moreTrigger.addEventListener('click', function (e) {
            e.preventDefault();
            var menu = this.closest('.jg-dropdown').querySelector('.jg-dropdown-menu');
            if (menu) menu.classList.toggle('open');
        });
    }

    /* ── Scroll shadow ── */
    window.addEventListener('scroll', function () {
        document.getElementById('jg-nav').classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });
})();
</script>