<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="jg-page-hero"><br>
    <div class="jg-page-hero__photo"></div>
    <div class="jg-page-hero__overlay"></div>
    <div class="container jg-page-hero__inner">
        <div class="jg-breadcrumb">
            <a href="<?= SITE_URL ?>/">Home</a>
            <i class="fa fa-angle-right"></i>
            <span>Dashboard</span>
        </div>
        <h1 class="jg-page-hero__title">Dashboard</h1>
        <p class="jg-page-hero__sub">Track every application, status, and deadline in one place.</p>
    </div>
</div>
<section class="dashboard-bg">
     <div class="container">
          <div class="row g-4">
               <div class="col-md-4">
                    <div class="premium-card">
                         <div>
                              <a href="<?= SITE_URL ?>/seeker/profile" class="btn btn-soft rounded-pill px-4 py-2" style="font-size: 14px;">Edit Profile</a>
                         </div><br>
                         <h6 class="card-header-title mb-4"><i class="fa fa-bolt" style="color: #0a65cc;"></i> Profile Strength</h6>
                         <div class="d-flex justify-content-between mb-2">
                              <small class="text-muted fw-bold">Completion</small>
                              <small class="text-success fw-bold"><?= $data['strength'] ?>%</small>
                         </div>
                         <div class="progress mb-4" style="height: 8px; border-radius: 8px; background-color: #e2e8f0;">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $data['strength'] ?>%; border-radius: 8px;"></div>
                         </div>
                         <?php if ($data['strength'] < 100): ?>
                              <div class="alert alert-warning border-0 d-flex align-items-start gap-2 p-3 mb-0" style="background: #fffbeb; border-radius: 8px;">
                                   <i class="fa fa-lightbulb-o mt-1" style="color: #b6b624;"></i>
                                   <small class="text-dark" style="line-height: 1.5;">Add more information to reach 100% and stand out to employers!</small>
                              </div>
                         <?php endif; ?>
                         
                    </div>

                    <div class="stat-box">
                         <h1 style="color:white;"><?= $data['totalApplied'] ?? 0 ?></h1>
                         <p>Total Applications</p>
                    </div>

               </div>

               <div class="col-md-8">

                    <div class="premium-card">
                         <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                              <h6 class="card-header-title"><i class="fa fa-history" style="color: #084fa3;"></i> Recent Activity</h6>
                              <a href="<?= SITE_URL ?>/seeker/applications" class="text-decoration-none" style="font-size: 13px; color: #084fa3; font-weight: 600;">View All</a>
                         <table class="jg-apps-table">
                         <thead>
                              <tr>
                                   <th>Company</th>
                                   <th>Job Title</th>
                                   <th>Status</th>
                                   <th>Applied Date</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php if (!empty($recentApps)): ?>
                                   <?php foreach ($recentApps as $app): ?>
                                        <tr>
                                             <!-- Company -->
                                             <td>
                                             <div style="display:flex; align-items:center; gap:10px;">
                                                  <?php if (!empty($app['company_logo'])): ?>
                                                       <img src="<?= SITE_URL ?>/uploads/logos/<?= htmlspecialchars($app['company_logo']) ?>" class="company-logo" alt="">
                                                  <?php else: ?>
                                                       <div class="company-initial">
                                                            <?= strtoupper(substr($app['company_name'] ?? 'C', 0, 1)) ?>
                                                       </div>
                                                  <?php endif; ?>
                                                  <span><?= htmlspecialchars($app['company_name'] ?? 'N/A') ?></span>
                                             </div>
                                             </td>
                                             <!-- Job Title -->
                                             <td><?= htmlspecialchars($app['job_title']) ?></td>
                                             <!-- Status -->
                                             <td>
                                                  <span class="date-text"><?= htmlspecialchars($app['status']) ?></span>
                                             </td>
                                             <!-- Date -->
                                             <td>
                                             <?= date('M d, Y', strtotime($app['applied_at'])) ?>
                                             </td>
                                        </tr>
                                   <?php endforeach; ?>
                              <?php else: ?>
                                   <tr>
                                        <td colspan="4" style="text-align:center;">No recent applications</td>
                                   </tr>
                              <?php endif; ?>
                         </tbody>
                         </table>
                         </div>
                         <div class="text-center py-5">
                              <a href="<?= SITE_URL ?>/jobs" class="btn btn-success rounded-pill px-4 shadow-sm" style="background: #0a65cc; border:none;">Browse New Jobs</a>
                         </div>
                    </div>
                    
               </div>
               <div class="premium-card">
                    <h6 class="card-header-title mb-2"><i class="fa fa-star" style="color: #1360be;"></i> Recommended Jobs</h6>
                    <?php if (!empty($jobs)): ?>
                    <table class="jg-apps-table">
                         <thead>
                              <tr>
                                   <th>Job Title</th>
                                   <th>Company</th>
                                   <th>Location</th>
                                   <th>Type</th>
                                   <th class="text-center">Action</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php foreach ($jobs as $job): ?>
                                   <tr>
                                        <td>
                                             <span><?= htmlspecialchars($job['title']) ?></span>
                                        </td>
                                        <td>
                                             <?= htmlspecialchars($job['company_name'] ?? 'N/A') ?>
                                        </td>

                                        <td>
                                             <?= htmlspecialchars($job['location_city']) ?>,
                                             <?= htmlspecialchars($job['location_country']) ?>
                                        </td>
                                        <td>
                                             <span class="badge bg-rounded-pill" style="background: #e2e8f0; color: #334155; font-size: 13px;">
                                             <?= htmlspecialchars($job['job_type']) ?>
                                             </span>
                                        </td>
                                        <td class="text-center">
                                             <a href="<?= SITE_URL ?>/jobs/<?= $job['id'] ?>" class="btn btn-sm btn-light-blue">View Details</a>
                                        </td>
                                   </tr>
                              <?php endforeach; ?>
                         </tbody>
                    </table>
                    <?php else: ?>
                    <p>No recommended jobs found.</p>
                    <?php endif; ?> 
               </div>
          </div>
     </div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>