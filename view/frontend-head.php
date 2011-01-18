<?php
/**
 * Displays metatags for frontend.
 */

?>
<?php    
   $aUserAgents =	array('iphone', 'iPod', 'iPad', 'aspen', 'incognito', 'webmate', 'android', 'dream', 'cupcake', 'froyo', 'blackberry9500', 'blackberry9520', 'blackberry9530', 'blackberry9550', 'blackberry9800', 'Palm', 'webos', 's8000', 'bada', 'Opera Mini', 'Opera Mobi');
   $mobileUserAgent = false;
   foreach($aUserAgents as $userAgent){
      if(stripos($_SERVER['HTTP_USER_AGENT'],$userAgent))
         $mobileUserAgent = true;
   }

      
?>
<?php if($mobileUserAgent==false){ ?>
<script type="text/javascript" src="<?php echo RELATIVE_PATH; ?>/flowplayer/flowplayer.min.js"></script>
<?php }  ?>
<link rel="stylesheet" href="<?php echo RELATIVE_PATH; ?>/css/flowplayer.css" type="text/css" media="screen" />
<?php if($mobileUserAgent==false){ ?>
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="<?php echo RELATIVE_PATH; ?>/js/pngfix.js"></script>
<![endif]-->
<script type="text/javascript">	
	/*<![CDATA[*/
		function fp_replay(hash) {
			var fp = document.getElementById('wpfp_'+hash);
			var popup = document.getElementById('wpfp_'+hash+'_popup');
			fp.removeChild(popup);
			flowplayer('wpfp_'+hash).play();
		}
	
		function fp_share(hash) {
			var cp = document.getElementById('wpfp_'+hash+'_custom_popup');
			cp.innerHTML = '<div style="margin-top: 10px; text-align: center;"><label for="permalink" style="color: white;">Permalink to this page:</label><input onclick="this.select();" id="permalink" name="permalink" type="text" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" /></div>';
		}
	/*]]>*/
</script>
<?php } ?>