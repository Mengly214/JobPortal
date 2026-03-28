<!-- ===== FOOTER ===== -->
<footer class="jg-footer">
    <div class="jg-footer__top">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="jg-footer__brand">
                        <a href="<?php echo SITE_URL; ?>/" class="jg-footer__logo">
                            <span class="jg-footer__logo-dot"></span><?php echo SITE_NAME; ?>
                        </a>
                        <p>Connecting talented professionals with great companies. Your next career move starts here.</p>
                        <div class="jg-footer__social">
                            <a href="#" aria-label="Facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="jg-footer__col">
                        <h5>For Candidates</h5>
                        <ul>
                            <li><a href="<?php echo SITE_URL; ?>/jobs">Browse Jobs</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/register?role=job_seeker">Add Resume</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/seeker/dashboard">My Dashboard</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/about">About Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="jg-footer__col">
                        <h5>For Employers</h5>
                        <ul>
                            <li><a href="<?php echo SITE_URL; ?>/register?role=employer">Post a Job</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/employer/dashboard">Manage Jobs</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/employer/profile">Company Profile</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/contact">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="jg-footer__col">
                        <h5>Join Our Newsletter</h5>
                        <p class="jg-footer__newsletter-desc">Subscribe to get the latest jobs posted and career tips delivered to your inbox.</p>
                        <form action="<?php echo SITE_URL; ?>/contact" method="post" class="jg-footer__newsletter">
                            <input type="email" name="email" placeholder="Your email address" required>
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="jg-footer__bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <p>Copyright &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="<?php echo SITE_URL; ?>/terms">Terms of Use</a>
                    <a href="<?php echo SITE_URL; ?>/contact">Contact</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo SITE_URL; ?>/assets/js/jquery.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/owl.carousel.min.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/smoothscroll.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/custom.js"></script>
<script>
$(document).ready(function(){
    if($('.jg-tst-carousel').length){
        $('.jg-tst-carousel').owlCarousel({
            loop:true,margin:20,autoplay:true,autoplayTimeout:5000,dots:true,nav:false,
            responsive:{0:{items:1},768:{items:2},992:{items:3}}
        });
    }
});
</script>

<style>
/* ============================================================
   JG DESIGN SYSTEM — Single CSS block, loaded after DOM
   All --jg-* vars defined here, available globally
============================================================ */
:root{
  --jg-primary:#0a65cc;
  --jg-secondary:#14a077;
  --jg-dark:#1a1a2e;
  --jg-gray:#f4f6f9;
  --jg-text:#444;
  --jg-border:#e0e6f0;
  --jg-radius:10px;
  --jg-shadow:0 4px 24px rgba(10,101,204,.10);
}

/* ---- Body ---- */
body{padding-top:70px}

/* ---- Footer ---- */
.jg-footer{background:#0d1b2e;color:#a0aec0;margin-top:0}
.jg-footer__top{padding:60px 0 40px;border-bottom:1px solid rgba(255,255,255,.07)}
.jg-footer__logo{font-size:22px;font-weight:800;color:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:8px;margin-bottom:14px}
.jg-footer__logo-dot{width:8px;height:8px;background:#14a077;border-radius:50%;display:inline-block}
.jg-footer__brand p{font-size:14px;line-height:1.7;color:#a0aec0;max-width:280px}
/* Footer social — dark background variant */
.jg-footer .jg-footer__social{display:flex;gap:10px;margin-top:18px}
.jg-footer .jg-footer__social a{width:36px;height:36px;border-radius:50%;border:1px solid rgba(255,255,255,.15);color:#a0aec0;display:flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:.2s}
.jg-footer .jg-footer__social a:hover{background:#0a65cc;border-color:#0a65cc;color:#fff}
.jg-footer__col{padding:0 10px}
.jg-footer__col h5{font-size:15px;font-weight:700;color:#fff;margin-bottom:18px;padding-bottom:10px;border-bottom:2px solid #0a65cc;display:inline-block}
.jg-footer__col ul{list-style:none;padding:0;margin:0}
.jg-footer__col ul li{margin-bottom:10px}
.jg-footer__col ul li a{font-size:14px;color:#a0aec0;text-decoration:none;transition:.2s;display:flex;align-items:center;gap:6px}
.jg-footer__col ul li a::before{content:'›';color:#0a65cc;font-size:16px;line-height:1}
.jg-footer__col ul li a:hover{color:#fff;padding-left:4px}
.jg-footer__newsletter-desc{color:#a0aec0;font-size:14px;margin-bottom:16px}
.jg-footer__newsletter{display:flex;border-radius:8px;overflow:hidden;border:1px solid rgba(255,255,255,.1)}
.jg-footer__newsletter input{flex:1;background:rgba(255,255,255,.05);border:none;outline:none;padding:12px 14px;font-size:13px;color:#fff}
.jg-footer__newsletter input::placeholder{color:#718096}
.jg-footer__newsletter button{background:#0a65cc;color:#fff;border:none;padding:12px 18px;font-size:13px;font-weight:600;cursor:pointer;transition:.2s;white-space:nowrap}
.jg-footer__newsletter button:hover{background:#084fa3}
.jg-footer__bottom{padding:18px 0}
.jg-footer__bottom p{margin:0;font-size:13px;color:#718096}
.jg-footer__bottom a{font-size:13px;color:#718096;text-decoration:none;margin-left:18px;transition:.2s}
.jg-footer__bottom a:hover{color:#fff}

/* ---- Navbar ---- */
.jg-nav{position:fixed;top:0;left:0;right:0;z-index:9999;background:#fff;box-shadow:0 2px 16px rgba(10,101,204,.10);height:70px;display:flex;align-items:center;transition:box-shadow .3s}
.jg-nav.scrolled{box-shadow:0 4px 24px rgba(10,101,204,.16)}

/* ---- Page Hero ---- */
.jg-page-hero{background:linear-gradient(135deg,#0a1628 0%,#0a65cc 100%);padding:52px 0 44px;color:#fff}
.jg-page-hero h1{font-size:32px;font-weight:800;margin:0 0 8px;letter-spacing:-.5px}
.jg-page-hero p{color:rgba(255,255,255,.75);font-size:16px;margin:0}
.jg-breadcrumb{font-size:13px;color:rgba(255,255,255,.6);margin-bottom:10px}
.jg-breadcrumb a{color:rgba(255,255,255,.7);text-decoration:none}
.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb i{margin:0 6px;font-size:11px}

/* ---- Sections ---- */
.jg-section{padding:60px 0}
.jg-section--gray{background:var(--jg-gray)}
.jg-label{display:inline-block;background:linear-gradient(135deg,#e8f0fd,#c8daf9);color:var(--jg-primary);font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:6px 16px;border-radius:20px;margin-bottom:14px}
.jg-label--light{background:rgba(255,255,255,.15);color:rgba(255,255,255,.9)}
.jg-section__title{font-size:30px;font-weight:800;color:var(--jg-dark);margin-bottom:12px;letter-spacing:-.5px}
.jg-section__sub{color:#888;font-size:15px;max-width:520px;margin:0 auto 36px}

/* ---- Buttons ---- */
.jg-btn{display:inline-flex;align-items:center;gap:8px;padding:12px 26px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:.2s;border:2px solid transparent}
.jg-btn--primary{background:var(--jg-primary);color:#fff;border-color:var(--jg-primary)}
.jg-btn--primary:hover{background:#084fa3;border-color:#084fa3;color:#fff}
.jg-btn--outline{background:transparent;color:var(--jg-primary);border-color:var(--jg-primary)}
.jg-btn--outline:hover{background:var(--jg-primary);color:#fff}
.jg-btn--white{background:#fff;color:var(--jg-primary);border-color:#fff}
.jg-btn--white:hover{background:transparent;color:#fff;border-color:#fff}
.jg-btn--sm{padding:8px 18px;font-size:13px}
button.jg-btn{border:2px solid transparent}

/* ---- Badges ---- */
.jg-badge{display:inline-block;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600}
.jg-badge--full-time{background:#e8f5e9;color:#2e7d32}
.jg-badge--part-time{background:#fff3e0;color:#e65100}
.jg-badge--intern,.jg-badge--internship{background:#e3f2fd;color:#1565c0}
.jg-badge--remote{background:#f3e5f5;color:#6a1b9a}
.jg-badge--contract{background:#fce4ec;color:#880e4f}
.jg-badge--freelance{background:#e8f5e9;color:#1b5e20}

/* ---- Alerts ---- */
.jg-alert{display:flex;align-items:center;gap:10px;padding:14px 16px;border-radius:8px;font-size:14px;margin-bottom:20px}
.jg-alert--success{background:#e8f5e9;color:#2e7d32;border-left:4px solid #4caf50}
.jg-alert--danger{background:#fdecea;color:#c62828;border-left:4px solid #f44336}

/* ---- Forms ---- */
.jg-form-group{margin-bottom:18px}
.jg-form-group label{display:block;font-size:13px;font-weight:600;color:#555;margin-bottom:7px}
.jg-form-control{width:100%;border:1.5px solid var(--jg-border);border-radius:8px;padding:12px 16px;font-size:14px;outline:none;transition:.2s;background:#fafbfd;font-family:inherit;color:var(--jg-text);box-sizing:border-box}
.jg-form-control:focus{border-color:var(--jg-primary);background:#fff;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
select.jg-form-control{height:46px;cursor:pointer}
textarea.jg-form-control{resize:vertical;min-height:80px}

/* ---- Filter box ---- */
.jg-filter-box{background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:20px;margin-bottom:30px;box-shadow:var(--jg-shadow)}
.jg-filter-box__row{display:flex;flex-wrap:wrap;gap:12px;align-items:center}
.jg-filter-field{position:relative;display:flex;align-items:center;flex:1;min-width:150px;border:1.5px solid var(--jg-border);border-radius:8px;background:#fafbfd;padding:0 14px;height:46px;transition:.2s}
.jg-filter-field:focus-within{border-color:var(--jg-primary);background:#fff}
.jg-filter-field--wide{flex:2}
.jg-filter-field > i{color:#aaa;margin-right:8px;font-size:14px;flex-shrink:0;pointer-events:none}
.jg-filter-field input{border:none;outline:none;background:transparent;font-size:14px;width:100%;color:var(--jg-text);height:100%}
.jg-filter-field select{border:none;outline:none;background:transparent;font-size:14px;width:100%;color:var(--jg-text);height:100%;appearance:none;-webkit-appearance:none;cursor:pointer}

/* ---- Results info ---- */
.jg-results-info{font-size:14px;color:#888;margin-bottom:16px}
.jg-results-info strong{color:var(--jg-dark)}

/* ---- Job cards ---- */
.jg-job-list{display:flex;flex-direction:column;gap:14px}
.jg-job-card{display:flex;align-items:center;gap:18px;background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:20px 24px;transition:.25s;position:relative}
.jg-job-card:hover{border-color:var(--jg-primary);box-shadow:var(--jg-shadow);transform:translateX(4px)}
.jg-job-card--featured{border-left:4px solid var(--jg-primary)}
.jg-job-card__featured-badge{position:absolute;top:12px;right:16px;background:var(--jg-primary);color:#fff;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:3px 10px;border-radius:20px}
.jg-job-card__logo{width:60px;height:60px;border-radius:10px;overflow:hidden;flex-shrink:0;border:1px solid var(--jg-border);display:flex;align-items:center;justify-content:center}
.jg-job-card__logo img{width:100%;height:100%;object-fit:cover}
.jg-job-card__logo-placeholder{width:60px;height:60px;background:linear-gradient(135deg,var(--jg-primary),#0a9acc);color:#fff;font-size:22px;font-weight:700;display:flex;align-items:center;justify-content:center;border-radius:10px}
.jg-job-card__logo-placeholder--lg{width:80px;height:80px;font-size:30px;border-radius:14px}
.jg-job-card__body{flex:1;min-width:0}
.jg-job-card__body h4{margin:0 0 5px;font-size:16px;font-weight:700}
.jg-job-card__body h4 a{color:var(--jg-dark);text-decoration:none}
.jg-job-card__body h4 a:hover{color:var(--jg-primary)}
.jg-job-card__body p{margin:0 0 8px;font-size:13px;color:#888;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.jg-job-card__meta{display:flex;flex-wrap:wrap;gap:12px;font-size:13px;color:#666}
.jg-job-card__meta span{display:flex;align-items:center;gap:5px}
.jg-job-card__actions{display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0}

/* ---- Pagination ---- */
.jg-pagination{display:flex;justify-content:center;gap:8px;margin-top:36px;flex-wrap:wrap}
.jg-page-btn{display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:8px;border:1.5px solid var(--jg-border);background:#fff;color:var(--jg-text);text-decoration:none;font-size:14px;font-weight:600;transition:.2s}
.jg-page-btn:hover,.jg-page-btn.active{background:var(--jg-primary);border-color:var(--jg-primary);color:#fff}

/* ---- Empty state ---- */
.jg-empty{text-align:center;padding:60px 20px;color:#aaa}
.jg-empty i{font-size:48px;margin-bottom:16px;display:block;color:#c5d5e8}
.jg-empty h3{font-size:20px;font-weight:700;color:#888;margin-bottom:8px}
.jg-empty p{font-size:14px}
.jg-empty a{color:var(--jg-primary)}

/* ---- Detail cards ---- */
.jg-detail-card{background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:28px;margin-bottom:20px}
.jg-detail-card__title{font-size:16px;font-weight:700;color:var(--jg-dark);margin:0 0 20px;padding-bottom:14px;border-bottom:1px solid var(--jg-border);display:flex;align-items:center;gap:8px}
.jg-detail-card__title i{color:var(--jg-primary)}
.jg-detail-card__subtitle{font-size:15px;font-weight:700;color:var(--jg-dark);margin:24px 0 12px}

/* ---- Job detail header ---- */
.jg-detail-header{display:flex;gap:24px;align-items:flex-start}
.jg-detail-header__logo{width:84px;height:84px;min-width:84px;border-radius:12px;border:1px solid var(--jg-border);overflow:hidden;display:flex;align-items:center;justify-content:center;background:var(--jg-gray)}
.jg-detail-header__logo img{width:100%;height:100%;object-fit:cover}
.jg-detail-header__info{flex:1}
.jg-detail-header__info h2{font-size:24px;font-weight:800;color:var(--jg-dark);margin:0 0 6px;line-height:1.3}
.jg-detail-header__company{color:#666;font-size:15px;margin-bottom:12px}

/* ---- Skills ---- */
.jg-skills{display:flex;flex-wrap:wrap;gap:8px;margin-top:12px}
.jg-skill{padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;background:#f0f5ff;color:var(--jg-primary);border:1px solid #c8daf9}
.jg-skill--required{background:var(--jg-primary);color:#fff;border-color:var(--jg-primary)}

/* ---- Prose ---- */
.jg-prose{font-size:14px;line-height:1.8;color:#555}
.jg-prose p{margin-bottom:14px}

/* ---- Overview sidebar list ---- */
.jg-overview-list{list-style:none;padding:0;margin:0}
.jg-overview-list li{display:flex;align-items:flex-start;gap:14px;padding:12px 0;border-bottom:1px solid var(--jg-border)}
.jg-overview-list li:last-child{border-bottom:none}
.jg-overview-list li i{color:var(--jg-primary);font-size:16px;width:18px;text-align:center;margin-top:2px}
.jg-overview-list small{display:block;font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.5px;font-weight:600;margin-bottom:2px}
.jg-overview-list strong{font-size:14px;color:var(--jg-dark)}
.jg-company-stats{list-style:none;padding:0;margin:0}
.jg-company-stats li{display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:1px solid var(--jg-border);font-size:14px}
.jg-company-stats li:last-child{border-bottom:none}
.jg-company-stats li i{color:var(--jg-primary);width:16px;margin-top:2px}
.jg-company-stats small{display:block;font-size:11px;color:#aaa}
.jg-company-stats strong{display:block;font-weight:600}
.jg-company-stats a{color:var(--jg-primary);text-decoration:none;word-break:break-all}

/* ---- Blog cards ---- */
.jg-blog-card{background:#fff;border-radius:var(--jg-radius);overflow:hidden;border:1px solid var(--jg-border);transition:.25s;height:100%}
.jg-blog-card:hover{box-shadow:var(--jg-shadow);transform:translateY(-4px)}
.jg-blog-card__img{position:relative;height:200px;overflow:hidden}
.jg-blog-card__img img{width:100%;height:100%;object-fit:cover;transition:.4s;display:block}
.jg-blog-card:hover .jg-blog-card__img img{transform:scale(1.05)}
.jg-blog-card__overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,22,40,.4),transparent)}
.jg-blog-card__body{padding:20px}
.jg-blog-card__meta{font-size:12px;color:#aaa;margin-bottom:10px;display:flex;gap:14px;flex-wrap:wrap}
.jg-blog-card__body h4{font-size:16px;font-weight:700;margin:0 0 10px;line-height:1.4}
.jg-blog-card__body h4 a{color:var(--jg-dark);text-decoration:none}
.jg-blog-card__body h4 a:hover{color:var(--jg-primary)}
.jg-blog-card__body p{font-size:13px;color:#888;line-height:1.6;margin-bottom:14px}
.jg-blog-card__link{font-size:13px;font-weight:600;color:var(--jg-primary);text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:gap .2s}
.jg-blog-card__link:hover{gap:10px}

/* ---- Blog detail ---- */
.jg-blog-detail__meta{font-size:13px;color:#aaa;margin-bottom:16px;display:flex;gap:16px;flex-wrap:wrap}
.jg-blog-detail__hero{width:100%;max-height:400px;object-fit:cover;border-radius:8px;margin-bottom:24px;display:block}
.jg-blog-detail__content{font-size:15px;line-height:1.9;color:#555}
.jg-recent-list{list-style:none;padding:0;margin:0}
.jg-recent-list li{border-bottom:1px solid var(--jg-border);padding:10px 0}
.jg-recent-list li:last-child{border-bottom:none}
.jg-recent-list a{font-size:14px;color:var(--jg-text);text-decoration:none;display:flex;align-items:flex-start;gap:8px;line-height:1.4}
.jg-recent-list a i{color:var(--jg-primary);margin-top:2px;flex-shrink:0}
.jg-recent-list a:hover{color:var(--jg-primary)}

/* ---- About section ---- */
.jg-about__row{display:flex;flex-wrap:wrap;align-items:center}
.jg-about__images{position:relative;height:380px;margin-bottom:20px}
.jg-about__img{position:absolute;border-radius:14px}
.jg-about__img--a{width:70%;height:280px;top:0;left:0;box-shadow:0 12px 40px rgba(0,0,0,.12);background:linear-gradient(135deg,#c8daf9,#a8c4f0)}
.jg-about__img--b{width:55%;height:200px;bottom:0;right:0;box-shadow:0 12px 40px rgba(0,0,0,.12);border:4px solid #fff;background:linear-gradient(135deg,#c8f0e0,#a0dbc0)}
.jg-about__content{padding-left:40px}
.jg-stats-row{display:flex;gap:24px;margin-top:28px;flex-wrap:wrap}
.jg-stat{text-align:center;min-width:80px}
.jg-stat strong{display:block;font-size:28px;font-weight:800;color:var(--jg-primary)}
.jg-stat span{font-size:13px;color:#888}

/* ---- Feature cards (about page) ---- */
.jg-feature-card{background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:28px 24px;height:100%;transition:.25s}
.jg-feature-card:hover{box-shadow:var(--jg-shadow);transform:translateY(-4px);border-color:var(--jg-primary)}
.jg-feature-card__icon{width:52px;height:52px;border-radius:12px;background:linear-gradient(135deg,#e8f0fd,#c8daf9);color:var(--jg-primary);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px}
.jg-feature-card h4{font-size:16px;font-weight:700;color:var(--jg-dark);margin:0 0 10px}
.jg-feature-card p{font-size:14px;color:#777;line-height:1.7;margin:0}

/* ---- CTA banner ---- */
.jg-cta{position:relative;background:linear-gradient(135deg,#0a1628,#0a65cc);padding:60px 0;overflow:hidden;color:#fff}
.jg-cta__bg{position:absolute;inset:0;opacity:.05;background-image:repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%);background-size:20px 20px}
.jg-cta .container{position:relative}
.jg-cta h2{font-size:28px;font-weight:800;margin-bottom:12px}
.jg-cta p{color:rgba(255,255,255,.8);font-size:15px;max-width:520px;margin-bottom:0}
.jg-cta__action{display:flex;align-items:center;justify-content:flex-end}

/* ---- Team cards ---- */
.jg-team-card{background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:28px 20px;text-align:center;transition:.25s;height:100%}
.jg-team-card:hover{box-shadow:var(--jg-shadow);transform:translateY(-4px)}
.jg-team-card__avatar{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--jg-primary),#0a9acc);color:#fff;font-size:28px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
.jg-team-card h4{font-size:16px;font-weight:700;color:var(--jg-dark);margin:0 0 4px}
.jg-team-card__role{font-size:13px;color:var(--jg-primary);font-weight:600}
.jg-team-card p{font-size:13px;color:#888;line-height:1.6;margin:12px 0}
.jg-team-card__social{display:flex;justify-content:center;gap:8px}
.jg-team-card__social a{width:32px;height:32px;border-radius:50%;border:1px solid var(--jg-border);display:flex;align-items:center;justify-content:center;color:#aaa;text-decoration:none;transition:.2s;font-size:13px}
.jg-team-card__social a:hover{background:var(--jg-primary);border-color:var(--jg-primary);color:#fff}

/* ---- Terms ---- */
.jg-terms-section{padding:20px 0;border-bottom:1px solid var(--jg-border)}
.jg-terms-section:last-of-type{border-bottom:none}
.jg-terms-section h3{font-size:16px;font-weight:700;color:var(--jg-dark);margin-bottom:10px;display:flex;align-items:center;gap:9px}
.jg-terms-section h3 i{color:var(--jg-primary)}
.jg-terms-section p{font-size:14px;color:#666;line-height:1.8;margin:0}
.jg-terms-footer{padding:20px 0 0;font-size:13px;color:#aaa}
.jg-terms-footer a{color:var(--jg-primary)}

/* ---- Testimonials ---- */
.jg-tst-card{background:rgba(255,255,255,.07);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.12);border-radius:14px;padding:32px 28px;margin:10px}
.jg-tst-card--light{background:#fff;border:1px solid var(--jg-border);box-shadow:0 2px 12px rgba(10,101,204,.06)}
.jg-tst-card__quote{font-size:28px;opacity:.7;margin-bottom:16px}
.jg-tst-card .jg-tst-card__quote{color:var(--jg-primary)}
.jg-testimonials .jg-tst-card__quote{color:var(--jg-primary)}
.jg-tst-card p{font-size:15px;line-height:1.7;margin-bottom:20px}
.jg-tst-card--light p{color:#555}
.jg-testimonials .jg-tst-card p{color:rgba(255,255,255,.85)}
.jg-tst-card__author{display:flex;align-items:center;gap:14px;margin-bottom:14px}
.jg-tst-card__author img{width:50px;height:50px;border-radius:50%;object-fit:cover}
.jg-tst-card--light .jg-tst-card__author img{border:2px solid var(--jg-border)}
.jg-testimonials .jg-tst-card__author img{border:2px solid rgba(255,255,255,.3)}
.jg-tst-card__author strong{display:block;font-size:15px}
.jg-tst-card--light .jg-tst-card__author strong{color:var(--jg-dark)}
.jg-testimonials .jg-tst-card__author strong{color:#fff}
.jg-tst-card__author span{font-size:13px}
.jg-tst-card--light .jg-tst-card__author span{color:#888}
.jg-testimonials .jg-tst-card__author span{color:rgba(255,255,255,.55)}
.jg-tst-card__stars .fa-star{color:#ffc107;font-size:13px}

/* ---- Contact info ---- */
.jg-contact__info{display:flex;flex-direction:column;gap:20px}
.jg-contact__info-item{display:flex;align-items:flex-start;gap:14px}
.jg-contact__info-icon{width:44px;height:44px;min-width:44px;border-radius:50%;background:linear-gradient(135deg,#e8f0fd,#c8daf9);color:var(--jg-primary);display:flex;align-items:center;justify-content:center;font-size:16px}
.jg-contact__info-item strong{display:block;font-weight:700;color:var(--jg-dark);font-size:14px;margin-bottom:2px}
.jg-contact__info-item span{font-size:13px;color:#777}
/* Light social icons (contact page, about page) */
.jg-social-light{display:flex;gap:10px;margin-top:4px}
.jg-social-light a{width:36px;height:36px;border-radius:50%;border:1px solid var(--jg-border);color:#aaa;display:flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:.2s}
.jg-social-light a:hover{background:var(--jg-primary);border-color:var(--jg-primary);color:#fff}

/* ---- Dashboard cards ---- */
.jg-dash-card{background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:24px;display:flex;align-items:center;gap:18px;position:relative;transition:.25s;overflow:hidden}
.jg-dash-card:hover{box-shadow:var(--jg-shadow);transform:translateY(-3px)}
.jg-dash-card__link{position:absolute;inset:0;border-radius:var(--jg-radius)}
.jg-dash-card__icon{width:52px;height:52px;min-width:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff}
.jg-dash-card--blue .jg-dash-card__icon{background:linear-gradient(135deg,#0a65cc,#0a9acc)}
.jg-dash-card--green .jg-dash-card__icon{background:linear-gradient(135deg,#14a077,#1abc9c)}
.jg-dash-card--orange .jg-dash-card__icon{background:linear-gradient(135deg,#f39c12,#e67e22)}
.jg-dash-card__info strong{display:block;font-size:16px;font-weight:700;color:var(--jg-dark)}
.jg-dash-card__info span{font-size:13px;color:#888}

/* ---- Profile sidebar ---- */
/* Fix: use align-self:flex-start instead of position:sticky for Bootstrap row compat */
.jg-profile-sidebar{background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:28px 20px;text-align:center;position:sticky;top:80px;align-self:flex-start}
.jg-profile-sidebar__avatar{width:96px;height:96px;border-radius:50%;object-fit:cover;border:3px solid var(--jg-primary);margin-bottom:14px;display:block;margin-left:auto;margin-right:auto}
.jg-profile-sidebar__avatar--square{border-radius:12px}
.jg-profile-sidebar > strong{display:block;font-size:15px;font-weight:700;color:var(--jg-dark)}
.jg-profile-sidebar > span{font-size:12px;color:#aaa;display:block;margin:3px 0 10px}
.jg-profile-sidebar__badge{display:inline-block;padding:4px 14px;border-radius:20px;font-size:11px;font-weight:700;background:#e8f0fd;color:var(--jg-primary);margin-bottom:8px}
.jg-profile-sidebar__badge--green{background:#e8f5e9;color:var(--jg-secondary)}
.jg-profile-sidebar__meta{font-size:12px;color:#888;margin-top:5px}
.jg-profile-sidebar__meta i{color:var(--jg-primary);margin-right:4px}
.jg-profile-sidebar__nav{margin-top:16px;border-top:1px solid var(--jg-border);padding-top:14px;text-align:left}
.jg-profile-sidebar__nav a{display:flex;align-items:center;gap:9px;padding:10px 12px;border-radius:8px;font-size:13px;color:#555;text-decoration:none;transition:.2s;margin-bottom:2px}
.jg-profile-sidebar__nav a:hover,.jg-profile-sidebar__nav a.active{background:#f0f5ff;color:var(--jg-primary);font-weight:600}
.jg-profile-sidebar__nav a i{width:16px;text-align:center;color:#aaa}
.jg-profile-sidebar__nav a:hover i,.jg-profile-sidebar__nav a.active i{color:var(--jg-primary)}
.jg-profile-sidebar__nav a.logout{color:#e53935}
.jg-profile-sidebar__nav a.logout:hover{background:#fef2f2;color:#c0392b}
.jg-profile-sidebar__nav a.logout i{color:#e53935}
/* Make Bootstrap rows support sticky sidebar */
.jg-profile-row{display:flex;align-items:flex-start;flex-wrap:wrap}
.jg-profile-row>[class*="col-"]{float:none}

/* ---- Upload zone ---- */
.jg-upload-zone{border:2px dashed var(--jg-border);border-radius:8px;padding:20px;text-align:center;cursor:pointer;transition:.2s;position:relative;background:#fafbfd}
.jg-upload-zone:hover{border-color:var(--jg-primary);background:#f0f5ff}
.jg-upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.jg-upload-zone i{font-size:24px;color:#ccc;display:block;margin-bottom:8px}
.jg-upload-zone p{margin:0;font-size:13px;color:#aaa}
.jg-upload-zone small{font-size:11px;color:#ccc}
.jg-upload-zone__name{display:none;font-size:12px;color:var(--jg-secondary);margin-top:6px;font-weight:600}

/* ---- CV file display ---- */
.jg-cv-current{background:#f0f5ff;border:1px solid #c8daf9;border-radius:8px;padding:12px 16px;display:flex;align-items:center;gap:12px}
.jg-cv-current i{font-size:20px;color:var(--jg-primary)}
.jg-cv-current strong{display:block;font-size:13px;font-weight:700;color:var(--jg-dark)}
.jg-cv-current span{font-size:12px;color:#aaa}

/* ---- Password eye toggle ---- */
.jg-pw-eye{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer;padding:0;font-size:14px;z-index:2}
.jg-pw-eye:hover{color:var(--jg-primary)}

/* ---- Back link ---- */
.jg-back-link{display:inline-flex;align-items:center;gap:7px;font-size:14px;color:var(--jg-primary);text-decoration:none;font-weight:600;margin-top:4px;transition:gap .2s}
.jg-back-link:hover{gap:10px}

/* ---- Home hero ---- */
.jg-hero{position:relative;background:linear-gradient(135deg,#0a1628 0%,#0a65cc 100%);padding:100px 0 80px;overflow:hidden}
.jg-hero__bg{position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E")}
.jg-hero__row{align-items:center;display:flex;flex-wrap:wrap}
.jg-hero__content{padding:20px 0}
.jg-hero__title{font-size:46px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;letter-spacing:-1px}
.jg-hero__sub{color:rgba(255,255,255,.75);font-size:17px;margin-bottom:36px;line-height:1.6}
.jg-hero__image-col{display:flex;align-items:center;justify-content:center}
.jg-hero__img{max-width:100%;filter:drop-shadow(0 20px 40px rgba(0,0,0,.3));animation:floatImg 4s ease-in-out infinite}
@keyframes floatImg{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
/* Search bar */
.jg-search{background:#fff;border-radius:var(--jg-radius);box-shadow:0 8px 32px rgba(0,0,0,.2);overflow:hidden}
.jg-search__inner{display:flex;align-items:stretch;min-height:56px}
.jg-search__field{display:flex;align-items:center;flex:1;padding:0 18px;border-right:1px solid var(--jg-border)}
.jg-search__field:last-of-type{border-right:none}
.jg-search__icon{color:#aaa;margin-right:10px;font-size:16px;flex-shrink:0}
.jg-search__field input{border:none;outline:none;width:100%;font-size:15px;color:var(--jg-text);background:transparent;height:100%}
.jg-search__btn{background:var(--jg-primary);color:#fff;border:none;padding:0 32px;font-size:15px;font-weight:600;cursor:pointer;transition:.2s;white-space:nowrap;min-height:56px}
.jg-search__btn:hover{background:#084fa3}
/* Search tags — sits below the white card as a secondary strip */
.jg-search__tags{padding:10px 18px;background:rgba(255,255,255,.12);border-top:1px solid rgba(255,255,255,.15);font-size:13px;color:rgba(255,255,255,.7);display:flex;align-items:center;gap:6px;flex-wrap:wrap}
.jg-search__tags span{color:rgba(255,255,255,.5);margin-right:2px}
.jg-search__tags a{color:#fff;text-decoration:none;background:rgba(255,255,255,.15);padding:3px 10px;border-radius:20px;font-size:12px;transition:.2s}
.jg-search__tags a:hover{background:rgba(255,255,255,.3)}
/* How-it-works steps */
.jg-steps{background:#fff;padding:50px 0;border-bottom:1px solid var(--jg-border)}
.jg-step{text-align:center;padding:20px 24px}
.jg-step__icon{position:relative;display:inline-flex;align-items:center;justify-content:center;width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#e8f0fd,#c8daf9);color:var(--jg-primary);font-size:28px;margin-bottom:18px}
.jg-step__num{position:absolute;top:-6px;right:-6px;width:22px;height:22px;border-radius:50%;background:var(--jg-primary);color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center}
.jg-step h4{font-size:17px;font-weight:700;margin-bottom:10px;color:var(--jg-dark)}
.jg-step p{color:#777;font-size:14px;line-height:1.7;margin:0}
/* Category cards */
.jg-cat-card{display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--jg-border);border-radius:var(--jg-radius);padding:18px 20px;margin-bottom:20px;text-decoration:none;color:var(--jg-dark);transition:.25s}
.jg-cat-card:hover{border-color:var(--jg-primary);box-shadow:var(--jg-shadow);transform:translateY(-3px);color:var(--jg-primary)}
.jg-cat-card__icon{width:46px;height:46px;min-width:46px;border-radius:10px;background:linear-gradient(135deg,#e8f0fd,#c8daf9);display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--jg-primary)}
.jg-cat-card h5{margin:0;font-size:14px;font-weight:600;flex:1}
.jg-cat-card__arrow{opacity:0;transition:.2s;color:var(--jg-primary)}
.jg-cat-card:hover .jg-cat-card__arrow{opacity:1}
/* Featured job cards */
.jg-featured-card{background:#fff;border-radius:var(--jg-radius);border:1px solid var(--jg-border);overflow:hidden;height:100%;display:flex;flex-direction:column;transition:.25s}
.jg-featured-card:hover{box-shadow:var(--jg-shadow);transform:translateY(-5px)}
.jg-featured-card__badge{background:var(--jg-primary);color:#fff;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:5px 14px;display:inline-block}
.jg-featured-card__top{height:160px;overflow:hidden;background:var(--jg-gray);display:flex;align-items:center;justify-content:center}
.jg-featured-card__placeholder{height:160px;display:flex;align-items:center;justify-content:center;font-size:48px;color:#c5d5e8;width:100%}
.jg-featured-card__body{padding:18px 20px;flex:1}
.jg-featured-card__body h4{font-size:16px;font-weight:700;margin:0 0 12px}
.jg-featured-card__body h4 a{color:var(--jg-dark);text-decoration:none}
.jg-featured-card__body h4 a:hover{color:var(--jg-primary)}
.jg-featured-card__meta{list-style:none;padding:0;margin:0 0 12px;display:flex;flex-wrap:wrap;gap:10px;font-size:13px;color:#666}
.jg-featured-card__meta li{display:flex;align-items:center;gap:5px}
.jg-featured-card__body p{font-size:13px;color:#888;line-height:1.6;margin:0}
.jg-featured-card__footer{padding:14px 20px;border-top:1px solid var(--jg-border);display:flex;gap:10px;flex-wrap:wrap}
/* Home testimonials dark section */
.jg-testimonials{background:linear-gradient(135deg,#0a1628,#0d3060);padding:80px 0;position:relative;overflow:hidden}
.jg-testimonials .jg-section__title{color:#fff}

/* ---- Responsive ---- */
@media(max-width:991px){
  .jg-about__content{padding-left:0;padding-top:30px}
  .jg-cta__action{justify-content:flex-start;margin-top:20px}
}
@media(max-width:767px){
  body{padding-top:70px}
  .jg-hero{padding:60px 0 50px}
  .jg-hero__title{font-size:28px}
  .jg-search__inner{flex-direction:column;min-height:auto}
  .jg-search__field{border-right:none;border-bottom:1px solid var(--jg-border);min-height:50px}
  .jg-search__btn{width:100%;padding:14px;min-height:48px}
  .jg-filter-box__row{flex-direction:column}
  .jg-filter-field{min-width:100%;width:100%}
  .jg-job-card{flex-wrap:wrap}
  .jg-job-card__actions{flex-direction:row;width:100%;justify-content:flex-start}
  .jg-detail-header{flex-direction:column}
  .jg-detail-header__logo{width:70px;height:70px;min-width:70px}
  .jg-page-hero h1{font-size:24px}
  .jg-profile-sidebar{margin-bottom:24px;position:static}
  .jg-section__title{font-size:24px}
  .jg-footer__col{margin-bottom:28px}
  .jg-footer__bottom .text-right{text-align:left;margin-top:8px}
  .jg-footer__bottom a:first-child{margin-left:0}
}
</style>
</body>
</html>
