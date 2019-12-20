


<section id="events">
    <div class="container events-container">
        <div class="events-title-bg flex text-left justify-left flex-col">
            <div class="title" style="max-width: 750px;">
                <h2><?php echo get_the_title(); ?></h2>
                <hr/>
            </div>
            <div class="sub-title-date">
              <p>Posted on <?php echo e(get_the_date('jS F, Y')); ?> in 
                  <?php 
                  //get the post categories 
                  $categories = get_the_category();
                    if ( ! empty( $categories ) ) {
                        $categoryName = esc_html($categories[0]->name);   
                        $categorySlug = esc_html($categories[0]->slug);
                        $categoryId = $categories[0]->term_id;
                    }
                    global $wp;
                  ?>
                <a href="<?= get_page_link(13) .'?category='.$categorySlug ?>">
                  <?= $categoryName; ?>
                </a> </p>
            </div>

            <div class="featured_image-bg" >
                <div class="featured-image">
                  <img src="<?php echo e(get_the_post_thumbnail_url()); ?>" />
                </div>
            </div>
            <div class="content-header-bg">
              <div class="contents">
                <div class="contents-details flex">
                  <div class="social-icons-bg mr-79 flex flex-col">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(get_permalink()); ?>&amp;src=sdkpreparse">
                      <img src="<?php bloginfo('template_directory'); ?>/assets/images/facebook.png" alt="Share-Posts-On-Facebook" class="mb-24">
                    </a>
                    <a target="_blank" href="http://twitter.com/share?text=<?= get_the_title(); ?>&url=<?= urlencode(get_permalink()); ?>">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/twitter.png" alt="Share-Posts-On-Twitter" class="mb-24">
                    </a>
                  </div>
                  <div class="content-info">
                      <?= the_content(); ?>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="blog-back-bg flex justify-center items-center contents-center">
      <div class="blog-back-container">
        <a href="javascript:" onclick="window.history.back()" class="back-link"> 
            <svg width="6" height="11" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4.8583 0L6 1.2925L2.2915 5.5L6 9.7075L4.8583 11L0 5.5L4.8583 0Z" fill="#EF6D1D"/>
            </svg>              
          Go Back </a>
      </div>
    </div>
</section>
<style>
  footer {
      margin-top: 142px !important;
  }
</style>
