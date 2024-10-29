<?php
/**
 * The template for displaying the single service member address number.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$address = get_post_meta( $post->ID, '_service_member_address', true );
if ( '' !== $address ) {

	$icon = '';
	$svg  = wp_remote_get( SP_LIST_URI . 'Common/svg/address.svg' );
	if ( '404' !== $svg['response']['code'] ) {
		$icon = $svg['body'];
	}

	echo '<span class="address"><a class="service-member-address" href="tel:' . esc_attr( $address ) . '">' . $icon . '</a></span>';

}
