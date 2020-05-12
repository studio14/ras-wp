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

class NextGenExtension extends ExtensionHandler{
	private static $instance = null;
	
    public static function getInstance() {
		
		if (NextGenExtension::$instance == null) {
			NextGenExtension::$instance = new NextGenExtension;
		}
		return NextGenExtension::$instance;
    }

	/**
	* Provides Nextgen Gallery mapping fields for specific post type
	* @param string $data - selected import type
	* @return array - mapping fields
	*/
    public function processExtension($data) {
        $response = [];
        $nextgenFields = array(
			'FILENAME' => 'filename',
			'ALT & TITLE TEXT' => 'alttext',
			'DESCRIPTION' => 'description',
			'GALLERY NAME' => 'nextgen_gallery',
			'IMAGE' => 'image_url'

        );
		$next_gen_value = $this->convert_static_fields_to_array($nextgenFields);
		$response['nextgen_gallery_fields'] = $next_gen_value ;
		return $response;
    }

	/**
	* Nextgen Gallery extension supported import types
	* @param string $import_type - selected import type
	* @return boolean
	*/
    public function extensionSupportedImportType($import_type){
		if(in_array('nextgen-gallery/nggallery.php' , $this->get_active_plugins())){
			$import_type = $this->import_name_as($import_type);
			if($import_type == 'Posts' || $import_type == 'Pages' || $import_type =='CustomPosts' ) {
				return true;
			}
			else{
				return false;
			}
		}
	}
}