<?php
/**
 * Service Provider List Template Hooks
*/

/**
 * Content wrappers.
 */
add_action( 'rcode_before_single_service_member', 'rcode_output_content_wrapper', 10 );
add_action( 'rcode_after_single_service_member', 'rcode_output_content_wrapper_end', 10 );

/**
 * Single service member header
 */
add_action( 'rcode_single_service_member_header', 'rcode_get_single_service_member_image', 10 );
add_action( 'rcode_single_service_member_header', 'rcode_get_single_service_member_name', 15 );
add_action( 'rcode_single_service_member_header', 'rcode_get_single_service_member_meta', 20 );

/**
 * Single service member meta
 */
add_action( 'rcode_single_service_member_meta', 'rcode_get_single_service_member_position', 10 );
add_action( 'rcode_single_service_member_meta', 'rcode_get_single_service_member_email', 15 );
add_action( 'rcode_single_service_member_meta', 'rcode_get_single_service_member_phone', 35 );
add_action( 'rcode_single_service_member_meta', 'rcode_get_single_service_member_address', 20 );
add_action( 'rcode_single_service_member_meta', 'rcode_get_single_service_member_facebook', 25 );
add_action( 'rcode_single_service_member_meta', 'rcode_get_single_service_member_twitter', 30 );

/**
 * Single service member content area
 */
add_action( 'rcode_single_service_member_content', 'rcode_get_single_service_member_bio', 10 );
