<?php
/**
 * plugin activation
 */
class Service_Provider_List_Activator {
	public static function activate( $is_forced = false ) {
		$default_template = '
		[service_loop]
			<img class="service-member-photo" src="[service-photo-url]" alt="[service-name] : [service-position]">
			<div class="service-member-info-wrap">
				[service-name-formatted]
				[service-position-formatted]
				[service-bio-formatted]
				[service-email-link]
			</div>
		[/service_loop]';

		$default_css = '
			/*  div wrapped around entire service list  */
			div.service-member-listing {
			}
			/*  div wrapped around each service member  */
			div.service-member {
				padding-bottom: 2em;
				border-bottom: thin dotted #aaa;
			}
			/*  "Even" service member  */
			div.service-member.even {
			}
			/*  "Odd" service member  */
			div.service-member.odd {
				margin-top: 2em;
			}
			/*  Last service member  */
			div.service-member.last {
				padding-bottom: 0;
				border: none;
			}
			/*  Wrap around service info  */
			.service-member-info-wrap {
				float: left;
				width: 70%;
				margin-left: 3%;
			}
			/*  [service-bio-formatted]  */
			div.service-member-bio {
			}
			/*  p tags within [service-bio-formatted]  */
			div.service-member-bio p {
			}
			/*  [service-photo]  */
			img.service-member-photo {
				float: left;
			}
			/*  [service-email-link]  */
			.service-member-email {
			}
			/*  [service-name-formatted]  */
			div.service-member-listing h3.service-member-name {
				margin: 0;
			}
			/*  [service-position-formatted]  */
			div.service-member-listing h4.service-member-position {
				margin: 0;
				font-style: italic;
			}
			/* Clearfix for div.service-member */
			div.service-member:after {
				content: "";
				display: block;
				clear: both;
			}
			/* Clearfix for <= IE7 */
			* html div.service-member { height: 1%; }
			div.service-member { display: block; }
		';

		$default_tags       = array(
			'[service-name]',
			'[service-name-slug]',
			'[service-photo-url]',
			'[service-position]',
			'[service-email]',
			'[service-phone]',
			'[service-address]',
			'[service-bio]',
			'[service-facebook]',
			'[service-twitter]',
		);
		$default_tag_string = implode( ', ', $default_tags );

		$default_formatted_tags       = array(
			'[service-name-formatted]',
			'[service-position-formatted]',
			'[service-photo]',
			'[service-email-link]',
			'[service-bio-formatted]',
		);
		$default_formatted_tag_string = implode( ', ', $default_formatted_tags );

		$default_slug          = 'service-members';
		$default_name_singular = _x( 'Service Provider Member', 'post type singular name', 'service-provider-list' );
		$default_name_plural   = _x( 'Service Provider Members', 'post type general name', 'service-provider-list' );
		update_option( '_service_listing_default_tags', $default_tags );
		update_option( '_service_listing_default_tag_string', $default_tag_string );
		update_option( '_service_listing_default_formatted_tags', $default_formatted_tags );
		update_option( '_service_listing_default_formatted_tag_string', $default_formatted_tag_string );
		update_option( '_service_listing_default_html', $default_template );
		update_option( '_service_listing_default_css', $default_css );
		update_option( '_service_listing_default_slug', $default_slug );
		update_option( '_service_listing_default_name_singular', $default_name_singular );
		update_option( '_service_listing_default_name_plural', $default_name_plural );

		if ( ! get_option( '_service_listing_custom_html' ) ) {
			update_option( '_service_listing_custom_html', $default_template );
		}

		$filename = get_stylesheet_directory() . '/service-provider-list-custom.css';

		if ( ! get_option( '_service_listing_custom_css' ) && ! file_exists( $filename ) ) {
			update_option( '_service_listing_custom_css', get_option( '_service_listing_default_css' ) );
		} elseif ( file_exists( $filename ) ) {
			$custom_css = file_get_contents( $filename );
			update_option( '_service_listing_custom_css', $custom_css );
		}
		if ( ! get_option( '_service_listing_custom_slug' ) ) {
			update_option( '_service_listing_custom_slug', $default_slug );
		}
		if ( ! get_option( '_service_listing_custom_name_singular' ) ) {
			update_option( '_service_listing_custom_name_singular', $default_name_singular );
		}
		if ( ! get_option( '_service_listing_custom_name_plural' ) ) {
			update_option( '_service_listing_custom_name_plural', $default_name_plural );
		}

		// Maybe add flag to signal the need to flush the rewrite rules.
		if ( ! get_option( '_service_listing_flush_rewrite_rules_flag' ) ) {

			add_option( '_service_listing_flush_rewrite_rules_flag', true );

		}
	}

}
