<?php

/**
 * Needed includes
 */
include dirname( __FILE__ ) . '/../models/flowplayer.php';
include dirname( __FILE__ ) . '/../models/flowplayer-frontend.php';

/**
 * WP Hooks
 */
add_action('wp_head', 'flowplayer_head');
add_action('the_content', 'flowplayer_content');
add_action('wp_footer','flowplayer_display_scripts');
//	Addition for 0.9.15
add_action('widget_text','flowplayer_content');

/**
 * END WP Hooks
 */
 
$GLOBALS['scripts'] = array();

/**
 * Replaces the flowplayer tags in post content by players and fills the $GLOBALS['scripts'] array.
 * @param string Content to be parsed
 * @return string Modified content string
 */
function flowplayer_content( $content ) {
	
	$content_matches = array();
	preg_match_all('/\[flowplayer\ [^\]]+\]/i', $content, $content_matches);
		
	// process all found tags
	foreach ($content_matches[0] as $tag) {
		$ntag = str_replace("\'",'&#039;',$tag);
				
		//	search for URL
		preg_match("/src='([^']*?)'/i",$ntag,$tmp);
		if( $tmp[1] == NULL ) {
			preg_match_all("/src=([^\s\]]*)/i",$ntag,$tmp);
			$media = $tmp[1][0];
		}
		else
			$media = $tmp[1];
			
		//	width and heigth
		preg_match("/width=(\d*)/i",$ntag,$width);
		preg_match("/height=(\d*)/i",$ntag,$height);
		
		if( $width[1] != NULL)
			$arguments['width'] = $width[1];
		if( $height[1] != NULL)
			$arguments['height'] = $height[1];
			
		//	search for popup in quotes
		preg_match("/popup='([^']*?)'/i",$ntag,$tmp);
		$arguments['popup'] = $tmp[1];
		
		//	search for splash image
		preg_match("/splash='([^']*?)'/i",$ntag,$tmp);
		if( $tmp[1] == NULL ) {
			preg_match_all("/splash=([^\s\]]*)/i",$ntag,$tmp);
			$arguments['splash'] = $tmp[1][0];
		}
		else
			$arguments['splash'] = $tmp[1];

		if (trim($media) != '') {
			// build new player
			$fp = new flowplayer_frontend();
         		$new_player = $fp->build_min_player($media,$arguments);
			$content = str_replace($tag, $new_player['html'],$content);
			$GLOBALS['scripts'][] = $new_player['script'];
		}
	}
	
	return $content;
}


/**
 * Prints flowplayer javascript content to the bottom of the page.
 */
function flowplayer_display_scripts() {
	if (!empty($GLOBALS['scripts'])) {
		echo "\n<script defer=\"defer\" type=\"text/javascript\">\n<!--\n\n";
		foreach ($GLOBALS['scripts'] as $scr) {
			echo $scr;
		}
		echo "\n\n//-->\n</script>\n";
	}
}

/**
 * This is the template tag. Use the standard Flowplayer shortcodes
 */

function flowplayer($shortcode) {
	echo apply_filters('the_content',$shortcode);
}

?>