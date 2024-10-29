<?php
/**
 * The template for displaying the single service member meta.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="entry-meta service-meta">

	<?php
	/**
	 * Hook rcode_single_service_member_meta
	 *
	 * @hooked rcode_get_single_service_member_position - 10
	 * @hooked rcode_get_single_service_member_email - 15
	 * @hooked rcode_get_single_service_member_phone - 20
	 * @hooked rcode_get_single_service_member_address - 35
	 * @hooked rcode_get_single_service_member_facebook - 25
	 * @hooked rcode_get_single_service_member_twitter - 30
	 */
	do_action( 'rcode_single_service_member_meta' );
	?>

</div>
