<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Features
 */

$features = array(
	'slider-options'    => array(
		'label'   => esc_html__( 'Improved Slider Options', 'antreas' ),
		'sub'     => esc_html__( 'Add more slides, control the appearance & position of slides.', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'woocommerce'       => array(
		'label'   => esc_html__( 'WooCommerce Support', 'antreas' ),
		'sub'     => esc_html__( 'Create a WooCommerce powered shop. Supports WooCommerce v3.x and upwards', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'reorder-sections'  => array(
		'label'   => esc_html__( 'Reorder Homepage Sections', 'antreas' ),
		'sub'     => esc_html__( 'Re-order your site\'s front-page sections in any way you want.', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'custom-colors'     => array(
		'label'   => esc_html__( 'Custom Color Schemes & Color Controls', 'antreas' ),
		'sub'     => esc_html__( 'Easily change your site\'s color schemes.', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'typography'        => array(
		'label'   => esc_html__( 'Custom Typography Controls', 'antreas' ),
		'sub'     => esc_html__( 'Want a different font family? No problem. Just an upgrade away.', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'other'        => array(
		'label'   => esc_html__( 'Other PRO goodies', 'antreas' ),
		'sub'     => esc_html__( 'Options for homepage animations, sticky header, social links, footer columns and many more.', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'tagline'           => array(
		'label'   => esc_html__( 'Extend the Tagline Section', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add images and buttons', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'features'          => array(
		'label'   => esc_html__( 'Extend the Features Section', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Section Description & Features Columns', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'about'          => array(
		'label'   => esc_html__( 'Extend the About Section', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Section Description & About Columns', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'portfolio'         => array(
		'label'   => esc_html__( 'Extend the Portfolio Section ', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Section Description, Portfolio Columns & Related Portfolio Images', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'services'          => array(
		'label'   => esc_html__( 'Extend the Services Section ', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Section Description and Services Columns', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'team'              => array(
		'label'   => esc_html__( 'Extend the Team Members Section', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Section Description and Team Columns', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'testimonials'      => array(
		'label'   => esc_html__( 'Extend the Testimonials Section ', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Section Description and Testimonials Columns', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'clients'           => array(
		'label'   => esc_html__( 'Extend the Clients Section ', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Description and Clients Columns', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'contact'          => array(
		'label'   => esc_html__( 'Extend the Contact Section', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a: Section Description & Contact Content', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'shortcode'          => array(
		'label'   => esc_html__( 'New Shortcode Section', 'antreas' ),
		'sub'     => esc_html__( 'By upgrading to the PRO version you\'ll be able to add a new Shortcode Section', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'dedicated-support' => array(
		'label'   => esc_html__( 'Dedicated Support Team', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-yes"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
	'security-updates'  => array(
		'label'   => esc_html__( 'Critical security updates ', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-yes"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),

	'featured-updates'  => array(
		'label'   => esc_html__( 'Future feature updates ', 'antreas' ),
		'lite'     => '<span class="dashicons dashicons-no-alt"></span>',
		'pro' => '<span class="dashicons dashicons-yes"></span></i>',
	),
);
?>
<div class="featured-section features">
	<table class="free-pro-table">
		<thead>
		<tr>
			<th></th>
			<th><?php _e( 'Lite', 'antreas' ); ?></th>
			<th><?php _e( 'PRO', 'antreas' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $features as $feature ) : ?>
			<tr>
				<td class="feature">
					<h3><?php echo $feature['label']; ?></h3>
					<?php if ( isset( $feature['sub'] ) ) : ?>
						<p><?php echo $feature['sub']; ?></p>
					<?php endif ?>
				</td>
				<td class="cpo-feature">
					<?php echo $feature['lite']; ?>
				</td>
				<td class="cpo-pro-feature">
					<?php echo $feature['pro']; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td></td>
			<td colspan="2" class="text-right">
				<a href="<?php echo esc_url_raw( antreas_upgrade_link( 'about-page' ) ); ?>" target="_blank" class="button button-primary button-hero"><span class="dashicons dashicons-cart"></span><?php _e( 'Get The Pro Version Now!', 'antreas' ); ?>
				</a></td>
		</tr>
		</tbody>
	</table>
</div>
