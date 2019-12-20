<?php $__env->startSection('content'); ?>
  <?php echo $__env->make('partials.header-bg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('partials.sub-current-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="custom-page--content">
    <div class="container" style="max-width: 1160px;padding-left:0px;">
      <div class="custom-page-content">
          <?php echo $__env->make('partials.custom-pages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="custom-page--info">
            <div class="content" style="line-height: 24px; font-size: 16px;">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                the_content();
                endwhile; endif; ?>
            </div>
          <div class="summary our-team-bg">
            <div class="w-full">
                <div class="our-team flex inline flex-wrap justify-between">
                    <?php $__currentLoopData = $get_officers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $get_people): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="team-content w-full lg:w-1/2 max-w-teamwidth">
                        <div class="team_image max-h-teamwidth" style="background-image: url(<?php echo $get_people['featured_image']; ?>)">
                          <div class="team_hover"></div>
                        </div>
                        <div class="team_details">
                            <h2 class="team_name">
                                <?php echo $get_people['title']; ?>

                            </h2>
                            <p class="team_position">
                                <?php echo $get_people['position']; ?>

                            </p>
                            <a href="https://twitter.com/<?= $get_people['twitter_handle'] ?>" class="team_twitter_info" target="_blank">
                                <?php echo $get_people['twitter_handle']; ?>

                            </a>
                        </div>
                        <div class="team_info">
                          <p class="team_info_p" style="line-height: 150%; font-size: 16px;">
                              <?php echo $get_people['description']; ?>

                          </p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>