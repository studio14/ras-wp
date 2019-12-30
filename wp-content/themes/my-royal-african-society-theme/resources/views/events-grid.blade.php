{{--
    Template Name: Events Grid Template
  --}}
  @extends('layouts.app')
  
  @section('content')
      <section id="events">
          <div class="container events-container">
              <div class="events-title-bg flex text-left justify-left">
                  <div class="title">
                      <h2><?= $page_title; ?></h2>
                      <hr/>
                  </div>
              </div>
              <div class="events-desc-bg flex text-left justify-left">
                  <div class="desc">
                      <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                      the_content();
                      endwhile; endif; ?>
                  </div>
              </div>
              <div class="events-content">
                  <div class="events-filter-bg">
                      <div class="events-filter flex flex-wrap justify-between align-center items-center">
                          <div class="events-filter-section-1 inline mb-30 flex flex-row flex-wrap justify-between">
                              <div class="input-type-bg flex-wrap">
                                  <div class="input-type-bg flex-wrap">
                                      <label for="show_input">Show</label>
                                      <select name="show_all" id="show_input" onchange="loadType(this.value, '<?= get_page_link(9) ?>', '<?php  if (isset($_GET['date'])) echo '?date='.$_GET['date'].'&'; else echo '?' ?>category');");">
                                          <option value=""><?php echo esc_attr( __( 'All' ) ); ?> </option>
                                          <?php 
                                          $events_categories = get_terms(array('taxonomy' => 'events_category', 'parent' => 0, 'hide_empty' => true ));
                                          foreach ($events_categories as $events_category) {
                                          ?>
                                          <option value="<?= $events_category->slug ?>" <?php if(isset($_GET['category']) && $events_category->slug == $_GET['category'] ) echo 'selected' ?> ><?= $events_category->name ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                                  <div class="input-type-bg">
                                      <label for="dateFrom">From</label>
                                      <?php 
                                          
                                      ?>
                                      <select name="show_from" id="dateFrom" onchange="loadType(this.value, '<?= get_page_link(9) ?>', '<?php  if (isset($_GET['category'])) echo '?category='.$_GET['category'].'&'; else echo '?' ?>date');">
                                              <option value=""><?php echo esc_attr( __( 'All' ) ); ?> </option>
                                              <?php
                                                  // Set current month
                                                  $current_month = '';
                              
                                                  // Get event posts in order
                                                  $events = query_posts( array(
                                                      'post_type' => 'events',
                                                      'meta_key' => 'events_date',
                                                      'meta_compare' => '>',
                                                      'meta_value' => date ('2018-01-01'),
                                                      'meta_type'  => 'DATE',
                                                      'post_status' => 'publish',
                                                      'posts_per_page' => '-1',
                                                      'orderby' => 'meta_value',
                                                      'order' => 'DESC'
                                                  ) );
                                                  
                                                  // Iterate over events
                                                  foreach($events as $key => $event){
  
                                                  $memberonly = get_field('members_only', $event->ID);
                                                  if ($memberonly != 1) {
                                                      // Get event date from post meta
                                                      $event_date = get_post_meta($event->ID, 'events_date', $single = true);
                              
                                                      // Cache event month/year
                                                      $event_month = date('F Y', strtotime($event_date));
                                                      
                                                      $selected = '';
                                                      // Open new group if new month
                                                      if($current_month != $event_month){
                                                              if ($_GET['date'] == strtotime($event_month)) $selected = 'selected';
                                                              echo '<option value="'.strtotime($event_month).'"'.$selected.'>'.$event_month.'</option>';
                                                      }   
                                                  }
                              
                                                      $current_month = $event_month;        
                                                  }
                                              ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="events-filter-section-2  mb-30 inline flex flex-row justify-between">
                              <div class="grid grid_sort inline flex flex-row justify-center items-center active" id="grid">
                                  <a href="<?= get_page_link(9) ?>" class="inline flex flex-row justify-center items-center">
                                      <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M4.31204 0.438477H1.43735C0.643213 0.438477 0 1.11659 0 1.95213V4.97942C0 5.81571 0.643213 6.49307 1.43735 6.49307H4.31204C5.10618 6.49307 5.74939 5.81571 5.74939 4.97942V1.95213C5.74939 1.11659 5.10618 0.438477 4.31204 0.438477ZM4.31204 4.97942H1.43735V1.95213H4.31204V4.97942Z" fill="#EF6D1D"/>
                                          <path d="M12.933 0.438477H10.0584C9.26429 0.438477 8.62109 1.11659 8.62109 1.95213V4.97942C8.62109 5.81571 9.26429 6.49307 10.0584 6.49307H12.933C13.7264 6.49307 14.3704 5.81571 14.3704 4.97942V1.95213C14.3704 1.11659 13.7264 0.438477 12.933 0.438477ZM12.933 4.97942H10.0584V1.95213H12.933V4.97942Z" fill="#EF6D1D"/>
                                          <path d="M21.562 0.438477H18.6873C17.8932 0.438477 17.25 1.11659 17.25 1.95213V4.97942C17.25 5.81571 17.8932 6.49307 18.6873 6.49307H21.562C22.3555 6.49307 22.9994 5.81571 22.9994 4.97942V1.95213C22.9994 1.11659 22.3555 0.438477 21.562 0.438477ZM21.562 4.97942H18.6873V1.95213H21.562V4.97942Z" fill="#EF6D1D"/>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M4.31204 9.52051H1.43735C0.643213 9.52051 0 10.1979 0 11.0342V14.0615C0 14.8977 0.643213 15.5751 1.43735 15.5751H4.31204C5.10618 15.5751 5.74939 14.8977 5.74939 14.0615V11.0342C5.74939 10.1986 5.10618 9.52051 4.31204 9.52051ZM4.31204 14.0615H1.43735V11.0342H4.31204V14.0615Z" fill="#EF6D1D"/>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9331 9.52051H10.0584C9.26431 9.52051 8.62109 10.1979 8.62109 11.0342V14.0615C8.62109 14.8977 9.26431 15.5751 10.0584 15.5751H12.9331C13.7266 15.5751 14.3705 14.8977 14.3705 14.0615V11.0342C14.3705 10.1986 13.7266 9.52051 12.9331 9.52051ZM12.9331 14.0615H10.0584V11.0342H12.9331V14.0615Z" fill="#EF6D1D"/>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M21.562 9.52051H18.6873C17.8932 9.52051 17.25 10.1979 17.25 11.0342V14.0615C17.25 14.8977 17.8932 15.5751 18.6873 15.5751H21.562C22.3555 15.5751 22.9994 14.8977 22.9994 14.0615V11.0342C22.9994 10.1986 22.3555 9.52051 21.562 9.52051ZM21.562 14.0615H18.6873V11.0342H21.562V14.0615Z" fill="#EF6D1D"/>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M4.31204 18.6025H1.43735C0.643213 18.6025 0 19.2799 0 20.1162V23.1435C0 23.9798 0.643213 24.6571 1.43735 24.6571H4.31204C5.10618 24.6571 5.74939 23.9798 5.74939 23.1435V20.1162C5.74939 19.2807 5.10618 18.6025 4.31204 18.6025ZM4.31204 23.1435H1.43735V20.1162H4.31204V23.1435Z" fill="#EF6D1D"/>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9331 18.6025H10.0584C9.26431 18.6025 8.62109 19.2799 8.62109 20.1162V23.1435C8.62109 23.9798 9.26431 24.6571 10.0584 24.6571H12.9331C13.7266 24.6571 14.3705 23.9798 14.3705 23.1435V20.1162C14.3705 19.2807 13.7266 18.6025 12.9331 18.6025ZM12.9331 23.1435H10.0584V20.1162H12.9331V23.1435Z" fill="#EF6D1D"/>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M21.562 18.6025H18.6873C17.8932 18.6025 17.25 19.2799 17.25 20.1162V23.1435C17.25 23.9798 17.8932 24.6571 18.6873 24.6571H21.562C22.3555 24.6571 22.9994 23.9798 22.9994 23.1435V20.1162C22.9994 19.2807 22.3555 18.6025 21.562 18.6025ZM21.562 23.1435H18.6873V20.1162H21.562V23.1435Z" fill="#EF6D1D"/>
                                      </svg>
                                          
                                      <h2>Grid</h2> 
                                  </a> 
                              </div>
                              <div class="grid calender_sort inline flex flex-row justify-center items-center" id="calender">
                              <a href="<?= get_page_link(1054) ?>" class="inline flex flex-row justify-center items-center">
                                  <svg width="22" height="25" viewBox="0 0 22 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M21.1095 2.86192H18.5885V2.41435C18.5885 1.52322 17.8645 0.79834 16.975 0.79834C16.0826 0.79834 15.3568 1.52352 15.3568 2.41435V2.86192H12.5918V2.41435C12.5918 1.52322 11.8669 0.79834 10.9761 0.79834C10.084 0.79834 9.35821 1.52352 9.35821 2.41435V2.86192H6.5932V2.41435C6.5932 1.52322 5.86832 0.79834 4.97749 0.79834C4.08636 0.79834 3.36148 1.52352 3.36148 2.41435V2.86192H0.849405C0.593694 2.86192 0.386719 3.0692 0.386719 3.32461V23.5853C0.386719 23.8407 0.593694 24.048 0.849405 24.048H21.1098C21.3655 24.048 21.5725 23.8407 21.5725 23.5853V3.32461C21.5722 3.0692 21.3652 2.86192 21.1095 2.86192ZM16.2819 2.41435C16.2819 2.03371 16.5928 1.72371 16.9746 1.72371C17.354 1.72371 17.6628 2.03371 17.6628 2.41435V4.57047C17.6628 4.95141 17.354 5.26141 16.9746 5.26141C16.5928 5.26141 16.2819 4.95141 16.2819 4.57047V2.41435ZM10.2836 2.41435C10.2836 2.03371 10.5942 1.72371 10.9761 1.72371C11.3567 1.72371 11.6664 2.03371 11.6664 2.41435V4.57047C11.6664 4.95141 11.3567 5.26141 10.9761 5.26141C10.5942 5.26141 10.2836 4.95141 10.2836 4.57047V2.41435ZM4.28686 2.41435C4.28686 2.03371 4.59655 1.72371 4.97749 1.72371C5.35813 1.72371 5.66782 2.03371 5.66782 2.41435V4.57047C5.66782 4.95141 5.35813 5.26141 4.97749 5.26141C4.59686 5.26141 4.28686 4.95141 4.28686 4.57047V2.41435ZM20.6468 23.1223H1.31178V3.78699H3.36118V4.57016C3.36118 5.4616 4.08605 6.18648 4.97719 6.18648C5.86801 6.18648 6.59289 5.46129 6.59289 4.57016V3.78699H9.3579V4.57016C9.3579 5.4616 10.0837 6.18648 10.9758 6.18648C11.8666 6.18648 12.5915 5.46129 12.5915 4.57016V3.78699H15.3565V4.57016C15.3565 5.4616 16.0826 6.18648 16.9746 6.18648C17.8645 6.18648 18.5882 5.46129 18.5882 4.57016V3.78699H20.6465V23.1223H20.6468Z" fill="#333333" stroke="#333333" stroke-width="0.5"/>
                                      <path d="M16.5924 10.4654C16.3898 10.3103 16.0992 10.3482 15.9438 10.5518L10.1666 18.101L6.34116 13.397C6.18014 13.1987 5.88834 13.1687 5.69031 13.3298C5.49197 13.4911 5.46205 13.7826 5.62338 13.9806L9.81871 19.1399C9.90662 19.2481 10.0383 19.3108 10.1778 19.3108C10.1799 19.3108 10.1824 19.3108 10.1845 19.3108C10.3261 19.3086 10.4591 19.2417 10.5451 19.1291L16.6788 11.1141C16.834 10.9114 16.7954 10.6209 16.5924 10.4654Z" fill="#333333" stroke="#333333" stroke-width="0.5"/>
                                      </svg>
                                  <h2>
                                      Calender</h2>
                              </a>
                              </div>
                          </div>
                      </div>
  
                      <div class="events-show grid">
                          <div class="events-show-grid">
                              <div class="container flex flex-wrap flex-row">
                              <?php
                                  $paged = get_query_var('paged') ? get_query_var( 'paged' ) : 1;
                                  $terms = $_GET['category'] ? $_GET['category'] : '';
                                  $args = array('post_type' => 'events', 
                                      'posts_per_page' => 8, 
                                      'paged' => $paged,
                                      'meta_query' => array(
                                          array(
                                              'key' => 'events_date',
                                              'orderby' => 'meta_value',
                                              'order'	    => 'DESC',
                                              'value' => $_GET['date'] ? date('Y-m-1', $_GET['date']) : date('2018-01-1'),
                                              'compare' => '>=',
                                              'type' => 'DATE'
                                          ),
                                          array(
                                              'key' => 'events_date',
                                              'orderby' => 'meta_value',
                                              'order'	    => 'DESC',
                                              'value' => $_GET['date'] ? date('Y-m-t', $_GET['date']) : '',
                                              'compare' => $_GET['date'] ? '<=' : 'LIKE',
                                              'type' => 'DATE'
                                          ),
                                  // this array results in no return for both arrays
                                          array(
                                              'key' => 'members_only',
                                              'value' => 0,
                                              'compare' => '='
                                          ),
                                          'relation' => 'AND',
                                      ),
                                      'meta_key' => 'events_date',
                                      'orderby'   => 'meta_value',
                                      'order'	    => 'DESC',
                                  );
                                  $terms = $_GET['category'] ? $_GET['category'] : '';
                                  if ( $terms != '' ) {
                                      $args['tax_query'] = [
                                          [
                                              'taxonomy' => 'events_category',
                                              'field' => 'slug',
                                              'terms' => $terms,
                                              'current_category' => 1,
                                          ]
                                      ];
                                  }
                                  $query = new WP_Query($args);
                                  $postCount = 0;
                                  while($query -> have_posts()) : $query -> the_post();
                                  $postCount++;
                                  $events_date = get_field('events_date');
                                  $events_link = get_post_meta($query->post->ID, 'events_link');
                                  $events_location = get_post_meta($query->post->ID, 'events_location');
                                  $events_ticket_price = get_post_meta($query->post->ID, 'events_ticket_price');
                                  $events_starting_time = get_post_meta($query->post->ID, 'events_starting_time');
                                  $events_ending_time = get_post_meta($query->post->ID, 'events_ending_time');
                                  $members_only = get_post_meta($query->post->ID, 'members_only');
                                  $events_permalink = get_the_permalink($query->post->ID);
                                  $terms = wp_get_post_terms( $query->post->ID, 'events_category' );
                                  $category = $terms[0]->name;
                                  $featuredImageUrl = get_the_post_thumbnail_url($query->post->ID);
  
                              ?>
                                  <?php if ($postCount == 1) { ?>
                                      <div class="item item-1" style="background: url(<?= $featuredImageUrl ?>) no-repeat center;width: 100%;max-width: 66.20%;background-size: cover; <?php if($postCount%3 == 2) echo 'margin-right: 0px;' ?>" onclick="document.location.href='<?= $events_permalink ?>'">
                                          <div class="events-list-item flex">
                                              <div class="event-single-content flex justify-center contents-center">
                                                  <div class="events-single-header-bg w-full">
                                                      <div class="events-single-header flex justify-between">
                                                          <div class="events-date">
                                                              <p class="text-white">When- <?= $events_date; ?></p>
                                                          </div>
                                                          <div class="events-cat">
                                                              <p class="text-white"><?= $category; ?></p>
                                                          </div>
                                                      </div>
                                                      <div class="events-title-header-bg mt-5 xl:mt-16">
                                                          <div class="events-title-header">
                                                              <a href="<?= $events_permalink; ?>">
                                                                  <h2 class="text-white">
                                                                      {!! App\limit_character(get_the_title(), '60') !!}
                                                                  </h2>
                                                              </a>
                                                          </div>
                                                          <div class="events-description-bg mt-16 xl:mt-29">
                                                              <div class="events-description  custom-header-size max-w-419.97 hidden md:block">
                                                                  <p class="text-white">{!! App\limit_character(get_the_excerpt(), '180') !!}</p>
                                                              </div>
                                                              <div class="event-readmore mt-33">
                                                                  <div class="button"><a href="<?= $events_permalink; ?>" class="text-white flex justify-center items-center align-center">read more </a></div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  <?php } else if  ($postCount == 2) { ?>
                                      <div class="item item-2" style="background: url(<?= $featuredImageUrl ?>) no-repeat center;width: 100%;max-width: 32.685%;background-size: cover; <?php if($postCount%3 == 2) echo 'margin-right: 0px;' ?>"  onclick="document.location.href='<?= $events_permalink ?>'">
                                          <div class="events-list-item flex">
                                              <div class="event-single-content flex justify-center contents-center">
                                                      <div class="events-single-header-bg w-full">
                                                          <div class="events-single-header flex justify-between">
                                                              <div class="events-date">
                                                                  <p class="text-white">When- <?= $events_date; ?> </p>
                                                              </div>
                                                              <div class="events-cat">
                                                                  <p class="text-white"><?= $category; ?></p>
                                                              </div>
                                                          </div>
                                                          <div class="events-title-header-bg mt-5">
                                                              <div class="events-title-header cutom-event-size-2">
                                                                  <a href="<?= $events_permalink; ?>">
                                                                      <h2 class="text-white">
                                                                          {!! App\limit_character(get_the_title(), '50') !!}
                                                                      </h2>
                                                                  </a>
                                                              </div>
                                                              <div class="events-description-bg mt-29">
                                                                  <div class="event-readmore custom-margin-top">
                                                                      <div class="button"><a href="<?= $events_permalink; ?>" class="text-white flex justify-center items-center align-center">read more </a></div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                          </div>
                                      </div>
                                  <?php 
                                  }     else { ?>
                                  <div class="item item-2" style="background: url(<?= $featuredImageUrl ?>) no-repeat center;width: 100%;max-width: 32.685%;background-size: cover; <?php if($postCount%3 == 2) echo 'margin-right: 0px;' ?>" onclick="document.location.href='<?= $events_permalink ?>'">
                                      <div class="events-list-item flex">
                                          <div class="event-single-content flex justify-center contents-center">
                                                  <div class="events-single-header-bg w-full">
                                                      <div class="events-single-header flex justify-between">
                                                          <div class="events-date">
                                                              <p class="text-white">When- <?= $events_date; ?> </p>
                                                          </div>
                                                          <div class="events-cat">
                                                              <p class="text-white"><?= $category; ?></p>
                                                          </div>
                                                      </div>
                                                      <div class="events-title-header-bg mt-16">
                                                          <div class="events-title-header custom-text-header">
                                                              <a href="<?= $events_permalink; ?>">
                                                                  <h2 class="text-white">
                                                                      {!! App\limit_character(get_the_title(), '35') !!}
                                                                  </h2>
                                                              </a>
                                                          </div>
                                                          <div class="events-description-bg mt-29">
                                                              <div class="event-readmore mt-78">
                                                                  <div class="button"><a href="<?= $events_permalink; ?>" class="text-white flex justify-center items-center align-center">read more </a></div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                      </div>
                                  </div>
                              <?php }
                                  endwhile; ?>
                              </div>
                          </div>
                          {!! App\pagination($query->max_num_pages, 'events') !!}
                  </div>
              </div>
          </div>
  
      </section>
      <script type="text/javascript">
          function loadType(value, url, type) {
              document.location.href = url + type + '=' + value; 
          }
      </script>
  @endsection