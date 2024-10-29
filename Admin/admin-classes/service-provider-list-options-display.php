<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 */

// Get existing options.
$default_slug          = get_option( '_service_listing_default_slug' );
$default_name_singular = get_option( '_service_listing_default_name_singular' );
$default_name_plural   = get_option( '_service_listing_default_name_plural' );

// Check Nonce and then update options.
if ( ! empty( $_POST ) && check_admin_referer( 'service-member-options', 'service-list-options' ) ) {
	update_option( '_service_listing_custom_slug', wp_unique_term_slug( sanitize_text_field($_POST['service-listing-slug']), 'service-member' ) );
	update_option( '_service_listing_custom_name_singular', sanitize_text_field($_POST['service-listing-name-singular']) );
	update_option( '_service_listing_custom_name_plural', sanitize_text_field($_POST['service-listing-name-plural']) );

	$custom_slug          = stripslashes_deep( get_option( '_service_listing_custom_slug' ) );
	$custom_name_singular = stripslashes_deep( get_option( '_service_listing_custom_name_singular' ) );
	$custom_name_plural   = stripslashes_deep( get_option( '_service_listing_custom_name_plural' ) );

	// We've updated the options, send off an AJAX request to flush the rewrite rules.
	// TODO# Should move these options to use the Settings API instead of our own custom thing - or maybe just make it all AJAX - no need for a page refresh.
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var data = {
			'action': 'rcode_flush_rewrite_rules',
		}

		$.post( "<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>", data, function(response){});
	});
	</script>
<?php

} else {
	$custom_slug          = stripslashes_deep( get_option( '_service_listing_custom_slug' ) );
	$custom_name_singular = stripslashes_deep( get_option( '_service_listing_custom_name_singular' ) );
	$custom_name_plural   = stripslashes_deep( get_option( '_service_listing_custom_name_plural' ) );
}


$output      = '<div class="wrap rcode-options">';
	$output .= '<div id="icon-edit" class="icon32 icon32-posts-service-member"><br></div>';
	$output .= '<h2>' . __( 'Service Provider List', 'service-provider-list' ) . '</h2>';
	$output .= '<h2>' . __( 'Options', 'service-provider-list' ) . '</h2>';

	$output         .= '<div class="rcode-content rcode-column">';
		$output     .= '<form method="post" action="">';
			$output .= '<fieldset id="service-listing-field-slug" class="rcode-fieldset">';
			$output .= '<legend class="rcode-field-label">' . __( 'Service Provider Members URL Slug', 'service-provider-list' ) . '</legend>';
			$output .= '<input type="text" name="service-listing-slug" value="' . $custom_slug . '"></fieldset>';
			$output .= '<p>' . __( 'The slug used for building the service members URL. The current URL is: ', 'service-provider-list' );
			$output .= site_url( $custom_slug ) . '/';
			$output .= '</p>';
			$output .= '<fieldset id="service-listing-field-name-plural" class="rcode-fieldset">';
			$output .= '<legend class="rcode-field-label">' . __( 'Service Provider Member title', 'service-provider-list' ) . '</legend>';
			$output .= '<input type="text" name="service-listing-name-plural" value="' . $custom_name_plural . '"></fieldset>';
			$output .= '<p>' . __( 'The title that displays on the Service Provider Member archive page. Default is "Service Provider Members"', 'service-provider-list' ) . '</p>';
			$output .= '<fieldset id="service-listing-field-name-singular" class="rcode-fieldset">';
			$output .= '<legend class="rcode-field-label">' . __( 'Service Provider Member singular title', 'service-provider-list' ) . '</legend>';
			$output .= '<input type="text" name="service-listing-name-singular" value="' . $custom_name_singular . '"></fieldset>';
			$output .= '<p>' . __( 'The Service Provider Member taxonomy singular name. No need to change this unless you need to use the singular_name field in your theme. Default is "Service Provider Member"', 'service-provider-list' ) . '</p>';

			$output .= '<p><input type="submit" value="' . __( 'Save ALL Changes', 'service-provider-list' ) . '" class="button button-primary button-large"></p><br /><br />';

			$output .= wp_nonce_field( 'service-member-options', 'service-list-options' );
		$output     .= '</form>';
	$output         .= '</div>';
	$output         .= '<div class="rcode-sidebar rcode-column last">';
		// Get the sidebar.
		ob_start();
		require_once 'service-provider-list-admin-sidebar.php';
		$output .= ob_get_clean();
	$output     .= '</div>';
$output         .= '</div>';

// @codingStandardsIgnoreLine
echo $output;
