/*
Media Selector
Plugin: Notification Attachments for Gravity Forms
Since: 0.1
Author: KGM Servizi
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery(function($) {

    $(document).ready(function () {
    		var element = $('#gf_kgm_notification_attachment');
    		attachment_ids = $.parseJSON(element.find('.attachment_ids').val());

			//convert the attachment_ids from objects to arrays
			attachment_ids = $.makeArray( attachment_ids );

			if(element.find('.details li').length > 0 )
			element.show();
			
			//add-remove event
			element.find('.remove').on('click',function( event ) {
				event.preventDefault();
				if( confirm( "Are you sure you wish to remove this attachment?" ) ) {
					var attachment = $(this).parent();
					var index = attachment_ids.indexOf( attachment.data('id') );
					if ( index > -1 ) {
					    attachment_ids.splice( index, 1 );
					    element.find('.attachment_ids').val( JSON.stringify( attachment_ids ) );
					}
					attachment.remove();
				}
			});

            var gf_kgm_notification_attachment;

            $('.wp-admin').on('click', '.gf_kgm_notification_attachment', function(e) {

                e.preventDefault();                

                //store the element clicked
                trigger = $(this);

                if( gf_kgm_notification_attachment ){
                    gf_kgm_notification_attachment.open();
                    return;
                }

                gf_kgm_notification_attachment = wp.media.frames.file_frame = wp.media({
                    title: 'Upload Attachment', 
                    button: {
                        text: 'Upload Attachment'
                    },
                    multiple: false
                });

                gf_kgm_notification_attachment.on('select', function() {

                    attachment = gf_kgm_notification_attachment.state().get('selection').first().toJSON();

                    console.log(attachment); 

					//create attachment grapich
					var node = $( '<li/>' ).data( 'id', attachment.id );

					//build the structure
					if (attachment.mime == 'image/jpg' || attachment.mime == 'image/jpeg' || attachment.mime == 'image/png') {
						var nodes = [
							$( '<div/>' ).addClass( 'remove dashicons dashicons-dismiss' ), //delete icon
							$( '<img/>' ).addClass( 'img_size' ).attr( 'src', attachment.url ),
							$( '<div/>').addClass('file_details').append(
								$( '<span/>').text( attachment.title ).addClass('title'),
								$( '<span/>').text( "[" + attachment.mime + "]").addClass('mime')
							),//file details
							$( '<br/>' ).addClass( 'clear' )
						];
					} else {
						var nodes = [
							$( '<div/>' ).addClass( 'remove dashicons dashicons-dismiss' ), //delete icon
							$( '<img/>' ).addClass( 'img_size' ).attr( 'src', attachment.icon ),
							$( '<div/>').addClass('file_details').append(
								$( '<span/>').text( attachment.title ).addClass('title'),
								$( '<span/>').text( "[" + attachment.mime + "]").addClass('mime')
							),//file details
							$( '<br/>' ).addClass( 'clear' )
						];
					}

					node.append( nodes );
					element.find('.details').append( node );

					//store attachments ids
					attachment_ids.push( attachment.id );

					//store attachments to button
					element.find('.attachment_ids').val( JSON.stringify( attachment_ids ) );

                });

                gf_kgm_notification_attachment.open();

            });            

    });

});