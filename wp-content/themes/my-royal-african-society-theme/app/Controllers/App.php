<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public function the_content() {
        
        global $post;   

        $my_content = get_post_meta($post->ID); 

        return apply_filters('the_content', $my_content);
    }

    public function customPageFields()
    {
        $top_text = '';
        return array (
         $top_text =>  get_field('top_text')
        );
    }

    public function annualDocuments()
    {
        $document_items = get_posts([
            'post_type' => 'annual_reports',
            'posts_per_page'=>'10',
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'document_file' => get_field('document_file', $post),
            ];
        }, $document_items);
    }

    public function governanceDocuments()
    {
        $document_items = get_posts([
            'post_type' => 'governance_documents',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'document_file' => get_field('document_file', $post),
            ];
        }, $document_items);
    }

    public function publicationsDocs()
    {
        $document_items = get_posts([
            'post_type' => 'publications_docs',
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'document_file' => get_field('document_file', $post),
            ];
        }, $document_items);
    }

    public function historyDetails()
    {
        $document_items = get_posts([
            'post_type' => 'history_details',
            'orderby' => 'menu_order',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'description' => get_field('description', $post),
            ];
        }, $document_items);
    }

    public function getMembershipPricings()
    {
        $document_items = get_posts([
            'post_type' => 'membership_pricing',
            'orderby' => 'menu_order',
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'price' => get_field('price', $post),
                'description' => get_field('description', $post),
                'page_link' => get_field('page_link', $post),
            ];
        }, $document_items);
    }

    public function getGiftingPricings()
    {
        $document_items = get_posts([
            'post_type' => 'gift_membership',
            'orderby' => 'menu_order',
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'price' => get_field('price', $post),
                'description' => get_field('description', $post),
                'page_link' => get_field('page_link', $post),
            ];
        }, $document_items);
    }

    public function currentInternships()
    {
        $document_items = get_posts([
            'post_type' => 'internships',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'subtitle' => get_field('subtitle', $post),
                'document_file' => get_field('document_file', $post),
            ];
        }, $document_items);
    }

    public function currentVolunteers()
    {
        $document_items = get_posts([
            'post_type' => 'volunteers',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'subtitle' => get_field('subtitle', $post),
                'document_file' => get_field('document_file', $post),
            ];
        }, $document_items);
    }

    public function getPeoples()
    {
        $document_items = get_posts([
            'post_type' => 'people',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'position' => get_field('position', $post),
                'twitter_handle' => get_field('twitter_handle', $post),
                'description' => get_field('description', $post),
                'featured_image' => get_the_post_thumbnail_url( $post, 'post-thumbnail' ),
            ];
        }, $document_items);
    }

    public function getClients()
    {
        $document_items = get_posts([
            'post_type' => 'clients',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'client_logo' => get_field('client_logo', $post),
                'client_link' => get_field('client_link', $post),
            ];
        }, $document_items);
    }

    public function getOfficers()
    {
        $document_items = get_posts([
            'post_type' => 'officer_members',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'position' => get_field('position', $post),
                'twitter_handle' => get_field('twitter_handle', $post),
                'description' => get_field('description', $post),
                'featured_image' => get_the_post_thumbnail_url( $post, 'post-thumbnail' ),
            ];
        }, $document_items);
    }

    public function eventsManagers()
    {
        $events_manager = get_posts([
            'post_type' => 'events',
            'posts_per_page'=>'10',
            'category' => 0,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'events_starting_time' => get_field('events_starting_time', $post),
                'events_ending_time' => get_field('events_ending_time', $post),
                'events_time_and_date' => get_field('events_time_and_date', $post),
                'events_date' => get_field('events_date', $post),
                'events_link' => get_field('events_link', $post),
                'events_location' => get_field('events_location', $post),
                'events_ticket_price' => get_field('events_ticket_price', $post),
                'members_only' => get_field('members_only', $post),
                'category' => get_object_taxonomies($post),
                'permelink' => $post->id,
            ];
        }, $events_manager);
    }

    public function customSliders()
    {
        $events_manager = get_posts([
            'post_type' => 'custom_slider',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'featured_image' => get_the_post_thumbnail_url( $post, 'post-thumbnail' ),
                'slider' => get_field('slider', $post),
            ];
        }, $events_manager);
    }

    public function contactInfo()
    {
        $document_items = get_posts([
            'post_type' => 'contact_info',
            'numberposts'       => -1,
            'orderby'          => 'date',
            'order'            => 'ASC',
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'content' => apply_filters('the_content', $post->post_content),
            ];
        }, $document_items);
    }


    public function getFaqs()
    {
        $events_manager = get_posts([
            'post_type' => 'faq',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'content' => apply_filters('the_content', $post->post_content),
                'category' => get_object_taxonomies($post),
            ];
        }, $events_manager);
    }

    public function getCouncils()
    {
        $document_items = get_posts([
            'post_type' => 'council',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'title' => apply_filters('the_title', $post->post_title),
                'position' => get_field('position', $post),
                'twitter_handle' => get_field('twitter_handle', $post),
                'description' => get_field('description', $post),
                'featured_image' => get_the_post_thumbnail_url( $post, 'post-thumbnail' ),
            ];
        }, $document_items);
    }

    public function getFooters() {
        $footer_content = [
            'footer_our_mission_text' => get_field('footer_our_mission_text', 1183),
            'contact_information' => get_field('contact_information', 1183),
            'social_information' => get_field('social_information', 1183),
            'big_banner_information' => get_field('big_banner_information', 1183),
        ];

        return $footer_content;
    }

    public function getClientsLogo() {
        $document_items = get_posts([
            'post_type' => 'clients',
            'numberposts'       => -1,
        ]);

        return array_map(function ($post) {
            return [
                'client_logo' => get_field('client_logo', $post),
                'title' => apply_filters('the_title', $post->post_title),
            ];
        }, $document_items);
    }


    public function customArchives() {
        $posts = get_posts(array(
            'post_status' => 'publish',
            'post_type' => 'events',
            'meta_key'  => 'events_date',
            'orderby'   => 'meta_value',
            'order'     => 'DESC'
        ));

        $group_posts = array();

            if( $posts ) {

                foreach( $posts as $post ) {

                    $date = get_field('events_date', $post->ID, false);

                    $date = explode('/', get_field('events_date'));

                    $year = $date[2];
                    $month = $date[1];

                    $group_posts[$year][$month][] = array($post, $date);

                }

            }
        return $group_posts;
    }
    
}
