<?php
/**
 * Provide a admin area view for the export page
 *
 * This file is used to markup the admin-facing export page.
 */

$output          = '<div class="wrap rcode-template">';
	$output     .= '<div id="icon-edit" class="icon32 icon32-posts-service-member"><br></div><h2>' . __( 'Service Provider List', 'service-provider-list' ) . '</h2>';
	$output     .= '<div class="rcode-content rcode-column">';
		$output .= '<h2>' . __( 'Export', 'service-provider-list' ) . '</h2>';
		$output .= '<p>' . __( 'Click the export button below to generate a CSV download of your service member data.', 'service-provider-list' ) . '</p>';

		// Check for file access.
		$access_type = get_filesystem_method();
if ( 'direct' !== $access_type ) {
	$output .= '<p>' . __( "After clicking 'Export Service Provider Members' a Download button will appear.", 'service-provider-list' ) . '</p>';
}

		$output .= '<a href="#" class="button button-primary export-button">' . __( 'Export Service Provider Members', 'service-provider-list' ) . '</a>';
	$output     .= '</div>';
	$output     .= '<div class="rcode-sidebar rcode-column last">';
		// Get the sidebar.
		ob_start();
		require_once 'service-provider-list-admin-sidebar.php';
		$output .= ob_get_clean();
	$output     .= '</div>';
$output         .= '</div>';

// @codingStandardsIgnoreLine
echo $output;
