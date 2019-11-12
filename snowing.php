<?php
/**
* Plugin Name: VCS Snowing
* Plugin URI:
* Description: Create a simple snow overlay canvas for your wordpress website.
* Version: 2.0
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
	register_setting( 'snowing-settings-group', 'snowing_frontpage' );
}

function snowing_tool_page(){?>
	<div class = "snowing_tool_container">
		<h1> Snowing Overlay </h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'snowing-settings-group' ); ?>
    			<?php do_settings_sections( 'snowing-settings-group' ); ?>
		<div class = "snowing_tool_option">
			<h2 class="snowing"> Activate the snowing overlay?</h2>
			<input class="snowing" type="checkbox" name="snowing_active" value="1" <?php echo (esc_attr(get_option('snowing_active')) == "1")?"checked":"";?>/>
		</div>
		<div class = "snowing_tool_option">
			<h2 class="snowing"> Only show on front page?</h2>
			<input class="snowing" type="checkbox" name="snowing_frontpage" value="1" <?php echo (esc_attr(get_option('snowing_frontpage')) == "1")?"checked":"";?>/>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

function add_snowing_style(){
  $plugin_url = plugin_dir_url(__FILE__);
  wp_enqueue_style('snowing_style', $plugin_url.'style.css', array(), '1.0', 'all');
}

function add_snowing_script(){
  $plugin_url = plugin_dir_url(__FILE__);
  wp_register_script('snowing_script', $plugin_url.'snowing.js', array('jquery'), NULL, true);

  if(esc_attr(get_option('snowing_active')) == "1"){
    if(esc_attr(get_option('snowing_frontpage')) == "1" && is_front_page()){
      wp_enqueue_script('snowing_script' );
    }
    else if(esc_attr(get_option('snowing_frontpage')) != "1"){
      wp_enqueue_script('snowing_script' );
    }
  }
}

//Enqueue the Script Loader for Backend and Frontend!
add_action( 'wp_enqueue_scripts', 'add_snowing_script' );
add_action( 'wp_enqueue_scripts', 'add_snowing_style' );
add_action( 'admin_enqueue_scripts', 'add_snowing_style' ); //Only add the Style to the Backend!

//Make the snowing effect visible in the backend
//  add_action( 'admin_enqueue_scripts', 'add_snowing_script' );

