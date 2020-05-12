<?php
/*
Plugin Name: Custom Taxonomy Order
Plugin URI: https://wordpress.org/plugins/custom-taxonomy-order-ne/
Description: Allows for the ordering of categories and custom taxonomy terms through a simple drag-and-drop interface.
Version: 3.1.0
Author: Marcel Pol
Author URI: https://timelord.nl/
License: GPLv2 or later
Text Domain: custom-taxonomy-order-ne
Domain Path: /lang/

/*
	Copyright 2011 - 2011  Drew Gourley
	Copyright 2013 - 2020  Marcel Pol   (email: marcel@timelord.nl)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


/*
 * TODO:
 * - Add pagination, just like next_post_link().
 *   https://wordpress.org/support/topic/how-to-create-a-navigation-in-archivephp-with-the-given-order/
 * - Order by post count (and other orderby's)
 *   https://wordpress.org/support/topic/order-terms-by-post-count/
 */


// Plugin Version
define('CUSTOMTAXORDER_VER', '3.1.0');


/*
 * Get settings for ordering this taxonomy.
 * $customtaxorder_settings is an array with key: $taxonomy->name and value: setting (0, 1, 2).
 */
function customtaxorder_get_settings() {
	$customtaxorder_defaults = array('category' => 0);

	$args = array( 'public' => true, '_builtin' => false );
	$output = 'objects';
	$taxonomies = get_taxonomies( $args, $output );
	foreach ( $taxonomies as $taxonomy ) {
		$customtaxorder_defaults[$taxonomy->name] = 0;
	}

	$customtaxorder_defaults = apply_filters( 'customtaxorder_defaults', $customtaxorder_defaults );
	$customtaxorder_settings = get_option( 'customtaxorder_settings' );
	$customtaxorder_settings = wp_parse_args( $customtaxorder_settings, $customtaxorder_defaults );

	return $customtaxorder_settings;
}


/*
 * customtax_cmp
 * Sorting of an array with objects, ordered by term_order
 * Sorting the query with get_terms() doesn't allow sorting with term_order
 */
function customtax_cmp( $a, $b ) {
	if ( (float) $a->term_order == (float) $b->term_order ) {
		return 0;
	} else if ( (float) $a->term_order < (float) $b->term_order ) {
		return -1;
	} else {
		return 1;
	}
}


/*
 * Flush object cache when order is changed in taxonomy ordering plugin.
 *
 * @since 2.7.8
 *
 */
function customtaxorder_flush_cache() {
	wp_cache_flush();
}
add_action( 'customtaxorder_update_order', 'customtaxorder_flush_cache' );


/*
 * Function to sort the standard WordPress Queries for terms.
 *
 * @return string t.orderby
 *
 */
function customtaxorder_apply_order_filter( $orderby, $args ) {
	$options = customtaxorder_get_settings();

	$taxonomy = 'category';
	if ( isset( $args['taxonomy'] ) ) {
		if ( is_string( $args['taxonomy'] ) && ! empty( $args['taxonomy'] ) ) {
			$taxonomy = $args['taxonomy'];
		} else if ( is_array( $args['taxonomy'] ) && ! empty( $args['taxonomy'] ) ) {
			// Bug: if $args[$taxonomy] is an array with tax->names it will return the orderby for the first tax.
			$taxonomy = array_shift( $args['taxonomy'] );
		}
	}

	if ( ! isset( $options[$taxonomy] ) ) {
		$options[$taxonomy] = 0; // Default if it was not set in options yet.
	}

	if ( $args['orderby'] == 'term_order_' ) { // leave for now...
		return 't.term_order';
	} elseif ( $args['orderby'] == 'name_' ) {
		return 't.name';
	} elseif ( $options[$taxonomy] == 1 && ! isset($_GET['orderby']) ) {
		return 't.term_order';
	} elseif ( $options[$taxonomy] == 2 && ! isset($_GET['orderby']) ) {
		return 't.name';
	} elseif ( $options[$taxonomy] == 3 && ! isset($_GET['orderby']) ) {
		return 't.slug';
	} else {
		return $orderby;
	}
}
add_filter('get_terms_orderby', 'customtaxorder_apply_order_filter', 10, 2);


/*
 * Set defaults in Class WP_Term_Query->parse_query();
 * Default is name now. Set it to term_order if desired.
 */
function customtaxorder_get_terms_defaults( $query_var_defaults, $taxonomies ) {
	$options = customtaxorder_get_settings();

	$taxonomy = 'category';
	if ( isset( $query_var_defaults['taxonomy'] ) ) {
		if ( is_string( $query_var_defaults['taxonomy'] ) && ! empty( $query_var_defaults['taxonomy'] ) ) {
			$taxonomy = $query_var_defaults['taxonomy'];
		}
	}

	if ( ! isset( $options[$taxonomy] ) ) {
		$options[$taxonomy] = 0; // Default if it was not set in options yet.
	}

	if ( $options[$taxonomy] == 1 ) {
		$query_var_defaults['orderby'] = 'term_order';
	} elseif ( $options[$taxonomy] == 2 ) {
		$query_var_defaults['orderby'] = 'name';
	} elseif ( $options[$taxonomy] == 3 ) {
		$query_var_defaults['orderby'] = 'slug';
	}

	return $query_var_defaults;
}
add_filter('get_terms_defaults', 'customtaxorder_get_terms_defaults', 10, 2);


/*
 * customtaxorder_wp_get_object_terms_order_filter
 *
 * Filters:
 * wp_get_object_terms is used to sort in wp_get_object_terms and wp_get_post_terms functions.
 * get_terms is used in wp_list_categories and get_terms functions.
 * get_the_terms is used in the the_tags function.
 * tag_cloud_sort is used in the wp_tag_cloud and wp_generate_tag_cloud functions (but then the get_terms filter here does nothing).
 * term_query_results is used in WP_Term_Query->get_terms() (will probably come in WP Next).
 *
 * Default sorting is by name (according to the codex).
 *
 */
function customtaxorder_wp_get_object_terms_order_filter( $terms ) {
	$options = customtaxorder_get_settings();

	$terms_old_order = $terms;

	if ( empty($terms) || ! is_array($terms) ) {
		return $terms; // only work with an array of terms
	}
	foreach ($terms as $term) {
		if ( is_object($term) && isset( $term->taxonomy ) ) {
			$taxonomy = $term->taxonomy;
		} else {
			return $terms; // not an array with objects
		}
		break; // just the first one :)
	}

	if ( !isset ( $options[$taxonomy] ) ) {
		$options[$taxonomy] = 0; // default if not set in options yet
	}
	if ( $options[$taxonomy] == 1 && ! isset($_GET['orderby']) ) {

		// no filtering so the test in wp_generate_tag_cloud() works out right for us
		// filtering will happen in the tag_cloud_sort filter sometime later
		// post_tag = default tags
		// product_tag = woocommerce product tags
		if (current_filter() == 'get_terms'  && !is_admin() ) {
			$customtaxorder_exclude_taxonomies = array('post_tag', 'product_tag');
			if ( in_array($taxonomy, apply_filters( 'customtaxorder_exclude_taxonomies', $customtaxorder_exclude_taxonomies )) ) {
				return $terms;
			}
		}

		// Sort children after the ancestor, by using a float with "ancestor.child".
		foreach ($terms as $term) {
			if ( ! $term->parent == 0 ) {
				$parents = get_ancestors( $term->term_id, $term->taxonomy, 'taxonomy' );
				if ( is_array($parents) && ! empty($parents) ) {
					$ancestor_ID = array_pop( $parents );
					$ancestor_term = get_term($ancestor_ID, $term->taxonomy);
					if ( is_object($ancestor_term) && isset($ancestor_term->term_order) ) {
						$float = floatval($term->term_order) + 10000;
						$term->term_order = floatval( strval($ancestor_term->term_order) . '.' . strval($float) );
					}
				}
			}
		}

		usort($terms, 'customtax_cmp');

		$terms_new_order = $terms;
		/*
		* Fires after term array has been ordered with usort.
		* Please be aware that this can be triggered multiple times during a request.
		*
		* @since 2.9.4
		*
		* @param array $terms_new_order ordered array with instances of WP_Term_Query.
		* @param array $terms_old_order original array with instances of WP_Term_Query.
		*/
		do_action( 'customtaxorder_terms_ordered', $terms_new_order, $terms_old_order );

		return $terms;
	}
	return $terms;
}
add_filter( 'wp_get_object_terms', 'customtaxorder_wp_get_object_terms_order_filter' );
add_filter( 'get_terms', 'customtaxorder_wp_get_object_terms_order_filter');
add_filter( 'get_the_terms', 'customtaxorder_wp_get_object_terms_order_filter' );
add_filter( 'tag_cloud_sort', 'customtaxorder_wp_get_object_terms_order_filter' );
add_filter( 'term_query_results', 'customtaxorder_wp_get_object_terms_order_filter' );


/*
 * Support Advanced Custom Fields with its Taxonomy Fields.
 */
function customtaxorder_wp_get_object_terms_order_filter_acf( $terms ) {

	if ( empty($terms) || ! is_array($terms) ) {
		return $terms; // only work with an array of terms
	}
	foreach ($terms as $term) {
		if ( ! is_object($term) || ! is_a($term, 'WP_Term') ) {
			return $terms; // not an array with terms
		}
	}

	$terms = customtaxorder_wp_get_object_terms_order_filter( $terms );

	return $terms;
}
add_filter('acf/format_value_for_api', 'customtaxorder_wp_get_object_terms_order_filter_acf', 99 );


/*
 * customtaxorder_order_categories
 * Filter to sort the categories according to term_order
 *
 */
function customtaxorder_order_categories( $categories ) {
	$options = customtaxorder_get_settings();

	$terms_old_order = $categories;

	if ( !isset ( $options['category'] ) ) {
		$options['category'] = 0; // default if not set in options yet
	}
	if ( $options['category'] == 1 && ! isset($_GET['orderby']) ) {
		usort($categories, 'customtax_cmp');

		$terms_new_order = $categories;
		/*
		* Fires after term array has been ordered with usort.
		* Please be aware that this can be triggered multiple times during a request.
		*
		* @since 2.9.4
		*
		* @param array $terms_new_order ordered array with instances of WP_Term_Query.
		* @param array $terms_old_order original array with instances of WP_Term_Query.
		*/
		do_action( 'customtaxorder_terms_ordered', $terms_new_order, $terms_old_order );

		return $categories;
	}
	return $categories;
}
add_filter( 'get_the_categories', 'customtaxorder_order_categories' );


/*
 * Set WooCommerce attribute terms to public so they can be sorted.
 * Works for WooCommerce 3.0+
 */
function customtaxorder_woocommerce_attribute_taxonomies_public( $attribute_taxonomies ) {
    foreach ( $attribute_taxonomies as $attribute_taxonomy ) {
        $attribute_taxonomy->attribute_public = 1;
    }
    return $attribute_taxonomies;
}
add_filter( 'woocommerce_attribute_taxonomies', 'customtaxorder_woocommerce_attribute_taxonomies_public' );


/*
 * Load language files.
 */
function customtaxorder_load_lang() {
	load_plugin_textdomain('custom-taxonomy-order-ne', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/');
}
add_action('plugins_loaded', 'customtaxorder_load_lang');


/*
 * Function called at activation time.
 */
function _customtaxorder_activate() {
	global $wpdb;
	$init_query = $wpdb->query("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_order'");
	if ($init_query == 0) { $wpdb->query("ALTER TABLE $wpdb->terms ADD term_order INT( 4 ) NULL DEFAULT '0'"); }
}


function customtaxorder_activate($networkwide) {
	global $wpdb;
	if (function_exists('is_multisite') && is_multisite()) {
		$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		foreach ($blogids as $blog_id) {
			switch_to_blog($blog_id);
			_customtaxorder_activate();
			restore_current_blog();
		}
	} else {
		_customtaxorder_activate();
	}
}
register_activation_hook( __FILE__, 'customtaxorder_activate' );


/*
 * Install database tables for new blog on MultiSite.
 * Deprecated action since WP 5.1.0.
 *
 */
function customtaxorder_activate_new_site($blog_id) {
	switch_to_blog($blog_id);
	_customtaxorder_activate();
	restore_current_blog();
}
add_action( 'wpmu_new_blog', 'customtaxorder_activate_new_site' );


/*
 * Install database tables for new blog on MultiSite.
 * Used since WP 5.1.0.
 * Do not use wp_insert_site, since the options table doesn't exist yet...
 *
 * @since 2.10.1
 */
function customtaxorder_wp_initialize_site( $blog ) {
	switch_to_blog( $blog->id );
	_customtaxorder_activate();
	restore_current_blog();
}
add_action( 'wp_initialize_site', 'customtaxorder_wp_initialize_site' );


if ( is_admin() ) {
	// Admin functions
	include('admin-customtaxorder.php');
	// Settingspage
	include('page-customtaxorder.php');
}
// functions for sorting taxonomies
include('taxonomies.php');
