<?php $__env->startSection('content'); ?>
  <?php echo $__env->make('partials.header-bg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('partials.sub-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="custom-page--content">
    <div class="container" style="max-width: 1160px;padding-left:0px;">
      <div class="custom-page-content">
          <?php echo $__env->make('partials.mission-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="custom-page--info">
            <div class="summary" style="line-height: 150%; font-size: 16px;">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                the_content();
                endwhile; endif; ?>
            </div>
        </div>
      </div>

      <div class="tiled-image--bg">
          <div class="image-tiled-bg flex inline flex-wrap">
            <div class="w-1/2">
              <div class="image-bg">
                  <?php 
                    if ($group_images['image_one'] != null)
                    {
                  ?>
                  <img src="<?= $group_images['image_one'] ?>" alt="Royal-African-Society-Patron-Images">
                  <?php
                    }
                    if ($group_images['image_two'] != null)
                    {
                    ?>
                  <img src="<?= $group_images['image_two'] ?>" alt="Royal-African-Society-Patron-Images">
                  <?php 
                    }
                    ?>
              </div>
            </div>
            <div class="w-1/2">
              <div class="image-bg">
                  <?php
                    if ($group_images['image_three'] != null)
                    {
                    ?>
                  <img src="<?= $group_images['image_three'] ?>" alt="Royal-African-Society-Patron-Images">
                  <?php 
                    }
                    ?>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>