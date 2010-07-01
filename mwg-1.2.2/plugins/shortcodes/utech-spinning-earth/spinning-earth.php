<?php
/*
Plugin Name: Utech Spinning Earth
Plugin URI: http://www.utechworld.com/projects/spinning-earth-for-wp/
Description: Insert a great looking spinning earth with shortcode. For more details and  <a href="http://wordpress.org/extend/plugins/utech-spinning-earth/#compatibility">to rate</a> this plugin please go to the <a href="http://wordpress.org/extend/plugins/utech-spinning-earth/">plugin page</a>. Enjoy!
Version:  1.1
Author: Meini
Author URI: http://www.utechworld.com
License: GPL2
*/

/*  Copyright 2010  Meini  (http://www.utechworld.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// [SpinningEarth]
 


function spinningEarth_func($atts) {
	extract(shortcode_atts(array(
		'size' => '200',
		'color' => 'FFFFFF',
		'wrap' => 'none',
		'url' => 'http://www.utechworld.com/spinning-earth/',
		'brightness' => '50'
	), $atts));
	//get plugin folder
	$folder = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); 
	$ext = ".swf";
	$moviename = "spinning-earth";

	//only left, right or none allowed for float style
	$divtxt = 'div';
	switch ($wrap) {
		case 'left':
			$divtxt = '<div style="float: left">';
			break;
		case 'right':
			$divtxt = '<div style="float: right">';
			break;
		case 'center':
		case 'centre':
			$divtxt = '<div style="text-align: center">';
			break;
		default:
			$divtxt = '<div>';
	}

	//create flash html
	$result= $divtxt . '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
	codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" 
	WIDTH="'.$size .'" HEIGHT="' . $size . '" 
	id="'. $moviename .'">
	<PARAM NAME=movie VALUE="' . $folder . $moviename . $ext . '">
	<PARAM NAME=quality VALUE=high>
	<PARAM NAME=bgcolor VALUE=#' . $color . '>
	<param name="Flashvars" value="url='. $url .'&amp;brightness=' . $brightness .'">
	<EMBED src="' . $folder . $moviename . $ext . '" quality=high bgcolor=#' . $color . ' 
	WIDTH="' .$size .'" HEIGHT="' . $size . '" 
	NAME="'. $moviename .'" 
	ALIGN="" TYPE="application/x-shockwave-flash" 
	flashvars="url='. $url .'&amp;brightness=' . $brightness .'" 
	PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
	</EMBED></OBJECT></div> ';


	return ($result);
	}

add_shortcode('spinningearth', 'spinningEarth_func');

?>