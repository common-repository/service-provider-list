<?php
/**
 * Define the internationalization functionality
 */
class Service_Provider_List_I18n {

	/**
	 * The domain specified for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {


	}

	/**
	 * Set the domain equal to that of the specified domain.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
