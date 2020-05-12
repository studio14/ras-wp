<?php
/**
 * Plugin Name: WP REST API - Filter posts date wise using given column
 * Plugin URI:  https://github.com/vignesh-s/filter_post_using_date_query_column
 * Description: In WordPress 4.7, Posts cannot be filtered based on modified, modified_gmt, date_gmt fields. Using this plugin we can specify the column(any of date, date_gmt, modified, modified_gmt) as query parameter "date_query_column" to query against value(s) given in "before" and/or "after" query parameters.
 * Author:      Vignesh Sundar
 * Author URI: 	https://github.com/vignesh-s/
 * Version: 	0.1
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 **/

add_action( 'rest_api_init', 'rest_api_add_post_date_query_column_each_post_type' );

 /**
  * Add date_query_column & filter posts in each post type
  **/
function rest_api_add_post_date_query_column_each_post_type() {
	foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
		add_filter( 'rest_' . $post_type->name . '_collection_params', 'rest_api_add_post_date_query_column_param');
        add_filter( 'rest_' . $post_type->name . '_query', 'rest_api_filter_posts_using_date_query_column', 10, 2 );
	}
}

/**
 * Add the query parameter
 *
 * @param  array $query_params The query arguments.
 * @return array $query_params.
 **/
function rest_api_add_post_date_query_column_param( $query_params ) {
	$query_params['date_query_column'] = [
            'description' => __( 'The date query column.' ),
            'type'        => 'string',
            'enum'        => ['post_date', 'post_date_gmt', 'post_modified', 'post_modified_gmt'],
        ];
    return $query_params;
}

/**
 * Filter posts based on date_query_column parameter if before/after param is present.
 *
 * @param  array           $args    The query arguments.
 * @param  WP_REST_Request $request Full details about the request.
 * @return array $args.
 **/
function rest_api_filter_posts_using_date_query_column( $args, $request ) {
	if ( ! isset( $request['before'] ) && ! isset( $request['after'] )  )
        return $args;

    if( isset( $request['date_query_column'] ) )
        $args['date_query'][0]['column'] = 'post_' . $request['date_query_column'];

    return $args;
}
