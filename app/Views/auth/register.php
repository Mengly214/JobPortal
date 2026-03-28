<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero">
    <div class="container">
        <h1>Create Your Account</h1>
        <p>Choose how you'd like to join <?php echo SITE_NAME; ?></p>
    </div>
</div>

<section class="jg-section" style="padding-top:36px">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">

    <!-- ROLE TOGGLE -->
    <div class="jg-role-toggle">
        <button type="button" class="jg-role-btn <?php echo $role !== 'employer' ? 'active' : ''; ?>" onclick="switchRole('job_seeker')">
            <i class="fa fa-user"></i> Job Seeker
        </button>
        <button type="button" class="jg-role-btn <?php echo $role === 'employer' ? 'active' : ''; ?>" onclick="switchRole('employer')">
            <i class="fa fa-building"></i> Employer
        </button>
    </div>

    <?php if ($error): ?><div class="jg-alert jg-alert--danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?></div><?php endif; ?>

    <!-- JOB SEEKER FORM -->
    <div class="jg-reg-panel <?php echo $role !== 'employer' ? 'active' : ''; ?>" id="panel-job_seeker">
        <div class="jg-detail-card" style="border-top:4px solid #0a65cc">
            <h3 class="jg-detail-card__title"><i class="fa fa-user"></i> Job Seeker Registration</h3>
            <form action="<?php echo SITE_URL; ?>/register" method="post" enctype="multipart/form-data">
                <input type="hidden" name="role" value="job_seeker">
                <div class="row">
                    <div class="col-md-6"><div class="jg-form-group"><label>Full Name <span class="req">*</span></label><input type="text" name="full_name" class="jg-form-control" placeholder="John Doe" value="<?php echo htmlspecialchars($_POST['full_name']??''); ?>" required></div></div>
                    <div class="col-md-6"><div class="jg-form-group"><label>Location</label><input type="text" name="location" class="jg-form-control" placeholder="City, Country" value="<?php echo htmlspecialchars($_POST['location']??''); ?>"></div></div>
                </div>
                <div class="jg-form-group"><label>Email Address <span class="req">*</span></label><input type="email" name="email" class="jg-form-control" placeholder="john@example.com" value="<?php echo htmlspecialchars($_POST['email']??''); ?>" required></div>
                <div class="row">
                    <div class="col-md-6"><div class="jg-form-group"><label>Password <span class="req">*</span></label><div style="position:relative"><input type="password" name="password" id="sk-pass" class="jg-form-control" placeholder="Min 8 characters" required style="padding-right:42px"><button type="button" class="jg-pw-eye" onclick="tpw('sk-pass',this)"><i class="fa fa-eye"></i></button></div></div></div>
                    <div class="col-md-6"><div class="jg-form-group"><label>Confirm Password <span class="req">*</span></label><div style="position:relative"><input type="password" name="password2" id="sk-pass2" class="jg-form-control" placeholder="Repeat password" required style="padding-right:42px"><button type="button" class="jg-pw-eye" onclick="tpw('sk-pass2',this)"><i class="fa fa-eye"></i></button></div></div></div>
                </div>
                <div class="jg-form-group"><label>Upload CV <span style="color:#aaa;font-weight:400">(optional — PDF, DOC)</span></label>
                    <div class="jg-upload-zone" id="cv-wrap"><input type="file" name="cv_file" accept=".pdf,.doc,.docx" onchange="showFile(this,'cv-name','cv-wrap')"><i class="fa fa-cloud-upload"></i><p>Click to upload or drag &amp; drop</p><span class="jg-upload-zone__name" id="cv-name"></span></div>
                </div>
                <button type="submit" class="jg-btn jg-btn--primary"><i class="fa fa-user-plus"></i> Create Job Seeker Account</button>
            </form>
        </div>
    </div>

    <!-- EMPLOYER FORM -->
    <div class="jg-reg-panel <?php echo $role === 'employer' ? 'active' : ''; ?>" id="panel-employer">
        <div class="jg-detail-card" style="border-top:4px solid #0a65cc">
            <h3 class="jg-detail-card__title"><i class="fa fa-building"></i> Employer Registration</h3>
            <form action="<?php echo SITE_URL; ?>/register" method="post" enctype="multipart/form-data">
                <input type="hidden" name="role" value="employer">
                <div class="row">
                    <div class="col-md-6"><div class="jg-form-group"><label>Company Name <span class="req">*</span></label><input type="text" name="company_name" class="jg-form-control" placeholder="Acme Corp" value="<?php echo htmlspecialchars($_POST['company_name']??''); ?>" required></div></div>
                    <div class="col-md-6"><div class="jg-form-group"><label>Contact Person <span class="req">*</span></label><input type="text" name="full_name" class="jg-form-control" placeholder="Jane Smith" value="<?php echo htmlspecialchars($_POST['full_name']??''); ?>" required></div></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="jg-form-group"><label>Email Address <span class="req">*</span></label><input type="email" name="email" class="jg-form-control" placeholder="hr@company.com" value="<?php echo htmlspecialchars($_POST['email']??''); ?>" required></div></div>
                    <div class="col-md-6"><div class="jg-form-group"><label>Company Location</label><input type="text" name="location" class="jg-form-control" placeholder="City, Country" value="<?php echo htmlspecialchars($_POST['location']??''); ?>"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="jg-form-group"><label>Password <span class="req">*</span></label><div style="position:relative"><input type="password" name="password" id="em-pass" class="jg-form-control" placeholder="Min 8 characters" required style="padding-right:42px"><button type="button" class="jg-pw-eye" onclick="tpw('em-pass',this)"><i class="fa fa-eye"></i></button></div></div></div>
                    <div class="col-md-6"><div class="jg-form-group"><label>Confirm Password <span class="req">*</span></label><div style="position:relative"><input type="password" name="password2" id="em-pass2" class="jg-form-control" placeholder="Repeat password" required style="padding-right:42px"><button type="button" class="jg-pw-eye" onclick="tpw('em-pass2',this)"><i class="fa fa-eye"></i></button></div></div></div>
                </div>
                <div class="jg-form-group"><label>Company Logo <span style="color:#aaa;font-weight:400">(optional)</span></label>
                    <div class="jg-upload-zone" id="logo-wrap"><input type="file" name="company_logo" accept="image/jpeg,image/png,image/webp" onchange="showFile(this,'logo-name','logo-wrap')"><i class="fa fa-image"></i><p>Click to upload your company logo</p><span class="jg-upload-zone__name" id="logo-name"></span></div>
                </div>
                <button type="submit" class="jg-btn jg-btn--primary"><i class="fa fa-building"></i> Create Employer Account</button>
            </form>
        </div>
    </div>

    <div style="text-align:center;margin-top:16px;font-size:13px;color:#888">Already have an account? <a href="<?php echo SITE_URL; ?>/login" style="color:var(--jg-primary);font-weight:700">Sign in here</a></div>
</div>
</div>
</div>
</section>

<style>
:root{--jg-primary:#0a65cc;--jg-secondary:#14a077;--jg-border:#e0e6f0;--jg-shadow:0 4px 24px rgba(10,101,204,.10)}
.jg-role-toggle{display:flex;background:#fff;border:1.5px solid var(--jg-border);border-radius:10px;overflow:hidden;margin-bottom:24px;box-shadow:var(--jg-shadow)}
.jg-role-btn{flex:1;padding:14px;border:none;background:transparent;font-size:15px;font-weight:600;color:#777;cursor:pointer;transition:.2s;display:flex;align-items:center;justify-content:center;gap:9px}
.jg-role-btn.active{background:var(--jg-primary);color:#fff}
.jg-role-btn:not(.active):hover{background:#f0f5ff;color:var(--jg-primary)}
.jg-reg-panel{display:none}.jg-reg-panel.active{display:block}
.req{color:#e53935}
.jg-upload-zone{border:2px dashed var(--jg-border);border-radius:8px;padding:20px;text-align:center;cursor:pointer;transition:.2s;position:relative;background:#fafbfd}
.jg-upload-zone:hover{border-color:var(--jg-primary);background:#f0f5ff}
.jg-upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.jg-upload-zone i{font-size:28px;color:#ccc;display:block;margin-bottom:8px}
.jg-upload-zone p{margin:0;font-size:13px;color:#aaa}
.jg-upload-zone__name{display:none;font-size:12px;color:var(--jg-secondary);margin-top:6px;font-weight:600}
.jg-pw-eye{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer;padding:0;font-size:14px}
.jg-pw-eye:hover{color:var(--jg-primary)}
</style>

<script>
function switchRole(r){
    document.querySelectorAll('.jg-role-btn').forEach(function(b,i){b.classList.toggle('active',r==='job_seeker'?i===0:i===1)});
    document.querySelectorAll('.jg-reg-panel').forEach(function(p){p.classList.remove('active')});
    document.getElementById('panel-'+r).classList.add('active');
    history.replaceState(null,'','<?php echo SITE_URL; ?>/register?role='+r);
}
function tpw(id,btn){var i=document.getElementById(id);i.type=i.type==='password'?'text':'password';btn.querySelector('i').className=i.type==='password'?'fa fa-eye':'fa fa-eye-slash'}
function showFile(input,nameId,wrapId){if(input.files&&input.files[0]){var n=document.getElementById(nameId);var w=document.getElementById(wrapId);n.textContent='✓ '+input.files[0].name;n.style.display='block';w.style.borderColor='var(--jg-primary)'}}
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
