<?php
/**
 * Plugin Name: Horizontal Admin Menu
 * Plugin URI: http://wordpress.org/extend/plugins/horizontal-admin-menu/
 * Description: Allows you to move your existing WordPress admin menu to the top of the screen. Existing submenus show as drop-down menus when you mouse over a top level menu. Alters existing WordPress styles so the menus match the default admin theme.
 * Version: 1.0
 * Author: Eddie Krebs
 * Author URI: http://profiles.wordpress.org/users/ekrebs
 * License: GPLv2 or later
 */

/**
 * Inserts the new admin styles into the page
 *
 * Note that this code inserts the styles directly into the HEAD, rather than a link to
 * an external stylesheet. This is because WP uses load-styles.php to insert its admin
 * styles, which loads after any linked css files. Injecting the css directly will
 * allow you to override the existing styles. I don't like it either.
 *
 * @return void
 */
function ek_admin_styles() {
    if ( ! get_user_option( 'ek_admin_enable' ) )
        return;
    echo '<style type="text/css" media="all">' . PHP_EOL;
    include( dirname( __FILE__ ) . '/css/admin.css' );
    echo PHP_EOL . '</style>' . PHP_EOL;
}
add_action('admin_head', 'ek_admin_styles');


/**
 * Show the settings on the user profile screen used by this plugin.
 *
 * @return void
 */
function ek_admin_show_prefs() {
    ?>

	<h3>Horizontal Admin Menu</h3>

	<table class="form-table">

		<tr>
			<th scope="row">Enable/Disable</th>
			<td>
                <label for="ek-admin-enable">
				    <input type="checkbox" name="ek-admin-enable" id="ek-admin-enable" value="1" <?php
                    checked( true, get_user_option( 'ek_admin_enable' ), true )
                    ?> />
                    Move your admin menu to the top of the screen
                </label>
			</td>
		</tr>
	</table>

    <?php
}
add_action( 'show_user_profile', 'ek_admin_show_prefs' );
add_action( 'edit_user_profile', 'ek_admin_show_prefs' );

/**
 * Save user preferences
 *
 * @param $user_id
 * @return bool
 */
function ek_admin_save_prefs( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) )
		return false;

	update_user_option( $user_id, 'ek_admin_enable', $_POST['ek-admin-enable'] );
	return true;
}
add_action( 'personal_options_update', 'ek_admin_save_prefs' );
add_action( 'edit_user_profile_update', 'ek_admin_save_prefs' );

?>
