<?php require BASE_PATH . '/app/Views/layouts/admin-header.php'; ?>

<div class="pg-bar">
     <h2><i class="fa fa-tachometer"></i> Dashboard</h2>
     <span style="color:#999;font-size:13px"><i class="fa fa-clock-o"></i> <?php echo date('D, d M Y — H:i'); ?></span>
</div>

<!-- STAT CARDS -->
<div class="dash-stats">
     <div class="stat-card bg-green">
          <i class="fa fa-briefcase ic"></i>
          <h2><?php echo $stats['active_jobs']; ?></h2>
          <p>Active Jobs</p>
          <a href="<?php echo SITE_URL; ?>/admin/jobs">All <?php echo $stats['total_jobs']; ?> &rarr;</a>
     </div>
     <div class="stat-card bg-blue">
          <i class="fa fa-user ic"></i>
          <h2><?php echo $stats['total_seekers']; ?></h2>
          <p>Job Seekers</p>
          <a href="<?php echo SITE_URL; ?>/admin/users?role=job_seeker">View &rarr;</a>
     </div>
     <div class="stat-card bg-dark">
          <i class="fa fa-building ic"></i>
          <h2><?php echo $stats['total_employers']; ?></h2>
          <p>Employers</p>
          <a href="<?php echo SITE_URL; ?>/admin/users?role=employer">View &rarr;</a>
     </div>
     <div class="stat-card bg-teal">
          <i class="fa fa-file-text ic"></i>
          <h2><?php echo $stats['total_apps']; ?></h2>
          <p>Applications</p>
          <a href="<?php echo SITE_URL; ?>/admin/applications">New: <?php echo $stats['new_apps']; ?> &rarr;</a>
     </div>
     <div class="stat-card bg-red">
          <i class="fa fa-envelope ic"></i>
          <h2><?php echo $stats['unread_messages']; ?></h2>
          <p>Unread Messages</p>
          <a href="<?php echo SITE_URL; ?>/admin/messages">View &rarr;</a>
     </div>
     <div class="stat-card bg-orange">
          <i class="fa fa-newspaper-o ic"></i>
          <h2><?php echo $stats['total_blog']; ?></h2>
          <p>Blog Posts</p>
          <a href="#">View &rarr;</a>
     </div>
</div>

<!-- QUICK ACTIONS -->
<div class="qk-act">
     <strong>Quick Actions:</strong>
     <a href="<?php echo SITE_URL; ?>/admin/jobs"         class="btn btn-primary btn-sm"><i class="fa fa-briefcase"></i> Manage Jobs</a>
     <a href="<?php echo SITE_URL; ?>/admin/users"        class="btn btn-default btn-sm"><i class="fa fa-users"></i> Manage Users</a>
     <a href="<?php echo SITE_URL; ?>/admin/applications" class="btn btn-default btn-sm"><i class="fa fa-file-text"></i> Applications</a>
     <a href="<?php echo SITE_URL; ?>/admin/settings"     class="btn btn-default btn-sm"><i class="fa fa-cog"></i> Settings</a>
     <?php if ($stats['new_apps'] > 0): ?>
     <a href="<?php echo SITE_URL; ?>/admin/applications?status=submitted" class="btn btn-warning btn-sm">
          <i class="fa fa-bell"></i> <?php echo $stats['new_apps']; ?> New Application<?php echo $stats['new_apps'] > 1 ? 's' : ''; ?>
     </a>
     <?php endif; ?>
</div>

<div class="dash-grid-2">

     <!-- RECENT JOBS -->
     <div class="adm-card">
          <div class="card-head">
               <h4><i class="fa fa-briefcase"></i> Recent Jobs</h4>
               <a href="<?php echo SITE_URL; ?>/admin/jobs" class="btn btn-default btn-xs">View All</a>
          </div>
          <table class="table table-hover">
               <thead><tr><th>Title</th><th>Company</th><th>Type</th><th>Status</th><th>Posted</th></tr></thead>
               <tbody>
               <?php if (empty($recentJobs)): ?>
               <tr><td colspan="5" class="text-center text-muted" style="padding:20px">No jobs yet.</td></tr>
               <?php else:
                    $sc = ['active'=>'success','draft'=>'default','closed'=>'danger','paused'=>'warning','expired'=>'warning'];
               ?>
               <?php foreach ($recentJobs as $j): ?>
               <tr>
                    <td><a href="<?php echo SITE_URL; ?>/jobs/<?php echo $j['id']; ?>" target="_blank"><?php echo clean($j['title']); ?></a></td>
                    <td><small><?php echo clean($j['company_name'] ?? '–'); ?></small></td>
                    <td><small><?php echo ucfirst(str_replace('_', ' ', $j['job_type'])); ?></small></td>
                    <td><span class="label label-<?php echo $sc[$j['status']] ?? 'default'; ?>"><?php echo ucfirst($j['status']); ?></span></td>
                    <td><small><?php echo date('d M Y', strtotime($j['created_at'])); ?></small></td>
               </tr>
               <?php endforeach; endif; ?>
               </tbody>
          </table>
     </div>

     <!-- JOBS BY STATUS -->
     <div class="adm-card" style="padding:0">

          <div class="jbs-head">
               <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="8" width="3" height="7" rx="1"/><rect x="6" y="5" width="3" height="10" rx="1"/><rect x="11" y="2" width="3" height="13" rx="1"/></svg>
               Jobs by Status
          </div>

          <?php
          $jbs_colors   = ['active'=>'#29ca8e','draft'=>'#909090','paused'=>'#f57c00','closed'=>'#e53935','expired'=>'#ff9800'];
          $jbs_all      = ['active'=>0,'draft'=>0,'paused'=>0,'closed'=>0,'expired'=>0];
          foreach ($jobsByStatus as $s) {
               $jbs_all[$s['status']] = (int)$s['total'];
          }
          $jbs_total    = max(1, array_sum($jbs_all));
          $jbs_maxC     = max(1, max($jbs_all));
          $jbs_circ     = 2 * M_PI * 30;
          $jbs_active   = $jbs_all['active'];
          $jbs_fillRate = round($jbs_active / $jbs_total * 100);
          $jbs_unused   = count(array_filter($jbs_all, fn($v) => $v === 0));

          // Heatmap: real job posting activity last 28 days
          $conn = $GLOBALS['conn'];
          $heatmap_raw = $conn->query("
               SELECT DATE(created_at) AS day, COUNT(*) AS cnt
               FROM jobs
               WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 28 DAY)
               GROUP BY DATE(created_at)
          ")->fetch_all(MYSQLI_ASSOC);
          $heatmap_days = [];
          foreach ($heatmap_raw as $row) {
               $heatmap_days[$row['day']] = (int)$row['cnt'];
          }
          $heatmap_max = max(1, !empty($heatmap_days) ? max($heatmap_days) : 1);
          ?>

          <div class="jbs-body">

               <!-- Donut + legend -->
               <div class="jbs-donut-row">
                    <div class="jbs-donut-wrap">
                         <svg viewBox="0 0 80 80">
                              <circle cx="40" cy="40" r="30" fill="none" stroke="#f0f0f0" stroke-width="10"/>
                              <?php
                              $offset = 0;
                              foreach ($jbs_all as $status => $count):
                                   $len = $jbs_circ * $count / $jbs_total;
                                   $col = $jbs_colors[$status] ?? '#ccc';
                              ?>
                              <circle cx="40" cy="40" r="30" fill="none"
                                   stroke="<?php echo $col; ?>"
                                   stroke-width="10"
                                   stroke-dasharray="<?php echo round($len, 2); ?> <?php echo round($jbs_circ - $len, 2); ?>"
                                   stroke-dashoffset="<?php echo round(-$offset, 2); ?>"
                                   transform="rotate(-90 40 40)"/>
                              <?php $offset += $len; endforeach; ?>
                         </svg>
                         <div class="jbs-donut-center">
                              <span class="jbs-donut-num"><?php echo $stats['total_jobs']; ?></span>
                              <span class="jbs-donut-lbl">total</span>
                         </div>
                    </div>
                    <div class="jbs-legend">
                         <?php foreach ($jbs_all as $status => $count):
                              $col = $jbs_colors[$status] ?? '#ccc';
                         ?>
                         <div class="jbs-leg-item <?php echo $count === 0 ? 'jbs-leg-zero' : ''; ?>">
                              <span class="jbs-leg-dot" style="background:<?php echo $col; ?>"></span>
                              <span class="jbs-leg-name"><?php echo ucfirst($status); ?></span>
                              <span class="jbs-leg-val"><?php echo $count; ?></span>
                         </div>
                         <?php endforeach; ?>
                    </div>
               </div>

               <!-- Bar rows — all statuses always shown -->
               <div class="jbs-bars">
                    <?php foreach ($jbs_all as $status => $count):
                         $pct  = round($count / $jbs_total * 100);
                         $barW = round($count / $jbs_maxC * 100);
                         $col  = $jbs_colors[$status] ?? '#ccc';
                    ?>
                    <div class="jbs-bar-row">
                         <span class="jbs-bar-lbl"><?php echo ucfirst($status); ?></span>
                         <div class="jbs-bar-track">
                              <div class="jbs-bar-fill" style="background:<?php echo $count ? $col : '#eee'; ?>;width:<?php echo $barW; ?>%"></div>
                         </div>
                         <span class="jbs-bar-n" <?php echo $count === 0 ? 'style="color:#ccc"' : ''; ?>><?php echo $count; ?></span>
                         <span class="jbs-bar-pct"><?php echo $count ? $pct . '%' : '—'; ?></span>
                    </div>
                    <?php endforeach; ?>
               </div>

               <hr class="jbs-divider">

               <!-- Posting activity heatmap (real data) -->
               <div class="jbs-section-title">Posting activity — last 4 weeks</div>
               <div class="jbs-heatmap">
                    <?php
                    $hm_colors = ['#f0f0f0','#edf7f2','#9FE1CB','#1D9E75','#085041'];
                    for ($i = 27; $i >= 0; $i--):
                         $day   = date('Y-m-d', strtotime("-{$i} days"));
                         $cnt   = $heatmap_days[$day] ?? 0;
                         $level = $cnt === 0 ? 0 : min(4, (int)ceil($cnt / $heatmap_max * 4));
                         $title = $cnt . ' job' . ($cnt !== 1 ? 's' : '') . ' on ' . date('d M', strtotime($day));
                    ?>
                    <div class="jbs-hm-cell" style="background:<?php echo $hm_colors[$level]; ?>" title="<?php echo $title; ?>"></div>
                    <?php endfor; ?>
               </div>
               <div class="jbs-hm-foot">
                    <span>4 weeks ago</span>
                    <div class="jbs-hm-legend">
                         Less
                         <div class="jbs-hm-leg-cell" style="background:#f0f0f0"></div>
                         <div class="jbs-hm-leg-cell" style="background:#9FE1CB"></div>
                         <div class="jbs-hm-leg-cell" style="background:#1D9E75"></div>
                         <div class="jbs-hm-leg-cell" style="background:#085041"></div>
                         More
                    </div>
                    <span>Today</span>
               </div>

               <hr class="jbs-divider">

               <!-- Insights grid -->
               <div class="jbs-section-title">Insights</div>
               <div class="jbs-insights">
                    <div class="jbs-tip">
                         <div class="jbs-tip-num"><?php echo $jbs_active; ?></div>
                         <div class="jbs-tip-lbl">Live right now</div>
                         <div class="jbs-tip-sub">Visible to seekers</div>
                    </div>
                    <div class="jbs-tip">
                         <div class="jbs-tip-num"><?php echo $jbs_fillRate; ?>%</div>
                         <div class="jbs-tip-lbl">Active rate</div>
                         <div class="jbs-tip-sub">Of all posted jobs</div>
                    </div>
                    <div class="jbs-tip">
                         <div class="jbs-tip-num"><?php echo $stats['total_jobs']; ?></div>
                         <div class="jbs-tip-lbl">All time posted</div>
                         <div class="jbs-tip-sub">Across all statuses</div>
                    </div>
                    <div class="jbs-tip">
                         <div class="jbs-tip-num"><?php echo $jbs_unused; ?></div>
                         <div class="jbs-tip-lbl">Unused statuses</div>
                         <div class="jbs-tip-sub">Draft / paused / etc.</div>
                    </div>
               </div>

          </div>
     </div>

</div>

<div class="dash-grid-2">

     <!-- RECENT APPLICATIONS -->
     <div class="adm-card">
          <div class="card-head">
               <h4><i class="fa fa-file-text"></i> Recent Applications</h4>
               <a href="<?php echo SITE_URL; ?>/admin/applications" class="btn btn-default btn-xs">View All</a>
          </div>
          <table class="table table-hover">
               <thead><tr><th>Applicant</th><th>Job</th><th>Status</th><th>Date</th></tr></thead>
               <tbody>
               <?php if (empty($recentApps)): ?>
               <tr><td colspan="4" class="text-center text-muted" style="padding:20px">No applications yet.</td></tr>
               <?php else:
                    $ac = ['submitted'=>'primary','reviewing'=>'info','shortlisted'=>'warning','interview'=>'warning','offered'=>'success','hired'=>'success','rejected'=>'danger','withdrawn'=>'default'];
               ?>
               <?php foreach ($recentApps as $a): ?>
               <tr>
                    <td><small><?php echo clean($a['applicant_email']); ?></small></td>
                    <td><small><?php echo clean($a['job_title']); ?></small></td>
                    <td><span class="label label-<?php echo $ac[$a['status']] ?? 'default'; ?>" style="font-size:10px"><?php echo ucfirst($a['status']); ?></span></td>
                    <td><small><?php echo date('d M', strtotime($a['applied_at'])); ?></small></td>
               </tr>
               <?php endforeach; endif; ?>
               </tbody>
          </table>
     </div>

     <!-- RECENT USERS -->
     <div class="adm-card">
          <div class="card-head">
               <h4><i class="fa fa-users"></i> Recent Registrations</h4>
               <a href="<?php echo SITE_URL; ?>/admin/users" class="btn btn-default btn-xs">View All</a>
          </div>
          <table class="table table-hover">
               <thead><tr><th>Email</th><th>Role</th><th>Status</th><th>Joined</th></tr></thead>
               <tbody>
               <?php if (empty($recentUsers)): ?>
               <tr><td colspan="4" class="text-center text-muted" style="padding:20px">No users yet.</td></tr>
               <?php else: ?>
               <?php foreach ($recentUsers as $u): ?>
               <tr>
                    <td><small><?php echo clean($u['email']); ?></small></td>
                    <td><span class="label label-default" style="font-size:10px"><?php echo ucfirst(str_replace('_', ' ', $u['role'])); ?></span></td>
                    <td><?php echo $u['is_active'] ? '<span class="label label-success" style="font-size:10px">Active</span>' : '<span class="label label-danger" style="font-size:10px">Inactive</span>'; ?></td>
                    <td><small><?php echo date('d M Y', strtotime($u['created_at'])); ?></small></td>
               </tr>
               <?php endforeach; endif; ?>
               </tbody>
          </table>
     </div>

</div>

<style>
/* ── Stat cards grid ───────────────────────────────────── */
.dash-stats {
     display: grid;
     grid-template-columns: repeat(6, 1fr);
     gap: 16px;
     margin-bottom: 20px;
}

/* ── Two-column layout ─────────────────────────────────── */
.dash-grid-2 {
     display: grid;
     grid-template-columns: 1fr 1fr;
     gap: 20px;
     margin-bottom: 0;
}
.dash-grid-2 .adm-card {
     margin-bottom: 22px;
}

/* ── Jobs by Status card ───────────────────────────────── */
.jbs-head {
     display: flex;
     align-items: center;
     gap: 8px;
     padding: 13px 18px;
     border-bottom: 1px solid #f0f0f0;
     font-size: 14px;
     font-weight: 600;
     color: #454545;
}
.jbs-head svg {
     width: 15px;
     height: 15px;
     color: #29ca8e;
}
.jbs-body {
     padding: 18px;
}
.jbs-donut-row {
     display: flex;
     align-items: center;
     gap: 16px;
     margin-bottom: 16px;
}
.jbs-donut-wrap {
     position: relative;
     width: 80px;
     height: 80px;
     flex-shrink: 0;
}
.jbs-donut-wrap svg {
     width: 80px;
     height: 80px;
}
.jbs-donut-center {
     position: absolute;
     inset: 0;
     display: flex;
     flex-direction: column;
     align-items: center;
     justify-content: center;
     pointer-events: none;
}
.jbs-donut-num {
     font-size: 19px;
     font-weight: 700;
     color: #29ca8e;
     line-height: 1;
}
.jbs-donut-lbl {
     font-size: 10px;
     color: #aaa;
     margin-top: 2px;
}
.jbs-legend {
     display: flex;
     flex-direction: column;
     gap: 6px;
     flex: 1;
}
.jbs-leg-item {
     display: flex;
     align-items: center;
     gap: 7px;
     font-size: 12px;
     color: #555;
}
.jbs-leg-zero {
     opacity: 0.35;
}
.jbs-leg-dot {
     width: 8px;
     height: 8px;
     border-radius: 50%;
     flex-shrink: 0;
}
.jbs-leg-name {
     flex: 1;
}
.jbs-leg-val {
     font-weight: 700;
     color: #333;
}
.jbs-bars {
     display: flex;
     flex-direction: column;
     gap: 8px;
     margin-bottom: 16px;
}
.jbs-bar-row {
     display: flex;
     align-items: center;
     gap: 9px;
}
.jbs-bar-lbl {
     width: 50px;
     font-size: 11px;
     color: #888;
     text-align: right;
     flex-shrink: 0;
}
.jbs-bar-track {
     flex: 1;
     height: 7px;
     background: #f0f0f0;
     border-radius: 6px;
     overflow: hidden;
}
.jbs-bar-fill {
     height: 7px;
     border-radius: 6px;
}
.jbs-bar-n {
     width: 22px;
     font-size: 12px;
     font-weight: 700;
     color: #333;
     text-align: right;
}
.jbs-bar-pct {
     width: 34px;
     font-size: 11px;
     color: #bbb;
     text-align: right;
}
.jbs-divider {
     border: none;
     border-top: 1px solid #f0f0f0;
     margin: 14px 0;
}
.jbs-section-title {
     font-size: 11px;
     font-weight: 700;
     text-transform: uppercase;
     letter-spacing: .05em;
     color: #999;
     margin-bottom: 10px;
}
.jbs-heatmap {
     display: grid;
     grid-template-columns: repeat(28, 1fr);
     gap: 3px;
     margin-bottom: 6px;
}
.jbs-hm-cell {
     aspect-ratio: 1;
     border-radius: 2px;
     cursor: default;
}
.jbs-hm-foot {
     display: flex;
     justify-content: space-between;
     align-items: center;
     font-size: 10px;
     color: #bbb;
}
.jbs-hm-legend {
     display: flex;
     gap: 3px;
     align-items: center;
}
.jbs-hm-leg-cell {
     width: 11px;
     height: 11px;
     border-radius: 2px;
     margin: 0 1px;
}
.jbs-insights {
     display: grid;
     grid-template-columns: 1fr 1fr;
     gap: 8px;
}
.jbs-tip {
     background: #f8f8f8;
     border-radius: 8px;
     padding: 10px 12px;
}
.jbs-tip-num {
     font-size: 20px;
     font-weight: 700;
     color: #333;
     line-height: 1;
}
.jbs-tip-lbl {
     font-size: 12px;
     color: #555;
     margin-top: 4px;
}
.jbs-tip-sub {
     font-size: 10px;
     color: #bbb;
     margin-top: 2px;
}

/* ── Responsive ────────────────────────────────────────── */
@media(max-width:1200px) { .dash-stats { grid-template-columns: repeat(3, 1fr); } }
@media(max-width:900px)  { .dash-stats { grid-template-columns: repeat(2, 1fr); } .dash-grid-2 { grid-template-columns: 1fr; } }
@media(max-width:480px)  { .dash-stats { grid-template-columns: 1fr 1fr; } }
</style>

<?php require BASE_PATH . '/app/Views/layouts/admin-footer.php'; ?>