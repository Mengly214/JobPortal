<?php require BASE_PATH . '/app/Views/layouts/admin-header.php'; ?>

<div class="pg-bar">
     <h2><i class="fa fa-briefcase"></i> Manage Jobs</h2>
     <a href="<?php echo SITE_URL; ?>/admin/jobs/create" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Job</a>
</div>

<?php if (isset($_GET['updated'])): ?>
<div class="alert alert-success"><i class="fa fa-check-circle"></i> Job updated successfully.</div>
<?php endif; ?>

<div class="adm-card" style="padding:15px 18px;margin-bottom:20px;border-top:none;border-left:4px solid #29ca8e;border-radius:0 4px 4px 0">
     <form method="get" action="<?php echo SITE_URL; ?>/admin/jobs" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
          <input type="text" name="search" class="form-control" style="width:220px" placeholder="Search title..." value="<?php echo htmlspecialchars($search); ?>">
          <select name="status" class="form-control" style="width:150px">
               <option value="">All Statuses</option>
               <?php foreach (['active','draft','paused','closed','expired'] as $s): ?>
               <option value="<?php echo $s; ?>" <?php echo $status === $s ? 'selected' : ''; ?>><?php echo ucfirst($s); ?></option>
               <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
          <a href="<?php echo SITE_URL; ?>/admin/jobs" class="btn btn-default">Clear</a>
          <span class="text-muted" style="margin-left:auto;font-size:13px"><?php echo count($jobs); ?> job<?php echo count($jobs) !== 1 ? 's' : ''; ?> found</span>
     </form>
</div>

<div class="adm-card">
     <div class="card-head"><h4><i class="fa fa-briefcase"></i> All Jobs</h4></div>
     <table class="table table-hover">
          <thead><tr><th>#</th><th>Title</th><th>Company</th><th>Type</th><th>Status</th><th>Featured</th><th>Views</th><th>Posted</th><th>Actions</th></tr></thead>
          <tbody>
          <?php if (empty($jobs)): ?>
          <tr><td colspan="9" class="text-center text-muted" style="padding:25px">No jobs found.</td></tr>
          <?php else:
          $sc = ['active'=>'success','draft'=>'default','closed'=>'danger','paused'=>'warning','expired'=>'warning'];
          foreach ($jobs as $j): ?>
          <tr>
               <td style="color:#999"><?php echo $j['id']; ?></td>
               <td><a href="<?php echo SITE_URL; ?>/jobs/<?php echo $j['id']; ?>" target="_blank"><?php echo clean($j['title']); ?></a></td>
               <td><small><?php echo clean($j['company_name'] ?? '–'); ?></small></td>
               <td><small><?php echo ucfirst(str_replace('_', ' ', $j['job_type'])); ?></small></td>
               <td><span class="label label-<?php echo $sc[$j['status']] ?? 'default'; ?>"><?php echo ucfirst($j['status']); ?></span></td>
               <td>
                    <a href="<?php echo SITE_URL; ?>/admin/jobs?feature=<?php echo $j['id']; ?>" title="Toggle featured">
                         <i class="fa fa-star" style="font-size:16px;color:<?php echo $j['is_featured'] ? '#f0c040' : '#ddd'; ?>"></i>
                    </a>
               </td>
               <td><small><?php echo $j['views']; ?></small></td>
               <td><small><?php echo date('d M Y', strtotime($j['created_at'])); ?></small></td>
               <td>
                    <a href="<?php echo SITE_URL; ?>/admin/jobs/edit/<?php echo $j['id']; ?>" class="btn btn-xs btn-primary" title="Edit job">
                         <i class="fa fa-pencil"></i> Edit
                    </a>
                    <a href="<?php echo SITE_URL; ?>/admin/jobs?toggle=<?php echo $j['id']; ?>" class="btn btn-xs <?php echo $j['status'] === 'active' ? 'btn-warning' : 'btn-success'; ?>"
                       onclick="return confirm('Toggle status?')"><?php echo $j['status'] === 'active' ? 'Pause' : 'Activate'; ?></a>
                    <a href="<?php echo SITE_URL; ?>/admin/jobs?delete=<?php echo $j['id']; ?>" class="btn btn-xs btn-danger"
                       onclick="return confirm('Delete this job permanently?')">Delete</a>
               </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
     </table>
</div>

<?php require BASE_PATH . '/app/Views/layouts/admin-footer.php'; ?>