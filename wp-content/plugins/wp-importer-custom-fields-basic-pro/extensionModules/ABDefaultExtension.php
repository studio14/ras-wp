<?php
/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

namespace Smackcoders\CFCSV;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class DefaultExtension extends ExtensionHandler{
	private static $instance = null;

	public static function getInstance() {

		if (DefaultExtension::$instance == null) {
			DefaultExtension::$instance = new DefaultExtension;
		}
		return DefaultExtension::$instance;
	}

	/**
	* Provides default mapping fields for specific post type or taxonomies
	* @param string $data - selected import type
	* @return array - mapping fields
	*/
	public function processExtension($data){
		// $import_type = $data['Types'];
		$mode = $_POST['Mode'];

		$import_types = $data;
		$import_type = $this->import_name_as($import_types);

		$response = [];
		$check_custpost = array('Posts' => 'post', 'Pages' => 'page', 'Users' => 'users', 'Comments' => 'comments', 'CustomerReviews' =>'wpcr3_review', 'Categories' => 'categories', 'Tags' => 'tags', 'CustomPosts' => 'CustomPosts');	
		if ( $import_type != 'Users' && $import_type != 'Taxonomies' && $import_type != 'Categories' && $import_type != 'Comments' && $import_type != 'Images' && $import_type != 'ngg_pictures') {
			$wordpressfields = array(
                                    'Title' => 'post_title',
                                       'ID' => 'ID',
                                       'Content' => 'post_content',
                                       'Short Description' => 'post_excerpt',
                                       'Publish Date' => 'post_date',
                                       'Slug' => 'post_name',
                                       'Author' => 'post_author',
                                       'Status' => 'post_status',
                                       'Featured Image' => 'featured_image'    
                                       );
			if ($import_type === 'Posts' || $import_type === 'CustomPosts') { 
				$wordpressfields['Format'] = 'post_format';
				$wordpressfields['Comment Status'] = 'comment_status';
				$wordpressfields['Ping Status'] = 'ping_status';
				$wordpressfields['Track Options'] = 'pinged';
			}
			if ($import_type === 'Pages') {
				$wordpressfields['Parent'] = 'post_parent';
				$wordpressfields['Order'] = 'menu_order';
				$wordpressfields['Page Template'] = 'wp_page_template';
				$wordpressfields['Comment Status'] = 'comment_status';
				$wordpressfields['Ping Status'] = 'ping_status';
			}

			if($mode == 'Insert'){
				unset($wordpressfields['ID']);
			}
		} 

		if($import_type == 'Users'){
			$wordpressfields = array(
					'User Login' => 'user_login',
					'User Pass' => 'user_pass',
					'First Name' => 'first_name',
					'Last Name' => 'last_name',
					'Nick Name' => 'nickname',
					'User Email' => 'user_email',
					'User URL' => 'user_url',
					'User Nicename' => 'user_nicename',
					'User Registered' => 'user_registered',
					//'User Activation Key' => 'user_activation_key',
					//'User Status' => 'user_status',
					'Display Name' => 'display_name',
					'User Role' => 'role',
					'Biographical Info' => 'biographical_info',
					'Disable Visual Editor' => 'disable_visual_editor',
					'Syntax Highlighting' => 'syntax_highlighting',
					'Admin Color Scheme' => 'admin_color',
					'Enable Keyboard Shortcuts' => 'enable_keyboard_shortcuts',
					'Show Toolbar' => 'show_toolbar',
					'Language' => 'language',
					'ID' => 'ID'
					);
			if($mode == 'Insert'){
				unset($wordpressfields['ID']);
			}
		}
		
		if($import_type === 'Comments') {
			$wordpressfields = array(
					'Comment Post Id' => 'comment_post_ID',
					'Comment Author' => 'comment_author',
					'Comment Author Email' => 'comment_author_email',
					'Comment Author URL' => 'comment_author_url',
					'Comment Content' => 'comment_content',
					'Comment Author IP' => 'comment_author_IP',
					'Comment Date' => 'comment_date',
					'Comment Approved' => 'comment_approved',
					);
		}
		if($import_type === 'Images') {
			$wordpressfields = array(
					'Caption' => 'caption',
					'Alt text' => 'alt_text',
					'Desctiption' => 'description',
					'File Name' => 'file_name',
					'Title' => 'title',
					'Featured Image' => 'featured_image');
		}
		if($import_type === 'ngg_pictures') {
			$wordpressfields = array(
					'Caption' => 'caption',
					'Alt text' => 'alt_text',
					'Desctiption' => 'description',
					'File Name' => 'file_name',
					'Featured Image' => 'featured_image',
					'Nextgen Gallery' => 'nextgen_gallery');
		}
		if($import_type === 'Taxonomies') {
			$wordpressfields = array(
					'Taxonomy Name' => 'name',
					'Taxonomy Slug' => 'slug',
					'Taxonomy Description' => 'description',
					'Term ID' => 'TERMID',
					);
			if($mode == 'Insert'){
				unset($wordpressfields['Term ID']);
			}
		}
		if($import_type === 'Categories') {
			$wordpressfields = array(
					'Category Name' => 'name',
					'Category Slug' => 'slug',
					'Category Description' => 'description',
					'Term ID' => 'TERMID',
					'Parent' => 'parent',
					);
			if($mode == 'Insert'){
				unset($wordpressfields['Term ID']);
			}	
		}
		if($import_type === 'Tags') {
			$wordpressfields = array(
					'Tag Name' => 'name',
					'Tag Slug' => 'slug',
					'Tag Description' => 'description',
					'Term ID' => 'TERMID',
					);
			if($mode == 'Insert'){
				unset($wordpressfields['Term ID']);
			}	
		}

		$wordpress_value = $this->convert_static_fields_to_array($wordpressfields);
		$response['core_fields'] = $wordpress_value ;
		return $response;
	} 

	/**
	* Core Fields extension supported import types
	* @param string $import_type - selected import type
	* @return boolean
	*/
	public function extensionSupportedImportType($import_type){
		return true;
	}

}
