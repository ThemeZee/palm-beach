<?php
/**
 * Main Navigation
 *
 * @version 1.0
 * @package Palm Beach
 */
?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>

	<button class="primary-menu-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false" <?php palm_beach_amp_menu_toggle(); ?>>
		<?php
		echo palm_beach_get_svg( 'menu' );
		echo palm_beach_get_svg( 'close' );
		?>
		<span class="menu-toggle-text screen-reader-text"><?php esc_html_e( 'Menu', 'palm-beach' ); ?></span>
	</button>

	<div class="primary-navigation">

		<nav id="site-navigation" class="main-navigation" role="navigation" <?php palm_beach_amp_menu_is_toggled(); ?> aria-label="<?php esc_attr_e( 'Primary Menu', 'palm-beach' ); ?>">

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
				)
			);
			?>
		</nav><!-- #site-navigation -->

	</div><!-- .primary-navigation -->

<?php endif; ?>

<?php do_action( 'palm_beach_after_navigation' ); ?>
