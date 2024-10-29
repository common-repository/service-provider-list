<?php
/**
 * Service Provider List Template Functions
*/

if ( ! function_exists( 'rcode_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function rcode_output_content_wrapper() {
		rcode_get_template_part( 'global/wrapper-start' );
	}
}

if ( ! function_exists( 'rcode_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 */
	function rcode_output_content_wrapper_end() {
		rcode_get_template_part( 'global/wrapper-end' );
	}
}

if ( ! function_exists( 'rcode_get_single_service_member_bio' ) ) {

	/**
	 * Get the single service member's bio.
	 */
	function rcode_get_single_service_member_bio() {

		rcode_get_template_part( 'single-service-member/service-bio' );

	}
}

if ( ! function_exists( 'rcode_get_single_service_member_image' ) ) {

	/**
	 * Get the single service member's image.
	 */
	function rcode_get_single_service_member_image() {

		rcode_get_template_part( 'single-service-member/service-image' );

	}
}

if ( ! function_exists( 'rcode_get_single_service_member_name' ) ) {

	/**
	 * Get the single service member's name.
	 */
	function rcode_get_single_service_member_name() {

		rcode_get_template_part( 'single-service-member/service-name' );

	}
}

if ( ! function_exists( 'rcode_get_single_service_member_meta' ) ) {

	/**
	 * Get the single service member's name.
	 */
	function rcode_get_single_service_member_meta() {

		rcode_get_template_part( 'single-service-member/service-meta' );

	}
}

if ( ! function_exists( 'rcode_get_single_service_member_position' ) ) {

	/**
	 * Get the single service member's position.
	 */
	function rcode_get_single_service_member_position() {

		rcode_get_template_part( 'single-service-member/service-position' );

	}
}

if ( ! function_exists( 'rcode_get_single_service_member_email' ) ) {

	/**
	 * Get the single service member's email.
	 */
	function rcode_get_single_service_member_email() {

		rcode_get_template_part( 'single-service-member/service-email' );

	}
}

if ( ! function_exists( 'rcode_get_single_service_member_phone' ) ) {

	/**
	 * Get the single service member's phone.
	 */
	function rcode_get_single_service_member_phone() {

		rcode_get_template_part( 'single-service-member/service-phone' );

	}
}


if ( ! function_exists( 'rcode_get_single_service_member_address' ) ) {

	/**
	 * Get the single service member's address.
	 */
	function rcode_get_single_service_member_address() {

		rcode_get_template_part( 'single-service-member/service-address' );

	}
}


if ( ! function_exists( 'rcode_get_single_service_member_facebook' ) ) {

	/**
	 * Get the single service member's facebook.
	 */
	function rcode_get_single_service_member_facebook() {

		rcode_get_template_part( 'single-service-member/service-facebook' );

	}
}

if ( ! function_exists( 'rcode_get_single_service_member_twitter' ) ) {

	/**
	 * Get the single service member's twitter.
	 */
	function rcode_get_single_service_member_twitter() {

		rcode_get_template_part( 'single-service-member/service-twitter' );

	}
}
