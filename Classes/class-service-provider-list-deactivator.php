<?php
/**
 *  plugin deactivation
 */
class Service_Provider_List_Deactivator {
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
