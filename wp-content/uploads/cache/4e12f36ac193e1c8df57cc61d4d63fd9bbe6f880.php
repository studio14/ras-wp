<?php $__env->startSection('content'); ?>
  <?php echo $__env->make('partials.header-bg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('partials.sub-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="custom-page--content">
    <div class="container" style="max-width: 1160px; padding-left:0px;">
      <div class="flex-col md:flex-row custom-page-content">
        <div class="custom-page-title ">
          <h2><?php echo App::title(); ?> Membership</h2>
          <hr>
          <div class="action-button-bg">
              <div>
                <a target="_blank" href="<?= $link_to_web_apps; ?>" class="text-white action-button bg-primary"> Join Now
                  <svg width="12" height="12" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L4 4.37037L1 8" stroke="white" stroke-width="2"/>
                    </svg>                          
                </a>
              </div>
          </div>
        </div>
        <div class="membership custom-page--info flex-col md:flex-row mt-97 md:mt-0">
            <div class="summary mb-62">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                the_content();
                endwhile; endif; ?>
            </div>
          </div>
      </div>
    </div>
  </div>

  <div class="member-call-out flex justify-center align-center items-center ceontent-center">
    <div class="container max-w-587 flex justify-center text-center align-center items-center ceontent-center flex-col">
      <div class="member-callout-container text-center">
        <p class="call-out-text">Become part of the most dynamic, influential and fun organisations promoting Africa in the UK</p>
      </div>
      <div class="member-callout-button flex justify-center text-center items-center">
        <a target="_blank" href="<?= $link_to_web_apps; ?>" class="btn">Sign Up</a>
      </div>
    </div>
  </div>
  <div class="contact-us-bg flex justify-center items-center align-center text-center">
    <div class="container flex justify-center items-center align-center text-center">
      <div class="contact-us-content text-center">
        <p class="contact-text"><a href="<?php echo get_permalink( get_page_by_path( 'contact-us' ) ) ?>">Contact us</a> &nbsp; for more information</p>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>