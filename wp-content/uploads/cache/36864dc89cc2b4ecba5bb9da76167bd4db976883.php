

<?php echo $__env->make('partials.content-search-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $searchterm = ( get_query_var('s') ) ? get_query_var('s') : ''; 
if (isset($_GET['s'])) {
?>
<section id="search-results">
    <div class="search-content-bg">
        <div class="container">
            <div class="search-title-bg flex text-left justify-left">
                <div class="title">
                    <h2>Search Results <?php if (isset($_GET['s']) && $_GET['s'] != null) echo 'For ' . esc_html( get_search_query( false ) ); ?> </h2>
                    <hr/>
                </div>
            </div>
            <div class="search-results-bg">
              <div class="search-details flex flex-wrap">
                <?php
                  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                  $searchterm = ( get_query_var('s') ) ? get_query_var('s') : '';
                  ($searchterm != '') ? $page_load = 'page' : $page_load = '';
                  $args = array('post_type' => array('post', $page_load), 'posts_per_page' => 8, 'paged' => $paged,
                    's' => $searchterm );
                  $wp_query = new WP_Query($args);
                  $count = 0;
                  while ($wp_query->have_posts()) : $wp_query->the_post(); $count++;
                      $membersonly = get_post_meta($wp_query->post->ID, 'members_only');
                      if ($membersonly[0] !== '1') {

              ?>
                <div class="search-items-bg md:max-w-full max-w-533">
                  <div class="search-items">
                      <div class="title">
                        <a href="<?php echo e(get_permalink()); ?>">
                          <p><?php echo App\limit_character(get_the_title(), '35'); ?></p>
                        </a>
                      </div>
                      <div class="content">
                          <p>
                              <?php the_excerpt() ?>
                          </p>

                      </div>
                      <div class="read-more">
                        <a href="<?php echo e(get_permalink()); ?>"><p>Read more 
                            <svg height="11" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M6.53721 6.53033C6.8301 6.23744 6.8301 5.76256 6.53721 5.46967L1.76423 0.696699C1.47134 0.403806 0.996467 0.403806 0.703574 0.696699C0.410681 0.989592 0.410681 1.46447 0.703574 1.75736L4.94621 6L0.703574 10.2426C0.410681 10.5355 0.410681 11.0104 0.703574 11.3033C0.996467 11.5962 1.47134 11.5962 1.76423 11.3033L6.53721 6.53033ZM5.15234 6.75H6.00687V5.25H5.15234V6.75Z" fill="#123234"/>
                            </svg>                              
                        </p></a>
                      </div>
                  </div>
                </div>
                <?php }
                     endwhile; ?>
              </div>
            </div>
            <?php echo App\pagination($wp_query->max_num_pages, 'results'); ?>

        </div>
        <?php if(!$wp_query->have_posts()): ?>
        <div class="container">
            <div class="not-found-bg">
              <div class="not-found-title">
                <h1> Sorry, no results found.</h1>
              </div>
            </div>
          </div>
        <?php endif; ?>
    </div>
</section>
<style>
footer {
  margin-top: 0px !important;
}
</style>
<?php 
}
?>

