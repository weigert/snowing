<?php
/**
* Plugin Name: VCS Snowing
* Plugin URI:
* Description: Create a simple snow overlay canvas for your wordpress website.
* Version: 1.0
* Author: Nicholas McDonald
* Author URI: https://weigert.vsos.ethz.ch/
**/

//Add the Tools Page for Toggling Activity
add_action('admin_menu', 'snowing_add_toolpage');

function snowing_add_toolpage(){
	//Add the Management Page Callback
	add_management_page( 'Snowing', 'Snowing', 'manage_options', __FILE__, 'snowing_tool_page');

	//Add the Plugin Settings
	add_action( 'admin_init', 'snowing_register_settings' );
}

function snowing_register_settings(){
	//Register the Checkbox
	register_setting( 'snowing-settings-group', 'snowing_active' );
}

function snowing_tool_page(){?>
	<div class = "snowing_tool_container">
		<h2> Activate the Snowing Overlay?</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'snowing-settings-group' ); ?>
    			<?php do_settings_sections( 'snowing-settings-group' ); ?>
			<input type="checkbox" name="snowing_active" value="1" <?php echo (esc_attr(get_option('snowing_active')) == "1")?"checked":"";?>/>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

//Load the Script if Active
if(esc_attr(get_option('snowing_active')) == "1") require_once('overlay.php');
