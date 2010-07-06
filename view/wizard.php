<?
if (isset($_COOKIE["selected_video"]))
   $uploaded_video = $_COOKIE["selected_video"];
if (isset($_COOKIE["selected_image"]))
   $uploaded_image = $_COOKIE["selected_image"];
  

  $post_id = intval($_REQUEST['post_id']);
  //load configuration file:   
  $conf_path = realpath(dirname(__FILE__).'/../wpfp.conf');
  $allow_uploads=false;
  if(file_exists($conf_path)){    
			//open file for reading
			$fp = fopen($conf_path,'r');
			//check if failed to open
			if(!$fp) {
				$allow_update=false;
			} else {
				//read data
				$data = fread($fp,filesize($conf_path));
				//get each line
				$tmp = explode("\n",$data);
				//get each var
				foreach($tmp as $key => $dat) {
					//split from var:val
					$data = explode(':', $dat);
					//build into conf stack
					$conf[$data[0]] = $data[1];
					$return = true;
				}
			}
			fclose($fp);		
	}
	if (isset($conf["allowuploads"]))
	  $allow_uploads = $conf["allowuploads"];
	  
	if (isset($conf["postthumbnail"]))
	  $post_thumbnail = $conf["postthumbnail"];
	$video_types = array('flv','mov','avi','mpeg','mpg','asf','qt','wmv','mp4');
  $splash_types = array('jpg','jpeg','gif','png', 'bmp','jpe');
  if (isset($selected_attachment['url'])) 
  {
      $path_parts = pathinfo($selected_attachment['url']);
      if (in_array($path_parts['extension'], $video_types))
         $uploaded_video = $selected_attachment['url'];
      if (in_array($path_parts['extension'], $splash_types))
         $uploaded_image = $selected_attachment['url'];
   }
   if (isset($uploaded_video)){
      $serv = $_SERVER['SERVER_NAME'];
      $pattern = '/'.$serv.'(.*)/';
      preg_match($pattern, $uploaded_video, $matches);
      require_once(realpath(dirname(__FILE__).'/getid3/getid3.php'));
      // Initialize getID3 engine
      $getID3 = new getID3;
      
      $ThisFileInfo = $getID3->analyze(realpath($_SERVER['DOCUMENT_ROOT'] .$matches[1]));
      if (isset($ThisFileInfo['error'])) $file_error = "Could not read video details, please fill the width and height manually.";
      //getid3_lib::CopyTagsToComments($ThisFileInfo);
      $file_time = $ThisFileInfo['playtime_string'];            // playtime in minutes:seconds, formatted string
      $file_width = $ThisFileInfo['video']['resolution_x'];          
      $file_height = $ThisFileInfo['video']['resolution_y'];
      $file_size = $ThisFileInfo['filesize'];           
      $file_size = round($file_size/(1024*1024),2);                
   }  	    
   

?>
<script type="text/javascript">
function fillVideoInputs(){
   var vid_list = document.getElementById("files_video");
   var item = vid_list.options[vid_list.selectedIndex].title;
//   alert(item); 
   document.getElementById("src").value = item;
   document.getElementById("hidden_video").value = item;
}
function fillSplashInputs(){
   var spl_list = document.getElementById("files_splash");
   var item = spl_list.options[spl_list.selectedIndex].title;
//   alert(item); 
   document.getElementById("splash").value = item;
   document.getElementById("hidden_splash").value = item;
   document.cookie = "selected_image="+item+";";
}
</script>
<form>
	<table class="slidetoggle describe">
		<tbody>
			<tr>
				<th valign="top" scope="row" class="label"><span class="alignright">Video</span></th>
				<td colspan="2" class="field" style="width: 75%"><input type="text" class="text" id="src" name="src" style="width: 100%" value="<?php echo $uploaded_video ?>"/></td>
			</tr>
			<?php 
         if ($allow_uploads=="true") { 
			echo '<tr>
			<th></th>
			<td colspan="2" style="width: 100%" >         
         Or <a href="media-upload.php?post_id='.$post_id.'&amp;type=video&amp;TB_iframe=true&amp;width=640&amp;height=723">open media library</a> to upload new video.
			</td>
			</tr>';
			 }; //allow uplads video ?>

			<?php if (!empty($uploaded_video)){?>
			   <tr><th></th>
         <th valign="top" scope="row" class="label"><span class="alignleft">File info</span></th><td>
           <? if (!empty($file_width)){?>
            Video Duration: <?php echo $file_time ?><br />
            File size: <?php echo $file_size ?>MB
            <? } else echo $file_error;  ?>
            </td>
         </tr>
      <? }; //video has been selected ?>
			<tr><th></th>
				<th valign="top" scope="row" class="label" ><span class="alignleft">Width <small>(px)</small></span><br class='clear' /></th>
				<td class="field"><input type="text" id="width" name="width" style="width: 100%"  value="<?php echo $file_width ?>"/></td>
			</tr>
			<tr><th></th>
				<th valign="top" scope="row" class="label" style="width: 10%"><span class="alignleft">Height <small>(px)</small></span></th>
				<td class="field"><input type="text" id="height" name="height" style="width: 100%" value="<?php echo $file_height ?>"/></td>
			</tr>
			<tr>
				<th valign="top" scope="row" class="label"><span class="alignright">Splash Image</span></th>
				<td class="field" colspan="2"><input type="text" id="splash" name="splash" style="width: 100%"  value="<?php echo $uploaded_image ?>"/></td>
			</tr>
			<? if ($allow_uploads=='true') {
			echo '<tr>
  			<th></th>
  			<td colspan="2" class="field" style="width: 100%" >
        Or <a href="media-upload.php?type=image&amp;post_id='.$post_id .'&amp;TB_iframe=true&amp;width=640&amp;height=723">open media library</a> to upload new splash image.
        </td>
			</tr>';
			 }; //allow uplads splash image ?>
			<? if (!empty($uploaded_image))
          if (($post_thumbnail=='true') && current_theme_supports( 'post-thumbnails') && isset($selected_attachment['id'])) 
             update_post_meta( $post_id, '_thumbnail_id', $selected_attachment['id'] );?>
			<tr>
				<th valign="top" scope="row" class="label"><span class="alignright">HTML Popup</span></th>
				<td colspan="2"><textarea type="text" id="popup" name="popup" style="width: 100%"></textarea></td>
			</tr>
			<tr>
				<th valign="top" scope="row" class="label"><span class="alignright">Autoplay</span></th>
				<td colspan="2" class="field"><input type="checkbox" id="autoplay" name="autoplay" /></td>
			</tr>
			<tr>
				<th valign="top" scope="row" class="label">
					<input type="button" value="Insert" name="insert" id="insert-button" class="button-primary" onclick="clickOK();" />
				</th>
			</tr>
		</tbody>
	</table>
</form>

<script type="text/javascript">
	console.log( document );
	//window.parent.send_to_editor( '<span id="FCKFVWPFlowplayerPlaceholder"></span>' );

	var re = /\[flowplayer[^\[]*?<span>FCKFVWPFlowplayerPlaceholder<\/span>[^\[]*?\]/mi;
	var re2 = /<span>FCKFVWPFlowplayerPlaceholder<\/span>/gi;
	var hTinyMCE = window.parent.tinyMCE.getInstanceById('content');
	//console.log(window.parent.tinyMCE.activeEditor.isHidden() );
	if( hTinyMCE == undefined || window.parent.tinyMCE.activeEditor.isHidden() ) {
		//console.log( 'not in wysiwyg' );
	}
	else {
		hTinyMCE.selection.setContent('<span>FCKFVWPFlowplayerPlaceholder</span>');
		
		content_original = hTinyMCE.getContent();
		content = content_original.replace(/\n/g,'\uffff');
	     
		var shortcode = content.match( re );
		
		
		hTinyMCE.setContent( hTinyMCE.getContent().replace( re2,'' ) );
		
		if( shortcode != null ) {
			shortcode = shortcode.join('');
			shortcode = shortcode.replace( re2,'' );
			
			shortcode = shortcode.replace( /\\'/g,'&#039;' );
			
			//alert(shortcode);
			srcurl = shortcode.match( /src='([^']*)'/ );
			if( srcurl == null )
				srcurl = shortcode.match( /src=([^,\]\s]*)/ );
			
			iheight = shortcode.match( /height=(\d*)/ );
			
			iwidth = shortcode.match( /width=(\d*)/ );
			sautoplay = shortcode.match( /autoplay=([^\s]+)/ );
			ssplash = shortcode.match( /splash='([^']*)'/ );
			if( ssplash == null )
				ssplash = shortcode.match( /splash=([^,\]\s]*)/ );
			
			spopup = shortcode.match( /popup='([^']*)'/ );
	
			//alert( srcurl[1] + '\n' + iheight[1] + '\n' + iwidth[1] + '\n' + splash[1] + '\n' + popup[1] );

			if( srcurl != null && srcurl[1] != null )
				document.getElementById("src").value = srcurl[1];
			if( iheight != null && iheight[1] != null )
				document.getElementById("height").value = iheight[1];
			if( iwidth != null && iwidth[1] != null )
				document.getElementById("width").value = iwidth[1];
			if( sautoplay != null && sautoplay[1] != null )
				document.getElementById("autoplay").value = sautoplay[1];
			if( ssplash != null && ssplash[1] != null )
				document.getElementById("splash").value = ssplash[1];
			if( spopup != null && spopup[1] != null ) {
				spopup = spopup[1].replace(/&#039;/g,'\'').replace(/&quot;/g,'"').replace(/&lt;/g,'<').replace(/&gt;/g,'>');
				spopup = spopup.replace(/&amp;/g,'&');
				document.getElementById("popup").value = spopup;
			}
			
			document.getElementById("insert-button").value = "Update";
		}
		//document.getElementById("src").focus();
		window.parent.blur();
		//window.parent.document.getElementById( 'content_ifr' ).contentWindow.document.getElementById("src").focus();
		//alert( window.parent.document.getElementById( 'content_ifr' ).contentWindow.document.body.innerHTML );
		//document.getElementById("src").focus();
	}


function clickOK() {
			
	var shortcode = '';
	
	if(document.getElementById("src").value == '') {
		alert('Please enter the file name of your video file.');
		return false;
	}
	else
		shortcode = '[flowplayer src=\'' + document.getElementById("src").value + '\'';
		
	if( document.getElementById("width").value != '' && document.getElementById("width").value % 1 != 0 ) {
		alert('Please enter a valid width.');
		return false;
	}
	if( document.getElementById("width").value != '' )
		shortcode += ' width=' + document.getElementById("width").value;
		
	if( document.getElementById("height").value != '' && document.getElementById("height").value % 1 != 0 ) {
		alert('Please enter a valid height.');
		return false;
	}
	if( document.getElementById("height").value != '' )
		shortcode += ' height=' + document.getElementById("height").value;
	
  if( document.getElementById("autoplay").checked )
		shortcode += ' autoplay=true';
		
	if( document.getElementById("splash").value != '' )
		shortcode += ' splash=\'' + document.getElementById("splash").value + '\'';
	
	if( document.getElementById("popup").value != '' ) {
			var popup = document.getElementById("popup").value;
			popup = popup.replace(/&/g,'&amp;');
			popup = popup.replace(/'/g,'\\\'');
			popup = popup.replace(/"/g,'&quot;');
			popup = popup.replace(/</g,'&lt;');
			popup = popup.replace(/>/g,'&gt;');
			shortcode += ' popup=\'' + popup +'\'';
	}
	
	shortcode += ']';
	document.cookie = "selected_video='';expires=Thu, 01-Jan-1970 00:00:01 GMT;";
	document.cookie = "selected_image='';expires=Thu, 01-Jan-1970 00:00:01 GMT;";
	if( hTinyMCE == undefined || window.parent.tinyMCE.activeEditor.isHidden() ) {
		window.parent.send_to_editor( shortcode );
	}
	else {
		if( content_original.match( re ) )
			hTinyMCE.setContent( content_original.replace( re,shortcode ) );
		else
			hTinyMCE.setContent( content_original.replace( re2,shortcode ) );
	
		//return true;
		window.parent.tb_remove();
	}
}

</script>
