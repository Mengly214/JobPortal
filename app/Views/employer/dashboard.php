<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<section>
<div class="container">
<div class="text-center">

     <h1>Employer Dashboard</h1><br>

     <p class="lead">
         Welcome back, <?php echo htmlspecialchars($_SESSION['email']); ?>!
     </p>

     <br>



     <!-- ✅ ADD HERE -->
     <br><br>
     <a href="<?php echo SITE_URL; ?>/employer/applications" class="section-btn btn btn-primary">
         View Applications
     </a>

</div>
</div>
</section>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>