<?php


include_once('functions.php');

add_action( 'rest_api_init', function() {
  register_rest_route( 'ras/v1', '/posts', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_posts'
  ));

  register_rest_route( 'ras/v1', '/posts/count', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_posts_count'
  ));

  register_rest_route( 'ras/v1', '/post', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_post'
  ));

  register_rest_route( 'ras/v1', '/posts/category', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_post_category'
  ));

  register_rest_route( 'ras/v1', '/posts/categories', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_all_post_category'
  ));

  register_rest_route( 'ras/v1', '/posts/categories/all', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_all_post_categories'
  ));

  register_rest_route( 'ras/v1', '/posts/dates', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_posts_dates'
  ));

});

function api_get_posts($request) {
  $posts_data = array();
  $posts_per_page = $request->get_param('per_page');
  $categorySlug = $request->get_param('category_id');
  $page = $request->get_param('page');
  $posts_date = $request->get_param('posts_date') ? $request->get_param('posts_date') : '';

  $category = get_term_by( 'id', $categorySlug, 'category' );

  if($category) {
    $args = [
      'numberposts' => $posts_per_page ? $posts_per_page : 10,
      'paged' => $page,
      'category' => $category->term_id,
      'date_query' => [
            'year' => date('Y', $posts_date),
            'month' => date('m', $posts_date),
        ]
    ];

    $eventArgs = [
      'numberposts' => -1,
      'category' => $category->term_id,
      'date_query' => [
            'year' => date('Y', $posts_date),
            'month' => date('m', $posts_date),
        ]
    ];

  }
  else {
    $args = [
      'numberposts' => $posts_per_page ? $posts_per_page : 6,
      'paged' => $page,
      'date_query' => [
            'year' => date('Y', $posts_date),
            'month' => date('m', $posts_date),
        ]
    ];
    $eventArgs = [
      'numberposts' => -1,
      'date_query' => [
            'year' => date('Y', $posts_date),
            'month' => date('m', $posts_date),
        ]
    ];
  }
  $posts = get_posts($args);

  $totalPosts = get_posts($eventArgs);

  $posts_data['totalItems'] = count($totalPosts);
  $posts_data['pageCount'] = ceil($posts_data['totalItems'] / $posts_per_page);
  $posts_data['itemCount'] = count($posts);

  $categories = get_categories(array(
    'taxonomy' => 'category'
  ));

  if($posts && $categories) {
    foreach ($posts as $post) {
      $post_thumbnail = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail_url( $post->ID ) : null;
      $posts_data['data'][] = (object) array( 
        'id' => $post->ID, 
        'slug' => $post->post_name, 
        'type' => $post->post_type,
        'title' => $post->post_title,
        'featured_img_src' => $post_thumbnail,
        'content' => $post->post_content,
        'excerpt' => get_the_excerpt($post),
        'post_date' => $post->post_date,
        'home_only' => get_field('home_only', $post),
        'categories' => returnCategories($post, 'category'),
      );
    }

    if($category) {
      $posts_data['category'] = array(
        'id' => $category->term_id,
        'name' => $category->name,
        'slug' => $category->slug,
      );
    }
    else $posts_data['category'] = [];
  }
  else {
    return failedResponse();
  }

  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 200 );
  return $response;
}

function api_get_post($request) {
  $post_data = array();
  $slug = $request->get_param('slug');
  $args = array(
    'name' => $slug
  );
  $post = get_posts($args);
  $post = $post[0];

  if($post) {
    $post_thumbnail = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail_url( $post->ID ) : null;
    $post_data = array(
      'id' => $post->ID,
      'title' => $post->post_title,
      'featured_img_src' => $post_thumbnail,
      'slug' => $post->post_name,
      'content' => $post->post_content,
      'type' => $post->post_type,
      'post_date' => $post->post_date, 
      'category' => returnCategories($post, 'category'),
    );
  }
  else return failedResponse();

  $response = new WP_REST_Response( $post_data );
  $response->set_status( 200 );
  return $response;

}

function api_get_post_category($request) {
  $slug = $request->get_param('slug');
  $posts_per_page = $request->get_param('per_page');
  $page = $request->get_param('page');

  $category = get_term_by( 'slug', $slug, 'category' );

  $args = [
    'post_type' => 'post',
    'numberposts' => $posts_per_page ? $posts_per_page : 6,
    'paged' => $page,
    'tax_query' => array(
      array(
          'taxonomy' => 'category',
          'field' => 'term_id',
          'terms' => $category->term_id,
      )
  )
  ];
  $catPosts = get_posts($args);

  

  $categories = get_categories(array(
    'taxonomy' => 'category'
  ));

  $totalPosts = get_posts(array(
    'numberposts' => -1,
    'tax_query' => array(
      array(
          'taxonomy' => 'category',
          'field' => 'term_id',
          'terms' => $category->term_id,
      )
    )
  ));

  $posts_data['totalItems'] = count($totalPosts);
  $posts_data['pageCount'] = ceil($posts_data['totalItems'] / $posts_per_page);
  $posts_data['itemCount'] = count($catPosts);

  if($catPosts && $category) {
    foreach($catPosts as $post) {
      $post_thumbnail = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail_url( $post->ID ) : null;
      $posts_data['items']['blogs'][] = (object) array( 
         'id' => $post->ID,
        'title' => $post->post_title,
        'featured_img_src' => $post_thumbnail,
        'slug' => $post->post_name,
        'content' => $post->post_content,
        'type' => $post->post_type,
        'post_date' => $post->post_date, 
        'category' => returnCategories($post, 'category'),
      );
    }

    $posts_data['items']['category'] = array(
      'id' => $category->term_id,
      'name' => $category->name,
      'slug' => $category->slug,
    );

    foreach ($categories as $category) {
      $posts_data['items']['categories'][] = (object) array( 
        'id' => $category->term_id,
        'name' => $category->name,
        'slug' => $category->slug,
      );
    }
  }
  else {
    return failedResponse();
  }

  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 200 );
  return $response;
}

function api_get_all_post_categories() {
  $categories = get_categories(array(
    'taxonomy' => 'category'
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

function api_get_all_post_category($request) {
  $slug = $request->get_param('slug');

  $category = get_term_by( 'slug', $slug, 'category' );

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

function api_get_posts_count() {
  $posts = get_posts(array(
    'numberposts' => -1,
  ));

  $posts_data['count'] = count($posts);

  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 200 );
  return $response;
}

function api_get_posts_dates($request) {
    $posts_data = array();
    global $wpdb;
    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE  post_status = 'publish' ORDER BY post_date DESC");

    foreach($years as $year) {
        $months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND YEAR(post_date) = '".$year."' ORDER BY post_date DESC");

        foreach($months as $month) {
            $mkdate = date('F Y', mktime(0,0,0, $month, 0, $year));
            $posts_data [] = (object) array(
                'date' => $mkdate,
                'timestamp' => strtotime($mkdate),
                'month' => date('F', strtotime($mkdate)), 
                'year' => date('Y', strtotime($mkdate)),
            );
        }  
    }
    return $posts_data;
}

?>