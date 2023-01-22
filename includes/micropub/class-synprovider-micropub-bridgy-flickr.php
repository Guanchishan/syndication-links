<?php

/**
 * Flickr Micropub Class
 */

class SynProvider_Micropub_Bridgy_Flickr extends SynProvider_Micropub {
	use Bridgy_Config {
		register_setting as bridgy_register_setting;
		admin_init as bridgy_admin_init;
	}
	/**
	 * Constructor
	 *
	 * The default version of this just sets the parameters
	 *
	 * @param array $args Array of Arguments
	 */
	public function __construct( $args = array() ) {
		$this->name     = __( 'Flickr via Bridgy', 'syndication-links' );
		$this->uid      = 'micropub-flickr-bridgy';
		$this->endpoint = 'https://brid.gy/micropub';

		if ( ! array_key_exists( 'token', $args ) ) {
			$this->token = get_option( 'bridgy_flickr_token' );
		}

		$option = get_option( 'syndication_provider_enable' );
		$enable = is_array( $option ) ? in_array( $this->uid, $option ) : false;

		if ( $enable ) {
			add_action( 'admin_init', array( $this, 'admin_init' ), 12 );
		}

		parent::__construct( $args );
		$this->register_setting();
	}

	public function register_setting() {
		$this->bridgy_register_setting();
		register_setting(
			'syndication_providers',
			'bridgy_flickr_token',
			array(
				'type'         => 'string',
				'description'  => 'Bridgy Flickr Micropub Token',
				'show_in_rest' => false,
				'default'      => '',
			)
		);
	}

	public function admin_init() {
		$this->bridgy_admin_init();
		add_settings_field(
			'bridgy_flickr_token',
			__( 'Micropub Token to Enable Bridgy Flickr Publish', 'syndication-links' ),
			array(
				'Syn_Config',
				'text_callback',
			),
			'syndication_provider_options',
			'bridgy_options',
			array(
				'name' => 'bridgy_flickr_token',
			)
		);
	}

	/**
	 * Convert post to Microformats for Micropub
	 *
	 * @param int|WP_Post $post WordPress Post
	 * @return array|false Microformats
	 */
	public static function post_to_mf2( $post ) {
		$mf2 = parent::post_to_mf2( $post );

		return $mf2;
	}
}
