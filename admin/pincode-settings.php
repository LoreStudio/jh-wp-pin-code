<?php 
	$error = '';
	if ( isset( $_POST['save_settings'] ) && !empty( $_POST['save_settings'] ) ) { 

		// validate nounce field	
		if ( ! isset( $_POST['validate_post_data'] ) || ! wp_verify_nonce( $_POST['validate_post_data'], 'validate_settings_data' ) ) {
			$error = 'Sorry, your nonce did not verify.';	   

		} else {
			$protected_pages = [];
			// WPML lang is Active
			if ( function_exists('icl_object_id') ) { 
				if ( isset( $_POST['selected_pages'] ) && ! empty( $_POST['selected_pages'] ) ) {
					foreach( $_POST['selected_pages'] as $pid ) {
						$type = apply_filters( 'wpml_element_type', get_post_type( $pid ) );
						$trid = apply_filters( 'wpml_element_trid', false, $pid, $type );
						$translations = apply_filters( 'wpml_get_element_translations', array(), $trid, $type );
						// find any translation
						if( $translations ){
							foreach ( $translations as $lang => $translation ) {
								$protected_pages[] = $translation->element_id;							
								
							}
						}
					}
				}
			}else{ // simple site
				if ( isset( $_POST['selected_pages'] ) && ! empty( $_POST['selected_pages'] ) ) {
					foreach( $_POST['selected_pages'] as $pid ) {
						$protected_pages[] = $pid;
					}
				}
			}
			update_option( 'expire_cookie_hour', sanitize_text_field( $_POST['expire_cookie_hour'] ) );
			
			if ( $_POST['site_protect_level'] == 'protect_pages' ) {
				update_option( 'protected_pages', $protected_pages );
			}
			update_option( 'site_protect_level', 		$_POST['site_protect_level'] );
			update_option( 'popup_background_color', 	$_POST['popup_background_color'] );
			update_option( 'popup_text', 				$_POST['popup_text'] );
			update_option( 'popup_logo_url', 			$_POST['popup_img_src'] );
		}
	}

?>

<div class="wrap">
	<h1 id="add-new-user"> 
		<?php _e('Pin Code Login Settings');?>
	</h1>
	<?php if ( ! empty( $error ) ) : ?>
		<div class="notice notice-success is-dismissible">
			<p>
				<?php echo esc_html( $error );?>
			</p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text">
					Dismiss this notice.
				</span>
			</button>
		</div>
	<?php endif; ?>
	<div class="wrap">
		<form method="post" action="" enctype="multipart/form-data">
			<?php wp_nonce_field( 'validate_settings_data', 'validate_post_data' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="upload_logo">
							Upload Logo
						</label>
					</th>
					<td>
						<?php $popup_logo_url = get_option( 'popup_logo_url' ) ? get_option( 'popup_logo_url' ) : ''; ?>
						<?php if ( $popup_logo_url ) : ?>
							<p>
								<img src="<?php echo $popup_logo_url;?>" alt="logo" width="246" height="50" id="popup_logo_url">
							</p>
						<?php endif; ?>
						<input type="text" name="popup_img_src" id="popup_img_src" value="<?php echo $popup_logo_url;?>">    
						<input type='button' class="button-primary" id="open-media-dialog" value="Choose Image" />
						<script type="text/javascript">
							(function( $ ) {
								var wp_media_dialog_field;
								function selectMedia() {
								    var custom_uploader;
								    if ( custom_uploader ) {
								        custom_uploader.open( );
								    	console.log( 'custom_uploader' );
								        return;
								    }
							    	console.log( 'custom_uploader next' );
								    custom_uploader = wp.media.frames.file_frame = wp.media({
								        title: 'Choose Image',
								        button: {
								            text: 'Choose Image'
								        },
								        multiple: false
								    });
								    custom_uploader.on('select', function() {
								    	console.log( 'on select' );
								        attachment = custom_uploader.state().get('selection').first().toJSON();
								        wp_media_dialog_field.val( attachment.url );
								        console.log( attachment.url )
								        // jQuery( '#popup_img_src' ).val( attachment.url )
									    jQuery( '#popup_logo_url' ).prop( 'src', attachment.url );
								    });
								    custom_uploader.open();
								}
								jQuery( '#open-media-dialog' ).click( function(e) {
								    e.preventDefault();
								    wp_media_dialog_field = jQuery( '#popup_img_src' );
								    selectMedia();
								});
							})(jQuery);
						</script>
					</td>       
				</tr>
				<tr>
					<th scope="row">
						<label for="popup_text">
							Text
						</label>
					</th>
					<td>
						<textarea name="popup_text" style="height: 283px;width: 400px;" ><?php echo get_option( 'popup_text' ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row" style="width:260px;">
						<label for="upload_logo">
							Popup Background Color (E.g #4672BC)
						</label>
					</th>
					<td>
						<?php $bk_color = get_option( 'popup_background_color' ) ? esc_attr ( get_option( 'popup_background_color' ) ) : '#fff' ?>
						<input type="text" name="popup_background_color" value="<?php echo $bk_color; ?>">
					</td>                       
				</tr>
				<tr>
					<th scope="row">
						<label for="expire_cookie">
							Cookie Expire in Hours
						</label>
					</th>
					<td>
						<?php $expire_cookie_hour = get_option( 'expire_cookie_hour' ) ? esc_attr( get_option( 'expire_cookie_hour' ) ) : ''; ?>
						<select name="expire_cookie_hour" id="expire_cookie_hour">
							<option value="">
								Select Expire Hours
							</option>
							<?php for( $hour = 1; $hour <=48; $hour++ ) : ?>
								<option value="<?php echo $hour;?>" <?php if ( $hour == $expire_cookie_hour ) { echo 'selected'; } ?> >
									<?php echo $hour;?>
								</option>
							<?php endfor; ?>
						</select>   
					</td>                       
				</tr>
				<tr>
					<th scope="row">
						<label for="protection_level">
							Protection Level
						</label>
					</th>
					<td>
						<?php
							$protected_type = esc_attr( get_option('site_protect_level' ) );
							if ( ! $protected_type ) {
								$protected_type = 'entire_site';
							}
						?>
						<label for="site_level">
							<input <?php if ( 'entire_site' == $protected_type ) { echo 'checked'; } ?> type="radio" name="site_protect_level" value="entire_site">
							Protect Entire Site
						</label>
						<br>
						<label for="pages_level">
							<input <?php if ( 'protect_pages' == $protected_type ) { echo 'checked'; } ?> type="radio" name="site_protect_level" value="protect_pages">
							Protect Specific Pages
						</label>
						<div id="protect_pages_wrapper" <?php if ( 'protect_pages' != $protected_type ) { echo 'style="display:none;"'; } ?> >
							<h2>
								Select page to protect
							</h2>
							<?php
								$protected_pages = get_option( 'protected_pages' );
								$pages = get_pages(
									array(
										'post_status'  => 'publish',
										'sort_order'   => 'ASC',
										'sort_column'  => 'post_title'
									)
								);
							?>
							<?php foreach ( $pages as $page ) : ?>
								<p>
									<?php $checked = $protected_pages && in_array( $page->ID, $protected_pages ) ?>
									<input type="checkbox" name="selected_pages[]" value="<?php echo $page->ID; ?>" <?php if ( $checked ) { echo 'checked'; } ?> >
									<?php echo $page->post_title; ?>
								</p>
							<?php endforeach?>
						</div>
					</td>                       
				</tr>
			</table>                
			<input class="button button-primary" name="save_settings" value="Save Settings" type="submit">
		</form>
		<script>
			jQuery(document).ready(function(e) {
			   jQuery('input[name="site_protect_level"]').on('change', function(){
				   if(jQuery(this).val() == 'entire_site'){
					   jQuery('#protect_pages_wrapper').hide();
				   }else{
						jQuery('#protect_pages_wrapper').show();
				   }
			   });
			});
		</script>
	</div>
</div>
