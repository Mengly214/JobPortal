<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<?php
$myId        = (int)$_SESSION['user_id'];
$otherName   = htmlspecialchars($app['company_name'] ?? $app['employer_name'] ?? 'Employer');
$otherInit   = strtoupper(substr($app['company_name'] ?? 'E', 0, 1));
$companyLogo = $app['company_logo'] ?? '';
$lastMsgId   = !empty($messages) ? (int)end($messages)['id'] : 0;
?>

<!-- Hidden config for JS -->
<input type="hidden" id="msg-app-id"   value="<?= $app['id'] ?>">
<input type="hidden" id="msg-api-base" value="<?= SITE_URL ?>/api/messages">
<input type="hidden" id="msg-last-id"  value="<?= $lastMsgId ?>">

<!-- Hero -->
<div class="msg-hero">
    <div class="container msg-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?= SITE_URL ?>/seeker/applications">My Applications</a>
            <i class="fa fa-angle-right"></i>
            <span>Message — <?= $otherName ?></span>
        </div>
        <div class="msg-hero__content">
            <div class="msg-hero__avatar">
                <?php if ($companyLogo): ?>
                    <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($companyLogo) ?>" alt="" style="border-radius:10px">
                <?php else: ?>
                    <div class="msg-hero__avatar-init" style="border-radius:10px"><?= $otherInit ?></div>
                <?php endif; ?>
            </div>
            <div>
                <h1 class="msg-hero__name"><?= $otherName ?></h1>
                <p class="msg-hero__sub">
                    <i class="fa fa-briefcase"></i> <?= htmlspecialchars($app['job_title']) ?>
                    &nbsp;·&nbsp;
                    <a href="<?= SITE_URL ?>/seeker/application/<?= $app['id'] ?>">View Status</a>
                    &nbsp;·&nbsp;
                    <a href="<?= SITE_URL ?>/seeker/applications"><i class="fa fa-arrow-left"></i> Back</a>
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
                    <p>No messages yet. The employer will reach out once they review your application.</p>
                </div>
                <?php else: ?>
                <?php foreach ($messages as $m):
                    $isMe = ((int)$m['sender_id'] === $myId);
                ?>
                <div class="msg-bubble <?= $isMe ? 'msg-bubble--me' : 'msg-bubble--them' ?>" data-id="<?= $m['id'] ?>">
                    <?php if (!$isMe): ?>
                    <div class="msg-bubble__av">
                        <?php if ($companyLogo): ?>
                            <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($companyLogo) ?>" alt="" style="border-radius:6px">
                        <?php else: ?>
                            <div class="msg-bubble__av-init" style="border-radius:6px"><?= $otherInit ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <div class="msg-bubble__body">
                        <div class="msg-bubble__text"><?= nl2br(htmlspecialchars($m['message'])) ?></div>
                        <div class="msg-bubble__meta">
                            <?= $isMe ? 'You' : $otherName ?>
                            &nbsp;·&nbsp; <?= date('d M Y, g:i a', strtotime($m['created_at'])) ?>
                            <?php if ($isMe && $m['is_read']): ?>
                                <i class="fa fa-check-circle" style="color:#14a077;margin-left:4px" title="Read"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Live status bar -->
            <div class="msg-statusbar">
                <span class="msg-statusbar__dot"></span>
                <span class="msg-statusbar__text">Connecting…</span>
                <span style="margin-left:auto;font-size:10px;color:#c0cad8">Updates every 3s &nbsp;·&nbsp; Ctrl+Enter to send</span>
            </div>

            <!-- Compose (no action/method — handled by JS) -->
            <form class="msg-compose" id="msg-form">
                <textarea class="msg-compose__input" id="msg-input" rows="1"
                    placeholder="Reply to <?= $otherName ?>…"
                    maxlength="2000"></textarea>
                <button type="submit" class="msg-compose__send" title="Send (Ctrl+Enter)">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </form>

        </div>
    </div>
</section>

<?php require_once BASE_PATH . '/app/Views/messages/_shared_styles.php'; ?>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>