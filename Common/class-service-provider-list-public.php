<?php
/**
 * The public functionality
 */
class Service_Provider_List_Public {
	private $plugin_name;
	private $version;
	private $service_provider_list_shortcode_atts;
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name                               		= $plugin_name;
		$this->version                                   		= $version;
		$this->service_provider_list_shortcode_atts          	= array();
		$this->service_provider_list_shortcode_atts_defaults 	= array(
			'id'         	=> '',
			'service_type'  => '',
			'wrap_class' 	=> '',
			'order'      	=> 'ASC',
			'image_size' 	=> 'full',
		);
		$this->service_member_register_shortcodes();
	}

	/**
	 * Register the stylesheets.
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 */

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/service-provider-list-public.css',
			array(),
			$this->version,
			'all'
		);

		wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'js/service-provider-list-front.js',
				array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ),
				$this->version,
				false
			);

		/**
		 * Check to see if we should load the external stylesheet
		 *
		 */
		if ( 'yes' === get_option( '_service_listing_write_external_css' ) ) {
			wp_register_style( 'service-list-custom-css', get_stylesheet_directory_uri() . '/service-provider-list-custom.css' );
			wp_enqueue_style( 'service-list-custom-css' );
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 */
	}

	/**
	 * Initialize service member custom post type and taxonomies.
	 */
	public function service_member_init() {

		global $wp_version;

		// Get user options for post type labels.
		if ( ! get_option( '_service_listing_custom_slug' ) ) {
			$slug = get_option( '_service_listing_default_slug' );
		} else {
			$slug = get_option( '_service_listing_custom_slug' );
		}
		if ( ! get_option( '_service_listing_custom_name_singular' ) ) {
			$singular_name = get_option( '_service_listing_default_name_singular' );
		} else {
			$singular_name = get_option( '_service_listing_custom_name_singular' );
		}
		if ( ! get_option( '_service_listing_custom_name_plural' ) ) {
			$name = get_option( '_service_listing_default_name_plural' );
		} else {
			$name = get_option( '_service_listing_custom_name_plural' );
		}

		// TODO Instead of using "Service Provider" all through here...try to use the custom slug set in options.
		// Set up post type options.
		$labels = array(
			'name'                  => $name,
			'singular_name'         => $singular_name,
			'add_new'               => _x( 'Add New Member', 'service member', $this->plugin_name ),
			'add_new_item'          => __( 'Add New Service Provider Member', $this->plugin_name ),
			'edit_item'             => __( 'Edit Service Provider Member', $this->plugin_name ),
			'new_item'              => __( 'New Service Provider Member', $this->plugin_name ),
			'view_item'             => __( 'View Service Provider Member', $this->plugin_name ),
			'search_items'          => __( 'Search Service Provider Members', $this->plugin_name ),
			'exclude_from_search'   => true,
			'not_found'             => __( 'No service members found', $this->plugin_name ),
			'not_found_in_trash'    => __( 'No service members found in Trash', $this->plugin_name ),
			'parent_item_colon'     => '',
			'all_items'             => __( 'Service Provider List', $this->plugin_name ),
			'menu_name'             => __( 'Service Provider List', $this->plugin_name ),
			'featured_image'        => __( 'Service Provider Photo', $this->plugin_name ),
			'set_featured_image'    => __( 'Set Service Provider Photo', $this->plugin_name ),
			'remove_featured_image' => __( 'Remove Service Provider Photo', $this->plugin_name ),
			'use_featured_image'    => __( 'Use Service Provider Photo', $this->plugin_name ),
		);

		/**
		 * 
		 * Return false on this filter and flush your permalinks to disable the service-members archive page.
		 * 
		 * @param $enabled bool Whether or not the archive page is enabled. Default is true.
		 */
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'page',
			'has_archive'        => apply_filters( 'rcode_enable_service_member_archive', true ),
			'hierarchical'       => false,
			'menu_position'      => 100,
			'rewrite'            => array(
				'slug'       => $slug,
				'with_front' => false,
			),
			'supports'           => array( 'title', 'thumbnail', 'excerpt' ),
			'menu_icon'          => 'dashicons-id-alt',
		);

		// Register post type.
		register_post_type( 'service-member', $args );

		$service_type_labels = array(
			'name'              => _x( 'Service Type', 'taxonomy general name', $this->plugin_name ),
			'singular_name'     => _x( 'Service Type', 'taxonomy singular name', $this->plugin_name ),
			'search_items'      => __( 'Search Service Type', $this->plugin_name ),
			'all_items'         => __( 'All Service Type', $this->plugin_name ),
			'parent_item'       => __( 'Parent Service Type', $this->plugin_name ),
			'parent_item_colon' => __( 'Parent Service Type:', $this->plugin_name ),
			'edit_item'         => __( 'Edit Service Type', $this->plugin_name ),
			'update_item'       => __( 'Update Service Type', $this->plugin_name ),
			'add_new_item'      => __( 'Add New Service Type', $this->plugin_name ),
			'new_item_name'     => __( 'New Service Type', $this->plugin_name ),
		);
		register_taxonomy(
			'service-member-service_type', array( 'service-member' ), array(
				'hierarchical' => true,
				'labels'       => $service_type_labels, /* NOTICE: Here is where the $labels variable is used */
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => array( 'slug' => 'service_type' ),
			)
		);

	}

	/**
	 * Maybe flush rewrite rules
	 */
	public function maybe_flush_rewrite_rules() {

		if ( get_option( '_service_listing_flush_rewrite_rules_flag' ) ) {

			// Flush the rewrite rules.
			flush_rewrite_rules();

			// Remove our flag.
			delete_option( '_service_listing_flush_rewrite_rules_flag' );

		}

	}


	/**
	 * Register plugin shortcode(s)
	 */
	public function service_member_register_shortcodes() {

		add_shortcode( 'service-provider-list', array( $this, 'service_member_service_provider_list_shortcode_callback' ) );

	}

	/**
	 * Callback for [service-provider-list]
	 */
	public function service_member_service_provider_list_shortcode_callback( $atts = array() ) {

		global $rcode_sc_output;

		$this->service_provider_list_shortcode_atts = shortcode_atts( $this->service_provider_list_shortcode_atts_defaults, $atts, 'service-provider-list' );
		include 'front-files/service-provider-list-shortcode-display.php';
		return $rcode_sc_output;

	}

}
