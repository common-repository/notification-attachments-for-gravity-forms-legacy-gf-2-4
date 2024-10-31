<?php
/*
Send Functions
Plugin: Notification Attachments for Gravity Forms
Since: 0.1
Author: KGM Servizi
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

//Send attachment with Gravity Froms Notification
function gf_kgm_notification_attachment_send($notification, $form, $lead) {
	$attachment_id_raw = esc_attr(rgar($notification, "attachment_id"));
	$attachment_ids    = (array) json_decode($attachment_id_raw);
	$wp_upload_dir     = wp_upload_dir();
	if( !empty( $attachment_ids ) ) {
		foreach( $attachment_ids as $attachment_id ){
			$attachment = wp_get_attachment_url( $attachment_id );
			if( !empty( $attachment ) ){
				$notification['attachments'][] = str_replace( $wp_upload_dir['baseurl'], $wp_upload_dir['basedir'], $attachment );
			}
		}
	}
	return $notification;
}