<?php
require_once dirname( __FILE__ ) . '/../models/flowplayer.php';
//require_once dirname( __FILE__ ) . '/../models/flowplayer-frontend.php';


add_shortcode('flowplayer','flowplayer_content_handle');

function flowplayer_content_handle( $atts ) {
	extract( shortcode_atts( array(
      'src' => '',
      'width' => '',
      'height' => '',
      'autoplay' => '',
      'splash' => '',
      'popup' => '',
      'controlbar' => '',
      ), $atts ) );
	$arguments['width'] = $width;
	$arguments['height'] = $height;
	$arguments['autoplay'] = $autoplay;
//	$arguments['embed'] = $embed;
	$arguments['splash'] = $splash;
	$arguments['popup'] = $popup;
	$arguments['controlbar'] = $controlbar;

	if (trim($src) != '') {
		// build new player
		$fp = new flowplayer_frontend();
      $new_player = $fp->build_min_player($src,$arguments);
    //  var_dump($new_player['html']); 
		$content = str_replace($src, $new_player['html'],$atts);
		$GLOBALS['scripts'][] = $new_player['script'];
    // var_dump($content); 
	}
    return $new_player['html'];
//	return $content;
}
?>
