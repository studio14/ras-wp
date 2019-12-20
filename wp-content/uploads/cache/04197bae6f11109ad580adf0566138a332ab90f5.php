<?php $__env->startSection('content'); ?>
  <section id="contact-us" class="contact-us-container">
    <div class="container flex flex-wrap justify-center">
      <div class="flex flex-wrap" style="width: 100%;max-width: 1125px;">
      <div class="flex flex-col text-left w-full md:w-30p mr-0">
          <div class="contact-title">
            <h2>Contact Us</h2>
            <hr>
          </div>
          <div class="contact-address-1">
            <div class="contact-info-1">
              <div class="contact-info-1-title">
                <p>Address: </p>
              </div>
              <div class="contact-info-1-desc">
                <p><?= $main_address_info['address_title'] ?></p>
                <p><?= $main_address_info['address_details'] ?></p>
                <p><?= $main_address_info['phone_number'] ?></p>
              </div>
            </div>
          </div>
      </div>
      <div class="flex flex-col text-left w-full md:w-70p">
        <div class="contact-map">
          <?php if (empty($google_map_address)) {
            ?>
          <img src="<?php bloginfo('template_directory'); ?>/assets/images/map_default.png" alt="map-contact" />
          <?php
          } else {
            echo $google_map_address;
          }
          ?>
        </div>
        <div class="general-enquiries">
          <div class="title">
            <h2>General Enquiries</h2>
          </div>
          <div class="desc">
            <p>For General Enquiries, please send an email to <a href="mailto: ras@soas.ac.uk">ras@soas.ac.uk</a>
               or get in touch via the contact form below </p>
            <p> Donations and Legacies, please contact Caitlin Pearson on <a href="mailto: caitlin.pearson@soas.ac.uk">caitlin.pearson@soas.ac.uk</a> </p>
          </div>
        </div>
        <?php while(have_posts()) : the_post(); ?>
          <?php the_content();?>
        <?php endwhile; ?>
        <div class="contact-info-2-bg">
          <div class="flex w-full flex-wrap justify-between content-center">
            <?php $__currentLoopData = $contact_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item w-full md:w-1/2 mb-93">
              <div class="title">
                <h2><?php echo $contact['title']; ?></h2>
              </div>
              <div class="content">
                <p><?php echo $contact['content']; ?></p>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
      </div>
      </div>
    </div>
  </section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>