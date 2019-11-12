# snowing
WP plugin to make it snow on your blog

# Installation
Drag the contents of this repository into a folder (e.g. "/snowing/") in your /wp-content/plugins/ folder. Then from the administration panel, you will be able to activate the plugin. That's it! Should work out of the box.

# Usage
The snowing overlay is not activated by default. To activate it, check the box in the Administration Panel -> Tools -> Snowing.

You can also select whether you want it visible on all pages, or only the homepage.

This is not active for Mobile Phones (screens with a width < 600px). Feel free to change this.

# How it Works
The plugin handles the activation / deactivation of an html file that includes a stylesheet and some javascript.

The javascript spawns a canvas, which covers the entire window, without pointer events and a fixed position.

The canvas then spawns flakes which jitter randomly as they move down the screen. When they reach the bottom of the screen, they are deleted.

It also handles resizing.

Edit: Previously, this had an issue with wordpress because I was including the javascript directly. The script and style are now properly enqueued, so that it doesn't have any conflicts with wordpress. Now also uses jQuery for event listening. I have to do this because of how wordpress works. Additionally, you can now choose whether you only want to display it on the front page, or on all pages.

By default, the snowing effect is deactivated in the wp-admin backend, but could be activated by adding an admin_enqueue_scripts callback at the bottom of snowing.php! Not sure why you would want this though.

# Example
Current live on my blog! https://weigert.vsos.ethz.ch

Originally written for https://vcs.ethz.ch

