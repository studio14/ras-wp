<?php $__env->startSection('content'); ?>
  
  <?php echo $__env->make('partials.content-search-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<section id="404page" class="notfound">
  <div class="container">
      <div class="not-found-bg">
        <div class="not-found-title">
          <h1>Sorry, the page you requested could not be found.</h1>
          <p>You can use our search form above to quickly find what you were looking for</p>
        </div>
      </div>
    </div>
</section>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>