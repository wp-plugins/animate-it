<?php
/**
 * Plugin Name: Animate It!
 * Plugin URI: http://www.eleopard.in
 * Description: It will allow user to add CSS Animations
 * Version: 1.0
 * Author: eLEOPARD Design Studios
 * Author URI: http://www.eleopard.in
 * License: GNU General Public License version 2 or later; see LICENSE.txt
 *  http://www.gnu.org/copyleft/gpl.html GNU/GPL
    (C) 2014 eLEOPARD Design Studios Pvt Ltd. All rights reserved
   
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
	
	or see <http://www.gnu.org/licenses/>.
	* For any other query please contact us at contact[at]eleopard[dot]in
*/


include_once 'eds_tinymce.php';

function set_edsanimate_options(){
	add_option('scroll_offset'
			,'75'
			,'Percentage height of the element '.
			'after which animation should get applied' );
}

function unset_edsanimate_options(){
	delete_option('scroll_offset');
}
	
function admin_edsanimate_options(){
	?>
	<div class="wrap"><h2>Animate It! Options</h2></div>
	<?php 
	if(isset($_REQUEST['submit'])){
		update_edsanimate_options();
	}
	
	print_edsanimate_form();
	?></div><?php 
}

function update_edsanimate_options(){
	$ok= false;
	if($_REQUEST['scroll_offset']){
		update_option('scroll_offset', $_REQUEST['scroll_offset']);
		$ok=true;	
	}
	
	if($ok){?>
		<div id="message" class="updated fade">
			<p>Options saved.</p>
		</div>
		<?php	
		
	}else{?>
		<div id="message" class="error fade">
			<p>Failed to save options.</p>
		</div>
		<?php		
	}
}

function print_edsanimate_form(){
	$default_scroll_offset = get_option('scroll_offset');
	?>
	<form method="post">
		<label for="scroll_offset">Scroll Offset (in percentage):
			<input type="text" name="scroll_offset" value="<?php echo $default_scroll_offset; ?>" />
		</label>
		<br/>
		<input type="submit" name="submit" value="Submit" />
	</form>
	<?php	
}
	
function modify_menu(){
	add_options_page('Animate It! Options'
					, 'Animate It!'
					, 'manage_options'
					, __FILE__
					, 'admin_edsanimate_options');
}


function add_eds_script_and_css()
{
	wp_register_style( 'animate-css',plugins_url( '/assets/css/animate.css', __FILE__ ));
	wp_register_script( 'viewpointcheck-script',plugins_url( '/assets/js/viewportchecker.js', __FILE__ ),array('jquery'));
	wp_register_script( 'edsanimate-script', plugins_url( '/assets/js/edsanimate.js', __FILE__ ),array('viewpointcheck-script') );
	wp_localize_script( 'edsanimate-script', 'scroll_offset', get_option('scroll_offset'));
	wp_enqueue_style( 'animate-css' );	
	wp_enqueue_script( 'viewpointcheck-script');		
	wp_enqueue_script( 'edsanimate-script');  
}




function edsanimate_handler( $attributes, $content = null ) {
	
	
	extract( shortcode_atts( array(
		'animation' => '',
		'delay' => '',
		'on_scroll' => ''
	), $attributes ) );
	
	
	$classString = "animated";
	
	if($animation == '')
	{		
		return $content;
	}
	
	$classString .= " " . $animation;

	if($delay!= '' && is_int((int)$delay) && $delay>=0 && $delay <=12)
		$classString .= " delay" . $delay;
		
	
	if(strcasecmp($on_scroll, 'yes')==0)
		$classString .= " eds-on-scroll";	
	
	return '<div class="'.$classString.'">'.$content.'</div>';		
	
}
add_filter('widget_text', 'do_shortcode');
register_activation_hook(__FILE__, 'set_edsanimate_options');
register_deactivation_hook(__FILE__, 'unset_edsanimate_options');
add_action('admin_menu', 'modify_menu');
add_shortcode('edsanimate', 'edsanimate_handler');
add_action('wp_enqueue_scripts', 'add_eds_script_and_css');





