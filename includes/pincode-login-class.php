<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
/**
 * The file contains all the plugin related functions
 */
if ( !class_exists( 'Pincode_Login' ) ) {
	class Pincode_Login {

		public $plugin_slug;
		public $version;
		public $cache_key;
		public $cache_allowed;

		public $t1d_pin_data = array(
			'673710' => array(
				array(
					'lang' => 'English',
					'homepage' => 'https://t1dclinicaltrial.com/',
					'resource_center_page' => 'https://t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://t1dclinicaltrial.com/resources/moa-video/'
				),
				array(
					'lang' => 'Spanish',
					'homepage' => 'https://es-us.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://es-us.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://es-us.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673711' => array(
				array(
					'lang' => 'Dutch',
					'homepage' => 'https://nl-be.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://nl-be.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://nl-be.t1dclinicaltrial.com/resources/moa-video/'
				),
				array(
					'lang' => 'French',
					'homepage' => 'https://fr-be.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://fr-be.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://fr-be.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673712' => array(
				array(
					'lang' => 'Canada (English)',
					'homepage' => 'https://en-ca.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://en-ca.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://en-ca.t1dclinicaltrial.com/resources/moa-video/'
				),
				array(
					'lang' => 'Canada (French)',
					'homepage' => 'https://fr-ca.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://fr-ca.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://fr-ca.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673713' => array(
				array(
					'lang' => 'Czech (Czech Republic)',
					'homepage' => 'https://cs-cz.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://cs-cz.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://cs-cz.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673714' => array(
				array(
					'lang' => 'Danish (Denmark)',
					'homepage' => 'https://da-dk.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://da-dk.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://da-dk.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673715' => array(
				array(
					'lang' => 'French (France)',
					'homepage' => 'https://fr-fr.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://fr-fr.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://fr-fr.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673716' => array(
				array(
					'lang' => 'German (Germany)',
					'homepage' => 'https://de-de.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://de-de.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://de-de.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673717' => array(
				array(
					'lang' => 'Hungarian (Hungary)',
					'homepage' => 'https://hu-hu.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://hu-hu.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://hu-hu.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673718' => array(
				array(
					'lang' => 'Italian (Italy)',
					'homepage' => 'https://it-it.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://it-it.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://it-it.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673719' => array(
				array(
					'lang' => 'Polish (Poland)',
					'homepage' => 'https://pl-pl.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://pl-pl.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://pl-pl.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673720' => array(
				array(
					'lang' => 'Spanish (Spain)',
					'homepage' => 'https://es-es.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://es-es.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://es-es.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673721' => array(
				array(
					'lang' => 'Swedish (Sweden)',
					'homepage' => 'https://sv-se.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://sv-se.t1dclinicaltrial.com/resources/',
					'moa_video' => 'https://sv-se.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
			'673722' => array(
				array(
					'lang' => 'English (UK)',
					'homepage' => 'https://en-gb.t1dclinicaltrial.com/',
					'resource_center_page' => 'https://en-gb.t1dclinicaltrial.com/resources',
					'moa_video' => 'https://en-gb.t1dclinicaltrial.com/resources/moa-video/'
				)
			),
		);
		
		function __construct() {
			
			$this->plugin_slug   = plugin_basename( __DIR__ );
			$this->version       = PINCODE_PLUGIN_VERSION;
			$this->cache_key     = 'pincode-login';
			$this->cache_allowed = false;
			
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
			
			//Update functions
			add_filter( 'plugins_api', [ $this, 'update_info' ], 20, 3 );
			add_filter( 'site_transient_update_plugins', [ $this, 'plugin_update' ] );
			add_action( 'upgrader_process_complete', [ $this, 'update_purge' ], 10, 2 );

			// Hide page content if pincode is not entered
			if ( ! is_admin() ) {
				// Start the output buffer
				add_action( 'init', function() {
					ob_start();
				} );

				add_action( 'shutdown', function() {
					$final = '';

					// We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
					// that buffer's output into the final output.
					$levels = ob_get_level();

					for ( $i = 0; $i < $levels; $i++ ) {
						$final .= ob_get_clean();
					}

					// Apply any filters to the final output
					echo apply_filters( 'final_output', $final );
				}, 0 );

				add_filter( 'final_output', function( $output ) {
					// Get current page id
					$page_id = get_queried_object_id();

					// Get pincode from cookie.
					if ( isset( $_GET['pin'] ) && $this->is_valid_t1d_pin( $_GET['pin'] ) ) {
						setcookie( 'pincode', $_GET['pin'], time() + ( 2 * 60 * 60 ), '/' );
						
						return $output;
					}

					$protected_type = esc_attr( get_option( 'site_protect_level' ) );

					$is_protected = false;

					if( 'entire_site' == $protected_type ) {
						$is_protected = true;
					} else {
						$protected_pages = get_option( 'protected_pages' );

						if( $protected_pages && in_array( $page_id, $protected_pages ) ) {
							$is_protected = true;
						}
					}

					// Remove the content if the page is protected
					if ( $is_protected && !is_user_logged_in() && !is_admin() ) {
						$output = preg_replace( '/<article[^>]*>.*?<\/article>/si', '', $output );
					}

					return $output;
				} );
			}
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
				wp_enqueue_script( "pincode-login-js", PINCODE_DIR_URI . 'assets/js/pincode-login.js', array('jquery'), '1.0.4', true );
	
				// define some local variable
				$local_variables = [
					'ajax_url'	=> admin_url( 'admin-ajax.php' ),
					'img_dir'	=> PINCODE_DIR_URI.'assets/images/',
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

			// Get pincode from cookie.
			if ( isset( $_COOKIE['pincode'] ) ) {
				$pincode = sanitize_text_field( $_COOKIE['pincode'] );
				return;
			}

			// Get pincode from url.
			if ( isset( $_GET['pin'] ) && $this->is_valid_t1d_pin( $_GET['pin'] ) ) {
				return;
			}

			if ($is_protected && !is_user_logged_in() && !is_admin()) {
                ?>
                <script>
                    ( function( $ ) {	
                        $("body").addClass('overflow-hidden');
						$('.menu-item-link a').attr("onclick","return false");
						$('.menu-item-link a').attr("href","#");
                    })(jQuery);
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
			$popup_study_name = get_option( 'popup_study_name' ) ? get_option( 'popup_study_name' ) : '';
			$popup_information_text = get_option( 'popup_information_text' ) ? get_option( 'popup_information_text' ) : '';
			$popup_disclaimer_text = get_option( 'popup_disclaimer_text' ) ? get_option( 'popup_disclaimer_text' ) : '';
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
					<?php if( !empty($popup_study_name)){?>
						<h1 class="study-name"><?php esc_html_e( $popup_study_name );?></h1>
					<?php }?>
					<?php if( !empty($popup_information_text)){?>
						<p class="information-text"><?php  esc_html_e($popup_information_text);?></p>
					<?php }?>
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
                    <?php if( !empty($popup_disclaimer_text)){?>
						<p class="disclaimer-text"><?php esc_html_e( $popup_disclaimer_text);?></p>
					<?php }?>
                </div>
            </div>
        <?php
			return ob_get_clean();
        }
		
		// Ajax email login check	
        function pincode_verify_login()
		{
            $pincode = sanitize_text_field($_POST['user_pincode']);

            if (empty($pincode)) {
                // if the user name doesn't exist
				wp_send_json(array('status' => 'error', 'message' => __('Please enter your pincode')));
            }
            if (!empty($pincode) && wp_verify_nonce($_POST['pincode_check_nonce'], 'pincode-check-nonce')) {

				$t1d_pins = $this->t1d_pins( $pincode, $_POST['redirect_to'] );

                $user = get_user_by('login', $pincode);

                if ($t1d_pins == false && !$user) {
                    // if the user name doesn't exist
					wp_send_json(array('status' => 'error', 'message' => __('Invalid pincode. Please try again')));
                }

				// If user, then login user and show page.
				if ( $user ) {
					// wp_set_current_user($user->ID);
					wp_set_auth_cookie($user->ID, 1);

					// Set cookie for pincode for 2 hours - t1dclinicaltrial.com
					if ( strpos( $_POST['redirect_to'], 't1dclinicaltrial.com' ) != false ) {
						setcookie( 'pincode', $pincode, time() + ( 2 * 60 * 60 ), '/' );
					}

					wp_send_json(
						array(
							'status' => 'success',
							'message' => __('Successfully Logged in'),
							'redirect_to' => $t1d_pins != false ?  $t1d_pins . '?pin=' . $pincode : $_POST['redirect_to']
						)
					);

					return;
				}

				// Set cookie for pincode for 2 hours - t1dclinicaltrial.com
				if ( strpos( $_POST['redirect_to'], 't1dclinicaltrial.com' ) != false ) {
					setcookie( 'pincode', $pincode, time() + ( 2 * 60 * 60 ), '/' );

					wp_send_json(
						array(
							'status' => 'success',
							'message' => __('Successfully Logged in'),
							'redirect_to' => $t1d_pins . '?pin=' . $pincode
						)
					);
				}
            }
            // Validation fail
            wp_send_json(array('status' => 'error', 'message' => __('Unknown error occured')));			
        }

		/**
		 * T1D PIN codes
		 */
		function t1d_pins( $pin, $redirect_to )
		{
			// If $redirect_to url string does not contain 't1dclinicaltrial.com', then return false.
			if ( strpos( $redirect_to, 't1dclinicaltrial.com' ) == false ) {
				return false;
			}

			$pins = $this->t1d_pin_data;

			// Get pin keys.
			$pi_keys = array_keys( $pins );

			// Check if pin is in array.
			if ( in_array( $pin, $pi_keys ) ) {
				$redirect_url = false;

				// Get the site.
				$sites = $pins[ $pin ];

				// If site has 2 entries, then get the url that matches the $redirect_to.
				if ( count( $sites ) == 2 ) {
					foreach ( $sites as $site ) {
						foreach ( $site as $key => $value ) {
							if ( $value == $redirect_to ) {
								$redirect_url = $value;
							}
						}
					}

					// If $redirect_url is still false, then redirect to fist site's url.
					if ( $redirect_url == false ) {
						if ( strpos( $redirect_to, 'resources' ) !== false ) {
							$redirect_url = $sites[0]['resource_center_page'];
						} elseif ( strpos( $redirect_to, 'moa-video' ) !== false ) {
							$redirect_url = $sites[0]['moa_video'];
						} else {
							$redirect_url = $sites[0]['homepage'];
						}
					}
				} else {
					// If redirect_to contains 'resources', then redirect to resources page.
					if ( strpos( $redirect_to, 'resources' ) !== false ) {
						$redirect_url = $sites[0]['resource_center_page'];
					} elseif ( strpos( $redirect_to, 'moa-video' ) !== false ) {
						$redirect_url = $sites[0]['moa_video'];
					} else {
						$redirect_url = $sites[0]['homepage'];
					}
				}

				return $redirect_url;
			}

			return false;
		}

		/**
		 * Check if pin is valid.
		 */
		function is_valid_t1d_pin( $pin )
		{
			// Get pin keys.
			$pin_keys = array_keys( $this->t1d_pin_data );

			// Check if pin is in array.
			if ( in_array( $pin, $pin_keys ) ) {
				return true;
			}

			return false;
		}

		// call the shortcode to open popup
		function add_piccode_verify_popup() {
			if (!is_user_logged_in()) {
				echo do_shortcode('[pincode_login_check]');
			}
		}
		
		public function update_request() {
		
			$remote = get_transient( $this->cache_key );
			
			if( false === $remote ) {
				
				$remote = wp_remote_get( 'https://raw.githubusercontent.com/LoreStudio/jh-wp-pin-code/main/pin-code-info.json', [
					'timeout' => 10,
			    		'headers' => [
						'Accept' => 'application/json'
			    		]
				  ]);
			
				if ( is_wp_error( $remote ) || 200 !== wp_remote_retrieve_response_code( $remote ) || empty( wp_remote_retrieve_body( $remote ) ) ) {
					return false;
				}
			
				set_transient( $this->cache_key, $remote, 120 );
			
			}
			
			$remote = json_decode( wp_remote_retrieve_body( $remote ) );
			
			return $remote;
		
		}	

		function update_info( $response, $action, $args ) {
		
			// do nothing if you're not getting plugin information right now
			if ( 'plugin_information' !== $action ) {
			    return $response;
			}
			
			// do nothing if it is not our plugin
			if ( empty( $args->slug ) || $this->plugin_slug !== $args->slug ) {
			    return $response;
			}
			
			// get updates
			$remote = $this->update_request();
			
			if ( ! $remote ) {
			    return $response;
			}
			
			$response = new \stdClass();
			
			$response->name           = $remote->name;
			$response->slug           = $remote->slug;
			$response->version        = $remote->version;
			$response->download_link  = $remote->download_url;
			$response->trunk          = $remote->download_url;
			$response->last_updated   = $remote->last_updated;
			
			$response->sections = [
			    'description'  => $remote->sections->description,
			    'installation' => $remote->sections->installation,
			    'changelog'    => $remote->sections->changelog
			];
			
			
			return $response;
		
		}

		public function plugin_update( $transient ) {
		
			if ( empty($transient->checked ) ) {
			    return $transient;
			}
		
			$remote = $this->update_request();
		
			if ( $remote && version_compare( $this->version, $remote->version, '<' ) ) {
			    $response              = new \stdClass();
			    $response->slug        = $this->plugin_slug;
			    $response->plugin      = "jh-wp-pin-code-main/pin-code-login.php";
			    $response->new_version = $remote->version;
			    $response->package     = $remote->download_url;
			
			    $transient->response[ $response->plugin ] = $response;
			
			}
		
			return $transient;		
		}
		
		public function update_purge( $upgrader, $options ) {		
			if ( $this->cache_allowed && 'update' === $options['action'] && 'plugin' === $options[ 'type' ] ) {
		    		// clean the cache when new plugin version is installed
		    		delete_transient( $this->cache_key );
			}		
		}	
	
 } // end of Class
	
}
