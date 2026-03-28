<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero">
    <div class="container">
        <h1>Our Team</h1>
        <p>Meet the passionate people behind <?php echo SITE_NAME; ?></p>
    </div>
</div>

<section class="jg-section">
<div class="container">
    <div class="row text-center" style="margin-bottom:40px">
        <div class="col-md-8 col-md-offset-2">
            <span class="jg-label">The Team</span>
            <h2 class="jg-section__title">People Who Make It Happen</h2>
            <p class="jg-section__sub">A passionate group dedicated to helping professionals find their dream jobs and employers build great teams.</p>
        </div>
    </div>
    <div class="row">
    <?php
    $members = [
        ['John Doe',     'CEO & Founder',    'fa-user',     'Visionary leader with 15+ years in HR technology and talent acquisition.'],
        ['Jane Doe',     'CTO',              'fa-code',     'Full-stack engineer driving the tech platform that powers our mission.'],
        ['Becky Fox',    'Marketing Expert', 'fa-bullhorn', 'Growth strategist connecting great talent with the companies that need them.'],
        ['Daniel Smith', 'Customer Support', 'fa-headphones','Ensuring every job seeker and employer has a seamless, positive experience.'],
    ];
    foreach ($members as [$name, $role, $icon, $bio]):
    ?>
    <div class="col-md-3 col-sm-6" style="margin-bottom:28px">
        <div class="jg-team-card">
            <div class="jg-team-card__avatar"><i class="fa <?php echo $icon; ?>"></i></div>
            <h4><?php echo $name; ?></h4>
            <span class="jg-team-card__role"><?php echo $role; ?></span>
            <p><?php echo $bio; ?></p>
            <div class="jg-team-card__social">
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
</div>
</section>

<section class="jg-cta">
    <div class="jg-cta__bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-9">
                <span class="jg-label jg-label--light">Join Our Mission</span>
                <h2>Want to Be Part of Our Team?</h2>
                <p>We're always looking for talented people who are passionate about connecting talent with opportunity.</p>
            </div>
            <div class="col-md-4 col-sm-3 jg-cta__action">
                <a href="<?php echo SITE_URL; ?>/contact" class="jg-btn jg-btn--white"><i class="fa fa-envelope"></i> Get In Touch</a>
            </div>
        </div>
    </div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
