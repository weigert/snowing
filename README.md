# snowing
WP plugin to make it snow on your blog

# Installation
Drag the contents of this repository into a folder in your /wp-content/plugins folder. Then from the administration panel, you will be able to activate the plugin.

# Usage
The snowing overlay is not activated by default. To activate it, check the box in the Administration Panel -> Tools -> Snowing.

Then, it will be visible on all pages of your site.

This is not active for Internet Explorer and Mobile Phones (screens with a width < 600px). Feel free to change this.

# How it Works
The plugin handles the activation / deactivation of an html file that includes a stylesheet and some javascript.

The javascript spawns a canvas, which covers the entire window, without pointer events and a fixed position.

The canvas then spawns flakes which jitter randomly as they move down the screen. When they reach the bottom of the screen, they are deleted.

It also handles resizing.

# Example
Current live on my blog! https://weigert.vsos.ethz.ch

Originally written for https://vcs.ethz.ch

