<?php
/*
Form inside Gravity Forms Notification setting structure and function
Plugin: Notification Attachments for Gravity Forms
Since: 0.1
Author: KGM Servizi
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

//Code for form inside Gravity Forms Notification setting
function gf_kgm_notification_attachment_editor($ui_settings, $notification, $form) {
	if (!empty($ui_settings['notification_message'])) {
		$attachment_id_raw = esc_attr(rgar($notification, "attachment_id"));
		$attachment_ids    = (array) json_decode($attachment_id_raw);
		if (empty($attachment_id_raw)) {
			$attachment_id_raw = "[]";
		}
		ob_start();
		?>
		<tr valign="top">
            <th scope="row">
                <label for="gf_kgm_notification_attachment">
                    <?php _e("Attachments", "gf_kgm_notification_attachment"); ?>
                </label>
            </th>
            <td id="gf_kgm_notification_attachment">
				<ul class="details">
					<?php foreach( $attachment_ids as $attachment_id ) : $attachment = gf_kgm_notification_attachment_get_meta( $attachment_id ); ?>
					<li data-id="<?php echo esc_attr($attachment_id); ?>">
						<div class="remove dashicons dashicons-dismiss"></div>
	                	<img src="<?php echo esc_url($attachment->mime_file); ?>" class="flt_left" />
	                	<div class="flt_left file_details">
		                	<span class="title"><?php echo esc_html($attachment->title); ?></span>
		                	<span class="mime">[<?php echo esc_html($attachment->mime); ?>]</span>
		                </div>
		                <br class="clear">
	                </li>
	                <?php endforeach; ?>           	
                </ul>
                <input type="hidden" name="gf_kgm_notification_attachment_id" id="gf_kgm_notification_attachment_id" class="attachment_ids" value="<?php echo esc_attr($attachment_id_raw); ?>" />
            	<a href="#" class="button add gf_kgm_notification_attachment" title="<?php _e('Add Attachment', 'gf-notification-attachment'); ?>">
            		<?php _e('Add Attachment', 'gf-notification-attachment'); ?>
            	</a>
            </td>
        </tr>
        <?php
		$ui_settings['notification_message'] .= ob_get_clean();
	}
	return $ui_settings;
}

//Retrieve attachment value for Form
function gf_kgm_notification_attachment_get_meta($attachment_id) {

	$attachment = get_post($attachment_id);
	$image      = wp_get_attachment_image_src($attachment_id, array(150,150), true); 
	$image      = !empty($image) ? $image[0] : null;

	if (is_null($image)) {
		$image = wp_mime_type_icon($attachment->post_mime_type);
	}

	return (object) apply_filters('gf_kgm_notification_attachment_get_meta', array(
			'id'        => $attachment_id,
			'mime_file' => $image,
			'mime'      => $attachment->post_mime_type,
			'title'     => $attachment->post_title
		), $attachment_id, $attachment);
}