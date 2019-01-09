<?php

//Enqueue Google fonts
add_action( 'wp_head', 'antreas_styling_fonts', 20 );
function antreas_styling_fonts() {
	//antreas_fonts( apply_filters( 'antreas_font_body', antreas_get_option( 'type_body' ) ), antreas_get_option( 'type_body_variants' ) );
}


// Registers all widget areas
add_action( 'widgets_init', 'antreas_init_sidebar' );
function antreas_init_sidebar() {

	register_sidebar(
		array(
			'name'          => __( 'Default Widgets', 'antreas' ),
			'id'            => 'primary-widgets',
			'description'   => __( 'Sidebar shown in all standard pages by default.', 'antreas' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title heading">',
			'after_title'   => '</div>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Secondary Widgets', 'antreas' ),
			'id'            => 'secondary-widgets',
			'description'   => __( 'Shown in pages with more than one sidebar.', 'antreas' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title heading">',
			'after_title'   => '</div>',
		)
	);

	$footer_columns = 3;
	for ( $count = 1; $count <= $footer_columns; $count++ ) {
		register_sidebar(
			array(
				'id'            => 'footer-widgets-' . $count,
				'name'          => __( 'Footer Widgets', 'antreas' ) . ' ' . $count,
				'description'   => __( 'Shown in the footer area.', 'antreas' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title heading">',
				'after_title'   => '</div>',
			)
		);
	}
}


//Registers all menu areas
add_action( 'widgets_init', 'antreas_init_menu' );
function antreas_init_menu() {
	register_nav_menus( array( 'top_menu' => __( 'Top Menu', 'antreas' ) ) );
	register_nav_menus( array( 'main_menu' => __( 'Main Menu', 'antreas' ) ) );
	register_nav_menus( array( 'footer_menu' => __( 'Footer Menu', 'antreas' ) ) );
	register_nav_menus( array( 'mobile_menu' => __( 'Mobile Menu', 'antreas' ) ) );
}
