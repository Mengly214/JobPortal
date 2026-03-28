<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<style>

</style>

<section class="profile-page">
<div class="container">
<div class="row">

     <!-- SIDEBAR -->
     <div class="col-md-3">
          <div class="profile-sidebar">
               <?php $src = !empty($user['avatar'])
                    ? SITE_URL.'/uploads/avatars/'.clean($user['avatar'])
                    : 'https://ui-avatars.com/api/?name='.urlencode($user['full_name'] ?? $user['email']).'&size=120&background=1360be&color=fff&bold=true'; ?>
               <img id="av-preview" src="<?php echo $src; ?>" class="profile-avatar">
               <div style="font-weight:700;font-size:15px;color:#252525"><?php echo htmlspecialchars($user['full_name'] ?? 'Job Seeker'); ?></div>
               <div style="font-size:12px;color:#aaa;margin:4px 0 10px"><?php echo htmlspecialchars($user['email']); ?></div>
               <span style="background:#eafaf4;color:#1360be;border-radius:50px;padding:3px 12px;font-size:11px;font-weight:700">Job Seeker</span>
               <?php if (!empty($user['seeker_city'])): ?>
               <div style="font-size:12px;color:#aaa;margin-top:8px"><i class="fa fa-map-marker" style="color:#1360be"></i> <?php echo clean($user['seeker_city']); ?></div>
               <?php endif; ?>
               <hr style="margin:16px 0">
               <nav class="profile-nav" style="text-align:left">
                    <a href="<?php echo SITE_URL; ?>/seeker/profile" class="active"><i class="fa fa-user"></i> My Profile</a>
                    <a href="<?php echo SITE_URL; ?>/seeker/dashboard"><i class="fa fa-tachometer"></i> Dashboard</a>
                    <a href="<?php echo SITE_URL; ?>/jobs"><i class="fa fa-briefcase"></i> Browse Jobs</a>
                    <a href="<?php echo SITE_URL; ?>/logout" style="color:#e53935"><i class="fa fa-sign-out" style="color:#e53935"></i> Logout</a>
               </nav>
          </div>
     </div>

     <!-- MAIN CONTENT -->
     <div class="col-md-9">

          <?php if ($error):   ?><div class="alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?></div><?php endif; ?>
          <?php if ($success): ?><div class="alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div><?php endif; ?>

          <form method="post" action="<?php echo SITE_URL; ?>/seeker/profile" enctype="multipart/form-data">

               <!-- Account Info -->
               <div class="profile-card">
                    <h4><i class="fa fa-user"></i> Account Information</h4>
                    <div class="row">
                         <div class="col-md-6">
                              <div class="form-group">
                                   <label class="profile-label">Full Name</label>
                                   <input type="text" name="full_name" class="form-control profile-input"
                                          value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" placeholder="Your full name">
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
                    <div class="row">
                         <div class="col-md-6">
                              <div class="form-group">
                                   <label class="profile-label">Location</label>
                                   <input type="text" name="seeker_city" class="form-control profile-input"
                                          value="<?php echo htmlspecialchars($user['seeker_city'] ?? ''); ?>" placeholder="City, Country">
                              </div>
                         </div>
                         <div class="col-md-6">
                              <div class="form-group">
                                   <label class="profile-label">Profile Photo</label>
                                   <div class="upload-zone">
                                        <input type="file" name="avatar" accept="image/*" onchange="previewImg(this,'av-preview')">
                                        <i class="fa fa-camera" style="color:#ccc;font-size:16px;display:block;margin-bottom:3px"></i>
                                        <span style="font-size:11px;color:#aaa">Click to upload photo</span>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="form-group">
                         <label class="profile-label">Bio</label>
                         <textarea name="bio" class="form-control profile-input profile-textarea"
                                   placeholder="Write a brief professional summary..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                    </div>
               </div>

               <!-- Professional Info -->
               <div class="profile-card">
                    <h4><i class="fa fa-briefcase"></i> Professional Information</h4>
                    <div class="form-group">
                         <label class="profile-label">Skills</label>
                         <input type="text" name="skills" class="form-control profile-input"
                                value="<?php echo htmlspecialchars($user['skills'] ?? ''); ?>"
                                placeholder="e.g. PHP, JavaScript, MySQL, Photoshop (comma separated)">
                         <small class="text-muted">Separate skills with commas</small>
                    </div>
                    <div class="form-group">
                         <label class="profile-label">Work Experience</label>
                         <textarea name="experience" class="form-control profile-input profile-textarea"
                                   placeholder="Describe your work experience, job titles, companies, durations..."><?php echo htmlspecialchars($user['experience'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                         <label class="profile-label">Education</label>
                         <textarea name="education" class="form-control profile-input profile-textarea"
                                   placeholder="Degrees, institutions, graduation years..."><?php echo htmlspecialchars($user['education'] ?? ''); ?></textarea>
                    </div>
               </div>

               <!-- CV Upload -->
               <div class="profile-card">
                    <h4><i class="fa fa-file-pdf-o"></i> CV / Resume</h4>
                    <?php if (!empty($user['cv_file'])): ?>
                    <div style="background:#f0fdf8;border:1px solid #c8f0e0;border-radius:6px;padding:12px 16px;margin-bottom:14px;display:flex;align-items:center;gap:12px">
                         <i class="fa fa-file-text-o" style="color:#29ca8e;font-size:20px"></i>
                         <div>
                              <div style="font-size:13px;font-weight:700;color:#252525">Current CV</div>
                              <div style="font-size:12px;color:#aaa"><?php echo clean($user['cv_file']); ?></div>
                         </div>
                    </div>
                    <?php endif; ?>
                    <div class="upload-zone" style="padding:20px">
                         <input type="file" name="cv_file" accept=".pdf,.doc,.docx">
                         <i class="fa fa-cloud-upload" style="color:#ccc;font-size:24px;display:block;margin-bottom:6px"></i>
                         <div style="font-size:13px;color:#aaa">Click to upload CV</div>
                         <div style="font-size:11px;color:#ccc;margin-top:3px">PDF, DOC, DOCX — max 5MB</div>
                    </div>
               </div>

               <!-- Change Password -->
               <div class="profile-card">
                    <h4><i class="fa fa-lock"></i> Change Password <small style="font-weight:400;color:#aaa">(leave blank to keep current)</small></h4>
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
