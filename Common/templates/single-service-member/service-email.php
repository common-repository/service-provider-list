<?php
/**
 * The template for displaying the single service member email.
 *
 */

$email = get_post_meta( $post->ID, '_service_member_email', true );
if ( '' !== $email ) {

	$icon = '';
	$svg  = wp_remote_get( SP_LIST_URI . 'Common/svg/envelope.svg' );
	if ( '404' !== $svg['response']['code'] ) {
		$icon = $svg['body'];
	}

	echo '<span class="email"><a class="service-member-email" href="mailto:' . esc_attr( antispambot( $email ) ) . '" title="Email ' . esc_attr( get_the_title() ) . '">' . $icon . '</a></span>';

}
