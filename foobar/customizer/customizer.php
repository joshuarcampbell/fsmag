<?php
/**
 * Editorial Mag Theme Customizer
 *
 * @package Editorial_Mag
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fsmag_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	$wp_customize->add_panel('fsmag_general_settings', array(
	  'capabitity' => 'edit_theme_options',
	  'priority' => 3,
	  'title' => esc_html__('General Settings', 'fsmag')
	));

	$wp_customize->get_section('title_tagline' )->panel = 'fsmag_general_settings';
	$wp_customize->get_section('header_image' )->panel = 'fsmag_general_settings';
	$wp_customize->get_section('background_image' )->panel = 'fsmag_general_settings';


/*sorting core and widget for ease of theme use*/
$wp_customize->get_section( 'static_front_page' )->priority = 2;

/**
 * Important Link
*/
$wp_customize->add_section( 'fsmag_implink_section', array(
  'title'       => esc_html__( 'Important Links', 'fsmag' ),
  'priority'      => 2
) );

    $wp_customize->add_setting( 'fsmag_imp_links', array(
      'sanitize_callback' => 'fsmag_text_sanitize'
    ));

    $wp_customize->add_control( new fsmag_theme_Info_Text( $wp_customize,'fsmag_imp_links', array(
        'settings'    => 'fsmag_imp_links',
        'section'     => 'fsmag_implink_section',
        'description' => '<a class="implink" href="http://docs.sparklewpthemes.com/fsmag/" target="_blank">'.esc_html__('Documentation', 'fsmag').'</a><a class="implink" href="http://demo.sparklewpthemes.com/fsmag/demos/" target="_blank">'.esc_html__('Live Demo', 'fsmag').'</a><a class="implink" href="https://www.sparklewpthemes.com/support/" target="_blank">'.esc_html__('Support Forum', 'fsmag').'</a><a class="implink" href="https://www.facebook.com/foobar" target="_blank">'.esc_html__('Like Us in Facebook', 'fsmag').'</a>',
      )
    ));

/**
 * Themes Color Settings
*/	
	$wp_customize->add_panel('fsmag_color_options', array(
		'priority' => 4,
		'title' => esc_html__('Themes Colors Settings', 'fsmag'),
		'description'=> esc_html__('Change the Colors from here as you want', 'fsmag'),
	));

    $wp_customize->get_section('colors' )->panel = 'fsmag_color_options';

   
   /**
    * Category Color Options   
    */
	$wp_customize->add_section('fsmag_category_color_setting', array(
		'title' => esc_html__('Category Color Settings', 'fsmag'),
		'panel' => 'fsmag_color_options'
	));

    $i = 1;
    $args = array(
       'orderby' => 'id',
       'hide_empty' => 0
    );

    $categories = get_categories( $args );

    $wp_category_list = array();

    foreach ($categories as $category_list ) {

        $wp_category_list[$category_list->cat_ID] = $category_list->cat_name;

        $wp_customize->add_setting('fsmag_category_color_'.get_cat_id( $wp_category_list[ $category_list->cat_ID ] ), array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'fsmag_color_option_hex_sanitize',
			'sanitize_js_callback' => 'fsmag_color_escaping_option_sanitize'  // done
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fsmag_category_color_'.get_cat_id( $wp_category_list[ $category_list->cat_ID ] ), array(
			'label' => sprintf( '%1$s', $wp_category_list[ $category_list->cat_ID ] ),
			'section' => 'fsmag_category_color_setting',
			'settings' => 'fsmag_category_color_'.get_cat_id( $wp_category_list[ $category_list->cat_ID ] ),
			'priority' => $i
        )));

        $i++;
    }

/**
 * Breaking News Section
*/
	$wp_customize->add_section('fsmag_breaking_news_settings', array(
		'priority' => 6,
		'title' => esc_html__('Breaking News Settings', 'fsmag'),
	));

		$wp_customize->add_setting('fsmag_breaking_news_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'fsmag_radio_enable_sanitize', // done
		));

		$wp_customize->add_control('fsmag_breaking_news_section', array(
		    'type' => 'radio',
		    'label' => esc_html__('Breaking News Section', 'fsmag'),
		    'description' => esc_html__('Choose the option as you want', 'fsmag'),
		    'section' => 'fsmag_breaking_news_settings',
		    'setting' => 'fsmag_breaking_news_section',
		    'choices' => array(
		    	'enable' => esc_html__('Enable', 'fsmag'),
		        'disable' => esc_html__('Disable', 'fsmag'),
		)));

		/**
		 * Breaking News Category 
		*/
		$wp_customize->add_setting( 'fsmag_breaking_news_team_id', array(
		    'default' => 1,
		    'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( new fsmag_Category_Dropdown( $wp_customize, 'fsmag_breaking_news_team_id', array(
		    'label' => esc_html__( 'Select Breaking News Category', 'fsmag' ),
		    'section' => 'fsmag_breaking_news_settings'        
		) ) );


/**
 * Home 1 - Full Width Section
*/
$fsmag_home1_section = $wp_customize->get_section( 'sidebar-widgets-home-1' );
if ( ! empty( $fsmag_home1_section ) ) {
    $fsmag_home1_section->panel = '';
    $fsmag_home1_section->title = esc_html__( 'Home 1 - Full Width Section', 'fsmag' );
    $fsmag_home1_section->priority = 6;
}

/**
 * Home 2 - 3/1 Main Block Section
*/
$fsmag_home2_section = $wp_customize->get_section( 'sidebar-widgets-home-2' );
if ( ! empty( $fsmag_home2_section ) ) {
    $fsmag_home2_section->panel = '';
    $fsmag_home2_section->title = esc_html__( 'Home 2 - 3/1 Main Block Section', 'fsmag' );
    $fsmag_home2_section->priority = 6;
}

/**
 * Home 3 - Full Width Section
*/
$fsmag_home3_section = $wp_customize->get_section( 'sidebar-widgets-home-3' );
if ( ! empty( $fsmag_home3_section ) ) {
    $fsmag_home3_section->panel = '';
    $fsmag_home3_section->title = esc_html__( 'Home 3 - Full Width Section', 'fsmag' );
    $fsmag_home3_section->priority = 6;
}

/**
 * Design Layout Setting
*/
	$wp_customize->add_panel('fsmag_design_options', array(
	   'description' => esc_html__('Change the Design Settings from here as you want', 'fsmag'),
	   'priority' => 7,
	   'title' => esc_html__('Design Layout Settings', 'fsmag')
	));
	    
		$imagepath =  get_template_directory_uri() . '/assets/images/';

		/**
		 * Layout for pages only
		*/
		$wp_customize->add_section('fsmag_layout_page_setting', array(
			'title' => esc_html__('Layout for Pages Only', 'fsmag'),
			'panel'=> 'fsmag_design_options'
		));

	   	$wp_customize->add_setting('fsmag_page_layout', array(
	   		'default' => 'rightsidebar',
	   		'sanitize_callback' => 'fsmag_layout_sanitize'  //done
	   	));

	   	$wp_customize->add_control( new fsmag_Image_Radio_Control( $wp_customize, 'fsmag_page_layout', array(
	   		'type' => 'radio',
	   		'label' => esc_html__('Select Layout for Pages. This Layout will be Reflected in all Pages Unless Unique Layout is set For Specific Page', 'fsmag'),
	   		'section' => 'fsmag_layout_page_setting',
	   		'settings' => 'fsmag_page_layout',
	   		'choices' => array( 
	                'leftsidebar'  => $imagepath . 'left-sidebar.png',  
	                'rightsidebar' => $imagepath . 'right-sidebar.png',
	                'nosidebar'    => $imagepath . 'no-sidebar.png',
	            )
	   	) ) );


		/**
		* Category Page Settings
		*/
		$wp_customize->add_section('fsmag_archive_page_layout_setting', array(
			'title' => esc_html__('Layout for Archive Page Only', 'fsmag'),
			'panel'=> 'fsmag_design_options'
		));

		    $wp_customize->add_setting('fsmag_archive_page_layout', array(
				'default' => 'rightsidebar',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'fsmag_layout_sanitize'  //done
		    ));

		    $wp_customize->add_control( new fsmag_Image_Radio_Control( $wp_customize, 'fsmag_archive_page_layout', array(
				'type' => 'radio',
				'label' => esc_html__('Select Category Page Layout', 'fsmag'),
				'section' => 'fsmag_archive_page_layout_setting',
				'settings' => 'fsmag_archive_page_layout',
				'choices' => array( 
		            'leftsidebar'   => $imagepath . 'left-sidebar.png',  
		            'rightsidebar'  => $imagepath . 'right-sidebar.png',
		            'nosidebar'     => $imagepath . 'no-sidebar.png',
		        )
		    )));

		/**
		 * Single Posts Page Settings
		*/
		$wp_customize->add_section('fsmag_single_posts_layout_setting', array(
			'title' => esc_html__('Layout for Single Posts Only', 'fsmag'),
			'panel'=> 'fsmag_design_options'
		));

		   	$wp_customize->add_setting('fsmag_single_posts_layout', array(
		   		'default' => 'rightsidebar',
		   		'sanitize_callback' => 'fsmag_layout_sanitize'  //done
		   	));

		   	$wp_customize->add_control(new fsmag_Image_Radio_Control($wp_customize, 'fsmag_single_posts_layout', array(
		   		'type' => 'radio',
		   		'label' => esc_html__('Select Layout for Single Posts', 'fsmag'),
		   		'section' => 'fsmag_single_posts_layout_setting',
		   		'settings' => 'fsmag_single_posts_layout',
		   		'choices' => array( 
						'leftsidebar'  => $imagepath . 'left-sidebar.png',  
						'rightsidebar' => $imagepath . 'right-sidebar.png',
						'nosidebar'    => $imagepath . 'no-sidebar.png',
		            )
		   	)));

/**
 * Author News Section
*/
	$wp_customize->add_section('fsmag_author_settings', array(
		'priority' => 8,
		'title' => esc_html__('Single Post Author Settings', 'fsmag'),
	));

		$wp_customize->add_setting('fsmag_author_section', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'fsmag_radio_enable_sanitize', // done
		));

		$wp_customize->add_control('fsmag_author_section', array(
		    'type' => 'radio',
		    'label' => esc_html__('Single Page Author Section', 'fsmag'),
		    'description' => esc_html__('Choose the option as you want', 'fsmag'),
		    'section' => 'fsmag_author_settings',
		    'setting' => 'fsmag_author_section',
		    'choices' => array(
		    	'enable' => esc_html__('Enable', 'fsmag'),
		        'disable' => esc_html__('Disable', 'fsmag'),
		)));

		$wp_customize->add_setting('fsmag_author_title', array(
			'default' => '',
			'sanitize_callback' => 'fsmag_text_sanitize'  //done
		));

		$wp_customize->add_control('fsmag_author_title', array(
			'type' => 'text',
			'label' => esc_html__('Enter Author Reporter Title', 'fsmag'),
			'section' => 'fsmag_author_settings',
			'settings' => 'fsmag_author_title'
		) ); 

/**
 * Social Media Link Options
*/
	$wp_customize->add_section('fsmag_social_link_activate_settings', array(
		'priority' => 8,
		'title' => esc_html__('Social Media Links Settings', 'fsmag'),
	));

		$wp_customize->add_setting('fsmag_social_media_link', array(
		    'default' => 'enable',
		    'sanitize_callback' => 'fsmag_radio_enable_sanitize', // done
		));

		$wp_customize->add_control('fsmag_social_media_link', array(
		    'type' => 'radio',
		    'label' => esc_html__('Footer Sociala Media Link', 'fsmag'),
		    'description' => esc_html__('Choose the option as you want', 'fsmag'),
		    'section' => 'fsmag_social_link_activate_settings',
		    'setting' => 'fsmag_social_media_link',
		    'choices' => array(
		    	'enable' => esc_html__('Enable', 'fsmag'),
		        'disable' => esc_html__('Disable', 'fsmag'),
		)));

	    $fsmag_social_links = array(
	          'fsmag_social_facebook' => array(
	          'id' => 'fsmag_social_facebook',
	          'title' => esc_html__('Facebook', 'fsmag'),
	          'default' => ''
	        ),
	          'fsmag_social_twitter' => array(
	          'id' => 'fsmag_social_twitter',
	          'title' => esc_html__('Twitter', 'fsmag'),
	          'default' => ''
	        ),
	          'fsmag_social_linkedin' => array(
	          'id' => 'fsmag_social_linkedin',
	          'title' => esc_html__('Linkendin', 'fsmag'),
	          'default' => ''
	        ),
	          'fsmag_social_youtube' => array(
	          'id' => 'fsmag_social_youtube',
	          'title' => esc_html__('YouTube', 'fsmag'),
	          'default' => ''
	        ),
	          'fsmag_social_instagram' => array(
	          'id' => 'fsmag_social_instagram',
	          'title' => esc_html__('Instagram', 'fsmag'),
	          'default' => ''
	        ),
	    );

	    $i = 20;

	    foreach($fsmag_social_links as $fsmag_social_link) {

	        $wp_customize->add_setting($fsmag_social_link['id'], array(
				'default' => $fsmag_social_link['default'],
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'  // done
	        ));

	        $wp_customize->add_control($fsmag_social_link['id'], array(
				'label' => $fsmag_social_link['title'],
				'section'=> 'fsmag_social_link_activate_settings',
				'settings'=> $fsmag_social_link['id'],
				'priority' => $i
	        ));

	        $i++;

	    }


/**
 * Footer Section      
*/
    $wp_customize->add_panel('fsmag_footer_settings', array(
      'priority' => 9,
      'title' => esc_html__('Footer Settings', 'fsmag'),
    ));
   

		/**
		* Footer Area One Settings
		*/
		$wp_customize->add_section('fsmag_footer_buttom_area_settings', array(
			'title' => esc_html__('Footer Area Settings', 'fsmag'),
			'panel'=> 'fsmag_footer_settings'
		));
    

		$wp_customize->add_setting('fsmag_footer_buttom_copyright_setting', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'fsmag_text_sanitize'  //done
		));

		$wp_customize->add_control('fsmag_footer_buttom_copyright_setting', array(
			'type' => 'textarea',
			'label' => esc_html__('Footer Content (Copyright Text)', 'fsmag'),
			'section' => 'fsmag_footer_buttom_area_settings',
			'settings' => 'fsmag_footer_buttom_copyright_setting'
		) );  



	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'fsmag_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'fsmag_customize_partial_blogdescription',
		) );
	}


	/**
     * Text fields sanitization
    */
    function fsmag_text_sanitize( $input ) {
        return wp_kses_post( force_balance_tags( $input ) );
    }

    /**
     * Category Colors Sanitization
    */
	function fsmag_color_option_hex_sanitize($color) {
	  if ($unhashed = sanitize_hex_color_no_hash($color))
	     return '#' . $unhashed;
	  return $color;
	}

	function fsmag_color_escaping_option_sanitize($input) {
	  $input = esc_attr($input);
	  return $input;
	}

	/**
	 * Enable/Disable Sanitization
	*/
	function fsmag_radio_enable_sanitize($input) {
	    $valid_keys = array(
	     'enable' => esc_html__('Enable', 'fsmag'),
	     'disable' => esc_html__('Disable', 'fsmag'),
	    );
	    if ( array_key_exists( $input, $valid_keys ) ) {
	      return $input;
	    } else {
	      return '';
	    }
	}

	/**
	 * Page Layout Sanitization
	*/
	function fsmag_layout_sanitize($input) {
		$imagepath =  get_template_directory_uri() . '/assets/images/';

		$valid_keys = array( 
			'leftsidebar'  => $imagepath . 'left-sidebar.png',  
            'rightsidebar' => $imagepath . 'right-sidebar.png',
            'nosidebar'    => $imagepath . 'no-sidebar.png',
		);
		if ( array_key_exists( $input, $valid_keys ) ) {
			return $input;
		} else {
			return '';
		}
	}

}
add_action( 'customize_register', 'fsmag_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function fsmag_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function fsmag_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fsmag_customize_preview_js() {
	wp_enqueue_script( 'fsmag-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'fsmag_customize_preview_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fsmag_customize_controls_scripts() {
    wp_enqueue_script( 'fsmag-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array( 'customize-preview' ), '1.1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'fsmag_customize_controls_scripts' );