<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

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

add_action('rest_api_init', function() {
    register_rest_field( 'discounts', 'discount_name', array(
        'get_callback' => function($post_arr) {
            $post_arr['discount_name'] = get_field('discount_name');
            return $post_arr;
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => 'string',
        ),
    ));
    register_rest_field( 'discounts', 'discounts_code', array(
        'get_callback' => function($post_arr) {
            $post_arr['discounts_code'] = get_field('discounts_code');
            $post_arr['discount_validity'] = get_field('discount_validity');
            return $post_arr;
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => 'string',
        ),
    ));
    register_rest_field( 'discounts', 'discount_validity', array(
        'get_callback' => function($post_arr) {
            $post_arr['discount_validity'] = get_field('discount_validity');
            return $post_arr['discount_validity'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => boolean,
        ),
    ));
});



add_action( 'rest_api_init', function () {
    //Path to meta query route
    register_rest_route( 'api/v2', '/events/', array(
            'methods' => 'GET', 
            'callback' => 'custom_meta_query' 
    ) );
});

// Do the actual query and return the data
function custom_meta_query() {
    $events_date = '';
    $per_page = '';
    $page = '';

    if(isset($_GET['events_date'])) {
        $events_date = $_GET['events_date'];
        $args = array('events_date' => $events_date);
        
        // Run a custom query

        $meta_query = new WP_Query($args);
        if($meta_query->have_posts()) {
            //Define and empty array
            $data = array();
            // Store each post's title in the array
            while($meta_query->have_posts()) {
                $meta_query->the_post();
                $data[] =  get_the_title();
            }
            // Return the data
            return $data;
        } else {
            // If there is no post
            return 'No post to show';
        }
    }
}


add_action('rest_api_init', function() {
    register_rest_field( 'events', 'events_starting_time', array(
        'get_callback' => function($post_arr, $request) {
            $post_arr['events_starting_time'] = get_field('events_starting_time');
            return $post_arr['events_starting_time'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => 'string',
        ),
    ));
    register_rest_field( 'events', 'events_ending_time', array(
        'get_callback' => function($post_arr, $request) {
            $post_arr['events_ending_time'] = get_field('events_ending_time');
            return $post_arr['events_ending_time'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => 'string',
        ),
    ));
    register_rest_field( 'events', 'events_date', array(
        'get_callback' => function($post_arr) {
            $post_arr['events_date'] = get_field('events_date');
            return $post_arr['events_date'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => array()
        ),
    ));
    register_rest_field( 'events', 'events_link', array(
        'get_callback' => function($post_arr) {
            $post_arr['events_link'] = get_field('events_link');
            return $post_arr['events_link'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => 'string'
        ),
    ));
    register_rest_field( 'events', 'events_location', array(
        'get_callback' => function($post_arr) {
            $post_arr['events_location'] = get_field('events_location');
            return $post_arr['events_location'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => 'string'
        ),
    ));
    register_rest_field( 'events', 'events_ticket_price', array(
        'get_callback' => function($post_arr) {
            $post_arr['events_ticket_price'] = get_field('events_ticket_price');
            return $post_arr['events_ticket_price'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => 'string'
        ),
    ));
    register_rest_field( 'events', 'members_only', array(
        'get_callback' => function($post_arr) {
            $post_arr['members_only'] = get_field('members_only');
            return $post_arr['members_only'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => boolean
        ),
    ));
    register_rest_field('events', 'members_only', array(
        'get_callback' => function($post_arr) {
            $post_arr['add_to_calender_link'] = get_field('add_to_calender_link');
            return $post_arr['add_to_calender_link'];
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __('Some'),
            'type'        => boolean
        ),
    ));
});


add_action( 'rest_api_init', function() {
    register_rest_route( 'ras/v1', '/posts', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_posts'
    ));

    register_rest_route( 'ras/v1', '/categories', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_categories'
    ));

    register_rest_route( 'ras/v1', '/events', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_events'
    ));
    register_rest_route( 'ras/v1', '/discounts', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_discounts'
    ));
    register_rest_route( 'ras/v1', '/faq', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_faq'
    ));
    register_rest_route( 'ras/v1', '/posts/(?P<post_id>\d+)', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_post'
    ));

    register_rest_route( 'ras/v1', '/events/(?P<event_id>\d+)', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_event_manager'
    ));
    register_rest_route( 'ras/v1', '/discounts/(?P<discount_id>\d+)', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_discount'
    ));
    register_rest_route( 'ras/v1', '/footer', array(
        'methods' => 'GET',
        'callback' =>  __NAMESPACE__ . '\\api_get_footer_content'
    ));
});

function api_get_posts( $request ) {
    $posts_data = array();
    $paged = $request->get_param( 'page' );
    $selectedCategory = $request->get_param( 'category_id' );
    $per_page = $request->get_param('per_page');
    $paged = ( isset( $paged ) || ! ( empty( $paged ) ) ) ? $paged : 1; 
    $posts = get_posts( array(
            'paged' => $paged,
            'posts_per_page' => $per_page !== '' ? $per_page : '10',           
            'post_type' => array( 'post'),
            'category' => $selectedCategory !== '' ? $selectedCategory : '',  
        )
    ); 
    foreach( $posts as $post ) {
        $id = $post->ID; 
        $post_thumbnail = ( has_post_thumbnail( $id ) ) ? get_the_post_thumbnail_url( $id ) : null;

        $post_categories = get_the_category($post);
        $category_name = array();
        foreach ($post_categories as $category) {
            $category_name[] = (object) array (
                'id' => $category->term_id,
                'name' => $category->name,
                'slug' => $category->slug,
            );
        }

        $posts_data[] = (object) array( 
            'id' => $id, 
            'slug' => $post->post_name, 
            'type' => $post->post_type,
            'title' => $post->post_title,
            'featured_img_src' => $post_thumbnail,
            'content' => $post->post_content,
            'excerpt' => get_the_excerpt($post),
            'post_date' => $post->post_date,
            'category' => $category_name[0],

        );
    }                  
    return $posts_data;                   
} 

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

function api_get_events( $request ) {
    $posts_data = array();
    $paged = $request->get_param( 'page' );
    $per_page = $request->get_param('per_page');
    $selectedCategory = $request->get_param( 'category_id' );
    $events_date = $request->get_param('events_date');
    $paged = ( isset( $paged ) || ! ( empty( $paged ) ) ) ? $paged : 1; 
    if(isset($selectedCategory) && $selectedCategory !== '')
    {
        $posts = get_posts( array(
                'paged' => $paged,
                'posts_per_page' => $per_page !== '' ? $per_page : '10',            
                'post_type' => array( 'events'),
                'meta_key' => 'events_date',
                'orderby'   => 'meta_value',
                'order'	    => 'DESC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'events_category',
                        'field' => 'term_id',
                        'terms' => isset($selectedCategory) && $selectedCategory !== '' ? $selectedCategory : ''
                    )
                )
            )
        ); 
    }
    else {
        $posts = get_posts( array(
                'paged' => $paged,
                'posts_per_page' => $per_page !== '' ? $per_page : '10',            
                'post_type' => array( 'events'),
                'meta_key' => 'events_date',
                'orderby'   => 'meta_value',
                'order'	    => 'DESC',
            )
        ); 
    }
    
    foreach( $posts as $post ) {
        $id = $post->ID; 
        $post_thumbnail = ( has_post_thumbnail( $id ) ) ? get_the_post_thumbnail_url( $id ) : null;

        $post_categories = get_the_terms($post->ID, 'events_category');
        $category_name = array();
        foreach ($post_categories as $category) {
            $category_name[] = (object) array (
                'id' => $category->term_id,
                'name' => $category->name,
                'slug' => $category->slug,
            );
        }

        $posts_data[] = (object) array( 
            'id' => $id, 
            'post_content' => $post->post_content,
            'post_title' => $post->post_title,
            'post_excerpt' => $post->post_excerpt,
            'featured_image' => $post_thumbnail,
            'events_starting_time' => get_field('events_starting_time', $post), 
            'events_ending_time' => get_field('events_ending_time', $post), 
            'events_date' => get_field('events_date', $post), 
            'events_location' => get_field('events_location', $post), 
            'events_ticket_price' => get_field('events_ticket_price', $post), 
            'members_only' => get_field('members_only', $post), 
            'add_to_calender_link' => get_field('add_to_calender_link', $post),
            'post_date' => $post->post_date,
            'category' => $category_name[0]
        );
    }                  
    return $posts_data;                   
} 

function api_get_discounts( $request ) {
    $posts_data = array();
    $paged = $request->get_param( 'page' );
    $per_page = $request->get_param('per_page');
    $selectedCategory = $request->get_param( 'category_id' );
    $paged = ( isset( $paged ) || ! ( empty( $paged ) ) ) ? $paged : 1; 
    $posts = get_posts( array(
            'paged' => $paged,
            'posts_per_page' => $per_page !== '' ? $per_page : '10',            
            'post_type' => array( 'discounts'),
            'category' => $selectedCategory !== '' ? $selectedCategory : ''
        )
    ); 
    foreach( $posts as $post ) {
        $id = $post->ID; 
        $post_thumbnail = ( has_post_thumbnail( $id ) ) ? get_the_post_thumbnail_url( $id ) : null;

        $posts_data[] = (object) array( 
            'id' => $id,
            'post_title' => $post->post_title,
            'featured_image' => $post_thumbnail,
            'discount_name' => get_field('discount_name', $post), 
            'discounts_code' => get_field('discounts_code', $post), 
            'discount_validity' => get_field('discount_validity', $post),
            'discount_document_upload' => get_field('discount_document_upload', $post),
            'store_name' => get_field('store_name', $post)
        );
    }                  
    return $posts_data;                   
} 

function api_get_post( $request ) {
    $posts_data = array();
    $post_id = $request->get_param( 'post_id' );
    $posts = get_post($post_id); 
    if ($posts->ID != null) {
        status_header( 200 );
        $post_thumbnail = ( has_post_thumbnail( $post_id ) ) ? get_the_post_thumbnail_url( $post_id ) : null;

        $post_categories = get_the_category($posts);
        $category_name = array();
        foreach ($post_categories as $category) {
            $category_name[] = (object) array (
                'id' => $category->term_id,
                'name' => $category->name,
                'slug' => $category->slug,
            );
        }

        $posts_data['id'] = $posts->ID;
        $posts_data['slug'] = $posts->post_name;
        $posts_data['type'] = $posts->post_type;
        $posts_data['title'] = $posts->post_title;
        $posts_data['featured_img_src'] = $post_thumbnail;
        $posts_data['content'] = $posts->post_content;
        $posts_data['post_date'] = $posts->post_date;
        $posts_data['category'] = $category_name[0];
    }
    else {
        status_header( 404 );
        $posts_data['error'] = 'does not exists';
    }
                 
    return $posts_data;                   
} 

function api_get_event_manager( $request ) {
    $posts_data = array();
    $event_id = $request->get_param( 'event_id' );
    $posts = get_post($event_id); 
    if ($posts->ID != null) {
        $post_thumbnail = ( has_post_thumbnail( $event_id ) ) ? get_the_post_thumbnail_url( $event_id ) : null;
        $posts_data['id'] = $posts->ID;
        $posts_data['post_content'] = $posts->post_content;
        $posts_data['post_title'] = $posts->post_title;
        $posts_data['post_excerpt'] = $posts->post_excerpt;
        $posts_data['featured_image'] = $post_thumbnail;
        $posts_data['events_starting_time'] = get_field('events_starting_time', $posts);
        $posts_data['events_ending_time'] = get_field('events_ending_time', $posts);
        $posts_data['events_date'] = get_field('events_date', $posts);
        $posts_data['events_location'] = get_field('events_location', $posts);
        $posts_data['events_ticket_price'] = get_field('events_ticket_price', $posts);
        $posts_data['post_date'] = get_field('post_date', $posts);
    }
    else {
        status_header( 404 );
        $posts_data['error'] = 'does not exists';
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


function events_pre_get_posts( $query ) {
	
	// do not modify queries in the admin
	if( is_admin() ) {
		return $query;
	}
	
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'events' ) {
		$query = new WP_Query( array(
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
        
        $query->set('meta_query', $meta_query);
        $query->set('orderby', array('events_date_sort' => 'DESC'));
	}
	// return
	var_dump($query);
}

add_action('pre_get_posts', 'events_pre_get_posts');