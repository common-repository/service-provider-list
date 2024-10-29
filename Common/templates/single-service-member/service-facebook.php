<?php
/**
 * The template for displaying the single service member facebook link.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$facebook = get_post_meta( $post->ID, '_service_member_fb', true );
if ( '' !== $facebook ) {

	$icon = '';
	$svg  = wp_remote_get( SP_LIST_URI . 'Common/svg/facebook.svg' );
	if ( '404' !== $svg['response']['code'] ) {
		$icon = $svg['body'];
	}

	echo '<span class="facebook"><a class="service-member-facebook" href="' . esc_attr( $facebook ) . '" title="Find ' . esc_attr( get_the_title() ) . ' on Facebook">' . $icon . '</a></span>';

}
