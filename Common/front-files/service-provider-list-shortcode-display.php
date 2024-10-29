<?php
/**
 * Provide a public-facing view for the plugin
 */

	global $rcode_sc_output;

	$isShowServiceTypeOption = 1;
	$atts       	= $this->service_provider_list_shortcode_atts;
	$service_id   	= $atts['id'];
	$service_type   = $atts['service_type'];
	$wrap_class 	= $atts['wrap_class'];
	$order      	= $atts['order'];

	if($service_type!=''){
		$isShowServiceTypeOption = 2;
	}

	$stype = '';
	if(isset($_REQUEST['stype']) && $_REQUEST['stype']!=''){
		$stype 			= $_REQUEST['stype'];
		$service_type 	= str_replace("-", " ", $stype);
	}else{
		$service_type   = strtolower( $service_type );
	}

	// Get Template and CSS.
	$custom_html            = stripslashes_deep( get_option( '_service_listing_custom_html' ) );
	$custom_css             = stripslashes_deep( get_option( '_service_listing_custom_css' ) );
	$default_tags           = get_option( '_service_listing_default_tags' );
	$default_formatted_tags = get_option( '_service_listing_default_formatted_tags' );
	$output                 = '';
	$order                  = strtoupper( $order );
	$service                = '';
	$use_external_css 		= get_option( '_service_listing_write_external_css' );

	/**
	 * Set up our WP_Query
	 */

	$args = array(
		'posts_per_page' => 100,
		'orderby'        => 'menu_order',
		'post_status'    => 'publish',
	);

	// Check user's 'order' value.
	if ( 'ASC' !== $order && 'DESC' !== $order ) {
		$order = 'ASC';
	}

	// Set 'order' in our query args.
	$args['order']              = $order;

	if (isset($atts['service-member']) && '' !== $atts['service-member']) {
		$args['service-member-service_type'] = $service_type;
	}else if($stype!=''){
		$args['service-member-service_type'] = $service_type;
	}

	if ( '' !== $service_id && 'service-member' === get_post_type( intval( $service_id ) ) ) {
		$args['p'] = intval( $service_id );
	}

	/**
	 * rcode_query_args filter.
	 */
	$filtered_args = apply_filters( 'rcode_query_args', $args, 'shortcode' );

	// If we don't get an array back, reset $args back to the default.
	$args = is_array( $filtered_args ) ? $filtered_args : $args;

	// Make sure this gets set back to service-member - no reason to be querying anything else here.
	$args['post_type'] = 'service-member';

	// Query the service members.
	$service = new WP_Query( $args );

	/**
	 * Set up our loop_markup
	 */

	$loop_markup_reset = str_replace( '[service_loop]', '', substr( $custom_html, strpos( $custom_html, '[service_loop]' ), strpos( $custom_html, '[/service_loop]' ) - strpos( $custom_html, '[service_loop]' ) ) );
	$loop_markup       = $loop_markup_reset;


	// Doing this so I can concatenate class names for current and possibly future use.
	$service_member_classes = $wrap_class;

	// Prepare to output styles if not using external style sheet.
	if ( 'no' === $use_external_css ) {
		$style_output = '<style>' . $custom_css . '</style>';
	} else {
		$style_output = ''; }

	$i = 0;

	if ( $service->have_posts() ) :

		$output .= '<div class="service-member-listing ' . $service_type . '">';

		if($isShowServiceTypeOption==1){
			if($service_type!=''){
				//$output .= '<p>You are searching for: <strong>'.$service_type."</strong></p>";
			}
			$terms = get_terms( array(
			    'taxonomy' 		=> 'service-member-service_type',
			    'hide_empty' 	=> true,
			) );

			if($terms){
				$output .= '<div class="service-member"> <strong>Service Type: </strong>';
				$output .= '<select name="serviceTypeSelect" id="serviceTypeSelect" class="category-select">';
				$output .= '<option value="">Select Service</option>';
				foreach ($terms as $key => $value) {
					$isSelectcted = '';
					if($stype!='' && $stype==$value->slug){
						$isSelectcted = 'selected=selected';
					}
					$output .= '<option value='.$value->slug.' '.$isSelectcted.'>'.$value->name.'</option>';
				}
				$output .= '</select>';
				$output .= '</div>';
			}

		}

		while ( $service->have_posts() ) :
			$service->the_post();

			global $post;

			if ( ( $service->found_posts ) - 1 === $i ) {
				$service_member_classes .= ' last';
			}

			if ( $i % 2 ) {
				$output .= '<div class="service-member odd ' . $service_member_classes . '">';
			} else {
				$output .= '<div class="service-member even ' . $service_member_classes . '">';
			}

			global $post;

			$custom          = get_post_custom();
			$name            = get_the_title();
			$name_formatted  = '<h3 class="service-member-name">' . $name . '</h3>';
			$name_slug       = basename( get_permalink() );
			$title           = isset( $custom['_service_member_title'][0] ) ? $custom['_service_member_title'][0] : '';
			$title_formatted = '' !== $title ? '<h4 class="service-member-position">' . $title . '</h4>' : '';
			$email           = isset( $custom['_service_member_email'][0] ) ? $custom['_service_member_email'][0] : '';
			$phone           = isset( $custom['_service_member_phone'][0] ) ? $custom['_service_member_phone'][0] : '';
			$address           = isset( $custom['_service_member_address'][0] ) ? $custom['_service_member_address'][0] : '';
			$bio             = isset( $custom['_service_member_bio'][0] ) ? $custom['_service_member_bio'][0] : '';
			$fb_url          = isset( $custom['_service_member_fb'][0] ) ? $custom['_service_member_fb'][0] : '';
			$tw_url          = isset( $custom['_service_member_tw'][0] ) ? 'http://www.twitter.com/' . $custom['_service_member_tw'][0] : '';
			$email_mailto    = '' !== $email ? '<a class="service-member-email" href="mailto:' . antispambot( $email ) . '" title="Email ' . $name . '">' . antispambot( $email ) . '</a>' : '';
			$email_nolink    = '' !== $email ? antispambot( $email ) : '';

			if ( has_post_thumbnail() ) {

				$image_size = apply_filters( 'rcode_set_service_image_size', $atts['image_size'], $post->ID );

				$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size, false );
				$src       = $image_obj[0];

				$photo_url = $src;
				$photo     = '<img class="service-member-photo" src="' . $photo_url . '" alt = "' . $title . '">';

			} else {

				$photo_url = '';
				$photo     = '';

			}

			if ( function_exists( 'wpautop' ) ) {

				$bio_format = '' !== $bio ? '<div class="service-member-bio">' . wpautop( $bio ) . '</div>' : '';

			} else {

				$bio_format = $bio;

			}

			$accepted_single_tags  = $default_tags;
			$replace_single_values = apply_filters( 'rcode_replace_single_values_filter', array( $name, $name_slug, $photo_url, $title, $email_nolink, $phone,$address, $bio, $fb_url, $tw_url ), $post->ID );

			$accepted_formatted_tags  = $default_formatted_tags;
			$replace_formatted_values = apply_filters( 'rcode_replace_formatted_values_filter', array( $name_formatted, $title_formatted, $photo, $email_mailto, $bio_format ), $post->ID );

			$loop_markup = str_replace( $accepted_single_tags, $replace_single_values, $loop_markup );
			$loop_markup = str_replace( $accepted_formatted_tags, $replace_formatted_values, $loop_markup );

			$output .= apply_filters( 'rcode_single_loop_markup_filter', $loop_markup, $post->ID );

			$loop_markup = $loop_markup_reset;



			$output .= '</div> <!-- Close service-member -->';
			$i++;


		endwhile;

		$output .= '</div> <!-- Close service-member-listing -->';

		wp_reset_postdata();

	endif;

	$output = $style_output . $output;

	$rcode_sc_output = do_shortcode( $output );
