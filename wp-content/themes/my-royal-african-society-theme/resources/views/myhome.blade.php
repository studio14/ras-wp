{{--
  Template Name: Home Page Template
--}}

@extends('layouts.app')

@section('content')
<div class="slideshow-container">
  <div class="owl-carousel">
  @foreach($custom_sliders as $custom_slider)
  <div class="home-page" style="background-image: url({!! $custom_slider['featured_image'] !!});">
    <div class="home-title-bg">
      <div class="home-title-bg--text container">
        <div class="home-title-bg--text--bg">
          <div class="container">
            <div class=" text-title-tittle">
              <h2>{!! $custom_slider['title'] !!}</h2>
              <div class="action-button-bg">
                <a href="{!! $custom_slider['slider']['home_button_link']['url'] !!}" class="btn primary-button" target="{!! $custom_slider['slider']['home_button_link']['target'] !!}">
                  {!! $custom_slider['slider']['home_button_link']['title'] !!} 
                    <svg width="12" height="12" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 29px">
                      <path d="M1 1L4 4.37037L1 8" stroke="#FFFFFF" stroke-width="2"/>
                      </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  </div>
    <!-- <div class="slider-indicator-bg">
      <div class="slider-indicator">
        <div class="checkbox-indicator">
            <ul class="indicators flex justify-between">
              <?php 
              $count = count($custom_sliders);
              $index_count = 1;
                while ($index_count <= $count) { ?>
              <li data-slide="first" class="dot" onclick="currentSlide(<?php echo $index_count; ?>)"><em></em></li>
              <?php $index_count++; } ?>
            </ul>
        </div>
      </div>
    </div> -->
</div>
<div class="container">
  <div class="promoting">
      <div class="">
        <div class="promoting-container">
          <div class="join-us-content block lg:flex justify-center item-center">
            <div class="block lg:flex community-bg">
              <div class="feautured-image-bg" style="position: relative;margin-top: -20px;width:40%;">
                <div class="promoting-featured-image" style="background-image: url('<?= $home_first_section['featured_image'] ?>');">
                    <div class="promoting-image-play-btn" id="myBtn" >
                      <div class="feauted-image-join-us">
                        
                      </div>
                    </div>
                </div>
              </div>
              <div class="promoting-text-bg">
                <div>
                  <div class="promoting-text-header">
                    <h3><?= $home_first_section['text_title'] ?> 
                      <!-- <span>Promoting Africa. </span> -->
                    </h3>
                  </div>
                  <div class="arrow-next">
                      <a data-scroll href="#our-pillars">
                        <svg width="16" height="34" viewBox="0 0 16 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.54289 32.72C7.93342 33.1105 8.56658 33.1105 8.95711 32.72L15.3211 26.356C15.7116 25.9655 15.7116 25.3323 15.3211 24.9418C14.9305 24.5513 14.2974 24.5513 13.9069 24.9418L8.25 30.5987L2.59315 24.9418C2.20262 24.5513 1.56946 24.5513 1.17893 24.9418C0.788408 25.3323 0.788408 25.9655 1.17893 26.356L7.54289 32.72ZM7.25 0.997986L7.25 32.0129H9.25L9.25 0.997986L7.25 0.997986Z" fill="white"/>
                        </svg>
                      </a>
                  </div>                  
                  <div class="promoting-text-info text-white">
                      <p class="text-info text-white"><?= $home_first_section['text_description'] ?> </p>
                  </div>
                  <div class="action-button-bg" style="margin-bottom: 25px;">
                      <div>
                        <a href="<?= $home_first_section['button_link'] ?>" class="action-button bg-transparent know-more-button text-white"> <?= $home_first_section['button_text'] ?> 
                          <svg width="12" height="12" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 29px">
                          <path d="M1 1L4 4.37037L1 8" stroke="#FFFFFF" stroke-width="2"/>
                          </svg>
                        </a>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="myModal" class="modal" style="position: absolute;z-index: 999;">

        <!-- Modal content -->
        <div class="modal-content">
          <div class="close-window">
              <a href="#close-modal" rel="modal:close" class="close close-modal">&times;</a>
          </div>
          <div class="embeded-video">
              <iframe width="100%" src="https://www.youtube-nocookie.com/embed/ZXa_sOfBOMM?rel=0&autoplay=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
           </div>
        </div>
      
      </div>

  <div class="our-pillars" id="our-pillars">
    <div class="pillars-container-bg">
      <div class="our-pillar-container">
        <div class="our-pillars-title">
            <h2 class="pillars-h2">Our Pillars</h2>
        </div>
        <div class="our-pillars-content flex flex-wrap">
          <div class="mobile-grid xl:w-pillarsitemwidth lg:w-1/2 w-54p mr-0 lg:pr-20px xl:pr-0 mr-0 ml-0 md:-mr-5v md:-ml-5v lg:pb-60">
            <div class="our-pillars-cotent-bg">
              <div class="our-pillars-content-featured-bg" style="background-image: url('<?= $pillars_section['pillar_section_1']['featured_image'] ?>')" onclick="document.location.href='<?= $pillars_section['pillar_section_1']['link'] ?>'">
                <div class="our-pillars-content-bg">

                </div>
              </div>
              <div class="our-pillars-text-bg flex" onclick="document.location.href='<?= $pillars_section['pillar_section_1']['link'] ?>'">
                <div class="our-pillars-text bg-white">
                    <a href="<?= $pillars_section['pillar_section_1']['link'] ?>" title='<?= $pillars_section['pillar_section_1']['title'] ?>'>
                     <p class="text-content text-secondary"><?= $pillars_section['pillar_section_1']['title'] ?></p>
                    </a>
                  </div>
                <div class="text-arrow">
                  <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.53705 8.70711C8.92758 8.31658 8.92758 7.68342 8.53705 7.29289L2.17309 0.928932C1.78257 0.538408 1.1494 0.538408 0.758879 0.928932C0.368354 1.31946 0.368354 1.95262 0.758879 2.34315L6.41573 8L0.758879 13.6569C0.368354 14.0474 0.368354 14.6805 0.758879 15.0711C1.1494 15.4616 1.78257 15.4616 2.17309 15.0711L8.53705 8.70711ZM6.42261 9H7.82995V7H6.42261V9Z" fill="white"/>
                  </svg>                    
                </div>
              </div>
            </div>
          </div>
          <div class="mobile-grid xl:w-pillarsitemwidth lg:w-1/2 w-54p mr-0 lg:pr-20px xl:pr-0 mr-0 ml-0 md:-mr-5v md:-ml-5v lg:pb-60">
              <div class="our-pillars-cotent-bg">
                <div class="our-pillars-content-featured-bg" style="background-image: url('<?= $pillars_section['pillar_section_2']['featured_image'] ?>')" onclick="document.location.href='<?= $pillars_section['pillar_section_2']['link'] ?>'">
                  <div class="our-pillars-content-bg">

                    </div>
                </div>
                <div class="our-pillars-text-bg flex" onclick="document.location.href='<?= $pillars_section['pillar_section_2']['link'] ?>'">
                  <div class="our-pillars-text bg-white">
                      <a href="<?= $pillars_section['pillar_section_2']['link'] ?>" title='<?= $pillars_section['pillar_section_2']['title'] ?>'>
                        <p class="text-content text-secondary"><?= $pillars_section['pillar_section_2']['title'] ?></p>
                      </a>
                    </div>
                  <div class="text-arrow">
                    <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.53705 8.70711C8.92758 8.31658 8.92758 7.68342 8.53705 7.29289L2.17309 0.928932C1.78257 0.538408 1.1494 0.538408 0.758879 0.928932C0.368354 1.31946 0.368354 1.95262 0.758879 2.34315L6.41573 8L0.758879 13.6569C0.368354 14.0474 0.368354 14.6805 0.758879 15.0711C1.1494 15.4616 1.78257 15.4616 2.17309 15.0711L8.53705 8.70711ZM6.42261 9H7.82995V7H6.42261V9Z" fill="white"/>
                    </svg>                      
                  </div>
                </div>
              </div>
            </div>
            <div class="mobile-grid xl:w-pillarsitemwidth lg:w-1/2 w-54p mr-0 lg:pr-20px xl:pr-0 mr-0 ml-0 md:-mr-5v md:-ml-5v lg:pb-60">
                <div class="our-pillars-cotent-bg">
                  <div class="our-pillars-content-featured-bg" style="background-image: url('<?= $pillars_section['pillar_section_3']['featured_image'] ?>')" onclick="document.location.href='<?= $pillars_section['pillar_section_3']['link'] ?>'">
                    <div class="our-pillars-content-bg">

                      </div>
                  </div>
                  <div class="our-pillars-text-bg flex" onclick="document.location.href='<?= $pillars_section['pillar_section_3']['link'] ?>'">
                    <div class="our-pillars-text bg-white">
                        <a href="<?= $pillars_section['pillar_section_3']['link'] ?>" title='<?= $pillars_section['pillar_section_3']['title'] ?>'>
                          <p class="text-content text-secondary"><?= $pillars_section['pillar_section_3']['title'] ?></p>
                        </a>
                      </div>
                    <div class="text-arrow">
                      <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.53705 8.70711C8.92758 8.31658 8.92758 7.68342 8.53705 7.29289L2.17309 0.928932C1.78257 0.538408 1.1494 0.538408 0.758879 0.928932C0.368354 1.31946 0.368354 1.95262 0.758879 2.34315L6.41573 8L0.758879 13.6569C0.368354 14.0474 0.368354 14.6805 0.758879 15.0711C1.1494 15.4616 1.78257 15.4616 2.17309 15.0711L8.53705 8.70711ZM6.42261 9H7.82995V7H6.42261V9Z" fill="white"/>
                      </svg>                        
                    </div>
                  </div>
                </div>
              </div>
              <div class="mobile-grid xl:w-pillarsitemwidth lg:w-1/2 w-54p mr-0 lg:pr-20px xl:pr-0 mr-0 ml-0 md:-mr-5v md:-ml-5v lg:pb-60">
                  <div class="our-pillars-cotent-bg">
                    <div class="our-pillars-content-featured-bg" style="background-image: url('<?= $pillars_section['pillar_section_4']['featured_image'] ?>')" onclick="document.location.href='<?= $pillars_section['pillar_section_4']['link'] ?>'">
                      <div class="our-pillars-content-bg">

                        </div>
                    </div>
                    <div class="our-pillars-text-bg flex" onclick="document.location.href='<?= $pillars_section['pillar_section_4']['link'] ?>'">
                      <div class="our-pillars-text bg-white">
                          <a href="<?= $pillars_section['pillar_section_4']['link'] ?>" title='<?= $pillars_section['pillar_section_4']['title'] ?>'>
                           <p class="text-content text-secondary"><?= $pillars_section['pillar_section_4']['title'] ?></p>
                          </a>
                        </div>
                      <div class="text-arrow">
                        <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M8.53705 8.70711C8.92758 8.31658 8.92758 7.68342 8.53705 7.29289L2.17309 0.928932C1.78257 0.538408 1.1494 0.538408 0.758879 0.928932C0.368354 1.31946 0.368354 1.95262 0.758879 2.34315L6.41573 8L0.758879 13.6569C0.368354 14.0474 0.368354 14.6805 0.758879 15.0711C1.1494 15.4616 1.78257 15.4616 2.17309 15.0711L8.53705 8.70711ZM6.42261 9H7.82995V7H6.42261V9Z" fill="white"/>
                        </svg>                          
                      </div>
                    </div>
                  </div>
                </div>
          </div>
      </div>
    </div>
  </div>

  <div class="events">
    <div class="lg:container class-events-container">
      <div class="latest-events-container">
        <div class="events-title">
          <h2>Our Events</h2>
        </div>
        <div class="events-content block lg:flex">
            <?php
            $args = array('post_type' => 'events', 
            'post_per_page' => 2,
            'meta_query' => array (
                array(
                    'relation' => 'AND',
                    array (
                      'relation' => 'AND',
                      'events_date_sort' => array (
                      'key'=> 'events_date',
                      'value' => date('Y-m-d', strtotime('+2 years')),
                      'compare' => '<=',
                      'type' => 'DATE',
                    ),
                      'members_only_sort' => array (
                        'key' => 'members_only', 
                        'value' => 0, 
                        'compare' => '='
                      ),
                    ),
                    'home_only_sort' => array (
                      'key' => 'home_only',
                      'value' => 1,
                      'compare' => '<=',
                    ),
                ),
            ),
            'orderby' => array (
              'home_only_sort' => 'DESC',
              'events_date_sort' => 'DESC',
            ),
            );
            $query = new WP_Query($args);
            $postCount = 0;
            $numberPosts = $query->found_posts;
            while($query -> have_posts()) : $query -> the_post();
            $events_id = $query->ID;
            $events_date = get_field('events_date');
            $events_link = get_post_meta($query->post->ID, 'events_link');
            $events_location = get_post_meta($query->post->ID, 'events_location');
            $events_ticket_price = get_post_meta($query->post->ID, 'events_ticket_price');
            $events_starting_time = get_post_meta($query->post->ID, 'events_starting_time');
            $events_ending_time = get_post_meta($query->post->ID, 'events_ending_time');
            $events_permalink = get_the_permalink($query->post->ID);
            $terms = wp_get_post_terms( $query->post->ID, 'events_category' );
            $category = $terms[0]->name;
            $featuredImageUrl = get_the_post_thumbnail_url($query->post->ID);
            $membersonly = get_post_meta($query->post->ID, 'members_only');
            $homeonly = get_post_meta($query->post->ID, 'home_only');
            if ($postCount < 2) {
          ?>
           <?php if ($postCount  == 0) { ?>
          <div class="max-w-eventitemsfirst min-h-eventitemsfirst eventcontainer">
            <div class="events-container" onclick="location.href='<?php if ($members_only !== 1) echo $events_permalink; else echo 'https://app.royalafricansociety.org/events/'.$events_id; ?>'"
              style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.52), rgba(0, 0, 0, 0.52)), url(<?= $featuredImageUrl ?>)" style="align-items: unset; padding-top: 63px;">
              <div class="events-cotent-bg">
                <div class="content">
                  <div class="content-top flex">
                    <p>When - <?= $events_date; ?></p>
                    <p><?= $category; ?></p>
                  </div>
                  <div class="content-main">
                    <a href="<?php if ($members_only !== 1) echo $events_permalink; else echo 'https://app.royalafricansociety.org/events/'.$events_id; ?>"><?= the_title(); ?></a>
                   <p>{!! App\limit_character(get_the_excerpt(), '180') !!}</p>
                  </div>
                  <div class="event-readmore">
                    <div class="button"><a href="<?php if ($members_only !== 1) echo $events_permalink; else echo 'https://app.royalafricansociety.org/events/'.$events_id; ?>">read more </a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php 
            } else { ?>
          <div class="max-w-full lg:max-w-eventitemslast min-h-eventitemsfirst eventcontainer">
              <div class="events-container" onclick="location.href='<?php if ($members_only !== 1) echo $events_permalink; else echo 'https://app.royalafricansociety.org/events/'.$events_id; ?>'"  
                style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.52), rgba(0, 0, 0, 0.52)), url(<?= $featuredImageUrl ?>)">
                <div class="events-cotent-bg" >
                  <div class="content">
                    <div class="content-top flex">
                      <p>When - <?= $events_date; ?></p>
                      <p><?= $category; ?></p>
                    </div>
                    <div class="content-main">
                      <a href="<?php if ($members_only !== 1) echo $events_permalink; else echo 'https://app.royalafricansociety.org/events/'.$events_id; ?>"><?= the_title(); ?> </a>
                    </div>
                    <div class="event-readmore">
                        <div class="button"><a href="<?php if ($members_only !== 1) echo $events_permalink; else echo 'https://app.royalafricansociety.org/events/'.$events_id; ?>">read more </a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }
            }
            $postCount++;
          endwhile; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="latest-news">
    <div class="lg:container my-latest-news-container">
      <div class="latest-news-container">
        <div class="news-title">
          <h2>Latest News</h2>
        </div>
        <div class="news-content flex flex-wrap">
            <?php
            $wp_query = '';
            $category = isset($_GET['category']) ? $_GET['category'] : '';
            $count = 0;
            $args = [
              'post_type' => 'post',
              'post_per_page' => 4,
              'meta_query' => [
                'relation' => 'AND',
                'home_only'=> [ 
                  'key' => 'home_only',
                  'value' => 1,
                  'compare' => '<=',
                ],
                'members_only_sort' => [
                  'key' => 'members_only',
                  'value' => '0',
                  'compare' => '='
                ]
              ],
              'orderby' => array(
                'home_only' => 'DESC',
                'date' => 'DESC'
              )
            ];
            $wp_query = new WP_Query($args); 
            $postCount = 0;
            while ($wp_query->have_posts()) : $wp_query->the_post(); $count++; 
            $membersonly = get_post_meta($wp_query->post->ID, 'members_only');
            if ($postCount <= 3) { ?>
          <div class="item xl:w-blogitemswidth md:w-1/2 w-full mr-0 pr-0 lg:pr-60 xl:pr-0 mr-0">
            <div class="news-cotent-bg">
                  <div class="news-content-featured-bg" style="background-image: url('{{ get_the_post_thumbnail_url() }}')" onclick="document.location.href='{{ get_permalink() }}'">
                      <div class="blog-cat-bg">
                          <div class="blog-cat-tag">
                            <?php
                              $categories = get_the_category();
                              $count = 0;
                              $output = '';
                              if ( ! empty( $categories ) ) {
                                foreach( $categories as $category ) {
                                  if ($count <1) {
                                    $output .= '<a href="'.get_page_link(13) .'?category='.$category->slug.'">' . esc_html( $category->name ) . '</a>';
                                
                                  }
                                  $count++;
                                }
                            }
                            ?>
                          <p class="blog-text"><?= $output; ?></p>
                          </div>
                        </div>
              </div>
              <div class="news-content-info">
                <div class="news-content-title">
                  <a href="{{ get_permalink() }}">{!! App\limit_character(html_entity_decode(get_the_title()), '35') !!}</a>
                </div>
                <div class="news-content-summary">
                  <p>{!! App\limit_character(get_the_excerpt(), '260') !!}</p>
                </div>
                <div class="news-read-more flex inline">
                  <p><a href="{{ get_permalink() }}" class="read-more-link">Read more  
                    <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.42426 5.42426C5.65858 5.18995 5.65858 4.81005 5.42426 4.57574L1.60589 0.757359C1.37157 0.523045 
                    0.991674 0.523045 0.757359 0.757359C0.523045 0.991674 0.523045 1.37157 0.757359 1.60589L4.15147 5L0.757359 
                    8.39411C0.523045 8.62843 0.523045 9.00833 0.757359 9.24264C0.991674 9.47696 1.37157 9.47696 1.60589 9.24264L5.42426 
                    5.42426ZM4 5.6H5V4.4H4V5.6Z" fill="#123234"/>
                  </svg>
                </a></p>
                  <p class="date"><span>{{ the_time('d/n/Y') }}</span></p>
                </div>
              </div>
            </div>
          </div>
          <?php $postCount++; }
          endwhile; ?>
        </div>
      </div>
    </div>
  </div>


  <!-- <div class="join-us">
    <div class="lg:container my-join-us-container">
      <div class="join-us-container">
        <div class="join-us-content flex">
          <div class="community-bg block lg:flex">
            <div class="join-us-title">
              <h3><?= $home_bottom_section['text_title'] ?></h3>
              <p><?= $home_bottom_section['text_description'] ?> </p>
                <div class="action-button-bg" style="margin-bottom: 30px;">
                    <div>
                      <a href="<?= $home_bottom_section['button_link'] ?>" class="text-white action-button bg-primary"> <?= $home_bottom_section['button_text'] ?>
                        <svg width="12" height="12" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1 1L4 4.37037L1 8" stroke="white" stroke-width="2"/>
                          </svg>                          
                      </a>
                    </div>
                </div>
            </div>
            <div class="join-us-featured-image">
                <img src="<?= $home_bottom_section['featured_image'] ?>" alt="Royal-African-Society-Logo" class="feauted-image-join-us">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->

<style>
@media screen and (max-width: 992px) {
  .footer {
    margin-top: -80px !important;
  }
}
.footer {
  margin-top: 0px !important;
}
.modal {
      transition: opacity 0.25s ease;
    }
    body.modal-active {
      overflow-x: hidden;
      overflow-y: visible !important;
    }
</style>
<script type="text/javascript">
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1} 
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block"; 
  dots[slideIndex-1].className += " active";
}
</script>
@endsection