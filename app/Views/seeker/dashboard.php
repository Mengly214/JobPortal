<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<style>
     /* 1. Base Background */
     .dashboard-bg {
          background-color: #f8fafc;
          /* Slightly cooler, cleaner gray */
          min-height: 80vh;
          padding: 40px 0;
          font-family: 'Inter', system-ui, -apple-system, sans-serif;
     }

     /* 2. Premium Card Styling */
     .premium-card {
          background: #ffffff;
          border-radius: 12px;
          border: 1px solid #e2e8f0;
          /* Crisp, light border */
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
          padding: 24px;
          margin-bottom: 24px;
          height: 100%;
          display: flex;
          flex-direction: column;
     }

     /* 3. The Green Stat Box */
     .stat-box {
          background: linear-gradient(135deg, #10b981, #059669);
          /* Richer emerald green */
          color: white;
          border-radius: 12px;
          padding: 30px 20px;
          text-align: center;
          box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
          margin-bottom: 24px;
          display: flex;
          flex-direction: column;
          justify-content: center;
          height: 140px;
     }

     .stat-box h1 {
          font-size: 3.5rem;
          font-weight: 800;
          margin-bottom: 0;
          line-height: 1;
     }

     .stat-box p {
          font-size: 12px;
          font-weight: 700;
          letter-spacing: 1.5px;
          margin-top: 8px;
          text-transform: uppercase;
          opacity: 0.9;
          margin-bottom: 0;
     }

     /* 4. Soft action buttons */
     .btn-soft {
          background-color: #ecfdf5;
          color: #059669;
          font-weight: 600;
          border: 1px solid #a7f3d0;
          transition: 0.2s;
     }

     .btn-soft:hover {
          background-color: #10b981;
          color: white;
     }

     /* Custom List Item for Jobs */
     .job-list-item {
          display: flex;
          align-items: center;
          padding: 16px 0;
          border-bottom: 1px solid #f1f5f9;
     }

     .job-list-item:last-child {
          border-bottom: none;
          padding-bottom: 0;
     }

     .card-header-title {
          font-size: 16px;
          font-weight: 700;
          color: #1e293b;
          margin: 0;
          display: flex;
          align-items: center;
          gap: 8px;
     }
</style>

<section class="dashboard-bg">
     <div class="container">

          <div class="row mb-4">
               <div class="col-12">
                    <div class="premium-card" style="padding: 20px 24px; flex-direction: row; justify-content: space-between; align-items: center; height: auto;">
                         <div class="d-flex align-items-center gap-3">
                              <div style="width: 56px; height: 56px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                   <i class="fa fa-user text-success" style="font-size: 20px;"></i>
                              </div>
                              <div>
                                   <h3 class="fw-bold mb-1" style="font-size: 20px; color: #0f172a;">Welcome back! 👋</h3>
                                   <p class="text-muted mb-0" style="font-size: 14px;"><?= htmlspecialchars($_SESSION['email']) ?></p>
                              </div>
                         </div>
                         <div>
                              <a href="<?= SITE_URL ?>/seeker/profile" class="btn btn-soft rounded-pill px-4 py-2" style="font-size: 14px;">Edit Profile</a>
                         </div>
                    </div>
               </div>
          </div>

          <div class="row g-4">
               <div class="col-md-4">

                    <div class="premium-card">
                         <h6 class="card-header-title mb-4"><i class="fa fa-bolt text-warning"></i> Profile Strength</h6>
                         <div class="d-flex justify-content-between mb-2">
                              <small class="text-muted fw-bold">Completion</small>
                              <small class="text-success fw-bold"><?= $data['strength'] ?>%</small>
                         </div>
                         <div class="progress mb-4" style="height: 8px; border-radius: 8px; background-color: #e2e8f0;">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $data['strength'] ?>%; border-radius: 8px;"></div>
                         </div>
                         <?php if ($data['strength'] < 100): ?>
                              <div class="alert alert-warning border-0 d-flex align-items-start gap-2 p-3 mb-0" style="background: #fffbeb; border-radius: 8px;">
                                   <i class="fa fa-lightbulb-o text-warning mt-1"></i>
                                   <small class="text-dark" style="line-height: 1.5;">Add your CV to reach 100% and stand out to employers!</small>
                              </div>
                         <?php endif; ?>
                    </div>

                    <div class="stat-box">
                         <h1><?= $data['totalApplied'] ?? 0 ?></h1>
                         <p>Total Applications</p>
                    </div>

               </div>

               <div class="col-md-8">

                    <div class="premium-card">
                         <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                              <h6 class="card-header-title"><i class="fa fa-history text-primary"></i> Recent Activity</h6>
                              <a href="<?= SITE_URL ?>/seeker/applications" class="text-decoration-none" style="font-size: 13px; color: #059669; font-weight: 600;">View All</a>
                         </div>

                         <div class="text-center py-5">
                              <div class="mb-3">
                                   <i class="fa fa-search" style="font-size: 40px; color: #cbd5e1;"></i>
                              </div>
                              <h6 class="fw-bold text-dark mb-2">Keep exploring!</h6>
                              <p class="text-muted small mb-4">Check out our latest jobs to find your next opportunity.</p>
                              <a href="<?= SITE_URL ?>/jobs" class="btn btn-success rounded-pill px-4 shadow-sm" style="background: #10b981; border:none;">Browse New Jobs</a>
                         </div>
                    </div>

                    <div class="premium-card">
                         <h6 class="card-header-title mb-2"><i class="fa fa-star text-warning"></i> Recommended Jobs</h6>

                         <div class="job-list-item">
                              <div style="width: 48px; height: 48px; background: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                   <i class="fa fa-code text-primary"></i>
                              </div>
                              <div class="flex-grow-1 px-3">
                                   <h6 class="mb-1 fw-bold" style="font-size: 15px; color: #1e293b;">Senior Web Developer</h6>
                                   <p class="text-muted small mb-0"><i class="fa fa-map-marker me-1"></i> Krong Poi Pet</p>
                              </div>
                              <a href="<?= SITE_URL ?>/jobs" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size: 12px; font-weight: 600;">View</a>
                         </div>

                         <div class="job-list-item">
                              <div style="width: 48px; height: 48px; background: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                   <i class="fa fa-paint-brush text-danger"></i>
                              </div>
                              <div class="flex-grow-1 px-3">
                                   <h6 class="mb-1 fw-bold" style="font-size: 15px; color: #1e293b;">UI/UX Designer</h6>
                                   <p class="text-muted small mb-0"><i class="fa fa-map-marker me-1"></i> Remote</p>
                              </div>
                              <a href="<?= SITE_URL ?>/jobs" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size: 12px; font-weight: 600;">View</a>
                         </div>

                    </div>

               </div>
          </div>
     </div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>