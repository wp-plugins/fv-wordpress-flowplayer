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

global $fv_wp_flowplayer_ver;

if( is_admin() ) : ?>
<script type="text/javascript" src="<?php echo FV_FP_RELATIVE_PATH ?>/flowplayer/fv-flowplayer.min.js?ver=<?php echo $fv_wp_flowplayer_ver; ?>"></script>
<?php endif; ?>

<link rel="stylesheet" href="<?php echo FV_FP_RELATIVE_PATH; ?>/css/flowplayer.css?ver=<?php echo $fv_wp_flowplayer_ver; ?>" type="text/css" media="screen" />

<?php if( current_user_can('manage_options') ) : ?>
	<link rel="stylesheet" href="<?php echo FV_FP_RELATIVE_PATH; ?>/css/admin.css?ver=<?php echo $fv_wp_flowplayer_ver; ?>" type="text/css" media="screen" />
	<style type="text/css">
	.fv-wp-flowplayer-notice-small { color: <?php echo trim($this->conf['timeColor']); ?> !important; }
	</style>
<?php endif; ?>

<?php if ( isset($this->conf['key']) && $this->conf['key'] != 'false' && strlen($this->conf['key']) > 0 && isset($this->conf['logo']) && $this->conf['logo'] != 'false' && strlen($this->conf['logo']) > 0 ) : ?>
		<style type="text/css">
			.flowplayer .fp-logo { display: block; opacity: 1; }    
		</style>                                              
<?php endif; ?>

<style type="text/css">
	<?php if( isset($this->conf['hasBorder']) && $this->conf['hasBorder'] == "true" ) : ?>
		.flowplayer { border: 1px solid <?php echo trim($this->conf['borderColor']); ?> !important; }
	<?php endif; ?>

	.flowplayer, flowplayer * { margin: 0 auto 28px auto; display: block; }
	.flowplayer .fp-controls { background-color: <?php echo trim($this->conf['backgroundColor']); ?> !important; }
	.flowplayer { background-color: <?php echo trim($this->conf['canvas']); ?> !important; }
	.flowplayer .fp-duration { color: <?php echo trim($this->conf['durationColor']); ?> !important; }
	.flowplayer .fp-elapsed { color: <?php echo trim($this->conf['timeColor']); ?> !important; }
	.flowplayer .fp-volumelevel { background-color: <?php echo trim($this->conf['progressColor']); ?> !important; }  
	.flowplayer .fp-volumeslider { background-color: <?php echo trim($this->conf['bufferColor']); ?> !important; }
	.flowplayer .fp-timeline { background-color: <?php echo trim($this->conf['timelineColor']); ?> !important; }
	.flowplayer .fp-progress { background-color: <?php echo trim($this->conf['progressColor']); ?> !important; }
	.flowplayer .fp-buffer { background-color: <?php echo trim($this->conf['bufferColor']); ?> !important; }
	#content .flowplayer, .flowplayer { font-family: <?php echo trim($this->conf['font-face']); ?>; }
	#content .flowplayer .fp-embed-code textarea, .flowplayer .fp-embed-code textarea { line-height: 1.4; white-space: pre-wrap; color: <?php echo trim($this->conf['durationColor']); ?> !important; height: 160px; font-size: 10px; }
	
	.fvplayer .mejs-container .mejs-controls { background: <?php echo trim($this->conf['backgroundColor']); ?>!important; } 
	.fvplayer .mejs-controls .mejs-time-rail .mejs-time-current { background: <?php echo trim($this->conf['progressColor']); ?>!important; } 
	.fvplayer .mejs-controls .mejs-time-rail .mejs-time-loaded { background: <?php echo trim($this->conf['bufferColor']); ?>!important; } 
	.fvplayer .mejs-horizontal-volume-current { background: <?php echo trim($this->conf['progressColor']); ?>!important; } 
	.fvplayer .me-cannotplay span { padding: 5px; }
	#content .fvplayer .mejs-container .mejs-controls div { font-family: <?php echo trim($this->conf['font-face']); ?>; }

	.wpfp_custom_background { display: none; }	
	.wpfp_custom_popup { display: none; position: absolute; top: 10%; z-index: 2; text-align: center; width: 100%; color: #fff; }
	.is-finished .wpfp_custom_popup, .is-finished .wpfp_custom_background { display: block; }	
	.wpfp_custom_popup_content {  background: <?php echo trim($this->conf['backgroundColor']) ?>; padding: 1% 5%; width: 65%; margin: 0 auto; }

	<?php echo trim($this->conf['ad_css']); ?>
	.wpfp_custom_ad { color: <?php echo trim($this->conf['adTextColor']); ?>; }
	.wpfp_custom_ad a { color: <?php echo trim($this->conf['adLinksColor']); ?> }
</style>
