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
			update_option( 'site_wide_pin', 			$_POST['site_wide_pin'] );

			if ( isset( $_POST['single_protected_pages'] ) && ! empty( $_POST['single_protected_pages'] ) ) {
				update_option( 'single_protected_pages', json_decode( stripslashes( $_POST['single_protected_pages'] ) ) );
			}

			update_option( 'popup_background_color', 	$_POST['popup_background_color'] );
			update_option( 'popup_text', 				$_POST['popup_text'] );
			update_option( 'popup_logo_url', 			$_POST['popup_img_src'] );

			update_option( 'popup_study_name', 			$_POST['popup_study_name'] );
			update_option( 'popup_information_text', 	$_POST['popup_information_text'] );
			update_option( 'popup_disclaimer_text', 	$_POST['popup_disclaimer_text'] );
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
						<label for="study_name">
							Study name
						</label>
					</th>
					<td>
						<?php $popup_study_name = get_option( 'popup_study_name' ) ? esc_attr ( get_option( 'popup_study_name' ) ) : '' ?>
						<input type="text" name="popup_study_name" value="<?php echo $popup_study_name; ?>" style="width: 400px;">
						
					</td>                       
				</tr>
				<tr>
					<th scope="row">
						<label for="information_text">
							Information text
						</label>
					</th>
					<td>
				<?php $popup_information_text = get_option( 'popup_information_text' ) ? esc_attr ( get_option( 'popup_information_text' ) ) : '' ?>
						<input type="text" name="popup_information_text" value="<?php echo $popup_information_text; ?>" style="width: 400px;">
						
					</td>                       
				</tr>
				<tr>
					<th scope="row">
						<label for="disclaimer_text">
							Disclaimer text
						</label>
					</th>
					<td>
						<?php $popup_disclaimer_text = get_option( 'popup_disclaimer_text' ) ? esc_attr ( get_option( 'popup_disclaimer_text' ) ) : '' ?>
						<input type="text" name="popup_disclaimer_text" value="<?php echo $popup_disclaimer_text; ?>" style="width: 400px;">
						
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
					</td>                       
				</tr>
				<tr id="site-wide-pin" style="<?php echo $protected_type == 'entire_site' ? '' : 'display:none'; ?>">
					<th scope="row">
						<label for="disclaimer_text">
							Pin Code
						</label>
					</th>
					<td>
						<?php $site_wide_pin = get_option( 'site_wide_pin' ) ? esc_attr ( get_option( 'site_wide_pin' ) ) : '' ?>
						<input type="text" name="site_wide_pin" value="<?php echo $site_wide_pin; ?>" style="width: 400px;">
					</td>                       
				</tr>
				<tr id="single-page-protecttion" style="<?php echo $protected_type == 'protect_pages' ? '' : 'display:none'; ?>">
					<style>
						.button-default {
							border-color: #c3c4c7 !important;
							color: #646970 !important;
						}
						.button-danger {
							background: #dc3232 !important;
							border-color: #dc3232 !important;
							color: #fff !important;
							margin-left: 10px !important;
						}
						.selected-password-pages {
							margin-top: 10px;
						}
						.selected-password-pages p {
							margin-bottom: 5px !important;
						}
						.selected-password-pages button {
							margin-right: 5px !important;
						}
					</style>
					<th scope="row">
						<label>
							Pin Codes
						</label>
					</th>
					<td>
						<?php
							$single_protected_pages = get_option( 'single_protected_pages' );

							// echo '<pre>';
							// var_dump( get_option( 'single_protected_pages' ) );
							// echo '</pre>';
						?>
						<input id="single-protected-pages" type="hidden" name="single_protected_pages">

						<select id="wp-pages" name="wp_pages">
							<option value="">
								Select Page
							</option>

							<?php
								$pages = get_pages(
									array(
										'post_status'  => 'publish',
										'sort_order'   => 'ASC',
										'sort_column'  => 'post_title'
									)
								);

								foreach ( $pages as $page ) :
									$display = '';

									if ( $single_protected_pages ) {
										foreach ( $single_protected_pages as $protected_page ) {
											if ( $protected_page->page_id == $page->ID ) {
												$display = 'display:none';
											}
										}
									}
							?>
								<option value="<?php echo $page->ID ?>" style="<?php echo $display; ?>">
									<?php echo $page->post_title; ?>
								</option>
							<?php endforeach; ?>
						</select>
						<input type="text" id="wp-page-password" name="wp_page_password" value="" style="width: 200px;">
						<button id="add-password-btn" class="button button-secondary" type="button">Add</button>
						<button id="update-password-btn" class="button button-secondary" type="button" style="display:none">Update</button>
						<button id="cancel-password-btn" class="button button-default" type="button" style="display:none">Cancel</button>
						<button id="delete-password-btn" class="button button-danger" type="button" style="display:none">Delete</button>

						<div id="selected-password-pages" class="selected-password-pages" style="<?php echo $single_protected_pages ? '' : 'display:none'; ?>" data-pages='<?php echo $single_protected_pages ? json_encode( $single_protected_pages ) : ''; ?>'>
							<p>Password Protected Pages</p>

							<?php
								if ( $single_protected_pages ) :
									foreach ( $single_protected_pages as $page ) :
										$page_obj = get_post( $page->page_id );
							?>
								<button data-page-id="<?php echo $page->page_id; ?>" data-page-password="<?php echo $page->page_password; ?>" class="button button-secondary" type="button">
									<?php echo $page_obj->post_title; ?>
								</button>
							<?php
									endforeach;
								endif;
							?>	
						</div>
					</td>
				</tr>
			</table>                
			<input class="button button-primary" name="save_settings" value="Save Settings" type="submit">
		</form>
		<script>
			window.onload = function() {
				// If input site_protect_level changes
				var site_protection = document.querySelectorAll('input[name="site_protect_level"]');

				for (var i = 0; i < site_protection.length; i++) {
					site_protection[i].addEventListener('change', function() {
						var global_pin = document.getElementById('site-wide-pin');
						var single_page_protection = document.getElementById('single-page-protecttion');

						if (this.value == 'entire_site') {
							global_pin.style.display = 'table-row';
							single_page_protection.style.display = 'none';
						} else {
							global_pin.style.display = 'none';
							single_page_protection.style.display = 'table-row';
						}
					});
				}

				// Single Page Protection
				var protected_pages = [];

				var single_protected_pages = document.getElementById('single-protected-pages');
				var wp_pages_select = document.getElementById('wp-pages');
				var wp_page_password = document.getElementById('wp-page-password');
				var add_button = document.getElementById('add-password-btn');

				var update_button = document.getElementById('update-password-btn');
				var cancel_button = document.getElementById('cancel-password-btn');
				var delete_button = document.getElementById('delete-password-btn');

				var selected_password_pages = document.getElementById('selected-password-pages');

				// If protected pages are already saved, add an event listener to each button
				if (selected_password_pages.getAttribute('data-pages')) {
					protected_pages = JSON.parse(selected_password_pages.getAttribute('data-pages'));
					
				}

				if (protected_pages) {
					single_protected_pages.value = JSON.stringify(protected_pages);

					var pages = selected_password_pages.getElementsByTagName('button');

					for (var i = 0; i < pages.length; i++) {
						pages[i].addEventListener('click', function() {
							var page_id = this.getAttribute('data-page-id');
							var page_password = this.getAttribute('data-page-password');

							wp_pages_select.value = page_id;
							wp_page_password.value = page_password;

							// Loop through the options and show the selected option
							for (var i = 0; i < wp_pages_select.options.length; i++) {
								if (wp_pages_select.options[i].value == page_id) {
									wp_pages_select.options[i].style.display = 'block';
								} else {
									wp_pages_select.options[i].style.display = 'none';
								}
							}

							add_button.style.display = 'none';
							update_button.style.display = 'inline-block';
							cancel_button.style.display = 'inline-block';
							delete_button.style.display = 'inline-block';
						});
					}
				}

				// Add
				add_button.addEventListener('click', function() {
					var page_id = wp_pages_select.value;
					var page_name = wp_pages_select.options[wp_pages_select.selectedIndex].text;
					var page_password = wp_page_password.value;

					if ( ! page_id || ! page_password ) {
						alert('Please select page and enter password');
						return;
					}

					// Create page button
					var page = document.createElement('button');
					page.innerHTML = page_name;
					page.setAttribute('data-page-id', page_id);
					page.setAttribute('data-page-password', page_password);
					page.setAttribute('class', 'button button-secondary');
					page.setAttribute('type', 'button');

					// Add click event to page button
					page.addEventListener('click', function() {
						var page_id = this.getAttribute('data-page-id');
						var page_password = this.getAttribute('data-page-password');

						wp_pages_select.value = page_id;
						wp_page_password.value = page_password;

						// Loop through the options and show the selected option
						for (var i = 0; i < wp_pages_select.options.length; i++) {
							if (wp_pages_select.options[i].value == page_id) {
								wp_pages_select.options[i].style.display = 'block';
							} else {
								wp_pages_select.options[i].style.display = 'none';
							}
						}

						add_button.style.display = 'none';
						update_button.style.display = 'inline-block';
						cancel_button.style.display = 'inline-block';
						delete_button.style.display = 'inline-block';
					});

					// Add page and password to hidden input
					protected_pages.push({
						page_id: page_id,
						page_password: page_password
					});

					single_protected_pages.value = JSON.stringify(protected_pages);

					// Add page to selected pages
					selected_password_pages.style.display = 'block';
					selected_password_pages.appendChild(page);

					// Set display of selected pages option to none
					wp_pages_select.options[wp_pages_select.selectedIndex].style.display = 'none';

					// Reset fields
					wp_pages_select.value = '';
					wp_page_password.value = '';

				});

				// Update
				update_button.addEventListener('click', function() {
					var page_id = wp_pages_select.value;
					var page_name = wp_pages_select.options[wp_pages_select.selectedIndex].text;
					var page_password = wp_page_password.value;

					if ( ! page_id || ! page_password ) {
						alert('Please select page and enter password');
						return;
					}

					// Loop through the selected pages and update the page
					var pages = selected_password_pages.getElementsByTagName('button');
					for (var i = 0; i < pages.length; i++) {
						if (pages[i].getAttribute('data-page-id') == page_id) {
							pages[i].innerHTML = page_name;
							pages[i].setAttribute('data-page-password', page_password);
						}
					}

					// Loop through the options and only show the non-selected options
					pages = Array.from(pages).map(function(page) {
						return page.getAttribute('data-page-id');
					});

					for (var i = 0; i < wp_pages_select.options.length; i++) {
						// If page_id is in array pages, then hide the option
						if (pages.includes(wp_pages_select.options[i].value)) {
							wp_pages_select.options[i].style.display = 'none';
						} else {
							wp_pages_select.options[i].style.display = 'block';
						}
					}

					// Update page and password to hidden input
					protected_pages = protected_pages.map(function(page) {
						if (page.page_id == page_id) {
							page.page_password = page_password;
						}
						return page;
					});

					single_protected_pages.value = JSON.stringify(protected_pages);

					// Reset fields
					wp_pages_select.value = '';
					wp_page_password.value = '';

					add_button.style.display = 'inline-block';
					update_button.style.display = 'none';
					cancel_button.style.display = 'none';
					delete_button.style.display = 'none';
				});

				// Cancel
				cancel_button.addEventListener('click', function() {
					// Loop through the options and only show the non-selected options
					var pages = selected_password_pages.getElementsByTagName('button');

					pages = Array.from(pages).map(function(page) {
						return page.getAttribute('data-page-id');
					});

					for (var i = 0; i < wp_pages_select.options.length; i++) {
						// If page_id is in array pages, then hide the option
						if (pages.includes(wp_pages_select.options[i].value)) {
							wp_pages_select.options[i].style.display = 'none';
						} else {
							wp_pages_select.options[i].style.display = 'block';
						}
					}

					wp_pages_select.value = '';
					wp_page_password.value = '';

					add_button.style.display = 'inline-block';
					update_button.style.display = 'none';
					cancel_button.style.display = 'none';
					delete_button.style.display = 'none';
				});

				// Delete
				delete_button.addEventListener('click', function() {
					var page_id = wp_pages_select.value;

					// Loop through the selected pages and remove the page
					var pages = selected_password_pages.getElementsByTagName('button');
					for (var i = 0; i < pages.length; i++) {
						if (pages[i].getAttribute('data-page-id') == page_id) {
							selected_password_pages.removeChild(pages[i]);
						}
					}

					// Loop through the options and only show the non-selected options
					pages = Array.from(pages).map(function(page) {
						return page.getAttribute('data-page-id');
					});

					for (var i = 0; i < wp_pages_select.options.length; i++) {
						// If page_id is in array pages, then hide the option
						if (pages.includes(wp_pages_select.options[i].value)) {
							wp_pages_select.options[i].style.display = 'none';
						} else {
							wp_pages_select.options[i].style.display = 'block';
						}
					}

					// Loop through the options and show the selected option
					for (var i = 0; i < wp_pages_select.options.length; i++) {
						if (wp_pages_select.options[i].value == page_id) {
							wp_pages_select.options[i].style.display = 'block';
						}
					}

					// Update page and password to hidden input
					protected_pages = protected_pages.filter(function(page) {
						return page.page_id != page_id;
					});

					single_protected_pages.value = JSON.stringify(protected_pages);

					// Reset fields
					wp_pages_select.value = '';
					wp_page_password.value = '';

					add_button.style.display = 'inline-block';
					update_button.style.display = 'none';
					cancel_button.style.display = 'none';
					delete_button.style.display = 'none';

					// If no pages are selected, hide the selected pages div
					if (selected_password_pages.getElementsByTagName('button').length == 0) {
						selected_password_pages.style.display = 'none';
					}
				});
			}
		</script>
	</div>
</div>
