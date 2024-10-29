<?php
/**
 * Provide a admin area view for the plugin
 */

?>
<div class="wrap rcode-usage">
	<div id="icon-edit" class="icon32 icon32-posts-service-member"><br></div>
	<h2><?php esc_html_e( 'Service Provider List', 'service-provider-list' ); ?></h2>

	<h2><?php esc_html_e( 'Usage', 'service-provider-list' ); ?></h2>
	<div class="rcode-content rcode-column">
		<?php
		$template_url = 'edit.php?post_type=service-member&page=service-member-template';
		$usage_url    = 'edit.php?post_type=service-member&page=service-member-usage';
		?>

		<p>
			<?php
			printf(
				// Translators: The placeholders below are for links.
				esc_html__( 'The Service Provider List plugin makes it easy to create and display a service directory on your website. You can create your own %1$s for displaying service information as well as %2$s styling to make your service directory look great.', 'service-provider-list' ),
				sprintf(
					'<a href="%s" title="%s">%s</a>',
					esc_url( $template_url ),
					esc_attr__( 'Edit the Service Provider List template.', 'service-provider-list' ),
					esc_html__( 'templates', 'service-provider-list' )
				),
				sprintf(
					'<a href="%s" title="%s">%s</a>',
					esc_url( $usage_url ),
					esc_attr__( 'Edit Custom CSS for Service Provider List', 'service-provider-list' ),
					esc_html__( 'add custom css', 'service-provider-list' )
				)
			);
			?>
		</p>
		<h3><?php esc_html_e( 'Shortcode', 'service-provider-list' ); ?></h3>
		<h4><code>[service-provider-list]</code></h4>
		<p><?php esc_html_e( 'This is the most basic usage of Service Provider List. Displays all Service Provider Members on post or page.', 'service-provider-list' ); ?></p>
		<h4><code>[service-provider-list service_type="Robots"]</code></h4>
		<p><?php esc_html_e( 'This displays all Service Provider Members from the service_type "Robots" sorted by order on the "Order" page. This will also add a class of "Robots" to the outer Service Provider List container for styling purposes.', 'service-provider-list' ); ?></p>
		<h4><code>[service-provider-list id=12]</code></h4>
		<p><?php esc_html_e( 'This will display the Service Provider Member ID "12". The Service Provider Member ID can be found on the "All Service Provider Members" page.', 'service-provider-list' ); ?></p>
		<h4><code>[service-provider-list wrap_class="clearfix"]</code></h4>
		<p><?php esc_html_e( 'This adds a class to the inner Service Provider Member wrap.', 'service-provider-list' ); ?></p>
		<h4><code>[service-provider-list order="ASC"]</code></h4>
		<p><?php esc_html_e( 'This displays Service Provider Members sorted by ascending or descending order according to the "Order" page. You may use "ASC" or "DESC" but the default is "ASC"', 'service-provider-list' ); ?></p>
		<h4><code>[service-provider-list image_size=thumbnail]</code></h4>
		<p><?php esc_html_e( 'This displays the Service Provider Members\' "thumbnail" size image instead of the "full" size image. You can use any image size registered with WordPress in place of "thumbnail."', 'service-provider-list' ); ?></p>
		<p>
			<?php
			printf(
				// Translators: The placeholders below are for links.
				esc_html__( 'To display your Service Provider List just use the shortcode <code>[service-provider-list]</code> in any page or post. This will output all service members according to the template options set %1$s.', 'service-provider-list' ),
				sprintf(
					'<a href="%s" title="%s">%s</a>',
					esc_url( $template_url ),
					esc_attr__( 'Edit the Service Provider List template.', 'service-provider-list' ),
					esc_html__( 'here', 'service-provider-list' )
				),
				''
			);
			?>
		</p>
	</div>
	<div class="rcode-sidebar rcode-column last">
		<?php require_once 'service-provider-list-admin-sidebar.php'; ?>
	</div>
</div>
