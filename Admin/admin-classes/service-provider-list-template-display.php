<?php
/**
 * Provide a admin area view for the plugin
 */

// Get options for default HTML CSS.
	$default_html                 = get_option( '_service_listing_default_html' );
	$default_css                  = get_option( '_service_listing_default_css' );
	$default_tag_string           = get_option( '_service_listing_default_tag_string' );
	$default_formatted_tag_string = get_option( '_service_listing_default_formatted_tag_string' );
	$default_tags                 = get_option( '_service_listing_default_tags' );
	$default_formatted_tags       = get_option( '_service_listing_default_formatted_tags' );
	$write_external_css           = get_option( '_service_listing_write_external_css' );

	$default_tag_ul = '<ul class="rcode-tag-list">';

foreach ( $default_tags as $tag ) {
	$default_tag_ul .= '<li>' . $tag . '</li>';
}

	$default_tag_ul .= '</ul>';

	$default_formatted_tag_ul = '<ul class="rcode-tag-list">';

foreach ( $default_formatted_tags as $tag ) {
	$default_formatted_tag_ul .= '<li>' . $tag . '</li>';
}

	$default_formatted_tag_ul .= '</ul>';

if ( 'yes' === $write_external_css ) {
	$ext_css_check = 'checked';
} else {
	$ext_css_check = '';
}

	$output          = '<div class="wrap rcode-template">';
		$output     .= '<div id="icon-edit" class="icon32 icon32-posts-service-member"><br></div><h2>' . __( 'Service Provider List', 'service-provider-list' ) . '</h2>';
		$output     .= '<div class="rcode-content rcode-column">';
			$output .= '<h2>Templates</h2>';
			$output .= '<h4>' . __( 'Accepted Template Tags', 'service-provider-list' ) . ' <strong>(' . __( 'UNFORMATTED', 'service-provider-list' ) . ')</strong></h4>';
			$output .= $default_tag_ul;

			$output .= '<br />';

			$output .= '<h4>' . __( 'Accepted Template Tags', 'service-provider-list' ) . ' <strong>(' . __( 'FORMATTED', 'service-provider-list' ) . ')</strong></h4>';
			$output .= $default_formatted_tag_ul;

			$output .= '<br />';
			
			$output .= '<p>' . __( 'Add text here.' );
			$output .= '<br />';

			$output .= '<form method="post" action="">';
			$output .= '<h3>' . __( 'Service Provider Loop Template', 'service-provider-list' ) . '</h3>';

			$output .= '<div class="default-html">
		    				<h4 class="heading button-secondary">' . __( 'View Default Template', 'service-provider-list' ) . '</h4>
		    				<div class="content">
		    					<pre>' . htmlspecialchars( stripslashes_deep( $default_html ) ) . '</pre>
		    				</div>
		    			</div><br />';

			$output .= '<textarea name="service-listing-html" cols="120" rows="16">' . $custom_html . '</textarea>';
			$output .= '<p><input type="submit" value="' . __( 'Save ALL Changes', 'service-provider-list' ) . '" class="button button-primary button-large"></p><br /><br />';

			$output .= wp_nonce_field( 'service-member-template', 'service-list-template' );
			$output .= '</form>';
		$output     .= '</div>';
		$output     .= '<div class="rcode-sidebar rcode-column last">';
			// Get the sidebar.
			ob_start();
			require_once 'service-provider-list-admin-sidebar.php';
			$output .= ob_get_clean();
		$output     .= '</div>';
	$output         .= '</div>';

	echo $output;
