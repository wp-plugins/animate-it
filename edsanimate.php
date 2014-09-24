<?php
/**
 * Plugin Name: Animate It!
 * Plugin URI: http://www.eleopard.in
 * Description: It will allow user to add CSS Animations
 * Version: 1.1
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


include_once 'assets/helper/Mobile_Detect.php';
include_once 'eds_tinymce.php';


function detectDevice()
{
 	static $deviceType = null;
 	if(!$deviceType)
 	{
		$detect = new Mobile_Detect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
 	}
 	return $deviceType;
	
}

function set_edsanimate_options(){
	add_option('scroll_offset'
			,'75'
			,'Percentage height of the element '.
			'after which animation should get applied' );
	
	add_option('enable_on_phone'
			,'0'
			,'Animation should work on smartphones or not.');

	add_option('enable_on_tab'
			,'1'
			,'Animation should work on tablets or not.');
}

function unset_edsanimate_options(){
	delete_option('scroll_offset');
	delete_option('enable_on_phone');
	delete_option('enable_on_tab');
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
	if(isset($_REQUEST['scroll_offset'])
		&& isset($_REQUEST['enable_on_phone'])
		&& isset($_REQUEST['enable_on_tab'])){
		update_option('scroll_offset', $_REQUEST['scroll_offset']);
		update_option('enable_on_phone', $_REQUEST['enable_on_phone']);
		update_option('enable_on_tab', $_REQUEST['enable_on_tab']);
		
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
		<table cellspacing="10" cellpadding="10">
			<tr>
				<td>
					<label for="scroll_offset">Scroll Offset (in percentage):</label>
				</td>
				<td colspan="2">
					<input type="text" name="scroll_offset" value="<?php echo $default_scroll_offset; ?>" />
				</td>
				
			</tr>
			<tr>
				<td>
					<label for="enable_on_phone">Enable on Smartphones:</label>
				</td>
				<td>
					<select name="enable_on_phone">	
						<option value="0" <?php echo (get_option('enable_on_phone')=='0')?'selected="selected"':'';?>>No</option>
						<option value="1" <?php echo (get_option('enable_on_phone')=='1')?'selected="selected"':'';?>>Yes</option>				
					</select>	
				</td>
				<td>
					<p style="font-size:11px;"><i>(Animation should work on Smartphones or not)</i>
				</td>
			</tr>
			<tr>
				<td>
					<label for="enable_on_tab">Enable on Tablets:</label>					
				</td>
				<td>
					<select name="enable_on_tab">	
						<option value="0" <?php echo (get_option('enable_on_tab')=='0')?'selected="selected"':'';?>>No</option>
						<option value="1" <?php echo (get_option('enable_on_tab')=='1')?'selected="selected"':'';?>>Yes</option>				
					</select>
				</td>
				<td>
					<p style="font-size:11px;"><i>(Animation should work on Tablets or not)</i>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<input type="submit" name="submit" value="Submit" />
				</td>				
			</tr>
		</table>
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
	$deviceType = detectDevice();
	
	$enableSmartPhone = get_option('enable_on_phone');
	$enableTablet =  get_option('enable_on_tab');
	
	
	$enable= ($deviceType=='phone' && intval($enableSmartPhone))
			|| ($deviceType =='tablet' && intval($enableTablet))
			|| ($deviceType =='computer');
	
	if($enable):		
		wp_register_style( 'animate-css',plugins_url( '/assets/css/animate.css', __FILE__ ));
		wp_register_script( 'viewpointcheck-script',plugins_url( '/assets/js/viewportchecker.js', __FILE__ ),array('jquery'));
		wp_register_script( 'edsanimate-script', plugins_url( '/assets/js/edsanimate.js', __FILE__ ),array('viewpointcheck-script') );
		wp_localize_script( 'edsanimate-script', 'scroll_offset', get_option('scroll_offset'));
		wp_enqueue_style( 'animate-css' );	
		wp_enqueue_script( 'viewpointcheck-script');		
		wp_enqueue_script( 'edsanimate-script'); 
	endif; 
}




function edsanimate_handler( $attributes, $content = null ) {
	
	$deviceType = detectDevice();
	
	$enableSmartPhone = get_option('enable_on_phone');
	$enableTablet =  get_option('enable_on_tab');
	
	
	$enable= ($deviceType=='phone' && intval($enableSmartPhone))
			|| ($deviceType =='tablet' && intval($enableTablet))
			|| ($deviceType =='computer');

	if($enable):
		extract( shortcode_atts( array(
			'animation' => '',
			'delay' => '',
			'duration' => '',
			'infinite_animation' =>'',
			'on_scroll' => ''
		), $attributes ) );
		
		
		$classString = "animated";
		
		if($animation == '')
		{		
			return $content;
		}
		
		$classString .= " " . $animation;
	
		if(strcasecmp($infinite_animation, 'yes')==0)
			$classString .= " infinite";
		
		if($delay!= '' && is_int((int)$delay) && $delay>=0 && $delay <=12)
			$classString .= " delay" . $delay;
			
		if($duration!= '' && is_int((int)$duration) && $duration>=0 && $duration <=12)
			$classString .= " duration" . $duration;			
		
		if(strcasecmp($on_scroll, 'yes')==0)
			$classString .= " eds-on-scroll";	
		
		return '<div class="'.$classString.'">'.$content.'</div>';
	else:
		return $content;
	endif;		
	
}

//Admin Menu Options Filters 
add_filter('widget_text', 'do_shortcode');
register_activation_hook(__FILE__, 'set_edsanimate_options');
register_deactivation_hook(__FILE__, 'unset_edsanimate_options');
add_action('admin_menu', 'modify_menu');
add_shortcode('edsanimate', 'edsanimate_handler');
add_action('wp_enqueue_scripts', 'add_eds_script_and_css');





