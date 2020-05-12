<?php


function customtaxorder_register_settings() {
	register_setting('customtaxorder_settings', 'customtaxorder_settings', 'customtaxorder_settings_validate');
	register_setting('customtaxorder_settings', 'customtaxorder_taxonomies', 'customtaxorder_taxonomies_validate');
}
add_action('admin_init', 'customtaxorder_register_settings');


function customtaxorder_settings_validate($input) {
	$args = array( 'public' => true );
	$output = 'objects';
	$taxonomies = get_taxonomies( $args, $output );
	foreach ( $taxonomies as $taxonomy ) {
		if ( $input[$taxonomy->name] != 1 ) {
			if ( $input[$taxonomy->name] != 2 ) {
				if ( $input[$taxonomy->name] != 3 ) {
					$input[$taxonomy->name] = 0; //default
				}
			}
		}
	}
	$output = array();
	foreach ( $input as $key => $value) {
		$key = (string) sanitize_text_field( $key );
		$output[$key] = (int) $value;
	}
	return $output;
}
function customtaxorder_taxonomies_validate($input) {
	$input = (string) sanitize_text_field( $input );
	return $input;
}


/*
 * Add all the admin menu pages.
 */
function customtaxorder_menu() {
	$args = array( 'public' => true );
	$output = 'objects';
	$taxonomies = get_taxonomies($args, $output);

	// Also make the link_category available if activated.
	$active_plugins = get_option('active_plugins');
	if ( in_array( 'link-manager/link-manager.php', $active_plugins ) ) {
		$args = array( 'name' => 'link_category' );
		$link_category = get_taxonomies( $args, $output );
		$taxonomies = array_merge($taxonomies, $link_category);
	}

	$taxonomies = customtaxorder_sort_taxonomies( $taxonomies );
	// Set your custom capability through this filter.
	$custom_cap = apply_filters( 'customtaxorder_custom_cap', 'manage_categories' );

	//add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
	add_menu_page(__('Term Order', 'custom-taxonomy-order-ne'), __('Term Order', 'custom-taxonomy-order-ne'), $custom_cap, 'customtaxorder', 'customtaxorder_subpage', 'dashicons-list-view', 122.35);
	//add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', int $position = null )
	add_submenu_page('customtaxorder', __('Order Taxonomies', 'custom-taxonomy-order-ne'), __('Order Taxonomies', 'custom-taxonomy-order-ne'), $custom_cap, 'customtaxorder-taxonomies', 'custom_taxonomy_order');

	foreach ($taxonomies as $taxonomy ) {
		// Set your finegrained capability for this taxonomy for this custom filter.
		$custom_cap_tax = apply_filters( 'customtaxorder_custom_cap_' . $taxonomy->name, $custom_cap );
		add_submenu_page('customtaxorder', __('Order ', 'custom-taxonomy-order-ne') . $taxonomy->label, __('Order ', 'custom-taxonomy-order-ne') . $taxonomy->label, $custom_cap_tax, 'customtaxorder-'.$taxonomy->name, 'customtaxorder_subpage');
	}
	add_submenu_page('customtaxorder', __('About', 'custom-taxonomy-order-ne'), __('About', 'custom-taxonomy-order-ne'), $custom_cap, 'customtaxorder-about', 'customtaxorder_about');
}
add_action('admin_menu', 'customtaxorder_menu');


function customtaxorder_css() {
	if ( isset($_GET['page']) ) {
		$pos_page = $_GET['page'];
		$pos_args = 'customtaxorder';
		$pos = strpos($pos_page,$pos_args);
		if ( $pos === false ) {} else {
			wp_enqueue_style('customtaxorder', plugins_url( 'css/customtaxorder.css', __FILE__), false, CUSTOMTAXORDER_VER, 'screen' );
		}
	}
}
add_action('admin_print_styles', 'customtaxorder_css');


function customtaxorder_js_libs() {
	if ( isset($_GET['page']) ) {
		$pos_page = $_GET['page'];
		$pos_args = 'customtaxorder';
		$pos = strpos($pos_page,$pos_args);
		if ( $pos === false ) {} else {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'customtaxorder', plugins_url( '/js/script.js', __FILE__ ), 'jquery-ui-sortable', CUSTOMTAXORDER_VER, true );
		}
	}
}
add_action('admin_print_scripts', 'customtaxorder_js_libs');


/*
 * Add term_order input to tag edit screen.
 * @since 3.1.0
 */
function customtaxorder_tag_edit_screen() {
	$options = customtaxorder_get_settings();
	$args = array( 'public' => true );
	$output = 'objects';
	$taxonomies = get_taxonomies($args, $output);

	// Also make the link_category available if activated.
	$active_plugins = get_option('active_plugins');
	if ( in_array( 'link-manager/link-manager.php', $active_plugins ) ) {
		$args = array( 'name' => 'link_category' );
		$link_category = get_taxonomies( $args, $output );
		$taxonomies = array_merge($taxonomies, $link_category);
	}
	foreach ( $taxonomies as $taxonomy ) {
		if ( is_object($taxonomy) && isset($taxonomy->name) ) {
			if ( ! isset($options[$taxonomy->name]) ) {
				$options[$taxonomy->name] = 0; // default if not set in options yet
			}
			if ( $options[$taxonomy->name] == 1 ) { // only when custom order is enabled.
				add_action( "{$taxonomy->name}_add_form_fields",  'customtaxorder_term_order_add_form_field', 10, 1 );
				add_action( "{$taxonomy->name}_edit_form_fields", 'customtaxorder_term_order_edit_form_field', 10, 2 );
			}
		}
	}
}
add_action( 'admin_init', 'customtaxorder_tag_edit_screen' );


/*
 * Output the "term_order" form field when adding a new term.
 * @param string $taxonomy the name of the taxonomy.
 * @since 3.1.0
 */
function customtaxorder_term_order_add_form_field( $taxonomy ) {
	$options = customtaxorder_get_settings();
	if ( isset($options[$taxonomy]) && $options[$taxonomy] == 1 ) {
		?>
		<div class="form-field form-required">
			<label for="term_order">
				<?php esc_html_e( 'Order', 'custom-taxonomy-order-ne' ); ?>
			</label>
			<input type="number" pattern="[0-9.]+" name="term_order" id="term_order" value="0" size="11">
			<p class="description">
				<?php esc_html_e( 'This taxonomy is sorted based on custom order. You can choose your own order by entering a number (1 for first, etc.) in this field.', 'custom-taxonomy-order-ne' ); ?>
			</p>
		</div>
		<?php
	}
}


/*
 * Output the "term_order" form field when editing an existing term.
 * @param object $term
 * @param string $taxonomy the name of the taxonomy.
 * @since 3.1.0
 */
function customtaxorder_term_order_edit_form_field( $term = false, $taxonomy ) {
	$options = customtaxorder_get_settings();
	if ( isset($options[$taxonomy]) && $options[$taxonomy] == 1 ) {
		if ( is_object($term) && isset($term->term_order) ) {
			$term_order = $term->term_order;
		} else {
			$term_order = 0;
		}
		?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="term_order">
					<?php esc_html_e( 'Order', 'custom-taxonomy-order-ne' ); ?>
				</label>
			</th>
			<td>
				<input name="term_order" id="term_order" type="text" value="<?php echo $term_order; ?>" size="11" />
				<p class="description">
					<?php
					esc_html_e( 'This taxonomy is sorted based on custom order. You can choose your own order by entering a number (1 for first, etc.) in this field.', 'custom-taxonomy-order-ne' );
					if ( isset($term->parent) && $term->parent != 0 ) {
						echo '<br />';
						esc_html_e( 'This sub-term will be sorted after the parent term, the order entered here is relative to other sub-terms.', 'custom-taxonomy-order-ne' );
					}
					?>
				</p>
			</td>
		</tr>
		<?php
	}
}


/*
 * Set `term_order` to term when updating
 * @since 3.1.0
 * @param  int     $term_id   The ID of the term
 * @param  int     $tt_id     Not used
 * @param  string  $taxonomy  Taxonomy of the term
 */
function customtaxorder_add_term_order( $term_id = 0, $tt_id = 0, $taxonomy = '' ) {
	if ( ! isset($_POST['term_order']) ) {
		return;
	}
	if ( $term_id == 0 ) {
		return;
	}
	$term = get_term( $term_id, $taxonomy );
	if ( ! is_object( $term ) ) {
		return;
	}

	$term_order = (int) $_POST['term_order'];

	customtaxorder_set_db_term_order( $term_id, $term_order, $taxonomy );
}
add_action( 'create_term', 'customtaxorder_add_term_order', 10, 3 );
add_action( 'edit_term',   'customtaxorder_add_term_order', 10, 3 );



/*
 * Set `term_order` in database for term.
 * @since 3.1.0
 * @param  int     $term_id    The ID of the term.
 * @param  int     $term_order The order of the term.
 * @param  string  $taxonomy   Taxonomy of the term.
 */
function customtaxorder_set_db_term_order( $term_id = 0, $term_order = 0, $taxonomy = '' ) {
	global $wpdb;

	if ( $term_id == 0 ) {
		return;
	}
	$term = get_term( $term_id, $taxonomy );
	if ( ! is_object( $term ) ) {
		return;
	}

	$wpdb->query( $wpdb->prepare(
		"
			UPDATE $wpdb->terms SET term_order = '%d' WHERE term_id ='%d'
		",
		$term_order,
		$term_id
	) );
	$wpdb->query( $wpdb->prepare(
		"
			UPDATE $wpdb->term_relationships SET term_order = '%d' WHERE term_taxonomy_id ='%d'
		",
		$term_order,
		$term_id
	) );

	clean_term_cache( $term_id, $taxonomy );
}


/*
 * About page with text.
 */
function customtaxorder_about() {
	?>
	<div class='wrap'>
		<h1><?php _e('About Custom Taxonomy Order NE', 'custom-taxonomy-order-ne'); ?></h1>
		<div id="poststuff" class="metabox-holder">
			<div class="widget">
				<h2 class="widget-top"><?php _e('About this plugin.', 'custom-taxonomy-order-ne'); ?></h2>
				<p><?php _e('This plugin is being maintained by Marcel Pol from', 'custom-taxonomy-order-ne'); ?>
					<a href="http://zenoweb.nl" target="_blank" title="ZenoWeb">ZenoWeb</a>.
				</p>

				<h2 class="widget-top"><?php _e('Review this plugin.', 'custom-taxonomy-order-ne'); ?></h2>
				<p><?php _e('If this plugin has any value to you, then please leave a review at', 'custom-taxonomy-order-ne'); ?>
					<a href="https://wordpress.org/support/view/plugin-reviews/custom-taxonomy-order-ne?rate=5#postform" target="_blank" title="<?php esc_attr_e('The plugin page at wordpress.org.', 'custom-taxonomy-order-ne'); ?>">
						<?php _e('the plugin page at wordpress.org', 'custom-taxonomy-order-ne'); ?></a>.
				</p>

				<h2 class="widget-top"><?php _e('Donate to the maintainer.', 'custom-taxonomy-order-ne'); ?></h2>
				<p><?php _e('If you want to donate to the maintainer of the plugin, you can donate through PayPal.', 'custom-taxonomy-order-ne'); ?></p>
				<p><?php _e('Donate through', 'custom-taxonomy-order-ne'); ?> <a href="https://www.paypal.com" target="_blank" title="<?php esc_attr_e('Donate to the maintainer.', 'custom-taxonomy-order-ne'); ?>"><?php _e('PayPal', 'custom-taxonomy-order-ne'); ?></a>
					<?php _e('to', 'custom-taxonomy-order-ne'); ?> marcel@timelord.nl.
				</p>
			</div>
		</div>
	</div>
	<?php
}


/*
 * Add Settings link to the main plugin page.
 */
function customtaxorder_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/customtaxorder.php' ) ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=customtaxorder' ) . '">' . __( 'Settings', 'custom-taxonomy-order-ne' ) . '</a>';
	}
	return $links;
}
add_filter( 'plugin_action_links', 'customtaxorder_links', 10, 2 );
