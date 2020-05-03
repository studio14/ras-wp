<?php


include_once('functions.php');

add_action( 'rest_api_init', function() {
  register_rest_route( 'ras/v1', '/discounts', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_discounts'
  ));

  register_rest_route( 'ras/v1', '/discounts/count', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_discounts_count'
  ));

  register_rest_route( 'ras/v1', '/discount', array(
    'methods' => 'GET',
    'callback' =>  __NAMESPACE__ . '\\api_get_discount'
  ));
});

function api_get_discounts($request) {
  $posts_data = array();
  $posts_per_page = $request->get_param('per_page');
  $page = $request->get_param('page');

  $args = [
    'paged' => $page,
    'posts_per_page' => $posts_per_page !== '' ? $posts_per_page : '10',            
    'post_type' => array( 'discounts'),
    'meta_key'		=> 'discount_validity',
    'meta_value'	=> true
  ];

  $eventArgs = [
    'numberposts' => -1 ,
    'post_type' => 'discounts',
    'post_type' => array( 'discounts'),
    'meta_key'		=> 'discount_validity',
    'meta_value'	=> true
  ];

  $posts = get_posts($args);

  $totalPosts = get_posts($eventArgs);

  $posts_data['totalItems'] = count($totalPosts);
  $posts_data['pageCount'] = ceil($posts_data['totalItems'] / $posts_per_page);
  $posts_data['itemCount'] = count($posts);


  if($posts) {
    foreach ($posts as $post) {
      $post_thumbnail = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail_url( $post->ID ) : null;
      $posts_data['data'][] = (object) array( 
         'id' => $post->ID,
          'slug' => $post->post_name,
          'post_title' => $post->post_title,
          'featured_image' => $post_thumbnail,
          'discount_name' => get_field('discount_name', $post), 
          'discounts_code' => get_field('discounts_code', $post), 
          'discount_validity' => get_field('discount_validity', $post),
          'discount_document_upload' => get_field('discount_document_upload', $post),
          'store_name' => get_field('store_name', $post)
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

function api_get_discount($request) {
  $post_data = array();
  $slug = $request->get_param('slug');
  $args = array(
    'name' => $slug,
    'post_type' => 'discounts',
  );
  $post = get_posts($args);
  $post = $post[0];

  if($post) {
    $post_thumbnail = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail_url( $post->ID ) : null;
    $post_data[] = array(
      'id' => $post->ID,
      'slug' => $post->post_name,
      'post_title' => $post->post_title,
      'featured_image' => $post_thumbnail,
      'discount_name' => get_field('discount_name', $post), 
      'discounts_code' => get_field('discounts_code', $post), 
      'discount_validity' => get_field('discount_validity', $post),
      'discount_document_upload' => get_field('discount_document_upload', $post),
      'store_name' => get_field('store_name', $post),
    );
  }
  else return failedResponse();

  $response = new WP_REST_Response( $post_data );
  $response->set_status( 200 );
  return $response;

}

function api_get_discounts_count() {
  $posts = get_posts(array(
    'numberposts' => -1,
  ));

  $posts_data['count'] = count($posts);

  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 200 );
  return $response;
}


?>