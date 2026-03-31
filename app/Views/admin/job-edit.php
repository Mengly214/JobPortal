<?php require BASE_PATH . '/app/Views/layouts/admin-header.php'; ?>

<div class="pg-bar">
     <h2><i class="fa fa-pencil"></i> Edit Job</h2>
     <div style="display:flex;gap:8px">
          <a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-external-link"></i> Preview</a>
          <a href="<?php echo SITE_URL; ?>/admin/jobs" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Jobs</a>
     </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?></div>
<?php endif; ?>

<div class="adm-card" style="padding:24px">
     <form method="post" action="<?php echo SITE_URL; ?>/admin/jobs/edit/<?php echo $job['id']; ?>" enctype="multipart/form-data">

          <!-- Basic Info -->
          <div class="adm-card" style="padding:18px;margin-bottom:20px;border-top:2px solid #29ca8e">
               <h4 style="margin:0 0 16px;font-size:14px;color:#252525"><i class="fa fa-info-circle" style="color:#29ca8e;margin-right:6px"></i> Basic Information</h4>
               <div class="row">
                    <div class="col-md-8">
                         <div class="form-group">
                              <label>Job Title <span style="color:red">*</span></label>
                              <input type="text" name="title" class="form-control"
                                     value="<?php echo htmlspecialchars($job['title'] ?? ''); ?>" required>
                         </div>
                    </div>
                    <div class="col-md-4">
                         <div class="form-group">
                              <label>Category</label>
                              <select name="category_id" class="form-control">
                                   <option value="0">-- Select Category --</option>
                                   <?php foreach ($categories as $cat): ?>
                                   <option value="<?php echo $cat['id']; ?>"
                                        <?php echo (int)($job['category_id'] ?? 0) === (int)$cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo clean($cat['name']); ?>
                                   </option>
                                   <?php endforeach; ?>
                              </select>
                         </div>
                    </div>
               </div>
               <div class="form-group">
                    <label>Job Description <span style="color:red">*</span></label>
                    <textarea name="description" class="form-control" rows="6" required><?php echo htmlspecialchars($job['description'] ?? ''); ?></textarea>
               </div>
               <div class="form-group">
                    <label>Requirements</label>
                    <textarea name="requirements" class="form-control" rows="4"><?php echo htmlspecialchars($job['requirements'] ?? ''); ?></textarea>
               </div>
               <div class="form-group">
                    <label>Benefits</label>
                    <textarea name="benefits" class="form-control" rows="3"><?php echo htmlspecialchars($job['benefits'] ?? ''); ?></textarea>
               </div>
          </div>

          <!-- Job Details -->
          <div class="adm-card" style="padding:18px;margin-bottom:20px;border-top:2px solid #3f51b5">
               <h4 style="margin:0 0 16px;font-size:14px;color:#252525"><i class="fa fa-briefcase" style="color:#3f51b5;margin-right:6px"></i> Job Details</h4>
               <div class="row">
                    <div class="col-md-3">
                         <div class="form-group">
                              <label>Job Type <span style="color:red">*</span></label>
                              <select name="job_type" class="form-control" required>
                                   <option value="">-- Select --</option>
                                   <?php foreach (['full-time'=>'Full Time','part-time'=>'Part Time','contract'=>'Contract','freelance'=>'Freelance','internship'=>'Internship'] as $v=>$l): ?>
                                   <option value="<?php echo $v; ?>" <?php echo ($job['job_type'] ?? '') === $v ? 'selected' : ''; ?>><?php echo $l; ?></option>
                                   <?php endforeach; ?>
                              </select>
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="form-group">
                              <label>Work Mode</label>
                              <select name="work_mode" class="form-control">
                                   <?php foreach (['on-site'=>'On-site','remote'=>'Remote','hybrid'=>'Hybrid'] as $v=>$l): ?>
                                   <option value="<?php echo $v; ?>" <?php echo ($job['work_mode'] ?? '') === $v ? 'selected' : ''; ?>><?php echo $l; ?></option>
                                   <?php endforeach; ?>
                              </select>
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="form-group">
                              <label>Experience Level</label>
                              <select name="experience_level" class="form-control">
                                   <?php foreach (['entry'=>'Entry Level','mid'=>'Mid Level','senior'=>'Senior Level','lead'=>'Lead / Manager'] as $v=>$l): ?>
                                   <option value="<?php echo $v; ?>" <?php echo ($job['experience_level'] ?? '') === $v ? 'selected' : ''; ?>><?php echo $l; ?></option>
                                   <?php endforeach; ?>
                              </select>
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="form-group">
                              <label>Application Deadline</label>
                              <input type="date" name="application_deadline" class="form-control"
                                     value="<?php echo htmlspecialchars($job['deadline'] ?? ''); ?>">
                         </div>
                    </div>
               </div>
          </div>

          <!-- Salary & Location -->
          <div class="adm-card" style="padding:18px;margin-bottom:20px;border-top:2px solid #009688">
               <h4 style="margin:0 0 16px;font-size:14px;color:#252525"><i class="fa fa-map-marker" style="color:#009688;margin-right:6px"></i> Salary & Location</h4>
               <div class="row">
                    <div class="col-md-2">
                         <div class="form-group">
                              <label>Currency</label>
                              <select name="salary_currency" class="form-control">
                                   <?php foreach (['USD','EUR','GBP','KHR'] as $c): ?>
                                   <option value="<?php echo $c; ?>" <?php echo ($job['salary_currency'] ?? 'USD') === $c ? 'selected' : ''; ?>><?php echo $c; ?></option>
                                   <?php endforeach; ?>
                              </select>
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="form-group">
                              <label>Salary Min</label>
                              <input type="number" name="salary_min" class="form-control" min="0"
                                     value="<?php echo (int)($job['salary_min'] ?? 0); ?>">
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="form-group">
                              <label>Salary Max</label>
                              <input type="number" name="salary_max" class="form-control" min="0"
                                     value="<?php echo (int)($job['salary_max'] ?? 0); ?>">
                         </div>
                    </div>
                    <div class="col-md-2">
                         <div class="form-group">
                              <label>City <span style="color:red">*</span></label>
                              <input type="text" name="location_city" class="form-control"
                                     value="<?php echo htmlspecialchars($job['location_city'] ?? ''); ?>" required>
                         </div>
                    </div>
                    <div class="col-md-2">
                         <div class="form-group">
                              <label>Country</label>
                              <input type="text" name="location_country" class="form-control"
                                     value="<?php echo htmlspecialchars($job['location_country'] ?? ''); ?>">
                         </div>
                    </div>
               </div>
          </div>

          <!-- Job Image -->
          <div class="adm-card" style="padding:18px;margin-bottom:20px;border-top:2px solid #e53935">
               <h4 style="margin:0 0 16px;font-size:14px;color:#252525"><i class="fa fa-image" style="color:#e53935;margin-right:6px"></i> Job Image</h4>
               <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                              <label>Upload New Image <small class="text-muted">(leave blank to keep current)</small></label>
                              <input type="file" name="job_image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" id="job-img-input">
                         </div>
                    </div>
                    <div class="col-md-6">
                         <label>Current Image</label><br>
                         <?php if (!empty($job['job_image'])): ?>
                         <img id="image-preview" src="<?php echo SITE_URL; ?>/uploads/jobs/<?php echo htmlspecialchars($job['job_image']); ?>"
                              style="max-height:120px;border-radius:4px;border:1px solid #eee;padding:4px">
                         <?php else: ?>
                         <img id="image-preview" src="" style="max-height:120px;border-radius:4px;border:1px solid #eee;padding:4px;display:none">
                         <span class="text-muted" id="no-img-txt">No image uploaded</span>
                         <?php endif; ?>
                    </div>
               </div>
               <script>
               document.getElementById('job-img-input').addEventListener('change', function() {
                    var file = this.files[0];
                    if (file) {
                         var reader = new FileReader();
                         reader.onload = function(e) {
                              var preview = document.getElementById('image-preview');
                              preview.src = e.target.result;
                              preview.style.display = 'block';
                              var noImg = document.getElementById('no-img-txt');
                              if (noImg) noImg.style.display = 'none';
                         };
                         reader.readAsDataURL(file);
                    }
               });
               </script>
          </div>

          <!-- Publishing -->
          <div class="adm-card" style="padding:18px;margin-bottom:20px;border-top:2px solid #f57c00">
               <h4 style="margin:0 0 16px;font-size:14px;color:#252525"><i class="fa fa-bullhorn" style="color:#f57c00;margin-right:6px"></i> Publishing</h4>
               <div class="row">
                    <div class="col-md-4">
                         <div class="form-group">
                              <label>Status</label>
                              <select name="status" class="form-control">
                                   <?php foreach (['active'=>'Active — visible on site','draft'=>'Draft — hidden','paused'=>'Paused','closed'=>'Closed'] as $v=>$l): ?>
                                   <option value="<?php echo $v; ?>" <?php echo ($job['status'] ?? '') === $v ? 'selected' : ''; ?>><?php echo $l; ?></option>
                                   <?php endforeach; ?>
                              </select>
                         </div>
                    </div>
                    <div class="col-md-4">
                         <div class="form-group">
                              <label>Employer ID</label>
                              <input type="number" name="employer_id" class="form-control" min="0"
                                     value="<?php echo (int)($job['employer_id'] ?? 0); ?>">
                         </div>
                    </div>
                    <div class="col-md-4">
                         <div class="form-group" style="padding-top:24px">
                              <label>
                                   <input type="checkbox" name="is_featured" value="1"
                                          <?php echo !empty($job['is_featured']) ? 'checked' : ''; ?>>
                                   &nbsp; Mark as Featured Job
                              </label>
                         </div>
                    </div>
               </div>
          </div>

          <div style="display:flex;gap:10px">
               <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save Changes</button>
               <a href="<?php echo SITE_URL; ?>/admin/jobs" class="btn btn-default">Cancel</a>
               <a href="<?php echo SITE_URL; ?>/jobs/<?php echo $job['id']; ?>" target="_blank"
                  class="btn btn-default" style="margin-left:auto"><i class="fa fa-external-link"></i> Preview Job</a>
          </div>

     </form>
</div>

<?php require BASE_PATH . '/app/Views/layouts/admin-footer.php'; ?>