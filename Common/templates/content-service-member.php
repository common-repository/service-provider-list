<?php
/**
 * The template for displaying the single service member content.
 *
 * This template can be overridden by copying it to yourtheme/rcode-templates/single-service-member/content-service-member.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Hook rcode_before_single_service_member_header.
	 */
	do_action( 'rcode_before_single_service_member_header' );
	?>
	<header class="service-header">
		<?php
		/**
		 * Hook rcode_single_service_member_header.
		 *
		 * @hooked rcode_get_single_service_member_image - 10
		 * @hooked rcode_get_single_service_member_name  - 15
		 * @hooked rcode_get_single_service_member_meta  - 20
		 */
		do_action( 'rcode_single_service_member_header' );
		?>
	</header>
	<?php
	/**
	 * Hook rcode_after_single_service_member_header.
	 */
	do_action( 'rcode_after_single_service_member_header' );
	?>
	<div class="service-content">
		<?php
		/**
		 * Hook rcode_single_service_member_content.
		 *
		 * @hooked rcode_get_single_service_member_bio - 10
		 */
		do_action( 'rcode_single_service_member_content' );
		?>
	</div>
	<?php
	/**
	 * Hook rcode_after_single_service_member_content.
	 */
	do_action( 'rcode_after_single_service_member_content' );
	?>
</article>
