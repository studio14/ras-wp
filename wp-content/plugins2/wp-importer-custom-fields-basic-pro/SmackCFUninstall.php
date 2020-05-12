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

/**
 * Class SmackUCIUnInstall
 * @package Smackcoders\CFCSV
 */

class SmackUCIUnInstall {
	/**
	 * UnInstall UCI Pro.
	 */
	protected static $instance = null;
	public function __construct() {
		$this->plugin = Plugin::getInstance();
	}

	public static function getInstance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function unInstall() {
		global $wpdb;

		$wpdb->hide_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$ucisettings = get_option('sm_uci_pro_settings');
		$prefix = $wpdb->prefix;
		$droptable = isset($ucisettings['drop_table']) ? $ucisettings['drop_table'] : '';
		if(!empty($droptable) && $droptable == 'true'){
			$tables[] = "drop table ultimate_cfimporter_pro_external_file_schedules";
			$tables[] = "drop table ultimate_cfimporter_pro_ftp_schedules";
			$tables[] = "drop table ultimate_cfimporter_pro_ftp_schedules";
			$tables[] = "drop table ultimate_cfimporter_pro_mappingtemplate";
			$tables[] = "drop table ultimate_cfimporter_pro_scheduled_import";
			$tables[] = "drop table {$prefix}cfimport_detail_log";
			$tables[] = "drop table {$prefix}smackcf_file_events";

			foreach($tables as $table) {
				$wpdb->query($table, array());
			}
		}
	}
}
