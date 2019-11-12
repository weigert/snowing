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
