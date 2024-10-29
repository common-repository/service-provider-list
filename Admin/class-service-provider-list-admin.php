<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 **/
class Service_Provider_List_Admin {

	private $plugin_name;
	private $version;
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 */

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/service-provider-list-admin.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
		if ( isset( $_GET['post_type'] ) && 'service-member' === $_GET['post_type'] ) {

			wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'js/service-provider-list-admin.js',
				array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ),
				$this->version,
				false
			);
		}
	}

	/**
	 * Flush Rewrite Rules after saving plugin options
	 */
	public function ajax_flush_rewrite_rules() {
		flush_rewrite_rules();
		wp_send_json_success();
	}

	/**
	 * Register admin menu items.
	 */
	public function register_menu() {

		// Order page.
		add_submenu_page(
			'edit.php?post_type=service-member',
			__( 'Service Provider List Order', $this->plugin_name ),
			__( 'Manage List Order', $this->plugin_name ),
			'edit_pages',
			'service-member-order',
			array( $this, 'display_order_page' )
		);

		// Templates page.
		add_submenu_page(
			'edit.php?post_type=service-member',
			__( 'Display Templates', $this->plugin_name ),
			__( 'Front Design & HTML Variables', $this->plugin_name ),
			'edit_pages',
			'service-member-template',
			array( $this, 'display_templates_page' )
		);

		// Usage page.
		add_submenu_page(
			'edit.php?post_type=service-member',
			__( 'Service Provider List Usage', $this->plugin_name ),
			__( 'Shortcode', $this->plugin_name ),
			'edit_pages',
			'service-member-usage',
			array( $this, 'display_usage_page' )
		);

		// Options page.
		add_submenu_page(
			'edit.php?post_type=service-member',
			__( 'Service Provider List Options', $this->plugin_name ),
			__( 'Settings', $this->plugin_name ),
			'edit_pages',
			'service-member-options',
			array( $this, 'display_options_page' )
		);

		// Export.
		add_submenu_page(
			'edit.php?post_type=service-member',
			__( 'Service Provider List Export', $this->plugin_name ),
			__( 'CSV Export List', $this->plugin_name ),
			'export',
			'service-member-export',
			array( $this, 'display_export_page' )
		);

	}

	/**
	 * Display Order page content.
	 */
	public function display_order_page() {
		include_once 'admin-classes/service-provider-list-order-display.php';
	}

	/**
	 * Display Template page content.
	 */
	public function display_templates_page() {
		include_once 'admin-classes/service-provider-list-template-display.php';
	}

	/**
	 * Display Usage page content.
	 */
	public function display_usage_page() {
		include_once 'admin-classes/service-provider-list-usage-display.php';
	}

	/**
	 * Display Usage page content.
	 */
	public function display_options_page() {
		include_once 'admin-classes/service-provider-list-options-display.php';
	}

	/**
	 * Display Usage page content.
	 */
	public function display_export_page() {
		include_once 'admin-classes/service-provider-list-export-display.php';
	}

	/**
	 * Hide unwanted meta boxes on service member screen.
	 */
	public function hide_meta_boxes( $hidden, $screen ) {

		if ( 'service-member' === $screen->id ) {
			$hidden = array( 'postexcerpt' );
		}

		return $hidden;

	}

	/**
	 * Change name of title meta box on service member screen.
	 */
	public function service_member_change_title( $title ) {

		$screen = get_current_screen();

		if ( 'service-member' === $screen->post_type ) {
			$title = __( 'Service Provider Name', $this->plugin_name );
		}

		return $title;
	}

	/**
	 * Handle service member featured image text
	 */
	public function service_member_featured_image_text() {

	}

	/**
	 * Add theme support for post thumbnails
	 */
	public function add_featured_image_support() {

		add_theme_support( 'post-thumbnails', array( 'service-member' ) );

	}

	/**
	 * Register service member meta boxes.
	 */
	public function service_member_add_meta_boxes() {

		add_meta_box(
			'service-member-info',
			__( 'Service Provider Member Info', $this->plugin_name ),
			array( $this, 'service_member_info_meta_box' ),
			'service-member',
			'normal',
			'high'
		);

		add_meta_box(
			'service-member-bio',
			__( 'Service Provider Member Bio', $this->plugin_name ),
			array( $this, 'service_member_bio_meta_box' ),
			'service-member',
			'normal',
			'high'
		);

	}

	/**
	 * Register service member custom columns.
	 */
	public function service_member_custom_columns( $cols ) {

		$cols = array(
			'cb'                  => '<input type="checkbox" />',
			'id'                  => __( 'Service Provider ID', $this->plugin_name ),
			'title'               => __( 'Name', $this->plugin_name ),
			'photo'               => __( 'Photo', $this->plugin_name ),
			'_service_member_title' => __( 'Position', $this->plugin_name ),
			'_service_member_email' => __( 'Email', $this->plugin_name ),
			'_service_member_phone' => __( 'Phone', $this->plugin_name ),
			'_service_member_address' => __( 'Address', $this->plugin_name ),
			'_service_member_bio'   => __( 'Bio', $this->plugin_name ),
		);

		return $cols;
	}

	/**
	 * Display service member info meta box.
	 */
	public function service_member_info_meta_box() {

		global $post;

		$custom              = get_post_custom( $post->ID );
		$_service_member_title = isset( $custom['_service_member_title'][0] ) ? $custom['_service_member_title'][0] : '';
		$_service_member_email = isset( $custom['_service_member_email'][0] ) ? $custom['_service_member_email'][0] : '';
		$_service_member_phone = isset( $custom['_service_member_phone'][0] ) ? $custom['_service_member_phone'][0] : '';
		$_service_member_address = isset( $custom['_service_member_address'][0] ) ? $custom['_service_member_address'][0] : '';
		$_service_member_fb    = isset( $custom['_service_member_fb'][0] ) ? $custom['_service_member_fb'][0] : '';
		$_service_member_tw    = isset( $custom['_service_member_tw'][0] ) ? $custom['_service_member_tw'][0] : '';
		?>

		<div class="rcode_admin_wrap">
			<label for="_service-member-title">
				<?php esc_html_e( 'Position:', $this->plugin_name ); ?>
				<input type="text"
						name="_service_member_title"
						id="_service_member_title"
						placeholder="<?php esc_attr_e( 'Service Provider Member\'s Position', $this->plugin_name ); ?>"
						value="<?php echo esc_attr( $_service_member_title ); ?>"/>
			</label>
			<label for="_service-member-email">
				<?php esc_html_e( 'Email:', $this->plugin_name ); ?>
				<input type="text"
						name="_service_member_email"
						id="_service_member_email"
						placeholder="<?php esc_attr_e( 'Service Provider Member\'s Email', $this->plugin_name ); ?>"
						value="<?php echo esc_attr( $_service_member_email ); ?>"/>
			</label>
			<label for="_service-member-title">
				<?php esc_html_e( 'Phone:', $this->plugin_name ); ?>
				<input type="text"
						name="_service_member_phone"
						id="_service_member_phone"
						placeholder="<?php esc_attr_e( 'Service Provider Member\'s Phone', $this->plugin_name ); ?>"
						value="<?php echo esc_attr( $_service_member_phone ); ?>"/>
			</label>

			<label for="_service-member-title">
				<?php esc_html_e( 'Address:', $this->plugin_name ); ?>
				<input type="text"
						name="_service_member_address"
						id="_service_member_address"
						placeholder="<?php esc_attr_e( 'Service Provider Member\'s Address', $this->plugin_name ); ?>"
						value="<?php echo esc_attr( $_service_member_address ); ?>"/>
			</label>

			<label for="_service-member-fb">
				<?php esc_html_e( 'Facebook URL:', $this->plugin_name ); ?>
				<input type="text"
						name="_service_member_fb"
						id="_service_member_fb"
						placeholder="<?php esc_attr_e( 'Service Provider Member\'s Facebook URL', $this->plugin_name ); ?>"
						value="<?php echo esc_attr( $_service_member_fb ); ?>"/>
			</label>
			<label for="_service-member-tw">
				<?php esc_html_e( 'Twitter Username:', $this->plugin_name ); ?>
				<input type="text"
						name="_service_member_tw"
						id="_service_member_tw"
						placeholder="<?php esc_attr_e( 'Service Provider Member\'s Twitter Name', $this->plugin_name ); ?>"
						value="<?php echo esc_attr( $_service_member_tw ); ?>"/>
			</label>
		</div>
		<?php

	}

	/**
	 * Display service member warnings.
	 */
	public function rcode_service_member_warning_meta_box() {

		esc_html_e(
			'<p><strong>Your current theme does not support post thumbnails. Unfortunately, you will not be able to add photos for your Service Provider Members</strong></p>',
			$this->plugin_name
		);

	}

	/**
	 * Display service member bio meta box.
	 */
	public function service_member_bio_meta_box() {

		global $post;

		$custom            = get_post_custom( $post->ID );
		$_service_member_bio = isset( $custom['_service_member_bio'][0] ) ? $custom['_service_member_bio'][0] : '';

		wp_editor(
			$_service_member_bio,
			'_service_member_bio',
			$settings = array(
				'textarea_rows' => 8,
				'media_buttons' => false,
				'tinymce'       => true, // Disables actual TinyMCE buttons // This makes the rich content editor.
				'quicktags'     => true, // Use QuickTags for formatting    // work within a metabox.
			)
		);
		?>
		<?php wp_nonce_field( 'rcode_post_nonce', 'rcode_add_edit_service_member_noncename' ); ?>

		<?php

	}

	/**
	 * Display service member custom columns.
	 */
	public function service_member_display_custom_columns( $column ) {

		global $post;

		$custom              = get_post_custom();
		$_service_member_title = isset( $custom['_service_member_title'][0] ) ? $custom['_service_member_title'][0] : '';
		$_service_member_email = isset( $custom['_service_member_email'][0] ) ? $custom['_service_member_email'][0] : '';
		$_service_member_phone = isset( $custom['_service_member_phone'][0] ) ? $custom['_service_member_phone'][0] : '';
		$_service_member_address = isset( $custom['_service_member_address'][0] ) ? $custom['_service_member_address'][0] : '';
		$_service_member_bio   = isset( $custom['_service_member_bio'][0] ) ? $custom['_service_member_bio'][0] : '';

		switch ( $column ) {
			case 'id':
				echo $post->ID;
				break;
			case 'photo':
				if ( has_post_thumbnail() ) {
					echo get_the_post_thumbnail( $post->ID, array( 75, 75 ) );
				}
				break;
			case '_service_member_title':
				echo esc_html( $_service_member_title );
				break;
			case '_service_member_email':
				echo '<a href="mailto:' . esc_attr( $_service_member_email ) . '">' . esc_html( $_service_member_email ) . '</a>';
				break;
			case '_service_member_phone':
				echo esc_html( $_service_member_phone );
				break;
			case '_service_member_address':
				echo esc_html( $_service_member_address );
				break;
			case '_service_member_bio':
				echo esc_html( $this->get_service_bio_excerpt( $_service_member_bio, 10 ) );
				break;
		}

	}

	/**
	 * Save the service member details post meta.
	 */
	public function save_service_member_details() {

		global $post;

		if ( ! isset( $_POST['rcode_add_edit_service_member_noncename'] ) || ! wp_verify_nonce( $_POST['rcode_add_edit_service_member_noncename'], 'rcode_post_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		update_post_meta(
			$post->ID,
			'_service_member_bio',
			isset( $_POST['_service_member_bio'] ) ? sanitize_text_field($_POST['_service_member_bio']) : ''
		);
		update_post_meta(
			$post->ID,
			'_service_member_title',
			isset( $_POST['_service_member_title'] ) ? sanitize_text_field($_POST['_service_member_title']) : ''
		);
		update_post_meta(
			$post->ID,
			'_service_member_email',
			isset( $_POST['_service_member_email'] ) ? sanitize_text_field($_POST['_service_member_email']) : ''
		);
		update_post_meta(
			$post->ID,
			'_service_member_phone',
			isset( $_POST['_service_member_phone'] ) ? sanitize_text_field($_POST['_service_member_phone']) : ''
		);
		update_post_meta(
			$post->ID,
			'_service_member_address',
			isset( $_POST['_service_member_address'] ) ? sanitize_text_field($_POST['_service_member_address']) : ''
		);
		update_post_meta(
			$post->ID,
			'_service_member_fb',
			isset( $_POST['_service_member_fb'] ) ? sanitize_text_field($_POST['_service_member_fb']) : ''
		);
		update_post_meta(
			$post->ID,
			'_service_member_tw',
			isset( $_POST['_service_member_tw'] ) ? sanitize_text_field($_POST['_service_member_tw']) : ''
		);

	}

	/**
	 * Get service bio excerpt.
	 */
	public function get_service_bio_excerpt( $text, $excerpt_length ) {

		global $post;

		if ( ! $excerpt_length || ! is_int( $excerpt_length ) ) {
			$excerpt_length = 20;
		}

		if ( '' !== $text ) {
			$text         = strip_shortcodes( $text );
			$text         = apply_filters( 'the_content', $text );
			$text         = str_replace( ']]>', ']]>', $text );
			$excerpt_more = ' ...';
			$text         = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}

		return apply_filters( 'the_excerpt', $text );

	}

	/**
	 * Update Service Provider Member order.
	 */
	public function update_service_member_order() {
		global $wpdb;

		if ( ! isset( $_POST['nonce'] ) || ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( $_POST['nonce'], 'rcode-order' ) ) ) {
			wp_send_json_error( "Cheatin' uh?" );
		}

		$post_type = sanitize_text_field($_POST['postType']);
		$order     = sanitize_text_field($_POST['order']);

		/**
		 *    Expect: $sorted = array(
		 *                menu_order => post-XX
		 *            );
		 */
		foreach ( $order as $menu_order => $post_id ) {
			$post_id    = intval( str_ireplace( 'post-', '', $post_id ) );
			$menu_order = intval( $menu_order );
			wp_update_post(
				array(
					'ID'         => $post_id,
					'menu_order' => $menu_order,
				)
			);
		}

		wp_send_json_success( 'Order updated' );
	}

	/**
	 * Service Provider Member Export
	 */
	public function service_member_export() {

		$access_type = get_filesystem_method();

		$args = array(
			'post_type'      => 'service-member',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);

		$service_query = new WP_Query( $args );

		if ( $service_query->have_posts() ) :

			$csv_headers = array();
			$csv_data    = array();

			while ( $service_query->have_posts() ) :
				$service_query->the_post();

				$custom = get_post_custom();

				// Setup our CSV Header line if we haven't already.
				if ( ! $csv_headers ) {
					$csv_headers[] = 'Service Provider Member Name';
					$csv_headers[] = 'Service Provider Member Image URL';

					foreach ( $custom as $key => $value ) {
						if ( strpos( $key, '_service_member_' ) !== false ) {

							$new_key = trim( str_replace( '_', ' ', $key ) );

							$csv_headers[] = ucwords( $new_key );

						}
					}

					$csv_headers[] = 'Service Type';

					$csv_data[] = $csv_headers;
				}

				// Setup our data line for this Service Provider Member.
				$csv_new_line = array( get_the_title() );

				// Get the post image.
				$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );
				if ( false !== $image_obj ) {
					$csv_new_line[] = $image_obj[0];
				} else {
					$csv_new_line[] = '';
				}

				// Get the post custom data.
				foreach ( $custom as $key => $value ) {
					if ( strpos( $key, '_service_member_' ) !== false ) {

						$new_value = $value[0];

						$csv_new_line[] = trim( $new_value );

					}
				}

				// Get the service type data.
				$service_types = get_the_terms( get_the_ID(), 'service-member-service_type' );

				$service_type_names = array();

				// $service_types should be an array of WP_Term objects if terms are found. It will be false if no terms exist, and a WP_Error if there was an error.
				if ( is_array( $service_types ) ) {
					foreach ( $service_types as $service_type ) {
						// Wrap each service_type name in quotes.
						$service_type_names[] = '"' . $service_type->name . '"';
					}
				}

				// Add the service_type data to the line.
				$csv_new_line[] = implode( ',', $service_type_names );

				// Add a new line to the end of our data.
				$csv_data[] = $csv_new_line;

			endwhile;

			$csv_str_out = '';
			foreach ( $csv_data as $line ) {

				$i = 1;
				foreach ( $line as $data ) {
					$data_line_out = '"' . str_replace( '"', '""', $data ) . '"';

					// Replace the newlines with <br> tags.
					$csv_str_out .= str_replace( array( "\r\n", "\r", "\n" ), '<br/>', $data_line_out );

					if ( count( $line ) !== $i ) {
						$csv_str_out .= ',';
					}

					$i++;
				}

				$csv_str_out .= "\n";

			}

			if ( 'direct' === $access_type ) {

				// Save the file.
				$url   = wp_nonce_url( 'edit.php?post_type=service-member&page=service-member-export', 'rcode-service-export' );
				$creds = request_filesystem_credentials( $url, '', false, false, null );

				if ( ! WP_filesystem( $creds ) ) {
					wp_send_json_error( 'Problem accessing WP File System' );
				}

				global $wp_filesystem;

				$uploads = wp_upload_dir();

				// Create the rcode directory in uploads if we need to.
				if ( ! is_dir( $uploads['basedir'] . '/rcode' ) ) {

					$wp_filesystem->mkdir( $uploads['basedir'] . '/rcode' );
					$wp_filesystem->put_contents( $uploads['basedir'] . '/rcode/index.php', '', FS_CHMOD_FILE );

				} else {

					// Clean out any files that are in there...we're not backing up these exports, although that could be a feature later on.
					$path  = $uploads['basedir'] . '/rcode/';
					$files = $wp_filesystem->dirlist( $path );

					foreach ( $files as $file ) {

						if ( false !== strpos( $file['name'], 'service-member-export-' ) ) {

							$wp_filesystem->delete( $path . $file['name'] );

						}
					}
				}

				// Save our file.
				$wp_filesystem->put_contents(
					$uploads['basedir'] . '/rcode/service-member-export-' . date( 'Y-m-d-G-i' ) . '.csv',
					$csv_str_out,
					FS_CHMOD_FILE
				);

				wp_send_json_success(
					array(
						'created_file' => true,
						'url'          => $uploads['baseurl'] . '/rcode/service-member-export-' . date( 'Y-m-d-G-i' ) . '.csv',
					)
				);
			} else {
				wp_send_json_success(
					array(
						'created_file' => false,
						'content'      => $csv_str_out,
						'filename'     => 'service-member-export-' . date( 'Y-m-d-G-i' ) . '.csv',
					)
				);
			}

		endif;

		wp_send_json_error( 'No data to export.' );

	}

}
