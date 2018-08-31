<?php
/**
 * Main Custom admin functions area
 *
 * @since fsthemeswpThemes
 *
 * @param Editorial_Mag
 *
*/
if( !function_exists('fsmag_file_directory') ){

    function fsmag_file_directory( $file_path ){
        if( file_exists( trailingslashit( get_stylesheet_directory() ) . $file_path) ) {
            return trailingslashit( get_stylesheet_directory() ) . $file_path;
        }
        else{
            return trailingslashit( get_template_directory() ) . $file_path;
        }
    }
}


/**
 * Load Custom Admin functions that act independently of the theme functions.
*/
require fsmag_file_directory('fsthemes/functions.php');

/**
 * Custom functions that act independently of the theme header.
*/
require fsmag_file_directory('fsthemes/core/custom-header.php');

/**
 * Custom functions that act independently of the theme templates.
*/
require fsmag_file_directory('fsthemes/core/template-functions.php');

/**
 * Custom template tags for this theme.
*/
require fsmag_file_directory('fsthemes/core/template-tags.php');

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
   require fsmag_file_directory('fsthemes/core/jetpack.php');
}

/**
 * Customizer additions.
*/
require fsmag_file_directory('fsthemes/customizer/customizer.php');

/**
 * Load widget compatibility field file.
*/
require fsmag_file_directory('fsthemes/widget-fields.php');

/**
 * Load widget compatibility tgm file.
*/
require fsmag_file_directory('fsthemes/tgm.php');

/**
 * Load theme about page
*/
require fsmag_file_directory('fsthemes/admin/about-theme/fsmag-about.php');


/**
 * Load woocommerce hooks file.
*/
if ( fsmag_is_woocommerce_activated() ) {
	
	require fsmag_file_directory('fsthemes/hooks/woocommerce.php');
}

/**
 * Load in customizer upgrade to pro
*/
require fsmag_file_directory('fsthemes/customizer/customizer-pro/class-customize.php');


