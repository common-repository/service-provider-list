<?php
/**
 * Service Provider List Core Functions
 *
 * General core functions available everywhere.
 *
 */

function rcode_get_template_part( $slug = '' ) {

	$template = '';

	// Look in yourtheme/rcode-templates/slug.php.
	if ( '' !== $slug ) {
		$template = locate_template( array( "rcode-templates/{$slug}.php" ) );
	}

	// Look in yourtheme/slug.php.
	if ( ! $template && '' !== $slug ) {
		$template = locate_template( array( "{$slug}.php" ) );
	}

	// Get default slug.php.
	if ( ! $template && '' !== $slug && file_exists( SP_LIST_PATH . "/Common/templates/{$slug}.php" ) ) {
		$template = SP_LIST_PATH . "/Common/templates/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'rcode_get_template_part', $template, $slug );

	//wp_die( $template );

	if ( $template ) {
		load_template( $template, false );
	}

}

/**
 * This is loading the single-service-member.php template from the plugin's templates folder
 * UNLESS single-service-member.php is present in the stylesheet directory/rcode-templates.
 * theme root > theme/rcode-templates > plugin/Common/templates
 */
function rcode_template_include( $template ) {

	if ( ! is_singular( 'service-member' ) ) {
		return $template;
	}

	// Check in the folder we've told users to add the template to.
	$template = locate_template( array( '/rcode-templates/single-service-member.php' ) );

	// If it's not found, look in the theme root.
	if ( ! $template ) {
		$template = locate_template( array( 'single-service-member.php' ) );
	}

	// Still not found? Just use the one we included in the plugin.
	if ( ! $template ) {
		$template = SP_LIST_PATH . 'Common/templates/single-service-member.php';
	}

	return $template;

}
add_filter( 'template_include', 'rcode_template_include' );
