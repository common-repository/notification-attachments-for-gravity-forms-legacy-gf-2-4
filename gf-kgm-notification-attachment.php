<?php
/* 
Plugin Name: Notification Attachments for Gravity Forms (Legacy GF 2.4-)
Version: 0.1
Description: Send attachment in Gravity Forms Notification
Author: KGM Servizi
Author URI: https://kgmservizi.com
License: GPLv2 or later
Text Domain: gf-kgm-notification-attachment
*/

global $gf_kgm_notification_attachment;
add_action( 'init', 'gf_kgm_notification_attachment_init' );

//Init
function gf_kgm_notification_attachment_init() {
	global $gf_kgm_notification_attachment;

	if (class_exists('GFForms')) {
		add_filter( 'gform_notification', 'gf_kgm_notification_attachment_send', 20, 3 );		
		add_action( 'admin_enqueue_scripts', 'gf_kgm_notification_attachment_attach_script');
		add_filter( 'gform_pre_notification_save', 'gf_kgm_notification_attachment_save', 20, 2 );
		add_action( 'wp_ajax_gf_kgm_notification_attachment', 'gf_kgm_notification_attachment_ajax' );
		add_filter( 'gform_noconflict_scripts', 'gf_kgm_notification_attachment_gform_noconflict' );
		add_filter( 'gform_notification_ui_settings', 'gf_kgm_notification_attachment_editor', 20, 3 );

		$gf_kgm_notification_attachment = (object) array(
			'text_domain' => 'gf-kgm-notification-attachment',
			'version'     => '1.0',
			'plugin_url'  => trailingslashit( plugin_dir_url( __FILE__ ) )
			);
		return $gf_kgm_notification_attachment;
	} else {
		add_action( 'admin_notices', 'gf_kgm_notification_attachment_admin_notices' );
	}
}

include( plugin_dir_path( __FILE__ ) . 'includes/form.php');
include( plugin_dir_path( __FILE__ ) . 'includes/save.php');
include( plugin_dir_path( __FILE__ ) . 'includes/send.php');
include( plugin_dir_path( __FILE__ ) . 'includes/enqueue.php');
include( plugin_dir_path( __FILE__ ) . 'includes/retrieve.php');
include( plugin_dir_path( __FILE__ ) . 'includes/security.php');
include( plugin_dir_path( __FILE__ ) . 'includes/notification.php');