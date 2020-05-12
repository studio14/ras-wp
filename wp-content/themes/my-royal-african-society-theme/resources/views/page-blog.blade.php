{{--
  Template Name: Blog Template
--}}

@extends('layouts.app')

@section('content')

<section id="events">
    <div class="container events-container">
        <div class="container events-title-bg flex text-left justify-left">
            <div class="title" style="max-width: 454px;">
                <h2> {{ App::title() }}</h2>
                <hr/>
            </div>
        </div>
        <?php


        ?>
        <div class="events-content">
                <div class="container events-filter-bg">
                <div class="events-filter flex justify-between align-center items-center">
                  <div class="events-filter-section-1 inline flex flex-row flex-wrap">
                      <div class="input-type-bg flex-wrap">
                          <div class="input-type-bg flex-wrap">
                            <label for="show_input">Show</label>
                            <select name="show_all" id="show_input" onchange="loadType(this.value, '<?= get_page_link(13) ?>', '<?php  if (isset($_GET['date'])) echo '?date='.$_GET['date'].'&'; else echo '?' ?>category');" >
                                <option value="">All </option>
                                <?php 
                                $categories = get_categories();
                                foreach ($categories as $category) {
                                ?>
                                <option value="<?= $category->slug ?>" <?php if(isset($_GET['category']) && $category->slug == $_GET['category'] ) echo 'selected' ?> ><?= $category->name ?></option>
                                <?php } ?>

                            </select>
                          </div>
                        <?php
                            $args = array('post_type' => 'events');
                            $query = new WP_Query($args);
                        ?>
                        <?php $args = array(
                            'type'            => 'monthly',
                            'limit'           => '',
                            'format'          => 'custom', 
                            'before'          => '',
                            'after'           => '',
                            'show_post_count' => 1,
                            'echo'            => 1,
                            'order'           => 'DESC',
                            'post_type'     => 'post'
                        );
                        ?>
                      <div class="input-type-bg">
                          <label for="dateFrom">From</label>
                          <select name="show_from" id="dateFrom" onchange="loadType(this.value, '<?= get_page_link(13) ?>', '<?php  if (isset($_GET['category'])) echo '?category='.$_GET['category'].'&'; else echo '?' ?>date');" >
                                <option value="">All </option>
                                <?php wp_get_archives( $args ); ?>
                            </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="latest-news">
              <div class="flex flex-wrap my-latest-news-container">
                <div class="latest-news-container" style="max-width: 100%;display: flex;
                flex-wrap: wrap;width:100%;">
                  <div class="news-content flex inline flex-wrap">
                  <?php
                      $wp_query = '';
                      $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                      $category = isset($_GET['category']) ? $_GET['category'] : '';
                      $postCount = 0;
                      $args = [
                        'posts_per_page' => 9,
                        'paged' => $paged,
                        'category_name' => $category,
                        'meta_key'		=> 'members_only',
                        'meta_value'	=> 0
                      ];
                      $date = $_GET['date'] ? $_GET['date'] : '';
                      if ( $date != '' ) {
                          $args['date_query'] = [
                              [
                                  'year'  => date('Y', $date),
                                  'month' => date('m', $date),
                              ]
                          ];
                      }
                      $wp_query = new WP_Query($args);
                      $numberPosts = $wp_query->found_posts;
                      while ($wp_query->have_posts()) : $wp_query->the_post();
                        if ($postCount == 0) { ?>
                  <div class="latest-news-featured">
                        <div class="latest-news-featured-bg" style="height: 100%;">
                            <div class="w-full flex flex-row flex-wrap lg:flex-no-wrap min-h-blog-height" style="height: 100%;">
                                <div class="featured-image-bg w-full lg:w-2/3" style="background-image: url('{{ get_the_post_thumbnail_url() }}')" onclick="document.location.href='{{ get_permalink() }}'">
                                </div>
                                <div class="w-full lg:w-1/3 feat_blog_details flex">
                                    <div class="text-content-bg flex flex-col">
                                        <div class="date">
                                            <p>{{ the_time('d/n/Y') }}</p>
                                        </div>
                                        <div class="title">
                                            <a href="{{ get_permalink() }}"><h2>{!! App\limit_character(html_entity_decode(get_the_title()), '35') !!}</h2></a>
                                        </div>
                                        <div class="content">
                                            <p>@php the_excerpt() @endphp</p>
                                        </div>
                                        <div class="secondary-button-bg mt-13 w-193.42 h-54 w-full">
                                            <div class="button">
                                              <a href="{{ get_permalink() }}" class="text-secondary flex justify-center items-center align-center">read more
                                              </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <?php } else  { ?>
                        <div class="item xl:w-blogitemswidth md:w-1/2 size1200:w-full w-full mr-0 pr-0 lg:pr-60 xl:pr-0 mr-0 pb-10" <?php if ($postCount % 4 == 0) echo "style='margin-right: 0;'" ?>>
                          <div class="news-cotent-bg flex-wrap @php if ($postCount == $numberPosts) echo 'last-item'; @endphp">
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
                                          $output .= '<a href="'.get_page_link(13) .'?category='.$category->slug.'" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>';
                                      
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
                                <a href="{{ get_permalink() }}">{!! App\limit_character(get_the_title(), '50') !!}</a>
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
                      <?php } $postCount++; ?>
                    <?php
                     endwhile; ?>

                    </div>

                </div>
              </div>
              {!! App\pagination($wp_query->max_num_pages, 'news') !!}
            </div>
            <?php 
            if (have_posts() == null) {
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
<script type="text/javascript">
  function loadType(value, url, type) {
      document.location.href = url + type + '=' + value;      
  }
</script>

@endsection