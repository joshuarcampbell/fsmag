<?php
/**
 * Plugin recommendation.
 *
 * @package Editorial_Mag
 */

// Load TGM library.
require_once trailingslashit( get_template_directory() ) . 'sparklethemes/tgm/class-tgm-plugin-activation.php';

if ( ! function_exists( 'fsmag_register_recommended_plugins' ) ) :

	/**
	 * Register recommended plugins.
	 *
	 * @since 1.0.0
	 */
	function fsmag_register_recommended_plugins() {

		$plugins = array(						
            array(
				'name' => esc_html__( 'Share Buttons by AddThis', 'fsmag' ),
				'slug' => 'addthis',
				'required' => false,
            ),
            array(
				'name' => esc_html__( 'Social Media Share Buttons | MashShare', 'fsmag' ),
				'slug' => 'mashsharer',
				'required' => false,
            ),
            array(
				'name' => esc_html__( 'Contact Form 7', 'fsmag' ),
				'slug' => 'contact-form-7',
				'required' => false,
            ),
            array(
				'name' => esc_html__( 'Regenerate Thumbnails', 'fsmag' ),
				'slug' => 'regenerate-thumbnails',
				'required' => false,
            ),
            array(
            	'name'     => esc_html__( 'WooCommerce', 'fsmag' ),
            	'slug'     => 'woocommerce',
            	'required' => false,
            ),
		);

		$config = array();

		tgmpa( $plugins, $config );

	}

endif;

add_action( 'tgmpa_register', 'fsmag_register_recommended_plugins' );
