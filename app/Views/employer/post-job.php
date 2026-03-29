<?php
// Safety defaults — ensure variables are always defined regardless of how the view is called
$old      = $old      ?? [];
$job      = $job      ?? null;
$editMode = $editMode ?? false;
$error    = $error    ?? '';
$success  = $success  ?? '';
?>
<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero" style="background:linear-gradient(135deg,rgba(10,22,40,.88),rgba(10,101,204,.82)),url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1400&q=60&fit=crop') center/cover no-repeat;margin-top:-70px;padding-top:150px;padding-bottom:52px">
    <div class="container" style="position:relative;z-index:2">
        <div class="jg-breadcrumb"><a href="<?= SITE_URL ?>/">Home</a> <i class="fa fa-angle-right"></i> <a href="<?= SITE_URL ?>/employer/jobs">My Jobs</a> <i class="fa fa-angle-right"></i> <span><?= $editMode ? 'Edit Job' : 'Post a Job' ?></span></div>
        <h1 class="jg-page-hero__title"><?= $editMode ? 'Edit Job Listing' : 'Post a New Job' ?></h1>
        <p style="color:rgba(255,255,255,.72);margin:0;font-size:16px"><?= $editMode ? 'Update your job details below' : 'Fill in the details to attract the best candidates' ?></p>
    </div>
</div>

<section style="padding:36px 0 70px;background:#f5f7fb">
<div class="container">
<div class="row">

    <!-- FORM -->
    <div class="col-md-8">
        <?php if ($error):   ?><div class="pj-alert pj-alert--danger"><i class="fa fa-exclamation-circle"></i> <?= $error ?></div><?php endif; ?>
        <?php if ($success): ?><div class="pj-alert pj-alert--success"><i class="fa fa-check-circle"></i> <?= $success ?>
            <a href="<?= SITE_URL ?>/employer/jobs" style="margin-left:12px;font-weight:700">← View My Jobs</a>
        </div><?php endif; ?>

        <?php
        $v = function($key) use ($old, $job) {
            if (!empty($old[$key])) return htmlspecialchars($old[$key]);
            if ($job && isset($job[$key])) return htmlspecialchars($job[$key]);
            return '';
        };
        $sel = function($key, $val) use ($old, $job) {
            $cur = !empty($old[$key]) ? $old[$key] : ($job[$key] ?? '');
            return $cur == $val ? 'selected' : '';
        };
        $chk = function($key) use ($old, $job) {
            if (!empty($old)) return isset($old[$key]) ? 'checked' : '';
            return (!empty($job[$key])) ? 'checked' : '';
        };
        $formAction = $editMode ? SITE_URL.'/employer/jobs/edit/'.$job['id'] : SITE_URL.'/employer/jobs/create';
        ?>

        <form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data">

            <!-- BASIC INFO -->
            <div class="pj-card">
                <h4 class="pj-card__title"><i class="fa fa-info-circle"></i> Basic Information</h4>
                <div class="pj-field">
                    <label>Job Title <span class="req">*</span></label>
                    <input type="text" name="title" class="pj-input" placeholder="e.g. Senior Software Engineer" value="<?= $v('title') ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>Category</label>
                            <select name="category_id" class="pj-input">
                                <option value="">— Select Category —</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $sel('category_id', $cat['id']) ?>><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>Experience Level</label>
                            <select name="experience_level" class="pj-input">
                                <option value="">— Select —</option>
                                <?php foreach(['entry'=>'Entry Level','mid'=>'Mid Level','senior'=>'Senior Level','executive'=>'Executive'] as $v2=>$l): ?>
                                <option value="<?= $v2 ?>" <?= $sel('experience_level',$v2) ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JOB DETAILS -->
            <div class="pj-card">
                <h4 class="pj-card__title"><i class="fa fa-file-text-o"></i> Job Details</h4>
                <div class="pj-field">
                    <label>Job Description <span class="req">*</span></label>
                    <textarea name="description" class="pj-input pj-textarea" rows="8" placeholder="Describe the role, responsibilities, and what makes it exciting..." required><?= $v('description') ?></textarea>
                </div>
                <div class="pj-field">
                    <label>Requirements</label>
                    <textarea name="requirements" class="pj-input pj-textarea" rows="5" placeholder="List qualifications, skills and experience required..."><?= $v('requirements') ?></textarea>
                </div>
                <div class="pj-field">
                    <label>Benefits</label>
                    <textarea name="benefits" class="pj-input pj-textarea" rows="4" placeholder="Health insurance, remote work, stock options, paid leave..."><?= $v('benefits') ?></textarea>
                </div>
            </div>

            <!-- JOB TYPE & LOCATION -->
            <div class="pj-card">
                <h4 class="pj-card__title"><i class="fa fa-map-marker"></i> Type &amp; Location</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>Job Type</label>
                            <select name="job_type" class="pj-input">
                                <?php foreach(['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contract','freelance'=>'Freelance','internship'=>'Internship'] as $v2=>$l): ?>
                                <option value="<?= $v2 ?>" <?= $sel('job_type',$v2) ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>Work Mode</label>
                            <select name="work_mode" class="pj-input">
                                <?php foreach(['on_site'=>'On Site','remote'=>'Remote','hybrid'=>'Hybrid'] as $v2=>$l): ?>
                                <option value="<?= $v2 ?>" <?= $sel('work_mode',$v2) ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>City / Location</label>
                            <input type="text" name="location_city" class="pj-input" placeholder="e.g. New York" value="<?= $v('location_city') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>Country</label>
                            <input type="text" name="location_country" class="pj-input" placeholder="e.g. USA" value="<?= $v('location_country') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SALARY -->
            <div class="pj-card">
                <h4 class="pj-card__title"><i class="fa fa-money"></i> Salary</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="pj-field">
                            <label>Currency</label>
                            <select name="salary_currency" class="pj-input">
                                <?php foreach(['USD'=>'USD ($)','EUR'=>'EUR (€)','GBP'=>'GBP (£)','KHR'=>'KHR (៛)'] as $v2=>$l): ?>
                                <option value="<?= $v2 ?>" <?= $sel('salary_currency',$v2) ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pj-field">
                            <label>Min Salary</label>
                            <input type="number" name="salary_min" class="pj-input" placeholder="e.g. 30000" value="<?= $v('salary_min') ?>" min="0">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pj-field">
                            <label>Max Salary</label>
                            <input type="number" name="salary_max" class="pj-input" placeholder="e.g. 60000" value="<?= $v('salary_max') ?>" min="0">
                        </div>
                    </div>
                </div>
                <p class="pj-hint">Leave salary blank to hide from listing</p>
            </div>

            <!-- SETTINGS -->
            <div class="pj-card">
                <h4 class="pj-card__title"><i class="fa fa-cog"></i> Settings</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>Status</label>
                            <select name="status" class="pj-input">
                                <option value="active" <?= $sel('status','active') ?>>Active — visible to seekers</option>
                                <option value="draft"  <?= $sel('status','draft')  ?>>Draft — save for later</option>
                                <?php if ($editMode): ?>
                                <option value="closed" <?= $sel('status','closed') ?>>Closed</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pj-field">
                            <label>Application Deadline</label>
                            <input type="date" name="deadline" class="pj-input" value="<?= $v('deadline') ?>">
                        </div>
                    </div>
                </div>
                <div class="pj-field">
                    <label class="pj-checkbox">
                        <input type="checkbox" name="is_featured" value="1" <?= $chk('is_featured') ?>>
                        <span class="pj-checkbox__box"></span>
                        <div>
                            <strong>Featured Job</strong>
                            <span>Show this job in the featured section on the homepage</span>
                        </div>
                    </label>
                </div>

                <!-- Job Image -->
                <div class="pj-field">
                    <label>Job Cover Image <span style="color:#aaa;font-weight:400">(optional — JPG, PNG, max 3MB)</span></label>
                    <?php if ($editMode && !empty($job['job_image'])): ?>
                    <div class="pj-current-image">
                        <img src="<?= SITE_URL.'/uploads/jobs/'.clean($job['job_image']) ?>" alt="">
                        <span>Current image</span>
                    </div>
                    <?php endif; ?>
                    <div class="pj-upload-zone" id="img-zone">
                        <input type="file" name="job_image" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this)">
                        <i class="fa fa-cloud-upload"></i>
                        <p>Click or drag to upload a cover image</p>
                        <small>Recommended: 1200×630px</small>
                        <span id="img-name" class="pj-upload-name"></span>
                    </div>
                    <img id="img-preview" style="display:none;max-height:160px;border-radius:8px;margin-top:10px;object-fit:cover;width:100%" alt="">
                </div>
            </div>

            <!-- SUBMIT -->
            <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
                <button type="submit" class="jg-btn jg-btn--primary" style="padding:13px 32px;font-size:15px">
                    <i class="fa fa-<?= $editMode ? 'save' : 'paper-plane' ?>"></i>
                    <?= $editMode ? 'Save Changes' : 'Post Job' ?>
                </button>
                <a href="<?= SITE_URL ?>/employer/jobs" class="jg-btn" style="border:2px solid #e0e6f0;color:#555;background:#fff;padding:12px 24px">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- SIDEBAR TIPS -->
    <div class="col-md-4">
        <div class="pj-tips">
            <h5><i class="fa fa-lightbulb-o"></i> Tips for a Great Listing</h5>
            <ul>
                <li><strong>Clear title</strong> — Use the exact job title candidates search for</li>
                <li><strong>Detailed description</strong> — Describe the day-to-day role clearly</li>
                <li><strong>List requirements</strong> — Separate must-haves from nice-to-haves</li>
                <li><strong>Show salary</strong> — Listings with salary get 3× more applicants</li>
                <li><strong>Add benefits</strong> — Perks attract top talent</li>
                <li><strong>Set deadline</strong> — Creates urgency for applicants</li>
            </ul>
        </div>

        <div class="pj-tips pj-tips--blue" style="margin-top:16px">
            <h5><i class="fa fa-star"></i> Featured Jobs</h5>
            <p>Featured jobs appear on the homepage and receive up to <strong>5× more views</strong> than standard listings.</p>
        </div>

        <?php if ($editMode && !empty($job)): ?>
        <div class="pj-tips" style="margin-top:16px">
            <h5><i class="fa fa-bar-chart"></i> Job Stats</h5>
            <div style="display:flex;flex-direction:column;gap:10px;margin-top:4px">
                <div class="pj-stat-row"><span>Views</span><strong><?= number_format($job['views']??0) ?></strong></div>
                <div class="pj-stat-row"><span>Status</span><strong><?= ucfirst($job['status']) ?></strong></div>
                <div class="pj-stat-row"><span>Posted</span><strong><?= date('d M Y',strtotime($job['created_at'])) ?></strong></div>
            </div>
            <a href="<?= SITE_URL ?>/employer/applications?job=<?= $job['id'] ?>" class="jg-btn jg-btn--outline jg-btn--sm" style="margin-top:14px;width:100%;justify-content:center">
                <i class="fa fa-file-text"></i> View Applications
            </a>
        </div>
        <?php endif; ?>
    </div>

</div>
</div>
</section>

<style>
.jg-page-hero__title{font-size:32px;font-weight:800;color:#fff;margin:0 0 8px;letter-spacing:-.5px}
.jg-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.55);margin-bottom:12px}
.jg-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none}.jg-breadcrumb a:hover{color:#fff}
.jg-breadcrumb i{font-size:10px}.jg-breadcrumb span{color:rgba(255,255,255,.85)}
.pj-alert{padding:14px 18px;border-radius:10px;font-size:14px;margin-bottom:20px;display:flex;align-items:center;gap:10px}
.pj-alert--success{background:#e8f5e9;color:#2e7d32;border-left:4px solid #4caf50}
.pj-alert--danger{background:#fdecea;color:#c62828;border-left:4px solid #f44336}
.pj-card{background:#fff;border-radius:14px;border:1.5px solid #e8edf5;padding:24px;margin-bottom:20px;box-shadow:0 2px 10px rgba(10,50,120,.04)}
.pj-card__title{font-size:15px;font-weight:700;color:#1a1a2e;margin:0 0 20px;padding-bottom:14px;border-bottom:1px solid #f0f4f9;display:flex;align-items:center;gap:8px}
.pj-card__title i{color:#0a65cc}
.pj-field{margin-bottom:18px}
.pj-field label{display:block;font-size:13px;font-weight:600;color:#555;margin-bottom:7px}
.req{color:#e53935}
.pj-input{width:100%;border:1.5px solid #e8edf5;border-radius:8px;padding:11px 14px;font-size:14px;outline:none;transition:.2s;background:#fafbfd;color:#444;box-sizing:border-box}
.pj-input:focus{border-color:#0a65cc;background:#fff;box-shadow:0 0 0 3px rgba(10,101,204,.08)}
select.pj-input{cursor:pointer;height:44px}
.pj-textarea{resize:vertical;min-height:80px;line-height:1.6}
.pj-hint{font-size:12px;color:#aaa;margin-top:4px}
.pj-upload-zone{border:2px dashed #e0e6f0;border-radius:10px;padding:24px;text-align:center;cursor:pointer;transition:.2s;position:relative;background:#fafbfd}
.pj-upload-zone:hover{border-color:#0a65cc;background:#f0f5ff}
.pj-upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.pj-upload-zone i{font-size:28px;color:#c5d5e8;display:block;margin-bottom:8px}
.pj-upload-zone p{margin:0;font-size:13px;color:#aaa}
.pj-upload-zone small{font-size:11px;color:#c5d5e8}
.pj-upload-name{display:none;font-size:12px;color:#14a077;font-weight:700;margin-top:6px;display:block}
.pj-current-image{display:flex;align-items:center;gap:12px;background:#f0f5ff;border:1px solid #c8daf9;border-radius:8px;padding:10px 14px;margin-bottom:12px}
.pj-current-image img{width:60px;height:40px;border-radius:4px;object-fit:cover}
.pj-current-image span{font-size:12px;color:#555}
.pj-checkbox{display:flex;align-items:flex-start;gap:12px;cursor:pointer;padding:14px;border:1.5px solid #e8edf5;border-radius:10px;transition:.2s}
.pj-checkbox:hover{border-color:#0a65cc;background:#f8fbff}
.pj-checkbox input{display:none}
.pj-checkbox__box{width:20px;height:20px;min-width:20px;border-radius:6px;border:2px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;transition:.2s;margin-top:1px}
.pj-checkbox input:checked ~ .pj-checkbox__box{background:#0a65cc;border-color:#0a65cc}
.pj-checkbox input:checked ~ .pj-checkbox__box::after{content:'✓';color:#fff;font-size:12px;font-weight:700}
.pj-checkbox div strong{display:block;font-size:14px;color:#1a1a2e}
.pj-checkbox div span{font-size:12px;color:#94a3b8}
/* Tips sidebar */
.pj-tips{background:#fff;border-radius:14px;border:1.5px solid #e8edf5;padding:20px;box-shadow:0 2px 10px rgba(10,50,120,.04)}
.pj-tips--blue{border-color:#c8daf9;background:#f0f5ff}
.pj-tips h5{font-size:14px;font-weight:700;color:#1a1a2e;margin:0 0 14px;display:flex;align-items:center;gap:8px}
.pj-tips h5 i{color:#0a65cc}
.pj-tips ul{margin:0;padding-left:16px;display:flex;flex-direction:column;gap:8px}
.pj-tips ul li{font-size:13px;color:#666;line-height:1.5}
.pj-tips p{font-size:13px;color:#666;margin:0;line-height:1.6}
.pj-stat-row{display:flex;justify-content:space-between;font-size:13px;padding:6px 0;border-bottom:1px solid #f0f4f9}
.pj-stat-row span{color:#64748b}.pj-stat-row strong{color:#1a1a2e}
.jg-btn{display:inline-flex;align-items:center;gap:7px;font-weight:700;text-decoration:none;border-radius:8px;border:2px solid transparent;cursor:pointer;transition:.2s;padding:10px 22px;font-size:14px}
.jg-btn--primary{background:#0a65cc;color:#fff;border-color:#0a65cc}.jg-btn--primary:hover{background:#084fa3;color:#fff}
.jg-btn--outline{background:#fff;color:#0a65cc;border-color:#0a65cc}.jg-btn--outline:hover{background:#0a65cc;color:#fff}
.jg-btn--sm{padding:8px 16px;font-size:13px}
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var n = document.getElementById('img-name');
        var p = document.getElementById('img-preview');
        n.textContent = '✓ ' + input.files[0].name;
        n.style.display = 'block';
        var r = new FileReader();
        r.onload = function(e) { p.src = e.target.result; p.style.display = 'block'; };
        r.readAsDataURL(input.files[0]);
        document.getElementById('img-zone').style.borderColor = '#0a65cc';
    }
}
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
