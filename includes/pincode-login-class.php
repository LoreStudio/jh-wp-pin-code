<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
/**
 * The file contains all the plugin related functions
 */
if ( !class_exists( 'Pincode_Login' ) ) {
	class Pincode_Login {		
		function __construct() {	

			add_action( 'wp_enqueue_scripts', [$this, 'pincode_login_scripts'] );
			add_action( 'admin_menu', [$this, 'pincode_login_setting_page'] );
			//add_action('wp_head', [$this, 'pincode_user_logged_in']);

			add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'] );

			add_action( 'wp_ajax_nopriv_pincode_verify_login', [$this, 'pincode_verify_login'] );
			add_action( 'wp_footer', [$this, 'add_piccode_verify_popup'] );
			// Register a new shortcode: [pincode_login_user]
            add_shortcode( 'pincode_login_check', [$this, 'pincode_login_check_user'] );
			add_filter( 'auth_cookie_expiration', [$this, 'lore_change_cookie_expire_time'], 99, 3 );
			add_action( 'admin_init', [$this, 'subscriber_block_wp_admin'] );
			add_filter( 'init', [$this,'show_admin_bar_for_admin'],9 );
			
		}
		public function show_admin_bar_for_admin(){
			if (!current_user_can('manage_options')) {
    			add_filter('show_admin_bar', '__return_false');
			}
		}
		// front end enque scripts
		public function pincode_login_scripts(){
			if( ! is_admin ( ) ) {
				wp_enqueue_script( 'jquery' );
				wp_enqueue_style( 'pincode-login-style',  PINCODE_DIR_URI. 'assets/css/pincode-style.css', array(), '1.0.0', 'all' );				
				wp_enqueue_script( "pincode-login-js", PINCODE_DIR_URI . 'assets/js/pincode-login.js', array(), '1.0.0', false );
	
				// define some local variable
				$local_variables = [
					'ajax_url'	=> admin_url( 'admin-ajax.php' ),
					'img_dir'	=> LOCATION_DIR_URI.'assets/images/',
				];
				wp_localize_script( 'pincode-login-js', 'pincode_object', $local_variables );	
			}
		}
		// admin scripts
		function admin_enqueue_scripts( ) {
			wp_enqueue_media();
		}
		// set the cookie expire
		public function lore_change_cookie_expire_time( $expire, $user_id, $remember ){
			
			//$expire is time in seconds
			$expire_hours = esc_attr(get_option('expire_cookie_hour'));
			if( !$expire_hours ){
				$expire_hours = 24;
			}
			return $expire_hours * HOUR_IN_SECONDS;
			// only for testing
			//return 30;
		}
		public function subscriber_block_wp_admin() {
			if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
				wp_safe_redirect( home_url() );
				exit;
			}
		}
		
		// this is menu setting page
		public function pincode_login_setting_page(){
			
			add_menu_page( 'PIN Code Login', 'PIN Code Login', 'administrator',  'pincode-login-setting-page', array($this,'set_store_loc_setting_page'), 'dashicons-privacy', '59.96');
		
		}
		// set the hours setting for store
		public function set_store_loc_setting_page(){
			// check capability
			if(current_user_can('manage_options')){
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/pincode-settings.php';

			}else{
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/restricted-access.php';

			}

		}
		// The callback function that will replace [pincode_login_check]
       public function pincode_login_check_user() {
		   global $post;
            $protected_type = esc_attr(get_option('site_protect_level'));
			$is_protected = false;
			if('entire_site' == $protected_type){
				$is_protected = true;
			}else{
				$protected_pages = get_option('protected_pages');
				if($protected_pages && in_array($post->ID, $protected_pages)){
					$is_protected = true;
				}
			}
			if ($is_protected && !is_user_logged_in() && !is_admin()) {
                ?>
                <script>
                    jQuery( function( $ ) {	
                        $("body").addClass('overflow-hidden');
						$('.menu-item-link a').attr("onclick","return false");
						$('.menu-item-link a').attr("href","#");
                    });
                </script>  
                <?php
                $output = $this->show_login_popup_window();
				 return $output;
                
            }
        }
		        // Email login fields
        function show_login_popup_window() {
            ob_start();
			$background_color = get_option( 'popup_background_color' ) ? esc_attr( get_option( 'popup_background_color' ) ) : false;
			$background_style = $background_color ? 'style="background-color:' . $background_color . '"' : false;
			$popup_text = get_option( 'popup_text' ) ? get_option( 'popup_text' ) : false;
        ?>       
            <div style="display:block;" class="popup" data-popup="popup-1" id="popup">
                <div class="popup-inner" <?php if ( $background_style ) { echo $background_style; } ?>>
	                <?php if( get_option( 'popup_logo_url' ) ) :  ?>
						<img src="<?php echo get_option( 'popup_logo_url' );?>" alt="logo" width="246" height="50" class="img-responsive" />
					<?php endif; ?>
					<?php if ( $popup_text ): ?>
						<div class="popup-text-wrapper">
							<p class="popup-text">
								<?php echo get_option( 'popup_text' );?>
							</p>
						</div>
					<?php endif ?>
                    <form id="pincode_login_form" action="" method="POST">
                        <input type="hidden" id="redirect_to" name="redirect_to" value="<?php echo site_url ( $_SERVER['REQUEST_URI'] ); ?>" />
                        <input type="hidden" name="action" value="pincode_verify_login">
                        <input type="hidden" name="pincode_check_nonce" value="<?php echo wp_create_nonce ( 'pincode-check-nonce' ); ?>"/>
						<div class="popup-inline">
							<input class="pincode-box" type="text" name="user_pincode" id="user_pincode" placeholder="<?php esc_html_e('PIN');?>" />
							<a class="btn-access btn" id="login_submit_btn" name="login_submit_btn"><?php esc_html_e( '→' );?> </a>
						</div>
						<div class="login_errors" id="login-error-window">
						</div>
                    </form>
                </div>
            </div>
        <?php
			return ob_get_clean();
        }
		
		// Ajax email login check	
        function pincode_verify_login() {

            $pincode = sanitize_text_field($_POST['user_pincode']);
            if (empty($pincode)) {
                // if the user name doesn't exist
				wp_send_json(array('status' => 'error', 'message' => __('Please enter your pincode')));
            }
            if (!empty($pincode) && wp_verify_nonce($_POST['pincode_check_nonce'], 'pincode-check-nonce')) {

                // this returns the user ID and other info from the user name
                $user = get_user_by('login', $pincode);
                if (!$user) {
                    // if the user name doesn't exist
					wp_send_json(array('status' => 'error', 'message' => __('Invalid pincode. Please try again')));
                }

               // wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID, 1);
                wp_send_json(array('status' => 'success', 'message' => __('Successfully Logged in')));
               
            }
            // Validation fail
            wp_send_json(array('status' => 'error', 'message' => __('Unknown error occured')));			
        }
		// call the shortcode to open popup
      function add_piccode_verify_popup() {
		if (!is_user_logged_in()) {
			echo do_shortcode('[pincode_login_check]');
		}
      }
		
	} // end of Class
	
	
	
}