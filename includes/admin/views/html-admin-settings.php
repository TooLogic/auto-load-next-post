<?php
/**
 * Admin View: Settings
 *
 * @since    1.0.0
 * @version  1.6.0
 * @author   Sébastien Dumont
 * @category Admin
 * @package  Auto Load Next Post/Admin/Views
 * @license  GPL-2.0+
 * @global   string $current_section
 * @global   string $current_tab
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $current_section, $current_tab;

$tab_exists        = isset( $tabs[ $current_tab ] ) || has_action( 'auto_load_next_post_sections_' . $current_tab ) || has_action( 'auto_load_next_post_settings_' . $current_tab ) || has_action( 'auto_load_next_post_settings_tabs_' . $current_tab );
$current_tab_label = isset( $tabs[ $current_tab ] ) ? $tabs[ $current_tab ] : '';

if ( ! $tab_exists ) {
	wp_safe_redirect( admin_url( 'options-general.php?page=auto-load-next-post-settings' ) );
	exit;
}
?>
<div class="wrap auto-load-next-post">
	<form method="post" id="mainform" action="" enctype="multipart/form-data">
		<nav class="nav-tab-wrapper">
			<?php
				foreach ( $tabs as $slug => $label ) {
					$url = add_query_arg( array(
						'page' => 'auto-load-next-post-settings',
						'tab'  => esc_attr( $slug ),
					), admin_url( 'options-general.php' ) );

					echo '<a href="' . esc_html( $url ) . '" class="nav-tab ' . ( $current_tab === $slug ? 'nav-tab-active' : '' ) . '">' . esc_html( $label ) . '</a>';
				}

				do_action( 'auto_load_next_post_settings_tabs' );
			?>
		</nav>
		<h1 class="screen-reader-text"><?php echo esc_html( $current_tab_label ); ?></h1>
		<?php
		do_action( 'auto_load_next_post_sections_' . $current_tab );

		self::show_messages();

		do_action( 'auto_load_next_post_settings_' . $current_tab );
		?>
		<p class="submit">
			<?php submit_button( esc_attr__( 'Save Changes', 'auto-load-next-post' ), 'button-primary', esc_attr__( 'Save Changes', 'auto-load-next-post' ), false, array( 'id' => 'save' ) ); ?>
			<?php wp_nonce_field( 'auto-load-next-post-settings' ); ?>
		</p>
	</form>

	<div class="alnp-sidebar">
		<?php do_action( 'auto_load_next_post_sidebar', $current_tab ); ?>
	</div>
</div>
