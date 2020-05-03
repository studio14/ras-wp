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

class TaxonomiesImport {
    private static $taxonomies_instance = null;

    public static function getInstance() {
		
		if (TaxonomiesImport::$taxonomies_instance == null) {
			TaxonomiesImport::$taxonomies_instance = new TaxonomiesImport;
			return TaxonomiesImport::$taxonomies_instance;
		}
		return TaxonomiesImport::$taxonomies_instance;
    }

    public function taxonomies_import_function ($data_array, $mode, $importType , $check , $hash_key , $line_number ,$header_array ,$value_array) {
		
		$returnArr = array();
		$mode_of_affect = 'Inserted';
		global $wpdb;
		$helpers_instance = ImportHelpers::getInstance();
		$core_instance = CoreFieldsImport::getInstance();
		$media_instance = MediaHandling::getInstance();
		global $core_instance;

		$log_table_name = $wpdb->prefix ."cfimport_detail_log";

		$updated_row_counts = $helpers_instance->update_count($hash_key);
		$created_count = $updated_row_counts['created'];
		$updated_count = $updated_row_counts['updated'];
		$skipped_count = $updated_row_counts['skipped'];
		
		$terms_table = $wpdb->prefix ."term_taxonomy";
        //$taxonomy = $importAs;
        $taxonomy = $importType;
		
		$term_children_options = get_option("$taxonomy" . "_children");
		$_name = isset($data_array['name']) ? $data_array['name'] : '';
		$_slug = isset($data_array['slug']) ? $data_array['slug'] : '';
		$_desc = isset($data_array['description']) ? $data_array['description'] : '';
		$_image = isset($data_array['image']) ? $data_array['image'] : '';
		$_parent = isset($data_array['parent']) ? $data_array['parent'] : '';
		$_display_type = isset($data_array['display_type']) ? $data_array['display_type'] : '';
		
		$get_category_list = array();
		if (strpos($_name, ',') !== false) {
			$get_category_list = explode(',', $_name);
		} elseif (strpos($_name, '->') !== false) {
			$get_category_list = explode('->', $_name);
		} else {
			$get_category_list[] = trim($_name);
		}
	
		// if($_parent){
		// 	$get_parent = term_exists("$_parent", "$taxonomy");
		// 	$parent_term_id = $get_parent['term_id'];
		// }

		$parent_term_id = 0;
		if (count($get_category_list) == 1) {
			$_name = trim($get_category_list[0]);
			if($_parent){
				$get_parent = term_exists("$_parent", "$taxonomy");
				$parent_term_id = $get_parent['term_id'];
			}
		} else {
			$count = count($get_category_list);
			$_name = trim($get_category_list[$count - 1]);
			$checkParent = trim($get_category_list[$count - 2]);
			$parent_term = term_exists("$checkParent", "$taxonomy");
			$parent_term_id = $parent_term['term_id'];
		}

		if($check == 'termid'){
			$termID = $data_array['TERMID'];
		}
		if($check == 'slug'){
			$get_termid = get_term_by( "slug" ,"$_slug" , "$taxonomy");
			$termID = $get_termid->term_id;
		}	
		
		if($mode == 'Insert'){
			if(!empty($termID)){

				$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to duplicate Term found!.";
				$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key  = '$hash_key'");
				return array('MODE' => $mode, 'ERROR_MSG' => 'The term already exists!');
			}else{
				$taxoID = wp_insert_term("$_name", "$taxonomy", array('description' => $_desc, 'slug' => $_slug));
				if(is_wp_error($taxoID)){
					$core_instance->detailed_log[$line_number]['Message'] = "Can't insert this " . $taxonomy . ". " . $taxoID->get_error_message();
					$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key  = '$hash_key'");
				}else{

				$termID = $taxoID['term_id'];
				$update = $wpdb->get_results("UPDATE {$wpdb->prefix}term_taxonomy SET `parent` = $parent_term_id WHERE `term_id` =$termID ");
				$returnArr = array('ID' => $termID, 'MODE' => $mode_of_affect);
				
				if(isset($_display_type)){
					add_term_meta($termID , 'display_type' , $_display_type);
				}

				if(isset($parent_term_id)){
					$update = $wpdb->get_results("UPDATE $terms_table SET `parent` = $parent_term_id WHERE `term_id` = $termID ");
				}	
				$returnArr = array('ID' => $termID, 'MODE' => $mode_of_affect);

				if($importType = 'wpsc_product_category'){
					if($data_array['category_image']){
					$udir = wp_upload_dir();
					$imgurl = $data_array['category_image'];
					$img_name = basename($imgurl);
					$uploadpath = $udir['basedir'] . "/wpsc/category_images/";
					}
					if($data_array['target_market']){
						$custom_market = explode(',', $data_array['target_market']);
							foreach ($custom_market as $key =>$value) {
								$market[$value - 1] = $value;
							}					
					}
					$meta_data = array('uses_billing_address' => $data_array['address_calculate'],'image' => $img_name,'image_width' => $data_array['category_image_width'],'image_height' => $data_array['category_image_height'],'display_type'=>$data_array['catelog_view'],'target_market'=>serialize($market));
						foreach($meta_data as $mk => $mv){
						// $wpdb->insert( $wpdb->prefix.'wpsc_meta', array('object_type' => 'wpsc_category','object_id' => $termID,'meta_key' => $mk,'meta_value' => $mv),array('%s','%d','%s','%s')); 
						}
				}
				$core_instance->detailed_log[$line_number]['Message'] = 'Inserted ' . $taxonomy . ' ID: ' . $termID;
				$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");
			}
		}
		} else {
			if($mode == 'Update') {
				if(!empty($termID)){
	
					//wp_update_term($termID, "$taxonomy", array('name' => $_name, 'slug' => $_slug, 'description' => $_desc, 'parent' => $parent_term_id));
					wp_update_term($termID, "$taxonomy", array('name' => $_name, 'slug' => $_slug, 'description' => $_desc));
					$update = $wpdb->get_results("UPDATE {$wpdb->prefix}term_taxonomy SET `parent` = $parent_term_id WHERE `term_id` =$termID ");
					//start of added for adding thumbnail
					if(isset($_image)){
					    $_image = trim($_image);
					    	$img = $media_instance->media_handling($_image , $termID,$data_array ,'','','',$header_array ,$value_array);
					    update_term_meta($termID , 'thumbnail_id' , $img); 
					}
					if(isset($_display_type)){
            update_term_meta($termID , 'display_type' , $_display_type);
					}	
					
					if(isset($parent_term_id)){
						$update = $wpdb->get_results("UPDATE $terms_table SET `parent` = $parent_term_id WHERE `term_id` = $termID ");
					}
					
					//end of added for adding thumbnail
					//start wpsc_product_category meta fields
					if($importType = 'wpsc_product_category'){
						  if($data_array['category_image']){
							$udir = wp_upload_dir();
							$imgurl = $data_array['category_image'];
							$img_name = basename($imgurl);
							$uploadpath = $udir['basedir'] . "/wpsc/category_images/";
						  }
						  if($data_array['target_market']){
							$custom_market = explode(',', $data_array['target_market']);
							foreach ($custom_market as $key =>$value) {
								$market[$value - 1] = $value;
							}
						  }
						  $meta_data = array('uses_billing_address' => $data_array['address_calculate'],'image' => $img_name,'image_width' => $data_array['category_image_width'],'image_height' => $data_array['category_image_height'],'display_type'=>$data_array['catelog_view'],'target_market'=>serialize($market));
						  foreach($meta_data as $mk => $mv){
						// $wpdb->insert( $wpdb->prefix.'wpsc_meta', array('object_type' => 'wpsc_category','object_id' => $termID,'meta_key' => $mk,'meta_value' => $mv),array('%s','%d','%s','%s'));  
						  }
					}
					//end wpsc_product_category meta fields
					$mode_of_affect = 'Updated';		
					$returnArr = array('ID' => $termID, 'MODE' => $mode_of_affect);
					
					$core_instance->detailed_log[$line_number]['Message'] = 'Updated ' . $taxonomy . ' ID: ' . $termID;
					$fields = $wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE hash_key = '$hash_key'");
			
				}else{
					$taxoID = wp_insert_term("$_name", "$taxonomy", array('description' => $_desc, 'slug' => $_slug));

					$termID = $taxoID['term_id'];

					if(isset($parent_term_id)){
						$update = $wpdb->get_results("UPDATE {$wpdb->prefix}term_taxonomy SET `parent` = $parent_term_id WHERE `term_id` =$termID ");
					}
						$returnArr = array('ID' => $termID, 'MODE' => $mode_of_affect);

					$core_instance->detailed_log[$line_number]['Message'] = 'Inserted ' . $taxonomy . ' ID: ' . $termID;
					$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");
				}
			} 
		}

		if(!is_wp_error($termID)) {
			update_option("$taxonomy" . "_children", $term_children_options);
			delete_option($taxonomy . "_children");
		}
		return $returnArr;
    }
}