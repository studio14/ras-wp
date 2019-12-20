<?php $__env->startSection('content'); ?>
  
  <section id="events">
      <div class="container events-container">
          <div class="container events-title-bg flex text-left justify-left">
              <div class="title" style="max-width: 454px;">
                  <h2><?php echo App::title(); ?></h2>
                  <hr/>
              </div>
          </div>
            <?php if (have_posts()) {
                $postCount = 1;
            ?>
            <?php
            the_post();
                @include('partials.content-'.get_post_type());
            ?>
            <?php 
                }
                else {
            ?>
            <div class="events-content no-news">
                <div class="container flex justify-center flex-col items-center items-center">
                    <h2> Sorry, No News Available Here. </h2>
                    <a href="<?php echo home_url(); ?>" class="" style="border-radius: 80px;">Go home          
                    </a>
                </div>
            </div>
            <?php 
                }
            ?>
  </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>