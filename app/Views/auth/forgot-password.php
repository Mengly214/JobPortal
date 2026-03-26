<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<section style="padding:80px 0;background:#f4f6f9;min-height:calc(100vh - 70px)">
<div class="container">
<div class="row">
<div class="col-md-5 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="jg-detail-card" style="border-top:4px solid #0a65cc">
        <div style="text-align:center;margin-bottom:28px">
            <div style="width:60px;height:60px;background:#e8f0fd;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:24px;color:#0a65cc"><i class="fa fa-lock"></i></div>
            <h3 style="font-weight:800;color:#1a1a2e;margin:0 0 6px">Forgot Password?</h3>
            <p style="color:#888;font-size:14px;margin:0">Enter your email and we'll send you a reset link.</p>
        </div>
        <?php if ($success): ?><div class="jg-alert jg-alert--success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
        <?php elseif ($error): ?><div class="jg-alert jg-alert--danger"><i class="fa fa-times-circle"></i> <?php echo $error; ?></div><?php endif; ?>
        <?php if (!$success): ?>
        <form action="<?php echo SITE_URL; ?>/forgot-password" method="post">
            <div class="jg-form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="jg-form-control" placeholder="Enter your registered email" required autofocus>
            </div>
            <button type="submit" class="jg-btn jg-btn--primary" style="width:100%;justify-content:center"><i class="fa fa-paper-plane"></i> Send Reset Link</button>
        </form>
        <?php endif; ?>
        <div style="text-align:center;margin-top:20px;font-size:13px">
            <a href="<?php echo SITE_URL; ?>/login" style="color:#0a65cc;font-weight:600"><i class="fa fa-arrow-left"></i> Back to Login</a>
        </div>
    </div>
</div>
</div>
</div>
</section>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
