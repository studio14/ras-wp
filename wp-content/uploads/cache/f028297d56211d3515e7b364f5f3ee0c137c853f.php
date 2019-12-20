<?php $__env->startSection('content'); ?>
  <?php echo $__env->make('partials.header-bg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('partials.sub-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="custom-page--content">
    <div class="membership container">
      <div class="flex-col md:flex-row custom-page-content">
        <div class="custom-page-title ">
          <h2><?php echo App::title(); ?> </h2>
          <hr>
        </div>
        <div class="custom-page--info flex-col md:flex-row mt-97 md:mt-0">
          <div class="summary mb-44" style="line-height: 150%; font-size: 16px;">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
              the_content();
              endwhile; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="membership-pricing bg-membership-color mt-0 pt-0 xl:pt-86 pb-86 flex justify-around content-center text-center align-center items-center">
    <div class="container block lg:flex flex-col lg:flex-row w-full justify-center mt-24 lg:mt-0">
    <?php $__currentLoopData = $get_gifting_pricings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $get_gifting_pricing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($loop->iteration%2 === 0): ?> 
          <div class="w-full md:w-1/2 lg:w-auto md:float-right">
            <div class="pricing-item bg-white text-center items-center">
              <div class="title">
                <p  class="text-secondary"><?php echo $get_gifting_pricing['title']; ?></p>
              </div>
              <div class="price-tag">
                <h2  class="text-secondary">£<?php echo $get_gifting_pricing['price']; ?></h2>
              </div>
              <div class="price-desc">
                <p class="text-secondary text-left">
                    <?php echo $get_gifting_pricing['description']; ?>   
                </p>
              </div>
              <div class="price-button">
                <a class="btn bg-custom-bg text-secondary" href="<?php echo $get_gifting_pricing['page_link']; ?>" target="_blank">BUY AS GIFT</a>
              </div>
            </div>
          </div>
        <?php else: ?> 
          <div class="w-full md:w-1/2 lg:w-auto md:float-right">
            <div class="pricing-item bg-primary text-center items-center">
              <div class="title">
                <p  class="text-white"><?php echo $get_gifting_pricing['title']; ?></p>
              </div>
              <div class="price-tag">
                <h2  class="text-white">£<?php echo $get_gifting_pricing['price']; ?></h2>
              </div>
              <div class="price-desc">
                <p class="text-white text-left">
                    <?php echo $get_gifting_pricing['description']; ?>   
                </p>
              </div>
              <div class="price-button">
                <a class="btn bg-custom-bg text-secondary" href="<?php echo $get_gifting_pricing['page_link']; ?>">BUY AS GIFT</a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
  
  
  <style>
    footer {
      margin-top: 145px !important;
    }
  </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>