<?php

/**
 * Needed includes
 */
include dirname( __FILE__ ) . '/../models/flowplayer.php';
include dirname( __FILE__ ) . '/../models/flowplayer-backend.php';

/**
 * Create the flowplayer_backend object
 */
$fp = new flowplayer_backend();

/**
 * WP Hooks
 */
add_action('admin_head', 'flowplayer_head');
add_action('admin_menu', 'flowplayer_admin');
add_action('media_buttons', 'flowplayer_add_media_button', 30);
add_action('media_upload_fv-wp-flowplayer', 'flowplayer_wizard');
/**
 * END WP Hooks
 */

function flowplayer_wizard() {
	wp_enqueue_style('media');
	wp_iframe('flowplayer_wizard_function');
}

function flowplayer_wizard_function() {
	include dirname( __FILE__ ) . '/../view/wizard.php';
}

/**
 * Administrator environment function.
 */
function flowplayer_admin () {
	
	// if we are in administrator environment
	if (function_exists('add_submenu_page')) {
		add_options_page(
							'FV Wordpress Flowplayer', 
							'FV Wordpress Flowplayer', 
							8, 
							basename(__FILE__), 
							'flowplayer_page'
						);
	}
}

/**
 * Outputs HTML code for bool options based on arg passed.
 * @param string Currently selected value ('true' or 'false').
 * @return string HTML code
 */
function flowplayer_bool_select($current) {
	switch($current) {
		 		case "true":
		 			$html = '<option selected="selected" value="true">true</option><option value="false">false</option>';
		 			break;
		 		case "false":
		 			$html = '<option value="true" >true</option><option selected="selected" value="false">false</option>';
		 			break;
		 		default:
		 			$html = '<option value="true">true</option><option selected="selected" value="false">false</option>';
		 			break;
		 	}
		 return $html;
}

/**
 * Displays administrator menu with configuration.
 */
function flowplayer_page() {
	//initialize the class:
	$fp = new flowplayer();
	include dirname( __FILE__ ) . '/../view/admin.php';
}

/**
 * Checks for errors regarding access to configuration file. Displays errors if any occur.
 * @param object $fp Flowplayer class object.
 */
function flowplayer_check_errors($fp){
	$html = '';
	// config file checks, exists, readable, writeable
	$conf_file = realpath(dirname(__FILE__)).'/wpfp.conf';
	if(!file_exists($conf_file)){
		$html .= '<h3 style="font-weight: bold; color: #ff0000">'.$conf_file.' Does not exist please create it</h3>';
	} elseif(!is_readable($conf_file)){
		$html .= '<h3 style="font-weight: bold; color: #ff0000">'.$conf_file.' is not readable please check file permissions</h3>';
	} elseif(!is_writable($conf_file)){
		$html .= '<h3 style="font-weight: bold; color: #ff0000">'.$conf_file.' is not writable please check file permissions</h3>';
	}
}

function flowplayer_add_media_button(){
	$plugins = get_option('active_plugins');
	$found = false;
	
	foreach ( $plugins AS $plugin ) {
		if( stripos($plugin,'foliopress-wysiwyg') !== FALSE )
			$found = true;
	}
	if(!$found) {
		/*global $fmp_jw_url, $fmp_jw_files_dir;
		$wizard_url = $fmp_jw_url . '/inc/shortcode_wizard.php';
		$config_dir = $fmp_jw_files_dir . '/configs';
		$playlist_dir = $fmp_jw_files_dir .'/playlists';
		$button_src = $fmp_jw_url . '/inc/images/playerbutton.gif';
		$button_tip = 'Insert a Flash MP3 Player';*/
		$wizard_url = 'media-upload.php?type=fv-wp-flowplayer';
		$button_src = RELATIVE_PATH.'/images/icon.png';
		echo '<a title="Add FV WP Flowplayer" href="'.$wizard_url.'&TB_iframe=true&width=500&height=300" class="thickbox" ><img src="' . $button_src . '" alt="' . $button_tip . '" /></a>';
	}
}

?>