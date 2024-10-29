<?php
/**
 * The template for displaying the single service member bio.
 */

$bio = get_post_meta( $post->ID, '_service_member_bio', true );

echo wpautop( $bio );
