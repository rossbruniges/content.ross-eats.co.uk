<?php

if ( ! class_exists('TTFCore') ) {
	class TTFCore {

		var $domain;
		var $themename = "Jestro";
		var $themeurl = "http://thethemefoundry.com/";
		var $shortname = "jestro_themes";
		var $options = array();

		/* PHP4 Compatible Constructor */
		function TTFCore () {
			add_action( 'admin_init', array(&$this, 'printAdminScripts' ) );
			add_action( 'admin_init', array(&$this, 'redirectRegistration' ) );
			add_action( 'admin_menu', array(&$this, 'addAdminPage' ) );
			add_action( 'widgets_init', array(&$this, 'registerSidebars' ) );
			add_action( 'wp_before_admin_bar_render', array(&$this, 'adminBarRender'), 99);
			add_action( 'wp_footer', array(&$this, 'statsCode'));

			load_theme_textdomain( $this->domain, locate_template( array( 'languages' ) ) );

			$this->setupTheme();
		}

		function setupTheme() {
			$this->addContentWidth();
			$this->addFeedSupport();
			$this->addImageSize();
			$this->addThumbnailSupport();

			do_action( 'setup_theme_' . $this->domain );
		}

		function addContentWidth() {}

		function addFeedSupport() {
			add_theme_support( 'automatic-feed-links');
		}

		function addImageSize() {}

		function addThumbnailSupport() {
			add_theme_support( 'post-thumbnails' );
		}

		/* Add Custom CSS & JS */
		function printAdminScripts () {
			if ( current_user_can( 'edit_theme_options' ) && isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
				wp_enqueue_script( 'media-upload' );
				add_thickbox();
				wp_enqueue_style( 'jestro', get_template_directory_uri().'/functions/stylesheets/admin.css');
				wp_enqueue_script( 'jestro', get_template_directory_uri().'/functions/javascripts/admin.js', array('jquery') );
				wp_enqueue_script( 'farbtastic' );
				wp_enqueue_style( 'farbtastic' );
			}
		}

		function redirectRegistration() {
			global $pagenow;
			if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
				wp_redirect( admin_url( 'themes.php?page=ttf-admin.php' ) );
				exit;
			}
		}

		function registerSidebars() {}

		function adminBarRender() {
			global $wp_admin_bar;

			if ( ! empty( $wp_admin_bar ) ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'appearance',
					'title' => __( 'Theme Options' ),
					'href' => admin_url('themes.php?page=ttf-admin.php'),
				) );
			}
		}

		/* Process Input and Add Options Page*/
		function addAdminPage() {
			// global $themename, $shortname, $options;
			if ( current_user_can( 'edit_theme_options' ) && isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
				if ( ! empty( $_REQUEST['save-theme-options-nonce'] ) && wp_verify_nonce( $_REQUEST['save-theme-options-nonce'], 'save-theme-options' ) && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'save' ) {
					foreach ($this->options as $value) {
						if ( array_key_exists('id', $value) ) {
							if ( isset( $_REQUEST[ $value['id'] ] ) ) {
								if (
									in_array(
										$value['id'],
										array(
											$this->shortname.'_background_color',
											$this->shortname.'_hover_color',
											$this->shortname.'_link_color',
										)
									)
								) {
									$opt_value = preg_match( '/^#([a-zA-Z0-9]){3}$|([a-zA-Z0-9]){6}$/', trim( $_REQUEST[ $value['id'] ] ) ) ? trim( $_REQUEST[ $value['id'] ] ) : '';
									update_option( $value['id'], $opt_value );
								} elseif (
									in_array(
										$value['id'],
										array(
											$this->shortname.'_categories_to_exclude',
											$this->shortname.'_pages_to_exclude',
										)
									)
								) {
									$opt_value = implode(',', array_filter( array_map( 'intval', explode(',', $_REQUEST[ $value['id'] ] ) ) ) );
									update_option( $value['id'], $opt_value );
								} else {
									update_option( $value['id'], stripslashes( $_REQUEST[ $value['id'] ] ) );
								}
							} else {
								delete_option( $value['id'] );
							}
						}
					}
					wp_redirect("themes.php?page=".basename(__FILE__)."&saved=true");
					exit;
				} else if ( ! empty( $_REQUEST['reset-theme-options-nonce'] ) && wp_verify_nonce( $_REQUEST['reset-theme-options-nonce'], 'reset-theme-options' ) && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'reset' ) {
					foreach ($this->options as $value) {
						if ( array_key_exists('id', $value) ) {
							delete_option( $value['id'] );
						}
					}
					wp_redirect("themes.php?page=".basename(__FILE__)."&reset=true");
					exit;
				}
			}

			add_theme_page(
				__( 'Theme Options' ),
				__( 'Theme Options' ),
				'edit_theme_options',
				basename(__FILE__),
				array(&$this, 'adminPage' )
			);
		}

		/* Output of the Admin Page */
		function adminPage () {
			// global $themename, $shortname, $options;
			$up_dir = wp_upload_dir();
			if ( ! empty( $_REQUEST['saved'] ) ) {
				echo '<div id="message" class="updated fade"><p><strong>' . sprintf( __( '%s settings saved!', $this->domain ), $this->themename ) . '</strong></p></div>';
			}

			if ( ! empty( $_REQUEST['reset'] ) ) {
				echo '<div id="message" class="updated fade"><p><strong>' . sprintf( __( '%s settings reset.', $this->domain ), $this->themename ) . '</strong></p></div>';
			}
			?>

		<div id="v-options">
			<div id="vop-header">
				<h1><?php printf( __( '%s Options', $this->domain ), $this->themename ); ?></h1>
				<p><?php
					printf(
						__( '<strong>Need help?</strong> <a href="%1$s">Read the tutorials</a> or visit the <a href="%2$s">support forums.</a>', $this->domain ),
						'http://thethemefoundry.com/tutorials/' . $this->domain,
						'http://thethemefoundry.com/forums/'
					);
				?></p>
			</div><!--end vop-header-->
			<div class="v-notice">
				<h3><?php _e( 'Go PRO!', $this->domain ); ?></h3>
				<p><?php _e( 'You are using the free trial version of ' . $this->themename . '. Upgrade to ' . $this->themename . ' PRO for extra features, lifetime theme updates, dedicated support, and comprehensive theme tutorials.', $this->domain ); ?></p>
				<p><a href="http://thethemefoundry.com/<?php echo $this->domain; ?>/"><?php _e( 'Learn more about ' . $this->themename . ' PRO &rarr;', $this->domain ); ?></a></p>
			</div>
			<div id="vop-body">
				<form method="post" action="">
					<?php wp_nonce_field( 'save-theme-options', 'save-theme-options-nonce' );
					for ($i = 0; $i < count($this->options); $i++) :
						switch ($this->options[$i]["type"]) :
							case "subhead":
								if ($i != 0) :
									?>
									<div class="v-save-button submit">
										<input type="hidden" name="action" value="save" />
										<input class="button-primary" type="submit" value="<?php esc_attr_e( 'Save changes', $this->domain ); ?>" name="save"/>
									</div><!--end v-save-button-->
								</div>
							</div><!-- .v-option -->
									<?php
								endif;

								?>
								<div class="v-option">
									<h3><?php echo $this->options[$i]["name"]; ?></h3>
									<div class="v-option-body clear">
										<?php if ( isset( $this->options[$i]["notice"] ) ) : ?>
											<p class="notice"><?php echo $this->options[$i]["notice"]; ?></p>
										<?php endif; ?>
								<?php
							break;

							case "checkbox":
								?>
								<?php if ( isset( $this->options[$i]["pro"] ) ) $pro = $this->options[$i]["pro"]; else $pro = false; ?>
								<div class="v-field check clear <?php if ( $pro == 'true' ) echo 'pro'; ?>">
									<div class="v-field-d"><span><?php echo $this->options[$i]["desc"]; ?></span></div>
									<input id="<?php echo $this->options[$i]["id"]; ?>" type="checkbox" name="<?php echo $this->options[$i]["id"]; ?>" value="true"<?php echo (get_option($this->options[$i]['id'])) ? ' checked="checked"' : ''; ?> />
									<label for="<?php echo $this->options[$i]["id"]; ?>"><?php echo $this->options[$i]["name"]; ?></label>
								</div><!--end v-field check-->
								<?php
							break;

								case "radio":
									?>
									<?php if ( isset( $this->options[$i]["pro"] ) ) $pro = $this->options[$i]["pro"]; else $pro = false; ?>
									<div class="v-field radio clear <?php if ( $pro == 'true' ) echo 'pro'; ?>">
										<div class="v-field-d"><span><?php echo $this->options[$i]["desc"]; ?></span></div>
											<?php
											$radio_setting = get_option($this->options[$i]['id']);
											$checked = "";
											foreach ($this->options[$i]['options'] as $key => $val) :
												if ($radio_setting != '' &&	$key == get_option($this->options[$i]['id']) ) {
													$checked = ' checked="checked"';
												} else {
													if ($key == $this->options[$i]['std']){
														$checked = 'checked="checked"';
													}
												}
												?>
												<input type="radio" name="<?php echo esc_attr( $this->options[$i]['id'] ); ?>" value="<?php echo esc_attr( $key ); ?>"<?php echo $checked; ?> /><?php echo $val; ?><br />
											<?php endforeach; ?>
										<label for="<?php echo esc_attr( $this->options[$i]["id"] ); ?>"><?php echo $this->options[$i]["name"]; ?></label>
									</div><!--end v-field radio-->
									<?php
								break;

								case "upload":
									?>
									<?php if ( isset( $this->options[$i]["pro"] ) ) $pro = $this->options[$i]["pro"]; else $pro = false; ?>
									<div class="v-field logo-upload clear <?php if ( $pro == 'true' ) echo 'pro'; ?>">
										<div class="v-field-d"><span><?php echo $this->options[$i]["desc"]; ?></span></div>
										<div class="v-field-c">
											<label for="<?php echo esc_attr( $this->options[$i]["id"] ); ?>"><?php echo $this->options[$i]["name"]; ?></label>
											<input id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" type="text" name="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" class="<?php echo esc_attr( $this->options[$i]["class"] ); ?>" value="<?php
												$id = get_option( $this->options[$i]["id"] );
												echo esc_attr( '' != $id ? $id : $this->options[$i]["std"] ); ?>" />
											<input id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>_upload_button" type="button" value="Upload Logo" data-type="image" data-field-id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" class="button" />
										</div>
									</div><!--end v-field text-->
									<?php
								break;

								case "text":
									?>
									<?php if ( isset( $this->options[$i]["pro"] ) ) $pro = $this->options[$i]["pro"]; else $pro = false; ?>
									<div class="v-field text clear <?php if ( $pro == 'true' ) echo 'pro'; ?>">
										<div class="v-field-d"><span><?php echo $this->options[$i]["desc"]; ?></span></div>
										<label for="<?php echo esc_attr( $this->options[$i]["id"] ); ?>"><?php echo $this->options[$i]["name"]; ?></label>
										<input id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" type="text" name="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" value="<?php
											$id = get_option( $this->options[$i]["id"] );
											echo esc_attr( stripslashes( '' != $id ? $id : $this->options[$i]["std"] ) ); ?>" />
									</div><!--end v-field text-->
									<?php
								break;

								case "colorpicker":
									?>
									<?php if ( isset( $this->options[$i]["pro"] ) ) $pro = $this->options[$i]["pro"]; else $pro = false; ?>
									<div class="v-field colorpicker clear <?php if ( $pro == 'true' ) echo 'pro'; ?>">
										<div class="v-field-d"><span><?php echo $this->options[$i]["desc"]; ?></span></div>
										<label for="<?php echo esc_attr( $this->options[$i]["id"] ); ?>"><?php echo $this->options[$i]["name"]; ?> <a href="#<?php echo esc_attr( $this->options[$i]["id"] ); ?>_colorpicker" onclick="toggleColorpicker (this, '<?php echo esc_js( $this->options[$i]["id"] ); ?>', 'open', '<?php _e( 'show color picker', $this->domain ); ?>', '<?php _e( 'hide color picker', $this->domain ); ?>')"><?php _e( 'show color picker', $this->domain ); ?></a></label>
										<div id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>_colorpicker" class="colorpicker_container"></div>
										<input id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" type="text" name="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" value="<?php
											$id = get_option($this->options[$i]["id"]);
											echo esc_attr( $id ? $id : $this->options[$i]["std"] ); ?>" />
									</div><!--end v-field colorpicker-->
									<?php
								break;

								case "select":
									?>
									<?php if ( isset( $this->options[$i]["pro"] ) ) $pro = $this->options[$i]["pro"]; else $pro = false; ?>
									<div class="v-field select clear <?php if ( $pro == 'true' ) echo 'pro'; ?>">
										<div class="v-field-d"><span><?php echo $this->options[$i]["desc"]?></span></div>
										<label for="<?php echo esc_attr( $this->options[$i]["id"] ); ?>"><?php echo $this->options[$i]["name"]; ?></label>
										<select id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" name="<?php echo esc_attr( $this->options[$i]["id"] ); ?>">
											<?php
												foreach ( (array) $this->options[$i]["options"] as $key => $val) :
													if ( '' == get_option($this->options[$i]["id"]) || is_null( get_option($this->options[$i]["id"] ) ) ) : ?>
														<option value="<?php echo $key; ?>"<?php echo ($key == $this->options[$i]['std']) ? ' selected="selected"' : ''; ?>><?php echo $val; ?></option>
													<?php else : ?>
														<option value="<?php echo $key; ?>"<?php echo get_option($this->options[$i]["id"]) == $key ? ' selected="selected"' : ''; ?>><?php echo $val; ?></option>
													<?php endif;
												endforeach;
											?>
										</select>
									</div><!--end v-field select-->
									<?php
								break;

								case "textarea":
									?>
									<?php if ( isset( $this->options[$i]["pro"] ) ) $pro = $this->options[$i]["pro"]; else $pro = false; ?>
									<div class="v-field textarea clear <?php if ( $pro == 'true' ) echo 'pro'; ?>">
										<div class="v-field-d"><span><?php echo $this->options[$i]["desc"]?></span></div>
										<label for="<?php echo esc_attr( $this->options[$i]["id"] ); ?>"><?php echo $this->options[$i]["name"]?></label>
										<textarea id="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" name="<?php echo esc_attr( $this->options[$i]["id"] ); ?>" <?php
											echo ( $this->options[$i]["options"] ? ' rows="' . $this->options[$i]["options"]["rows"] . '" cols="' . $this->options[$i]["options"]["cols"] . '"' : '' );
										?>><?php
											echo htmlspecialchars(
												'' != get_option($this->options[$i]['id']) ? get_option($this->options[$i]['id']) : $this->options[$i]['std'],
												ENT_QUOTES
											);
										?></textarea>
									</div><!--end vop-v-field textarea-->
									<?php
								break;
							endswitch;
						endfor;
						?>
					<div class="v-save-button submit">
						<input type="submit" value="<?php _e( 'Save changes', $this->domain ); ?>" name="save"/>
					</div><!--end v-save-button-->
				</div>
			</div>
			<div class="v-saveall-button submit">
				<input class="button-primary" type="submit" value="<?php esc_attr_e( 'Save all changes', $this->domain ); ?>" name="save" />
			</div>
		</form>

		<div class="v-reset-button submit">
			<form method="post" action="">
				<?php wp_nonce_field( 'reset-theme-options', 'reset-theme-options-nonce' ); ?>
				<input type="hidden" name="action" value="reset" />
				<input class="v-reset" type="submit" value="<?php esc_attr_e( 'Reset all options', $this->domain ); ?>" name="reset" />
			</form>
		</div>

		<script type="text/javascript">
			<?php
			for ($i = 0; $i < count($this->options); $i++) :
				if ($this->options[$i]['type'] == 'colorpicker') :
					?>
					jQuery("#<?php echo esc_js( $this->options[$i]["id"] ); ?>_colorpicker").farbtastic("#<?php echo esc_js( $this->options[$i]["id"] ); ?>");
					<?php
				endif;
			endfor;
			?>
			jQuery( '.colorpicker_container' ).hide();
			jQuery("div.v-field.pro input, div.v-field.pro select, div.v-field.pro textarea").attr("disabled", "disabled");
		</script>
	</div><!--end vop-body-->
</div><!--end v-options-->
<?php
		}

		function statsCode() {
			echo stripslashes(get_option($this->shortname.'_stats_code' ));
		}

	}
}
?>