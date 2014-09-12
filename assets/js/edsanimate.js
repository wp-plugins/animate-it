/*
 * Plugin Name: Animate It!
 * Plugin URI: http://www.eleopard.in
 * Description: It will allow user to add CSS Animations
 * Version: 1.0
 * Author: eLEOPARD Design Studios Pvt Ltd.
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
(function($) {
	$(document).ready(function(){
		var animationStyleClasses = ["animated", "bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble", "bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp", "bounceOut", "bounceOutDown", "bounceOutLeft", "bounceOutRight", "bounceOutUp", "fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "fadeOut", "fadeOutDown", "fadeOutDownBig", "fadeOutLeft", "fadeOutLeftBig", "fadeOutRight", "fadeOutRightBig", "fadeOutUp", "fadeOutUpBig", "flip", "flipInX", "flipInY", "flipOutX", "flipOutY", "lightSpeedIn", "lightSpeedOut", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "rotateOut", "rotateOutDownLeft", "rotateOutDownRight", "rotateOutUpLeft", "rotateOutUpRight", "hinge", "rollIn", "rollOut", "zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp", "zoomOut", "zoomOutDown", "zoomOutLeft", "zoomOutRight", "zoomOutUp"];
		var delayClasses  = ["delay1", "delay2", "delay3", "delay4", "delay5", "delay6", "delay7", "delay8", "delay9", "delay10", "delay11", "delay12"];
		var scrollOffset = scroll_offset;		
			
		$('.eds-on-scroll').each(function(){
			var $module = $(this);
			
			if($module.hasClass('custom'))
			{
				$module.removeClass(function(index, className){
					var removeClassList = "";
					var classList = className.trim().split(/\s+/);
					$.each(classList, function(index, value){
						if((value=='eds-on-scroll') 
							||	($.inArray(value, animationStyleClasses)!==-1) 
							|| ($.inArray(value, delayClasses)!==-1))
							removeClassList += " " + value;							
					});
					
					return removeClassList;					
				});
			}
			else
			{
				var classesToAdd = " eds-scroll-visible ";
						
				$module.removeClass(function(index, className){
					var removeClassList = "";
					var classList = className.trim().split(/\s+/);
					$.each(classList, function(index, value){
						if(($.inArray(value, animationStyleClasses)!==-1) 
							|| ($.inArray(value, delayClasses)!==-1))
							removeClassList += " " + value;							
					});
					
					classesToAdd += removeClassList;			
					return removeClassList;					
				});
				
				$module.addClass("eds-scroll-hidden");
				
				$module.viewportChecker({
			        classToAdd: classesToAdd,
					offset: scrollOffset 
			       });
				
			}		
	
		});	
	});	
})(jQuery);