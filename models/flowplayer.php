<?php
 
class flowplayer {
	private $count = 0;
	
	/**
	 * Relative URL path
	 */
	const RELATIVE_PATH = '';
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
	 * Class constructor
	 */
	public function __construct() {
		//set conf path
		///$this->conf_path = realpath(dirname(__FILE__)).'/../wpfp.conf';
		//load conf data into stack
		$this->_get_conf();
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
    if( !isset( $conf['key'] ) ) $conf['key'] = 'false';
    if( !isset( $conf['autobuffer'] ) ) $conf['autobuffer'] = 'false';
    if( !isset( $conf['popupbox'] ) ) $conf['popupbox'] = 'false';
    if( !isset( $conf['allowfullscreen'] ) ) $conf['allowfullscreen'] = 'true';
    if( !isset( $conf['allowuploads'] ) ) $conf['allowuploads'] = 'true';
    if( !isset( $conf['postthumbnail'] ) ) $conf['postthumbnail'] = 'false';
    if( !isset( $conf['tgt'] ) ) $conf['tgt'] = 'backgroundcolor';
    if( !isset( $conf['backgroundColor'] ) ) $conf['backgroundColor'] = '#1b1b1d';
    if( !isset( $conf['canvas'] ) ) $conf['canvas'] = '#ffffff';
    if( !isset( $conf['sliderColor'] ) ) $conf['sliderColor'] = '#2e2e2e';
    if( !isset( $conf['buttonColor'] ) ) $conf['buttonColor'] = '#454545';
    if( !isset( $conf['buttonOverColor'] ) ) $conf['buttonOverColor'] = '#ffffff';
    if( !isset( $conf['durationColor'] ) ) $conf['durationColor'] = '#ffffff';
    if( !isset( $conf['timeColor'] ) ) $conf['timeColor'] = '#ededed';
    if( !isset( $conf['progressColor'] ) ) $conf['progressColor'] = '#707070';
    if( !isset( $conf['bufferColor'] ) ) $conf['bufferColor'] = '#4d4d4d';
    if( !isset( $conf['commas'] ) ) $conf['commas'] = 'true';
    
    update_option( 'fvwpflowplayer', $conf );
    $this->conf = $conf;
    return true;	 
    /// End of addition
	}
	/**
	 * Writes configuration into file.
	 */
	public function _set_conf() {
	  //var_dump( $_POST );
	  foreach( $_POST AS $key => $value ) {
	    $_POST[$key] = preg_replace('/[^A-Za-z0-9]/', '', $value);
	    if( (strpos( $key, 'Color' ) !== FALSE )||(strpos( $key, 'canvas' ) !== FALSE)) {
	      $_POST[$key] = '#'.strtolower($value);
	    }
	  }
	  update_option( 'fvwpflowplayer', $_POST );
	  return;
	  
	}
	/**
	 * Salt function - returns pseudorandom string hash.
	 * @return Pseudorandom string hash.
	 */
	public function _salt() {
        $salt = substr(md5(uniqid(rand(), true)), 0, 10);    
        return $salt;
	}

	
}

/**
 * Defines some needed constants and loads the right flowplayer_head() function.
 */
function flowplayer_head() {
	// define needed constants
   preg_match('/.*wp-content\/plugins\/(.*?)\/models.*/',dirname(__FILE__),$matches);
   if (isset($matches[1]))
      $strFPdirname = $matches[1];
   else
       $strFPdirname = 'fv-wordpress-flowplayer';
	if (!defined('RELATIVE_PATH')) {
		define('RELATIVE_PATH', get_option('siteurl').'/wp-content/plugins/'.$strFPdirname);
	
    $conf = get_option( 'fvwpflowplayer' );
		if( !isset( $conf['key'] )||(!$conf['key'])||($conf['key']=='false') )
      define('PLAYER', RELATIVE_PATH.'/flowplayer/flowplayer.swf');
    else
      define('PLAYER', RELATIVE_PATH.'/flowplayer/commercial/flowplayer.commercial-3.1.5.swf');
    
		$vid = 'http://'.$_SERVER['SERVER_NAME'];
		if (dirname($_SERVER['PHP_SELF']) != '/') $vid .= dirname($_SERVER['PHP_SELF']);
		define('VIDEO_PATH', $vid.'/videos/');
	}
	// call the right function for displaying CSS and JS links
	if (class_exists('flowplayer_frontend')) {
		flowplayer_frontend::flowplayer_head();
	} else {
		flowplayer_backend::flowplayer_head();
	}
}

?>
