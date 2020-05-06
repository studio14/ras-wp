<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' <a class="excerpt-more" href="' . get_permalink() . '">' . __('...', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);


/**
 * 
 * Add Image Magic
 * 
 */
add_filter( 'wp_image_editors', 'wpb_image_editor_default_to_gd' );
function wpb_image_editor_default_to_gd( $editors ) {
    $gd_editor = 'WP_Image_Editor_GD';
    $editors = array_diff( $editors, array( $gd_editor ) );
    array_unshift( $editors, $gd_editor );
    return $editors;
}

/**
 * Add Search Bar
 */
add_filter('wp_nav_menu_items', function ($items, $args) {
    if(!is_admin() && $args->theme_location == 'top_navigation')
        return $items."<li id='menu-item-search' class='menu-item menu-item-type-custom menu-item-object-custom menu-item-search search-icon' style='margin-left:0;margin-right:0;padding-right:0;'><a href='".get_site_url()."/search'>
        <svg width='11.5' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
        <path d='M0.749971 6.58824C0.749971 9.79741 3.41294 12.4265 6.73221 12.4265C10.0515 12.4265 12.7144 9.79741 12.7144 6.58824C12.7144 3.37907 10.0515 0.75 6.73221 0.75C3.41294 0.75 0.749971 3.37907 0.749971 6.58824Z' stroke='black' stroke-width='1.5'/>
        <line y1='-0.75' x2='6.72825' y2='-0.75' transform='matrix(0.714709 0.699422 0.714709 -0.699422 11.541 11.2941)' stroke='black' stroke-width='1.5'/>
        </svg> Search</a></li>";
 
    return $items;
}, 10, 2);

/**
 * Add Hot Action Button Bar
 */
add_filter('wp_nav_menu_items', function ($items, $args) {
    if (is_search() || is_404() || is_page(['contact-us', 'terms-of-use', 'events', 'news', 'search'])) $customClass = 'hot-action-button'; else $customClass = 'change-donate-button';  
    if($args->theme_location == 'primary_navigation' || $args->theme_location == 'mobile_navigation')
        return $items."<li id='menu-item-become-a-member' class='menu-item menu-item-type-custom menu-item-object-custom menu-item-become-a-member hot-action-button' style='margin-right: 14px;'>
        <a href='".get_page_link(32). "' style='color: #fff;text-decoration:none;padding-left:31px;padding-right:31px;padding-top:8px;padding-bottom:8px;border:1px solid #ef6d1d;' class='primary-button button-xs'
        >Become a Member</a></li>
        <li id='menu-item-donate' class='menu-item menu-item-type-custom menu-item-object-custom menu-item-donate ". $customClass ."' style='margin-right:0'>
        <a href='https://app.royalafricansociety.org/donate' target='_blank' style='color: #fff;text-decoration:none;padding-left:31px;padding-right:31px;padding-top:8px;padding-bottom:8px;border:1px solid #123234;' 
        class='secondary-button button-xs'>Donate</a></li>";
 
    return $items;
}, 10, 2);


add_filter('sage/template/page/data', function (array $data) {
    $data['top_text'] = get_field('top_text');
    $data['intro_text'] = get_field('intro_text');
    $data['mission_statement'] = get_field('mission_statement');
    $data['core_values'] = get_field('core_values');
    $data['our_history_content'] = get_field('our_history_content');
    $data['history_image'] = get_field('history_image');
    $data['our_history_bottom_text'] = get_field('our_history_bottom_text');
    $data['services_into_text'] = get_field('services_into_text');
    $data['services_description_details'] = get_field('services_description_details');
    $data['page_title'] = get_field('custom_page_titles');
    $data['introductory_text'] = get_field('introductory_text');
    $data['become_a_member_description'] = get_field('become_a_member_description');
    $data['become_a_member_title'] = get_field('become_a_member_title');
    $data['featured_image_1'] = get_field('featured_image_1');
    $data['featured_image_2'] = get_field('featured_image_2');
    $data['first_information'] = get_field('first_information');
    $data['second_information'] = get_field('second_information');
    $data['footnote'] = get_field('footnote');
    $data['main_address_info'] = get_field('main_address_info');
    $data['google_map_address'] = get_field('google_map_address');
    $data['footer_text_title'] = get_field('footer_text_title');
    $data['footer_details'] = get_field('footer_details');
    $data['link_to_web_apps'] = get_field('link_to_web_apps');
    $data['governance_content'] = get_field('governance_content');
    $data['members_only'] = get_field('members_only');
    $data['homepage_only'] = get_field('homepage_only');
    $data['discount_name'] = get_field('discount_name');
    $data['discounts_code'] = get_field('discounts_code');
    $data['events_ticket_price'] = get_field('events_ticket_price');
    $data['events_link'] = get_field('events_link');
    $data['events_location'] = get_field('events_location');
    $data['events_starting_time'] = get_field('events_starting_time');
    $data['events_ending_time'] = get_field('events_ending_time');
    $data['events_date'] = get_field('events_date');
    $data['add_to_calender_link'] = get_field('add_to_calender_link');
    $data['slider_1'] = get_field('slider_1');
    $data['slider_2'] = get_field('slider_2');
    $data['slider_3'] = get_field('slider_3');
    $data['slider_4'] = get_field('slider_4');
    $data['slider_5'] = get_field('slider_5');
    $data['home_first_section'] = get_field('home_first_section');
    $data['home_bottom_section'] = get_field('home_bottom_section');
    $data['pillars_section_1'] = get_field('pillars_section_1');
    $data['pillars_section_2'] = get_field('pillars_section_2');
    $data['pillars_section_3'] = get_field('pillars_section_3');
    $data['pillars_section_4'] = get_field('pillars_section_4');
    $data['pillars_section'] = get_field('pillars_section');
    $data['footer_our_mission_text'] = get_field('footer_our_mission_text');
    $data['contact_information'] = get_field('contact_information');
    $data['social_information'] = get_field('social_information');
    $data['my_own_'] = get_field('my_own_');
    $data['published_date'] = get_field('published_date');
    return $data;
});


/**
 * 
 * Customise the email 
 */
add_filter( 'wpcf7_validate_email*', 'custom_email_confirmation_validation_filter', 20, 2 );
 
function custom_email_confirmation_validation_filter( $result, $tag ) {
    if ( 'your-email-confirm' == $tag->name ) {
        $your_email = isset( $_POST['your-email'] ) ? trim( $_POST['your-email'] ) : '';
        $your_email_confirm = isset( $_POST['your-email-confirm'] ) ? trim( $_POST['your-email-confirm'] ) : '';
 
        if ( $your_email != $your_email_confirm ) {
            $result->invalidate( $tag, "Are you sure this is the correct address?" );
        }
    }
 
    return $result;
}

add_filter('get_search_form', function () {
    $form = '';
    echo template('search');
    return $form;
  });


/**
 * Custom Fields Show In Rest APIs
 * 
 */

$post_type = "post";
function my_rest_prepare_post($data, $post, $request) {
    $_data = $data->data;
    $fields = get_fields($post->ID);
    foreach ($fields as $key => $value) {
        $_data[$key] = get_field($key, $post->ID);
	}
	//The helper function acf_photo_gallery contains array. Append this array to your data array
	$_data['acf_photo_gallery'] = acf_photo_gallery('ACF_FIELD_NAME', $post->ID);
    $data->data = $_data;
    return $data;
}
add_filter("rest_prepare_{$post_type}", 'my_rest_prepare_post', 10, 3);


/**
 * Search Form
 * 
 */
add_filter('get_search_form', function(){  
    $form = '';  
      echo template(realpath(get_template_directory() . '/views/partials/content-search.blade.php'), []);  
    return $form;  
});

/**
 * 
 * Customized archieves
 * 
 */

add_action('pre_get_posts', function($query) {
    if ($query->is_post_type_archive('events')) {
    $query->set('order', 'DESC');
    $query->set('meta_key', 'events_date');
    }
}, 1);

add_filter( 'get_archives_link', function( $link_html, $url, $text, $format, $before, $after ) {
    if (isset($_GET['date']) && $_GET['date'] == strtotime($text)) $selected = 'selected'; else $selected = '';
    if ( 'custom' == $format) {
        $link_html = "\t<option value=\"". esc_attr( strtotime($text) ) ."\" ".$selected.">$text</option>\n";
    }

    return $link_html;

}, 10, 6 );



/**
 * 
 * Sort out events by events date
 * 
 */

/**
 * Get event date 
 *
 * @return string
 */
function get_event_date() {

    /** @global WP_Post $post */
    global $post;

    /** Get event date from post meta */
    return get_post_meta($post->ID, 'events_date', $single = true);
}

/**
 * Get event month/year formatted
 *
 * @param string $event_date
 * 
 * @return string
 */
function format_event_date($events_date) {
    return date('F Y', strtotime($events_date));
}

/**
 * Order events archive by event date post meta
 *
 * @param WP_Query $query
 *
 * @return WP_Query
 */

add_filter('pre_get_posts', function($query) {
    if (!$query->is_main_query() || !is_post_type_archive('events')) return $query;
        $query->set('meta_key', 'events_date');
        $query->set('meta_compare', '>=');
        $query->set('meta_value', date('Y-m-d'));
        $query->set('meta_type', 'DATE');
        $query->set('posts_per_page', 2);
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
        return $query;
});