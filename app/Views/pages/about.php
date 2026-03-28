<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero" style="background:linear-gradient(135deg,rgba(10,22,40,.85) 0%,rgba(10,101,204,.80) 100%),url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&q=60&fit=crop') center/cover no-repeat">
    <div class="container">
        <h1>About Us</h1>
        <p>Learn about our mission to connect talent with opportunity</p>
    </div>
</div>

<section class="jg-section">
<div class="container">
    <div class="row jg-about__row">
        <div class="col-md-5 col-sm-12 jg-about__images hidden-xs">
            <div class="jg-about__img-stack">
                <div class="jg-about__img jg-about__img--a" style="background:none"><img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=560&q=80&fit=crop" alt="Modern office" style="width:100%;height:100%;object-fit:cover;border-radius:14px"></div>
                <div class="jg-about__img jg-about__img--b" style="background:none"><img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=420&q=80&fit=crop&crop=face" alt="Professional" style="width:100%;height:100%;object-fit:cover;border-radius:14px"></div>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 jg-about__content">
            <span class="jg-label">Our Story</span>
            <h2 class="jg-section__title">Connecting People to Opportunity</h2>
            <p style="color:#666;line-height:1.8;margin-bottom:16px">We believe everyone deserves a fulfilling career. Our platform bridges the gap between talented professionals and forward-thinking companies, making the job search faster, smarter, and more human.</p>
            <p style="color:#666;line-height:1.8;margin-bottom:24px">Since our founding, we've helped thousands of job seekers land roles they love, and helped hundreds of businesses build exceptional teams.</p>
            <div class="jg-stats-row">
                <div class="jg-stat"><strong>10K+</strong><span>Jobs Posted</span></div>
                <div class="jg-stat"><strong>5K+</strong><span>Companies</span></div>
                <div class="jg-stat"><strong>50K+</strong><span>Job Seekers</span></div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="jg-section jg-section--gray">
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <span class="jg-label">Why Choose Us</span>
            <h2 class="jg-section__title">What Makes Us Different</h2>
            <p class="jg-section__sub">We go beyond just listing jobs — we help you build a career.</p>
        </div>
    </div>
    <div class="row" style="margin-top:20px">
        <?php
        $features = [
            ['fa-search',   'Smart Search',         'Advanced filters by location, type, salary and category help you zero in on the perfect opportunity instantly.'],
            ['fa-shield',   'Verified Employers',   'All employer profiles are reviewed so you can apply with confidence, knowing every listing is genuine.'],
            ['fa-bell',     'Job Alerts',           'Set up alerts and be the first to know when new jobs matching your criteria are posted.'],
            ['fa-mobile',   'Mobile Friendly',      'Browse and apply for jobs from any device. Our platform is fully responsive and fast.'],
            ['fa-users',    'Large Network',        'Access thousands of opportunities across all industries from startups to global enterprises.'],
            ['fa-headphones','Dedicated Support',   'Our team is always ready to help both job seekers and employers for a smooth experience.'],
        ];
        foreach ($features as [$icon,$title,$desc]):
        ?>
        <div class="col-md-4 col-sm-6" style="margin-bottom:24px">
            <div class="jg-feature-card">
                <div class="jg-feature-card__icon"><i class="fa <?php echo $icon; ?>"></i></div>
                <h4><?php echo $title; ?></h4>
                <p><?php echo $desc; ?></p>
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
                <span class="jg-label jg-label--light">Join Us</span>
                <h2>Join Our Growing Community</h2>
                <p>Thousands of professionals and companies trust <?php echo SITE_NAME; ?> every day to find opportunity and talent.</p>
            </div>
            <div class="col-md-4 col-sm-3 jg-cta__action">
                <a href="<?php echo SITE_URL; ?>/register" class="jg-btn jg-btn--white"><i class="fa fa-user-plus"></i> Create Free Account</a>
            </div>
        </div>
    </div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
