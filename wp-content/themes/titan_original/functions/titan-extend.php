<?php
/*
----- Table of Contents

	1.  Load other functions
	2.  Set up theme specific variables
	3.  Image max width
	4.  Enqueue Client Files
	5.  Print header items
	6.  Register Sidebars
	7.  Main Menu Fallback
	8.  Navigation Function
	9.  Define theme options
	10. Theme option return functions
				I.    Logo Functions
				II.   Follow links
				III.  Homepage notice
				IV.   Sidebar Sidebox
				V.    Sidebar Adbox
				VI.   Footer Functions

*/

/*---------------------------------------------------------
	1. Load other functions
------------------------------------------------------------ */
locate_template( array( 'functions' . DIRECTORY_SEPARATOR . 'comments.php' ), true );
locate_template( array( 'functions' . DIRECTORY_SEPARATOR . 'ttf-admin.php' ), true );


if (!class_exists('Titan')) {
	class Titan extends TTFCore {

		/*---------------------------------------------------------
			2. Set up theme specific variables
		------------------------------------------------------------ */
		function Titan () {

			$this->themename = "Titan";
			$this->themeurl = "http://thethemefoundry.com/titan/";
			$this->shortname = "T";
			$this->domain = "titan";

			add_action( 'init', array(&$this, 'registerMenus' ));
			add_action( 'setup_theme_titan', array(&$this, 'setOptions' ) );

			add_action( 'wp_head', array( &$this, 'printHeaderItems' ) );
			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueueClientFiles' ) );

			parent::TTFCore();
		}

		/*---------------------------------------------------------
			3. Max Image width
		------------------------------------------------------------ */
		function addContentWidth() {
			global $content_width;
			if ( isset( $content_width ) ) {
				$content_width = 628;
			}

		}

		/*---------------------------------------------------------
			4. Enqueue Client Files
		------------------------------------------------------------ */
		function enqueueClientFiles() {
			global $wp_styles;

			if ( ! is_admin() ) {

				wp_enqueue_style(
					'titan-style',
					get_bloginfo( 'stylesheet_url' ),
					'',
					null
				);

				wp_enqueue_style(
					'titan-ie-style',
					get_template_directory_uri() . '/stylesheets/ie.css',
					array( 'titan-style' ),
					null
				);
				$wp_styles->add_data( 'titan-ie-style', 'conditional', 'lt IE 8' );

				if ( is_singular() ) {
					wp_enqueue_script( 'comment-reply' );
				}
			}
		}

		/*---------------------------------------------------------
			5. Print header items
		------------------------------------------------------------ */
		function printHeaderItems() {
			?>
			<!--[if lte IE 7]>
			<script type="text/javascript">
			sfHover=function(){var sfEls=document.getElementById("nav").getElementsByTagName("LI");for(var i=0;i<sfEls.length;i++){sfEls[i].onmouseover=function(){this.className+=" sfhover";}
			sfEls[i].onmouseout=function(){this.className=this.className.replace(new RegExp(" sfhover\\b"),"");}}}
			if (window.attachEvent)window.attachEvent("onload",sfHover);
			</script>
			<![endif]-->
			<?php
		}

		/*---------------------------------------------------------
			6. Register Sidebars
		------------------------------------------------------------ */
		function registerSidebars() {
			register_sidebar(array(
				'name' => __( 'Sidebar', 'titan' ),
				'id' => 'normal_sidebar',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h2 class="widgettitle">',
				'after_title' => '</h2>',
			));
		}

		/*---------------------------------------------------------
			7. Main Menu Fallback
		------------------------------------------------------------ */
		function main_menu_fallback() {
			?>
			<div id="navigation">
				<ul id="nav">
					<?php
						wp_list_pages( 'title_li=&number=9' );
					?>
				</ul>
			</div>
			<?php
			}

		/*---------------------------------------------------------
			8. Navigation Function
		------------------------------------------------------------ */
		function registerMenus() {
			register_nav_menu( 'nav-1', __( 'Top Navigation' ) );
		}

		/*---------------------------------------------------------
			9. Define theme options
		------------------------------------------------------------ */
		function setOptions() {

			/*
				OPTION TYPES:
				- checkbox: name, id, desc, std, type
				- radio: name, id, desc, std, type, options
				- text: name, id, desc, std, type
				- colorpicker: name, id, desc, std, type
				- select: name, id, desc, std, type, options
				- textarea: name, id, desc, std, type, options
			*/

			$this->options = array(
				array(
					"name" => __('Custom Logo Image <span>insert your custom logo image in the header</span>', 'titan'),
					"type" => "subhead"),

				array(
					"name" => __('Enable custom logo image', 'titan'),
					"id" => $this->shortname."_logo",
					"desc" => __('Check to use a custom logo in the header.', 'titan'),
					"std" => "false",
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __( 'Logo URL', 'titan' ),
					"id" => $this->shortname."_logo_img",
					"desc" => sprintf( __( 'Upload an image or enter an URL for your image.', 'titan' ), '<code>' . STYLESHEETPATH . '/images/</code>' ),
					"std" => '',
					"pro" => 'true',
					"upload" => true,
					"class" => "logo-image-input",
					"type" => "upload"),

				array(
					"name" => __('Logo image <code>&lt;alt&gt;</code> tag', 'titan'),
					"id" => $this->shortname."_logo_img_alt",
					"desc" => __('Specify the <code>&lt;alt&gt;</code> tag for your logo image.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Display tagline', 'titan'),
					"id" => $this->shortname."_tagline",
					"desc" => __('Check to show your tagline below your logo.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __( 'Follow Icons <span>control the follow icons in the top right of your header</span>', 'titan' ),
					"type" => "subhead"),

				array(
					"name" => __( 'Enable Twitter', 'titan' ),
					"id" => $this->shortname."_twitter_toggle",
					"desc" => __( 'Hip to Twitter? Check this box.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __( 'Enable Facebook', 'titan' ),
					"id" => $this->shortname."_facebook_toggle",
					"desc" => __( 'Check this box to show a link to your Facebook page.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __( 'Enable Flickr', 'titan' ),
					"id" => $this->shortname."_flickr_toggle",
					"desc" => __( 'Check this box to show a link to Flickr.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __( 'Enable email', 'titan' ),
					"id" => $this->shortname."_email_toggle",
					"desc" => __( 'Check this box to show a link to email updates.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __( 'Disable all', 'titan' ),
					"id" => $this->shortname."_follow_disable",
					"desc" => __( 'Check this box to hide all follow icons (including RSS). This option overrides any other settings.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __( 'Twitter link', 'titan' ),
					"id" => $this->shortname."_follow_twitter",
					"desc" => __( 'Enter your twitter link here.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __( 'Facebook link', 'titan' ),
					"id" => $this->shortname."_follow_facebook",
					"desc" => __( 'Enter your Facebook link.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __( 'Flickr link', 'titan' ),
					"id" => $this->shortname."_follow_flickr",
					"desc" => __( 'Enter your Flickr link.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __( 'Email link', 'titan' ),
					"id" => $this->shortname."_feed_email",
					"desc" => __( 'Enter your email updates link.', 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Homepage Notice <span>display a notice on your homepage</span>', 'titan'),
					"type" => "subhead"),

				array(
					"name" => __('Enable homepage notice', 'titan'),
					"id" => $this->shortname."_custom_notice",
					"desc" => __('Check this box to use a custom notice on the home page.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __('Custom notice', 'titan'),
					"id" => $this->shortname."_notice_content",
					"desc" =>	 __('The content of your custom notice.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "textarea",
					"options" => array(
						"rows" => "3",
						"cols" => "50") ),

				array(
					"name" => __('Sidebar Sidebox <span>customize your sidebox</span>', 'titan'),
					"type" => "subhead"),

				array(
					"name" => __('Disable sidebox', 'titan'),
					"id" => $this->shortname."_sidebox",
					"desc" => __('Check this box to disable the sidebar sidebox.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __('Custom code', 'titan'),
					"id" => $this->shortname."_sidebox_custom_code",
					"desc" => __('Check this box to use custom code for the sidebox.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __('Custom code content', 'titan'),
					"id" => $this->shortname."_sidebox_custom_code_content",
					"desc" => __('Must use properly formatted XHTML/HTML.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "textarea",
					"options" => array(
						"rows" => "7",
						"cols" => "70") ),

				array(
					"name" => __('Sidebar Adbox <span>control ads in your sidebar</span>', 'titan'),
					"type" => "subhead"),

				array(
					"name" => __('Enable adbox', 'titan'),
					"id" => $this->shortname."_adbox",
					"desc" => __('Check this box to enable the sidebar adbox.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "checkbox"),

				array(
					"name" => __('Ad 1 file name', 'titan'),
					"id" => $this->shortname."_adurl_1",
					"desc" => __( sprintf( __( 'Upload your image to the %s directory.' ), '<code>' . STYLESHEETPATH . '/images/sidebar/</code>' ), 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Ad 1 link', 'titan'),
					"id" => $this->shortname."_adlink_1",
					"desc" => __('Link for the first ad', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Ad 1 alt tag', 'titan'),
					"id" => $this->shortname."_adalt_1",
					"desc" => __('Alt tag for the first ad', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Ad 2 file name', 'titan'),
					"id" => $this->shortname."_adurl_2",
					"desc" => __( sprintf( __( 'Upload your image to the %s directory.' ), '<code>' . STYLESHEETPATH . '/images/sidebar/</code>' ), 'titan' ),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Ad 2 link', 'titan'),
					"id" => $this->shortname."_adlink_2",
					"desc" => __('Link for the second ad', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Ad 2 alt tag', 'titan'),
					"id" => $this->shortname."_adalt_2",
					"desc" => __('Alt tag for the second ad', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "text"),

				array(
					"name" => __('Footer <span>customize your footer</span>', 'titan'),
					"type" => "subhead"),

				array(
					"name" => __('About', 'titan'),
					"id" => $this->shortname."_about",
					"desc" => __('Something about you or your business.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "textarea",
					"options" => array(
						"rows" => "6",
						"cols" => "80") ),

				array(
					"name" => __('Flickr link', 'titan'),
					"id" => $this->shortname."_flickr",
					"desc" => __('Create a Flickr badge. At the end of the process extract the URL and paste here.', 'titan'),
					"std" => '',
					"pro" => 'true',
					"type" => "textarea",
					"options" => array(
						"rows" => "2",
						"cols" => "80") ),

				array(
					"name" => __('Copyright notice', 'titan'),
					"id" => $this->shortname."_copyright_name",
					"desc" => __('Your name or the name of your business.', 'titan'),
					"std" => __('Your Name Here', 'titan'),
					"type" => "text"),

				array(
					"name" => __('Stats code', 'titan'),
					"id" => $this->shortname."_stats_code",
					"desc" => __( sprintf( __( 'If you would like to use Google Analytics or any other tracking script in your footer just paste it here. The script will be inserted before the closing %s tag.' ), '<code>&#60;/body&#62;</code>' ), 'titan' ),
					"std" => '',
					"type" => "textarea",
					"options" => array(
						"rows" => "5",
						"cols" => "40") ),

			);
		}

		/*---------------------------------------------------------
			10. Theme option return functions
		------------------------------------------------------------ */

		/*---------------------------------------------------------
			I. Logo Functions
		------------------------------------------------------------ */

		/*---------------------------------------------------------
			II. Follow links
		------------------------------------------------------------ */

		/*---------------------------------------------------------
			III. Homepage Notice
		------------------------------------------------------------ */

		/*---------------------------------------------------------
			IV. Sidebar Sidebox
		------------------------------------------------------------ */

		/*---------------------------------------------------------
			V. Sidebar Adbox
		------------------------------------------------------------ */

		/* FOOTER FUNCTIONS */
		/*---------------------------------------------------------
			VI. Footer Functions
		------------------------------------------------------------ */

		function copyrightName() {
			return stripslashes( wp_filter_post_kses(get_option($this->shortname.'_copyright_name')) );
		}
	}
}

/* SETTING EVERYTHING IN MOTION */
function load_titan_pro_theme() {
	$GLOBALS['titan'] = new Titan;
}

add_action( 'after_setup_theme', 'load_titan_pro_theme' );