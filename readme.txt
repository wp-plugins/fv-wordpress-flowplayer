=== FV Wordpress Flowplayer ===
Contributors: FolioVision
Tags: video, flash, flowplayer
Requires at least: 2.0
Tested up to: 3.0
Stable tag: 1.0.2

Embed videos (FLV, H.264, and MP4) into posts or pages. Uses modified version of flowplayer (with removed FP logo and copyright notice).

== Description ==

FV Wordpress Flowplayer plugin is a free, easy-to-use, and complete solution for embedding FLV or MP4 videos into your posts or pages.

* Plugin is completely non-commercial. It contains modified opensource version of Flowplayer 3.1.3, with removed FP logo and copyright notice.
* Supported video formats are FLV, H.264, and MP4. Multiple videos can be displayed in one post or page.
* Default options for all the embedded videos can be set in comprehensive administration menu.
* It is loosely based on Wordpress Flowplayer plugin. However, there are several improvements:

	1. Doesn't use jQuery, so there will be no future conflicts with other plugins.
	2. Usage is simpler and forgiving, making the plugin easier to use.
	3. It will never display any annoying flowplayer logos or copyrights over your videos.
	4. Allows user to display clickable splash screen at the beginning of video (which not only looks good, but improves the performance significantly).
	5. Allows user to display popup box after the video ends, with any HTML content (clickable links, images, styling, etc.)
	6. Allows to upload videos and images through WP Media Library

== Installation ==

There aren't any special requirements for FV Wordpress Flowplayer to work, and you don't need to install any additional plugins.

   1. Download and unpack zip archive containing the plugin.
   2. Upload the fv-wordpress-flowplayer directory into wp-content/plugins/ directory of your wordpress installation.
   3. Make sure, that configuration file wpfp.conf is writable (666 permissions).
   4. Go into Wordpress plugins setup in Wordpress administration interface and activate FV Wordpress Flowplayer plugin.
   5. Optionally, if you want to embed videos denoted just by their filename, you can create the /videos/ directory located directly in the root of your domain and place your videos there. Otherwise, you would have to type in a complete URL of video files.

   
== Frequently Asked Questions ==

= I get an error message like this when activating the plugin: Parse error: parse error, unexpected T_STRING, expecting T_OLD_FUNCTION or T_FUNCTION or T_VAR or '}' in /wp-content/plugins/fv-wordpress-flowplayer/models/flowplayer.php on line 4 =

You need to use at least PHP 5, your site is probably still running on old PHP 5. 

= I installed the plugin, inserted the video, but it's not working, only a gray box appears. =

FV Flowplayer calls some javascript from the footer. That means your footer.php file must contain the <?php wp_footer(); ?> Wordpress hook. Almost all themes do this out of the box, but if you've customised your theme there's a chance that you might have deleted this call.

= I installed the plugin, inserted the video, but it's not working, the play button does not work.  =

Please make sure, that configuration file wpfp.conf is writable (666 permissions).

= You player works just fine, but there are some weird display issues. =

Please check if these issues also appear when using the default Wordpress template. There seems to be some sort of conflict between the Flowplayer CSS and your theme CSS.

= How to make this plugin WPMU compatible? =

Just copy the plugin into wp-content/plugins and then activate it on each blog where you want to use it.

= Is there a way to force pre-buffering to load a chunk of the video before the splash screen appears? =

This option is not available. With autobuffer, it means every visitor on every visit to your page will be downloading the video. This means that you use a lot more bandwidth than on demand. I know that I actually watch the video on only about 1/3 of the pages with video that I visit. That saves you money (no bandwidth overages) and means that people who do want to watch the video and other visitors to your site get faster performance.
If you want to autobuffer, you can turn that on in the options (we turn it off by default and recommend that it stays off).

= My videos are hosted with Amazon S3 service. How can I fill the details into shortcode? =

Currently there is no support for Amazon S3 service, this feature might be added in the future. 

= The spinning circle is off centre when the video is loading. =

This happens when you set width and height of the video other than are native dimensions. We recommend to use native dimensions of the video when placing on a webpage. 



== Screenshots ==

1. Post containing modified flowplayer playing a video.
2. Adding three players with different arguments into a post.
3. Add new video dialog window in editing mode.
4. Configuration menu for administrators.

== Changelog ==

= 1.0.2 =
* redirect feature added (Thanks for donation from Klaus Eickelpasch)
* more bug fix for wp shortcodes api to be compatible with commas in shortcodes
* fixed the absolute paths

= 1.0.1 =
* bug fix for wp shortcodes api to be compatible with commas in shortcodes

= 1.0 =
* autoplay option for single videos
* show/hide control bar
* show/hide fullscreen option
* connected with wp media library, video and image upload is supported now (Thanks for donation from Kermit Woodhall)

= 0.9.18 =
* added button & dialog window for easy video adding and editing

= 0.9.16 =
* minor bug fixes

= 0.9.15 =
* support for widget use and template use

= 0.9.14 =
* Added a possibility to forbid the popup boxes.
* Some output validation.
* Minor visual improvements.

= 0.9.13 =
* Added "Replay" and "Share" buttons to the popup box after video finishes.
* Some performance tweaks concerning popup box.

= 0.9.12 =
* First stable version ready to be published.
* Removed farbtastic colour picker using jQuery from settings menu. Substituted by jscolor.

== Configuration ==

Once the plugin is uploaded and activated, there will be a submenu of settings menu called FV Wordpress Flowplayer. In that submenu, you can modify following settings:

* AutoPlay - decides whether the video starts playing automatically, when the page/post is displayed.
* AutoBuffering - decides whether te video starts buffering automatically, when the page/post is displayed. If AutoPlay is set to true, you can ignore this setting.
* Popup Box - decides whether a popup box with "replay" and "share" buttons will be displayed when video ends.
* Colors of all the parts of flowplayer instances on page/post (controlbar, canvas, sliders, buttons, mouseover buttons, time and total time, progress and buffer sliders).

On the right side of this screen, you can see the current visual configuration of flowplayer. If you click Apply Changes button, this player's looks refreshes.

