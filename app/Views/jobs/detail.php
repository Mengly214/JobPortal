<?php
require BASE_PATH . '/app/Views/layouts/header.php';

// Determine apply state
$userId       = isLoggedIn() ? (int)$_SESSION['user_id'] : 0;
$isSeeker     = isLoggedIn() && userRole() === 'job_seeker';
$alreadyApplied = isset($alreadyApplied) ? $alreadyApplied : false;
if ($isSeeker && !$alreadyApplied) {
    require_once BASE_PATH . '/app/Models/Application.php';
    $alreadyApplied = (new Application())->alreadyApplied($job['id'], $userId);
}
$seeker = $seeker ?? null;
if ($isSeeker && !$seeker) {
    require_once BASE_PATH . '/app/Models/User.php';
    $seeker = (new User())->findById($userId);
}
$hasExistingCv = !empty($seeker['cv_file']);
?>

<!-- PAGE HERO -->
<div class="jg-page-hero jg-page-hero--detail">
    <div class="jg-page-hero__photo"></div>
    <div class="jg-page-hero__overlay"></div>
    <div class="container jg-page-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/jobs">Jobs</a>
            <i class="fa fa-angle-right"></i>
            <span><?= clean($job['title']) ?></span>
        </div>
        <h1 class="jg-page-hero__title"><?= clean($job['title']) ?></h1>
        <?php if (!empty($job['company_name'])): ?>
        <p class="jg-page-hero__sub">
            <i class="fa fa-building-o"></i> <?= clean($job['company_name']) ?>
            &ensp;·&ensp;
            <i class="fa fa-map-marker"></i> <?= clean($job['location_city'] ?? 'Remote') ?>
            &ensp;·&ensp;
            <i class="fa fa-clock-o"></i> <?= ucfirst(str_replace('_', ' ', $job['job_type'])) ?>
        </p>
        <?php endif; ?>
    </div>
</div>

<!-- MAIN LAYOUT -->
<section class="jg-detail-section">
<div class="container">
<div class="row">

    <!-- LEFT COLUMN -->
    <div class="col-md-8">

        <!-- Job Header Card -->
        <div class="jg-card jg-card--header js-reveal">
            <div class="jg-card-header__logo">
                <?php if (!empty($job['job_image'])): ?>
                    <img src="<?= SITE_URL . '/uploads/jobs/' . clean($job['job_image']) ?>" alt="">
                <?php elseif (!empty($job['logo'])): ?>
                    <img src="<?= SITE_URL . '/uploads/logos/' . clean($job['logo']) ?>" alt="">
                <?php else: ?>
                    <span class="jg-card-header__initial">
                        <?= strtoupper(substr($job['company_name'] ?? $job['title'], 0, 1)) ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="jg-card-header__info">
                <?php if ($job['is_featured']): ?>
                <span class="jg-featured-pill"><i class="fa fa-star"></i> Featured</span>
                <?php endif; ?>
                <h2><?= clean($job['title']) ?></h2>
                <?php if (!empty($job['company_name'])): ?>
                <p class="jg-card-header__company">
                    <i class="fa fa-building-o"></i> <?= clean($job['company_name']) ?>
                </p>
                <?php endif; ?>
                <div class="jg-meta-row">
                    <span class="jg-meta-chip"><i class="fa fa-map-marker"></i> <?= clean($job['location_city'] ?? 'Remote') ?></span>
                    <span class="jg-meta-chip"><i class="fa fa-clock-o"></i> <?= ucfirst(str_replace('_', ' ', $job['job_type'])) ?></span>
                    <span class="jg-meta-chip"><i class="fa fa-laptop"></i> <?= ucfirst(str_replace('_', ' ', $job['work_mode'])) ?></span>
                    <?php if (!empty($job['salary_visible']) && !empty($job['salary_min'])): ?>
                    <span class="jg-meta-chip jg-meta-chip--green">
                        <i class="fa fa-money"></i>
                        $<?= number_format($job['salary_min']) ?><?php if (!empty($job['salary_max'])): ?>–$<?= number_format($job['salary_max']) ?><?php endif; ?>
                        / <?= $job['salary_period'] ?? 'year' ?>
                    </span>
                    <?php endif; ?>
                    <span class="jg-meta-chip"><i class="fa fa-eye"></i> <?= number_format($job['views'] ?? 0) ?> views</span>
                </div>
                <?php if (!empty($skills)): ?>
                <div class="jg-skills">
                    <?php foreach ($skills as $s): ?>
                    <span class="jg-skill <?= $s['is_required'] ? 'jg-skill--required' : '' ?>">
                        <?= clean($s['name']) ?>
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
            <div class="jg-prose"><?= nl2br(clean($job['description'])) ?></div>

            <?php if (!empty($job['requirements'])): ?>
            <div class="jg-card__section-title" style="margin-top:32px">
                <div class="jg-card__section-icon jg-card__section-icon--amber"><i class="fa fa-list-ul"></i></div>
                Requirements
            </div>
            <div class="jg-prose"><?= nl2br(clean($job['requirements'])) ?></div>
            <?php endif; ?>

            <?php if (!empty($job['benefits'])): ?>
            <div class="jg-card__section-title" style="margin-top:32px">
                <div class="jg-card__section-icon jg-card__section-icon--green"><i class="fa fa-gift"></i></div>
                Benefits
            </div>
            <div class="jg-prose"><?= nl2br(clean($job['benefits'])) ?></div>
            <?php endif; ?>
        </div>

        <a href="<?= SITE_URL ?>/jobs" class="jg-back-link">
            <i class="fa fa-arrow-left"></i> Back to Jobs
        </a>
    </div>

    <!-- SIDEBAR -->
    <div class="col-md-4">
        <div class="jg-sidebar-sticky">

            <!-- Apply CTA Card -->
            <div class="jg-card jg-card--sidebar js-reveal" data-reveal-delay="80">
                <div class="jg-card__section-title">
                    <div class="jg-card__section-icon jg-card__section-icon--blue"><i class="fa fa-paper-plane"></i></div>
                    Apply for this Job
                </div>

                <?php if ($alreadyApplied || ($appSuccess ?? '') === 'success'): ?>
                <!-- Already applied state -->
                <div class="jg-applied-state">
                    <div class="jg-applied-state__icon"><i class="fa fa-check-circle"></i></div>
                    <div class="jg-applied-state__title">Application Submitted!</div>
                    <div class="jg-applied-state__msg">You have already applied for this position. Track your status in your dashboard.</div>
                    <a href="<?= SITE_URL ?>/seeker/applications" class="jg-btn jg-btn--outline jg-btn--full" style="margin-top:14px">
                        <i class="fa fa-tasks"></i> View My Applications
                    </a>
                </div>

                <?php elseif (!$isSeeker): ?>
                <!-- Not logged in / not a seeker -->
                <div style="text-align:center;padding:8px 0 4px">
                    <p style="font-size:14px;color:#64748b;margin-bottom:16px">
                        <?= isLoggedIn() ? 'Only job seekers can apply for positions.' : 'Create a free account to apply for this job.' ?>
                    </p>
                    <?php if (!isLoggedIn()): ?>
                    <a href="<?= SITE_URL ?>/login" class="jg-btn jg-btn--primary jg-btn--full">
                        <i class="fa fa-sign-in"></i> Login to Apply
                    </a>
                    <a href="<?= SITE_URL ?>/register?role=job_seeker" class="jg-btn jg-btn--outline jg-btn--full" style="margin-top:10px">
                        <i class="fa fa-user-plus"></i> Create Free Account
                    </a>
                    <?php endif; ?>
                </div>

                <?php else: ?>
                <!-- Apply button — opens modal -->
                <button type="button" id="openApplyModal" class="jg-btn jg-btn--primary jg-btn--full jg-btn--apply-trigger">
                    <i class="fa fa-paper-plane"></i> Apply Now
                </button>
                <p style="font-size:12px;color:#94a3b8;text-align:center;margin-top:10px">
                    Takes less than 2 minutes
                </p>
                <?php endif; ?>
            </div>

            <!-- Job Overview -->
            <div class="jg-card jg-card--sidebar js-reveal" data-reveal-delay="120">
                <div class="jg-card__section-title">
                    <div class="jg-card__section-icon"><i class="fa fa-info-circle"></i></div>
                    Job Overview
                </div>
                <ul class="jg-overview-list">
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-calendar"></i></div>
                        <div><small>Posted</small><strong><?= date('d M Y', strtotime($job['created_at'])) ?></strong></div>
                    </li>
                    <?php if (!empty($job['application_deadline'])): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--red"><i class="fa fa-hourglass-end"></i></div>
                        <div><small>Deadline</small><strong><?= date('d M Y', strtotime($job['application_deadline'])) ?></strong></div>
                    </li>
                    <?php endif; ?>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-briefcase"></i></div>
                        <div><small>Job Type</small><strong><?= ucfirst(str_replace('_', ' ', $job['job_type'])) ?></strong></div>
                    </li>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-laptop"></i></div>
                        <div><small>Work Mode</small><strong><?= ucfirst(str_replace('_', ' ', $job['work_mode'])) ?></strong></div>
                    </li>
                    <?php if (!empty($job['experience_level'])): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--amber"><i class="fa fa-star"></i></div>
                        <div><small>Experience</small><strong><?= ucfirst(str_replace('_', ' ', $job['experience_level'])) ?></strong></div>
                    </li>
                    <?php endif; ?>
                    <?php if (!empty($job['salary_visible']) && !empty($job['salary_min'])): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--green"><i class="fa fa-money"></i></div>
                        <div>
                            <small>Salary</small>
                            <strong>$<?= number_format($job['salary_min']) ?><?php if (!empty($job['salary_max'])): ?>–$<?= number_format($job['salary_max']) ?><?php endif; ?></strong>
                        </div>
                    </li>
                    <?php endif; ?>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-map-marker"></i></div>
                        <div>
                            <small>Location</small>
                            <strong>
                                <?= clean($job['location_city'] ?? 'Remote') ?>
                                <?php if (!empty($job['location_country'])): ?>, <?= clean($job['location_country']) ?><?php endif; ?>
                            </strong>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Company Info -->
            <div class="jg-card jg-card--sidebar js-reveal" data-reveal-delay="160">
                <div class="jg-card__section-title">
                    <div class="jg-card__section-icon"><i class="fa fa-building"></i></div>
                    About <?= clean($job['company_name'] ?? 'the Company') ?>
                </div>
                <?php if (!empty($job['company_desc'])): ?>
                <p class="jg-company-desc"><?= clean(substr($job['company_desc'], 0, 200)) ?>...</p>
                <?php endif; ?>
                <ul class="jg-company-stats">
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-industry"></i></div>
                        <div><small>Industry</small><strong><?= clean($job['industry'] ?? '–') ?></strong></div>
                    </li>
                    <li>
                        <div class="jg-overview-list__icon"><i class="fa fa-users"></i></div>
                        <div><small>Company Size</small><strong><?= clean($job['company_size'] ?? '–') ?></strong></div>
                    </li>
                    <?php if (!empty($job['website'])): ?>
                    <li>
                        <div class="jg-overview-list__icon jg-overview-list__icon--blue"><i class="fa fa-globe"></i></div>
                        <div>
                            <small>Website</small>
                            <strong>
                                <a href="<?= clean($job['website']) ?>" target="_blank" rel="noopener" class="jg-link">
                                    <?= clean($job['website']) ?>
                                </a>
                            </strong>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

</div>
</div>
</section>

<!-- ======================================================
     APPLY MODAL
====================================================== -->
<?php if ($isSeeker && !$alreadyApplied): ?>
<div id="applyModal" class="am-overlay" role="dialog" aria-modal="true" aria-labelledby="amTitle">
    <div class="am-box">

        <!-- Step 1: Confirm -->
        <div class="am-step" id="amStep1">
            <div class="am-header">
                <div class="am-header__icon"><i class="fa fa-paper-plane"></i></div>
                <div>
                    <div class="am-header__title" id="amTitle">Apply for this Position</div>
                    <div class="am-header__sub"><?= clean($job['title']) ?> · <?= clean($job['company_name'] ?? '') ?></div>
                </div>
                <button type="button" class="am-close" onclick="closeModal()" aria-label="Close">&times;</button>
            </div>

            <!-- Seeker info preview -->
            <div class="am-applicant-row">
                <?php
                $avatarSrc = !empty($seeker['avatar'])
                    ? SITE_URL . '/uploads/avatars/' . clean($seeker['avatar'])
                    : 'https://ui-avatars.com/api/?name=' . urlencode($seeker['full_name'] ?? $seeker['email']) . '&size=64&background=0a65cc&color=fff&bold=true';
                ?>
                <img src="<?= $avatarSrc ?>" class="am-applicant-row__avatar" alt="">
                <div>
                    <div class="am-applicant-row__name"><?= clean($seeker['full_name'] ?? 'You') ?></div>
                    <div class="am-applicant-row__email"><?= clean($seeker['email'] ?? '') ?></div>
                </div>
            </div>

            <button type="button" class="jg-btn jg-btn--primary jg-btn--full" onclick="goToStep(2)" style="margin-top:8px">
                <i class="fa fa-arrow-right"></i> Continue to Application
            </button>
            <button type="button" class="jg-btn jg-btn--ghost jg-btn--full" onclick="closeModal()" style="margin-top:10px">
                Cancel
            </button>
        </div>

        <!-- Step 2: Fill form -->
        <div class="am-step" id="amStep2" style="display:none">
            <div class="am-header">
                <button type="button" class="am-back" onclick="goToStep(1)"><i class="fa fa-arrow-left"></i></button>
                <div>
                    <div class="am-header__title">Your Application</div>
                    <div class="am-header__sub">Step 2 of 2</div>
                </div>
                <button type="button" class="am-close" onclick="closeModal()" aria-label="Close">&times;</button>
            </div>

            <form id="applyForm" action="<?= SITE_URL ?>/jobs/<?= $job['id'] ?>/apply" method="POST" enctype="multipart/form-data">

                <!-- Cover letter -->
                <div class="am-field">
                    <label class="am-label">
                        Cover Letter <span class="am-optional">optional</span>
                    </label>
                    <textarea name="cover_letter" class="am-textarea" rows="5"
                              placeholder="Tell the employer why you're the right fit for this role..."></textarea>
                </div>

                <!-- CV / Resume -->
                <div class="am-field">
                    <label class="am-label">CV / Resume</label>

                    <?php if ($hasExistingCv): ?>
                    <!-- Toggle: use existing or upload new -->
                    <div class="am-cv-toggle">
                        <label class="am-cv-option" id="optExisting">
                            <input type="radio" name="cv_choice" value="existing" checked onchange="toggleCvUpload(false)">
                            <div class="am-cv-option__box">
                                <i class="fa fa-file-pdf-o"></i>
                                <div>
                                    <strong>Use existing CV</strong>
                                    <span><?= clean($seeker['cv_file']) ?></span>
                                </div>
                                <div class="am-cv-option__check"><i class="fa fa-check-circle"></i></div>
                            </div>
                        </label>
                        <label class="am-cv-option" id="optNew">
                            <input type="radio" name="cv_choice" value="new" onchange="toggleCvUpload(true)">
                            <div class="am-cv-option__box">
                                <i class="fa fa-upload"></i>
                                <div>
                                    <strong>Upload a new CV</strong>
                                    <span>PDF or Word, max 5MB</span>
                                </div>
                                <div class="am-cv-option__check"><i class="fa fa-check-circle"></i></div>
                            </div>
                        </label>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="cv_choice" value="new">
                    <?php endif; ?>

                    <!-- File upload zone (hidden if existing is selected) -->
                    <div id="cvUploadZone" class="am-upload-zone" <?= $hasExistingCv ? 'style="display:none"' : '' ?>>
                        <input type="file" name="cv_file" id="cvFileInput" accept=".pdf,.doc,.docx"
                               onchange="previewCvFile(this)">
                        <i class="fa fa-cloud-upload am-upload-zone__icon"></i>
                        <div class="am-upload-zone__text">Click or drag your CV here</div>
                        <div class="am-upload-zone__hint">PDF or Word document · Max 5MB</div>
                        <div id="cvFileName" class="am-upload-zone__file" style="display:none">
                            <i class="fa fa-file-pdf-o"></i>
                            <span id="cvFileNameText"></span>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="am-field">
                    <label class="am-label">
                        Phone Number
                        <span class="am-optional">optional — so the employer can reach you</span>
                    </label>
                    <div class="am-input-wrap">
                        <i class="fa fa-phone am-input-icon"></i>
                        <input type="tel" name="phone" class="am-input"
                               placeholder="+855 012 345 678"
                               value="<?= clean($seeker['phone'] ?? '') ?>">
                    </div>
                </div>

                <!-- Error message -->
                <div id="amError" class="am-alert am-alert--danger" style="display:none"></div>

                <!-- Submit -->
                <button type="submit" id="amSubmitBtn" class="jg-btn jg-btn--primary jg-btn--full jg-btn--submit">
                    <i class="fa fa-paper-plane"></i> Submit Application
                </button>

                <p class="am-footer-note">
                    <i class="fa fa-lock"></i> Your information is only shared with <?= clean($job['company_name'] ?? 'the employer') ?>
                </p>
            </form>
        </div>

        <!-- Step 3: Success -->
        <div class="am-step" id="amStep3" style="display:none">
            <button type="button" class="am-close am-close--abs" onclick="closeModal()" aria-label="Close">&times;</button>
            <div class="am-success">
                <div class="am-success__ring">
                    <div class="am-success__check"><i class="fa fa-check"></i></div>
                </div>
                <h3 class="am-success__title">Application Submitted! 🎉</h3>
                <p class="am-success__msg">
                    Your application for <strong><?= clean($job['title']) ?></strong> at
                    <strong><?= clean($job['company_name'] ?? '') ?></strong> has been sent successfully.
                </p>
                <div class="am-success__flow">
                    <div class="am-flow-step am-flow-step--done">
                        <div class="am-flow-step__dot"><i class="fa fa-check"></i></div>
                        <span>Submitted</span>
                    </div>
                    <div class="am-flow-step__line"></div>
                    <div class="am-flow-step am-flow-step--next">
                        <div class="am-flow-step__dot"><i class="fa fa-search"></i></div>
                        <span>Under Review</span>
                    </div>
                    <div class="am-flow-step__line"></div>
                    <div class="am-flow-step">
                        <div class="am-flow-step__dot"><i class="fa fa-calendar"></i></div>
                        <span>Interview</span>
                    </div>
                    <div class="am-flow-step__line"></div>
                    <div class="am-flow-step">
                        <div class="am-flow-step__dot"><i class="fa fa-trophy"></i></div>
                        <span>Hired</span>
                    </div>
                </div>
                <a href="<?= SITE_URL ?>/seeker/applications" class="jg-btn jg-btn--primary jg-btn--full">
                    <i class="fa fa-tasks"></i> Track My Application
                </a>
                <button type="button" class="jg-btn jg-btn--ghost jg-btn--full" onclick="closeModal()" style="margin-top:10px">
                    Stay on this page
                </button>
            </div>
        </div>

    </div>
</div>
<?php endif; ?>

<!-- ======================================================
     STYLES
====================================================== -->
<style>
/* ─── PAGE HERO ─────────────────────────────────────────── */
.jg-page-hero{position:relative;margin-top:-70px;padding-top:150px;padding-bottom:56px;overflow:hidden;min-height:300px;display:flex;align-items:flex-end}
.jg-page-hero__photo{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1600&q=60&fit=crop&crop=top') center/cover no-repeat;transform:scale(1.03)}
.jg-page-hero__overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(5,14,30,.90) 0%,rgba(10,60,130,.82) 60%,rgba(5,14,30,.70) 100%)}
.jg-page-hero__inner{position:relative;z-index:2}
.jg-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.50);margin-bottom:14px}
.jg-breadcrumb a{color:rgba(255,255,255,.60);text-decoration:none}
.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb span{color:rgba(255,255,255,.85);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:260px}
.jg-breadcrumb i{font-size:11px;flex-shrink:0}
.jg-page-hero__title{font-size:36px;font-weight:800;color:#fff;letter-spacing:-1px;margin:0 0 12px;line-height:1.15;animation:pgIn .65s .1s cubic-bezier(.22,1,.36,1) both}
.jg-page-hero__sub{font-size:15px;color:rgba(255,255,255,.65);margin:0;display:flex;align-items:center;flex-wrap:wrap;gap:6px;animation:pgIn .65s .22s cubic-bezier(.22,1,.36,1) both}
.jg-page-hero__sub i{color:rgba(255,255,255,.45)}
@keyframes pgIn{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}

/* ─── LAYOUT ─────────────────────────────────────────────── */
.jg-detail-section{padding:40px 0 80px;background:#f5f7fb}

/* ─── CARDS ──────────────────────────────────────────────── */
.jg-card{background:#fff;border:1.5px solid #e8edf5;border-radius:16px;padding:28px 30px;margin-bottom:22px;transition:box-shadow .25s}
.jg-card:hover{box-shadow:0 4px 24px rgba(10,60,130,.07)}
.jg-card--sidebar{padding:24px 22px}
.jg-card__section-title{display:flex;align-items:center;gap:12px;font-size:17px;font-weight:700;color:#1a1a2e;margin-bottom:22px}
.jg-card__section-icon{width:34px;height:34px;border-radius:8px;flex-shrink:0;background:#eef3fd;color:#0a65cc;display:flex;align-items:center;justify-content:center;font-size:14px}
.jg-card__section-icon--amber{background:#fef3e2;color:#d68910}
.jg-card__section-icon--green{background:#e8f8f5;color:#148a68}
.jg-card__section-icon--blue{background:#eef3fd;color:#0a65cc}

/* ─── HEADER CARD ────────────────────────────────────────── */
.jg-card--header{display:flex;align-items:flex-start;gap:22px;border-left:4px solid #0a65cc}
.jg-card-header__logo{width:80px;height:80px;flex-shrink:0;border-radius:14px;overflow:hidden;border:1.5px solid #e8edf5;display:flex;align-items:center;justify-content:center;background:#f8fafd}
.jg-card-header__logo img{width:100%;height:100%;object-fit:cover}
.jg-card-header__initial{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;background:linear-gradient(135deg,#0a65cc,#14a077)}
.jg-card-header__info{flex:1;min-width:0}
.jg-card-header__info h2{font-size:22px;font-weight:800;color:#1a1a2e;margin:6px 0 8px}
.jg-card-header__company{font-size:14px;color:#666;margin:0 0 12px;display:flex;align-items:center;gap:6px}
.jg-featured-pill{display:inline-flex;align-items:center;gap:5px;background:linear-gradient(135deg,#0a65cc,#14a077);color:#fff;font-size:11px;font-weight:700;letter-spacing:.5px;padding:3px 10px;border-radius:20px;margin-bottom:4px}
.jg-meta-row{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
.jg-meta-chip{display:inline-flex;align-items:center;gap:5px;background:#f0f5ff;color:#0a65cc;font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;border:1px solid #dce9fb}
.jg-meta-chip--green{background:#e8f8f5;color:#148a68;border-color:#b7e5d8}
.jg-skills{display:flex;flex-wrap:wrap;gap:6px;margin-top:4px}
.jg-skill{display:inline-block;font-size:12px;font-weight:600;background:#f5f7fb;color:#555;border:1px solid #e0e6f0;padding:3px 12px;border-radius:20px;transition:.15s}
.jg-skill--required{background:#fff3e0;color:#d68910;border-color:#fac87a}
.jg-skill:hover{border-color:#0a65cc;color:#0a65cc;background:#f0f5ff}

/* ─── PROSE ──────────────────────────────────────────────── */
.jg-prose{font-size:15px;line-height:1.80;color:#444}

/* ─── APPLIED STATE ──────────────────────────────────────── */
.jg-applied-state{text-align:center;padding:8px 0 4px}
.jg-applied-state__icon{font-size:40px;color:#2e7d32;margin-bottom:10px}
.jg-applied-state__title{font-size:17px;font-weight:700;color:#1a5c1d;margin-bottom:8px}
.jg-applied-state__msg{font-size:13px;color:#555;line-height:1.6}

/* ─── BUTTONS ────────────────────────────────────────────── */
.jg-btn{display:inline-flex;align-items:center;gap:8px;font-weight:700;text-decoration:none;border-radius:10px;border:none;cursor:pointer;transition:.2s;font-size:14px}
.jg-btn--primary{background:#0a65cc;color:#fff;padding:11px 24px}
.jg-btn--primary:hover{background:#084fa3;color:#fff}
.jg-btn--outline{background:transparent;color:#0a65cc;padding:10px 22px;border:2px solid #0a65cc}
.jg-btn--outline:hover{background:#0a65cc;color:#fff}
.jg-btn--ghost{background:#f5f7fb;color:#64748b;padding:10px 22px;border:1.5px solid #e0e6f0}
.jg-btn--ghost:hover{background:#e8edf5;color:#1a1a2e}
.jg-btn--full{width:100%;justify-content:center}
.jg-btn--apply-trigger{padding:14px 24px;font-size:15px;letter-spacing:.3px}

/* ─── OVERVIEW / COMPANY LISTS ───────────────────────────── */
.jg-overview-list,.jg-company-stats{list-style:none;padding:0;margin:0 0 4px;display:flex;flex-direction:column;gap:0}
.jg-overview-list li,.jg-company-stats li{display:flex;align-items:center;gap:14px;padding:11px 0;border-bottom:1px solid #f0f4f8}
.jg-overview-list li:last-child,.jg-company-stats li:last-child{border-bottom:none}
.jg-overview-list__icon{width:32px;height:32px;border-radius:8px;flex-shrink:0;background:#eef3fd;color:#0a65cc;display:flex;align-items:center;justify-content:center;font-size:13px}
.jg-overview-list__icon--red{background:#fdeced;color:#c0392b}
.jg-overview-list__icon--amber{background:#fef3e2;color:#d68910}
.jg-overview-list__icon--green{background:#e8f8f5;color:#148a68}
.jg-overview-list__icon--blue{background:#eef3fd;color:#0a65cc}
.jg-overview-list small{display:block;font-size:11px;color:#aaa;line-height:1;margin-bottom:3px}
.jg-overview-list strong,.jg-company-stats strong{font-size:14px;font-weight:700;color:#1a1a2e;display:block}
.jg-company-desc{font-size:13px;color:#777;line-height:1.7;margin-bottom:14px}
.jg-link{color:#0a65cc;text-decoration:none;word-break:break-all}
.jg-link:hover{text-decoration:underline}

.jg-sidebar-sticky{position:sticky;top:88px}
.jg-back-link{display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:600;color:#666;text-decoration:none;padding:10px 0;margin-bottom:10px;transition:color .2s}
.jg-back-link:hover{color:#0a65cc}

/* ─── REVEAL ─────────────────────────────────────────────── */
.js-reveal{opacity:0;transform:translateY(22px);transition:opacity .6s cubic-bezier(.22,1,.36,1),transform .6s cubic-bezier(.22,1,.36,1)}
.js-reveal.visible{opacity:1;transform:translateY(0)}

/* ─── MODAL OVERLAY ──────────────────────────────────────── */
.am-overlay{position:fixed;inset:0;background:rgba(5,14,30,.65);z-index:9000;display:none;align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(3px)}
.am-overlay.open{display:flex}

/* ─── MODAL BOX ──────────────────────────────────────────── */
.am-box{background:#fff;border-radius:20px;width:100%;max-width:520px;max-height:90vh;overflow-y:auto;box-shadow:0 24px 64px rgba(5,14,30,.22);animation:amIn .35s cubic-bezier(.22,1,.36,1)}
@keyframes amIn{from{opacity:0;transform:translateY(28px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}

/* ─── MODAL HEADER ───────────────────────────────────────── */
.am-header{display:flex;align-items:flex-start;gap:14px;padding:24px 24px 18px;border-bottom:1px solid #f0f4f8}
.am-header__icon{width:42px;height:42px;border-radius:12px;background:#eef3fd;color:#0a65cc;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.am-header__title{font-size:17px;font-weight:700;color:#1a1a2e;line-height:1.2}
.am-header__sub{font-size:13px;color:#94a3b8;margin-top:3px}
.am-close{margin-left:auto;flex-shrink:0;background:none;border:none;font-size:22px;color:#aaa;cursor:pointer;line-height:1;padding:0 2px;transition:color .2s}
.am-close:hover{color:#e53935}
.am-close--abs{position:absolute;top:18px;right:20px}
.am-back{background:none;border:none;color:#0a65cc;font-size:16px;cursor:pointer;padding:0;margin-right:2px;transition:color .2s}
.am-back:hover{color:#084fa3}

/* ─── APPLICANT PREVIEW ROW ──────────────────────────────── */
.am-applicant-row{display:flex;align-items:center;gap:14px;background:#f8fafc;border:1.5px solid #e8edf5;border-radius:12px;padding:14px 18px;margin:20px 24px 0}
.am-applicant-row__avatar{width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid #0a65cc;flex-shrink:0}
.am-applicant-row__name{font-size:14px;font-weight:700;color:#1a1a2e}
.am-applicant-row__email{font-size:12px;color:#94a3b8;margin-top:2px}

/* ─── STEPS CONTENT PADDING ──────────────────────────────── */
#amStep1{padding-bottom:24px}
#amStep1 .jg-btn{margin:0 24px;width:calc(100% - 48px)}

/* ─── FORM FIELDS ────────────────────────────────────────── */
.am-field{padding:0 24px;margin-bottom:18px}
.am-label{display:block;font-size:13px;font-weight:700;color:#1a1a2e;margin-bottom:8px}
.am-optional{font-weight:400;color:#aaa;font-size:11px;margin-left:5px}
.am-textarea{width:100%;border:1.5px solid #e0e6f0;border-radius:10px;padding:12px 14px;font-size:14px;font-family:inherit;resize:vertical;outline:none;transition:.2s;background:#fafbfd;color:#333;min-height:110px}
.am-textarea:focus{border-color:#0a65cc;background:#fff;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
.am-textarea::placeholder{color:#bbb}

/* ─── CV TOGGLE ──────────────────────────────────────────── */
.am-cv-toggle{display:flex;flex-direction:column;gap:8px;margin-bottom:12px}
.am-cv-option input{position:absolute;opacity:0;pointer-events:none}
.am-cv-option__box{display:flex;align-items:center;gap:12px;padding:12px 14px;border:1.5px solid #e0e6f0;border-radius:10px;cursor:pointer;transition:.2s;background:#fafbfd}
.am-cv-option__box:hover{border-color:#0a65cc;background:#f0f6ff}
.am-cv-option input:checked + .am-cv-option__box{border-color:#0a65cc;background:#f0f6ff}
.am-cv-option__box > .fa{font-size:22px;color:#0a65cc;flex-shrink:0}
.am-cv-option__box > div{flex:1;min-width:0}
.am-cv-option__box strong{display:block;font-size:13px;font-weight:700;color:#1a1a2e}
.am-cv-option__box span{display:block;font-size:11px;color:#94a3b8;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.am-cv-option__check{color:#e0e6f0;font-size:18px;flex-shrink:0;transition:color .2s}
.am-cv-option input:checked + .am-cv-option__box .am-cv-option__check{color:#0a65cc}

/* ─── UPLOAD ZONE ────────────────────────────────────────── */
.am-upload-zone{position:relative;border:2px dashed #d0daea;border-radius:10px;padding:22px;text-align:center;background:#fafbfd;cursor:pointer;transition:.2s}
.am-upload-zone:hover{border-color:#0a65cc;background:#f0f6ff}
.am-upload-zone input[type="file"]{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer}
.am-upload-zone__icon{font-size:28px;color:#d0daea;display:block;margin-bottom:6px;transition:color .2s}
.am-upload-zone:hover .am-upload-zone__icon{color:#0a65cc}
.am-upload-zone__text{font-size:14px;font-weight:600;color:#475569}
.am-upload-zone__hint{font-size:12px;color:#aaa;margin-top:3px}
.am-upload-zone__file{display:flex;align-items:center;gap:8px;justify-content:center;margin-top:10px;font-size:13px;font-weight:600;color:#0a65cc}
.am-upload-zone__file .fa{font-size:16px}

/* ─── INPUT WITH ICON ────────────────────────────────────── */
.am-input-wrap{position:relative}
.am-input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#0a65cc;font-size:14px;pointer-events:none}
.am-input{width:100%;border:1.5px solid #e0e6f0;border-radius:10px;padding:11px 14px 11px 38px;font-size:14px;font-family:inherit;outline:none;transition:.2s;background:#fafbfd;color:#333}
.am-input:focus{border-color:#0a65cc;background:#fff;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
.am-input::placeholder{color:#bbb}

/* ─── ALERTS ─────────────────────────────────────────────── */
.am-alert{display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:10px;font-size:13px;font-weight:600;margin:0 24px 16px}
.am-alert--danger{background:#fdeced;color:#c0392b;border:1px solid #f4b8bb}

/* ─── SUBMIT BUTTON ──────────────────────────────────────── */
.jg-btn--submit{margin:8px 24px;width:calc(100% - 48px);padding:14px;font-size:15px;justify-content:center}
.am-footer-note{text-align:center;font-size:12px;color:#aaa;margin:10px 24px 20px;display:flex;align-items:center;justify-content:center;gap:6px}
.am-footer-note i{font-size:11px}

/* ─── SUCCESS STATE ──────────────────────────────────────── */
.am-success{text-align:center;padding:36px 28px 32px}
.am-success__ring{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#e8f8f5,#d4f5e9);border:3px solid #2e7d32;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;animation:successPop .5s cubic-bezier(.22,1,.36,1)}
.am-success__check{font-size:32px;color:#2e7d32}
@keyframes successPop{from{transform:scale(.5);opacity:0}to{transform:scale(1);opacity:1}}
.am-success__title{font-size:22px;font-weight:800;color:#1a1a2e;margin-bottom:10px}
.am-success__msg{font-size:14px;color:#555;line-height:1.7;margin-bottom:24px}
.am-success__msg strong{color:#1a1a2e}

/* ─── FLOW STEPS ─────────────────────────────────────────── */
.am-success__flow{display:flex;align-items:center;justify-content:center;gap:0;margin-bottom:24px;flex-wrap:nowrap}
.am-flow-step{display:flex;flex-direction:column;align-items:center;gap:6px;min-width:60px}
.am-flow-step__dot{width:32px;height:32px;border-radius:50%;background:#e8edf5;color:#aaa;display:flex;align-items:center;justify-content:center;font-size:13px;border:2px solid #e0e6f0}
.am-flow-step span{font-size:10px;font-weight:600;color:#94a3b8;text-align:center;white-space:nowrap}
.am-flow-step--done .am-flow-step__dot{background:#e8f8f5;color:#2e7d32;border-color:#2e7d32}
.am-flow-step--done span{color:#2e7d32}
.am-flow-step--next .am-flow-step__dot{background:#eef3fd;color:#0a65cc;border-color:#0a65cc}
.am-flow-step--next span{color:#0a65cc}
.am-flow-step__line{flex:1;height:2px;background:#e0e6f0;min-width:16px;margin-bottom:18px}

/* ─── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width:991px){.jg-sidebar-sticky{position:static;margin-top:24px}}
@media (max-width:767px){
    .jg-page-hero{padding-top:120px;padding-bottom:36px}
    .jg-page-hero__title{font-size:26px}
    .jg-card--header{flex-wrap:wrap}
    .jg-card-header__logo{width:60px;height:60px}
    .jg-card{padding:20px 18px}
    .am-box{max-height:95vh;border-radius:16px 16px 0 0;margin-top:auto}
    .am-overlay{align-items:flex-end;padding:0}
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
    } else { els.forEach(function(el){ el.classList.add('visible'); }); }

    /* Hero parallax */
    var ph = document.querySelector('.jg-page-hero__photo');
    if (ph) { window.addEventListener('scroll', function(){ ph.style.transform='scale(1.03) translateY('+(window.scrollY*.05)+'px)'; }, { passive:true }); }
})();

/* ── Modal open / close / step nav ─────────────────────── */
function openModal() {
    var m = document.getElementById('applyModal');
    if (!m) return;
    m.classList.add('open');
    document.body.style.overflow = 'hidden';
    goToStep(1);
}
function closeModal() {
    var m = document.getElementById('applyModal');
    if (!m) return;
    m.classList.remove('open');
    document.body.style.overflow = '';
}
function goToStep(n) {
    [1,2,3].forEach(function(i){
        var el = document.getElementById('amStep'+i);
        if (el) el.style.display = (i===n) ? 'block' : 'none';
    });
}

/* Open button */
var openBtn = document.getElementById('openApplyModal');
if (openBtn) { openBtn.addEventListener('click', openModal); }

/* Close on overlay click */
var overlay = document.getElementById('applyModal');
if (overlay) {
    overlay.addEventListener('click', function(e){
        if (e.target === overlay) closeModal();
    });
}

/* Close on Escape */
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeModal();
});

/* CV choice toggle */
function toggleCvUpload(show) {
    var zone = document.getElementById('cvUploadZone');
    if (zone) zone.style.display = show ? 'block' : 'none';
}

/* CV file preview */
function previewCvFile(input) {
    var nameEl  = document.getElementById('cvFileNameText');
    var wrap    = document.getElementById('cvFileName');
    var zone    = document.getElementById('cvUploadZone');
    if (input.files && input.files[0]) {
        var name = input.files[0].name;
        if (nameEl) nameEl.textContent = name;
        if (wrap)   wrap.style.display = 'flex';
        if (zone)   zone.style.borderColor = '#0a65cc';
    }
}

/* AJAX form submit */
var form = document.getElementById('applyForm');
if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn     = document.getElementById('amSubmitBtn');
        var errBox  = document.getElementById('amError');
        if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting...'; }
        if (errBox) errBox.style.display = 'none';

        var fd = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: fd
        })
        .then(function(r){ return r.json(); })
        .then(function(data){
            if (data.success) {
                goToStep(3);
                /* Update the sidebar button to "Applied" */
                var applyBtn = document.getElementById('openApplyModal');
                if (applyBtn) {
                    applyBtn.outerHTML = '<div class="jg-applied-sidebar"><i class="fa fa-check-circle"></i> Applied Successfully</div>';
                }
            } else {
                if (errBox) {
                    errBox.innerHTML = '<i class="fa fa-exclamation-circle"></i> ' + (data.error || 'Something went wrong.');
                    errBox.style.display = 'flex';
                }
                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa fa-paper-plane"></i> Submit Application'; }
            }
        })
        .catch(function(){
            if (errBox) {
                errBox.innerHTML = '<i class="fa fa-exclamation-circle"></i> Connection error. Please try again.';
                errBox.style.display = 'flex';
            }
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fa fa-paper-plane"></i> Submit Application'; }
        });
    });
}

/* Extra style: applied sidebar state */
var st = document.createElement('style');
st.textContent = '.jg-applied-sidebar{display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;background:#e8f8f5;color:#2e7d32;font-weight:700;font-size:14px;border-radius:10px;border:1.5px solid #b7e5d8}';
document.head.appendChild(st);
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>