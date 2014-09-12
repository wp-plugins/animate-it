<?php
function add_edsanimate_tinymce_plugin($plugin_array){
	
	$plugin_array['edsanimate'] = plugins_url('/assets/js/eds_tinymce.js',__file__);
	return $plugin_array;

}

function register_edsanimate_button($buttons){
	
	array_push($buttons, "|", "edsanimate");
	return $buttons;

}

function eds_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

function add_edsanimate_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
	return;
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'add_edsanimate_tinymce_plugin');
		add_filter('mce_buttons', 'register_edsanimate_button');
	}
}


add_action('init', 'add_edsanimate_button');

add_filter( 'tiny_mce_version', 'eds_refresh_mce');



