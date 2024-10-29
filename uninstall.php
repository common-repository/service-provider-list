<?php
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete option
delete_option( '_service_listing_default_tags' );
delete_option( '_service_listing_default_tag_string' );
delete_option( '_service_listing_default_formatted_tags' );
delete_option( '_service_listing_default_formatted_tag_string' );
delete_option( '_service_listing_default_html' );
delete_option( '_service_listing_default_css' );
delete_option( '_service_listing_custom_html' );
delete_option( '_service_listing_custom_css' );
delete_option( '_service_listing_custom_name_plural' );
delete_option( '_service_listing_custom_name_singular' );
delete_option( '_service_listing_custom_slug' );
delete_option( '_service_listing_default_name_plural' );
delete_option( '_service_listing_default_name_singular' );
delete_option( '_service_listing_default_slug' );
delete_option( '_service_listing_write_external_css' );
delete_option( '_service_provider_list_version' );
