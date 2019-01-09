<?php
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class Antreas_Customize_Selectize_Control extends WP_Customize_Control {

	public function enqueue() {
		wp_enqueue_script( 'antreas-selectize-control', ANTREAS_ASSETS_JS . 'customizer-controls/selectize-control.js', array( 'jquery', 'customize-controls', 'antreas-selectize' ), ANTREAS_VERSION );
	}

	public function to_json() {
		parent::to_json();
		$this->json['attributes'] = $this->input_attrs;
	}

	public function render_content() {
		?>
		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
		</span>

		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<?php
		$options = array();

		if ( $this->choices === 'all' ) {

			$options = array(
				'all'                 => __( 'All', 'antreas' ),
				'homepage'            => __( 'Homepage', 'antreas' ),
				'all_posts'           => __( 'All posts', 'antreas' ),
				'all_pages'           => __( 'All pages', 'antreas' ),
				'all_portfolio_items' => __( 'All portfolio items', 'antreas' ),
				'all_services'        => __( 'All services', 'antreas' ),
				'404_page'            => __( '404 page', 'antreas' ),
				'archive'             => __( 'Archive page', 'antreas' ),
				'search'              => __( 'Search page', 'antreas' ),
			);

			foreach ( $this->value() as $value ) :
				if ( ! isset( $options[ $value ] ) ) {
					$options[ $value ] = '#' . $value;
				}
			endforeach;
		}

		if ( $this->choices === 'pages' ) {

			$posts = wp_cache_get( 'antreas_pages' );
			if ( $posts === false ) {
				$args = array(
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'posts_per_page' => -1,
				);
				$query = new WP_Query( $args );

				wp_cache_set( 'antreas_pages', $query->posts );
				$posts = $query->posts;
			}

			foreach ( $posts as $post ) :
				$options[ $post->ID ] = $post->post_title;
			endforeach;
		}
		?>

		<select id="<?php echo esc_attr( $this->id ); ?>" multiple class="demo-default" placeholder="<?php esc_html_e( 'select pages...', 'antreas' ); ?>">
			<?php foreach ( $options as $value => $name ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php echo in_array( $value, $this->value() ) ? 'selected' : ''; ?> ><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>

		<?php
	}
}
