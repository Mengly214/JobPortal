<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | <?php echo SITE_NAME; ?></title>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/font-awesome.min.css">
    <style>
    *{box-sizing:border-box}
    body{margin:0;min-height:100vh;background:linear-gradient(135deg,rgba(10,22,40,.92) 0%,rgba(10,101,204,.88) 100%),url("https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1400&q=60&fit=crop") center/cover no-repeat;display:flex;align-items:center;justify-content:center;padding:30px 15px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif}
    .auth-wrap{width:100%;max-width:460px}
    .auth-brand{text-align:center;margin-bottom:28px}
    .auth-brand__logo{width:56px;height:56px;background:#0a65cc;border:3px solid rgba(255,255,255,.3);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:24px;color:#fff}
    .auth-brand h1{font-size:24px;font-weight:800;color:#fff;margin:0 0 5px;letter-spacing:-.5px}
    .auth-brand p{color:rgba(255,255,255,.6);font-size:14px;margin:0}
    .auth-card{background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.3);overflow:hidden}
    .auth-card__head{background:linear-gradient(135deg,#0a1628,#0a65cc);padding:24px 30px;text-align:center}
    .auth-card__head h3{color:#fff;font-size:18px;font-weight:700;margin:0 0 4px}
    .auth-card__head p{color:rgba(255,255,255,.7);font-size:13px;margin:0}
    .auth-card__body{padding:30px}
    .auth-alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:20px}
    .auth-alert--success{background:#e8f5e9;color:#2e7d32;border-left:4px solid #4caf50}
    .auth-alert--danger{background:#fdecea;color:#c62828;border-left:4px solid #f44336}
    .auth-group{margin-bottom:20px}
    .auth-group label{display:block;font-size:13px;font-weight:600;color:#555;margin-bottom:7px}
    .auth-group label i{color:#0a65cc;margin-right:5px}
    .auth-input{width:100%;border:1.5px solid #e0e6f0;border-radius:8px;padding:12px 16px;font-size:14px;outline:none;transition:.2s;background:#fafbfd;font-family:inherit}
    .auth-input:focus{border-color:#0a65cc;background:#fff;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
    .auth-input-wrap{position:relative}
    .auth-input-wrap .auth-input{padding-right:44px}
    .auth-eye{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer;font-size:15px;padding:0}
    .auth-eye:hover{color:#0a65cc}
    .auth-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;margin-bottom:22px}
    .auth-row label{cursor:pointer;color:#666;display:flex;align-items:center;gap:6px;font-weight:normal}
    .auth-row a{color:#0a65cc;text-decoration:none;font-weight:600}
    .auth-row a:hover{text-decoration:underline}
    .auth-submit{width:100%;padding:13px;background:#0a65cc;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;transition:.2s;letter-spacing:.2px}
    .auth-submit:hover{background:#084fa3}
    .auth-divider{display:flex;align-items:center;gap:12px;margin:22px 0;color:#ccc;font-size:12px}
    .auth-divider::before,.auth-divider::after{content:'';flex:1;height:1px;background:#f0f0f0}
    .auth-register{text-align:center}
    .auth-register p{color:#888;font-size:13px;margin-bottom:14px}
    .auth-reg-btn{display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:8px;border:1.5px solid #e0e6f0;background:#f8fafd;color:#555;font-size:13px;text-decoration:none;transition:.2s;margin:0 4px;font-weight:600}
    .auth-reg-btn i{color:#0a65cc}
    .auth-reg-btn:hover{background:#0a65cc;border-color:#0a65cc;color:#fff;text-decoration:none}
    .auth-reg-btn:hover i{color:#fff}
    .auth-back{display:block;text-align:center;margin-top:18px;font-size:13px;color:rgba(255,255,255,.6);text-decoration:none}
    .auth-back:hover{color:#fff}
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-brand">
        <div class="auth-brand__logo"><i class="fa fa-briefcase"></i></div>
        <h1><?php echo SITE_NAME; ?></h1>
        <p>Your gateway to great opportunities</p>
    </div>

    <div class="auth-card">
        <div class="auth-card__head">
            <h3>Welcome Back</h3>
            <p>Sign in to continue to your account</p>
        </div>
        <div class="auth-card__body">
            <?php if ($success): ?><div class="auth-alert auth-alert--success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div><?php endif; ?>
            <?php if ($error):   ?><div class="auth-alert auth-alert--danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?></div><?php endif; ?>

            <form action="<?php echo SITE_URL; ?>/login" method="post">
                <div class="auth-group">
                    <label><i class="fa fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" class="auth-input" placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required autofocus>
                </div>
                <div class="auth-group">
                    <label><i class="fa fa-lock"></i> Password</label>
                    <div class="auth-input-wrap">
                        <input type="password" id="pw" name="password" class="auth-input" placeholder="Enter your password" required>
                        <button type="button" class="auth-eye" onclick="var f=document.getElementById('pw'),i=this.querySelector('i');f.type=f.type==='password'?'text':'password';i.className=f.type==='password'?'fa fa-eye':'fa fa-eye-slash'"><i class="fa fa-eye"></i></button>
                    </div>
                </div>
                <div class="auth-row">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                    <a href="<?php echo SITE_URL; ?>/forgot-password">Forgot password?</a>
                </div>
                <button type="submit" class="auth-submit"><i class="fa fa-sign-in"></i> Sign In</button>
            </form>

            <div class="auth-divider">or register a new account</div>
            <div class="auth-register">
                <p>Don't have an account? Join as:</p>
                <a href="<?php echo SITE_URL; ?>/register?role=job_seeker" class="auth-reg-btn"><i class="fa fa-user"></i> Job Seeker</a>
                <a href="<?php echo SITE_URL; ?>/register?role=employer" class="auth-reg-btn"><i class="fa fa-building"></i> Employer</a>
            </div>
        </div>
    </div>
    <a href="<?php echo SITE_URL; ?>/" class="auth-back"><i class="fa fa-arrow-left"></i> Back to <?php echo SITE_NAME; ?></a>
</div>
</body>
</html>
