<?php
/*  FV Folopress Base Class - set of useful functions for Wordpress plugins    
    Copyright (C) 2013  Foliovision

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 

require_once( dirname(__FILE__) . '/../includes/fp-api.php' );

class flowplayer extends FV_Wordpress_Flowplayer_Plugin {
	private $count = 0;
	/**
	 * Relative URL path
	 */
	const FV_FP_RELATIVE_PATH = '';
	/**
	 * Where videos should be stored
	 */
	const VIDEO_PATH = '';
	/**
	 * Where the config file should be
	 */
	private $conf_path = '';
	/**
	 * Configuration variables array
	 */
	public $conf = array();
	/**
	 * We set this to true in shortcode parsing and then determine if we need to enqueue the JS, or if it's already included
	 */
	public $load_mediaelement = false;	
	/**
	 * Store scripts to load in footer
	 */
	public $scripts = array();		
	
	var $ret = array('html' => false, 'script' => false);
	
	var $hash = false;	
	
	public $ad_css_default = ".wpfp_custom_ad { position: absolute; bottom: 10%; z-index: 2; width: 100%; }\n.wpfp_custom_ad_content { background: white; margin: 0 auto; position: relative }";
	
	public $ad_css_bottom = ".wpfp_custom_ad { position: absolute; bottom: 0; z-index: 2; width: 100%; }\n.wpfp_custom_ad_content { background: white; margin: 0 auto; position: relative }";	
	
	/**
	 * Class constructor
	 */	
	public function __construct() {
		//load conf data into stack
		$this->_get_conf();
		
		if( is_admin() ) {
			//	update notices
		  $this->readme_URL = 'http://plugins.trac.wordpress.org/browser/fv-wordpress-flowplayer/trunk/readme.txt?format=txt';    
		  if( !has_action( 'in_plugin_update_message-fv-wordpress-flowplayer/flowplayer.php' ) ) {
	   		add_action( 'in_plugin_update_message-fv-wordpress-flowplayer/flowplayer.php', array( &$this, 'plugin_update_message' ) );
	   	}
	   	
	   	//	pointer boxes
	   	parent::__construct();
		}
		

		// define needed constants
		if (!defined('FV_FP_RELATIVE_PATH')) {
			define('FV_FP_RELATIVE_PATH', flowplayer::get_plugin_url() );
      
			$vid = 'http://'.$_SERVER['SERVER_NAME'];
			if (dirname($_SERVER['PHP_SELF']) != '/') 
				$vid .= dirname($_SERVER['PHP_SELF']);
			define('VIDEO_DIR', '/videos/');
			define('VIDEO_PATH', $vid.VIDEO_DIR);	
		}
    
    
    add_filter( 'fv_flowplayer_caption', array( $this, 'get_duration_playlist' ), 10, 3 );
    add_filter( 'fv_flowplayer_inner_html', array( $this, 'get_duration_video' ), 10, 2 );
    
    add_filter( 'fv_flowplayer_video_src', array( $this, 'get_amazon_secure'), 10, 2 );
	}
  
  
	/**
	 * Gets configuration from cfg file.
	 * 
	 * @return bool Returns false on failiure, true on success.
	 */
	private function _get_conf() {
	  ///  Addition  2010/07/12  mv
    $conf = get_option( 'fvwpflowplayer' );  
        
    if( !isset( $conf['autoplay'] ) ) $conf['autoplay'] = 'false';
    if( !isset( $conf['googleanalytics'] ) ) $conf['googleanalytics'] = 'false';
    if( !isset( $conf['key'] ) ) $conf['key'] = 'false';
    if( !isset( $conf['logo'] ) ) $conf['logo'] = 'false';
    if( !isset( $conf['rtmp'] ) ) $conf['rtmp'] = 'false';
    if( !isset( $conf['auto_buffer'] ) ) $conf['auto_buffer'] = 'false';
    if( !isset( $conf['scaling'] ) ) $conf['scaling'] = 'true';
    if( !isset( $conf['disableembedding'] ) ) $conf['disableembedding'] = 'false';
    if( !isset( $conf['popupbox'] ) ) $conf['popupbox'] = 'false';    
    if( !isset( $conf['allowfullscreen'] ) ) $conf['allowfullscreen'] = 'true';
    if( !isset( $conf['allowuploads'] ) ) $conf['allowuploads'] = 'true';
    if( !isset( $conf['postthumbnail'] ) ) $conf['postthumbnail'] = 'false';
    if( !isset( $conf['tgt'] ) ) $conf['tgt'] = 'backgroundcolor';
    if( !isset( $conf['backgroundColor'] ) ) $conf['backgroundColor'] = '#333333';
    if( !isset( $conf['canvas'] ) ) $conf['canvas'] = '#000000';
    if( !isset( $conf['sliderColor'] ) ) $conf['sliderColor'] = '#ffffff';
    /*if( !isset( $conf['buttonColor'] ) ) $conf['buttonColor'] = '#ffffff';
    if( !isset( $conf['buttonOverColor'] ) ) $conf['buttonOverColor'] = '#ffffff';*/
    if( !isset( $conf['durationColor'] ) ) $conf['durationColor'] = '#eeeeee';
    if( !isset( $conf['timeColor'] ) ) $conf['timeColor'] = '#eeeeee';
    if( !isset( $conf['progressColor'] ) ) $conf['progressColor'] = '#00a7c8';
    if( !isset( $conf['bufferColor'] ) ) $conf['bufferColor'] = '#eeeeee';
    if( !isset( $conf['timelineColor'] ) ) $conf['timelineColor'] = '#666666';
    if( !isset( $conf['borderColor'] ) ) $conf['borderColor'] = '#666666';
    if( !isset( $conf['hasBorder'] ) ) $conf['hasBorder'] = 'false';    
    if( !isset( $conf['adTextColor'] ) ) $conf['adTextColor'] = '#888';
    if( !isset( $conf['adLinksColor'] ) ) $conf['adLinksColor'] = '#ff3333';    
    if( !isset( $conf['parse_commas'] ) ) $conf['parse_commas'] = 'false';
    if( !isset( $conf['width'] ) ) $conf['width'] = '720';
    if( !isset( $conf['height'] ) ) $conf['height'] = '480';
    if( !isset( $conf['engine'] ) ) $conf['engine'] = 'false';
    if( !isset( $conf['font-face'] ) ) $conf['font-face'] = 'Tahoma, Geneva, sans-serif';
		if( !isset( $conf['ad'] ) ) $conf['ad'] = '';     
		if( !isset( $conf['ad_width'] ) ) $conf['ad_width'] = '';     
		if( !isset( $conf['ad_height'] ) ) $conf['ad_height'] = '';     
		if( !isset( $conf['ad_css'] ) ) $conf['ad_css'] = $this->ad_css_default;     		
		if( !isset( $conf['disable_videochecker'] ) ) $conf['disable_videochecker'] = 'false';            
    if( isset( $conf['videochecker'] ) && $conf['videochecker'] == 'off' ) { $conf['disable_videochecker'] = 'true'; unset($conf['videochecker']); }         
    if( !isset( $conf['interface'] ) ) $conf['interface'] = array( 'playlist' => false, 'redirect' => false, 'autoplay' => false, 'loop' => false, 'splashend' => false, 'embed' => false, 'subtitles' => false, 'ads' => false, 'mobile' => false, 'align' => false );        
    if( !isset( $conf['interface']['popup'] ) ) $conf['interface']['popup'] = 'true';    
		if( !isset( $conf['amazon_bucket'] ) || !is_array($conf['amazon_bucket']) ) $conf['amazon_bucket'] = array('');       
		if( !isset( $conf['amazon_key'] ) || !is_array($conf['amazon_key']) ) $conf['amazon_key'] = array('');   
		if( !isset( $conf['amazon_secret'] ) || !is_array($conf['amazon_secret']) ) $conf['amazon_secret'] = array('');  		
		if( !isset( $conf['amazon_expire'] ) ) $conf['amazon_expire'] = '5';
    if( !isset( $conf['amazon_expire_force'] ) ) $conf['amazon_expire_force'] = 'false';   
		if( !isset( $conf['fixed_size'] ) ) $conf['fixed_size'] = 'false';   		
		if( isset( $conf['responsive'] ) && $conf['responsive'] == 'fixed' ) { $conf['fixed_size'] = true; unset($conf['responsive']); }
    if( !isset( $conf['js-everywhere'] ) ) $conf['js-everywhere'] = 'false';
    if( !isset( $conf['marginBottom'] ) ) $conf['marginBottom'] = '28';
    if( !isset( $conf['ui_play_button'] ) ) $conf['ui_play_button'] = 'true';
    if( !isset( $conf['volume'] ) ) $conf['volume'] = 1;

    update_option( 'fvwpflowplayer', $conf );
    $this->conf = $conf;
    return true;	 
    /// End of addition
	}
	/**
	 * Writes configuration into file.
	 */
	public function _set_conf() {
	  $aNewOptions = $_POST;
	  $sKey = $aNewOptions['key'];

	  foreach( $aNewOptions AS $key => $value ) {
	  	if( is_array($value) ) {
      	$aNewOptions[$key] = $value;
      } else if( !in_array( $key, array('amazon_bucket', 'amazon_key', 'amazon_secret', 'font-face', 'ad', 'ad_css') ) ) {
      	$aNewOptions[$key] = trim( preg_replace('/[^A-Za-z0-9.:\-_\/]/', '', $value) );
      } else {
      	$aNewOptions[$key] = stripslashes($value);
      }
	    if( (strpos( $key, 'Color' ) !== FALSE )||(strpos( $key, 'canvas' ) !== FALSE)) {
	      $aNewOptions[$key] = '#'.strtolower($aNewOptions[$key]);
	    }
	  }
	  $aNewOptions['key'] = trim($sKey);
    $aOldOptions = is_array(get_option('fvwpflowplayer')) ? get_option('fvwpflowplayer') : array();
    
    if( isset($aNewOptions['db_duration']) && $aNewOptions['db_duration'] == "true" && ( !isset($aOldOptions['db_duration']) || $aOldOptions['db_duration'] == "false" ) ) {
      global $FV_Player_Checker;
      $FV_Player_Checker->queue_add_all();
    }
    
    if( !isset($aNewOptions['pro']) || !is_array($aNewOptions['pro']) ) {
      $aNewOptions['pro'] = array();
    }
    
    if( !isset($aOldOptions['pro']) || !is_array($aOldOptions['pro']) ) {
      $aOldOptions['pro'] = array();
    }    
 
    
    $aNewOptions['pro'] = array_merge($aOldOptions['pro'],$aNewOptions['pro']);
    $aNewOptions = array_merge($aOldOptions,$aNewOptions);
    $aNewOptions = apply_filters( 'fv_flowplayer_settings_save', $aNewOptions, $aOldOptions );
	  update_option( 'fvwpflowplayer', $aNewOptions );
    $this->conf = $aNewOptions;    
    
    $this->css_writeout();
    	     
	  return true;	
	}
	/**
	 * Salt function - returns pseudorandom string hash.
	 * @return Pseudorandom string hash.
	 */
	public function _salt() {
    $salt = substr(md5(uniqid(rand(), true)), 0, 10);    
    return $salt;
	}
  
  
  function build_playlist( $aArgs, $media, $src1, $src2, $rtmp, $splash_img, $suppress_filters = false ) {
    
      $sShortcode = isset($aArgs['playlist']) ? $aArgs['playlist'] : false;
      $sCaption = isset($aArgs['caption']) ? $aArgs['caption'] : false;
  
      $replace_from = array('&amp;','\;', '\,');				
      $replace_to = array('<!--amp-->','<!--semicolon-->','<!--comma-->');				
      $sShortcode = str_replace( $replace_from, $replace_to, $sShortcode );			
      $sItems = explode( ';', $sShortcode );

      if( $sCaption ) {
        $replace_from = array('&amp;quot;','&amp;','\;','&quot;');				
        $replace_to = array('"','<!--amp-->','<!--semicolon-->','"');				
        $sCaption = str_replace( $replace_from, $replace_to, $sCaption );
        $aCaption = explode( ';', $sCaption );        
      }
      if( isset($aCaption) && count($aCaption) > 0 ) {
        foreach( $aCaption AS $key => $item ) {
          $aCaption[$key] = str_replace('<!--amp-->','&',$item);
        }
      } 
      				
      $aItem = array();      
      $flash_media = array();
      
      if( $rtmp ) {
        $rtmp = 'rtmp:'.$rtmp;  
      }
      
      foreach( apply_filters( 'fv_player_media', array($media, $src1, $src2, $rtmp), $this ) AS $key => $media_item ) {
        if( !$media_item ) continue;
        $media_url = $this->get_video_src( preg_replace( '~^rtmp:~', '', $media_item ), array( 'url_only' => true, 'suppress_filters' => $suppress_filters ) );
        if( is_array($media_url) ) {
          $actual_media_url = $media_url['media'];
          if( $this->get_file_extension($actual_media_url) == 'mp4' ) {
            $flash_media[] = $media_url['flash'];
          }
        } else {
          $actual_media_url = $media_url;
        }
        if( stripos( $media_item, 'rtmp:' ) === 0 ) {
          $aItem[] = array( 'flash' => $this->get_file_extension($actual_media_url,'mp4').':'.$actual_media_url );
        } else {
          $aItem[] = array( $this->get_file_extension($actual_media_url) => $actual_media_url );
        }        
      }
      
      if( count($flash_media) ) {
        $bHaveFlash = false;
        foreach( $aItem AS $key => $aItemFile ) { //  how to avoid duplicates?
          if( in_array( 'flash', array_keys($aItemFile) ) ) {
            $bHaveFlash = true;
          }
        }
        
        if( !$bHaveFlash ) {
          foreach( $flash_media AS $flash_media_items ) {
            $aItem[] = array( 'flash' => $flash_media_items );
          }
        }      
      }
      
      $aPlaylistItems[] = $aItem;

      $sHTML = '';
      if( $sShortcode && count($sItems) > 0 ) {
        
        $sHTML = array();
        
        $sItemCaption = ( isset($aCaption) ) ? array_shift($aCaption) : false;
        $sItemCaption = apply_filters( 'fv_flowplayer_caption', $sItemCaption, $aItem, $aArgs );
        
        $splash_img = apply_filters( 'fv_flowplayer_playlist_splash', $splash_img, $this );
        
        $sHTML[] = "\t\t<a href='#' class='is-active' onclick='return false'><span ".( (isset($splash_img) && !empty($splash_img)) ? "style='background-image: url(\"".$splash_img."\")' " : "" )."></span>$sItemCaption</a>\n";
        
            
        foreach( $sItems AS $iKey => $sItem ) {
          $aPlaylist_item = explode( ',', $sItem );
        
          foreach( $aPlaylist_item AS $key => $item ) {
            if( $key > 0 && ( stripos($item,'http:') !== 0 && stripos($item,'https:') !== 0 && stripos($item,'rtmp:') !== 0 && stripos($item,'/') !== 0 ) ) {
              $aPlaylist_item[$key-1] .= ','.$item;              
              $aPlaylist_item[$key] = $aPlaylist_item[$key-1];
              unset($aPlaylist_item[$key-1]);
            }
            $aPlaylist_item[$key] = str_replace( $replace_to, $replace_from, $aPlaylist_item[$key] );	                        
          }
  
          $aItem = array();
          $sSplashImage = false;
          $flash_media = array();
          
          $sSplashImage = apply_filters( 'fv_flowplayer_playlist_splash', $sSplashImage, $this, $aPlaylist_item );

          foreach( apply_filters( 'fv_player_media', $aPlaylist_item, $this ) AS $aPlaylist_item_i ) {
            if( preg_match('~\.(png|gif|jpg|jpe|jpeg)($|\?)~',$aPlaylist_item_i) ) {
              $sSplashImage = $aPlaylist_item_i;
              continue;
            }
            
            $media_url = $this->get_video_src( preg_replace( '~^rtmp:~', '', $aPlaylist_item_i ), array( 'url_only' => true, 'suppress_filters' => $suppress_filters ) );
            if( is_array($media_url) ) {
              $actual_media_url = $media_url['media'];
              if( $this->get_file_extension($actual_media_url) == 'mp4' ) {
                $flash_media[] = $media_url['flash'];
              }
            } else {
              $actual_media_url = $media_url;
            }
            if( stripos( $media_item, 'rtmp:' ) === 0 ) {
              $aItem[] = array( 'flash' => $this->get_file_extension($actual_media_url,'mp4').':'.$actual_media_url ); 
            } else {
              $aItem[] = array( $this->get_file_extension($aPlaylist_item_i) => $actual_media_url ); 
            }                
            
          }
          
          if( count($flash_media) ) {
            $bHaveFlash = false;
            foreach( $aItem AS $key => $aItemFile ) {
              if( in_array( 'flash', array_keys($aItemFile) ) ) {
                $bHaveFlash = true;
              }
            }
            
            if( !$bHaveFlash ) {
              foreach( $flash_media AS $flash_media_items ) {
                $aItem[] = array( 'flash' => $flash_media_items );
              }
            }      
          }
      
          $aPlaylistItems[] = $aItem;
          $sItemCaption = ( isset($aCaption[$iKey]) ) ? __($aCaption[$iKey]) : false;
          $sItemCaption = apply_filters( 'fv_flowplayer_caption', $sItemCaption, $aItem, $aArgs );
          
          if( $sSplashImage ) {
            $sHTML[] = "\t\t<a href='#' onclick='return false'><span style='background-image: url(\"".$sSplashImage."\")'></span>$sItemCaption</a>\n";
          } else {
            $sHTML[] = "\t\t<a href='#' onclick='return false'><span></span>$sItemCaption</a>\n";
          }
          
        }
  
        $sHTML = "\t<div class='fp-playlist-external' rel='wpfp_{$this->hash}'>\n".implode( '', $sHTML )."\t</div>\n";

        $jsonPlaylistItems = str_replace( array('\\/', ','), array('/', ",\n\t\t"), json_encode($aPlaylistItems) );
        //$jsonPlaylistItems = preg_replace( '~"(.*)":"~', '$1:"', $jsonPlaylistItems );
      }

      return array( $sHTML, $aPlaylistItems );      
  }  
  
  
  
  
  function css_generate( $style_tag = true ) {
    global $fv_fp;
    
    $iMarginBottom = (isset($fv_fp->conf['marginBottom']) && intval($fv_fp->conf['marginBottom']) > -1 ) ? intval($fv_fp->conf['marginBottom']) : '28';
    
    if( $style_tag ) : ?>
      <style type="text/css">
    <?php endif;
    
    if ( isset($fv_fp->conf['key']) && $fv_fp->conf['key'] != 'false' && strlen($fv_fp->conf['key']) > 0 && isset($fv_fp->conf['logo']) && $fv_fp->conf['logo'] != 'false' && strlen($fv_fp->conf['logo']) > 0 ) : ?>		
      .flowplayer .fp-logo { display: block; opacity: 1; }                                              
    <?php endif;
  
    if( isset($fv_fp->conf['hasBorder']) && $fv_fp->conf['hasBorder'] == "true" ) : ?>
      .flowplayer { border: 1px solid <?php echo trim($fv_fp->conf['borderColor']); ?> !important; }
    <?php endif; ?>
  
    .flowplayer, flowplayer * { margin: 0 auto <?php echo $iMarginBottom; ?>px auto; display: block; }
    .flowplayer .fp-controls { background-color: <?php echo trim($fv_fp->conf['backgroundColor']); ?> !important; }
    .flowplayer { background-color: <?php echo trim($fv_fp->conf['canvas']); ?> !important; }
    .flowplayer .fp-duration { color: <?php echo trim($fv_fp->conf['durationColor']); ?> !important; }
    .flowplayer .fp-elapsed { color: <?php echo trim($fv_fp->conf['timeColor']); ?> !important; }
    .flowplayer .fp-volumelevel { background-color: <?php echo trim($fv_fp->conf['progressColor']); ?> !important; }  
    .flowplayer .fp-volumeslider { background-color: <?php echo trim($fv_fp->conf['bufferColor']); ?> !important; }
    .flowplayer .fp-timeline { background-color: <?php echo trim($fv_fp->conf['timelineColor']); ?> !important; }
    .flowplayer .fp-progress { background-color: <?php echo trim($fv_fp->conf['progressColor']); ?> !important; }
    .flowplayer .fp-buffer { background-color: <?php echo trim($fv_fp->conf['bufferColor']); ?> !important; }
    #content .flowplayer, .flowplayer { font-family: <?php echo trim($fv_fp->conf['font-face']); ?>; }
    
    .fvplayer .mejs-container .mejs-controls { background: <?php echo trim($fv_fp->conf['backgroundColor']); ?>!important; } 
    .fvplayer .mejs-controls .mejs-time-rail .mejs-time-current { background: <?php echo trim($fv_fp->conf['progressColor']); ?>!important; } 
    .fvplayer .mejs-controls .mejs-time-rail .mejs-time-loaded { background: <?php echo trim($fv_fp->conf['bufferColor']); ?>!important; } 
    .fvplayer .mejs-horizontal-volume-current { background: <?php echo trim($fv_fp->conf['progressColor']); ?>!important; } 
    .fvplayer .me-cannotplay span { padding: 5px; }
    #content .fvplayer .mejs-container .mejs-controls div { font-family: <?php echo trim($fv_fp->conf['font-face']); ?>; }
  
    .wpfp_custom_background { display: none; }	
    .wpfp_custom_popup { display: none; position: absolute; top: 10%; z-index: 2; text-align: center; width: 100%; color: #fff; }
    .is-finished .wpfp_custom_popup, .is-finished .wpfp_custom_background { display: block; }	
    .wpfp_custom_popup_content {  background: <?php echo trim($fv_fp->conf['backgroundColor']) ?>; padding: 1% 5%; width: 65%; margin: 0 auto; }
  
    <?php echo trim($this->conf['ad_css']); ?>
    .wpfp_custom_ad { color: <?php echo trim($fv_fp->conf['adTextColor']); ?>; }
    .wpfp_custom_ad a { color: <?php echo trim($fv_fp->conf['adLinksColor']); ?> }
    
    .fvfp_admin_error { color: <?php echo trim($fv_fp->conf['durationColor']); ?>; }
    .fvfp_admin_error a { color: <?php echo trim($fv_fp->conf['durationColor']); ?>; }
    #content .fvfp_admin_error a { color: <?php echo trim($fv_fp->conf['durationColor']); ?>; }
    .fvfp_admin_error_content {  background: <?php echo trim($fv_fp->conf['backgroundColor']); ?>; opacity:0.75;filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=75); }
  
    <?php if( $style_tag ) : ?>
      </style>  
    <?php endif;
  }
  
  
  function css_get() {
    global $fv_wp_flowplayer_ver;
    $bInline = true;
    $sURL = FV_FP_RELATIVE_PATH.'/css/flowplayer.css?ver='.$fv_wp_flowplayer_ver;    
    
    if( is_multisite() ) {
      global $blog_id;
      $site_id = $blog_id;
    } else {
      $site_id = 1;
    }

    if( isset($this->conf[$this->css_option()]) && $this->conf[$this->css_option()] ) {
      $filename = trailingslashit(WP_CONTENT_DIR).'fv-flowplayer-custom/style-'.$site_id.'.css';
      if( @file_exists($filename) ) {
        $sURL = trailingslashit( str_replace( array('/plugins','\\plugins'), '', plugins_url() )).'fv-flowplayer-custom/style-'.$site_id.'.css?ver='.$this->conf[$this->css_option()];
        $bInline = false;
      }
    }
    
    echo '<link rel="stylesheet" href="'.$sURL.'" type="text/css" media="screen" />'."\n";
    if( $bInline ) {
      $this->css_generate();
    }
    return ;
  }
  
  
  function css_option() {
    return 'css_writeout-'.sanitize_title(WP_CONTENT_URL);
  }
  
  
  function css_writeout() {
    $aOptions = get_option( 'fvwpflowplayer' );
    $aOptions[$this->css_option()] = false;
    update_option( 'fvwpflowplayer', $aOptions );
    
    /*$url = wp_nonce_url('options-general.php?page=fvplayer','otto-theme-options');
    if( false === ($creds = request_filesystem_credentials($url, $method, false, false, $_POST) ) ) { //  todo: no annoying notices here      
      return false; // stop the normal page form from displaying
    }   */ 
    
    if ( ! WP_Filesystem(true) ) {
      return false;
    }

    global $wp_filesystem;
    if( is_multisite() ) {
      global $blog_id;
      $site_id = $blog_id;
    } else {
      $site_id = 1;
    }
    $filename = $wp_filesystem->wp_content_dir().'fv-flowplayer-custom/style-'.$site_id.'.css';
     
    // by this point, the $wp_filesystem global should be working, so let's use it to create a file
    
    $bDirExists = false;
    if( !$wp_filesystem->exists($wp_filesystem->wp_content_dir().'fv-flowplayer-custom/') ) {
      if( $wp_filesystem->mkdir($wp_filesystem->wp_content_dir().'fv-flowplayer-custom/') ) {
        $bDirExists = true;
      }
    } else {
      $bDirExists = true;
    }
    
    if( !$bDirExists ) {
      return false;
    }
    
    ob_start();
    $this->css_generate(false);
    $sCSS = "\n/*CSS writeout performed on FV Flowplayer Settings save  on ".date('r')."*/\n".ob_get_clean();    
    if( !$sCSSCurrent = $wp_filesystem->get_contents( self::get_plugin_url().'/css/flowplayer.css' ) ) {
      return false;
    }
    $sCSSCurrent = preg_replace( '~url\((")?~', 'url($1'.self::get_plugin_url().'/css/', $sCSSCurrent ); //  fix relative paths!

    if( !$wp_filesystem->put_contents( $filename, $sCSSCurrent.$sCSS, FS_CHMOD_FILE) ) {
      return false;
    } else {
      $aOptions[$this->css_option()] = date('U');
      update_option( 'fvwpflowplayer', $aOptions );
      $this->conf = $aOptions;
    }
  }
  
  
  function get_amazon_secure( $media ) {
    $aArgs = func_get_args();
    $aArgs = $aArgs[1];
    global $fv_fp;
  
		$amazon_key = -1;
  	if( !empty($fv_fp->conf['amazon_key']) && !empty($fv_fp->conf['amazon_secret']) && !empty($fv_fp->conf['amazon_bucket']) ) {
  		foreach( $fv_fp->conf['amazon_bucket'] AS $key => $item ) {
  			if( stripos($media,$item.'/') != false  || stripos($media,$item.'.') != false ) {
  				$amazon_key = $key;
  				break;
  			}
  		}
  	}
  	
  	if( $amazon_key != -1 && !empty($fv_fp->conf['amazon_key'][$amazon_key]) && !empty($fv_fp->conf['amazon_secret'][$amazon_key]) && !empty($fv_fp->conf['amazon_bucket'][$amazon_key]) && stripos( $media, trim($fv_fp->conf['amazon_bucket'][$amazon_key]) ) !== false && apply_filters( 'fv_flowplayer_amazon_secure_exclude', $media ) ) {
  	
			$resource = trim( $media );

			if( !isset($fv_fp->expire_time) ) {
				$time = 60 * intval($fv_fp->conf['amazon_expire']);
			} else {
				$time = intval(ceil($fv_fp->expire_time));
			}
      
      if( isset($fv_fp->conf['amazon_expire']) && $fv_fp->conf['amazon_expire_force'] == 'true' ) {
        $time = 60 * intval($fv_fp->conf['amazon_expire']);
      }
      
			if( $time < 900 ) {
				$time = 900;
			}
      
			$time = apply_filters( 'fv_flowplayer_amazon_expires', $time, $media );
			$expires = time() + $time;
		 
			$url_components = parse_url($resource);
			$url_components['path'] = rawurlencode($url_components['path']); 
			$url_components['path'] = str_replace('%2F', '/', $url_components['path']);
			$url_components['path'] = str_replace('%2B', '+', $url_components['path']);			
			if( strpos( $url_components['path'], $fv_fp->conf['amazon_bucket'][$amazon_key] ) === false ) {
				$url_components['path'] = '/'.$fv_fp->conf['amazon_bucket'][$amazon_key].$url_components['path'];
			}
		      
      do {
        $expires++;
        $stringToSign = "GET\n\n\n$expires\n{$url_components['path']}";	
      
        $signature = utf8_encode($stringToSign);
  
        $signature = hash_hmac('sha1', $signature, $fv_fp->conf['amazon_secret'][$amazon_key], true);
        $signature = base64_encode($signature);
        
        $signature = urlencode($signature);        
      } while( stripos($signature,'%2B') !== false );      
		
			$url = $resource;
      
      if( $aArgs['url_only'] ) {
        $url .= '?AWSAccessKeyId='.$fv_fp->conf['amazon_key'][$amazon_key].'&Expires='.$expires.'&Signature='.$signature;
      } else {
        $url .= '?AWSAccessKeyId='.$fv_fp->conf['amazon_key'][$amazon_key].'&amp;Expires='.$expires.'&amp;Signature='.$signature;
      }    
			
						 
			$media = $url;
						
			$this->ret['script']['fv_flowplayer_amazon_s3'][$this->hash] = $time;
  	}
  	
  	return $media;
  }
  
  
  public static function get_duration( $post_id, $video_src ) {
    $sDuration = false;
    if( $sVideoMeta = get_post_meta( $post_id, flowplayer::get_video_key($video_src), true ) ) {  //  todo: should probably work regardles of quality version
      if( isset($sVideoMeta['duration']) && $sVideoMeta['duration'] > 0 ) {
        $tDuration = $sVideoMeta['duration'];
        if( $tDuration < 3600 ) {
          $sDuration = gmdate( "i:s", $tDuration );
        } else {
          $sDuration = gmdate( "H:i:s", $tDuration );
        }
      }      
    }
    return $sDuration;
  }
  
  
  public static function get_duration_post( $post_id = false ) {
    global $post, $fv_fp;
    $post_id = ( $post_id ) ? $post_id : $post->ID;

    $content = false;
    $objPost = get_post($post_id);
    if( $aVideos = FV_Player_Checker::get_videos($objPost->post_content) ) {
      if( $sDuration = flowplayer::get_duration($post_id, $aVideos[0]) ) {
        $content = $sDuration;
      }
    }
    
    return $content;
  }   
  
  
  public static function get_duration_playlist( $caption ) {
    global $fv_fp;
    if( !isset($fv_fp->conf['db_duration']) || $fv_fp->conf['db_duration'] != 'true' || !$caption ) return $caption;
    
    global $post;
    $aArgs = func_get_args();
    
    if( isset($aArgs[1][0]) && is_array($aArgs[1][0]) ) {        
      $sItemKeys = array_keys($aArgs[1][0]);
      if( $sDuration = flowplayer::get_duration( $post->ID, $aArgs[1][0][$sItemKeys[0]] ) ) {
        $caption .= '<i class="dur">'.$sDuration.'</i>';
      } 
    }
    
    return $caption;
  }
  
  
  public static function get_duration_video( $content ) {
    global $fv_fp, $post;    
    if( !isset($fv_fp->conf['db_duration']) || $fv_fp->conf['db_duration'] != 'true' ) return $content;

    $aArgs = func_get_args();
    if( $sDuration = flowplayer::get_duration( $post->ID, $aArgs[1]->aCurArgs['src']) ) {
      $content .= '<div class="fvfp_duration">'.$sDuration.'</div>';
    }
    
    return $content;
  }    
  
  
  public static function get_encoded_url( $sURL ) {
    //if( !preg_match('~%[0-9A-F]{2}~',$sURL) ) {
      $url_parts = parse_url( $sURL );
      $url_parts_encoded = parse_url( $sURL );			
      if( !empty($url_parts['path']) ) {
          $url_parts['path'] = join('/', array_map('rawurlencode', explode('/', $url_parts_encoded['path'])));
      }
      if( !empty($url_parts['query']) ) {
          $url_parts['query'] = str_replace( '&amp;', '&', $url_parts_encoded['query'] );				
      }
      
      $url_parts['path'] = str_replace( '%2B', '+', $url_parts['path'] );
      return http_build_url($sURL, $url_parts);
    /*} else {
      return $sURL;
    }*/    
  }
  
  
  function get_file_extension($media, $default = 'flash' ) {
    $pathinfo = pathinfo( trim($media) );

    $extension = ( isset($pathinfo['extension']) ) ? $pathinfo['extension'] : false;       
    $extension = preg_replace( '~[?#].+$~', '', $extension );
    $extension = strtolower($extension);
    
		if( !$extension ) {
			$output = $default;
		} else {
      if ($extension == 'm3u8' || $extension == 'm3u') {
        $output = 'x-mpegurl';
      } else if ($extension == 'm4v') {
        $output = 'mp4';
      } else if( $extension == 'mp3' ) {
        $output = 'mpeg';
      } else if( $extension == 'wav' ) {
        $output = 'wav';
      } else if( $extension == 'ogg' ) {
        $output = 'ogg';
      } else if( $extension == 'ogv' ) {
        $output = 'ogg';
      } else if( $extension == 'mov' ) {
        $output = 'mp4';
      } else if( $extension == '3gp' ) {
        $output = 'mp4';      
      } else if( !in_array($extension, array('mp4', 'm4v', 'webm', 'ogv', 'mp3', 'ogg', 'wav', '3gp')) ) {
        $output = $default;  
      } else {
        $output = $extension;
      }
    }

    return apply_filters( 'fv_flowplayer_get_file_extension', $output, $media );  
  }
  
  
  public static function get_plugin_url() {
    if( stripos( __FILE__, '/themes/' ) !== false || stripos( __FILE__, '\\themes\\' ) !== false ) {
      return get_template_directory_uri().'/fv-wordpress-flowplayer';
    } else {
      return plugins_url( '', str_replace( array('/models','\\models'), '', __FILE__ ) );
    }
  }
  
  
  public static function get_video_key( $sURL ) {
    $sURL = preg_replace( '~\?.*$~', '', $sURL );
    $sURL = str_replace( array('/','://'), array('-','-'), $sURL );
    return '_fv_flowplayer_'.sanitize_title($sURL);
  }
  
  
  
  
  function get_video_src($media, $aArgs ) {
    $aArgs = wp_parse_args( $aArgs, array(
          'dynamic' => false,
          'id' => false,
          'mobileUserAgent' => false,
          'rtmp' => false,        
          'suppress_filters' => false,
          'url_only' => false
        )
      );
    
  	if( $media ) { 
			$extension = $this->get_file_extension($media);
			//do not use https on mobile devices
			if (strpos($media, 'https') !== false && $aArgs['mobileUserAgent']) {
				$media = str_replace('https', 'http', $media);
			}
			$sID = ($aArgs['id']) ? 'id="'.$aArgs['id'].'" ' : '';
	
      if( !$aArgs['suppress_filters'] ) {
        $media = apply_filters( 'fv_flowplayer_video_src', $media, $aArgs );          
      }
			
			//	fix for signed Amazon URLs, we actually need it for Flash only, so it gets into an extra source tag
			$source_flash_encoded = false;	
			if( $this->is_secure_amazon_s3($media) /*&& stripos($media,'.webm') === false && stripos($media,'.ogv') === false */) {
					$media_fixed = str_replace('%2B', '%25252B',$media);   
					//	only if there was a change and we don't have an RTMP for Flash
					if( $media_fixed != $media && empty($aArgs['rtmp']) ) {
            $source_flash_encoded = $media_fixed;
					}
			}
			
			$url_parts = parse_url( ($source_flash_encoded) ? $source_flash_encoded : $media );					
			if( isset($url_parts['path']) && stripos( $url_parts['path'], '+' ) !== false ) {

				if( !empty($url_parts['path']) ) {
						$url_parts['path'] = join('/', array_map('rawurlencode', explode('/', $url_parts['path'])));
				}
				if( !empty($url_parts['query']) ) {
						//$url_parts['query'] = str_replace( '&amp;', '&', $url_parts['query'] );				
				}
				
				$source_flash_encoded = http_build_url( ($source_flash_encoded) ? $source_flash_encoded : $media, $url_parts);
			}
			
			if( $aArgs['url_only'] ) {
        if( $source_flash_encoded ) {
          return array( 'media' => $media, 'flash' => $source_flash_encoded );
        } else {
        	return trim($media);
        }
			} else {
        $mime_type = ( $extension == 'x-mpegurl' ) ? 'application/x-mpegurl' : 'video/'.$extension;
				$sReturn = '<source '.$sID.'src="'.trim($media).'" type="'.$mime_type.'" />'."\n";
        
        if( $source_flash_encoded && strcmp($extension,'mp4') == 0 ) {
          $sReturn .= '<source '.$sID.'src="'.trim($source_flash_encoded).'" type="video/flash" />'."\n";
        }
        return $sReturn;
			}
    }
    return null;
  }
  
  
  function get_video_url($media) {
  	if( strpos($media,'rtmp://') !== false ) {
  		return null;
  	}
    if( strpos($media,'http://') === false && strpos($media,'https://') === false ) {
      $http = is_ssl() ? 'https://' : 'http://';
			// strip the first / from $media
      if($media[0]=='/') $media = substr($media, 1);
      if((dirname($_SERVER['PHP_SELF'])!='/')&&(file_exists($_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']).VIDEO_DIR.$media))){  //if the site does not live in the document root
        $media = $http.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).VIDEO_DIR.$media;
      }
      else if(file_exists($_SERVER['DOCUMENT_ROOT'].VIDEO_DIR.$media)){ // if the videos folder is in the root
        $media = $http.$_SERVER['SERVER_NAME'].VIDEO_DIR.$media;//VIDEO_PATH.$media;
      }
      else{ // if the videos are not in the videos directory but they are adressed relatively
        $media_path = str_replace('//','/',$_SERVER['SERVER_NAME'].'/'.$media);
        $media = $http.$media_path;
      }
		}
    
    $media = apply_filters( 'fv_flowplayer_media', $media, $this );
    
    return $media;
  }  
  
  
  public static function is_licensed() {
    global $fv_fp;
		return preg_match( '!^\$\d+!', $fv_fp->conf['key'] );
	}
  
	
	public function is_secure_amazon_s3( $url ) {
		return preg_match( '/^.+?s3.*?\.amazonaws\.com\/.+Signature=.+?$/', $url ) || preg_match( '/^.+?\.cloudfront\.net\/.+Signature=.+?$/', $url );
	}
	
  
}
/**
 * Defines some needed constants and loads the right flowplayer_head() function.
 */
function flowplayer_head() {
	global $fv_fp;	
  $fv_fp->flowplayer_head();
}




function flowplayer_jquery() {
  global $fv_wp_flowplayer_ver, $fv_fp;
  
}




function fv_wp_flowplayer_save_post( $post_id ) {
	if( $parent_id = wp_is_post_revision($post_id) ) {
  	$post_id = $parent_id;
  }
  
  $post_id = ( isset($post->ID) ) ? $post->ID : $post_id;
  
  global $fv_fp, $post, $FV_Player_Checker;
  if( !$FV_Player_Checker->is_cron && $FV_Player_Checker->queue_check($post_id) ) {
    return;
  }
  
  $saved_post = get_post($post_id);
  $videos = FV_Player_Checker::get_videos($saved_post->post_content);

  $iDone = 0;
  if( is_array($videos) && count($videos) > 0 ) {
    $tStart = microtime(true);
  	foreach( $videos AS $video ) {
    	if( microtime(true) - $tStart > apply_filters( 'fv_flowplayer_checker_save_post_time', 5 ) ) {
        FV_Player_Checker::queue_add($post->ID);
        break;
      }
      
    	if( !get_post_meta( $post->ID, flowplayer::get_video_key($video), true ) ) {
        $video_secured = $fv_fp->get_video_src( $video, array( 'dynamic' => true, 'url_only' => true ) );
      	if( isset($video_secured['media']) && $FV_Player_Checker->check_mimetype( array($video_secured['media']), array( 'meta_action' => 'check_time', 'meta_original' => $video ) ) ) {
          $iDone++;
        } else {
          FV_Player_Checker::queue_add($post->ID);
        }
      } else {
        $iDone++;
      }
      
  	}
  }

  if( $iDone == count($videos) ) {
    FV_Player_Checker::queue_remove($post->ID);
  }
}

