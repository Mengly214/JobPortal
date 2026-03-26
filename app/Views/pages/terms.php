<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero">
    <div class="container">
        <h1>Terms &amp; Conditions</h1>
        <p>Please read these terms carefully before using our platform</p>
    </div>
</div>

<section class="jg-section">
<div class="container">
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="jg-detail-card">
            <?php
            $sections = [
                ['fa-check-circle', '1. Acceptance of Terms',   'By accessing and using this website, you accept and agree to be bound by these terms and conditions. If you do not agree to all of these terms, please do not use this site.'],
                ['fa-briefcase',    '2. Use of the Service',    'You agree to use this service only for lawful purposes. You must not use the platform in any way that violates applicable local, national, or international laws or regulations.'],
                ['fa-user',         '3. Account Registration',  'To access certain features you must register for an account. You are responsible for maintaining the confidentiality of your login credentials and for all activities that occur under your account.'],
                ['fa-list',         '4. Job Listings',          'Employers are solely responsible for the accuracy, legality, and content of their job listings. We reserve the right to remove any listing that violates our community guidelines or applicable law.'],
                ['fa-lock',         '5. Privacy Policy',        'We are committed to protecting your personal information. We will never sell your data to third parties. Please review our Privacy Policy for full details on how we collect and use data.'],
                ['fa-edit',         '6. Changes to Terms',      'We reserve the right to modify these terms at any time without prior notice. Continued use of the platform after changes have been posted constitutes your acceptance of the revised terms.'],
            ];
            foreach ($sections as [$icon, $title, $text]):
            ?>
            <div class="jg-terms-section">
                <h3><i class="fa <?php echo $icon; ?>"></i> <?php echo $title; ?></h3>
                <p><?php echo $text; ?></p>
            </div>
            <?php endforeach; ?>
            <div class="jg-terms-footer">
                <p><i class="fa fa-calendar"></i> Last updated: January 2025 &nbsp;|&nbsp; Questions? <a href="<?php echo SITE_URL; ?>/contact">Contact us</a></p>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
