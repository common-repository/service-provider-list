<?php
/**
 * The template for displaying the single service member twitter link.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$twitter = get_post_meta( $post->ID, '_service_member_tw', true );
if ( '' !== $twitter ) {

	$icon = '';
	$svg  = wp_remote_get( SP_LIST_URI . 'Common/svg/twitter.svg' );
	if ( '404' !== $svg['response']['code'] ) {
		$icon = $svg['body'];
	}

	echo '<span class="twitter"><a class="service-member-twitter" href="https://twitter.com/' . esc_attr( $twitter ) . '" title="Follow ' . esc_attr( get_the_title() ) . ' on Twitter">' . $icon . '</a></span>';

}
