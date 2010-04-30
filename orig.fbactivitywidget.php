<?php
/*
Plugin Name: Facebook Activity Widget for WordPress
Plugin Script: fbActivityWidget.php
Plugin URI: http://healyourchurchwebsite.com/2010/04/26/the-facebook-activity-widget-plugin-for-wordpress/
Description: Allows you to configure and display a FaceBook Activity Widget on the sidebar of your WordPress blog
Version: 0.1
License: GPL
Author: Dean Peters
Author URI: http://HealYourChurchWebsite.com/
Release Notes:
2010-04-22 - v0.1 - first version
* initial trunk & release

Helpful Resources:
* http://developers.facebook.com/docs/reference/plugins/activity
* http://wpengineer.com/wordpress-built-a-widget/
* http://www.cssnewbie.com/build-a-bare-bones-wordpress-2-8-widget/
* http://healyourchurchwebsite.com/2010/04/22/the-facebook-like-button-plugin-for-wordpress/

License:
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Online: http://www.gnu.org/licenses/gpl.txt

*/




function widget_fbactivity_init() {

	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control')) 
		return;

	function widget_fbactivity($args) {
	
		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);
		extract(get_option('widget_fbactivity'));		//		$options = get_option('widget_fbactivity');

		// Output
		//		echo '<iframe scrolling="no" frameborder="0" style="border: medium none; overflow: hidden; width: 200px; height: 300px;" allowtransparency="true" &amp;width="200&quot;&amp;height=300300&quot;&amp;header=true&quot;&amp;colorscheme=light&quot;&amp;font=arial&quot;&amp;border_color=%23cccccc&quot;&quot;" src="http://www.facebook.com/plugins/activity.php?site=healyourchurchwebsite.com"></iframe>';
		if ( !empty( $fbact_setting_widget_title ) ) { echo $before_title . $fbact_setting_widget_title . $after_title; };
		$fbact_param_site  = (!empty($fbact_param_site))? $fbact_param_site : get_bloginfo('url');
		$fbact_param_width  = (!empty($fbact_param_width))? $fbact_param_width : '180' ;
		$fbact_param_height  = (!empty($fbact_param_height)) ? $fbact_param_height : '300';
		$fbact_param_header  = (!empty($fbact_param_header)) ? $fbact_param_header : 'true';
		$fbact_param_colorscheme  = (!empty($fbact_param_colorscheme)) ? $fbact_param_colorscheme : 'light';
		$fbact_param_font  = (!empty($fbact_param_font)) ? $fbact_param_font : 'arial';
		$fbact_param_border_color  = (!empty($fbact_param_border_color)) ? $fbact_param_border_color : '%23cfcccc';
		$fbact_setting_css_class  = (!empty($fbact_setting_css_class))? $fbact_setting_css_class : 'fbActivityWidgetContainer' ;

		// build the iframe source string
		$fbact_iframe_src = "http://www.facebook.com/plugins/activity.php";
		$fbact_iframe_src .= "?site=".$fbact_param_site.'';
		$fbact_iframe_src .= "&amp;width=".$fbact_param_width.'';
		$fbact_iframe_src .= "&amp;height=".$fbact_param_height.'';
		$fbact_iframe_src .= "&amp;header=".$fbact_param_header.'';
		$fbact_iframe_src .= "&amp;colorscheme=".$fbact_param_colorscheme.'';
		$fbact_iframe_src .= "&amp;font=".$fbact_param_font.'';
		$fbact_iframe_src .= "&amp;border_color=".$fbact_param_border_color.'';
		?>
			<iframe 
				src="<?php echo $fbact_iframe_src ?>"  
				class="<?php echo $fbact_setting_css_class ?>"  
				scrolling="no"  
				frameborder="0"  
				allowTransparency="true"  
				style="border:none; overflow:hidden; width:<?php echo $fbact_param_width; ?>px; height:<?php echo $fbact_param_height; ?>px"> 
			</iframe>		
		<?php
		echo $after_widget;	
	}

	// Settings form
	function widget_fbactivity_control() {

		// Get options
		$options = get_option('widget_fbactivity');

		// options exist? if not set defaults
		if ( !is_array($options) ) {
			$options = array('fbact_setting_widget_title' => 'FB Activity Title', 
				'fbact_param_site' => 'healyourchurchwebsite.com', 
				'fbact_param_width' => '249', 
				'fbact_param_height' => '301', 
				'fbact_param_header' => 'true', 
				'fbact_param_colorscheme' => 'light', 
				'fbact_param_font' => 'arial', 
				'fbact_setting_css_class' => 'fbActivityWidgetContainer',
				'fbact_param_border_color' => 'black');
		}
		extract($options);		//		$options = get_option('widget_fbactivity');

		// form posted? ... do this instead of depending on the inherited update method (which was failing me)
		if ( $_POST['fbact-submit'] ) {
			// Remember to sanitize and format use input appropriately.
			$fbact_setting_widget_title = strip_tags(stripslashes($_POST['fbact_setting_widget_title']));
				$options['fbact_setting_widget_title'] = $fbact_setting_widget_title;
			$fbact_param_site = strip_tags(stripslashes($_POST['fbact_param_site']));
				$options['fbact_param_site'] = $fbact_param_site;
			$fbact_param_width = strip_tags(stripslashes($_POST['fbact_param_width']));
				$options['fbact_param_width'] = $fbact_param_width;
			$fbact_param_height = strip_tags(stripslashes($_POST['fbact_param_height']));
				$options['fbact_param_height'] = $fbact_param_height;
			$fbact_param_colorscheme = strip_tags(stripslashes($_POST['fbact_param_colorscheme']));
				$options['fbact_param_colorscheme'] = $fbact_param_colorscheme;
			$fbact_param_font = strip_tags(stripslashes($_POST['fbact_param_font']));
				$options['fbact_param_font'] = $fbact_param_font;
			$fbact_param_border_color = strip_tags(stripslashes($_POST['fbact_param_border_color']));
				$options['fbact_param_border_color'] = $fbact_param_border_color;
			$fbact_param_header = isset($_POST['fbact_param_header']);
				$options['fbact_param_header'] = $fbact_param_header;
			$fbact_setting_css_class = strip_tags(stripslashes($_POST['fbact_setting_css_class']));
				$options['fbact_setting_css_class'] = $fbact_setting_css_class;
				
			update_option('widget_fbactivity', $options);
		}

		// go ahead and armor the fields of input
		$fbact_setting_widget_title = htmlspecialchars($fbact_setting_widget_title, ENT_QUOTES);
		$fbact_param_site = htmlspecialchars($fbact_param_site, ENT_QUOTES);
		$fbact_param_width = htmlspecialchars($fbact_param_width, ENT_QUOTES);
		$fbact_param_height = htmlspecialchars($fbact_param_height, ENT_QUOTES);
		$fbact_param_header = $fbact_param_header ? 'checked="checked"' : '';
		$fbact_param_colorscheme = htmlspecialchars($fbact_param_colorscheme, ENT_QUOTES);
		$fbact_param_font = htmlspecialchars($fbact_param_font, ENT_QUOTES);
		$fbact_param_border_color = htmlspecialchars($fbact_param_border_color, ENT_QUOTES);
		$fbact_setting_css_class = htmlspecialchars($fbact_setting_css_class, ENT_QUOTES);
		
		// The form fields
		?>
		<style type="text/css" media="all">
			ul.fbactParamContainer li {clear: both;padding: 4px;}
			ul.fbactParamContainer label {width: 110px; text-align: right;display: block;float: left;padding: 4px 4px 0 0; margin: 0; font-size: 90%;}
			ul.fbactParamContainer input, ul.fbactParamContainer select { float: left; padding: 4px; margin: 0; font-size: 90%;}
			ul.fbactParamContainer input#fbact_param_header { margin-top: 8px; font-size: 90%;}
		</style>
		<?php 
		echo '<ul class="fbactParamContainer">';
		echo '<li>
				<label for="fbact_setting_widget_title">' . __('Widget Title') . '</label> 
				<input  id="fbact_setting_widget_title" name="fbact_setting_widget_title" size="30"  type="text" value="'.$fbact_setting_widget_title.'" />
				</li>';
		echo '<li>
				<label for="fbact_setting_css_class">' . __('iframe CSS Class') . '</label> 
				<input  id="fbact_setting_css_class" name="fbact_setting_css_class" size="30"  type="text" value="'.$fbact_setting_css_class.'" />
				</li>';

		echo '<li>
				<label for="fbact_param_site">' . __('Domain') . '</label> 
				<input  id="fbact_param_site" name="fbact_param_site" size="30" type="text" value="'.$fbact_param_site.'" />
				</label></li>';
		echo '<li>
				<label for="fbact_param_width">' . __('Width') . '</label> 
				<input  id="fbact_param_width" name="fbact_param_width" type="text" value="'.$fbact_param_width.'" />
				</li>';
		echo '<li>
				<label for="fbact_param_height">' . __('Height') . '</label> 
				<input  id="fbact_param_height" name="fbact_param_height" type="text" value="'.$fbact_param_height.'" />
				</li>';
		echo '<li>
				<label for="fbact_param_header">' . __('Show Header') . '</label> 
				<input class="checkbox" type="checkbox" '.$fbact_param_header.' id="fbact_param_header" name="fbact_param_header" />
				</li>';
		echo '<li>
				<label for="fbact_param_colorscheme">' . __('Sort Order:').'</label>';
				$fbact_colorscheme_array = array('light'=>'light','dark'=>'dark','evil'=>'evil');
				echo '<select id="fbact_param_colorscheme" name="fbact_param_colorscheme">';
				foreach($fbact_colorscheme_array as $fbact_text=>$fbact_value){
					echo '<option value="'.$fbact_value.'"';
					if ($fbact_value==$fbact_param_colorscheme){echo ' selected="selected"';}
					echo '>'.$fbact_text.'</option> ';
				}
				echo '</li>';
		echo '<li>
				<label for="fbact_param_font">' . __('Font').'</label>';
				$fbact_param_font_array = array('arial'=>'arial','lucida grande'=>'lucida grande','segoe ui'=>'segoe ui','tahoma'=>'tahoma','trebuchet ms'=>'trebuchet ms','verdana'=>'verdana');
				echo '<select id="fbact_param_font" name="fbact_param_font">';
				foreach($fbact_param_font_array as $fbact_text=>$fbact_value){
					echo '<option value="'.$fbact_value.'"';
					if ($fbact_value==$fbact_param_font){echo ' selected="selected"';}
					echo '>'.$fbact_text.'</option> ';
				}
				echo '</li>';
		echo '<li>
				<label for="fbact_param_border_color">' . __('Border Color') . '</label> 
				<input  id="fbact_param_border_color" name="fbact_param_border_color" type="text" value="'.$fbact_param_border_color.'" />
				</li>';

		echo '</ul>';
		echo '<input type="hidden" id="fbact-submit" name="fbact-submit" value="1" />';
	}
	
	// Register widget for use
	register_sidebar_widget(array('FaceBook Activity Widget', 'widgets'), 'widget_fbactivity');

	// Register settings for use, 300x500 pixel form
	register_widget_control(array('Facebook Activity Widget', 'widgets'), 'widget_fbactivity_control', 325, 300	);
}

// Run code and init
add_action('widgets_init', 'widget_fbactivity_init');

?>
