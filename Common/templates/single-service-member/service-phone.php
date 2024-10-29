<?php
/**
 * The template for displaying the single service member phone number.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$phone = get_post_meta( $post->ID, '_service_member_phone', true );
if ( '' !== $phone ) {

	$icon = '';
	$svg  = wp_remote_get( SP_LIST_URI . 'Common/svg/phone.svg' );
	if ( '404' !== $svg['response']['code'] ) {
		$icon = $svg['body'];
	}

	echo '<span class="phone"><a class="service-member-phone" href="tel:' . esc_attr( $phone ) . '">' . $icon . '</a></span>';

}
