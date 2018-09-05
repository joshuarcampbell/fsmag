<?php
/**
 * Main Custom admin functions area
 *
 * @since SparklewpThemes
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
require fsmag_file_directory('foobar/functions.php');

/**
 * Custom functions that act independently of the theme header.
*/
require fsmag_file_directory('foobar/core/custom-header.php');

/**
 * Custom functions that act independently of the theme templates.
*/
require fsmag_file_directory('foobar/core/template-functions.php');

/**
 * Custom template tags for this theme.
*/
require fsmag_file_directory('foobar/core/template-tags.php');

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
   require fsmag_file_directory('foobar/core/jetpack.php');
}

/**
 * Customizer additions.
*/
require fsmag_file_directory('foobar/customizer/customizer.php');

/**
 * Load widget compatibility field file.
*/
require fsmag_file_directory('foobar/widget-fields.php');

/**
 * Load widget compatibility tgm file.
*/
require fsmag_file_directory('foobar/tgm.php');

/**
 * Load theme about page
*/
require fsmag_file_directory('foobar/admin/about-theme/fsmag-about.php');


/**
 * Load woocommerce hooks file.
*/
if ( fsmag_is_woocommerce_activated() ) {
	
	require fsmag_file_directory('foobar/hooks/woocommerce.php');
}

/**
 * Load in customizer upgrade to pro
*/
require fsmag_file_directory('foobar/customizer/customizer-pro/class-customize.php');


