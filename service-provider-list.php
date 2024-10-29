<?php
/**
 * Plugin Name:Service Provider List
 * Description:The ideal plugin for display service provider profile list with services on your website.
 * Version:1.0.0
 * Author:serviceprovider1080
 * License:GPLv2 or later
 */

// Check if mbsting exists
if (!defined('ABSPATH')) {
    die('Invalid request.');
}

/**
 * Define constants for the plugin
 */
define( 'SP_LIST_PATH', plugin_dir_path( __FILE__ ) );
define( 'SP_LIST_URI', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in Classes/class-service-provider-list-activator.php
 */
function activate_service_provider_list() {
	require_once plugin_dir_path( __FILE__ ) . 'Classes/class-service-provider-list-activator.php';
	Service_Provider_List_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in Classes/class-service-provider-list-deactivator.php
 */
function deactivate_service_provider_list() {
	require_once plugin_dir_path( __FILE__ ) . 'Classes/class-service-provider-list-deactivator.php';
	Service_Provider_List_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_service_provider_list' );
register_deactivation_hook( __FILE__, 'deactivate_service_provider_list' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'Classes/class-service-provider-list.php';

/**
 * Begins execution of the plugin.
 */
function run_service_provider_list() {

	$plugin = new Service_Provider_List();
	$plugin->run();

}
run_service_provider_list();
