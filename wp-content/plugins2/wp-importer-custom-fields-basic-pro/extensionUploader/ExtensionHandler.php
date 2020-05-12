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

class ExtensionHandler{
	private static $instance=null;
	private static $validate_file = null;
	public static function getInstance() {

		if (ExtensionHandler::$instance == null) {
			ExtensionHandler::$validate_file = ValidateFile::getInstance();
			return ExtensionHandler::$instance;
		}
		return ExtensionHandler::$instance;
	}

	public function import_post_types($import_type) {	
		$import_type = trim($import_type);

		$module = array('Posts' => 'post', 'Pages' => 'page','Users' => 'user', 'Comments' => 'comments', 'Taxonomies' => $import_type,  'Categories' => 'categories', 'Tags' => 'tags', 'CustomPosts' => $import_type);
		foreach (get_taxonomies() as $key => $taxonomy) {
			$module[$taxonomy] = $taxonomy;
		}
		if(array_key_exists($import_type, $module)) {
			return $module[$import_type];
		}
		else {
			return $import_type;
		}
	}
	public function convert_fields_to_array($get_value){
		foreach($get_value as $values){
			foreach($values as $in_values){
				$fields_getting[]=$in_values;
			}	
		}
		return $fields_getting;
	}

	public function convert_static_fields_to_array($static_value){
		if (is_array($static_value) || is_object($static_value)){
			foreach($static_value as $key=>$values){
				$static_fields_getting[] = array('label' => $key,
					'name' => $values			
				);
			}
		}
		return $static_fields_getting;
	}

	public function get_active_plugins() {
		$active_plugins = get_option('active_plugins');
		return $active_plugins;
	}

	public function get_import_custom_post_types(){
		$custompost = array();
		$custom_array = array('post', 'page','wpsc-product', 'product_variation', 'shop_order', 'shop_coupon', 'shop_order_refund','mp_product_variation');
		$other_posttypes = array('attachment','revision','nav_menu_item','wpsc-product-file','mp_order','shop_webhook');
		$all_post_types = get_post_types();
		foreach($other_posttypes as $ptkey => $ptvalue) {
			if (in_array($ptvalue, $all_post_types)) {
				unset($all_post_types[$ptvalue]);
			}
		}
		foreach($all_post_types as $key => $value){
			if(!in_array($value,$custom_array)){
				$custompost[$value] = $value;
			}
		}
		return $custompost;
	}

	public function get_import_post_types(){
		$custom_array = array('post', 'page','wpsc-product', 'product_variation', 'shop_order', 'shop_coupon', 'shop_order_refund','mp_product_variation');
		$other_posttypes = array('attachment','revision','nav_menu_item','wpsc-product-file','mp_order','shop_webhook','custom_css','customize_changeset','oembed_cache','user_request','_pods_template','wpmem_product','wp-types-group','wp-types-user-group','wp-types-term-group','gal_display_source','display_type','displayed_gallery','wpsc_log','lightbox_library','scheduled-action','cfs','_pods_pod','_pods_field','acf-field','acf-field-group','wp_block','event','event-recurring','location','ngg_album','ngg_gallery', 'wpcr3_review');
		$importas = array(
			'Posts' => 'Posts',
			'Pages' => 'Pages',
			'Users' =>'Users',
			'Comments' => 'Comments',
			'Images' => 'Images'
		);
		$all_post_types = get_post_types();


		// To avoid toolset repeater group fields from post types in dropdown
		global $wpdb;
		$fields = $wpdb->get_results("select meta_value from {$wpdb->prefix}postmeta where meta_key = '_wp_types_group_fields' ");
		foreach($fields as $value){
			$repeat_values = $value->meta_value;
			$types_fields = explode( ',', $repeat_values);

			foreach($types_fields as $types_value){
				$explode = explode('_',$types_value);
				if (count($explode)>1) {
					if (in_array('repeatable',$explode)) {
						$name = $wpdb->get_results("SELECT post_name FROM ".$wpdb->prefix."posts WHERE id ='{$explode[3]}'");	
						$type_repeat_value =  $name[0]->post_name;

						if(in_array($type_repeat_value , $all_post_types)){
							unset($all_post_types[$type_repeat_value]);
						}
					}else{

					}
				}else{

				}
			}	
		}

		foreach($other_posttypes as $ptkey => $ptvalue) {
			if (in_array($ptvalue, $all_post_types)) {
				unset($all_post_types[$ptvalue]);
			}
		}
		foreach($all_post_types as $key => $value) {
			if(!in_array($value, $custom_array)) {
				if($value == 'event') {

				} else {
					$importas[$value] = $value;
				}
				$custompost[$value] = $value;
			}
		}

		return $importas;	
	}

	public function import_name_as($import_type){
		$taxonomies = get_taxonomies();
		$customposts = $this->get_import_custom_post_types();

		$import_type_as = $this->get_import_post_types();
		if (in_array($import_type, $taxonomies)) {
			if($import_type == 'category' || $import_type == 'product_category' || $import_type == 'product_cat' || $import_type == 'wpsc_product_category'):
				$import_type = 'Categories';
			elseif($import_type == 'product_tag' || $import_type == 'event-tags' || $import_type == 'post_tag'):
				$import_type = 'Tags';
			elseif($import_type == 'comments'):
				$import_type = 'Comments';
			else:
			$import_type = 'Taxonomies';
endif;
		}
		if (in_array($import_type, $customposts)) {
			$import_type = 'CustomPosts';
		}
		if(array_key_exists($import_type , $import_type_as )){
			$import_type = $import_type_as[$import_type];
		}
		return $import_type;
	}

	public function import_type_as($import_type){
		$import_type_as = $this->get_import_post_types();

		if(array_key_exists(trim($import_type) , $import_type_as )){	
			$import_type = $import_type_as[trim($import_type)];
		}

		return $import_type;
	}

	public function set_post_types($hashkey , $filename) {

		$smackcsv_instance = SmackCSV::getInstance();
		$upload_dir = $smackcsv_instance->create_upload_dir();
		$file_extension = pathinfo($filename, PATHINFO_EXTENSION);

		if($file_extension == 'csv' || $file_extension == 'txt'){
			ini_set("auto_detect_line_endings", true);
			$info = [];
			if (($h = fopen($upload_dir.$hashkey.'/'.$hashkey, "r")) !== FALSE) 
			{
				$line_number = 0;
				$Headers = [];
				// Convert each line into the local $data variable	
				$delimiters = array( ',','\t',';','|',':','&nbsp');
				$file_path = $upload_dir . $hashkey . '/' . $hashkey;
				ExtensionHandler::$validate_file = ValidateFile::getInstance();
				$delimiter = ExtensionHandler::$validate_file->getFileDelimiter($file_path, 5);
				$array_index = array_search($delimiter,$delimiters);
				if($array_index == 5){
					$delimiters[$array_index] = ' ';
				}
				while (($data = fgetcsv($h, 0, $delimiters[$array_index])) !== FALSE)  
				{		
					// Read the data from a single line
					array_push($info , $data);

					if($line_number == 0){
						$Headers = $info[$line_number];
						$type = $this->select_import_type($Headers);	
					}else{
						$values = $info[$line_number];	
					}
					$line_number ++;		
				}	
				// Close the file
				fclose($h);
			}
			$total_rows = $line_number - 1;
		}
		if($file_extension == 'xml'){
			$upload_dir_path = $upload_dir. $hashkey;
			if (!is_dir($upload_dir_path)) {
				wp_mkdir_p( $upload_dir_path);
			}
			chmod($upload_dir_path, 0777);   
			$path = $upload_dir . $hashkey . '/' . $hashkey;   

			$xml = simplexml_load_file($path);
			$xml_arr = json_decode( json_encode($xml) , 1);

			foreach($xml->children() as $child){   
				$child_name = $child->getName();    
			}
			$xml_class = new XmlHandler();
			$parse_xml = $xml_class->parse_xmls($hashkey);
			$i = 0;
			foreach($parse_xml as $xml_key => $xml_value){
				if(is_array($xml_value)){
					foreach ($xml_value as $e_key => $e_value){
						$Headers[$i] = $e_value['name'];
						$i++;
					}
				}
			}
			$type = $this->select_import_type($Headers);
			$total_rows = $this->get_xml_count($path , $child_name);
			if($total_rows == 0 || $total_rows == 1){
				$sub_child = $this->get_child($child,$path);
				$child_name = $sub_child['child_name'];
				$total_rows = $sub_child['total_count'];
			}
		}

		global $wpdb;
		$table_name = $wpdb->prefix ."smackcf_file_events";
		$fields = $wpdb->get_results("UPDATE $table_name SET total_rows=$total_rows WHERE hash_key = '$hashkey'");
		return $type;	
	}

	public function get_child($child,$path){
		foreach($child->children() as $sub_child){
			$sub_child_name = $sub_child->getName();
		}
		$total_xml_count = $this->get_xml_count($path , $sub_child_name);
		if($total_xml_count == 0 || $total_xml_count == 1){
			$this->get_child($sub_child,$path);
		}
		else{
			$result['child_name'] = $sub_child_name;
			$result['total_count'] = $total_xml_count;
			return $result;
		}
	}

	public function select_import_type($Headers){
		$type = 'Posts';
		if(in_array('wp_page_template', $Headers) && in_array('menu_order', $Headers)){
			$type = 'Pages';
		} elseif(in_array('user_login', $Headers) || in_array('role', $Headers) || in_array('user_email', $Headers) ){
			$type = 'Users';
		} elseif(in_array('comment_author', $Headers) || in_array('comment_content', $Headers) ||  in_array('comment_approved', $Headers) ){
			$type = 'Comments';
		} elseif( in_array('hide_on_screen', $Headers) || in_array('position', $Headers) || in_array('layout', $Headers)){
			if(in_array('advanced-custom-fields/acf.php', $this->get_active_plugins())) {
				$type = 'acf-field';
			} elseif(is_plugin_active('advanced-custom-fields-pro/acf.php')){
				$type = 'acf-field-group';
			}
		}
		return $type;
	}

	public function get_xml_count($eventFile , $tagname){
		$doc = new \DOMDocument();
		$doc->load($eventFile);
		$nodes=$doc->getElementsByTagName($tagname);
		$total_row_count = $nodes->length;
		return $total_row_count;	
	}

	public function processExtension($data){
		return '';
	}
	public function extensionSupportedImportType($import_type){
		return boolean ;
	}

}
