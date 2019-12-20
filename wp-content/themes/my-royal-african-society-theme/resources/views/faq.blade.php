{{--
  Template Name: FAQs Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.header-bg')
  @include('partials.sub-menu')

  <div class="custom-page--content">
    <div class="membership container">
      <div class="flex-col md:flex-row custom-page-content">
        <div class="custom-page-title" style="margin-bottom: 30px;">
          <h2>{!! App::title() !!} </h2>
          <hr>
        </div>
        <div class="custom-page--info flex-col md:flex-row mt-97 md:mt-0">
          <div class="summary mb-44" style="line-height: 150%; font-size: 16px;">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
              the_content();
              endwhile; endif; ?>
              <div class="history-dates" style="margin-top: 0px;">
                  <?php 
                  $taxonomy = 'faq_categories';
                  $args = array(
                    'hide_empty'   => '1',
                    'orderby' => 'ID',
                    'order' => 'DESC',
                  );
                  $old_taxonomy_terms = get_terms($taxonomy, $args);

                  if($old_taxonomy_terms) {
                    $count = 0;
                    foreach($old_taxonomy_terms as $taxonomy_term) {
                      $args = array(
                        'post_type' => 'faq',
                        "$taxonomy" => $taxonomy_term->slug,
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'post_date',
                        'order' => 'DESC',
                      );
                      $query = new WP_Query( $args );
                      if ( $query->have_posts() ) :
                  ?>
                <div class="faq_bg_title">
                  <div class="head_title">
                      <h2><?php echo $taxonomy_term->name; ?></h2>
                  </div>
                </div>
                <?php 
                $iteration = 0;
                while ( $query->have_posts() ) : $query->the_post(); $iteration++; ?>
                  <div class="year-title flex accordion">
                  <h2 class="year" style="font-size: 24px;line-height: 29px;margin-bottom: 10px;font-weight:normal;"><?php the_title(); ?>
                  </h2>
                  <svg class="arrow" width="22" height="12" viewBox="0 0 22 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 2L11.3704 10L1 2" stroke="black" stroke-width="3"/>
                  </svg>                    
                  </div>
                      <div class="year-content panel">
                          <div class="text-base leading-history" style="font-weight:normal;">
                              <?php the_content(); ?>
                          </div>
                      </div>
                    <?php endwhile; $count++; ?>
                    <br /><br />
                      <?php wp_reset_postdata();
                      endif;} }; 
                       ?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection