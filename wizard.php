<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript">
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
</head>
<body>
<div>


<table cellSpacing="2" cellPadding="2" align="left" border="0" width="100%">
	<tr>
		<td width="160">Filename <small>(in /videos/)</small>:</td><td><input id="src" name="src" style="width: 99%" /></td>
	</tr>
	<tr>
		<td>Width <small>(px; optional)</small>:</td><td><input id="width" name="width" style="width: 99%" /></td>
	</tr>
	<tr>
		<td>Height <small>(px; optional)</small>:</td><td><input id="height" name="height" style="width: 99%" /></td>
	</tr>
	<tr>
		<td>Splash Image:</td><td><input id="splash" name="splash" style="width: 99%" /></td>
	</tr>
	<tr>
		<td valign="top">HTML Popup:</td><td><textarea style="width: 100%; height: 5eM;" id="popup" name="popup"></textarea></td>
	</tr>
	<tr>
		<td colspan=2"><p><input type="button" value="Insert" name="insert" id="insert-button" class="button-primary" onclick="clickOK();" /></p></td>
	</tr>
</table>

</div>
</body>
<script language="javascript">
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
	
</script>

</html>
