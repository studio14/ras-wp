<?php

include_once("functions.php");

add_action( 'rest_api_init', function() {
  register_rest_route( 'ras/v1', '/events', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_events'
  ));

  register_rest_route( 'ras/v1', '/events/dates', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_events_dates'
  ));

  register_rest_route( 'ras/v1', '/event', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_event'
  ));

  register_rest_route( 'ras/v1', '/events/category', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_event_category'
  ));

  register_rest_route( 'ras/v1', '/events/categories', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_all_event_category'
  ));

  register_rest_route( 'ras/v1', '/events/categories/all', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_all_event_categories'
  ));
});

function api_get_events( $request ) {
  $posts_data = array();
  $per_page = $request->get_param('per_page');
  $page = $request->get_param('page');
  $selectedCategory = $request->get_param('category_id');
  $events_date = $request->get_param('events_date');

  $category = get_term_by( 'id', $selectedCategory, 'events_category' );
  if($category != '') {
    $args = [
      'post_type' => 'events',
      'numberposts' => $per_page ? $per_page : 5,
      'paged' => $page,
      'meta_query' => array (
      'relation' => 'AND',
      array(
          'relation' => 'OR',
          array(
              'key'     => 'duplicate_event',
              'value'   => '1',
              'compare' => '!=',
          ),
          array(
              'key'     => 'duplicate_event',
              'compare' => 'NOT EXISTS',
              'value'   => '1', 
          ),
      ),
          array (
              'relation' => 'AND',
              array(
                  'key' => 'events_date', 
                  'orderby' => 'meta_value',
                  'order'	    => 'DESC',
                  'value' => $events_date ? date('Y-m-1', $events_date) : date('2013-01-1'),
                  'compare' => '>=',
                  'type' => 'DATE'
              ),
              array(
                  'key' => 'events_date',
                  'orderby' => 'meta_value',
                  'order'	    => 'DESC',
                  'value' => $events_date ? date('Y-m-t', $events_date) : '',
                  'compare' => $events_date ? '<=' : 'LIKE',
                  'type' => 'DATE'
              ),
          )
      ),
      'tax_query' => array(
        array(
            'taxonomy' => 'events_category',
            'field' => 'term_id',
            'terms' => $category ? $category->term_id : '',
        )
      )
    ];

    $eventsArgs = [
      'numberposts' => -1,
      'post_type' => 'events',
      'tax_query' => array(
        array(
            'taxonomy' => 'events_category',
            'field' => 'term_id',
            'terms' => $category->term_id,
        )
      )
    ];
  }
  else {
    $args = array(
      'post_type' => 'events',
      'numberposts' => $per_page ? $per_page : 5,
      'paged' => $page,
      'meta_query' => array (
      'relation' => 'AND',
      array(
          'relation' => 'OR',
          array(
              'key'     => 'duplicate_event',
              'value'   => '1',
              'compare' => '!=',
          ),
          array(
              'key'     => 'duplicate_event',
              'compare' => 'NOT EXISTS',
              'value'   => '1', 
          ),
      ),
          array (
              'relation' => 'AND',
              array(
                  'key' => 'events_date', 
                  'orderby' => 'meta_value',
                  'order'	    => 'DESC',
                  'value' => $events_date ? date('Y-m-1', $events_date) : date('2013-01-1'),
                  'compare' => '>=',
                  'type' => 'DATE'
              ),
              array(
                  'key' => 'events_date',
                  'orderby' => 'meta_value',
                  'order'	    => 'DESC',
                  'value' => $events_date ? date('Y-m-t', $events_date) : '',
                  'compare' => $events_date ? '<=' : 'LIKE',
                  'type' => 'DATE'
              ),
          )
      ),
    );

    $eventsArgs = [
      'numberposts' => -1,
      'post_type' => 'events',
      'meta_query' => array (
      'relation' => 'AND',
        array(
            'relation' => 'OR',
            array(
                'key'     => 'duplicate_event',
                'value'   => '1',
                'compare' => '!=',
            ),
            array(
                'key'     => 'duplicate_event',
                'compare' => 'NOT EXISTS',
                'value'   => '1', 
            ),
        ),
            array (
                'relation' => 'AND',
                array(
                    'key' => 'events_date', 
                    'orderby' => 'meta_value',
                    'order'	    => 'DESC',
                    'value' => $events_date ? date('Y-m-1', $events_date) : date('2013-01-1'),
                    'compare' => '>=',
                    'type' => 'DATE'
                ),
                array(
                    'key' => 'events_date',
                    'orderby' => 'meta_value',
                    'order'	    => 'DESC',
                    'value' => $events_date ? date('Y-m-t', $events_date) : '',
                    'compare' => $events_date ? '<=' : 'LIKE',
                    'type' => 'DATE'
                ),
          )
      ),
    ];
  }
  $posts = get_posts($args);

  $totalEvents = get_posts($eventsArgs);

  $posts_data['totalItems'] = count($totalEvents);
  $posts_data['itemCount'] = count($posts);
  $posts_data['pageCount'] = ceil($posts_data['totalItems'] / $per_page);

  if($posts) {
    foreach ($posts as $post) {
      $post_thumbnail = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail_url( $post->ID ) : null;
      $posts_data['data'][] = array( 
        'id' => $post->ID, 
        'slug' => $post->post_name,
        'post_title' => $post->post_title,
        'events_date' => get_field('events_date', $post), 
        'featured_image' => $post_thumbnail,
        // 'post_content' => $post->post_content,
        // 'post_excerpt' => $post->post_excerpt,
        // 'events_starting_time' => get_field('events_starting_time', $post), 
        // 'events_ending_time' => get_field('events_ending_time', $post), 
        // 'events_link' => get_field('events_link', $post), 
        // 'events_location' => get_field('events_location', $post), 
        // 'events_ticket_price' => get_field('events_ticket_price', $post), 
        // 'members_only' => get_field('members_only', $post), 
        // 'duplicate_event' => get_field('duplicate_event', $post),
        // 'add_to_calender_link' => get_field('add_to_calender_link', $post),
        // 'post_date' => $post->post_date,
        // 'categories' => returnCategories($post->ID, 'events_category'),
      );
    }

    if($category) {
      $posts_data['category'] = array(
        'id' => $category->term_id,
        'name' => $category->name,
        'slug' => $category->slug,
      );
    }
    else $posts_data['items']['category'] = [];
  }
  else {
    return failedResponse();
  }
  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 200 );
  return $response;
}

function api_get_event($request) {
  $slug = $request->get_param('slug');
  $args = array(
    'name'        => $slug,
    'post_type'   => 'events',
    'numberposts' => 1
  );

  $event = get_posts($args);
  var_dump($event);
  $event = $event[0];

  if($event) {
    $post_thumbnail = ( has_post_thumbnail( $event->ID ) ) ? get_the_post_thumbnail_url( $event->ID ) : null;
    $post_data = array(
      'id' => $event->ID,
      'post_name' => $event->post_name,
      'post_content' => $event->post_content,
      'post_title' => $event->post_title,
      'post_excerpt' => $event->post_excerpt,
      'featured_image' => $post_thumbnail,
      'events_starting_time' => get_field('events_starting_time', $event->ID),
      'events_ending_time' => get_field('events_ending_time', $event->ID),
      'events_date' => get_field('events_date', $event),
      'events_link' => get_field('events_link', $event),
      'events_location' => get_field('events_location', $event),
      'events_ticket_price' => get_field('events_ticket_price', $event),
      'add_to_calender_link' => get_field('add_to_calender_link', $event),
      'post_date' => get_field('post_date', $event), 
      'categories' => returnCategories($event, 'events_category'),
    );
  }
  else return failedResponse();

  $response = new WP_REST_Response( $post_data );
  $response->set_status( 200 );
  return $response;
}

function api_get_event_category($request) {
  $slug = $request->get_param('slug');
  $posts_per_page = $request->get_param('per_page');
  $page = $request->get_param('page');

  $category = get_term_by( 'slug', $slug, 'events_category' );

  $args = [
    'post_type' => 'events',
    'numberposts' => $posts_per_page ? $posts_per_page : 5,
    'paged' => $page,
    'tax_query' => array(
      array(
          'taxonomy' => 'events_category',
          'field' => 'term_id',
          'terms' => $category->term_id,
      )
    )
  ];
  $catEvents = get_posts($args);

  $totalEvents = get_posts(array(
    'numberposts' => -1,
    'post_type' => 'events',
    'tax_query' => array(
      array(
          'taxonomy' => 'events_category',
          'field' => 'term_id',
          'terms' => $category->term_id,
      )
    )
  ));

  $posts_data['totalItems'] = count($totalEvents);
  $posts_data['pageCount'] = ceil($posts_data['totalItems'] / $posts_per_page);
  $posts_data['itemCount'] = count($catEvents);

  if($catEvents && $category) {
    foreach($catEvents as $post) {
      $post_thumbnail = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail_url( $post->ID ) : null;
      $posts_data['items']['events'][] = (object) array( 
          'id' => $post->ID, 
          'slug' => $post->post_name,
          'post_content' => $post->post_content,
          'post_title' => $post->post_title,
          'post_excerpt' => $post->post_excerpt,
          'featured_image' => $post_thumbnail,
          'events_starting_time' => get_field('events_starting_time', $post), 
          'events_ending_time' => get_field('events_ending_time', $post), 
          'events_date' => get_field('events_date', $post), 
          'events_link' => get_field('events_link', $post), 
          'events_location' => get_field('events_location', $post), 
          'events_ticket_price' => get_field('events_ticket_price', $post), 
          'members_only' => get_field('members_only', $post), 
          'duplicate_event' => get_field('duplicate_event', $post),
          'add_to_calender_link' => get_field('add_to_calender_link', $post),
          'post_date' => $post->post_date,
          'category' => returnCategories($post, 'events_category'),
      );
    }

    $posts_data['items']['category'] = array(
      'id' => $category->term_id,
      'name' => $category->name,
      'slug' => $category->slug,
    );
  }
  else {
    return failedResponse();
  }

  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 200 );
  return $response;
}

function api_get_all_event_categories() {
  $categories = get_categories(array(
    'taxonomy' => 'events_category'
  ));
  if($categories) {
    foreach ($categories as $category) {
      $posts_data[] = (object) array( 
        'id' => $category->term_id,
        'name' => $category->name,
        'slug' => $category->slug,
      );
    }
  }
  else return failedResponse();

  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 200 );
  return $response;
}


function api_get_all_event_category($request) {
  $slug = $request->get_param('slug');

  $category = get_term_by( 'slug', $slug, 'events_category' );

  if($category) {
    $post_data = array(
      'id' => $category->term_id,
      'name' => $category->name,
      'slug' => $category->slug,
    );
  }
  else return failedResponse();

  $response = new WP_REST_Response( $post_data );
  $response->set_status( 200 );
  return $response;
}

function api_get_events_dates($request) {
    $events = query_posts( array(
        'post_type' => 'events',
        'meta_key' => 'events_date',
        'meta_compare' => '>',
        'meta_value' => date ('2011-01-01'),
        'meta_type'  => 'DATE',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'orderby' => 'meta_value',
        'order' => 'DESC',
    ) );

    $current_month = '';

    $posts_data = array();

     foreach($events as $event){
        $event_date =  get_post_meta($event->ID, 'events_date', $single = true);
        $event_month = date('F Y', strtotime($event_date));
        if($current_month != $event_month){
            $posts_data[] = (object) array(
                'date' => date('F Y', strtotime($event_date)),
                'timestamp' => strtotime($event_date),
                'month' => date('F', strtotime($event_date)),
                'year' => date('Y', strtotime($event_date)),
            );
        }

        $current_month = $event_month;   
    }

    return $posts_data;
}