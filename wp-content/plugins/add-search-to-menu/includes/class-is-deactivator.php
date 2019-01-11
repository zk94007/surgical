<?php
/**
 * Fires during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    IS
 * @subpackage IS/includes
 * @author     Ivory Search <admin@ivorysearch.com>
 */

class IS_Deactivator {

	/**
	 * The code that runs during plugin deactivation.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		$is = Ivory_Search::getInstance();

		if ( isset( $is->opt['is_notices']['config'] ) ) {
			$is_notices = get_option( 'is_notices', array() );
			unset( $is_notices['is_notices']['config'] );
			update_option( 'is_notices', $is_notices );
		}
	}
}
