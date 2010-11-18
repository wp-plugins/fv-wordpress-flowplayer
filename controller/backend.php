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

if(isset($_POST['_wp_http_referer']) && (strpos($_POST['_wp_http_referer'],'fvplayer')))
  add_filter('media_send_to_editor','fp_media_send_to_editor', 10, 3);
 
add_action('the_content', 'flowplayer_content_remove_commas');

function flowplayer_content_remove_commas($content){
   preg_match('/.*popup=\'(.*?)\'.*/', $content, $matches);
   //var_dump($matches);
   $content_new = preg_replace('/\,/', '',$content);
   if (isset($matches[1]))
      $content_new = preg_replace('/popup=\'(.*?)\'/', 'popup=\''.$matches[1].'\'',$content_new);
//   var_dump($content_new);
   return $content_new;

}
/**
 * END WP Hooks
 */
 
function fp_media_send_to_editor($html, $attachment_id, $attachment){
  if(isset($_POST['_wp_http_referer']) && (strpos($_POST['_wp_http_referer'],'fvplayer'))) {
    //preg_match('/width=([0-9]+)/',$_POST['_wp_http_referer'],$matchesw);
    preg_match('/height=([0-9]+([a-z]+))/',$_POST['_wp_http_referer'],$matchesh);
    //var_dump($_POST['_wp_http_referer']);var_dump($matchesh);die;
 // }

  //if ((!empty($matchesh))&&($matchesh[2]=='fvplayer')){
      
      $video_types = array('flv','mov','avi','mpeg','mpg','asf','qt','wmv','mp4');
      $splash_types = array('jpg','jpeg','gif','png', 'bmp','jpe');
      if (isset($attachment_id)) 
      {
         $attachment_url = wp_get_attachment_url($attachment_id);
         $path_parts = pathinfo($attachment_url);
         if (in_array($path_parts['extension'], $splash_types)){
            setcookie("selected_image",$attachment_url);
            $selected_attachment = array('url'=>$attachment_url,'id'=>$attachment_id);
          }
          else{
//         if (in_array($path_parts['extension'], $video_types)){
            setcookie("selected_video",$attachment_url);
            $selected_attachment = array('url'=>$attachment_url);
            }
      }
      wp_enqueue_style('media');
      wp_iframe('flowplayer_wizard_function',$selected_attachment);
      die;
   }
}
function flowplayer_wizard() {
   setcookie("selected_video",'',time()-3600);
   setcookie("selected_image",'',time()-3600);
	wp_enqueue_style('media');
	wp_iframe('flowplayer_wizard_function','');
}

function flowplayer_wizard_function($selected_attachment) {
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
	$conf_file = realpath(dirname(__FILE__)).'/wpfp.conf';  //Zdenka: I think here should be /../

	if(!file_exists($conf_file)){
		$html .= '<h3 style="font-weight: bold; color: #ff0000">'.$conf_file.' Does not exist please create it</h3>';
	} elseif(!is_readable($conf_file)){
		$html .= '<h3 style="font-weight: bold; color: #ff0000">'.$conf_file.' is not readable please check file permissions</h3>';
	} elseif(!is_writable($conf_file)){
		$html .= '<h3 style="font-weight: bold; color: #ff0000">'.$conf_file.' is not writable please check file permissions</h3>';
	}
//	return $html;  //Zdenka : Why is this not here?
}

function flowplayer_add_media_button(){
  global $post;
	$plugins = get_option('active_plugins');
	$found = false;
	
	foreach ( $plugins AS $plugin ) {
		if( stripos($plugin,'foliopress-wysiwyg') !== FALSE )
			$found = true;
	}
	if(!$found) 
  {
		/*global $fmp_jw_url, $fmp_jw_files_dir;
		$wizard_url = $fmp_jw_url . '/inc/shortcode_wizard.php';
		$config_dir = $fmp_jw_files_dir . '/configs';
		$playlist_dir = $fmp_jw_files_dir .'/playlists';
		$button_src = $fmp_jw_url . '/inc/images/playerbutton.gif';
		$button_tip = 'Insert a Flash MP3 Player';*/
		$wizard_url = 'media-upload.php?post_id='.$post->ID.'&type=fv-wp-flowplayer';
		$button_src = RELATIVE_PATH.'/images/icon.png';
		echo '<a title="Add FV WP Flowplayer" href="'.$wizard_url.'&TB_iframe=true&width=500&height=300" class="thickbox" ><img src="' . $button_src . '" alt="' . $button_tip . '" /></a>';
	}
}

?>