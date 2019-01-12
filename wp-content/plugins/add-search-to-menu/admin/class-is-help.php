<?php

class IS_Help {

	private $screen;

	public function __construct( WP_Screen $screen ) {
		$this->screen = $screen;
	}

	public function set_help_tabs( $type ) {
		switch ( $type ) {
			case 'list':
				$this->screen->add_help_tab( array(
					'id'	  => 'list_overview',
					'title'   => __( 'Overview', 'ivory-search' ),
					'content' => $this->content( 'list_overview' ) ) );

				$this->screen->add_help_tab( array(
					'id'	  => 'list_available_actions',
					'title'	  => __( 'Available Actions', 'ivory-search' ),
					'content' => $this->content( 'list_available_actions' ) ) );

				$this->sidebar();

				return;
			case 'edit':
				$this->screen->add_help_tab( array(
					'id'	  => 'edit_overview',
					'title'	  => __( 'Overview', 'ivory-search' ),
					'content' => $this->content( 'edit_overview' ) ) );

				$this->screen->add_help_tab( array(
					'id'	  => 'includes',
					'title'	  => __( 'Includes', 'ivory-search' ),
					'content' => $this->content( 'includes' ) ) );

				$this->screen->add_help_tab( array(
					'id'	  => 'excludes',
					'title'   => __( 'Excludes', 'ivory-search' ),
					'content' => $this->content( 'excludes' ) ) );

				$this->screen->add_help_tab( array(
					'id'	  => 'edit_settings',
					'title'   => __( 'Options', 'ivory-search' ),
					'content' => $this->content( 'edit_settings' ) ) );

				$this->sidebar();

				return;
			case 'settings':
				$this->screen->add_help_tab( array(
					'id'	  => 'settings_overview',
					'title'	  => __( 'Overview', 'ivory-search' ),
					'content' => $this->content( 'settings_overview' ) ) );

				$this->screen->add_help_tab( array(
					'id'	  => 'search_to_menu',
					'title'	  => __( 'Menu Search', 'ivory-search' ),
					'content' => $this->content( 'search_to_menu' ) ) );

				$this->screen->add_help_tab( array(
					'id'	  => 'settings',
					'title'   => __( 'Settings', 'ivory-search' ),
					'content' => $this->content( 'settings' ) ) );

				$this->sidebar();

				return;
		}
	}

	private function content( $name ) {
		$content = array();

		$content['list_overview'] = '<p>' . __( "On this screen, you can manage search forms provided by Ivory Search plugin. You can create and manage an unlimited number of search forms. Each search form has a unique ID and search form shortcode ([ivory-search ...]). To insert a search form into a post or a text widget, insert the shortcode into the target.", 'ivory-search' ) . '</p>';

		$content['list_available_actions'] = '<p>' . __( "Hovering over a row in the search forms list will display action links that allow you to manage your search form. You can perform the following actions:", 'ivory-search' ) . '</p>';
		$content['list_available_actions'] .= '<p>' . __( "<strong>Edit</strong> - Navigates to the editing screen for that search form. You can also reach that screen by clicking on the search form title.", 'ivory-search' ) . '</p>';
		$content['list_available_actions'] .= '<p>' . __( "<strong>Duplicate</strong> - Clones that search form. A cloned search form inherits all content from the original, but has a different ID.", 'ivory-search' ) . '</p>';
		$content['list_available_actions'] .= '<p>' . __( "<strong>Delete</strong> - Deletes the search form. The search form gets deleted permanently and its shortcode becomes void so you have to remove the shortcode if you have used it anywhere.", 'ivory-search' ) . '</p>';

		$content['edit_overview'] = '<p>' . __( "On this screen, you can edit a search form. A search form is comprised of the following components:", 'ivory-search' ) . '</p>';
		$content['edit_overview'] .= '<p>' . __( "<strong>Title</strong> is the title of a search form. This title is only used for labeling a search form, and can be edited.", 'ivory-search' ) . '</p>';
		$content['edit_overview'] .= '<p>' . __( "<strong>Includes</strong> provides options to control which content on the site is searchable.", 'ivory-search' ) . '</p>';
		$content['edit_overview'] .= '<p>' . __( "<strong>Excludes</strong> provides options to exclude specific content from the search on the site.", 'ivory-search' ) . '</p>';
		$content['edit_overview'] .= '<p>' . __( "<strong>Options</strong> provides a place where you can customize overall behavior of this search form.", 'ivory-search' ) . '</p>';

		$content['includes'] = '<p>' . __( "Control here which content you want to make searchable using this search form.", 'ivory-search' ) . '</p>';

		$content['excludes'] = '<p>' . __( "Configure the options here to exclude specific content from search perfomed using this search form.", 'ivory-search' ) . '</p>';

		$content['edit_settings'] = '<p>' . __( "Control here the overall behaviour of this search form.", 'ivory-search' ) . '</p>';

		$content['settings_overview'] = '<p>' . __( "On this screen, you can manage search added in the site navgation menu and configure settings that will affect all search forms and search functionality on the site. The settings screen comprised of the following sections:", 'ivory-search' ) . '</p>';
		$content['settings_overview'] .= '<p>' . __( "<strong>Menu Search</strong> provides a place where you can customize the behavior of search form added in the site navgation menu.", 'ivory-search' ) . '</p>';
		$content['settings_overview'] .= '<p>' . __( "<strong>Settings</strong> provides options to configure sitewide search functionality.", 'ivory-search' ) . '</p>';

		$content['search_to_menu'] = '<p>' . __( "Cofigure the options in this section to manage search added in the site navigation menu.", 'ivory-search' ) . '</p>';

		$content['settings'] = '<p>' . __( "Configure options in this section to manage sitewide search functionality.", 'ivory-search' ) . '</p>';

		if ( ! empty( $content[$name] ) ) {
			return $content[$name];
		}
	}

	public function sidebar() {
		$content  = '<p><strong>' . __( 'For more information:', 'ivory-search' ) . '</strong></p>';
		$content .= '<p><a href="https://ivorysearch.com/documentation/" target="_blank">' . __( 'Docs', 'ivory-search' ) . '</a></p>';
		$content .= '<p><a href="https://ivorysearch.com/support/" target="_blank">' . __( 'Support', 'ivory-search' ) . '</a></p>';
		$content .= '<p><a href="https://wordpress.org/support/plugin/add-search-to-menu/reviews/?filter=5#new-post" target="_blank">' . __( 'Give us a rating', 'ivory-search' ) . '</a></p>';

		$this->screen->set_help_sidebar( $content );
	}

	public static function help_info( $content ) { ?>
		<span class="is-help">
			<i class="dashicons dashicons-warning"></i>
			<span class="is-info">
				<?php echo $content; ?>
			</span>
		</span>
	<?php	
	}
}
