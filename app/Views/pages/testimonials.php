<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero">
    <div class="container">
        <h1>Testimonials</h1>
        <p>Hear what our community has to say about <?php echo SITE_NAME; ?></p>
    </div>
</div>

<section class="jg-section">
<div class="container">
    <?php if (empty($testimonials)): ?>
    <div class="jg-empty"><i class="fa fa-comments"></i><h3>No Testimonials Yet</h3><p>Be the first to share your experience!</p></div>
    <?php else: ?>
    <div class="row">
        <?php foreach ($testimonials as $t): ?>
        <div class="col-md-4 col-sm-6" style="margin-bottom:24px">
            <div class="jg-tst-card jg-tst-card--light">
                <div class="jg-tst-card__quote"><i class="fa fa-quote-left"></i></div>
                <p><?php echo clean($t['content']); ?></p>
                <div class="jg-tst-card__author">
                    <img src="<?php echo !empty($t['author_photo']) ? SITE_URL.'/uploads/testimonials/'.clean($t['author_photo']) : SITE_URL.'/assets/images/tst-image-1-200x216.jpg'; ?>" alt="">
                    <div><strong><?php echo clean($t['author_name']); ?></strong><span><?php echo clean($t['author_role'] ?? ''); ?></span></div>
                </div>
                <div class="jg-tst-card__stars"><?php for ($i=1;$i<=($t['rating']??5);$i++) echo '<i class="fa fa-star"></i>'; ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
