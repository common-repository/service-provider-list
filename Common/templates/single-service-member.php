<?php
/**
 * The template for displaying all single service members.
 *
 * This template can be overridden by copying it to yourtheme/rcode-templates/single-service-member.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<?php
	/**
	 * rcode_before_single_service_member hook.
	 *
	 * @hooked rcode_output_content_wrapper - 10 (outputs opening divs for the content)
	 */
	do_action( 'rcode_before_single_service_member' );
	?>
	<?php
	while ( have_posts() ) :
		the_post();
?>

	<?php rcode_get_template_part( 'content-service-member' ); ?>

	<?php endwhile; ?>

	<?php
	/**
	 * rcode_after_single_service_member hook.
	 *
	 * @hooked rcode_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'rcode_after_single_service_member' );
	?>

<?php
get_footer();
