<?php
/*  FV Wordpress Flowplayer - HTML5 video player with Flash fallback    
    Copyright (C) 2013  Foliovision

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 

/**
 * Extension of original flowplayer class intended for frontend.
 */
class flowplayer_frontend extends flowplayer
{

	var $ajax_count = 0;
	
	var $autobuffer_count = 0;	
	
	var $autoplay_count = 0;
	
	var $expire_time = 0;
  
  var $aPlaylists = array();
  
  var $aCurArgs = false;
  
  var $sHTMLAfter = false;  
  

	/**
	 * Builds the HTML and JS code of single flowplayer instance on a page/post.
	 * @param string $media URL or filename (in case it is in the /videos/ directory) of video file to be played.
	 * @param array $args Array of arguments (name => value).
	 * @return Returns array with 2 elements - 'html' => html code displayed anywhere on page/post, 'script' => javascript code displayed before </body> tag
	 */
	function build_min_player($media,$args = array()) {
		global $post;
						
		$this->hash = md5($media.$this->_salt()); //  unique player id
    $this->aCurArgs = apply_filters( 'fv_flowplayer_args_pre', $args );
    $this->sHTMLAfter = false;
		$player_type = 'video';
		$rtmp = false;
		$youtube = false;
		$vimeo = false;
    $scripts_after = '';
    
		// returned array with new player's html and javascript content
    if( !isset($GLOBALS['fv_fp_scripts']) ) {
      $GLOBALS['fv_fp_scripts'] = array();
    }
		$this->ret = array('html' => '', 'script' => $GLOBALS['fv_fp_scripts'] );	//	note: we need the white space here, it fails to add into the string on some hosts without it (???)
		
      
    
		/*
     *  Set common variables
     */
		$width = ( isset($this->conf['width']) && (!empty($this->conf['width'])) && intval($this->conf['width']) > 0 ) ? $this->conf['width'] : 320;
		$height = ( isset($this->conf['height']) && (!empty($this->conf['height'])) && intval($this->conf['height']) > 0 ) ? $this->conf['height'] : 240;
		if (isset($this->aCurArgs['width'])&&!empty($this->aCurArgs['width'])) $width = trim($this->aCurArgs['width']);
		if (isset($this->aCurArgs['height'])&&!empty($this->aCurArgs['height'])) $height = trim($this->aCurArgs['height']);		
		        
		$src1 = ( isset($this->aCurArgs['src1']) && !empty($this->aCurArgs['src1']) ) ? trim($this->aCurArgs['src1']) : false;
		$src2 = ( isset($this->aCurArgs['src2']) && !empty($this->aCurArgs['src2']) ) ? trim($this->aCurArgs['src2']) : false;  
		
    
		$autoplay = false;
		if( isset($this->conf['autoplay']) && $this->conf['autoplay'] == 'true' && $this->aCurArgs['autoplay'] != 'false'  ) {
			$this->autobuffer_count++;
			if( $this->autobuffer_count < apply_filters( 'fv_flowplayer_autobuffer_limit', 2 ) ) {
				$autoplay = true;
			}
		}  
		if( isset($this->aCurArgs['autoplay']) && $this->aCurArgs['autoplay'] == 'true') {
			$this->autobuffer_count++;
			$autoplay = true;
		}
    
    
    $splash_img = $this->get_splash();
    
    
    foreach( array( $media, $src1, $src2 ) AS $media_item ) {
      if( stripos( $media_item, 'rtmp://' ) === 0 ) {
        $rtmp = $media_item;
      }
    }
    
    if( ( !empty($this->aCurArgs['rtmp']) || ( !empty($this->conf['rtmp']) && $this->conf['rtmp'] != 'false' ) ) && !empty($this->aCurArgs['rtmp_path']) ) {
      $rtmp = trim( $this->aCurArgs['rtmp_path'] );
    }

    list( $media, $src1, $src2 ) = apply_filters( 'fv_flowplayer_media_pre', array( $media, $src1, $src2 ), $this );
    
		
    /*
     *  Which player should be used
     */
		foreach( array( $media, $src1, $src2 ) AS $media_item ) {
			if( preg_match( '~\.(mp3|wav|ogg)([?#].*?)?$~', $media_item ) ) {
					$player_type = 'audio';
					break;
				} 
				
			global $post;
			$fv_flowplayer_meta = get_post_meta( $post->ID, '_fv_flowplayer', true );
			if( $fv_flowplayer_meta && isset($fv_flowplayer_meta[sanitize_title($media_item)]['time']) ) {
				$this->expire_time = $fv_flowplayer_meta[sanitize_title($media_item)]['time'];
			}
		}
    
		if( preg_match( "~(youtu\.be/|youtube\.com/(watch\?(.*&)?v=|(embed|v)/))([^\?&\"'>]+)~i", $media, $aYoutube ) ) {
			if( isset($aYoutube[5]) ) {
				$youtube = $aYoutube[5];
				$player_type = 'youtube';
			}
		} else if( preg_match( "~^[a-zA-Z0-9-_]{11}$~", $media, $aYoutube ) ) {
			if( isset($aYoutube[0]) ) {
				$youtube = $aYoutube[0];
				$player_type = 'youtube';
			}
		}

		if( preg_match( "~vimeo.com/(?:video/|moogaloop\.swf\?clip_id=)?(\d+)~i", $media, $aVimeo ) ) {
			if( isset($aVimeo[1]) ) {
				$vimeo = $aVimeo[1];
				$player_type = 'vimeo';
			}
		} else if( preg_match( "~^[0-9]{8}$~", $media, $aVimeo ) ) {
			if( isset($aVimeo[0]) ) {
				$vimeo = $aVimeo[0];
				$player_type = 'vimeo';
			}
		}
        
    $aPlaylistItems = array();    
    if( isset($this->aCurArgs['playlist']) && strlen(trim($this->aCurArgs['playlist'])) > 0 ) {                 
      list( $playlist_items_external_html, $aPlaylistItems ) = $this->build_playlist( $this->aCurArgs, $media, $src1, $src2, $rtmp, $splash_img );
    }    
    
    $this->aCurArgs = apply_filters( 'fv_flowplayer_args', $this->aCurArgs, $this->hash, $media, $aPlaylistItems );
    
    $player_type = apply_filters( 'fv_flowplayer_player_type', $player_type, $this->hash, $media, $aPlaylistItems, $this->aCurArgs );
    
    
    /*
     *  Video player
     */
		if( $player_type == 'video' ) {
		
				foreach( array( $media, $src1, $src2 ) AS $media_item ) {
					//if( ( strpos($media_item, 'amazonaws.com') !== false && stripos( $media_item, 'http://s3.amazonaws.com/' ) !== 0 && stripos( $media_item, 'https://s3.amazonaws.com/' ) !== 0  ) || stripos( $media_item, 'rtmp://' ) === 0 ) {  //  we are also checking amazonaws.com due to compatibility with older shortcodes
					
					if( $this->conf['engine'] == 'false' && stripos( $media_item, '.m4v' ) !== false ) {
						$this->ret['script']['fv_flowplayer_browser_ff_m4v'][$this->hash] = true;
					}
          
					if( $this->conf['engine'] == 'false' && preg_match( '~\.(mp4|m4v|mov)~', $media_item ) > 0 ) {
						$this->ret['script']['fv_flowplayer_browser_chrome_mp4'][$this->hash] = true;
					}				
					
				}    
				
				if (!empty($media)) {
					$media = $this->get_video_url($media);
				}
				if (!empty($src1)) {
					$src1 = $this->get_video_url($src1);
				}
				if (!empty($src2)) {
					$src2 = $this->get_video_url($src2);
				}
        $mobile = ( isset($this->aCurArgs['mobile']) && !empty($this->aCurArgs['mobile']) ) ? trim($this->aCurArgs['mobile']) : false;  
				if (!empty($mobile)) {
					$mobile = $this->get_video_url($mobile);
				}			
				
				$popup = '';
				
				//check user agents
				$aUserAgents = array('iphone', 'ipod', 'iPad', 'aspen', 'incognito', 'webmate', 'android', 'android', 'dream', 'cupcake', 'froyo', 'blackberry9500', 'blackberry9520', 'blackberry9530', 'blackberry9550', 'blackberry9800', 'Palm', 'webos', 's8000', 'bada', 'Opera Mini', 'Opera Mobi', 'htc_touch_pro');
				$mobileUserAgent = false;
				foreach($aUserAgents as $userAgent){
					if(stripos($_SERVER['HTTP_USER_AGENT'],$userAgent))
						$mobileUserAgent = true;
				}
				
				$redirect = '';			
	
				if (isset($this->aCurArgs['redirect'])&&!empty($this->aCurArgs['redirect'])) $redirect = trim($this->aCurArgs['redirect']);
				$scaling = "scale";
				if (isset($this->conf['scaling'])&&($this->conf['scaling']=="true"))
					$scaling = "fit";
				else
					$scaling = "scale";
				
        
        $subtitles = $this->get_subtitles();
        
			
				$show_splashend = false;
				if (isset($this->aCurArgs['splashend']) && $this->aCurArgs['splashend'] == 'show' && isset($this->aCurArgs['splash']) && !empty($this->aCurArgs['splash'])) {      
					$show_splashend = true;
					$splashend_contents = '<div id="wpfp_'.$this->hash.'_custom_background" class="wpfp_custom_background" style="position: absolute; background: url(\''.$splash_img.'\') no-repeat center center; background-size: contain; width: 100%; height: 100%; z-index: 1;"></div>';
				}	
				
				//  change engine for IE9 and 10
				
				if( $this->conf['engine'] == 'false' ) {
					$this->ret['script']['fv_flowplayer_browser_ie'][$this->hash] = true;
				}
				
				
				if ( !empty($redirect) ) {
					$this->ret['script']['fv_flowplayer_redirect'][$this->hash] = $redirect;
				}
	
				
				$attributes = array();
				$attributes['class'] = 'flowplayer';
				
				if( $autoplay == false ) {
					$attributes['class'] .= ' is-splash';
				}
        
        if( isset($this->aCurArgs['playlist_hide']) && strcmp($this->aCurArgs['playlist_hide'],'true') == 0 ) {
					$attributes['class'] .= ' playlist-hidden';
				}
				
        //  Fixed control bar
        $bFixedControlbar = false;
				if( isset($this->conf['ui_fixed_controlbar']) && strcmp($this->conf['ui_fixed_controlbar'],'true') == 0 ) {
					$bFixedControlbar = true;
				}
        if( isset($this->aCurArgs['controlbar']) ) {
          if( strcmp($this->aCurArgs['controlbar'],'yes') == 0 || strcmp($this->aCurArgs['controlbar'],'show') == 0 ) {
            $bFixedControlbar = true;
          } else if( strcmp($this->aCurArgs['controlbar'],'no') == 0 ) {
            $attributes['class'] .= ' no-controlbar';
          }
        }
        if( $bFixedControlbar ) {
          $attributes['class'] .= ' fixed-controls';
        }
        
        //  Play button
        $bPlayButton = false;
				if( isset($this->conf['ui_play_button']) && strcmp($this->conf['ui_play_button'],'true') == 0 ) {
					$bPlayButton = true;
				}        
        if( isset($this->aCurArgs['play_button']) ) {
          if( strcmp($this->aCurArgs['play_button'],'yes') == 0 ) {
            $bPlayButton = true;
          } else if( strcmp($this->aCurArgs['play_button'],'no') == 0 ) {
            $bPlayButton = false;
          }
        }
        if( $bPlayButton ) {
          $attributes['class'] .= ' play-button';
        }
				
        //  Align
				if( isset($this->aCurArgs['align']) ) {
					if( $this->aCurArgs['align'] == 'left' ) {
						$attributes['class'] .= ' alignleft';
					} else if( $this->aCurArgs['align'] == 'right' ) {
						$attributes['class'] .= ' alignright';
					} else if( $this->aCurArgs['align'] == 'center' ) {
						$attributes['class'] .= ' aligncenter';
					} 
				}
        $attributes['class'] .= $this->get_align();
				
				if( $this->conf['engine'] == 'true' || $this->aCurArgs['engine'] == 'flash' ) {
					$attributes['data-engine'] = 'flash';
				}
				
				if( $this->aCurArgs['embed'] == 'false' || ( $this->conf['disableembedding'] == 'true' && $this->aCurArgs['embed'] != 'true' ) ) {
					$attributes['data-embed'] = 'false';
				}           

        if( isset($this->aCurArgs['logo']) && $this->aCurArgs['logo'] ) {
					$attributes['data-logo'] = ( strcmp($this->aCurArgs['logo'],'none') == 0 ) ? '' : $this->aCurArgs['logo'];
				}
				
				if( $this->conf['fixed_size'] == 'true' ) {
					$attributes['style'] = 'width: ' . $width . 'px; height: ' . $height . 'px; ';
				} else {
					$attributes['style'] = 'max-width: ' . $width . 'px; max-height: ' . $height . 'px; ';
				}
				
        global $fv_wp_flowplayer_ver;
				$attributes['data-swf'] = FV_FP_RELATIVE_PATH.'/flowplayer/flowplayer.swf?ver='.$fv_wp_flowplayer_ver;
				//$attributes['data-flashfit'] = "true";
				
				if (isset($this->conf['googleanalytics']) && $this->conf['googleanalytics'] != 'false' && strlen($this->conf['googleanalytics']) > 0) {
					$attributes['data-analytics'] = $this->conf['googleanalytics'];
				}			
				
				if( isset($this->aCurArgs['rtmp']) && !empty($this->aCurArgs['rtmp']) ) {
					$attributes['data-rtmp'] = trim( $this->aCurArgs['rtmp'] );
				} else if( isset($rtmp) && stripos( $rtmp, 'rtmp://' ) === 0 && !(isset($this->conf['rtmp']) && $this->conf['rtmp'] != 'false' && stripos($rtmp,$this->conf['rtmp']) !== false ) ) {
					$rtmp_info = parse_url($rtmp);
					if( isset($rtmp_info['host']) && strlen(trim($rtmp_info['host']) ) > 0 ) {
						$attributes['data-rtmp'] = 'rtmp://'.$rtmp_info['host'].'/cfx/st';
					}
				} else if( !empty($this->conf['rtmp']) && $this->conf['rtmp'] != 'false' ) {
          if( stripos( $this->conf['rtmp'], 'rtmp://' ) === 0 ) {
            $attributes['data-rtmp'] = $this->conf['rtmp'];
            $rtmp = str_replace( $this->conf['rtmp'], '', $rtmp );
          } else {
            $attributes['data-rtmp'] = 'rtmp://' . $this->conf['rtmp'] . '/cfx/st/';
          }
        }
        
        				
				$this->get_video_checker_media($attributes, $media, $src1, $src2, $rtmp);
    

				if (isset($this->conf['allowfullscreen']) && $this->conf['allowfullscreen'] == 'false') {
					$attributes['data-fullscreen'] = 'false';
				}       
	
				$ratio = round($height / $width, 4);   
        $this->fRatio = $ratio;
  
				$attributes['data-ratio'] = $ratio;
				if( $scaling == "fit" && $this->conf['fixed_size'] == 'fixed' ) {
					$attributes['data-flashfit'] = 'true';
				}
        
        if( isset($this->aCurArgs['live']) && $this->aCurArgs['live'] == 'true' ) {
					$attributes['data-live'] = 'true';
				}
        
				$playlist = '';
				$is_preroll = false;
				if( isset($playlist_items_external_html) ) {
          if( !isset($this->aCurArgs['playlist_hide']) || strcmp($this->aCurArgs['playlist_hide'],'true') != 0 ) {
            $this->sHTMLAfter .= $playlist_items_external_html;
          }
          $this->aPlaylists["wpfp_{$this->hash}"] = $aPlaylistItems;

          $attributes['style'] .= "background-image: url({$splash_img});";
          if( $autoplay ) {
            $this->ret['script']['fv_flowplayer_autoplay'][$this->hash] = true;				//  todo: any better way?
          }
				}
        
        if( isset($this->aCurArgs['admin_warning']) ) {
          $this->sHTMLAfter .= wpautop($this->aCurArgs['admin_warning']);
        }
				
				$attributes_html = '';
				$attributes = apply_filters( 'fv_flowplayer_attributes', $attributes, $media, $this );
				foreach( $attributes AS $attr_key => $attr_value ) {
					$attributes_html .= ' '.$attr_key.'="'.esc_attr( $attr_value ).'"';
				}
				
				$this->ret['html'] .= '<div id="wpfp_' . $this->hash . '"'.$attributes_html.'>'."\n";
				
				if (isset($this->aCurArgs['loop']) && $this->aCurArgs['loop'] == 'true') {
					$this->ret['script']['fv_flowplayer_loop'][$this->hash] = true;
				}
				
				if( count($aPlaylistItems) == 0 ) {	// todo: this stops subtitles, mobile video, preload etc.
					$this->ret['html'] .= "\t".'<video';      
					if (isset($splash_img) && !empty($splash_img)) {
						$this->ret['html'] .= ' poster="'.flowplayer::get_encoded_url($splash_img).'"';
					} 
					if( $autoplay == true ) {
						$this->ret['html'] .= ' autoplay';  
					}
					if (isset($this->aCurArgs['loop']) && $this->aCurArgs['loop'] == 'true') {
						$this->ret['html'] .= ' loop';
								
					}     
					if( isset($this->conf['auto_buffer']) && $this->conf['auto_buffer'] == 'true' && $this->autobuffer_count < apply_filters( 'fv_flowplayer_autobuffer_limit', 2 )) {
						$this->ret['html'] .= ' preload="auto"';
						$this->ret['html'] .= ' id="wpfp_'.$this->hash.'_video"';
					}	else if ($autoplay == false) {
						$this->ret['html'] .= ' preload="none"';        
					}        
											
          
          $scripts_after .= $this->get_chrome_fail_code( $media, $src1, $src2, $attributes_html );
          
					 
					$this->ret['html'] .= ">\n";
									          
          foreach( apply_filters( 'fv_player_media', array($media, $src1, $src2), $this ) AS $media_item ) {    
            $this->ret['html'] .= $this->get_video_src($media_item, array( 'mobileUserAgent' => $mobileUserAgent, 'rtmp' => $rtmp ) );
          }
					if (!empty($mobile)) {
						$this->ret['script']['fv_flowplayer_mobile_switch'][$this->hash] = true;
						$this->ret['html'] .= $this->get_video_src($mobile, array( 'id' => 'wpfp_'.$this->hash.'_mobile', 'mobileUserAgent' => $mobileUserAgent, 'rtmp' => $rtmp ) );
					}			
			
					if( isset($rtmp) && !empty($rtmp) ) {
            
            foreach( apply_filters( 'fv_player_media_rtmp', array($rtmp),$this ) AS $rtmp_item ) {            
              $rtmp_item = apply_filters( 'fv_flowplayer_video_src', $rtmp_item, $this );
   
              $rtmp_url = parse_url($rtmp_item);
              $rtmp_file = $rtmp_url['path'] . ( ( !empty($rtmp_url['query']) ) ? '?'. str_replace( '&amp;', '&', $rtmp_url['query'] ) : '' );
      
              $extension = $this->get_file_extension($rtmp_url['path'], 'mp4');
              if( $extension ) {
                $extension .= ':';
              }
              $this->ret['html'] .= "\t"."\t".'<source src="'.$extension.trim($rtmp_file, " \t\n\r\0\x0B/").'" type="video/flash" />'."\n";
            }
					}  
					
					if (isset($subtitles) && !empty($subtitles)) {
						$this->ret['html'] .= "\t"."\t".'<track src="'.esc_attr($subtitles).'" />'."\n";
					}     
					
					$this->ret['html'] .= "\t".'</video>';//."\n";
				}
								
				
				if( isset($splashend_contents) ) {
					$this->ret['html'] .= $splashend_contents;
				}
				if( $popup_contents = $this->get_popup_code() ) {
					$this->ret['html'] .= $popup_contents;  
				}
				if( $ad_contents = $this->get_ad_code() ) {
					$this->ret['html'] .= $ad_contents;  
				}
        if( current_user_can('manage_options') && !isset($playlist_items_external_html) ) {
					$this->ret['html'] .= '<div id="wpfp_'.$this->hash.'_admin_error" class="fvfp_admin_error"><div class="fvfp_admin_error_content"><h4>Admin JavaScript warning:</h4><p>I\'m sorry, your JavaScript appears to be broken. Please use "Check template" in plugin settings, read our <a href="https://foliovision.com/player/installation#fixing-broken-javascript">troubleshooting guide</a> or <a href="http://foliovision.com/wordpress/pro-install">order our pro support</a> and we will get it fixed for you.</p></div></div>';       
        }
        
        $this->ret['html'] .= apply_filters( 'fv_flowplayer_inner_html', null, $this );
              
        $this->ret['html'] .= $this->get_sharing_html()."\n";

        if( current_user_can('manage_options') && $this->conf['disable_videochecker'] != 'true' ) {
          $this->ret['html'] .= $this->get_video_checker_html()."\n";
        }
        
				$this->ret['html'] .= '</div>'."\n";
        
				$this->ret['html'] .= $this->sHTMLAfter.$scripts_after;
        
		} //  end Video player
    
    
    /*
     *  Youtube player
     */
    else if( $player_type == 'youtube' ) {
				
			$sAutoplay = ($autoplay) ? 'autoplay=1&amp;' : '';
			$this->ret['html'] .= "<iframe id='fv_ytplayer_{$this->hash}' type='text/html' width='{$width}' height='{$height}'
	  src='http://www.youtube.com/embed/$youtube?{$sAutoplay}origin=".urlencode(get_permalink())."' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\n";
			
		}
    
    
    /*
     *  Vimeo player
     */
    else if( $player_type == 'vimeo' ) {
		
			$sAutoplay = ($autoplay) ? " autoplay='1'" : "";
			$this->ret['html'] .= "<iframe id='fv_vimeo_{$this->hash}' src='//player.vimeo.com/video/{$vimeo}' width='{$width}' height='{$height}' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen{$sAutoplay}></iframe>\n";
			
		}
    
    
    /*
     *  Audio player
     */
    else {	//	$player_type == 'video' ends
			$this->build_audio_player( $media, $width, $autoplay );
		}
    
		$this->ret['html'] = apply_filters( 'fv_flowplayer_html', $this->ret['html'], $this );
		$this->ret['script'] = apply_filters( 'fv_flowplayer_scripts_array', $this->ret['script'], 'wpfp_' . $this->hash, $media );
		return $this->ret;
	}
  
  
  function build_audio_player( $media, $width, $autoplay ) {    			
			$this->load_mediaelement = true;
			
			$preload = ($autoplay == true) ? '' : ' preload="none"'; 
					
			$this->ret['script']['mediaelementplayer'][$this->hash] = true;
			$this->ret['html'] .= '<div id="wpfp_' . $this->hash . '" class="fvplayer fv-mediaelement">'."\n";			
      $this->ret['html'] .= "\t".'<audio src="'.$this->get_video_src( $media, array( 'url_only' => true ) ).'" type="audio/'.$this->get_file_extension($media).'" controls="controls" width="'.$width.'"'.$preload.'></audio>'."\n";  
			$this->ret['html'] .= '</div>'."\n";  
  }
  
  
  function get_ad_code() {
    $ad_contents = false;
    
    if(
      (
        ( isset($this->conf['ad']) ) && strlen(trim($this->conf['ad'])) ||
        ( isset($this->aCurArgs['ad']) && !empty($this->aCurArgs['ad']) )
      ) 
      &&
      !strlen($this->aCurArgs['ad_skip'])				
    ) {
      if (isset($this->aCurArgs['ad']) && !empty($this->aCurArgs['ad'])) {
        $ad = html_entity_decode( str_replace('&#039;',"'", trim($this->aCurArgs['ad']) ) );
        $ad_width = ( isset($this->aCurArgs['ad_width']) ) ? $this->aCurArgs['ad_width'].'px' : '60%';	
        $ad_height = ( isset($this->aCurArgs['ad_height']) ) ? $this->aCurArgs['ad_height'].'px' : '';					
      }
      else {
        $ad = trim($this->conf['ad']);			
        $ad_width = ( isset($this->conf['ad_width']) && $this->conf['ad_width'] ) ? $this->conf['ad_width'].'px' : '60%';	
        $ad_height = ( isset($this->conf['ad_height']) && $this->conf['ad_height'] ) ? $this->conf['ad_height'].'px' : '';
      }
      
      $ad = apply_filters( 'fv_flowplayer_ad_html', $ad);
      if( strlen(trim($ad)) > 0 ) {			
        $ad_contents = "\t<div id='wpfp_".$this->hash."_ad' class='wpfp_custom_ad'>\n\t\t<div class='wpfp_custom_ad_content' style='max-width: $ad_width; max-height: $ad_height; '>\n\t\t<div class='fv_fp_close'><a href='#' onclick='jQuery(\"#wpfp_".$this->hash."_ad\").fadeOut(); return false'></a></div>\n\t\t\t".$ad."\n\t\t</div>\n\t</div>\n";                  
      }
    }
    
    return $ad_contents;
  }
  
  
  function get_align() {
    $sClass = false;
    if( isset($this->aCurArgs['align']) ) {
      if( $this->aCurArgs['align'] == 'left' ) {
        $sClass .= ' alignleft';
      } else if( $this->aCurArgs['align'] == 'right' ) {
        $sClass .= ' alignright';
      } else if( $this->aCurArgs['align'] == 'center' ) {
        $sClass .= ' aligncenter';
      } 
    }
    return $sClass;
  }
  
  
  function get_chrome_fail_code( $media, $src1, $src2, $attributes_html ) {
    $count = $mp4_position = $webm_position = 0;
    $mp4_video = false;

    foreach( array( $media, $src1, $src2 ) AS $media_item ) {
      $count++;
      if( preg_match( '~\.(mp4|mov|m4v)~', $media_item ) ) {
        $mp4_position = $count;
        $mp4_video = $media_item;
      } else if( preg_match( '~\.webm~', $media_item ) ) {
        $webm_position = $count;
      } 					
    }			

    $scripts_after = false; 
    if( $mp4_position > $webm_position ) {
      if (isset($this->conf['auto_buffer']) && $this->conf['auto_buffer'] == 'true' && $this->autobuffer_count < apply_filters( 'fv_flowplayer_autobuffer_limit', 2 )) {
        $scripts_after = '<script type="text/javascript">
          if( /chrom(e|ium)/.test(navigator.userAgent.toLowerCase()) )  {
            document.getElementById("wpfp_'.$this->hash.'_video").setAttribute("preload", "none");
          }
          </script>					
        ';
      }
        
      $mp4_video = $this->get_video_src( $mp4_video, array( 'url_only' => true ) );
  
      $this->ret['script']['fv_flowplayer_browser_chrome_fail'][$this->hash] = array( 'attrs' => $attributes_html, 'mp4' => $mp4_video, 'auto_buffer' => ( (isset($this->conf['auto_buffer']) && $this->conf['auto_buffer'] == 'true') ? "true" : "false" ) );
    }
    
    return $scripts_after;
  }
  
  
  function get_popup_code() {
    if ( ( ( isset($this->conf['popupbox']) ) && ( $this->conf['popupbox'] == "true" ) ) || ( isset($this->aCurArgs['popup']) && !empty($this->aCurArgs['popup']) ) ) {
      if (isset($this->aCurArgs['popup']) && !empty($this->aCurArgs['popup'])) {
        $popup = trim($this->aCurArgs['popup']);
        $popup = html_entity_decode( str_replace('&#039;',"'",$popup ) );
      }
      else {
        $popup = 'Would you like to replay the video?';
      }
      
      $popup = apply_filters( 'fv_flowplayer_popup_html', $popup );
      if( strlen(trim($popup)) > 0 ) {			
        $popup_contents = '<div id="wpfp_'.$this->hash.'_custom_popup" class="wpfp_custom_popup"><div class="wpfp_custom_popup_content">'.$popup.'</div></div>';
        return $popup_contents;
      }
    }
    return false;
  }
  
  
  function get_splash() {
    $splash_img = false;
    if (isset($this->aCurArgs['splash']) && !empty($this->aCurArgs['splash'])) {
      $splash_img = $this->aCurArgs['splash'];
      if( strpos($splash_img,'http://') === false && strpos($splash_img,'https://') === false ) {
        $http = is_ssl() ? 'https://' : 'http://';
        
        //$splash_img = VIDEO_PATH.trim($this->aCurArgs['splash']);
        if($splash_img[0]=='/') $splash_img = substr($splash_img, 1);
          if((dirname($_SERVER['PHP_SELF'])!='/')&&(file_exists($_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']).VIDEO_DIR.$splash_img))){  //if the site does not live in the document root
            $splash_img = $http.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).VIDEO_DIR.$splash_img;
          }
          else
          if(file_exists($_SERVER['DOCUMENT_ROOT'].VIDEO_DIR.$splash_img)){ // if the videos folder is in the root
            $splash_img = $http.$_SERVER['SERVER_NAME'].VIDEO_DIR.$splash_img;//VIDEO_PATH.$media;
          }
          else {
            //if the videos are not in the videos directory but they are adressed relatively
            $splash_img_path = str_replace('//','/',$_SERVER['SERVER_NAME'].'/'.$splash_img);
            $splash_img = $http.$splash_img_path;
          }
      }
      else {
        $splash_img = trim($this->aCurArgs['splash']);
      }  		  		
    }
    $splash_img = apply_filters( 'fv_flowplayer_splash', $splash_img, $this );
    return $splash_img;
  }
  
  
  function get_subtitles() {
    if (isset($this->aCurArgs['subtitles']) && !empty($this->aCurArgs['subtitles'])) {
      $subtitles = $this->aCurArgs['subtitles'];
      if( strpos($subtitles,'http://') === false && strpos($subtitles,'https://') === false ) {
        //$splash_img = VIDEO_PATH.trim($this->aCurArgs['splash']);
        if($subtitles[0]=='/') $subtitles = substr($subtitles, 1);
          if((dirname($_SERVER['PHP_SELF'])!='/')&&(file_exists($_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']).VIDEO_DIR.$subtitles))){  //if the site does not live in the document root
            $subtitles = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).VIDEO_DIR.$subtitles;
          }
          else
          if(file_exists($_SERVER['DOCUMENT_ROOT'].VIDEO_DIR.$subtitles)){ // if the videos folder is in the root
            $subtitles = 'http://'.$_SERVER['SERVER_NAME'].VIDEO_DIR.$subtitles;//VIDEO_PATH.$media;
          }
          else {
            //if the videos are not in the videos directory but they are adressed relatively
            $subtitles = str_replace('//','/',$_SERVER['SERVER_NAME'].'/'.$subtitles);
            $subtitles = 'http://'.$subtitles;
          }
      }
      else {
        $subtitles = trim($this->aCurArgs['subtitles']);
      }
      return $subtitles;
    }
    return false;
  }
  
  
  function get_video_checker_media($attributes, $media, $src1, $src2, $rtmp) {
    
    if(
      current_user_can('manage_options') && $this->ajax_count < 100 && $this->conf['disable_videochecker'] != 'true' &&
      ( $this->conf['video_checker_agreement'] == 'true' || $this->conf['key_automatic'] == 'true' )
    ) {
      $this->ajax_count++;
      
      $rtmp_test = false;
      if( $rtmp && isset($attributes['data-rtmp']) ) {
        $rtmp_test = parse_url($rtmp);
        $rtmp_test = trailingslashit($attributes['data-rtmp']).ltrim($rtmp_test['path'],'/');
      }
    
      $aTest_media = array();
      foreach( array( $media, $src1, $src2, $rtmp_test ) AS $media_item ) {
        if( $media_item ) {
          $aTest_media[] = $this->get_video_src( $media_item, array( 'url_only' => true, 'dynamic' => true ) );
          //break;
        } 
      }    

      if( isset($aTest_media) && count($aTest_media) > 0 ) { 
        $this->ret['script']['fv_flowplayer_admin_test_media'][$this->hash] = $aTest_media;
      }
    }            

  }
  
  
  function get_sharing_html() {
  
    if( isset($this->aCurArgs['share']) ) { 
      $aSharing = explode( ';', $this->aCurArgs['share'] );
      if( count($aSharing) == 2 ) {
        $sPermalink = urlencode($aSharing[1]);
        $sMail = rawurlencode( apply_filters( 'fv_player_sharing_mail_content', 'Check the amazing video here: '.$aSharing[1] ) );
        $sTitle = urlencode( $aSharing[0].' ');
      } else if( count($aSharing) == 1 && $this->aCurArgs['share'] != 'yes' && $this->aCurArgs['share'] != 'no' ) {
        $sPermalink = urlencode($aSharing[0]);
        $sMail = rawurlencode( apply_filters( 'fv_player_sharing_mail_content', 'Check the amazing video here: '.$aSharing[0] ) );
        $sTitle = urlencode( get_bloginfo().' ');
      }
    }
				
    if( !isset($sPermalink) || empty($sPermalink) ) {  
      $sPermalink = urlencode(get_permalink());
      $sMail = rawurlencode( apply_filters( 'fv_player_sharing_mail_content', 'Check the amazing video here: '.get_permalink() ) );
      $sTitle = urlencode( (is_singular()) ? get_the_title() : get_bloginfo().' ');
    }
					
    $sHTMLSharing = '<label>Share the video</label><ul class="fvp-sharing">
    <li><a class="sharing-facebook" href="https://www.facebook.com/sharer/sharer.php?u='.$sPermalink.'" target="_blank">Facebook</a></li>
    <li><a class="sharing-twitter" href="https://twitter.com/home?status='.$sTitle.$sPermalink.'" target="_blank">Twitter</a></li>
    <li><a class="sharing-google" href="https://plus.google.com/share?url='.$sPermalink.'" target="_blank">Google+</a></li>
    <li><a class="sharing-email" href="mailto:?body='.$sMail.'" target="_blank">Email</a></li></ul>';

    $sHTMLEmbed = '<div><label><a class="embed-code-toggle" href="#"><strong>Embed</strong></a></label></div><div class="embed-code"><label>Copy and paste this HTML code into your webpage to embed.</label><textarea></textarea></div>';


    if( $this->aCurArgs['embed'] == 'false' || ( $this->conf['disableembedding'] == 'true' && $this->aCurArgs['embed'] != 'true' ) ) {
      $sHTMLEmbed = '';
    }
    
    if( isset($this->aCurArgs['share']) && $this->aCurArgs['share'] == 'no' ) {
      $sHTMLSharing = '';
    } else if( isset($this->aCurArgs['share']) && $this->aCurArgs['share'] != 'no' ) {
      
    } else if( $this->conf['disablesharing'] == 'true' ) {
      $sHTMLSharing = '';
    }

    $sHTML = false;
    if( $sHTMLSharing || $sHTMLEmbed ) {
      $sHTML = "<div class='fvp-share-bar'>$sHTMLSharing$sHTMLEmbed</div>";
    }

    return $sHTML;
  }
  
  
  function get_video_checker_html() {
    global $fv_wp_flowplayer_ver;
    $sSpinURL = site_url('wp-includes/images/wpspin.gif');

    $sHTML = <<< HTML
<div title="This note is visible to logged-in admins only." class="fv-wp-flowplayer-notice-small fv-wp-flowplayer-ok" id="wpfp_notice_{$this->hash}" style="display: none">
  <div class="fv_wp_flowplayer_notice_head" onclick="fv_wp_flowplayer_admin_show_notice('{$this->hash}', this.parent); return false">Report Issue</div>
  <small>Admin: <span class="video-checker-result">Checking the video file...</span></small>
  <div style="display: none;" class="fv_wp_fp_notice_content" id="fv_wp_fp_notice_{$this->hash}">
    <div class="mail-content-notice">
    </div>
    <div class="support-{$this->hash}">
      <textarea style="width: 98%; height: 150px" onclick="if( this.value == 'Enter your comment' ) this.value = ''" class="wpfp_message_field" id="wpfp_support_{$this->hash}">Enter your comment</textarea>
      <p><a class="techinfo" href="#" onclick="jQuery('.more-{$this->hash}').toggle(); return false">Technical info</a> <img style="display: none; " src="{$sSpinURL}" id="wpfp_spin_{$this->hash}"> <input type="button" value="Send report to Foliovision" onclick="fv_wp_flowplayer_admin_support_mail('{$this->hash}', this); return false"></p></div>
    <div class="more-{$this->hash} mail-content-details" style="display: none; ">
      <p>Plugin version: {$fv_wp_flowplayer_ver}</p>
      <div class="fv-wp-flowplayer-notice-parsed level-0"></div></div>
  </div>
</div>
HTML;

    return $sHTML;
  }
  
  
	/**
	 * Displays the elements that need to be added to frontend.
	 */
	function flowplayer_head() {
    include dirname( __FILE__ ) . '/../view/frontend-head.php';
	}
      
}

