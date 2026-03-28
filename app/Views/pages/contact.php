<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Send a message and we'll respond shortly.</p>
    </div>
</div>

<section class="jg-section">
<div class="container">
<div class="row">
    <div class="col-md-7 col-sm-12">
        <div class="jg-detail-card">
            <h3 class="jg-detail-card__title"><i class="fa fa-envelope"></i> Send Us a Message</h3>
            <?php if ($success ?? ''): ?><div class="jg-alert jg-alert--success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div><?php endif; ?>
            <?php if ($error   ?? ''): ?><div class="jg-alert jg-alert--danger"><i class="fa fa-times-circle"></i> <?php echo $error; ?></div><?php endif; ?>
            <form action="<?php echo SITE_URL; ?>/contact" method="post" class="jg-contact-form">
                <div class="row">
                    <div class="col-sm-6"><div class="jg-form-group"><label>Full Name</label><input type="text" name="name" class="jg-form-control" placeholder="Your name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required></div></div>
                    <div class="col-sm-6"><div class="jg-form-group"><label>Email Address</label><input type="email" name="email" class="jg-form-control" placeholder="your@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required></div></div>
                </div>
                <div class="jg-form-group"><label>Message</label><textarea name="message" class="jg-form-control" rows="7" placeholder="How can we help?" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea></div>
                <button type="submit" class="jg-btn jg-btn--primary"><i class="fa fa-paper-plane"></i> Send Message</button>
            </form>
        </div>
    </div>
    <div class="col-md-5 col-sm-12">
        <div class="jg-detail-card">
            <h3 class="jg-detail-card__title"><i class="fa fa-map-marker"></i> Contact Information</h3>
            <div class="jg-contact__info">
                <div class="jg-contact__info-item"><div class="jg-contact__info-icon"><i class="fa fa-map-marker"></i></div><div><strong>Address</strong><span>212 Barrington Court, New York, NY 10001</span></div></div>
                <div class="jg-contact__info-item"><div class="jg-contact__info-icon"><i class="fa fa-envelope"></i></div><div><strong>Email</strong><span><?php echo defined('SITE_EMAIL') ? SITE_EMAIL : 'hello@jobportal.com'; ?></span></div></div>
                <div class="jg-contact__info-item"><div class="jg-contact__info-icon"><i class="fa fa-phone"></i></div><div><strong>Phone</strong><span>+1 (555) 555-1234</span></div></div>
                <div class="jg-contact__info-item"><div class="jg-contact__info-icon"><i class="fa fa-clock-o"></i></div><div><strong>Hours</strong><span>Mon–Fri, 9:00 AM – 6:00 PM</span></div></div>
            </div>
            <div class="jg-social-light" style="margin-top:20px">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
