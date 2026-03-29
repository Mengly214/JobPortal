<?php
$seeker      = $seeker      ?? [];
$appliedJobs = $appliedJobs ?? [];
?>
<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero" style="background:linear-gradient(135deg,rgba(10,22,40,.90),rgba(20,160,119,.80)),url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1400&q=60&fit=crop') center/cover no-repeat;margin-top:-70px;padding-top:140px;padding-bottom:50px">
    <div class="container" style="position:relative;z-index:2">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/employer/applications">Applications</a>
            <i class="fa fa-angle-right"></i>
            <span>Applicant Profile</span>
        </div>
        <h1 class="jg-page-hero__title">Applicant Profile</h1>
        <p style="color:rgba(255,255,255,.72);margin:0;font-size:16px">Reviewing candidate details and application history</p>
    </div>
</div>

<section style="padding:36px 0 70px;background:#f5f7fb;min-height:500px">
<div class="container">
<div class="row">

    <!-- LEFT: Profile Card -->
    <div class="col-md-4">

        <div class="sp-card">
            <!-- Avatar -->
            <div class="sp-avatar-wrap">
                <?php
                $avatarSrc = !empty($seeker['avatar'])
                    ? SITE_URL.'/uploads/avatars/'.htmlspecialchars($seeker['avatar'])
                    : 'https://ui-avatars.com/api/?name='.urlencode($seeker['full_name'] ?? $seeker['email']).'&size=120&background=0a65cc&color=fff&bold=true';
                ?>
                <img src="<?= $avatarSrc ?>" alt="" class="sp-avatar">
            </div>

            <div class="sp-name"><?= htmlspecialchars($seeker['full_name'] ?? 'Applicant') ?></div>
            <div class="sp-email"><i class="fa fa-envelope-o"></i> <?= htmlspecialchars($seeker['email']) ?></div>

            <?php if (!empty($seeker['location_city'])): ?>
            <div class="sp-meta"><i class="fa fa-map-marker"></i> <?= htmlspecialchars($seeker['location_city']) ?></div>
            <?php endif; ?>

            <div class="sp-meta"><i class="fa fa-calendar"></i> Member since <?= date('M Y', strtotime($seeker['created_at'])) ?></div>

            <div class="sp-divider"></div>

            <!-- CV Download -->
            <?php if (!empty($seeker['cv_file'])): ?>
            <a href="<?= SITE_URL ?>/uploads/resumes/<?= htmlspecialchars($seeker['cv_file']) ?>" download class="sp-btn sp-btn--primary">
                <i class="fa fa-download"></i> Download CV / Resume
            </a>
            <?php else: ?>
            <div class="sp-no-cv"><i class="fa fa-file-o"></i> No CV uploaded</div>
            <?php endif; ?>

            <a href="<?= SITE_URL ?>/employer/applications" class="sp-btn sp-btn--outline" style="margin-top:8px">
                <i class="fa fa-arrow-left"></i> Back to Applications
            </a>
        </div>

        <!-- Applications to my jobs -->
        <?php if (!empty($appliedJobs)): ?>
        <div class="sp-card" style="margin-top:16px">
            <h5 class="sp-section-title"><i class="fa fa-briefcase"></i> Applied to My Jobs</h5>
            <div style="display:flex;flex-direction:column;gap:10px">
                <?php foreach ($appliedJobs as $aj):
                    $sc = [
                        'submitted'   => ['pill-blue',   'Received'],
                        'reviewing'   => ['pill-purple',  'In Review'],
                        'shortlisted' => ['pill-orange',  'Shortlisted'],
                        'interview'   => ['pill-orange',  'Interview'],
                        'offered'     => ['pill-teal',    'Offered'],
                        'hired'       => ['pill-green',   'Hired'],
                        'rejected'    => ['pill-red',     'Rejected'],
                        'withdrawn'   => ['pill-gray',    'Withdrawn'],
                    ];
                    [$cls, $lbl] = $sc[$aj['status']] ?? ['pill-gray','Unknown'];
                ?>
                <div class="sp-app-row">
                    <div>
                        <strong style="font-size:13px;color:#1a1a2e"><?= htmlspecialchars($aj['job_title']) ?></strong>
                        <div style="font-size:11px;color:#94a3b8;margin-top:2px">
                            <i class="fa fa-calendar"></i> <?= date('d M Y', strtotime($aj['applied_at'])) ?>
                        </div>
                    </div>
                    <span class="status-pill <?= $cls ?>"><?= $lbl ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <!-- RIGHT: Details -->
    <div class="col-md-8">

        <!-- Bio -->
        <?php if (!empty($seeker['bio'])): ?>
        <div class="sp-detail-card">
            <h5 class="sp-section-title"><i class="fa fa-user-o"></i> About</h5>
            <p class="sp-body-text"><?= nl2br(htmlspecialchars($seeker['bio'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Skills -->
        <?php if (!empty($seeker['skills'])): ?>
        <div class="sp-detail-card">
            <h5 class="sp-section-title"><i class="fa fa-code"></i> Skills</h5>
            <div class="sp-skills">
                <?php foreach (array_filter(array_map('trim', explode(',', $seeker['skills']))) as $sk): ?>
                <span class="sp-skill"><?= htmlspecialchars($sk) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Experience -->
        <?php if (!empty($seeker['experience'])): ?>
        <div class="sp-detail-card">
            <h5 class="sp-section-title"><i class="fa fa-suitcase"></i> Work Experience</h5>
            <p class="sp-body-text"><?= nl2br(htmlspecialchars($seeker['experience'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Education -->
        <?php if (!empty($seeker['education'])): ?>
        <div class="sp-detail-card">
            <h5 class="sp-section-title"><i class="fa fa-graduation-cap"></i> Education</h5>
            <p class="sp-body-text"><?= nl2br(htmlspecialchars($seeker['education'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if (empty($seeker['bio']) && empty($seeker['skills']) && empty($seeker['experience']) && empty($seeker['education'])): ?>
        <div class="sp-empty">
            <i class="fa fa-user-o"></i>
            <p>This applicant hasn't filled in their profile details yet.</p>
            <small>You can still download their CV if available.</small>
        </div>
        <?php endif; ?>

    </div>
</div>
</div>
</section>

<style>
.jg-page-hero__title{font-size:32px;font-weight:800;color:#fff;margin:0 0 8px;letter-spacing:-.5px}
.jg-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.55);margin-bottom:12px}
.jg-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb i{font-size:10px}.jg-breadcrumb span{color:rgba(255,255,255,.85)}

.sp-card{background:#fff;border-radius:14px;border:1.5px solid #e8edf5;padding:28px 24px;box-shadow:0 2px 12px rgba(10,50,120,.05);text-align:center}
.sp-avatar-wrap{margin-bottom:16px}
.sp-avatar{width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #0a65cc;box-shadow:0 4px 16px rgba(10,101,204,.2)}
.sp-name{font-size:20px;font-weight:800;color:#1a1a2e;margin-bottom:6px}
.sp-email{font-size:13px;color:#64748b;margin-bottom:6px;display:flex;align-items:center;justify-content:center;gap:6px}
.sp-meta{font-size:13px;color:#64748b;margin-bottom:4px;display:flex;align-items:center;justify-content:center;gap:6px}
.sp-divider{border-top:1px solid #f0f4f9;margin:18px 0}
.sp-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px 20px;border-radius:9px;font-size:13px;font-weight:700;text-decoration:none;transition:.2s;border:2px solid transparent}
.sp-btn--primary{background:#0a65cc;color:#fff;border-color:#0a65cc}.sp-btn--primary:hover{background:#084fa3;color:#fff}
.sp-btn--outline{background:#fff;color:#0a65cc;border-color:#0a65cc}.sp-btn--outline:hover{background:#f0f5ff;color:#0a65cc}
.sp-no-cv{font-size:13px;color:#aaa;padding:10px;background:#fafbfd;border-radius:8px;border:1.5px dashed #e8edf5}
.sp-section-title{font-size:14px;font-weight:700;color:#1a1a2e;margin:0 0 14px;padding-bottom:10px;border-bottom:1px solid #f0f4f9;display:flex;align-items:center;gap:8px;text-align:left}
.sp-section-title i{color:#0a65cc}
.sp-detail-card{background:#fff;border-radius:14px;border:1.5px solid #e8edf5;padding:22px 24px;margin-bottom:16px;box-shadow:0 2px 12px rgba(10,50,120,.04)}
.sp-body-text{font-size:14px;color:#475569;line-height:1.75;margin:0;white-space:pre-line}
.sp-skills{display:flex;flex-wrap:wrap;gap:8px}
.sp-skill{background:#f0f5ff;color:#0a65cc;font-size:12px;font-weight:700;padding:5px 14px;border-radius:20px;border:1px solid #c8daf9}
.sp-app-row{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:8px 0;border-bottom:1px solid #f0f4f9}
.sp-app-row:last-child{border-bottom:none}
.sp-empty{text-align:center;padding:60px 20px;color:#aaa;background:#fff;border-radius:14px;border:1.5px dashed #e8edf5}
.sp-empty i{font-size:48px;color:#c5d5e8;display:block;margin-bottom:14px}
.sp-empty p{margin:0 0 6px;font-size:15px;color:#888}
.sp-empty small{font-size:12px}
.status-pill{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap}
.pill-green{background:#e8f5e9;color:#2e7d32}.pill-blue{background:#e8f0fe;color:#0a65cc}
.pill-purple{background:#f3e5f5;color:#6a1b9a}.pill-teal{background:#e0f7f0;color:#0d7a57}
.pill-orange{background:#fff3e0;color:#e65100}.pill-red{background:#fef2f2;color:#e53935}
.pill-gray{background:#f1f5f9;color:#64748b}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
