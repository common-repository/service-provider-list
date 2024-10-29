<?php
/**
 * The template for displaying the single service member title/position.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$title = get_post_meta( $post->ID, '_service_member_title', true );
if ( '' !== $title ) {
	echo '<span class="title">' . esc_html( $title ) . '</span>';
}
