<?php
/*
Plugin Name: wp-3wdoc-embed
Plugin URI: http://www.3wdoc.com/
Description: Create beautiful & interactive stories in the Cloud
Version: 0.1
Author: 3wdoc
Author URI: http://www.3wdoc.com/
*/

/*
Copyright 2012 3WDOC  (email : aide@3wdoc.com)

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

class Wp3wdocEmbed {
	
	private $pseudo_tag = "tag_3wdoc";
	private $plugin_dir_path = "";
	
	function Wp3wdocEmbed() {
		global $wpdb;
		$this->plugin_dir_path = plugin_dir_url(__FILE__);
		add_action('admin_print_footer_scripts',  array($this, "add_quicktag_plugin"));
		add_action("add_meta_boxes", array($this, "init_metaboxes"));
		add_action("save_post", array($this,"save_metaboxes"), 10, 2);
		add_shortcode($this->pseudo_tag , array($this,'add_snippet_content'));
		add_filter("mce_buttons", array(&$this, "add_tinymce_button"));
		add_filter('quicktags_settings', array(&$this, "add_quicktags_button"));
		add_filter('mce_external_plugins', array(&$this, "add_tinymce_plugin"));
		
	}//EOCo

	function mytheme_tinymce_config( $init ) {
	 $valid_iframe = 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]';
	 if ( isset( $init['extended_valid_elements'] ) ) {
	  $init['extended_valid_elements'] .= ',' . $valid_iframe;
	 } else {
	  $init['extended_valid_elements'] = $valid_iframe;
	 }
	
	 return $init;
	
	}
	
	function init_metaboxes() {
		add_meta_box("3wdoc-snippet", "Snippet 3wdoc", array($this,'build_metaboxes'), null, "side", "high");
		
	}//EOM
	
	function build_metaboxes() {
	    global $post;
		$meta = get_post_meta($post->ID, "3wdoc_snippet", true);
		$html.= '<table class="form-table">';
		$html.= '<tr>';
		$html.= '<th style="padding:2px">';
		$html.= '<label><strong>Insert this tag in your post:</strong></label>';
		$html.= '</th>';
		$html.= '</tr>';
		$html.= '<tr>';		
		$html.= '<th style="padding:2px">';
		$html.= '<i>['.$this->pseudo_tag.']</i>';
		$html.= '</th>';
		$html.= '</tr>';
		$html.= '<tr>';
		$html.= '<th style="padding:2px">';
		$html.= '<label><strong>Your snippet:</strong></label>';
		$html.= '</th>';
		$html.= '</tr>';
		$html.= '<tr>';
		$html.= '<th colspan="2" style="padding:2px">';
		$html.='<textarea name="3wdoc_snippet" cols="30" rows="10">'.$meta.'</textarea>';
		$html.= '</th>';
		$html.= '</tr>';
		$html.= '<tr>';
		$html.= '<th colspan="2" style="padding:2px">';
		$html.='<span style="font-family :Georgia, Times, sans-serif;font-size : 12px;color:#606060;font-weight:bold;"><i>You do not have an account on 3WDOC?</i></span>';
		$html.= '</th>';
		$html.= '</tr>';
		$html.= '<tr>';
		$html.= '<th colspan="2" style="text-align:center;padding:2px">';
		$html.='<button onclick="window.open(\'http://app.3wdoc.com/account/signup/\');" style="border:0px;color:#ffffff;font-family: Arial;font-weight:bold;text-transform:uppercase;font-size:12px;line-height:26px;text-align:center;background:#f6177b;cursor:pointer;-moz-box-shadow : 0 0 5px #474848;-webkit-box-shadow : 0 0 5px #474848;box-shadow : 0 0 5px #474848;height:26px;width:112px;margin:5px auto 0 auto;">Sign up now!</button>';
		$html.= '</th>';
		$html.= '</tr>';
		$html.='</table>';
		echo $html;
		
	}//EOM
	
	function add_tinymce_button($buttons) {
		array_push($buttons, "tag_3wdoc");
		
		return $buttons;
		
	}//EOM

	function add_quicktags_button( $buttons ) {
		$buttons['buttons'] .= ",3wdoc";
		
		return $buttons;
		
	}//EOM

	function add_tinymce_plugin($plugin_array) {
		$plugin_array["tag_3wdoc"] = $this->plugin_dir_path.'/wp3wdocEmbed.js';
		return $plugin_array;
	
	}//EOM

	function add_quicktag_plugin() {
		
		echo '<script type="text/javascript">';
		echo 'QTags.addButton( "3wdoc", "3wdoc", "[tag_3wdoc]","");';
		echo '</script>';
	
	}//EOM
	
	function save_metaboxes($args) {
		global $wpdb;
		if( isset($_POST["3wdoc_snippet"]) ) {
			update_post_meta($args, "3wdoc_snippet", $_POST["3wdoc_snippet"]);	
		}
		
	}//EOM
	
	function add_snippet_content($atts, $content = "") {

		global $post;
		$meta = get_post_meta($post->ID, "3wdoc_snippet", true);
		return $meta;
		
	}//EOM

}//EOC

add_action( 'init', 'Wp3wdocEmbed' );

function Wp3wdocEmbed() {
	
	global $Wp3wdocEmbed;
	$Wp3wdocEmbed = new Wp3wdocEmbed();
	
}//EOF
?>