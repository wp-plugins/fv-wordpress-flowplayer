<?php
/**
 * Displays administrator backend.
 */
?>
<div class="wrap">
<table>
	<tr>
		<td style="width: 450px;">
			<form id="wpfp_options" method="post" action="">
			<div id="icon-options-general" class="icon32"></div>
			<h2>FV Wordpress Flowplayer</h2>
			<?php //echo flowplayer_check_errors($fp); ?>
			<h3>Default Flowplayer Options:</h3>
			<table>
				<tr>
					<td>AutoPlay: </td>
					<td>
					 	<select name="autoplay">
						<?php echo flowplayer_bool_select($fp->conf['autoplay']); ?>
					 	</select>
					 </td>
				</tr>
				<tr style="position: absolute; top: -9999em; left: -9999em;">
					<td>Commercial License Key: </td>
					<td>
						<input type="text" size="20" name="key" id="key" value="<?php echo trim($fp->conf['key']); ?>" />	
					</td>
				</tr>	
				<tr>
					<td>Auto Buffering:</td>
					<td><select name="autobuffer">

					<?php echo flowplayer_bool_select($fp->conf['autobuffer']); ?>

					</select></td>
				</tr>
				<tr>
					<td>Popup Box:</td>
					<td><select name="popupbox">

					<?php echo flowplayer_bool_select($fp->conf['popupbox']); ?>

					</select></td>
				</tr>
				<tr>
					<td>Enable Full-screen Mode:</td>
					<td><select name="allowfullscreen">
					<?php echo flowplayer_bool_select($fp->conf['allowfullscreen']); ?>

					</select></td>
				</tr>
				<tr>
					<td>Allow User Uploads: </td>
					<td>
					 	<select name="allowuploads">
						<?php echo flowplayer_bool_select($fp->conf['allowuploads']); ?>
					 	</select>
					 </td>
				</tr>
				<tr>
					<td>Enable Post Thumbnail: </td>
					<td>
					 	<select name="postthumbnail">
						<?php echo flowplayer_bool_select($fp->conf['postthumbnail']); ?>
					 	</select>
					 </td>
				</tr>
				<tr>
					<td>Convert old shortcodes with commas (<abbr title="Older versions of this plugin used commas to sepparate shortcode parameters. This option will make sure it works with current version. Turn this off if you have some problems with display or other plugins which use shortcodes.">?</abbr>): </td>
					<td>
					 	<select name="commas">
						<?php echo flowplayer_bool_select($fp->conf['commas']); ?>
					 	</select>
					 </td>
				</tr>

					<?php echo include dirname( __FILE__ ) . '/../view/colours.php'; ?>

				<tr>
					<td>
					</td>
					<td>
						<input type="submit" name="submit" class="button-primary" value="Apply Changes" style="margin-top: 2ex;"/>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="text-align: justify;">
					<h3>Description:</h3>
					<ul>
						<li>FV Wordpress Flowplayer is a completely non-commercial solution for embedding video on Wordpress websites.</li>
						<li>It contains opensource version of Flowplayer, with removed logo and copyright notice. </li>
						<li>Supported video formats are <strong>FLV</strong>, <strong>H.264</strong>, and <strong>MP4</strong>. Multiple videos can be displayed in one post or page.</li>
						<li>Default options for all the embedded videos can be set in the menu above.</li>
					</ul>
					<h3>Usage:</h3>
					<p>
					To embed video "example.flv", simply include the following code inside any post or page: 
					<code>[flowplayer src=example.flv]</code>
					</p>
					<p>
					<code>src</code> is the only compulsory parameter, specifying the video file. Its value can be either a full URL of the file, 
					or just a filename, if it is located in the /videos/ directory in the root of the web.
					</p>
					<p>When user uploads are allowed, uploading or selecting video from WP Media Library is available. To insert selected video, simply use the 'Insert into Post' button.</p>
					<h4>Optional parameters:</h4>
					<ul style="text-align: left;">
						<li><code>width</code> and <code>height</code> specify the dimensions of played video in pixels. If they are not set, the default size is 320x240.<br />
						<i>Example</i>:<br /><code>[flowplayer src='example.flv' width=640 height=480]</code></li>
						<li><code>splash</code> parameter can be used to display a custom splash image before the video is started. Just like in case of <code>src</code> 
						parameter, its value can be either complete URL, or filename of an image located in /videos/ folder.<br />
						<i>Example</i>:<br /><code>[flowplayer src='example.flv' splash=image.jpg]</code></li>
						<li><code>autoplay</code> parameter specify wheter the video should start to play automaticaly after the page is loaded. This parameter overrides the default autoplay setting above. Its value can be either true or false.<br />
						<i>Example</i>:<br /><code>[flowplayer src='example.flv' autoplay=true]</code></li>
						<li><code>popup</code> parameter can be used to display any HTML code after the video finishes (ideal for advertisment or links to similar videos). 
						Content you want to display must be between simgle quotes (<code>''</code>).<br />
						<i>Example</i>:<br /><code>[flowplayer src='example.flv' popup='&lt;p&gt;some HTML content&lt;/p&gt;']</code></li>
						<li><code>controlbar</code> parameter can be used to show or hide the control bar. Value <code>show</code> will keep the controlbar visible for the whole duration of the video, and value <code>hide</code> will completely hide the control bar. If this parameter is not set, the default autohide is applied.<br />
						<i>Example</i>:<br /><code>[flowplayer src='example.flv' controlbar='show']</code></li>
						<li><code>redirect</code> parameter can be used to redirect to another page (in a new tab) after the video stops playing.<br />
						<i>Example</i>:<br /><code>[flowplayer src='example.flv' redirect='http://www.site.com']</code></li>
					</ul>
					</td>
					<td></td>
				</tr>
			</table>
			</form>
		</td>
		<td style="padding: 3em; vertical-align: top;">
			<a id="player" class="flowplayer_div" style="display:block;width:400px;height:300px;"></a>
		</td>
	</tr>
</table>

<script defer="defer" language="Javascript" type="text/javascript">

		//load player
		$f("player", "<?php echo PLAYER; ?>", {
				<?php echo (isset($fp->conf['key'])&&strlen($fp->conf['key'])>0?'key:\''.trim($fp->conf['key']).'\',':''); ?>
				plugins: {
				    <?php echo (((empty($fp->conf['showcontrols']))||($fp->conf['showcontrols']=='true'))? 
                  'controls: { buttonOverColor: \''.trim($fp->conf['buttonOverColor']).'\', sliderColor: \''. trim($fp->conf['sliderColor']).'\', bufferColor: \''. trim($fp->conf['bufferColor']).'\', sliderGradient: \'none\', progressGradient: \'medium\', durationColor: \''. trim($fp->conf['durationColor']).'\', progressColor: \''. trim($fp->conf['progressColor']).'\', backgroundColor: \''. trim($fp->conf['backgroundColor']).'\', timeColor: \''. trim($fp->conf['timeColor']).'\', buttonColor: \''. trim($fp->conf['buttonColor']).'\', backgroundGradient: \'none\', bufferGradient: \'none\', opacity:0.9, fullscreen: '.trim($fp->conf['allowfullscreen']).',autoHide: \'always\',hideDelay: 500} ':'controls:null'); ?> 
				},
				clip: {
					url:'<?php echo RELATIVE_PATH; ?>/flowplayer/example.flv',
					autoPlay: '<?php if (isset($fp->conf["autoplay"])) { echo trim($fp->conf["autoplay"]); } else { echo(false); } ?>',
	       	   autoBuffering: '<?php if (isset($fp->conf["autobuffer"])) { echo trim($fp->conf["autobuffer"]); } else { echo "false"; } ?>'
				},
	

            <?php 	
            if($fp->conf['logoenable'] == 'true'){
            	echo 'logo: {url: \'http://'.$fp->conf['logo'].'\', fullscreenOnly: '.trim($fp->conf['fullscreenonly']).', displayTime: 0, linkUrl: \'http://'.$fp->conf['logolink'].'\'},';
            }
            ?>

				canvas: {
					backgroundColor:'<?php echo trim($fp->conf["canvas"]); ?>'
				},
				onLoad: function() {
					$(":input[name=tgt]").removeAttr("disabled");		
				},
				onUnload: function() {
					$(":input[name=tgt]").attr("disabled", true);		
				}
			});

</script>

</div>

<?php 
	if(isset($_POST['submit'])) {
		/**
		 *  Write the configuration into file, if the form was submitted.
		 */
		$fp->_set_conf();
		/**
		 *  Refresh the page.
		 */
		?>
		<script type="text/JavaScript">
		<!--
			window.location = window.location;
		//   -->
		</script>
		<?php
	}
?>



