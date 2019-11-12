/*
Author: Nicholas McDonald
Created: 2. December 2016
Last Edited: - 12.11.2019 (Made into WordPress Plugin)
Version: 1.3
Description:
	Simple Javascript Canvas Overlay that lets it snow.
	Handles Window resizing, rejects internet explorer,
	handles mobile versions with CSS.
*/

//Setup jQuery
var $ = jQuery.noConflict();
$(startSnowing); 		//On Load, Start Snowing!
$(window).resize(recanvas);	//On Window Resize, Recanvas!

var flake = [];

function startSnowing() {
    snowing.start();
}

var snowing = {
    canvas : document.createElement("canvas"),
    start : function() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
        this.context = this.canvas.getContext("2d");
        this.frameNo = 0;
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        //Update Interval in Milliseconds
        this.interval = setInterval(updateGameArea, 20);
    },
    clear : function () {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
    stop : function() {
        clearInterval(this.interval);
    }
}

//Set the Class for CSS Rules
snowing.canvas.className = "snowing";

function recanvas(){
    //Reset the Canvas Size
    snowing.canvas.width = window.innerWidth;
    snowing.canvas.height = window.innerHeight;
}

function everyinterval(n) {
    if ((snowing.frameNo / n) % 1 == 0) {return true;}
    return false;
}

function component(width, height, color, x, y) {
    //Object Properties
    this.width = width;
    this.height = height;
    this.x = x;
    this.y = y;
    this.speedY = 1;

    //Update Function
    this.draw = function(){
        ctx = snowing.context;
        ctx.fillStyle = color;
  	ctx.fillRect(this.x, this.y, this.width, this.height);
    }
}

function updateGameArea() {
    //Update the Frame Number
    snowing.frameNo++;

    //Clear the Canvas
    snowing.clear();

    //Add new Flakes at Interval
    if (everyinterval(10)) flake.push(new component(5, 5, "#EEEEEE", (Math.random()*snowing.canvas.width)%snowing.canvas.width, 0));

    //Draw all Flakes
    for (i = 0; i < flake.length; i++) {
        flake[i].y += 3*Math.random();
        flake[i].x += Math.random()*2-1;
        flake[i].draw();
	//Remove guys that go too far.
	if(flake[i].y > snowing.canvas.height){ flake.splice(i, 1)
	i--;}
    }
}
root@weigert:/var/www/weigert/wordpress/wp-content/plugins/snowing# cat snowing.php
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

//Load the Script if Active
//function add_snowing_style(){
 // $plugin_url = plugin_dir_url(__FILE__);

//}

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
