<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;


include("apis/api.php");

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'top_navigation' => __('Top Navigation', 'sage'),
        'bottom_navigation' => __('Bottom Navigation', 'sage'),
        'footer_widget_navigation' => __('Footer Widget Navigation', 'sage'),
        'mobile_navigation' => __('Mobile Navigation', 'sage'),
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * Initialize ACF Builder
 */
add_action('init', function () {
    collect(glob(config('theme.dir').'/app/fields/*.php'))->map(function ($field) {
        return require_once($field);
    })->map(function ($field) {
        if ($field instanceof FieldsBuilder) {
            acf_add_local_field_group($field->build());
        }
    });
});


add_action( 'rest_api_init', function() {
    register_rest_route( 'ras/v1', '/categories', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_categories'
    ));

    register_rest_route( 'ras/v1', '/faq', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_faq'
    ));

    register_rest_route( 'ras/v1', '/footer', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_footer_content'
    ));
});

function api_get_categories($request) {
    $posts_data = [];
    $category = $request->get_param( 'category' );
    $categories = get_terms( $category, 'orderby=date&hide_empty=1' );
    foreach ($categories as $category) {
        $posts_data[] = (object) array( 
            'id' => $category->term_id, 
            'slug' => $category->slug, 
            'name' => $category->name,
        );
    }
    return $posts_data;
}

function api_get_faq( $request ) {
    $posts_data = array();
    $selectedCategory = $request->get_param( 'category_id' );
    $taxonomy = 'faq_categories';
        $args = array(
        'orderby' => 'id',
        'order' => 'DESC',
    );
    $taxonomy_terms = get_terms($taxonomy, $args);
    foreach($taxonomy_terms as $taxonomy_term) {
        $faqs = get_posts(array(
                'post_type' => 'faq',
                'numberposts' => -1,
                'category' => $selectedCategory !== '' ? $selectedCategory : '', 
                'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy_term->taxonomy,
                    'terms' => $taxonomy_term->slug,
                    'field' => 'slug',
                )
            )
        ));
        
        $posts_data[] = (object) array( 
            'category_name' => $taxonomy_term->name, 
            'category_slug' => $taxonomy_term->slug, 
            'taxonomy' => $taxonomy_term->name,
            'content' => $faqs
        );
    }                
    return $posts_data;                   
} 

function api_get_footer_content( $request ) {
    $posts_data = array();
    $paged = $request->get_param( 'page' );
    $per_page = $request->get_param('per_page');
    $paged = ( isset( $paged ) || ! ( empty( $paged ) ) ) ? $paged : 1; 
    $post = get_post(1183);
    $menuLocations = get_nav_menu_locations();
    $menuID = $menuLocations['footer_widget_navigation'];
    $bottomNavs = wp_get_nav_menu_items($menuID); 
    $posts_data[] = (object) array(
        'id' => $post->ID,
        'footer_our_mission_text' => get_field('footer_our_mission_text', $post),
        'contact_information' => get_field('contact_information', $post),
        'social_information' => get_field('social_information', $post),
        'my_own_footer' => get_field('my_own_footer', $post),
        'big_banner_information' => get_field('big_banner_information', $post),        
    );   
    $count = 0;
    foreach ($bottomNavs as $nav) {
        $posts_data['menu'][$count]['link'] = $nav->url;
        $posts_data['menu'][$count]['title'] = $nav->title;
        $count++;
    } 
    $resetCount = 0;
    $menuID = $menuLocations['bottom_navigation'];
    $footerBottomNavs = wp_get_nav_menu_items($menuID); 
    foreach ($footerBottomNavs as $nav) {
        $posts_data['footermenu'][$resetCount]['link'] = $nav->url;
        $posts_data['footermenu'][$resetCount]['title'] = $nav->title;
        $resetCount++;
    } 
    return $posts_data;                   
}

add_action( 'pre_get_posts', function ( $query ) {
    if ( is_post_type_archive( 'events' ) && $query->is_main_query() ) {
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'ASC' );
        $query->set( 'meta_key', 'events_date' );
    }
} );

/**
 * 
 * remove functionality to delete certain pages
 * 
 */
function restrict_page_deletion($post_ID){
    $user = get_current_user_id();

    $restrictedPageArray = [1183, 32, 1171];

    if(in_array($post_ID, $restrictedPageArray))
    {
        echo "You are not authorized to delete this page.";
        exit;
    }
}
add_action('before_delete_post', 'restrict_page_deletion', 10, 1);

add_action('pre_get_posts', function($query) {
    if( is_admin() ) {
		return $query;
	}
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'events' ) {
		$query = new \WP_Query( array(
            'meta_query' => array(
                'events_date_sort' => array(
                    'key' => 'events_date',
                    'compare' => 'EXISTS',
                    'type' => 'NUMERIC'
                ), 
            ),
            'orderby' => array(
                    'events_date' => 'DESC',
                ) 
            ) 
        );
    
    $query->set('orderby', array('events_date_sort' => 'DESC'));
	}
}, 1);