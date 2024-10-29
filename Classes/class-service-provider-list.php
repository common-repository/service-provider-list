<?php
/**
 * The file that defines the core plugin class
 **/

class Service_Provider_List {
	protected $loader;
	protected $plugin_name;
	protected $version;
	public function __construct() {

		$this->plugin_name = 'service-provider-list';
		$this->version     = '1.0.0';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {

		/**
		 * General core functions available everywhere.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Classes/rcode-core-functions.php';

		/**
		 * Templating functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Classes/rcode-template-functions.php';

		/**
		 * Templating hooks.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Classes/rcode-template-hooks.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Classes/class-service-provider-list-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Classes/class-service-provider-list-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Admin/class-service-provider-list-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Common/class-service-provider-list-public.php';

		$this->loader = new Service_Provider_List_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 */
	private function set_locale() {

		$plugin_i18n = new Service_Provider_List_I18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Service_Provider_List_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_menu' );

		// Maybe flush rewrite rules after service_member_init.
		$this->loader->add_action( 'wp_ajax_rcode_flush_rewrite_rules', $plugin_admin, 'ajax_flush_rewrite_rules', 20 );

		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'add_featured_image_support', 10 );
		$this->loader->add_filter( 'default_hidden_meta_boxes', $plugin_admin, 'hide_meta_boxes', 10, 2 );
		$this->loader->add_filter( 'enter_title_here', $plugin_admin, 'service_member_change_title' );
		$this->loader->add_action( 'do_meta_boxes', $plugin_admin, 'service_member_featured_image_text' );
		$this->loader->add_action( 'do_meta_boxes', $plugin_admin, 'service_member_add_meta_boxes' );
		$this->loader->add_filter( 'manage_service-member_posts_columns', $plugin_admin, 'service_member_custom_columns' );
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'service_member_display_custom_columns' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_service_member_details' );
		$this->loader->add_action( 'wp_ajax_service_member_update_post_order', $plugin_admin, 'update_service_member_order' );
		$this->loader->add_action( 'wp_ajax_service_member_export', $plugin_admin, 'service_member_export' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_public_hooks() {

		$plugin_public = new Service_Provider_List_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'service_member_init', 10 );
		$this->loader->add_action( 'init', $plugin_public, 'maybe_flush_rewrite_rules', 20 );

	}
	public function run() {
		$this->loader->run();
	}
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	public function get_loader() {
		return $this->loader;
	}
	public function get_version() {
		return $this->version;
	}

}
