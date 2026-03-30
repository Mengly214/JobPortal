<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<?php
$myId      = (int)$_SESSION['user_id'];
$myRole    = 'employer';
$sendUrl   = SITE_URL . '/employer/messages/send';
$backUrl   = SITE_URL . '/employer/applications';
$otherName = htmlspecialchars($app['applicant_name'] ?? 'Applicant');
$otherAv   = $app['applicant_avatar'] ?? '';
$otherInit = strtoupper(substr($app['applicant_name'] ?? 'A', 0, 1));
$companyLogo = $app['company_logo'] ?? '';
$companyInit = strtoupper(substr($app['company_name'] ?? 'C', 0, 1));
?>

<!-- Hero -->
<div class="msg-hero">
    <div class="container msg-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/employer/applications">Applications</a>
            <i class="fa fa-angle-right"></i>
            <span>Message</span>
        </div>
        <div class="msg-hero__content">
            <div class="msg-hero__avatar">
                <?php if ($otherAv): ?>
                    <img src="<?= SITE_URL ?>/uploads/avatars/<?= htmlspecialchars($otherAv) ?>" alt="">
                <?php else: ?>
                    <div class="msg-hero__avatar-init"><?= $otherInit ?></div>
                <?php endif; ?>
            </div>
            <div>
                <h1 class="msg-hero__name"><?= $otherName ?></h1>
                <p class="msg-hero__sub">
                    <i class="fa fa-briefcase"></i> <?= htmlspecialchars($app['job_title']) ?>
                    &nbsp;·&nbsp;
                    <a href="<?= SITE_URL ?>/employer/seeker/<?= $app['applicant_id'] ?>" style="color:rgba(255,255,255,.8);text-decoration:underline">View Profile</a>
                    &nbsp;·&nbsp;
                    <a href="<?= SITE_URL ?>/employer/applications" style="color:rgba(255,255,255,.8);text-decoration:underline"><i class="fa fa-arrow-left"></i> Back</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Chat -->
<section class="msg-section">
    <div class="container">
        <div class="msg-wrap">

            <!-- Thread -->
            <div class="msg-thread" id="msg-thread">
                <?php if (empty($messages)): ?>
                <div class="msg-empty">
                    <i class="fa fa-comments-o"></i>
                    <p>No messages yet. Send the first message to <?= $otherName ?>.</p>
                </div>
                <?php else: ?>
                <?php foreach ($messages as $m):
                    $isMe = ((int)$m['sender_id'] === $myId);
                ?>
                <div class="msg-bubble <?= $isMe ? 'msg-bubble--me' : 'msg-bubble--them' ?>">
                    <?php if (!$isMe): ?>
                    <div class="msg-bubble__av">
                        <?php if ($otherAv): ?>
                            <img src="<?= SITE_URL ?>/uploads/avatars/<?= htmlspecialchars($otherAv) ?>" alt="">
                        <?php else: ?>
                            <div class="msg-bubble__av-init"><?= $otherInit ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <div class="msg-bubble__body">
                        <div class="msg-bubble__text"><?= nl2br(htmlspecialchars($m['message'])) ?></div>
                        <div class="msg-bubble__meta">
                            <?= $isMe ? 'You' : htmlspecialchars($m['sender_name']) ?>
                            &nbsp;·&nbsp;
                            <span title="<?= htmlspecialchars($m['created_at']) ?>">
                                <?= date('d M Y, g:i a', strtotime($m['created_at'])) ?>
                            </span>
                            <?php if ($isMe && $m['is_read']): ?>
                                <i class="fa fa-check-circle" style="color:#14a077;margin-left:4px" title="Read"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Compose -->
            <form class="msg-compose" action="<?= $sendUrl ?>" method="POST">
                <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                <textarea class="msg-compose__input" name="message" rows="1"
                    placeholder="Type a message to <?= $otherName ?>..."
                    required maxlength="2000"></textarea>
                <button type="submit" class="msg-compose__send">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/app/Views/messages/_shared_styles.php'; ?>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>