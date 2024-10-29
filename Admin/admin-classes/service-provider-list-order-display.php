<?php
/**
 * Provide a admin area view for the plugin
 */

?>
<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-service-member"><br></div><h2><?php esc_html_e( 'Service Provider List', 'service-provider-list' ); ?></h2>
	<h2><?php esc_html_e( 'Order Service Provider', 'service-provider-list' ); ?></h2>
	<p><?php esc_html_e( 'Simply drag the service member up or down and they will be saved in that order.', 'service-provider-list' ); ?></p>
<?php
$service = new WP_Query(
	array(
		'post_type'      => 'service-member',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
	)
);
if ( $service->have_posts() ) :

	wp_nonce_field( 'rcode-order', 'rcode-order' );
		?>

	<table class="wp-list-table widefat fixed posts rcode-order" id="sortable-table">
		<thead>
			<tr>
				<th class="column-order"><?php esc_html_e( 'Order', 'service-provider-list' ); ?></th>
				<th class="column-photo"><?php esc_html_e( 'Photo', 'service-provider-list' ); ?></th>
				<th class="column-name"><?php esc_html_e( 'Name', 'service-provider-list' ); ?></th>
				<th class="column-title"><?php esc_html_e( 'Position', 'service-provider-list' ); ?></th>
				<th class="column-email"><?php esc_html_e( 'Email', 'service-provider-list' ); ?></th>
				<th class="column-phone"><?php esc_html_e( 'Phone', 'service-provider-list' ); ?></th>
				<th class="column-address"><?php esc_html_e( 'Address', 'service-provider-list' ); ?></th>
				<th class="column-bio"><?php esc_html_e( 'Bio', 'service-provider-list' ); ?></th>
			</tr>
		</thead>
		<tbody data-post-type="product">
		<?php
		while ( $service->have_posts() ) :
			$service->the_post();
			global $post;
			$custom = get_post_custom();
		?>
			<tr id="post-<?php the_ID(); ?>">
				<td class="column-order"><img src="<?php echo esc_attr( SP_LIST_URI ) . 'Admin/img/move-icon.png'; ?>" title="Select row for move order." alt="Move Icon" width="50" height="50" class="" /></td>
				<td class="column-photo">
				<?php
				if ( has_post_thumbnail() ) {
					echo get_the_post_thumbnail( $post->ID, array( 75, 75 ) );}
?>
</td>
				<td class="column-name"><strong><?php the_title(); ?></strong></td>
				<td class="column-title"><?php esc_html( $custom['_service_member_title'][0] ); ?></td>
				<td class="column-email"><?php esc_html( $custom['_service_member_email'][0] ); ?></td>
				<td class="column-phone"><?php esc_html( $custom['_service_member_phone'][0] ); ?></td>
				<td class="column-address"><?php esc_html( $custom['_service_member_address'][0] ); ?></td>
				<td class="column-bio"><?php esc_html( Service_Provider_List_Admin::get_service_bio_excerpt( $custom['_service_member_bio'][0], 10 ) ); ?></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<th class="column-order"><?php esc_html_e( 'Order', 'service-provider-list' ); ?></th>
				<th class="column-photo"><?php esc_html_e( 'Photo', 'service-provider-list' ); ?></th>
				<th class="column-name"><?php esc_html_e( 'Name', 'service-provider-list' ); ?></th>
				<th class="column-title"><?php esc_html_e( 'Position', 'service-provider-list' ); ?></th>
				<th class="column-email"><?php esc_html_e( 'Email', 'service-provider-list' ); ?></th>
				<th class="column-phone"><?php esc_html_e( 'Phone', 'service-provider-list' ); ?></th>
				<th class="column-address"><?php esc_html_e( 'Address', 'service-provider-list' ); ?></th>
				<th class="column-bio"><?php esc_html_e( 'Bio', 'service-provider-list' ); ?></th>
			</tr>
		</tfoot>
	</table>

<?php else : ?>

	<?php // translators: The placeholder below is the "Create New Service Provider Member" post. ?>
	<p><?php echo sprintf( wp_kses( __( 'No service members found, why not <a href="%s">create one?</a>', 'service-provider-list' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( 'post-new.php?post_type=service-member' ) ); ?></p>

<?php endif; ?>
<?php wp_reset_postdata(); // Don't forget to reset again! ?>
</div><!-- .wrap -->
