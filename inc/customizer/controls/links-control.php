<?php
/**
 * Theme Links Control for the Customizer
 *
 * @package Palm Beach
 */

/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays the theme links in the Customizer.
	 */
	class Palm_Beach_Customize_Links_Control extends WP_Customize_Control {
		/**
		 * Render Control
		 */
		public function render_content() {
			?>

			<div class="theme-links">

				<span class="customize-control-title"><?php esc_html_e( 'Theme Links', 'palm-beach' ); ?></span>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/themes/palm-beach/', 'palm-beach' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=palm-beach&utm_content=theme-page" target="_blank">
						<?php esc_html_e( 'Theme Page', 'palm-beach' ); ?>
					</a>
				</p>

				<p>
					<a href="http://preview.themezee.com/?demo=palm-beach&utm_source=customizer&utm_campaign=palm-beach" target="_blank">
						<?php esc_html_e( 'Theme Demo', 'palm-beach' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/docs/palm-beach-documentation/', 'palm-beach' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=palm-beach&utm_content=documentation" target="_blank">
						<?php esc_html_e( 'Theme Documentation', 'palm-beach' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/changelogs/?action=themezee-changelog&type=theme&slug=palm-beach/', 'palm-beach' ) ); ?>" target="_blank">
						<?php esc_html_e( 'Theme Changelog', 'palm-beach' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/palm-beach/reviews/', 'palm-beach' ) ); ?>" target="_blank">
						<?php esc_html_e( 'Rate this theme', 'palm-beach' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;
