<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<?php
/* ── Status config ─────────────────────────────────────── */
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
    'submitted'   => ['color'=>'#0d7a57','bg'=>'#f0fdf8','light'=>'#ccf2e5','icon'=>'fa-paper-plane','label'=>'Application Received',
                      'heading'=>'Your application was received!',
                      'message'=>'The employer has received your application and will begin reviewing it soon. Hang tight!',
                      'tip'=>null],
    'reviewing'   => ['color'=>'#0a65cc','bg'=>'#f0f6ff','light'=>'#d4e6fb','icon'=>'fa-search','label'=>'Under Review',
                      'heading'=>'Your application is being reviewed.',
                      'message'=>'The employer is actively looking at your profile. This is a great sign — they are interested!',
                      'tip'=>'Make sure your profile is complete and up to date.'],
    'shortlisted' => ['color'=>'#6c3fc5','bg'=>'#f7f3ff','light'=>'#e4d9fb','icon'=>'fa-star','label'=>'Shortlisted',
                      'heading'=>"You've been shortlisted! ⭐",
                      'message'=>'The employer added you to their shortlist. You are among the top candidates for this role!',
                      'tip'=>'An interview invitation may follow soon. Be ready!'],
    'interview'   => ['color'=>'#b45309','bg'=>'#fffbf0','light'=>'#fde9b8','icon'=>'fa-calendar','label'=>'Interview Scheduled',
                      'heading'=>'Interview Scheduled!',
                      'message'=>'The employer is interested in you! They will contact you via email or phone with the interview details.',
                      'tip'=>'Check your email regularly and keep your phone on. Prepare well!'],
    'offered'     => ['color'=>'#3730a3','bg'=>'#f1f0ff','light'=>'#d4d3f8','icon'=>'fa-envelope-open','label'=>'Offer Received',
                      'heading'=>'You received a job offer! 🎉',
                      'message'=>'Congratulations! The employer has extended an offer to you. Review the details carefully and respond promptly.',
                      'tip'=>'Check your email for the official offer letter.'],
    'hired'       => ['color'=>'#2e7d32','bg'=>'#f0fdf4','light'=>'#bbf7c5','icon'=>'fa-trophy','label'=>'Hired',
                      'heading'=>'Congratulations — you got the job! 🎉',
                      'message'=>'You have been selected for this position. The employer will be in touch with onboarding details soon. Well done!',
                      'tip'=>null],
    'rejected'    => ['color'=>'#e53935','bg'=>'#fff5f5','light'=>'#fcd5d4','icon'=>'fa-times-circle','label'=>'Not Selected',
                      'heading'=>'Application not selected.',
                      'message'=>"Unfortunately, the employer decided to move forward with other candidates. Don't give up — keep applying!",
                      'tip'=>'Every rejection brings you closer to the right opportunity.'],
    'withdrawn'   => ['color'=>'#64748b','bg'=>'#f8fafc','light'=>'#e2e8f0','icon'=>'fa-minus-circle','label'=>'Withdrawn',
                      'heading'=>'You withdrew this application.',
                      'message'=>'You chose to withdraw from this role. You can always explore similar positions.',
                      'tip'=>null],
];

$app     = $application; // passed from controller
$status  = $app['status'] ?? 'submitted';
$cfg     = $statusConfig[$status] ?? $statusConfig['submitted'];

$isTerminal  = in_array($status, ['rejected','withdrawn']);
$currentIdx  = array_search($status, $pipeline);

$deadlineStr = $app['application_deadline'] ?? null;
$deadlineLbl = $deadlineCls = '';
if ($deadlineStr) {
    $daysLeft = (int)(new DateTime())->diff(new DateTime($deadlineStr))->format('%r%a');
    if ($daysLeft < 0)      { $deadlineLbl = 'Expired';           $deadlineCls = 'ast-dl--red'; }
    elseif ($daysLeft <= 7) { $deadlineLbl = $daysLeft.'d left';  $deadlineCls = 'ast-dl--red'; }
    else                    { $deadlineLbl = $daysLeft.'d left';  $deadlineCls = 'ast-dl--green'; }
}
?>

<!-- ── Page hero ─────────────────────────────────────────── -->
<div class="ast-hero" style="--status-color:<?= $cfg['color'] ?>">
    <div class="ast-hero__overlay"></div>
    <div class="container ast-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/seeker/applications">My Applications</a>
            <i class="fa fa-angle-right"></i>
            <span><?= htmlspecialchars($app['job_title']) ?></span>
        </div>
        <div class="ast-hero__content">
            <div class="ast-hero__logo">
                <?php if (!empty($app['company_logo'])): ?>
                    <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($app['company_logo']) ?>" alt="">
                <?php else: ?>
                    <div class="ast-hero__logo-initial"><?= strtoupper(substr($app['company_name'] ?? 'C', 0, 1)) ?></div>
                <?php endif; ?>
            </div>
            <div class="ast-hero__text">
                <h1 class="ast-hero__title"><?= htmlspecialchars($app['job_title']) ?></h1>
                <p class="ast-hero__company"><?= htmlspecialchars($app['company_name'] ?? 'N/A') ?></p>
                <div class="ast-hero__meta">
                    <span><i class="fa fa-calendar-o"></i> Applied <?= date('d M Y', strtotime($app['applied_at'])) ?></span>
                    <?php if ($deadlineStr): ?>
                        <span class="ast-dl <?= $deadlineCls ?>"><i class="fa fa-clock-o"></i> <?= $deadlineLbl ?></span>
                    <?php endif; ?>
                    <span class="ast-status-pill" style="background:<?= $cfg['light'] ?>;color:<?= $cfg['color'] ?>">
                        <i class="fa <?= $cfg['icon'] ?>"></i> <?= $cfg['label'] ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Main layout ────────────────────────────────────────── -->
<section class="ast-section">
    <div class="container">
        <div class="row">

            <!-- LEFT: main content -->
            <div class="col-md-8">

                <!-- Status banner card -->
                <div class="ast-card ast-card--status" style="border-left-color:<?= $cfg['color'] ?>;background:<?= $cfg['bg'] ?>">
                    <div class="ast-card__status-icon" style="background:<?= $cfg['light'] ?>;color:<?= $cfg['color'] ?>">
                        <i class="fa <?= $cfg['icon'] ?>"></i>
                    </div>
                    <div>
                        <div class="ast-card__status-heading" style="color:<?= $cfg['color'] ?>"><?= $cfg['heading'] ?></div>
                        <div class="ast-card__status-msg"><?= $cfg['message'] ?></div>
                        <?php if (!empty($cfg['tip'])): ?>
                            <div class="ast-card__status-tip">
                                <i class="fa fa-lightbulb-o"></i> <?= $cfg['tip'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Progress tracker -->
                <?php if (!$isTerminal): ?>
                <div class="ast-card">
                    <div class="ast-card__title"><i class="fa fa-road"></i> Application Progress</div>
                    <div class="ast-pipeline">
                        <?php foreach ($pipeline as $i => $step):
                            $done    = ($currentIdx !== false) && $i < $currentIdx;
                            $current = ($currentIdx !== false) && $i === $currentIdx;
                            $future  = ($currentIdx !== false) && $i > $currentIdx;
                            $pl      = $pipelineLabels[$step];
                            $stDesc  = [
                                'submitted'   => 'Your application reached the employer successfully.',
                                'reviewing'   => 'The employer is reading your profile and resume.',
                                'shortlisted' => 'You made the shortlist — top candidates only!',
                                'interview'   => 'An interview will be scheduled. Watch your email and phone.',
                                'offered'     => 'The employer has extended a job offer to you.',
                                'hired'       => 'You have been selected — the job is yours!',
                            ][$step] ?? '';
                        ?>
                        <div class="ast-pip <?= $done ? 'ast-pip--done' : '' ?> <?= $current ? 'ast-pip--current' : '' ?> <?= $future ? 'ast-pip--future' : '' ?>">
                            <div class="ast-pip__track">
                                <div class="ast-pip__dot">
                                    <?php if ($done): ?>
                                        <i class="fa fa-check"></i>
                                    <?php else: ?>
                                        <i class="fa <?= $pl['icon'] ?>"></i>
                                    <?php endif; ?>
                                </div>
                                <?php if ($i < count($pipeline) - 1): ?>
                                    <div class="ast-pip__line <?= $done ? 'ast-pip__line--done' : '' ?>"></div>
                                <?php endif; ?>
                            </div>
                            <div class="ast-pip__body">
                                <div class="ast-pip__label"><?= $pl['label'] ?></div>
                                <div class="ast-pip__desc"><?= $stDesc ?></div>
                                <?php if ($current): ?>
                                    <span class="ast-pip__badge ast-pip__badge--current" style="background:<?= $cfg['color'] ?>">
                                        <i class="fa fa-circle" style="font-size:7px"></i> You are here
                                    </span>
                                <?php elseif ($done): ?>
                                    <span class="ast-pip__badge ast-pip__badge--done">
                                        <i class="fa fa-check"></i> Completed
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- What happens next -->
                <div class="ast-card">
                    <div class="ast-card__title"><i class="fa fa-question-circle"></i> What Happens Next?</div>
                    <div class="ast-next-steps">
                        <?php
                        $nextSteps = [
                            'submitted'   => [
                                ['icon'=>'fa-clock-o',    'title'=>'Wait for review',    'desc'=>'The employer will review your application shortly. This typically takes 3–7 business days.'],
                                ['icon'=>'fa-bell-o',     'title'=>'Stay alert',          'desc'=>'Keep an eye on your email and phone — the employer may reach out directly.'],
                                ['icon'=>'fa-user-circle','title'=>'Keep your profile updated','desc'=>'A complete profile improves your chances. Add skills, experience, and your latest CV.'],
                            ],
                            'reviewing'   => [
                                ['icon'=>'fa-search',     'title'=>'Employer is evaluating','desc'=>'Your profile is being assessed against the job requirements and other applicants.'],
                                ['icon'=>'fa-file-text-o','title'=>'Ensure your CV is ready','desc'=>'If invited for an interview, your CV may come up. Make sure it is current and tailored.'],
                                ['icon'=>'fa-envelope-o', 'title'=>'Check for messages',   'desc'=>'The employer may send a message or invite you for an interview very soon.'],
                            ],
                            'shortlisted' => [
                                ['icon'=>'fa-calendar-check-o','title'=>'Interview incoming','desc'=>'Shortlisted candidates are usually contacted within a few days to schedule an interview.'],
                                ['icon'=>'fa-graduation-cap',  'title'=>'Prepare thoroughly','desc'=>'Research the company, re-read the job description, and prepare your best answers.'],
                                ['icon'=>'fa-phone',           'title'=>'Be reachable',     'desc'=>'The employer may call or email to schedule. Keep your contact details current.'],
                            ],
                            'interview'   => [
                                ['icon'=>'fa-calendar',   'title'=>'Confirm the details',  'desc'=>'Reply promptly to the employer\'s message and confirm the date, time, and format.'],
                                ['icon'=>'fa-book',       'title'=>'Prepare and practice', 'desc'=>'Review the job requirements, practise common interview questions, and know your CV well.'],
                                ['icon'=>'fa-thumbs-o-up','title'=>'Give your best',       'desc'=>'Show up on time, be confident, and let your personality and skills shine through.'],
                            ],
                            'offered'     => [
                                ['icon'=>'fa-envelope-open','title'=>'Review the offer',   'desc'=>'Read the offer letter carefully — salary, benefits, start date, and any conditions.'],
                                ['icon'=>'fa-comments-o',  'title'=>'Negotiate if needed', 'desc'=>'It is perfectly acceptable to ask questions or negotiate reasonable terms professionally.'],
                                ['icon'=>'fa-check-circle','title'=>'Respond promptly',    'desc'=>'Accept or decline within the timeframe given. The employer is waiting for your decision.'],
                            ],
                            'hired'       => [
                                ['icon'=>'fa-handshake-o','title'=>'Onboarding details',   'desc'=>'Expect an email or call from HR with your start date, documents, and first-day instructions.'],
                                ['icon'=>'fa-id-card-o',  'title'=>'Prepare your documents','desc'=>'Have your ID, tax forms, and any certifications ready ahead of your start date.'],
                                ['icon'=>'fa-star-o',     'title'=>'Celebrate!',            'desc'=>'You earned it. Best of luck in your new role — this is just the beginning!'],
                            ],
                            'rejected'    => [
                                ['icon'=>'fa-search',       'title'=>'Keep searching',      'desc'=>'There are many great opportunities on JobPortal. Browse today\'s listings and apply again.'],
                                ['icon'=>'fa-pencil',       'title'=>'Refine your profile', 'desc'=>'Review your CV, improve your skills section, and make sure your profile stands out.'],
                                ['icon'=>'fa-heart-o',      'title'=>'Stay positive',       'desc'=>'Rejections are part of the journey. Every application is valuable experience. Keep going!'],
                            ],
                            'withdrawn'   => [
                                ['icon'=>'fa-search',    'title'=>'Browse more jobs',    'desc'=>'Explore thousands of opportunities on JobPortal that match your skills and goals.'],
                                ['icon'=>'fa-star-o',    'title'=>'Update your profile', 'desc'=>'Refresh your CV and skills to make your next application even stronger.'],
                                ['icon'=>'fa-thumbs-o-up','title'=>'You know your worth','desc'=>'Withdrawing shows self-awareness. Find a role that is the right fit for you.'],
                            ],
                        ];
                        $steps = $nextSteps[$status] ?? $nextSteps['submitted'];
                        foreach ($steps as $ns):
                        ?>
                        <div class="ast-next-step">
                            <div class="ast-next-step__icon"><i class="fa <?= $ns['icon'] ?>"></i></div>
                            <div>
                                <div class="ast-next-step__title"><?= $ns['title'] ?></div>
                                <div class="ast-next-step__desc"><?= $ns['desc'] ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php else: /* terminal: rejected or withdrawn */ ?>

                <!-- Terminal status card -->
                <div class="ast-card">
                    <div class="ast-card__title"><i class="fa fa-road"></i> Application Timeline</div>
                    <div class="ast-terminal">
                        <div class="ast-terminal__icon" style="background:<?= $cfg['light'] ?>;color:<?= $cfg['color'] ?>">
                            <i class="fa <?= $cfg['icon'] ?>"></i>
                        </div>
                        <div class="ast-terminal__msg"><?= $cfg['message'] ?></div>
                        <?php if ($cfg['tip']): ?>
                            <div class="ast-terminal__tip"><i class="fa fa-lightbulb-o"></i> <?= $cfg['tip'] ?></div>
                        <?php endif; ?>
                        <a href="<?= SITE_URL ?>/jobs" class="jg-btn jg-btn--primary" style="margin-top:20px">
                            <i class="fa fa-search"></i> Browse More Jobs
                        </a>
                    </div>
                </div>

                <!-- What happens next for terminal states -->
                <div class="ast-card">
                    <div class="ast-card__title"><i class="fa fa-question-circle"></i> What Happens Next?</div>
                    <div class="ast-next-steps">
                        <?php
                        $steps = $nextSteps[$status] ?? $nextSteps['submitted'];
                        foreach ($steps as $ns):
                        ?>
                        <div class="ast-next-step">
                            <div class="ast-next-step__icon"><i class="fa <?= $ns['icon'] ?>"></i></div>
                            <div>
                                <div class="ast-next-step__title"><?= $ns['title'] ?></div>
                                <div class="ast-next-step__desc"><?= $ns['desc'] ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php endif; ?>

            </div><!-- /.col-md-8 -->

            <!-- RIGHT: sidebar -->
            <div class="col-md-4">

                <!-- Job details -->
                <div class="ast-card">
                    <div class="ast-card__title"><i class="fa fa-briefcase"></i> Job Details</div>
                    <ul class="ast-info-list">
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <div><small>Job Type</small><strong><?= ucfirst(str_replace('_',' ',$app['job_type'] ?? '–')) ?></strong></div>
                        </li>
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <div><small>Location</small><strong><?= htmlspecialchars($app['location_city'] ?? 'N/A') ?></strong></div>
                        </li>
                        <li>
                            <i class="fa fa-calendar"></i>
                            <div><small>Applied On</small><strong><?= date('d M Y', strtotime($app['applied_at'])) ?></strong></div>
                        </li>
                        <li>
                            <i class="fa fa-hourglass-end"></i>
                            <div><small>Deadline</small><strong><?= $deadlineStr ? date('d M Y', strtotime($deadlineStr)) : '—' ?></strong></div>
                        </li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="ast-card">
                    <div class="ast-card__title"><i class="fa fa-cog"></i> Actions</div>
                    <div class="ast-actions">
                        <a href="<?= SITE_URL ?>/jobs/<?= $app['job_id'] ?? 0 ?>" class="ast-action-btn ast-action-btn--outline" target="_blank">
                            <i class="fa fa-external-link"></i> View Job Posting
                        </a>
                        <?php if (!empty($app['employer_id'])): ?>
                        <a href="<?= SITE_URL ?>/seeker/employer/<?= $app['employer_id'] ?>" class="ast-action-btn ast-action-btn--outline">
                            <i class="fa fa-building-o"></i> View Company
                        </a>
                        <?php endif; ?>
                        <a href="<?= SITE_URL ?>/seeker/applications" class="ast-action-btn ast-action-btn--outline">
                            <i class="fa fa-arrow-left"></i> All Applications
                        </a>
                        <?php if (!in_array($status, ['hired','rejected','withdrawn'])): ?>
                        <form action="<?= SITE_URL ?>/seeker/withdraw" method="POST"
                              onsubmit="return confirm('Withdraw this application? This cannot be undone.')">
                            <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                            <button type="submit" class="ast-action-btn ast-action-btn--danger">
                                <i class="fa fa-times"></i> Withdraw Application
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Status legend -->
                <div class="ast-card">
                    <div class="ast-card__title"><i class="fa fa-info-circle"></i> Status Guide</div>
                    <ul class="ast-legend">
                        <?php foreach ($statusConfig as $sk => $sc): ?>
                        <li class="<?= $sk === $status ? 'ast-legend__item--active' : '' ?>">
                            <span class="ast-legend__dot" style="background:<?= $sc['color'] ?>"></span>
                            <span><?= $sc['label'] ?></span>
                            <?php if ($sk === $status): ?>
                                <span class="ast-legend__you">← You</span>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div><!-- /.col-md-4 -->
        </div>
    </div>
</section>

<style>
/* ── Hero ──────────────────────────────────────────────── */
.ast-hero{position:relative;margin-top:-70px;padding-top:130px;padding-bottom:48px;overflow:hidden;background:linear-gradient(135deg,#0a1628 0%,#0a2f6e 60%,#0a1a40 100%)}
.ast-hero::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,transparent 60%,rgba(5,14,30,.4));pointer-events:none}
.ast-hero__overlay{position:absolute;inset:0;background-image:radial-gradient(circle at 70% 50%, rgba(10,101,204,.25) 0%, transparent 60%);pointer-events:none}
.ast-hero__inner{position:relative;z-index:2}
.ast-hero__content{display:flex;align-items:center;gap:22px;margin-top:16px;flex-wrap:wrap}
.ast-hero__logo img,.ast-hero__logo-initial{width:68px;height:68px;border-radius:14px;object-fit:cover;flex-shrink:0;border:2px solid rgba(255,255,255,.2)}
.ast-hero__logo-initial{background:linear-gradient(135deg,#0a65cc,#14a077);display:flex;align-items:center;justify-content:center;color:#fff;font-size:26px;font-weight:800}
.ast-hero__title{font-size:28px;font-weight:800;color:#fff;margin:0 0 4px;line-height:1.2;letter-spacing:-.5px}
.ast-hero__company{font-size:15px;color:rgba(255,255,255,.65);margin:0 0 12px}
.ast-hero__meta{display:flex;align-items:center;flex-wrap:wrap;gap:10px;font-size:13px;color:rgba(255,255,255,.6)}
.ast-hero__meta i{font-size:11px}
.ast-status-pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700}
.ast-dl{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600}
.ast-dl--green{background:rgba(46,125,50,.25);color:#86efac}
.ast-dl--red{background:rgba(229,57,53,.25);color:#fca5a5}

/* ── Section ───────────────────────────────────────────── */
.ast-section{padding:36px 0 70px;background:#f4f6f9}

/* ── Cards ─────────────────────────────────────────────── */
.ast-card{background:#fff;border:1px solid #e0e6f0;border-radius:14px;padding:26px;margin-bottom:20px;box-shadow:0 2px 12px rgba(10,50,120,.05)}
.ast-card--status{display:flex;align-items:flex-start;gap:18px;border-left:5px solid #ccc}
.ast-card__title{font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.7px;margin-bottom:20px;display:flex;align-items:center;gap:8px;padding-bottom:14px;border-bottom:1px solid #f0f4f8}
.ast-card__title i{color:#0a65cc}
.ast-card__status-icon{width:44px;height:44px;min-width:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.ast-card__status-heading{font-size:16px;font-weight:700;margin-bottom:6px}
.ast-card__status-msg{font-size:14px;line-height:1.7;color:#555}
.ast-card__status-tip{margin-top:10px;font-size:13px;font-weight:600;color:#64748b;display:flex;align-items:center;gap:6px;background:#f8fafc;padding:8px 12px;border-radius:8px}

/* ── Pipeline ──────────────────────────────────────────── */
.ast-pipeline{display:flex;flex-direction:column}
.ast-pip{display:flex;gap:0}
.ast-pip__track{display:flex;flex-direction:column;align-items:center;flex-shrink:0;width:48px}
.ast-pip__dot{width:40px;height:40px;border-radius:50%;border:2px solid #d0daea;background:#f5f7fb;color:#c0cad8;display:flex;align-items:center;justify-content:center;font-size:15px;transition:.25s;flex-shrink:0}
.ast-pip__line{width:2px;flex:1;min-height:32px;background:#e0e6f0;margin:4px 0;transition:.25s}
.ast-pip__line--done{background:linear-gradient(180deg,#2e7d32,#0a65cc)}
.ast-pip__body{flex:1;padding:2px 0 28px 16px}
.ast-pip__label{font-size:14px;font-weight:700;color:#94a3b8;margin-bottom:3px}
.ast-pip__desc{font-size:13px;color:#b0bac8;line-height:1.6}
.ast-pip__badge{display:inline-flex;align-items:center;gap:5px;margin-top:8px;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;color:#fff}
.ast-pip__badge--done{background:#2e7d32}
/* done */
.ast-pip--done .ast-pip__dot{background:#e8f5e9;border-color:#2e7d32;color:#2e7d32}
.ast-pip--done .ast-pip__label{color:#2e7d32}
.ast-pip--done .ast-pip__desc{color:#3a7d42}
/* current */
.ast-pip--current .ast-pip__dot{background:#0a65cc;border-color:#0a65cc;color:#fff;box-shadow:0 0 0 6px rgba(10,101,204,.12)}
.ast-pip--current .ast-pip__label{color:#0a65cc;font-size:15px}
.ast-pip--current .ast-pip__desc{color:#334466}
/* future */
.ast-pip--future .ast-pip__dot{opacity:.45}
.ast-pip--future .ast-pip__label{color:#c0cad8}
.ast-pip--future .ast-pip__desc{color:#d0daea}

/* ── Next steps ────────────────────────────────────────── */
.ast-next-steps{display:flex;flex-direction:column;gap:18px}
.ast-next-step{display:flex;align-items:flex-start;gap:14px}
.ast-next-step__icon{width:40px;height:40px;min-width:40px;border-radius:10px;background:#f0f5ff;color:#0a65cc;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.ast-next-step__title{font-size:14px;font-weight:700;color:#1a1a2e;margin-bottom:3px}
.ast-next-step__desc{font-size:13px;color:#64748b;line-height:1.6}

/* ── Terminal state ────────────────────────────────────── */
.ast-terminal{display:flex;flex-direction:column;align-items:center;text-align:center;padding:10px 0}
.ast-terminal__icon{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:18px}
.ast-terminal__msg{font-size:15px;color:#555;line-height:1.7;max-width:380px}
.ast-terminal__tip{margin-top:14px;font-size:13px;font-weight:600;color:#64748b;background:#f8fafc;padding:10px 18px;border-radius:10px}

/* ── Info list (sidebar) ───────────────────────────────── */
.ast-info-list{list-style:none;padding:0;margin:0}
.ast-info-list li{display:flex;align-items:center;gap:14px;padding:11px 0;border-bottom:1px solid #f0f4f8}
.ast-info-list li:last-child{border-bottom:none}
.ast-info-list li>i{font-size:16px;color:#0a65cc;width:18px;text-align:center;flex-shrink:0}
.ast-info-list small{display:block;font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px}
.ast-info-list strong{font-size:14px;color:#1a1a2e;font-weight:700}

/* ── Action buttons ────────────────────────────────────── */
.ast-actions{display:flex;flex-direction:column;gap:8px}
.ast-action-btn{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;padding:10px 16px;border-radius:9px;text-decoration:none;cursor:pointer;border:none;transition:.2s;width:100%;justify-content:center}
.ast-action-btn--outline{background:#fff;border:1.5px solid #e0e6f0;color:#475569}
.ast-action-btn--outline:hover{border-color:#0a65cc;color:#0a65cc;background:#f0f6ff}
.ast-action-btn--danger{background:#fff;border:1.5px solid #fca5a5;color:#e53935}
.ast-action-btn--danger:hover{background:#fef2f2;border-color:#e53935}
.ast-actions form{margin:0}

/* ── Status legend ─────────────────────────────────────── */
.ast-legend{list-style:none;padding:0;margin:0}
.ast-legend li{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f4f8;font-size:13px;color:#64748b}
.ast-legend li:last-child{border-bottom:none}
.ast-legend__dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
.ast-legend__item--active{font-weight:700;color:#1a1a2e}
.ast-legend__you{margin-left:auto;font-size:11px;font-weight:700;color:#0a65cc;background:#f0f6ff;padding:2px 8px;border-radius:20px}

/* ── Breadcrumb override for dark hero ─────────────────── */
.ast-hero .jg-breadcrumb{color:rgba(255,255,255,.5);margin-bottom:0}
.ast-hero .jg-breadcrumb a{color:rgba(255,255,255,.65)}
.ast-hero .jg-breadcrumb a:hover{color:#fff}
.ast-hero .jg-breadcrumb span{color:rgba(255,255,255,.85)}

/* ── Mobile ────────────────────────────────────────────── */
@media(max-width:767px){
    .ast-hero{padding-top:110px;padding-bottom:32px}
    .ast-hero__title{font-size:20px}
    .ast-card--status{flex-direction:column;gap:12px}
    .ast-section{padding:24px 0 50px}
}
</style>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>