<?php $__env->startSection('content'); ?>
  <?php echo $__env->make('partials.header-bg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('partials.sub-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="custom-page--content">
    <div class="container" style="max-width: 1160px;padding-left:0px;">
      <div class="custom-page-content">
          <?php echo $__env->make('partials.mission-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="custom-page--info">
          <div class="summary" style="line-height: 24px; font-size: 16px;">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
              the_content();
              endwhile; endif; ?>
          </div>
          <div class="history-dates">
          <?php $__currentLoopData = $history_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="year-title flex accordion">
              <h2 class="year"><?php echo $history_detail['title']; ?></h2>
              <svg class="arrow" width="22" height="12" viewBox="0 0 22 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21 2L11.3704 10L1 2" stroke="black" stroke-width="3"/>
                </svg>   
            </div>
          <div class="year-content panel" >
            <div class="text-base leading-history font-light">
                <?php echo $history_detail['description']; ?>

            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>