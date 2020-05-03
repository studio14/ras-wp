<?php


function returnTags($postID) {
  $returnTags = array();
  $tags = get_the_tags($postID);
  if ($tags) {
    foreach($tags as $tag) {
      $returnTags[] = (object) array(
        'tag_id' => $tag->term_id,
        'name' => $tag->name,
        'slug' => $tag->slug,
      );
    }
  }
  else {
    return '';
  }
  return $returnTags;
}

function returnCategories($postID, $catType) {
  $returnCat = array();
  $categories = get_the_terms($postID, $catType);
  if($categories) {
    foreach($categories as $category) {
      $returnCat[] = (object) array(
        'id' => $category->term_id,
        'name' => $category->name,
        'slug' => $category->slug,
      );
    }
  }
  else return [];

  return $returnCat;
}

function failedResponse() {
  $posts_data['success'] = false;
  $posts_data['error'] = 'does not exists';
  $response = new WP_REST_Response( $posts_data );
  $response->set_status( 500 );
  return $response;
}