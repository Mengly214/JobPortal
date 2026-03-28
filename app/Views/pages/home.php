<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<!-- ======================================================
     HERO — full-width horizontal banner
====================================================== -->
<section class="jg-hero" id="jg-hero">
    <!-- layered background: real photo + dark gradient overlay + dot texture -->
    <div class="jg-hero__photo"></div>
    <div class="jg-hero__overlay"></div>
    <div class="jg-hero__bg"></div>
    <div class="jg-hero__particles" id="jg-particles"></div>

    <div class="container jg-hero__container">

        <!-- eyebrow -->
        <div class="jg-hero__eyebrow">
            <span class="jg-hero__eyebrow-dot"></span>
            <span>10,000+ active job listings</span>
        </div>

        <!-- headline -->
        <h1 class="jg-hero__title">
            <span class="jg-hero__title-line">Find Your Career &amp;</span>
            <span class="jg-hero__title-line jg-hero__title-line--accent">Make a Better Life</span>
        </h1>

        <p class="jg-hero__sub">Connecting talented professionals with great companies — your next opportunity starts here.</p>

        <!-- ── SEARCH BAR ── -->
        <div class="jg-search-wrap">
            <form action="<?php echo SITE_URL; ?>/jobs" method="GET" class="jg-search">
                <div class="jg-search__inner">
                    <div class="jg-search__field">
                        <i class="fa fa-search jg-search__icon"></i>
                        <input type="text" name="keyword" placeholder="Job title, keyword...">
                    </div>
                    <div class="jg-search__divider"></div>
                    <div class="jg-search__field">
                        <i class="fa fa-map-marker jg-search__icon"></i>
                        <input type="text" name="location" placeholder="City or country...">
                    </div>
                    <button type="submit" class="jg-search__btn">
                        <i class="fa fa-search" style="margin-right:8px"></i>Search Jobs
                    </button>
                </div>
            </form>
            <div class="jg-search__tags">
                <span>Popular:</span>
                <a href="<?php echo SITE_URL; ?>/jobs?keyword=developer">Developer</a>
                <a href="<?php echo SITE_URL; ?>/jobs?keyword=designer">Designer</a>
                <a href="<?php echo SITE_URL; ?>/jobs?keyword=marketing">Marketing</a>
                <a href="<?php echo SITE_URL; ?>/jobs?keyword=finance">Finance</a>
                <a href="<?php echo SITE_URL; ?>/jobs?keyword=remote">Remote</a>
            </div>
        </div>

        <!-- floating stat pills -->
        <div class="jg-hero__pills">
            <div class="jg-hero__pill">
                <i class="fa fa-briefcase"></i>
                <strong>12,400+</strong><span>Jobs Posted</span>
            </div>
            <div class="jg-hero__pill">
                <i class="fa fa-users"></i>
                <strong>85K+</strong><span>Job Seekers</span>
            </div>
            <div class="jg-hero__pill">
                <i class="fa fa-building"></i>
                <strong>4,200+</strong><span>Companies</span>
            </div>
        </div>

    </div>

    <!-- scroll cue -->
    <div class="jg-hero__scroll-cue">
        <span>Scroll</span>
        <div class="jg-hero__scroll-line"></div>
    </div>
</section>

<!-- ======================================================
     HOW IT WORKS
====================================================== -->
<section class="jg-steps jg-reveal-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="jg-step js-reveal" data-reveal-delay="0">
                    <div class="jg-step__icon"><i class="fa fa-user-plus"></i><span class="jg-step__num">01</span></div>
                    <h4>Register Your Account</h4>
                    <p>Create a free account in seconds and start browsing thousands of job opportunities across all industries.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="jg-step js-reveal" data-reveal-delay="120">
                    <div class="jg-step__icon"><i class="fa fa-upload"></i><span class="jg-step__num">02</span></div>
                    <h4>Upload Your Resume</h4>
                    <p>Add your CV and let top employers discover you. Stand out with a complete, professional profile.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="jg-step js-reveal" data-reveal-delay="240">
                    <div class="jg-step__icon"><i class="fa fa-briefcase"></i><span class="jg-step__num">03</span></div>
                    <h4>Apply for Dream Job</h4>
                    <p>Apply with one click and track every application from your personal dashboard in real time.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================
     JOB CATEGORIES
====================================================== -->
<section class="jg-section jg-reveal-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center js-reveal">
                <span class="jg-label">Job Category</span>
                <h2 class="jg-section__title">Choose Your Desired Category</h2>
                <p class="jg-section__sub">Browse jobs by category and find the perfect match for your skills.</p>
            </div>
        </div>
        <div class="row jg-categories">
            <?php
            $catIcons = [
                'Technology'=>'fa-laptop','Design'=>'fa-paint-brush',
                'Marketing'=>'fa-bullhorn','Finance'=>'fa-bar-chart',
                'Healthcare'=>'fa-heartbeat','Education'=>'fa-graduation-cap',
                'Engineering'=>'fa-cogs','Sales'=>'fa-handshake-o',
                'Customer Service'=>'fa-headphones','Legal'=>'fa-balance-scale',
                'HR'=>'fa-users','Construction'=>'fa-building',
            ];
            $staticCats = [
                ['fa-laptop','Technology'],['fa-paint-brush','Design'],
                ['fa-bullhorn','Marketing'],['fa-bar-chart','Finance'],
                ['fa-heartbeat','Healthcare'],['fa-cogs','Engineering'],
                ['fa-users','Human Resources'],['fa-building','Construction'],
            ];
            $catList = !empty($categories) ? array_slice($categories,0,8) : null;
            $ci = 0;
            if ($catList): foreach ($catList as $cat):
                $icon = $catIcons[$cat['name']] ?? 'fa-briefcase';
            ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="<?php echo SITE_URL; ?>/jobs?category=<?php echo $cat['id']; ?>" class="jg-cat-card js-reveal" data-reveal-delay="<?php echo ($ci % 4) * 80; ?>">
                    <div class="jg-cat-card__icon"><i class="fa <?php echo $icon; ?>"></i></div>
                    <h5><?php echo clean($cat['name']); ?></h5>
                    <span class="jg-cat-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </a>
            </div>
            <?php $ci++; endforeach; else: foreach ($staticCats as $si => [$icon,$name]): ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="<?php echo SITE_URL; ?>/jobs" class="jg-cat-card js-reveal" data-reveal-delay="<?php echo ($si % 4) * 80; ?>">
                    <div class="jg-cat-card__icon"><i class="fa <?php echo $icon; ?>"></i></div>
                    <h5><?php echo $name; ?></h5>
                    <span class="jg-cat-card__arrow"><i class="fa fa-arrow-right"></i></span>
                </a>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<!-- ======================================================
     STATS COUNTER STRIP
====================================================== -->
<section class="jg-stats jg-reveal-section">
    <div class="container">
        <div class="jg-stats__grid">
            <div class="jg-stats__item js-reveal" data-reveal-delay="0">
                <strong class="jg-counter" data-target="12400">0</strong>
                <span>Jobs Posted</span>
            </div>
            <div class="jg-stats__item js-reveal" data-reveal-delay="100">
                <strong class="jg-counter" data-target="85000">0</strong>
                <span>Job Seekers</span>
            </div>
            <div class="jg-stats__item js-reveal" data-reveal-delay="200">
                <strong class="jg-counter" data-target="4200">0</strong>
                <span>Companies Hiring</span>
            </div>
            <div class="jg-stats__item js-reveal" data-reveal-delay="300">
                <strong class="jg-counter" data-target="98">0</strong>
                <span>% Satisfaction Rate</span>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================
     ABOUT STRIP
====================================================== -->
<section class="jg-about jg-reveal-section">
    <div class="container">
        <div class="row jg-about__row">
            <div class="col-md-5 col-sm-12 jg-about__images hidden-xs js-reveal" data-reveal-delay="0">
                <div class="jg-about__img-stack">
                    <div class="jg-about__img jg-about__img--a" style="background:none">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=560&q=80&fit=crop"
                             alt="Modern office" style="width:100%;height:100%;object-fit:cover;border-radius:14px">
                    </div>
                    <div class="jg-about__img jg-about__img--b" style="background:none">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=420&q=80&fit=crop"
                             alt="Team collaboration" style="width:100%;height:100%;object-fit:cover;border-radius:14px">
                    </div>
                </div>
                <div class="jg-about__badge">
                    <i class="fa fa-bell"></i>
                    <div><strong>104+</strong><span>New jobs this week</span></div>
                </div>
            </div>
            <div class="col-md-7 col-sm-12 jg-about__content js-reveal" data-reveal-delay="150">
                <span class="jg-label">About <?php echo SITE_NAME; ?></span>
                <h2 class="jg-section__title">Help You Get the Best Job That Fits You</h2>
                <div class="jg-about__features">
                    <div class="jg-about__feature">
                        <div class="jg-about__feature-icon"><i class="fa fa-trophy"></i></div>
                        <div>
                            <h5>#1 Jobs Site in the Region</h5>
                            <p>Leverage our extensive network to find quality positions across all industries and experience levels.</p>
                        </div>
                    </div>
                    <div class="jg-about__feature">
                        <div class="jg-about__feature-icon"><i class="fa fa-search"></i></div>
                        <div>
                            <h5>Seamless Searching</h5>
                            <p>Advanced filters by location, type, salary and category help you zero in on the perfect opportunity fast.</p>
                        </div>
                    </div>
                    <div class="jg-about__feature">
                        <div class="jg-about__feature-icon"><i class="fa fa-building"></i></div>
                        <div>
                            <h5>Hired in Top Companies</h5>
                            <p>Connect directly with vetted employers ranging from fast-growing startups to established enterprises.</p>
                        </div>
                    </div>
                </div>
                <a href="<?php echo SITE_URL; ?>/about" class="jg-btn jg-btn--primary">Learn More <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================
     CV UPLOAD CTA
====================================================== -->
<section class="jg-cta jg-reveal-section">
    <div class="jg-cta__bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-9 js-reveal" data-reveal-delay="0">
                <span class="jg-label jg-label--light">Getting Started</span>
                <h2>Don't Just Find. Be Found.</h2>
                <p>Put your CV in front of great employers and let recruiters contact you about opportunities you haven't even thought of yet.</p>
            </div>
            <div class="col-md-4 col-sm-3 jg-cta__action js-reveal" data-reveal-delay="150">
                <a href="<?php echo SITE_URL; ?>/register?role=job_seeker" class="jg-btn jg-btn--white">
                    <i class="fa fa-upload"></i> Upload Your Resume
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================
     RECENT JOBS
====================================================== -->
<section class="jg-section jg-reveal-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center js-reveal">
                <span class="jg-label">Hot Jobs</span>
                <h2 class="jg-section__title">Browse Recent Jobs</h2>
                <p class="jg-section__sub">Fresh opportunities posted by top employers — updated every day.</p>
            </div>
        </div>
        <?php if (!empty($featuredJobs)): ?>
        <div class="jg-job-list">
            <?php foreach ($featuredJobs as $i => $job): ?>
            <div class="jg-job-card js-reveal" data-reveal-delay="<?php echo ($i % 3) * 80; ?>">
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
                <div class="jg-job-card__body">
                    <h4><a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>"><?php echo clean($job['title']); ?></a></h4>
                    <p><?php echo clean(substr(strip_tags($job['description']??''),0,100)); ?>...</p>
                    <div class="jg-job-card__meta">
                        <?php if (!empty($job['company_name'])): ?>
                        <span><i class="fa fa-building-o"></i> <?php echo clean($job['company_name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($job['salary_min'])): ?>
                        <span><i class="fa fa-money"></i> $<?php echo number_format($job['salary_min']); ?><?php if (!empty($job['salary_max'])): ?>–$<?php echo number_format($job['salary_max']); ?><?php endif; ?></span>
                        <?php endif; ?>
                        <span><i class="fa fa-map-marker"></i> <?php echo clean($job['location_city']??'Remote'); ?></span>
                    </div>
                </div>
                <div class="jg-job-card__actions">
                    <a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>" class="jg-btn jg-btn--primary jg-btn--sm">Apply</a>
                    <span class="jg-badge jg-badge--<?php echo strtolower(str_replace(['_',' '],'-',$job['job_type']??'full-time')); ?>">
                        <?php echo ucfirst(str_replace('_',' ',$job['job_type']??'Full Time')); ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center" style="padding:40px 0">
            <p class="lead">No jobs posted yet. <a href="<?php echo SITE_URL; ?>/register?role=employer">Be the first to post!</a></p>
        </div>
        <?php endif; ?>
        <div class="text-center" style="margin-top:36px">
            <a href="<?php echo SITE_URL; ?>/jobs" class="jg-btn jg-btn--outline">Browse All Jobs <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- ======================================================
     FEATURED JOBS
====================================================== -->
<section class="jg-section jg-section--gray jg-reveal-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center js-reveal">
                <span class="jg-label">Featured Jobs</span>
                <h2 class="jg-section__title">Browse Featured Jobs</h2>
                <p class="jg-section__sub">Handpicked opportunities from our top employer partners.</p>
            </div>
        </div>
        <div class="jg-featured-grid">
            <?php if (!empty($featuredJobs)): foreach ($featuredJobs as $fi => $job):
                $stockImgs = [
                    'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&q=80&fit=crop',
                    'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80&fit=crop',
                    'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600&q=80&fit=crop',
                    'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&q=80&fit=crop',
                    'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&q=80&fit=crop',
                    'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&q=80&fit=crop',
                ];
                $imgFallback = $stockImgs[$job['id'] % count($stockImgs)];
                $cardImg = !empty($job['job_image'])
                    ? SITE_URL.'/uploads/jobs/'.clean($job['job_image'])
                    : (!empty($job['logo']) ? SITE_URL.'/uploads/logos/'.clean($job['logo']) : $imgFallback);
            ?>
            <div class="jg-featured-item js-reveal" data-reveal-delay="<?php echo ($fi % 3) * 100; ?>">
                <div class="jg-featured-card">
                    <div class="jg-featured-card__badge">Featured</div>
                    <div class="jg-featured-card__top">
                        <img src="<?php echo $cardImg; ?>" alt="<?php echo clean($job['title']); ?>">
                    </div>
                    <div class="jg-featured-card__body">
                        <h4><a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>"><?php echo clean($job['title']); ?></a></h4>
                        <ul class="jg-featured-card__meta">
                            <li><i class="fa fa-building-o"></i> <?php echo clean($job['company_name']??'Company'); ?></li>
                            <li><i class="fa fa-map-marker"></i> <?php echo clean($job['location_city']??'Remote'); ?></li>
                            <li><i class="fa fa-clock-o"></i> <?php echo ucfirst(str_replace('_',' ',$job['job_type']??'Full Time')); ?></li>
                            <?php if (!empty($job['salary_min'])): ?>
                            <li><i class="fa fa-money"></i> $<?php echo number_format($job['salary_min']); ?><?php if (!empty($job['salary_max'])): ?>–$<?php echo number_format($job['salary_max']); ?><?php endif; ?></li>
                            <?php endif; ?>
                        </ul>
                        <p><?php echo clean(substr(strip_tags($job['description']??''),0,90)); ?>...</p>
                    </div>
                    <div class="jg-featured-card__footer">
                        <a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>" class="jg-btn jg-btn--primary jg-btn--sm">Apply Now</a>
                        <?php if (isLoggedIn() && $_SESSION['role']==='job_seeker'): ?>
                        <a href="<?php echo SITE_URL; ?>/seeker/saved-jobs/save/<?php echo $job['id']; ?>" class="jg-btn jg-btn--outline jg-btn--sm"><i class="fa fa-bookmark-o"></i> Save</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div style="text-align:center;padding:30px 0;width:100%"><p class="lead">Featured jobs coming soon.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ======================================================
     TESTIMONIALS
====================================================== -->
<section class="jg-section jg-testimonials jg-reveal-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center js-reveal">
                <span class="jg-label">What Our Clients Say</span>
                <h2 class="jg-section__title" style="color:#fff">Our Testimonials</h2>
                <p class="jg-section__sub" style="color:rgba(255,255,255,.65);margin-bottom:48px">Real stories from professionals who found their dream jobs with us</p>
            </div>
        </div>
        <?php
        $tstPhotos = [
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120&h=120&q=80&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=120&h=120&q=80&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=120&h=120&q=80&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=120&h=120&q=80&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&q=80&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=120&h=120&q=80&fit=crop&crop=face',
        ];
        $demoTsts = [
            ['Jackson P.','Senior Developer',4,'Great platform for finding quality tech jobs. I landed my dream role within two weeks of signing up. The search filters are incredibly precise.',0],
            ['Maria S.','Marketing Manager',5,'The job alerts saved me so much time. I got notified about the perfect position and applied immediately. Now I love my new job!',1],
            ['David K.','UX Designer',5,'The employer responses are fast and professional. The whole process from application to offer was seamless and stress-free.',2],
        ];
        $items = [];
        if (!empty($testimonials)) {
            foreach ($testimonials as $i=>$t) {
                $items[] = ['name'=>clean($t['author_name']),'role'=>clean($t['author_role']??''),'rating'=>(int)($t['rating']??5),'text'=>clean($t['content']),'photo'=>!empty($t['author_photo'])?SITE_URL.'/uploads/testimonials/'.clean($t['author_photo']):$tstPhotos[$i%count($tstPhotos)]];
            }
        } else {
            foreach ($demoTsts as [$name,$role,$rating,$text,$pi]) $items[]=compact('name','role','rating','text')+['photo'=>$tstPhotos[$pi]];
        }
        ?>
        <div class="jg-tst-grid">
            <?php foreach ($items as $ti => $t): ?>
            <div class="jg-tst-item js-reveal" data-reveal-delay="<?php echo $ti * 100; ?>">
                <div class="jg-tst-card2">
                    <div class="jg-tst-card2__top">
                        <img src="<?php echo $t['photo']; ?>" alt="<?php echo $t['name']; ?>" class="jg-tst-card2__photo">
                        <div class="jg-tst-card2__meta">
                            <strong><?php echo $t['name']; ?></strong>
                            <span><?php echo $t['role']; ?></span>
                            <div class="jg-tst-card2__stars">
                                <?php for ($i=1;$i<=$t['rating'];$i++) echo '<i class="fa fa-star"></i>'; ?>
                            </div>
                        </div>
                        <div class="jg-tst-card2__quote"><i class="fa fa-quote-right"></i></div>
                    </div>
                    <p class="jg-tst-card2__text">"<?php echo $t['text']; ?>"</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ======================================================
     LATEST BLOG
====================================================== -->
<section class="jg-section jg-reveal-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center js-reveal">
                <span class="jg-label">Latest News</span>
                <h2 class="jg-section__title">Latest News &amp; Blog</h2>
                <p class="jg-section__sub">Career tips, industry news and updates to keep you ahead.</p>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($latestPosts)): foreach ($latestPosts as $bi => $post): ?>
            <div class="col-md-4 col-sm-6" style="margin-bottom:28px">
                <div class="jg-blog-card js-reveal" data-reveal-delay="<?php echo $bi * 100; ?>">
                    <div class="jg-blog-card__img">
                        <img src="<?php echo !empty($post['featured_image']) ? SITE_URL.'/uploads/blog/'.clean($post['featured_image']) : 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=720&q=80&fit=crop'; ?>" alt="">
                        <div class="jg-blog-card__overlay"></div>
                    </div>
                    <div class="jg-blog-card__body">
                        <div class="jg-blog-card__meta"><span><i class="fa fa-calendar"></i> <?php echo date('d M Y',strtotime($post['published_at'])); ?></span></div>
                        <h4><a href="<?php echo SITE_URL; ?>/blog/<?php echo $post['id']; ?>"><?php echo clean($post['title']); ?></a></h4>
                        <p><?php echo clean(substr(strip_tags($post['content']??''),0,100)); ?>...</p>
                        <a href="<?php echo SITE_URL; ?>/blog/<?php echo $post['id']; ?>" class="jg-blog-card__link">Read More <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-md-12 text-center" style="padding:30px 0"><p class="lead">Blog posts coming soon.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ======================================================
     CONTACT
====================================================== -->
<section class="jg-contact jg-reveal-section" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 js-reveal" data-reveal-delay="0">
                <span class="jg-label">Get In Touch</span>
                <h2 class="jg-section__title">Contact Us</h2>
                <p style="color:#666;margin-bottom:28px">Have a question or need help? We'd love to hear from you.</p>
                <form action="<?php echo SITE_URL; ?>/contact" method="post" class="jg-contact-form">
                    <div class="jg-form-group"><input type="text" name="name" placeholder="Your full name" required></div>
                    <div class="jg-form-group"><input type="email" name="email" placeholder="Your email address" required></div>
                    <div class="jg-form-group"><textarea name="message" rows="5" placeholder="Your message..." required></textarea></div>
                    <button type="submit" class="jg-btn jg-btn--primary">Send Message <i class="fa fa-paper-plane"></i></button>
                </form>
            </div>
            <div class="col-md-6 col-sm-12 jg-contact__right js-reveal" data-reveal-delay="150">
                <div class="jg-contact__info">
                    <div class="jg-contact__info-item">
                        <div class="jg-contact__info-icon"><i class="fa fa-map-marker"></i></div>
                        <div><strong>Address</strong><span>212 Barrington Court, New York, 10001</span></div>
                    </div>
                    <div class="jg-contact__info-item">
                        <div class="jg-contact__info-icon"><i class="fa fa-envelope"></i></div>
                        <div><strong>Email</strong><span><?php echo defined('SITE_EMAIL') ? SITE_EMAIL : 'hello@jobportal.com'; ?></span></div>
                    </div>
                    <div class="jg-contact__info-item">
                        <div class="jg-contact__info-icon"><i class="fa fa-phone"></i></div>
                        <div><strong>Phone</strong><span>+1 (555) 555-1234</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================
     BACK-TO-TOP BUTTON
====================================================== -->
<button class="jg-top-btn" id="jg-top-btn" aria-label="Back to top">
    <i class="fa fa-chevron-up"></i>
</button>

<!-- ======================================================
     PAGE STYLES
====================================================== -->
<style>
/* ─── SMOOTH SCROLL & SELECTION ─────────────────────── */
html { scroll-behavior: smooth; }
::selection { background: #0a65cc; color: #fff; }

/* ─── SCROLL PROGRESS BAR ───────────────────────────── */
#jg-progress-bar {
    position: fixed; top: 0; left: 0; height: 3px; z-index: 99999;
    background: linear-gradient(90deg, #0a65cc, #14a077);
    width: 0%; transition: width .1s linear;
    pointer-events: none;
}

/* ─── REVEAL ANIMATION BASE ─────────────────────────── */
.js-reveal {
    opacity: 0;
    transform: translateY(32px);
    transition: opacity .65s cubic-bezier(.22,1,.36,1), transform .65s cubic-bezier(.22,1,.36,1);
}
.js-reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ─── HERO — full-width horizontal banner ─────────────── */
.jg-hero {
    position: relative;
    margin-top: -70px;          /* pull flush behind fixed navbar */
    padding-top: 0;
    padding-bottom: 0;
    min-height: 92vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

/* real photo layer — covers 100% width × full hero height */
.jg-hero__photo {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1800&q=70&fit=crop&crop=center')
                center center / cover no-repeat;
    transform: scale(1.04);     /* tiny scale so parallax never shows white edge */
    transition: transform .1s linear;
}

/* dark gradient overlay — stronger at top (navbar area) and left (text area) */
.jg-hero__overlay {
    position: absolute; inset: 0;
    background:
        linear-gradient(
            to right,
            rgba(5,14,30,.92)  0%,
            rgba(5,14,30,.82) 40%,
            rgba(5,14,30,.55) 70%,
            rgba(5,14,30,.30) 100%
        ),
        linear-gradient(
            to bottom,
            rgba(5,14,30,.55) 0%,
            transparent 30%,
            transparent 70%,
            rgba(5,14,30,.70) 100%
        );
}

/* dot texture */
.jg-hero__bg {
    position: absolute; inset: 0; pointer-events: none; z-index: 1;
    background-image: radial-gradient(circle, rgba(255,255,255,.06) 1px, transparent 1px);
    background-size: 28px 28px;
}

/* particles canvas */
.jg-hero__particles { position: absolute; inset: 0; pointer-events: none; z-index: 2; }

/* inner container — centred content column */
.jg-hero__container {
    position: relative; z-index: 3;
    padding-top: 130px;   /* clear the 70px navbar + breathing room */
    padding-bottom: 100px;
    text-align: center;
    max-width: 860px;
    margin-left: auto; margin-right: auto;
}

/* eyebrow */
.jg-hero__eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.10); border: 1px solid rgba(255,255,255,.22);
    border-radius: 30px; padding: 7px 20px; font-size: 13px; color: rgba(255,255,255,.85);
    margin-bottom: 28px; backdrop-filter: blur(6px);
    opacity: 0; animation: heroLineIn .6s .05s cubic-bezier(.22,1,.36,1) forwards;
}
.jg-hero__eyebrow-dot {
    width: 8px; height: 8px; border-radius: 50%; background: #14a077; flex-shrink: 0;
    animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot { 0%,100%{box-shadow:0 0 0 0 rgba(20,160,119,.5)} 50%{box-shadow:0 0 0 7px rgba(20,160,119,0)} }

/* headline */
.jg-hero__title {
    font-size: 58px; font-weight: 800; color: #fff;
    line-height: 1.12; margin-bottom: 20px; letter-spacing: -2px;
    display: block;
}
.jg-hero__title-line {
    display: block;
    opacity: 0; transform: translateY(28px);
    animation: heroLineIn .75s cubic-bezier(.22,1,.36,1) forwards;
}
.jg-hero__title-line:nth-child(1) { animation-delay: .18s; }
.jg-hero__title-line:nth-child(2) { animation-delay: .32s; }
.jg-hero__title-line--accent {
    background: linear-gradient(90deg, #4db8ff, #14a077);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
@keyframes heroLineIn { to { opacity:1; transform:translateY(0); } }

.jg-hero__sub {
    color: rgba(255,255,255,.72); font-size: 18px; margin-bottom: 44px; line-height: 1.65;
    max-width: 620px; margin-left: auto; margin-right: auto;
    opacity: 0; animation: heroLineIn .7s .46s cubic-bezier(.22,1,.36,1) forwards;
}

/* search wrap */
.jg-search-wrap {
    opacity: 0; animation: heroLineIn .7s .60s cubic-bezier(.22,1,.36,1) forwards;
    margin-bottom: 16px;
}

/* ── search bar — wide pill ── */
.jg-search {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 20px 60px rgba(0,0,0,.35), 0 0 0 1px rgba(255,255,255,.08);
    overflow: hidden;
    max-width: 780px;
    margin: 0 auto;
}
.jg-search__inner {
    display: flex; align-items: stretch; min-height: 64px;
}
.jg-search__field {
    display: flex; align-items: center; flex: 1; padding: 0 22px;
    position: relative;
}
.jg-search__divider {
    width: 1px; background: #e0e6f0; align-self: stretch;
    margin: 12px 0; flex-shrink: 0;
}
.jg-search__icon { color: #0a65cc; margin-right: 12px; font-size: 16px; flex-shrink: 0; }
.jg-search__field input {
    border: none; outline: none; width: 100%;
    font-size: 15px; color: #333; background: transparent; height: 100%;
}
.jg-search__field input::placeholder { color: #aaa; }
.jg-search__btn {
    background: linear-gradient(135deg, #0a65cc, #0853aa);
    color: #fff; border: none;
    padding: 0 46px; font-size: 15px; font-weight: 700;
    cursor: pointer; transition: .2s; white-space: nowrap;
    min-height: 64px; border-radius: 0 10px 10px 0;
    position: relative; overflow: hidden;
}
.jg-search__btn:hover { background: linear-gradient(135deg, #084fa3, #063d82); }

/* popular tags — sit below the search pill */
.jg-search__tags {
    display: flex; align-items: center; justify-content: center;
    gap: 10px; flex-wrap: wrap;
    padding: 14px 0 0;
    margin-top: 14px;
    border-radius: 20px;
    font-size: 13px; color: rgba(255,255,255,.55);
    opacity: 0; animation: heroLineIn .6s .78s cubic-bezier(.22,1,.36,1) forwards;
}
.jg-search__tags span { color: rgba(255,255,255,.40); margin-right: 2px; }
.jg-search__tags a {
    color: rgba(255,255,255,.85); text-decoration: none;
    background: rgba(255,255,255,.12); padding: 4px 14px;
    border-radius: 20px; font-size: 12px; font-weight: 600;
    border: 1px solid rgba(255,255,255,.18);
    transition: background .2s, border-color .2s;
}
.jg-search__tags a:hover { background: rgba(255,255,255,.24); border-color: rgba(255,255,255,.35); }

/* stat pills row */
.jg-hero__pills {
    display: flex; align-items: center; justify-content: center;
    gap: 16px; flex-wrap: wrap; margin-top: 48px;
    opacity: 0; animation: heroLineIn .6s .92s cubic-bezier(.22,1,.36,1) forwards;
}
.jg-hero__pill {
    display: flex; align-items: center; gap: 10px;
    background: rgba(255,255,255,.09); border: 1px solid rgba(255,255,255,.18);
    backdrop-filter: blur(8px);
    border-radius: 40px; padding: 10px 22px;
    color: #fff; font-size: 14px;
    transition: background .2s, transform .2s;
}
.jg-hero__pill:hover { background: rgba(255,255,255,.16); transform: translateY(-2px); }
.jg-hero__pill i        { color: #4db8ff; font-size: 16px; }
.jg-hero__pill strong   { font-weight: 800; font-size: 16px; margin-right: 3px; }
.jg-hero__pill span     { color: rgba(255,255,255,.65); font-size: 12px; }

/* scroll cue */
.jg-hero__scroll-cue {
    position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%);
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    color: rgba(255,255,255,.40); font-size: 10px; letter-spacing: 3px; text-transform: uppercase;
    z-index: 4;
    opacity: 0; animation: heroLineIn .6s 1.5s forwards;
}
.jg-hero__scroll-line {
    width: 1px; height: 48px;
    background: linear-gradient(to bottom, rgba(255,255,255,.5), transparent);
    animation: scrollPulse 2.2s ease-in-out 2s infinite;
}
@keyframes scrollPulse { 0%,100%{transform:scaleY(1);opacity:.4} 50%{transform:scaleY(1.4);opacity:1} }

/* ─── SEARCH BAR ─────────────────────────────────────── */
.jg-search { background:#fff; border-radius:12px; box-shadow:0 12px 40px rgba(0,0,0,.25); overflow:hidden; }
.jg-search__inner { display:flex; align-items:stretch; min-height:58px; }
.jg-search__field { display:flex; align-items:center; flex:1; padding:0 18px; border-right:1px solid #e0e6f0; }
.jg-search__field:last-of-type { border-right:none; }
.jg-search__icon { color:#aaa; margin-right:10px; font-size:15px; flex-shrink:0; }
.jg-search__field input { border:none; outline:none; width:100%; font-size:15px; color:#444; background:transparent; height:100%; }
.jg-search__btn {
    background:#0a65cc; color:#fff; border:none;
    padding:0 36px; font-size:15px; font-weight:700;
    cursor:pointer; transition:.2s; white-space:nowrap; min-height:58px;
    position:relative; overflow:hidden;
}
.jg-search__btn::after {
    content:''; position:absolute; inset:0;
    background:rgba(255,255,255,0); transition:.3s;
}
.jg-search__btn:hover { background:#084fa3; }
.jg-search__btn:hover::after { background:rgba(255,255,255,.06); }
.jg-search__tags {
    padding:10px 18px;
    background:rgba(255,255,255,.10);
    border-top:1px solid rgba(255,255,255,.18);
    font-size:13px; color:rgba(255,255,255,.65);
    display:flex; align-items:center; gap:6px; flex-wrap:wrap;
}
.jg-search__tags span { color:rgba(255,255,255,.45); margin-right:2px; }
.jg-search__tags a {
    color:#fff; text-decoration:none;
    background:rgba(255,255,255,.15); padding:3px 12px;
    border-radius:20px; font-size:12px; font-weight:600; transition:.2s;
}
.jg-search__tags a:hover { background:rgba(255,255,255,.30); }

/* ─── STATS STRIP ────────────────────────────────────── */
.jg-stats {
    background: linear-gradient(90deg, #0a65cc 0%, #0d3060 100%);
    padding: 48px 0;
}
.jg-stats__grid {
    display: flex; flex-wrap: wrap;
    justify-content: space-around; gap: 24px;
}
.jg-stats__item { text-align: center; }
.jg-stats__item strong {
    display: block; font-size: 42px; font-weight: 800; color: #fff;
    line-height: 1; margin-bottom: 6px;
}
.jg-stats__item span { font-size: 14px; color: rgba(255,255,255,.65); }

/* ─── FEATURED CARDS ─────────────────────────────────── */
.jg-featured-grid  { display:flex; flex-wrap:wrap; margin:0 -12px; }
.jg-featured-item  { width:33.333%; padding:0 12px 24px; display:flex; }
.jg-featured-card  {
    background:#fff; border-radius:12px; border:1px solid #e0e6f0;
    overflow:hidden; display:flex; flex-direction:column; width:100%;
    transition:box-shadow .25s, transform .25s;
}
.jg-featured-card:hover { box-shadow:0 8px 32px rgba(10,101,204,.13); transform:translateY(-5px); }
.jg-featured-card__badge { background:#0a65cc; color:#fff; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:5px 14px; display:inline-block; }
.jg-featured-card__top   { height:180px; overflow:hidden; flex-shrink:0; }
.jg-featured-card__top img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .4s; }
.jg-featured-card:hover .jg-featured-card__top img { transform:scale(1.05); }
.jg-featured-card__body  { padding:20px 22px; flex:1; }
.jg-featured-card__body h4 { font-size:16px; font-weight:700; margin:0 0 12px; line-height:1.4; }
.jg-featured-card__body h4 a { color:#1a1a2e; text-decoration:none; }
.jg-featured-card__body h4 a:hover { color:#0a65cc; }
.jg-featured-card__meta  { list-style:none; padding:0; margin:0 0 12px; display:flex; flex-wrap:wrap; gap:8px; font-size:13px; color:#666; }
.jg-featured-card__meta li { display:flex; align-items:center; gap:5px; }
.jg-featured-card__meta li i { color:#0a65cc; }
.jg-featured-card__body p { font-size:13px; color:#888; line-height:1.65; margin:0; }
.jg-featured-card__footer { padding:14px 22px; border-top:1px solid #e0e6f0; display:flex; gap:10px; flex-wrap:wrap; flex-shrink:0; }

/* ─── CTA BANNER ─────────────────────────────────────── */
.jg-cta {
    position:relative;
    background: linear-gradient(135deg,rgba(10,22,40,.95),rgba(10,101,204,.92)),
                url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1400&q=50&fit=crop') center/cover no-repeat;
    padding:60px 0; overflow:hidden; color:#fff;
}
.jg-cta__bg { position:absolute;inset:0;opacity:.05;background-image:repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%);background-size:20px 20px }
.jg-cta .container { position:relative; }
.jg-cta h2 { font-size:30px; font-weight:800; margin-bottom:12px; }
.jg-cta p  { color:rgba(255,255,255,.82); font-size:15px; max-width:520px; margin-bottom:0; }
.jg-cta__action { display:flex; align-items:center; justify-content:flex-end; }

/* ─── TESTIMONIALS ───────────────────────────────────── */
.jg-testimonials {
    background: linear-gradient(135deg,rgba(10,22,40,.97),rgba(13,48,96,.96)),
                url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1400&q=50&fit=crop') center/cover no-repeat;
    padding:80px 0;
}
.jg-tst-grid  { display:flex; flex-wrap:wrap; margin:0 -14px; }
.jg-tst-item  { width:33.333%; padding:0 14px 28px; display:flex; }
.jg-tst-card2 {
    background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.13);
    border-radius:16px; padding:28px 26px;
    display:flex; flex-direction:column; width:100%;
    transition:background .25s, transform .25s;
}
.jg-tst-card2:hover { background:rgba(255,255,255,.12); transform:translateY(-4px); }
.jg-tst-card2__top  { display:flex; align-items:center; gap:14px; margin-bottom:20px; }
.jg-tst-card2__photo { width:60px; height:60px; border-radius:50%; object-fit:cover; flex-shrink:0; border:3px solid rgba(255,255,255,.30); }
.jg-tst-card2__meta strong { display:block; color:#fff; font-size:15px; font-weight:700; }
.jg-tst-card2__meta span   { font-size:12px; color:rgba(255,255,255,.55); display:block; margin-bottom:5px; }
.jg-tst-card2__stars .fa-star { color:#ffc107; font-size:12px; }
.jg-tst-card2__quote { font-size:22px; color:rgba(255,255,255,.20); flex-shrink:0; margin-left:auto; }
.jg-tst-card2__text { font-size:14px; line-height:1.75; color:rgba(255,255,255,.82); margin:0; flex:1; font-style:italic; }

/* ─── CONTACT ────────────────────────────────────────── */
.jg-contact { padding:70px 0; background:#fff; }
.jg-contact__right { padding-top:40px; }
.jg-contact-form .jg-form-group { margin-bottom:16px; }
.jg-contact-form input,
.jg-contact-form textarea {
    width:100%; border:1.5px solid #e0e6f0; border-radius:8px;
    padding:13px 16px; font-size:14px; outline:none; transition:.2s;
    background:#fafbfd; font-family:inherit;
}
.jg-contact-form input:focus,
.jg-contact-form textarea:focus { border-color:#0a65cc; background:#fff; box-shadow:0 0 0 3px rgba(10,101,204,.08); }
.jg-contact-form textarea { resize:vertical; min-height:120px; }

/* Input float-label ripple effect */
.jg-form-group { position:relative; }
.jg-form-group input::placeholder,
.jg-form-group textarea::placeholder { transition:opacity .2s; }
.jg-form-group input:focus::placeholder,
.jg-form-group textarea:focus::placeholder { opacity:.45; }

/* ─── BACK TO TOP ────────────────────────────────────── */
.jg-top-btn {
    position: fixed; bottom: 32px; right: 32px; z-index: 9000;
    width: 46px; height: 46px; border-radius: 50%;
    background: #0a65cc; color: #fff; border: none; cursor: pointer;
    box-shadow: 0 4px 20px rgba(10,101,204,.35);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    opacity: 0; transform: translateY(12px) scale(.9);
    transition: opacity .3s, transform .3s, background .2s;
    pointer-events: none;
}
.jg-top-btn.visible { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
.jg-top-btn:hover { background: #084fa3; transform: translateY(-2px) scale(1.05); }

/* ─── RIPPLE ─────────────────────────────────────────── */
.jg-ripple {
    position:absolute; border-radius:50%;
    background:rgba(255,255,255,.35); pointer-events:none;
    transform:scale(0); animation:rippleOut .6s linear;
}
@keyframes rippleOut { to { transform:scale(4); opacity:0; } }

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media (max-width:991px) {
    .jg-featured-item { width:50%; }
    .jg-tst-item      { width:50%; }
    .jg-stats__item strong { font-size:32px; }
}
@media (max-width:767px) {
    .jg-hero { min-height: auto; }
    .jg-hero__container { padding-top: 110px; padding-bottom: 70px; }
    .jg-hero__title { font-size: 30px; letter-spacing: -.5px; }
    .jg-hero__sub   { font-size: 15px; }
    .jg-search__inner  { flex-direction: column; min-height: auto; }
    .jg-search__divider { display: none; }
    .jg-search__field  { border-bottom: 1px solid #e0e6f0; min-height: 50px; }
    .jg-search__btn    { width: 100%; padding: 14px; min-height: 50px; border-radius: 0 0 14px 14px; }
    .jg-hero__pills    { gap: 8px; margin-top: 28px; }
    .jg-hero__pill     { padding: 8px 14px; font-size: 12px; }
    .jg-featured-item  { width: 100%; }
    .jg-tst-item       { width: 100%; }
    .jg-cta__action    { justify-content: flex-start; margin-top: 20px; }
    .jg-stats__grid    { gap: 16px; }
    .jg-stats__item strong { font-size: 28px; }
}
</style>

<!-- ======================================================
     SCRIPTS
====================================================== -->
<script>
(function(){
'use strict';

/* ── 1. Scroll progress bar ── */
var bar = document.createElement('div');
bar.id = 'jg-progress-bar';
document.body.prepend(bar);
window.addEventListener('scroll', function(){
    var pct = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
    bar.style.width = Math.min(pct, 100) + '%';
}, { passive: true });

/* ── 2. IntersectionObserver reveal (.js-reveal) ── */
var revealEls = document.querySelectorAll('.js-reveal');
if ('IntersectionObserver' in window) {
    var revealObs = new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = parseInt(el.dataset.revealDelay || 0);
                setTimeout(function(){ el.classList.add('visible'); }, delay);
                revealObs.unobserve(el);
            }
        });
    }, { threshold: 0.12 });
    revealEls.forEach(function(el){ revealObs.observe(el); });
} else {
    /* Fallback — just show everything */
    revealEls.forEach(function(el){ el.classList.add('visible'); });
}

/* ── 3. Animated counters ── */
function animateCounter(el) {
    var target = parseInt(el.dataset.target);
    var duration = 1800;
    var start = performance.now();
    function tick(now) {
        var elapsed = now - start;
        var progress = Math.min(elapsed / duration, 1);
        /* ease out quart */
        var eased = 1 - Math.pow(1 - progress, 4);
        var val = Math.floor(eased * target);
        el.textContent = val >= 1000 ? val.toLocaleString() : val;
        if (progress < 1) requestAnimationFrame(tick);
        else el.textContent = target >= 1000 ? target.toLocaleString() : target;
    }
    requestAnimationFrame(tick);
}
var counters = document.querySelectorAll('.jg-counter');
var counterTriggered = false;
if ('IntersectionObserver' in window) {
    var counterObs = new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
            if (entry.isIntersecting && !counterTriggered) {
                counterTriggered = true;
                counters.forEach(function(c){ animateCounter(c); });
            }
        });
    }, { threshold: 0.3 });
    counters.forEach(function(c){ counterObs.observe(c); });
}

/* ── 4. Back-to-top button ── */
var topBtn = document.getElementById('jg-top-btn');
window.addEventListener('scroll', function(){
    topBtn.classList.toggle('visible', window.scrollY > 400);
}, { passive: true });
topBtn.addEventListener('click', function(){
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* ── 5. Ripple on primary buttons ── */
document.querySelectorAll('.jg-btn--primary, .jg-search__btn').forEach(function(btn){
    btn.style.position = 'relative';
    btn.style.overflow = 'hidden';
    btn.addEventListener('click', function(e){
        var rect = btn.getBoundingClientRect();
        var r = document.createElement('span');
        r.className = 'jg-ripple';
        var size = Math.max(rect.width, rect.height);
        r.style.cssText = 'width:'+size+'px;height:'+size+'px;left:'+(e.clientX - rect.left - size/2)+'px;top:'+(e.clientY - rect.top - size/2)+'px;';
        btn.appendChild(r);
        setTimeout(function(){ r.remove(); }, 700);
    });
});

/* ── 6. Canvas particle system (hero) ── */
var canvas = document.createElement('canvas');
canvas.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;pointer-events:none;';
var heroParticles = document.getElementById('jg-particles');
if (heroParticles) {
    heroParticles.appendChild(canvas);
    var ctx = canvas.getContext('2d');
    var particles = [];
    var N = 38;
    function resize(){
        canvas.width  = heroParticles.offsetWidth;
        canvas.height = heroParticles.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize, { passive: true });
    for (var i = 0; i < N; i++) {
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            r: Math.random() * 2 + .5,
            dx: (Math.random() - .5) * .4,
            dy: (Math.random() - .5) * .4,
            a: Math.random() * .5 + .1
        });
    }
    function drawParticles(){
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(function(p){
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(255,255,255,' + p.a + ')';
            ctx.fill();
            p.x += p.dx; p.y += p.dy;
            if (p.x < 0 || p.x > canvas.width)  p.dx *= -1;
            if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
        });
        /* connect nearby particles */
        for (var i = 0; i < particles.length; i++) {
            for (var j = i+1; j < particles.length; j++) {
                var dx = particles[i].x - particles[j].x;
                var dy = particles[i].y - particles[j].y;
                var dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 100) {
                    ctx.beginPath();
                    ctx.strokeStyle = 'rgba(255,255,255,' + (.08 * (1 - dist/100)) + ')';
                    ctx.lineWidth = .5;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(drawParticles);
    }
    drawParticles();
}

/* ── 7. Parallax on hero background photo ── */
var heroPhoto = document.querySelector('.jg-hero__photo');
if (heroPhoto) {
    window.addEventListener('scroll', function(){
        heroPhoto.style.transform = 'scale(1.04) translateY(' + (window.scrollY * .08) + 'px)';
    }, { passive: true });
}

/* ── 8. Job-card hover tilt ── */
document.querySelectorAll('.jg-job-card').forEach(function(card){
    card.addEventListener('mousemove', function(e){
        var rect = card.getBoundingClientRect();
        var cx = rect.left + rect.width  / 2;
        var cy = rect.top  + rect.height / 2;
        var rx = (e.clientY - cy) / rect.height * 6;
        var ry = (cx - e.clientX) / rect.width  * 6;
        card.style.transform = 'perspective(800px) rotateX('+rx+'deg) rotateY('+ry+'deg) translateY(-3px)';
    });
    card.addEventListener('mouseleave', function(){
        card.style.transform = '';
    });
});

/* ── 9. Smooth section highlight in nav (active on scroll) ── */
var sections = document.querySelectorAll('section[id]');
var navLinks  = document.querySelectorAll('.jg-nav__links a');
window.addEventListener('scroll', function(){
    var scrollPos = window.scrollY + 120;
    sections.forEach(function(sec){
        if (scrollPos >= sec.offsetTop && scrollPos < sec.offsetTop + sec.offsetHeight) {
            navLinks.forEach(function(a){ a.parentElement.classList.remove('active'); });
            var match = document.querySelector('.jg-nav__links a[href*="#'+sec.id+'"]');
            if (match) match.parentElement.classList.add('active');
        }
    });
}, { passive: true });

})();
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>