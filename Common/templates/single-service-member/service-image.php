<?php
/**
 * The template for displaying the single service member image.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium', false );
$src       = $image_obj[0];
?>
<img class="service-member-photo" src="<?php echo esc_attr( $src ); ?>" alt = "<?php echo esc_attr( get_the_title() ); ?>">
