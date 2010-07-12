<?php
require_once dirname( __FILE__ ) . '/../models/flowplayer.php';
//require_once dirname( __FILE__ ) . '/../models/flowplayer-frontend.php';


add_shortcode('flowplayer','flowplayer_content_handle');

function flowplayer_content_handle( $atts ) {
  /// Addition  2010/07/12  mv 
  $fp = new flowplayer_frontend();
  if( $fp->conf['commas'] == 'true' ) {
    
    if( !isset( $atts['src'] ) ) {
      foreach( $atts AS $key => $att ) {
        if( stripos( $att, 'src=' ) !== FALSE ) {
          $atts['src'] = preg_replace( '/^\s*?src=[\'"](.*)[\'"],\s*?$/', '$1', $att );
          $i = $key+1;
          unset( $atts[$key] ); // = ''; //  let's remove it, so it won't confuse the rest of workaaround
        }
      }
    }
  
    if( !isset( $atts['splash'] ) ) {
      foreach( $atts AS $key => $att ) {
        if( stripos( $att, 'splash=' ) !== FALSE ) {
          $atts['splash'] = preg_replace( '/^\s*?splash=[\'"](.*)[\'"],\s*?$/', '$1', $att );
          unset( $atts[$key] ); // = ''; //  let's remove it, so it won't confuse the rest of workaround
        }
      }
    }
  
    //  the popup should really be a content of the shortcode, not an attribute
    //  this part will fix the popup if there is any single quote in it.
    if( !isset( $atts['popup'] ) ) {
      $popup = array();
      $is_popup = false;
      foreach( $atts AS $key => $att ) {
        if( !is_numeric( $key ) ) continue;
        if( ( stripos( $att, 'popup=' ) !== FALSE || $is_popup ) && stripos( $att, 'src=' ) === FALSE && stripos( $att, 'splash=' ) === FALSE) {
          $popup[] = $att;
          $is_popup = true;
          unset( $atts[$key] ); // = ''; //  let's remove it, so it won't confuse the rest of workaround
        }
      }
      $popup = implode( ' ', $popup );
      $atts['popup'] = preg_replace( '/^\s*?popup=[\'"](.*)[\'"]\s*?$/mi', '$1', $popup );
    }
    
  }
  /// End of addition
  
  extract( shortcode_atts( array(
      'src' => '',
      'width' => '',
      'height' => '',
      'autoplay' => '',
      'splash' => '',
      'popup' => '',
      'controlbar' => '',
      'redirect' => ''
      ), $atts ) );
  
	$arguments['width'] = preg_replace('/\,/', '', $width);
	$arguments['height'] = preg_replace('/\,/', '', $height);
	$arguments['autoplay'] = preg_replace('/\,/', '', $autoplay);
//	$arguments['embed'] = $embed;
	$arguments['splash'] = preg_replace('/\,/', '', $splash);
	$arguments['popup'] = $popup;
	$arguments['controlbar'] = preg_replace('/\,/', '', $controlbar);
	$arguments['redirect'] = preg_replace('/\,/', '', $redirect);

	$src = preg_replace('/\,/', '', $src);
	if (trim($src) != '') {
		// build new player
	  //$fp = new flowplayer_frontend();
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
