<?php
/**
 * Represents the view for the plugin settings page.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user to configure plugin settings.
 *
 * @package IS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exits if accessed directly.
}
?>

<div class="wrap">

	<h1 class="wp-heading-inline">
		<span class="is-search-image"></span>
		<?php esc_html_e( 'Ivory Search Settings', 'ivory-search' ); ?>
	</h1>

	<hr class="wp-header-end">

	<?php do_action( 'is_admin_notices' ); ?>
	<?php settings_errors(); ?>

		<div id="poststuff">
		<div id="search-body" class="metabox-holder columns-2">
			<form id="ivory_search_options" action="options.php" method="post">
			<div id="searchtbox-container-1" class="postbox-container">
			<div id="search-form-editor">
			<?php
				settings_fields( 'ivory_search' );

				$panels = array(
						'menu-search' => array(
								'menu-search',
								'Menu Search',
						),
						'settings' => array(
								'settings',
								'Settings',
						)
				);

				echo '<ul id="search-form-editor-tabs">';

				$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'menu-search';
				$url = esc_url( menu_page_url( 'ivory-search-settings', false ) );

				foreach ( $panels as $id => $panel ) {
					$class = ( $tab == $id ) ? 'active' : '';
					echo sprintf( '<li id="%1$s-tab" class="%2$s"><a href="%3$s">%4$s</a></li>',
						esc_attr( $panel[0] ), esc_attr( $class ), $url . '&tab=' . $panel[0], esc_html( $panel[1] ) );
				}

				echo '</ul>';

				$settings_fields = IS_Settings_Fields::getInstance();

				if ( 'menu-search'  == $tab ) {
					$settings_fields->is_do_settings_sections( 'ivory_search', 'ivory_search_section' );
				} else if ( 'settings' ==  $tab ) {
					$settings_fields->is_do_settings_sections( 'ivory_search', 'ivory_search_settings' );
				}

			?>
			</div><!-- #search-form-editor -->

			<?php if ( current_user_can( 'is_edit_search_form' ) ) :
				submit_button( 'Save', 'primary', 'ivory_search_options_submit' );
			endif; ?>

			</div><!-- #searchtbox-container-1 -->
			<div id="searchtbox-container-2" class="postbox-container">
				<?php if ( current_user_can( 'is_edit_search_form' ) ) : ?>
				<div id="submitdiv" class="searchbox">
					<div class="inside">
						<div class="submitbox" id="submitpost">
							<div id="major-publishing-actions">
								<div id="publishing-action">
									<span class="spinner"></span>
									<?php submit_button( 'Save', 'primary', 'ivory_search_options_submit', false ); ?>
								</div>
								<div class="clear"></div>
							</div><!-- #major-publishing-actions -->
						</div><!-- #submitpost -->
					</div>
				</div><!-- #submitdiv -->
				<?php endif; ?>

				<div id="informationdiv" class="searchbox">
					<h3><?php echo esc_html( __( 'Information', 'ivory-search' ) ); ?></h3>
					<div class="inside">
						<ul>
							<li><a href="https://ivorysearch.com/documentation/" target="_blank"><?php _e( 'Docs', 'ivory-search' ); ?></a></li>
							<li><a href="https://ivorysearch.com/support/" target="_blank"><?php _e( 'Support', 'ivory-search' ); ?></a></li>
							<li><a href="https://ivorysearch.com/contact/" target="_blank"><?php _e( 'Contact', 'ivory-search' ); ?></a></li>
							<li><a href="https://wordpress.org/support/plugin/add-search-to-menu/reviews/?filter=5#new-post" target="_blank"><?php _e( 'Give us a rating', 'ivory-search' ); ?></a></li>
						</ul>
					</div>
				</div><!-- #informationdiv -->
			</div><!-- #searchtbox-container-2 -->
			</form>
		</div><!-- #post-body -->
		<br class="clear" />
		</div><!-- #poststuff -->

</div><!-- .wrap -->

<?php do_action( 'is_admin_footer' );