<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<style>
.profile-page { background:#f5f7fb; min-height:100vh; padding:40px 0 60px; }
.profile-sidebar {
     background:#fff; border-radius:8px;
     box-shadow:0 2px 15px rgba(0,0,0,.07);
     border-top:4px solid #3f51b5;
     padding:28px 20px; text-align:center;
}
.profile-logo {
     width:100px; height:100px; border-radius:10px;
     object-fit:cover; border:3px solid #3f51b5; margin-bottom:12px;
}
.profile-card {
     background:#fff; border-radius:8px;
     box-shadow:0 2px 15px rgba(0,0,0,.07);
     margin-bottom:20px;
}
.profile-card-header {
     padding:16px 22px;
     border-bottom:1px solid #f5f5f5;
     display:flex; align-items:center; gap:8px;
}
.profile-card-header h4 { margin:0; font-size:14px; font-family:'Muli',sans-serif; font-weight:700; color:#252525; }
.profile-card-header .fa { color:#3f51b5; font-size:15px; }
.profile-card-body { padding:22px; }
.profile-label {
     font-size:11px; font-weight:700; text-transform:uppercase;
     letter-spacing:.5px; color:#757575; margin-bottom:5px;
     font-family:'Muli',sans-serif;
}
.profile-input {
     border:1.5px solid #e8e8e8 !important; border-radius:6px !important;
     padding:10px 14px !important; font-size:13px !important;
     transition:border-color .2s !important; box-shadow:none !important; height:auto !important;
}
.profile-input:focus { border-color:#3f51b5 !important; box-shadow:0 0 0 3px rgba(63,81,181,.1) !important; }
.upload-zone {
     border:2px dashed #e0e0e0; border-radius:6px; padding:16px;
     text-align:center; cursor:pointer; transition:.2s;
     position:relative; background:#fafafa;
}
.upload-zone:hover { border-color:#3f51b5; background:#f0f1fc; }
.upload-zone input[type=file] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
.profile-save-btn {
     background:linear-gradient(135deg,#303f9f,#3f51b5);
     border:none; color:#fff; font-family:'Muli',sans-serif;
     font-weight:700; font-size:14px; padding:11px 28px;
     border-radius:6px; cursor:pointer; transition:opacity .2s;
}
.profile-save-btn:hover { opacity:.9; }
.profile-nav a {
     display:block; padding:10px 14px; border-radius:6px;
     color:#575757; text-decoration:none; font-size:13px; margin-bottom:4px; transition:.2s;
}
.profile-nav a:hover, .profile-nav a.active { background:#eef0fb; color:#3f51b5; font-weight:700; }
.profile-nav a .fa { width:18px; color:#aaa; margin-right:6px; }
.profile-nav a.active .fa, .profile-nav a:hover .fa { color:#3f51b5; }
.alert-success { background:#eafaf4; border-left:4px solid #29ca8e; color:#1a7a4a; padding:12px 16px; border-radius:6px; margin-bottom:18px; }
.alert-danger  { background:#fdf2f2; border-left:4px solid #e53935; color:#a94442; padding:12px 16px; border-radius:6px; margin-bottom:18px; }
</style>

<section class="profile-page">
<div class="container">
<div class="row">

     <!-- SIDEBAR -->
     <div class="col-md-3">
          <div class="profile-sidebar">
               <?php
               $logoSrc = !empty($user['logo'])
                    ? SITE_URL.'/uploads/logos/'.clean($user['logo'])
                    : 'https://ui-avatars.com/api/?name='.urlencode($user['company_name'] ?? $user['email']).'&size=120&background=3f51b5&color=fff&bold=true';
               ?>
               <img id="logo-preview" src="<?php echo $logoSrc; ?>" class="profile-logo">
               <div style="font-weight:700;font-size:15px;color:#252525"><?php echo htmlspecialchars($user['company_name'] ?? 'Company'); ?></div>
               <div style="font-size:12px;color:#aaa;margin:3px 0 6px"><?php echo htmlspecialchars($user['full_name'] ?? ''); ?></div>
               <span style="background:#eef0fb;color:#3f51b5;border-radius:50px;padding:3px 12px;font-size:11px;font-weight:700">Employer</span>
               <?php if (!empty($user['company_city'])): ?>
               <div style="font-size:12px;color:#aaa;margin-top:8px"><i class="fa fa-map-marker" style="color:#3f51b5"></i> <?php echo clean($user['company_city']); ?></div>
               <?php endif; ?>
               <?php if (!empty($user['industry'])): ?>
               <div style="font-size:12px;color:#aaa;margin-top:4px"><i class="fa fa-industry" style="color:#3f51b5"></i> <?php echo clean($user['industry']); ?></div>
               <?php endif; ?>
               <hr style="margin:16px 0">
               <nav class="profile-nav" style="text-align:left">
                    <a href="<?php echo SITE_URL; ?>/employer/profile" class="active"><i class="fa fa-building"></i> Company Profile</a>
                    <a href="<?php echo SITE_URL; ?>/employer/dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                    <a href="<?php echo SITE_URL; ?>/employer/report"><i class="fa fa-bar-chart"></i> Company Report</a>
                    <a href="<?php echo SITE_URL; ?>/jobs"><i class="fa fa-briefcase"></i> Browse Jobs</a>
                    <a href="<?php echo SITE_URL; ?>/logout" style="color:#e53935"><i class="fa fa-sign-out" style="color:#e53935"></i> Logout</a>
               </nav>
          </div>
     </div>

     <!-- MAIN CONTENT -->
     <div class="col-md-9">

          <?php if ($error):   ?><div class="alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?></div><?php endif; ?>
          <?php if ($success): ?><div class="alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div><?php endif; ?>

          <form method="post" action="<?php echo SITE_URL; ?>/employer/profile" enctype="multipart/form-data">

               <!-- Account Info -->
               <div class="profile-card">
                    <div class="profile-card-header"><i class="fa fa-user"></i><h4>Account Information</h4></div>
                    <div class="profile-card-body">
                         <div class="row">
                              <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="profile-label">Contact Person Name</label>
                                        <input type="text" name="full_name" class="form-control profile-input"
                                               value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" placeholder="Your name">
                                   </div>
                              </div>
                              <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="profile-label">Email <span style="color:red">*</span></label>
                                        <input type="email" name="email" class="form-control profile-input"
                                               value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <!-- Company Info -->
               <div class="profile-card">
                    <div class="profile-card-header"><i class="fa fa-building"></i><h4>Company Information</h4></div>
                    <div class="profile-card-body">
                         <div class="row">
                              <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="profile-label">Company Name <span style="color:red">*</span></label>
                                        <input type="text" name="company_name" class="form-control profile-input"
                                               value="<?php echo htmlspecialchars($user['company_name'] ?? ''); ?>" placeholder="Your company name" required>
                                   </div>
                              </div>
                              <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="profile-label">Location</label>
                                        <input type="text" name="company_city" class="form-control profile-input"
                                               value="<?php echo htmlspecialchars($user['company_city'] ?? ''); ?>" placeholder="City, Country">
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-4">
                                   <div class="form-group">
                                        <label class="profile-label">Industry</label>
                                        <input type="text" name="industry" class="form-control profile-input"
                                               value="<?php echo htmlspecialchars($user['industry'] ?? ''); ?>" placeholder="e.g. Technology">
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <div class="form-group">
                                        <label class="profile-label">Company Size</label>
                                        <select name="company_size" class="form-control profile-input">
                                             <option value="">-- Select --</option>
                                             <?php foreach (['1-10','11-50','51-200','201-500','500+'] as $sz): ?>
                                             <option value="<?php echo $sz; ?>" <?php echo ($user['company_size'] ?? '') === $sz ? 'selected' : ''; ?>><?php echo $sz; ?> employees</option>
                                             <?php endforeach; ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="col-md-4">
                                   <div class="form-group">
                                        <label class="profile-label">Website</label>
                                        <input type="text" name="website" class="form-control profile-input"
                                               value="<?php echo htmlspecialchars($user['website'] ?? ''); ?>" placeholder="https://...">
                                   </div>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="profile-label">Company Description</label>
                              <textarea name="company_desc" class="form-control profile-input" rows="4"
                                        placeholder="Tell job seekers about your company, culture, mission..."><?php echo htmlspecialchars($user['company_desc'] ?? ''); ?></textarea>
                         </div>
                    </div>
               </div>

               <!-- Company Logo -->
               <div class="profile-card">
                    <div class="profile-card-header"><i class="fa fa-image"></i><h4>Company Logo</h4></div>
                    <div class="profile-card-body">
                         <div class="row">
                              <div class="col-md-4 text-center">
                                   <img id="logo-preview-small" src="<?php echo $logoSrc; ?>"
                                        style="width:80px;height:80px;border-radius:8px;object-fit:cover;border:2px solid #e0e0e0;margin-bottom:8px">
                                   <div style="font-size:11px;color:#aaa">Current Logo</div>
                              </div>
                              <div class="col-md-8">
                                   <div class="upload-zone" style="padding:20px">
                                        <input type="file" name="company_logo" accept="image/jpeg,image/png,image/webp"
                                               onchange="previewImg(this,'logo-preview');previewImg(this,'logo-preview-small')">
                                        <i class="fa fa-cloud-upload" style="color:#ccc;font-size:24px;display:block;margin-bottom:6px"></i>
                                        <div style="font-size:13px;color:#aaa">Click to upload new logo</div>
                                        <div style="font-size:11px;color:#ccc;margin-top:3px">JPG, PNG, WEBP — max 2MB</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <!-- Change Password -->
               <div class="profile-card">
                    <div class="profile-card-header"><i class="fa fa-lock"></i><h4>Change Password <small style="font-weight:400;color:#aaa">(leave blank to keep current)</small></h4></div>
                    <div class="profile-card-body">
                         <div class="row">
                              <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="profile-label">New Password</label>
                                        <div style="position:relative">
                                             <input type="password" name="password" id="p1" class="form-control profile-input" placeholder="Min 8 characters">
                                             <button type="button" onclick="togglePass('p1',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer"><i class="fa fa-eye"></i></button>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="profile-label">Confirm Password</label>
                                        <div style="position:relative">
                                             <input type="password" name="password2" id="p2" class="form-control profile-input" placeholder="Repeat password">
                                             <button type="button" onclick="togglePass('p2',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer"><i class="fa fa-eye"></i></button>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <button type="submit" class="profile-save-btn"><i class="fa fa-save"></i> &nbsp; Save Profile</button>
          </form>
     </div>

</div>
</div>
</section>

<script>
function previewImg(input, previewId) {
     if (input.files && input.files[0]) {
          var r = new FileReader();
          r.onload = function(e){ document.getElementById(previewId).src = e.target.result; };
          r.readAsDataURL(input.files[0]);
     }
}
function togglePass(id, btn) {
     var i = document.getElementById(id);
     i.type = i.type === 'password' ? 'text' : 'password';
     btn.querySelector('i').className = i.type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
}
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>