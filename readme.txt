=== FV WordPress Flowplayer ===
Contributors: FolioVision
Donate link: http://foliovision.com/donate/
Tags: video player, flowplayer, jwplayer, mobile video, html5 video, Vimeo, html5 player, youtube player, youtube playlist, video playlist, spider player, RTMP, Cloudfront, HLS
Requires at least: 3.5
Tested up to: 4.3
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WordPress's most reliable, easy to use and feature-rich video player. Supports responsive design, HTML5, playlists, ads, stats, Vimeo and YouTube.

== Description ==

Custom HTML 5 video on your own site with Flash fallback for legacy browsers is here.

FV WordPress Flowplayer 6 WordPress plugin is a free, easy-to-use, and complete solution for embedding FLV or MP4 videos into your posts or pages. With MP4 videos, FV WordPress Flowplayer offers 98% coverage even on mobile devices.

* **NEW** easy AB looped playback for your visitors (great for teaching sites)
* **NEW** improved and more powerful playlists (more playlist features coming soon).
* Automated checking of video mime type for logged in admins on MP4 videos
* FV Flowplayer 5 is a completely responsive WordPress video player.
* Custom start and end screens are built right in. You can use your own custom design before and after the video.
* Enjoy unlimited instances in a single page.
* No expensive plugins: unlike other players who nickel and dime you for every feature, with FV Flowplayer all advanced features are available in the standard license (Google Analytics, Cuepoints, Native fullscreen, Keyboard shortcuts, Subtitles, Slow motion, Random seeking, Retina ready)
* Single site pro license available (jwPlayer requires five pack for full features)
* Ultra-efficient player: just 62kB of JavaScript and 8kB of Flash code. You can extend Flowplayer using just HTML and CSS, leaving the JavaScript heavy lifting up to us.
* 98% Browser coverage. Built-in Flash fallback will get the job done on older browsers.
* Full support for Amazon S3, Cloudfront and other CDN's.
* Totally Brandable. Stop selling YouTube and start selling yourself. Even design your own player.

To remove our branding and add your own branding and get access to additional pro support, [you can buy your own license here](://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/buy).

Back to school special 25% off pro licenses until end of September.

**Additional Technical information**

* Core video engine: open source Flowplayer 6. 
* Supported video formats are FLV, H.264, and MP4 ([read about HTML5 video formats](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/encoding)). Multiple videos can be displayed in one post or page.
* Default options for all the embedded videos can be set in comprehensive administration menu.
* In comparison with WordPress Flowplayer plugin, there are several improvements:

	1. Allows user to display clickable splash screen at the beginning of video (which not only looks good, but improves the performance significantly).
	2. Allows user to display popup box after the video ends, with any HTML content (clickable links, images, styling, etc.)
	3. Does not use configuration file, but WordPress Options
	4. Does not drive you to use an in-house proprietary CDN but supports all CDN.
	5. Includes advanced built-in social sharing.
	6. Inexpensive [pro support](https://foliovision.com/pro-support) available.
	7. Includes an advanced built-in video encoding and theme checker to make sure your videos are encoded properly and your site is set up for video playback.

**Additional Documentation at Foliovision.com**

[Support](http://foliovision.com/support/fv-wordpress-flowplayer/) |
[Change Log](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/changelog) |
[Installation](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/installation)|
[User Guide](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/user-guide) | 
[Detailed FAQ](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/faq)


== Installation ==

There aren't any special requirements for FV WordPress Flowplayer to work, and you don't need to install any additional plugins.

   1. Download and unpack zip archive containing the plugin.
   2. Upload the fv-wordpress-flowplayer directory into wp-content/plugins/ directory of your wordpress installation.
   3. Go into WordPress plugins setup in WordPress administration interface and activate FV WordPress Flowplayer plugin.
   4. If you want to embed videos denoted just by their filename, you can create the /videos/ directory located directly in the root of your domain and place your videos there(you use complete URL of video files).
   5. Go to plugin Settings screen and click both "Check template" and "Check videos" buttons to check your template and videos mime type.
   
Visit [our site](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/installation) for a fully featured guide with **screenshots** and more!

   
== Frequently Asked Questions ==

= My video doesn't play in some browsers =

This should be related to your video format or mime type issues.

Each browser supports different video format, MP4 is the recommended format. In general, it's recommended to use constant frame rate. Detailed instructions about [video encoding for HTML 5](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/encoding).

HTML5 is pickier about what video it can play than Flash.

Please note that MP4 is just a container, it might contain various streams for audio and video. You should check what audio and video stream are you using. Read next question to find out how.

= Player buttons are gone - there are only square symbols =

1) This can happen if your site is at www.domain.com, but the CSS is loaded from your CDN at cdn.domain.com. Based on CSS3 and HTML5 specs not all the resources can be shared between domains.

So you need to set the following on your CDN for web fonts (woff, eot, ttf, svg):

Access-Control-Allow-Origin: *

Or you can allow your domain only (but in that case it might be good to also allow it with https):

Access-Control-Allow-Origin: http://www.domain.com

Or you can exclude wp-content/plugins/fv-wordpress-flowplayer/css/flowplayer.css from CDN.

2) Second cause might be that your webfonts are served with bad mimetype

`AddType application/x-font-woff woff
AddType application/x-font-ttf ttf
AddType application/vnd.ms-fontobject eot
AddType image/svg+xml svg`

= I want to align my player (left/right/middle) =

By default the player is positioned in the middle. To change alignment of the player to either left or right:
Go to FV WordPress Flowplayer settings > scroll down to post interface options > tick "Align". Now you can insert your video. In the interface you can now choose you alignment from the drop down menu: default (middle), left, or right.
You can check [demo in here](https://foliovision.com/player/demos/align-settings).

= How to check my video properties using the built-in checker and how to report video not playing =

* Login to your site as administrator (please use the browser in which the video is not playing for you)
* Double check Settings -> FV WordPress Flowplayer -> Sitewide Flowplayer Defaults -> "Disable admin video checker" is not checked
* Come to any post which was video
* A message in top left corner of the video should appear saying: "Checking the video file...". The check takes usually 1-2 seconds.
* Once it's finished, it changes color based on what problem is detected and you can click it to get video details.
* The dialog also includes our tips on how to resolve the issues found. There is also a button labeled "Send to Foliovision" which sends your video with details straight to our private support tickets.

Note: The checker doesn't work for localhost files, as our service is not able to access them.

= My video doesn't play in Internet Explorer 9 and 10 =

Most of the issues is caused by bad mime type on the server which serves your video files. Our plugin contains an automated checked for this - just click the "Check Videos" button on the plugin Settings screen.

Here's how to fix the mime type:

**If your videos are hosted on a standard server:**

You need to put the following into your .htaccess:

`AddType video/mp4             .mp4
AddType video/webm            .webm
AddType video/ogg             .ogv
AddType application/x-mpegurl .m3u8
AddType video/x-m4v           .m4v
AddType video/mp2t            .ts`

If you use Microsoft IIS, add following into web.config (one should be in your root website folder) into configuration/system.webServer/staticContent section:

`<remove fileExtension=".mp4" />  
<mimeMap fileExtension=".mp4" mimeType="video/mp4" />
<remove fileExtension=".webm" />  
<mimeMap fileExtension=".webm" mimeType="video/webm" />
<remove fileExtension=".ogg" />  
<mimeMap fileExtension=".ogg" mimeType="video/ogg" />
<remove fileExtension=".m4v" />  
<mimeMap fileExtension=".m4v" mimeType="video/x-m4v" />
<remove fileExtension=".ts" />  
<mimeMap fileExtension=".ts" mimeType="video/mp2t" />`

This can be also done in the Apache configuration. If you are on Microsoft IIS, you need to use the IIS manager. 

**If you host videos on Amazon AWS:**

They might be served with bad mime type too - "application/octet-stream". This largely depends on the tool which you use to upload your videos. Using your Amazon AWS Management Console, you can go though your videos and find file content type under the "Metadata" tab in an object's "Properties" pane and fix it to "video/mp4" (without the quotes, of course different video formats need different mime type, this one is for MP4). There are also tools for this, like S3 Browser Freeware, good place for start is here: https://forums.aws.amazon.com/thread.jspa?messageID=224446

Good example can be seen in our support forum: http://foliovision.com/support/fv-wordpress-flowplayer/how-to/how-to-set-correct-mime-type-on-videos-hosted-by-amazon

Also for Internet Explorer, it's not recommended to use MPEG-4 Visual or MPEG-4 Part 2 video stream codecs.

= How do I fix the bad metadata (moov) position? =

This means that the video information (such as what codecs are used) is not stored at the beginning of the file. In our experience, video with bad meta data position might be slow to load in Flash engine (check some browser which doesn't play MP4 format in Flash - like Opera) and Firefox. Although Safary and iOS (iPAd, iPhone) may play it just fine. 

In general we recommend you to re-encode your video as [per our instructions](https://foliovision.com/player/encoding#encoding-samples), but here are some quick tools:

If you are using Mac, try Lillipot (just remember to rename the file back to .mp4 extension): http://www.qtbridge.com/lillipot/lillipot.html

If you have Quick Time Pro, just open the video and in the Movie Properties -> Video Track -> Other Settings turn on the "Cache (hint)" - [screenshot](http://drop.foliovision.com/webwork/it/quick-time-pro-cache-hint.png).

If you are using Windows, try MP4 FastStart: http://www.datagoround.com/lab/

There are also server-side tools for fixing of this written in Python and there one for PHP, but it fails on videos bigger than the PHP memory limit.

= I'm getting error about 'HTTP range requests' =

Please check with your technical support if your web server supports HTTP range requests. Most of the modern web servers support this feature (Apache, Nginx, Lighttpd, Litespeed...). It's important for fast seeking in HTML5 video playback.

Other possible cause is that you are using some membership plugin to protect downloading of your videos (Premise and others). While this might seem like a good solution, we don't recommend it as it increases the load of your server and it won't allow seeking in the videos. You can use <a href="http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/secure-amazon-s3-guide">Amazon S3 with privacy settings</a>, just hit the link to read our illustrated guide.

= Are there any known compatibility issues? =

We heard about problems when using some fancy pro templates like OptimizePress (read below for fixing instructions) or Gantry framework. These templates often break the WordPress conventions (probably as they often try to add too many non-template functions, like video support built-in into the template). We can debug the issues for you, just head over to our website and order the pro support.

Full list of conflicting plugins is available here: https://foliovision.com/player/compatibility

= I'm using OptimizePress version 1 template. =

First click the "Check template" button on the pluging settings screen. It will likely report an issue like:

`It appears there are multiple Flowplayer scripts on your site, your videos might not be playing, please check. There might be some other plugin adding the script.
Flowplayer script http://site.com/wp-content/themes/OptimizePress/js/flowplayer-3.2.4.min.js is old version and won't play. You need to get rid of this script.`

The problem with this template is that it includes that old Flowplayer library without using the proper WordPress function to add a new script (wp_enqueue_script). You need to go through the template and make sure the script is not loading. Typically it will be in any of the header.php files - including header-myheader.php, header-singleheader.php or similar files.

There is also a workaround - on each page what is using one of the OptimizePress custom templates, check Launch Page & Sales Letter Options --> Video Options --> "Activate Video" and enter "&lt;!-- FV Flowplayer --&gt;" into Launch Page & Sales Letter Options --> Video Options --> "External Player Code" field. That way the template thinks the video is external and will not try to put in the Flowplayer library and the video will play.

= I'm using OptimizePress version 2 template. =

FV Flowplayer will handle all the videos inserted by the Live Edit. 

= Does this plugin support Shoutcast? =

Unfortunatelly HTML5 does not support live broadcasting. Please read about it here under "Flash. The good parts": http://flowplayer.org/docs/#flash

= I get an error message like this when activating the plugin: Parse error: parse error, unexpected T_STRING, expecting T_OLD_FUNCTION or T_FUNCTION or T_VAR or '}' in /wp-content/plugins/fv-wordpress-flowplayer/models/flowplayer.php on line 4 =

You need to use at least PHP 5, your site is probably still running on old PHP 4. 

= I get "Can't create temporary file for video analysis" in admin video checker =

This temporary file is required as our plugin contains a video checker for admin users - it checks the video format and other information and warns you about potential issues why your video might not play for everybody.

The error message means the WordPress media uploads directory (by default wp-content/uploads) is not writable by PHP. We use this standard WordPress path as it should work for nearly all the websites. Most of people use the standard WordPress Media Library, so this should really work.

You can try to set the permissions of that folder to allow writing for everybody and see if that helps. If you are not sure, ask your web host support about what PHP permission model you use.

= I installed the plugin, inserted the video, but it's not working - there is no control bar or only a gray box appears. =

Go to plugin Settings screen and hit "Check template" button. It will check if both jQuery library and Flowplayer JavaScript is loading properly.

Also, check "I'm using OptimizePress template" question above.

= You player works just fine, but there are some weird display issues. =

Please check if these issues also appear when using the default WordPress template. There seems to be some sort of conflict between the Flowplayer CSS and your theme CSS.

= Fullscreen is not working properly for me =

Are you using some old lightbox plugin like http://www.4mj.it/slimbox-wordpress-plugin/ ? Or are you putting the video into Iframe? Also, the video should not be placed in an HTML element with lowered z-index.

= How to make this plugin WPMU compatible? =

Just copy the plugin into wp-content/plugins and then activate it on each blog where you want to use it.

= Is there a way to force pre-buffering to load a chunk of the video before the splash screen appears? =

This option is not available. With autobuffer, it means every visitor on every visit to your page will be downloading the video. This means that you use a lot more bandwidth than on demand. I know that I actually watch the video on only about 1/3 of the pages with video that I visit. That saves you money (no bandwidth overages) and means that people who do want to watch the video and other visitors to your site get faster performance.
If you want to autobuffer, you can turn that on in the options (we turn it off by default and recommend that it stays off).

= My videos are hosted with Amazon S3 service. How can I fill the details into shortcode? =

Just enter the URL of your video hosted on Amazon S3 as the video source.

= I would like to localize the play again button. =

Currently there is no support for other languages.

= Where can I change the default directory for videos? =

You can change this manually in the the models/flowplayer.php in the flowplayer_head function. It you use videos in widgets you might need to edit the function flowplayer_content in controller/frontend.php as well. Please be carefull when editing source codes.

= How do I insert flowplayer object outside the post, for example to a sidebar? =

You need to use following code to include the shortcode into a sidebar:

echo apply_filters('the_content', '[flowplayer src=yourvideo.mp4 width=240 height=320]');

Fill the Flowplayer shortcode part according to your needs. The apply filter needs to be called because the flowplayer shortcodes are not parsen outside posts automatically. Also, please do not forget to add the echo at the beginning.

= How can I style the popup or ad? =

Check out .wpfp_custom_popup and .wpfp_custom_ad in /fv-wordpress-flowplayer/css/flowplayer.css. You might want to move your changes to your template CSS - make sure you use ID of container element, so your declarations will work even when the flowplayer.css is loaded later in the head section of your webpage.

= Is there a way to remove the share (embed) button? =

Yes, there's a global option in settings to disable sharing/embed. We plan to add an individual flag on a per video basis to allow sharing when sharing is turned off globally and vice versa.

= My videos are taking long time to load. =

1. Check your hosting for download speed.
2. Try to use different settings when encoding the videos, try to turn on the cache when encoding with [Quick Time](http://drop.foliovision.com/webwork/it/quick-time-pro-cache-hint.png)

= How can I change the play icon? =

You need to copy the CSS from the Flowplayer CSS (default theme) and put it into your theme CSS. Also add some element ID in front of it to make sure it overrides the default Flowplayer CSS:

`#content .is-paused.flowplayer .fp-ui{background:url({PATH TO YOUR IMAGE}.png) center no-repeat;background-size:12%;}
#content .is-rtl.is-splash.flowplayer .fp-ui, #content .is-rtl.is-paused.flowplayer .fp-ui{background:url({PATH TO YOUR IMAGE-rtl}.png) center no-repeat;background-size:12%}
@media (-webkit-min-device-pixel-ratio: 2){
  #content .is-splash.flowplayer .fp-ui, #content .is-paused.flowplayer .fp-ui{background:url({PATH TO YOUR IMAGE@2x}.png) center no-repeat;background-size:12%}
  #content .is-rtl.is-splash.flowplayer .fp-ui, #content .is-rtl.is-paused.flowplayer .fp-ui{background:url({PATH TO YOUR IMAGE-rtl@2x}.png)}
}`

The image needs to be 100x106px normal version nad 200x212px hi res version. You only have to include the RTL version if your site runs in such language.

= How can I change position of my custom logo? =

Check out Settings -> FV WordPress Flowplayer -> Sitewide Flowplayer Defaults -> Logo.

= Volume control in player looks weird =

Make sure you are not using obsolete tags like &lt;center&gt; to wrap the video. Such tag is not supported in HTML5, you have to use CSS to center elements.

= How do I get rid of the 'Hit ? for help' tooltip on the player box? =

You can put this into your template's functions.php file, if you know a bit of PHP. It will disable the tooltip.

`add_filter( 'fv_flowplayer_attributes', 'tweak_fv_flowplayer_attributes', 10, 2 );
function tweak_fv_flowplayer_attributes( $attrs ) {
	$attrs['data-tooltip'] = 'false';
	return $attrs;
}`

= How can I customized the player control bar? I want to add a play/pause button. =

Just put this code into the template's functions.php file. If you know a bit of PHP, it should not be a problem for you:

`add_filter( 'fv_flowplayer_attributes', 'tweak_controlbar_fv_flowplayer_attributes', 10, 2 );
function tweak_controlbar_fv_flowplayer_attributes( $attrs ) {
	$attrs['class'] .= ' play-button';
	return $attrs;
}`

It simply adds a class "play-button" to the player DIV element and then it knows to use the play button. The other options are:

`no-mute
no-time
no-volume`

= What if the FV Flowplayer 5 doesn't work for me? =

No worries.

1. You can always downgrade to version the Flash version ([here's how](http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/downgrading)). You do lose a lot of mobile and iOS capability but you didn't have it in the first place.
1. Contact us via [support](http://foliovision.com/support). We are actively investigating and fixing people's sites now during the initial release period. We will help you to get FV Flowplayer 5 working in your environment.

FV Flowplayer 5 Pro comes with a money back guarantee so you can even try the commercial no-branding version risk free. Or make it work first with the free versions.

Thank you for being part of the HMTL 5 mobile video revolution!

=======

== Screenshots ==

1. Post containing modified flowplayer playing a video.
2. Adding three players with different arguments into a post.
3. Add new video dialog window in editing mode.
4. Configuration menu for administrators.
5. Video checker. This shows up for admins only. Click on Admin: Video Ok or Admin: Video Issues in top left corner of the video when you are logged in as admin to get it.

== Changelog ==

= 6.0.3.8 - 2015/10/15 =

* Fix - Using safer names for CSS images

= 6.0.3.7 - 2015/10/08 =

* Fix - Playlist tabs - fix for Divi (Elegant Themes) triggering scroll action on tab click
* Fix - Playlist tabs - fix for pausing the playing video on tab switch event
* Fix - RTMP playback for streams without extension prefix (where rtmp_path="live" instead of rtmp_path="mp4:live")

= 6.0.3.6 - 2015/09/10 =

* Feature - playlist style "Tabs" added with per player setting in shortcode editor
* Feature - per player speed buttons setting for shortcode editor

= 6.0.3.5 - 2015/09/08 =

* Making the license field more prominent
* Bugfix - FV Flowplayer 5 -> 6 update process

= 6.0.3.4 - 2015/08/28 =

* Security fixes - CSFR protection for settings page

= 6.0.3.3 - 2015/08/20 =

* Bugfix - bad logo link for licensed users revised

= 6.0.3.2 - 2015/08/18 =

* Bugfix - bad logo link for licensed users
* Bugfix - video checker fix

= 6.0.3.1 - 2015/08/11 =

* Bugfix - CSS rewriting fix
* Bugfix - updated SWF files

= 6.0.3 - 2015/08/11 =

* Core - upgrade to Flowplayer 6.0.3

= 6.0.2.2 - 2015/07/30 =

* Bugfix - PHP missing includes

= 6.0.2.1 - 2015/07/15 =

* Bugfix - fix for CSS font paths

= 6.0.2 - 2015/07/09 =

* Upgrade to Flowplayer 6 core! HLS Flash playback, skin improvements, hover tooltip for seeking and a lot more.

= 2.4.2 - 2015/07/22 =

* Flowplayer 6 - last preparations for the upgrade

= 2.4.1 - 2015/07/20 =

* CSS - making sure the CSS writeout uses protocol independent links

= 2.4 - 2015/07/15 =

* Compatibily - CSS styles are now loaded using WP API wp_enqueue_scripts()

= 2.3.17 - 2015/07/07 =

* Core - putting in warning for Flowplayer 6 upgrade

= 2.3.16 - 2015/05/28 =

* Feature - MPEG DASH experimental support
* Feature - support for translations (covers front-end error messages and shortcode editor)
* Bugfix - Amazon S3 signed URLs - AWS signature version 4 fixes
* Bugfix - playlist loading improvements
* Bugfix - styling fixes (for FV Player Pro)

= 2.3.15 - 2015/04/24 =

* Bugfix - Fix for fancy quotes in shortcode attributes.
* Bugfix - Internet Explorer on Windows Phone 8.1 pretend to be Android and iPhone - breaking the playback. Fixed.
* Bugfix - RTMP extension parsing fix for RTMP path like mp4:file.mp4

= 2.3.14 - 2015/04/20 =

* Feature - speed control buttons - check Settings -> FV WordPress Flowplayer -> Player Skin - Speed Buttons
* Feature - support for [video] shortcode - check Settings -> FV WordPress Flowplayer -> Integrations -> Handle WordPress [video] shortcodes. This will be the new default in a couple of versions.
* Bugfix - fix for disappearing share bar (caused by new Google Analytics tracking in last version)

= 2.3.13 - 2015/04/17 =

* Feature - Google Analytics now tracks Video start, first/second/third quartile and completed playback
* Bugfix - OptimizePress 2 LiveEditor fix - live preview of video disabled for better compatibility
* Bugfix - RTMP playlist parsing fix is you enter the RTMP path like mp4:file.mp4

= 2.3.12 - 2015/02/13 =

* Feature - player position setting - lets you change the default centering to left align with no text wrapping
* Feature - RSS - improving player appearance
* Bugfix - autobuffering option fixed
* Bugfix - FV Flowplayer preview in admin screen conflict with WP Media Library fixed

= 2.3.11 - 2015/01/30 =

* Feature - setting for default splash screen added in Settings -> FV WordPress Flowplayer -> Sitewide Flowplayer Defaults -> Splash Image
* Bugfix - iOS 8 playback issues when using Video app
* Bugfix - playback issues when Google Analytics is configured for FV Flowplayer and it's blocked by some browser extension (like Ghostery)

= 2.3.10 - 2015/01/21 =

* Fix - admin player preview fixes
* Fix - code revisions, code optimizations for wp-admin
* Fix - src attribute parsing when fv_flowplayer_shortcode filter is used
* Fix - touch devices now use the device native fullscreen playback due to the inperfections in the browser fullscreen modes in different mobile browsers

= 2.3.9 - 2015/01/07 =

* Fix - added "Region" setting for the Amazon S3 buckets. It's required for AWS Signature Version 4 used by Frankfurt region.
* Bugfix - audio player responsivendess
* Bugfix - ratio uses coma instead of dot for decimal numbers on some servers - breaking things
* Bugfix - some PHP warnings
* Pro - YouTube Android < 4.3 fixes

= 2.3.8 - 2014/12/09 =

* Feature - upgrade to latest core Flowplayer (5.5.2 you- fixed for HLS, Flash performance, Windows Phone 8.1)
* Feature - [fvplayer post="{post id or 'this'}"] shows all the attached video files
* Feature - caption now shows up even for single videos
* Feature - live streams now show this message if the loading fails: "Live stream load failed. Please try again later, perhaps the stream is currently offline."
* Feature - playlist editor now has all the media upload buttons it needs
* Bugfix - player alignment was aligning it to the wrong/oposite side
* Bugfix - playlist editor showing duration of the last video added for new items
* Pro - Vimeo - improved loading for mobile users and quality switching improvements

= 2.3.7 - 2014/12/01 =

* Fix - changing retina CSS sprites to use a different post-fix. @x2 has issues with "All In One WP Security & Firewall" plugin
* Pro - fix for Lightbox splash image responsiveness

= 2.3.6 - 2014/11/20 =

* Bugfix - fix for auto play of playlists affecting other players on the page.
* Bugfix - fix for handling of videos on attachment pages
* Bugfix - fix for RTMP URLs with no file type like rtmp://host/live:stream-name
* Pro - fix for dynamic playlist (Vimeo, CloudFront) autoplay

= 2.3.5 - 2014/10/30 =

* Feature - added logo position option - see Settings -> FV WordPress Flowplayer -> Sitewide Flowplayer Defaults -> Logo
* Feature - added subtitle font size option - see Settings -> FV WordPress Flowplayer -> Player Skin -> Subitle Font Size
* Bugfix - bugfix for default volumne setting when set to 0 (mute)
* Pro - YouTube playlist items duration fix

= 2.3.4 - 2014/10/16 =

* Feature - add %random% to your ad code to put in a random number if required by the ad provider
* Feature - added option to skip CSS optimization (see Integrations settings)
* Feature - shortcode editor now uses the latest Media Library interface to upload the videos
* Bugfix - ad codes don't need to be responsive now that we check the player size before showing the code
* Bugfix - fixes for Google Chrome version checks
* Bugfix - shortcode editor fixes for /"
* Pro - Vimeo quality switching added (beta)

= 2.3.3 - 2014/10/13 =

* Feature - ad and popup feature now only loads the HTML content if the event (video playback or video end) occurs - making it more suitable for ads (as they won't load on background)
* Feature - custom plugin row action links added for easier access to Settings
* Feature - Scan video length - more information about videos in queue
* Feature - Scan video length - "Scan Now" button added!
* Bugfix - Scan video length was using Flash encoded URLs
* Bugfix - video splash image appearing around the video when video aspect ratio doesn't match the player size
* Pro - video lightbox links

= 2.3.2 - 2014/10/06 =

* Bugfix - bad Twitter sharing URLs
* Bugfix - fix for [fvplayer] shortcode handling in text widgets
* Pro - fix for start/end time in seconds

= 2.3.1 - 2014/10/06 =

* Feature - Colorbox compatibility (enhancement for programmers, Pro version has its own video and image lightbox gallery)
* Bugfix - fix for volume setting (no values above 1)
* Pro - easier video lightbox - type in <a href="http://your-server.com/videos/your-video.mp4" class="colorbox">click here to play video</a> and it will be open a lightbox with the video playing
* Pro - fixed YouTube video end bug when using Google Analytics tracking
* Pro - Quality Switching interface improved
* Pro (Beta) - added custom video ads (pre-roll, post-roll)
* Pro (Beta) - added support for custom video start and end time

= 2.3 - 2014/09/23 =

* Feature - upgreaded to latest core Flowplayer (5.5.0)
* Fix - fix for Windows Mobile 8.1 Update 1
* Bugfix - editor bug in rate cases
* Bugfix - video duratation checker fixes
* Pro - YouTube - added support for Google Developer API to parse the video durations and splash screens properly

= 2.2.22 - 2014/09/05 =

* Fix - WordPress 4.0 compatibility fix
* Fix - logo CSS fix
* Fix - video checker fixes
* Feature - playlist_hide added

= 2.2.21 - 2014/08/07 =

* Fix - mobile video is now used if there is no primary video
* Fix - UI fade out changed from 2 to 5 seconds for touch devices
* Fix - improved RTMP URL parsing to support rtmp://server/path/mp4:file-path URLs - however use RTMP server and RTMP path separately if possible
* Bugfix - sharing buttons were appearing even when disabled globally
* Pro - YouTube fix for Internet Explorer
* Pro - Quality switching enabled for HLS and other fixes

= 2.2.20 - 2014/08/05 =

* Feature - use share="Title;URL" to specify a custom URL for sharing using the video sharing buttons. Use "no" and "yes" to enable/disabled the sharing on the video.
* Fix - admin JavaScript check made less scary - it only shows up if you hover the player (and the JavaScript is broken of course)
* Fix - relative video paths were not respecting HTTP/HTTPS preference
* Fix - video checker won't work in IE 9 - added a warnings about that
* Fix - Android 4.x fullscreen compatibility fix (switch to native full screen mode as it's more compatible)
* Fix - Windows Mobile 8.1 compatibility fix (set to use inline playback)
* Fix - RTMP streams without extension now don't need "mp4:" entered at the start of path
* Pro - YouTube support added (enable in settings first)!
* Pro - Vimeo splash screen parsing (re-save your post to take effect)

= 2.2.19 - 2014/07/21 =

* Fix - missing controlbar="no" option for shortcode added
* Bugfix - video checker display issues

= 2.2.18 - 2014/07/16 =

* Bugfix - fix for PHP warnings

= 2.2.17 - 2014/07/11 =

* Fix - plugin HTML made more robust - it won't get damaged by some weird templates which put in P tags anymore
* Fix - share bar CSS improved to not be affected by template CSS
* Bugfix - plugin was failing to load its own JavaScript libraries in some rare cases (found on a website with Genesis framework, but we haven't found a compatibility issue when using it)

= 2.2.16 - 2014/07/07 =

* Feature - better support for Amazon S3 protected URLs and cache plugins - you can force a set expiry time now to match your cache timeout
* Pro (version 0.1.8) - support for secured CloudFront

= 2.2.15 - 2014/07/03 =

* Feature - added setting for default volume
* Bugfix - rare IE 11 issues with splash screen on autoplay videos

= 2.2.14 - 2014/06/24 =

* Bugfix - important fix for Chrome - share bar embed button was triggering video loading on background and thus causing extra traffic to the server
* Bugfix - some PHP and admin JS warnings 

= 2.2.13 - 2014/06/23 =

* Bugfix - fix for embed function call when not available (non-fatal JavaScript error)
* Bugfix - shortcode editor fixes for quotes in file URLs etc.
* Bugfix - video checker was sometimes listing JavaScript objects

= 2.2.12 - 2014/06/19 =

* Feature - play button now visible by default. Added option into Player Skin section.
* Fix - settings screen cleanup
* Beta feature - video duration scanning (check Integrations)
* Pro (version 0.1.7.3) - fixing PHP warnings

= 2.2.11 - 2014/06/17 =

* Bugfix - PHP warnings on fresh install settings save
* Pro (version 0.1.7.2) - fixing image lightbox to add class only for images.
* Pro (version 0.1.7.1) - bugfix for quality switching.

= 2.2.10 - 2014/06/13 =

* Bugfix - compatibility issues with "NextGen Gallery" plugin fixed
* Bugfix - loading indicator fixes for IE (was causing rendering issues in some configurations)
* Bugfix - share bar fixes for IE
* Pro - quality switching now happens live, without reloading of the webpage!

= 2.2.9 - 2014/06/05 =

* Feature - share bar added!
* Bugfix - annoying iOS 7 bug where black lines appear after videos - fixed!
* Bugfix - "Convert old shortcodes with commas" option changed to work with old [flowplayer] shortcodes only
* Bugfix - Pro extension settings forgotten if Pro extension was deactivated and options saved afterwards
* Bugfix - shortcode editor fixes for captions

= 2.2.8 - 2014/05/30 =

* Fix - compatibility issues with "NextGen Gallery" plugin fixed
* Fix - compatibility issues with "SI CAPTCHA Anti-Spam" plugin fixed
* Fix - Amazon S3 secure URLs in playlists were sometimes failing in Flash
* Pro - improved Vimeo error messages
* Pro - video lightbox now autoplays the video

= 2.2.7 - 2014/05/15 =

* Feature - licensed users automatically get FV Player Pro extension (video lightbox, Vimeo)
* Feature - video checker now also check RTMP!
* Fix - playlist style fix - alignment of more than 4 items
* Bugfix - basic Youtube embed fullscreen function
* Pro - Pro extension released! Adds support for video lightbox and advanced Vimeo embedding!

= 2.2.6 - 2014/04/17 =

* Fix - compatibility with WordPress 3.9 (it contains new TinyMCE editor version)

= 2.2.5 - 2014/04/16 =

* Bugfix - Amazon S3 protected URLs for Flash only browsers (edge case)

= 2.2.4 - 2014/04/11 =

* Bugfix - Amazon S3 protected URLs failure in edge cases on Flash devices
* Bugfix - Amazon S3 protected URLs in playlists
* Bugfix - fix for cursor icon on playlist items
* Bugfix - video checker now properly reports time out

= 2.2.3 - 2014/03/28 =

* Feature - option to change video watermark logo per video - use logo="http://your.logo/url.png" in shortcode. The sitewide logo has to be set for this to work though.
* Feature - playlist captions added (turn on in Settings -> FV WordPress Flowplayer -> Post Interface Options)
* Fix - admin front-end JavaScript checker now uses less aggressive color

= 2.2.2 - 2014/03/13 =

* Bugfix - OptimizePress 2 integration "admin note" now showing only for admins
* Bugfix - redirection finally works in Safari - if the popup fails, it opens the link in current window. Users can still use the browser back button.

= 2.2.1 - 2014/02/25 =

* Feature - added setting for bottom player margin - default to 28px
* Bugfix - CSS optimization - fix it the original CSS file fails to be opened
* Bugfix - "no Flowplayer scripts on your site" when there were no videos on homepage

= 2.2 - 2014/02/24 =

* Feature - attachment pages now work with FV Flowplayer
* Feature - OptimizePress2 integration - FV Flowplayer handles the videos inserted in OptimizePress Live Edit
* Feature - plugin skin CSS gets written into the main plugin CSS file to clean up your site header of any unnecessary style tags
* Feature - support for live streaming (add live="true" in shortcode)
* Fix - audio - support for Amazon S3 protected links
* Fix - "Check template" now looks for html5.js compatibility script and users see warnings on front-end if there are issues with JavaScript on the site
* Fix - "Check videos" button now uses the same code as admin video checker and is more resilient
* Fix - "Flash streaming server" settings acts as default RTMP server if there is none in the shortcode
* Fix - JavaScript only loads if the player is in use on the page
* Bugfix - bug in options initialization causing safety resize script missing on fresh install until save of the settings
* Bugfix - splash image URL encoding

= 2.1.52 - 2014/01/10 =

* Bugfix - critical bugfix for playlist parsing

= 2.1.51 - 2014/01/09 =

* Fix - upgrade to latest core Flowplayer
* Fix - removed unnucessary warnings from video checker
* Bugfix - Foliopress WYSIWYG compatibility

= 2.1.50 - 2013/12/06 =

* Bugfix - Amazon S3 bug after the JS optimization
* Bugfix - fix for PHP warnings
* Bugfix - Flashfit needs to be off by default to allow responsiveness
* Bugfix - HLS type in video source tag

= 2.1.49 - 2013/11/21 =

* Fix - Flowplayer configuration JS moved into footer
* Bugfix - Playlist - RTMP parsing issues
* Bugfix - Video Checker - disabled for PHP with Safe Mode On

= 2.1.48 - 2013/11/14 =

* Fix - playlist editor lets you specify all the required formats for the playlist items
* Fix - playlist thumbnails are 3:2 aspect ratio by default
* Fix - upgrade to latest core Flowplayer (5.4.4) fixing a lot of bugs (iOS7, RTMP ghost connections, ...)
* Bugfix - Post Interface Options saving

= 2.1.47 - 2013/11/05 =

* Fix - licensed users are required to agree on the automatic license key updates (required by WordPress.org policy)
* Fix - embed code libraries linked from the site hosting the plugin (required by WordPress.org policy)

= 2.1.46 - 2013/11/04 =

* Bugfix - playlist (beta) - improved HTML structure - fixes any playlist thumbnails display issues and responsiveness

= 2.1.45 - 2013/10/31 =

* Feature - Vimeo support - for now just a basic iframe embed - enter your Vimeo URL or ID as the video source 
* Feature - Youtube support - for now just a basic iframe embed - enter your Youtube URL or ID as the video source 

= 2.1.44 - 2013/10/22 =
* Bugfix - playlist (beta) - fix for splash image sizing
* Bugfix - playlist (beta) - shortcode editor was inserting empty playlist="" attributes when no playlist entered.

= 2.1.43 - 2013/10/22 =
* Fix - improved JavaScript - much less code in your site footer for each player

= 2.1.42 - 2013/10/18 =
* Bugfix - playlist (beta) - fixed CSS when more than 4 items in playlist
* Bugfix - playlist (beta) - fixed support for secure Amazon URLs - once more

= 2.1.41 - 2013/10/11 =
* Bugfix - bbPress compatibility fix - issues with some templates
* Bugfix - playlist (beta) - fixed support for secure Amazon URLs

= 2.1.40 - 2013/10/09 =
* Feature - playlist support - initial version, please let us know about any issues
* Fix - not using wp_get_headers() in video checker anymore - it was causing issues on some servers
* Fix - changed mime type and seeking points warnings in video checker to yellow warnings instead of errors
* Fix - added MPEG-1 warning to video checker
* Bugfix - RTMP parsing

= 2.1.39 - 2013/09/30 =
* Bugfix - Google Chrome preload disabler fix 
* Bugfix - Amazon S3 signed URLs - fix for + symbols in the URL

= 2.1.38 - 2013/09/26 =
* Bugfix - 3GP file parsing
* Bugfix - 3GP video checker messages - shows warnings to provide a HTML5 version of the video

= 2.1.37 - 2013/09/25 =
* Bugfix - Amazon S3 protected video length checking was interfering with some of the post saves in some cases

= 2.1.36 - 2013/09/23 =
* Bugfix - Amazon S3 secure link generator was suddenly failing for links without the bucket name in path part of URL 
* Bugfix - typo in OGV video parsing resulting in bad video type
* Bugfix - shortcode parsing when using oggtheora

= 2.1.35 - 2013/09/17 =
* Fix - added class fv-flowplayer-mobile-switch to the mobile switch message P element
* Fix - adjusted text of the template checker
* Bugfix - changed name of the RELATIVE_PATH constant for better compatibility
* Bugfix - video aspect ratio calculation for vertically oriented videos
* Bugfix - "Send to Foliovision" function of video checker - switched to use same From address as the WordPress site

= 2.1.34 - 2013/08/23 =
* Feature - template checker now also checks for working wp_footer hook in template
* Bugfix - Amazon S3 settings interface
* Bugfix - video player sizing in weird templates

= 2.1.33 - 2013/08/22 =
* Bugfix - fix for parsing of splash images (space characters)

= 2.1.32 - 2013/08/21 =
* Feature - better use of WordPress filters - for programmers. Read the guide here: http://foliovision.com/wordpress/plugins/fv-wordpress-flowplayer/api-programming
* Feature - support for Amazon S3 secured URLs!
* Fix - controlbar hides after 2 seconds of no mouse movement, it was 5 seconds before
* Fix - new structure of the Settings screen 
* Fix - options and settings screen layout revised - engine preference, fixed player size and video checker preference changed to simple checkboxes
* Bugfix - autobuffering now works only for first 2 videos also in HTML5
* Bugfix - autoplay now works only for the first video on the page (use fv_flowplayer_autoplay_limit filter)
* Bugfix - comma parsing turned off by default - it was causing issue with googlevideo.com URLs
* Bugfix - global variable name $scripts changed to $fv_fp_scripts
* Bugfix - video checker on WordPress Multisite media files

= 2.1.31 - 2013/08/09 =
* Fix - fixed dimension ads are now responsive - only part which first into the video player is shown
* Bugix - better Flash fallback for Google Chrome and Chromium - was not working without autobuffering ong

= 2.1.30 - 2013/08/08 =
* Fix - autobuffering now works only for first 2 videos on page ('fv_flowplayer_autobuffer_limit' filter) - to save your bandwidth.
* Fix - better Flash fallback for Google Chrome and Chromium - MP4 files just won't play for some people, so we detect this problem and reload the player in Flash mode - better than preferring Flash for all Chrome browsers
* Fix - player position is now calculated using JS if the player is too small - fixes issues with some of the themes, or when placing player into table with too many columns and no column width specified
* Fix - various finish events now don't use JS but CSS - popup, splashend.
* Bugfix - loop function in Flash player fixed
* Bugfix - player dimensions dropdown on settings screen
* Bugfix - splashend function in Flash player fixed* Bugfix - splashend function in Flash player fixed
* Bugfix - fix for rare occurrences of decimal numbers when fetching the video size in insert video dialog

= 2.1.29 - 2013/08/02 = 
* Bugfix - two boxes below each video removed - result of alpha version of playlist feature in our plugin. Sorry about the inconvenience.
* Bugfix - Chrome check breaking the plugin JS

= 2.1.28 - 2013/08/01 =
* Bugfix - we set Flash as preference in Chrome < 28 on Windows and Chrome < 27 on Linux. This tweak combined with disabled auto buffering on Chrome/Chromium should minimize issues with these browsers.
* Bugfix - loading indicator was in way of the play button - making it impossible to click in the middle of it. This was originally tweaked to avoid issues with some templates on iDevices (we registered 1 user having issues with this)

= 2.1.27 - 2013/07/31 =
*	Feature - styling presets for ad - let's you edit the ad CSS on the plugin settings screen
* Fix - auto buffering is disabled for MP4 in Google Chrome and Chromium, as therse browsers sometimes don't play MP4 and this seems to help
* Bugfix - auto buffering was not working properly and now it's fixed. It will be disabled after you upgrade this plugin. Please test it carefully before enabling it back on, mainly check your hosting bandwidth.

= 2.1.26 - 2013/07/26 =
* Fix - improved vidoe checker appearance
* Fix - player buttons fixed for white background
* Fix - play icon changed to striked-over play icon on video error
* Fix - video checker now detects bad mime type for WebM
* Bugfix - video checker fixed for big files

= 2.1.25 - 2013/07/18 =
* Bugfix - PHP warnings

= 2.1.24 - 2013/07/17 =
* Fix - added warning for Youtube videos (we don't have support for their embeding yet)
* Fix - ad and popup background color moved from inline style attribute to header, so you can use your template CSS to alter it now
* Fix - video checker warning about bad MOV mime type fixed. It only caused the playback issues with video/quicktime on Windows Firefox
* Bugfix - a glitch in iPad and iPhone rendering was causing our player to hide the entire post content when using certain templates (ThemesIndep, CSS .fp-waiting can't use display none there)
* Bugfix - Amazon S3 signed URL parsing for Flash player - thanks goes out to Jeremy Madison for his contribution!
* Bugfix - video checker now works with Amazon S3 signed URLs
* Bugfix - parsing of video type from Amazon S3 signed URLs

= 2.1.23 - 2013/07/11 =
* Fix - added warning for AVI videos - not supported by neither HTML5 nor Flash
* Fix - m3u8 parsing
* Fix - video checker now shows a tooltip that it's visible to admins only
* Bugfix - fix for editing of alternative video sources in "Add FV WP Flowplayer" dialog

= 2.1.22 - 2013/07/10 =
* Feature - video checker now also suggests when the video should be re-encoded or an alternative format provided (simple checks)
* Fix - you can now enter your RTMP server and RTMP video path independently for each video. Just click "Add RTMP" in the "Add FV WP Flowplayer" dialog.
* Fix - iPad, iPhone and Android users are no longer advised to download Flash if their device doesn't support the video. The notice now says: "Unsupported video format. Please use a Flash compatible device."
* Fix - Update to Flowplayer 5.4.3
* Bugfix - video checker "Send report to Foliovision" now doesn't interfere with Flowplayer shortcuts

= 2.1.20 - 2013/07/03 =
* Feature - added setting for player border (on by default for upgrades from 1.x version)
* Feature - added shortcode attribute for player alignment (enable in Interface Options)

= 2.1.19 - 2013/07/02 =
* Feature - added setting for ad text and link color
* Bugfix - video checker fix for Windows servers

= 2.1.18 - 2013/06/29 =
* Bugfix - fix for bad MOV parsing for HTML5 playing

= 2.1.17 - 2013/06/28 =
* Feature - Ad support! You can enter the global ad for your videos in plugin settings. Enable Interface options -> "Show Ads" to be able to specify ad in the video shortcode.
* Feature - Mobile video support! You can specify the low-bandwidth version of the video. We are working on recommended encoding settings and better mobile detection.
* Bugfix - fix for JetPack plugin conflict (After The Deadline)

= 2.1.16 - 2013/06/25 =
* Fix - video checker now requires a comment for the video issue submission
* Bugfix - video checker styling in older templates (no #content element)
* Bugfix - video checker URL parsing
* Bugfix - main plugin variable renamed, avoiding weird conflicts with some plugins

= 2.1.15 - 2013/06/24 =
* Bugfix - "Check template" bugfixes and improvements for WP Minify
* Bugfix - Fix for fix of Flowplayer preventing window.onload from firing on iPad
* Bugfix - Fix for RTMP streams with no extension
* Bugfix - Fix for video checker redirection and issues on some servers (which don't use DOCUMENT_ROOT)
* Bugfix - Settings screen moved to options-general.php?page=fvplayer

= 2.1.14 - 2013/06/12 =
* Feature - Added support for audio! Just put your MP3, OGG, or WAV into your shortcode.
* Feature - Added a function to report video not playing to Foliovision. Thank you for letting us know what videos don't play for you in our player.
* Styling - added some spacing below the video player
* Fix - Admin front-end video checker now takes minimum of space
* Bugfix - PHP warnings
* Bugfix - for parsing of video with no extension
* Bugfix - Flowplayer was preventing window.onload from firing on iPad

= 2.1.13 - 2013/06/05 =
* Feature - Added support for subtitles - first enable "Show Subtitles" in Settings -> FV WordPress Flowplayer -> Interface options
* Feature - Added options for what features show up in shortcode editor - check Settings -> FV WordPress Flowplayer -> Interface options
* Feature - Added option to allow/disallow embeding per video
* Fix - Admin front-end video checker is now less obnoxious - shows smaller messages and can be disabled in options
* Bugfix - for shortcode parsing

= 2.1.12 - 2013/05/31 =
* Feature - Front-end video checker now detects video codecs and other details (read "How to check my video properties using the built-in checker" in FAQ before we update our documentation )
* Fix - Firefox on Windows prefers Flash for M4V files (due to issues on some PCs)
* Styling - Fullscreen background color set to black
* Styling - Fix for bad fullscreen dimensions in some browsers (Chrome)
* Bugfix - Template checker bugfix for false positives (jQuery plugins detected as duplicite jQuery libraries)

= 2.1.11 - 2013/05/28 =
* Fix - more improvements and bugfixes for RTMP handling
* Fix - for template and videos checker

= 2.1.10 - 2013/05/28 =
* Fix - Update to Flowplayer 5.4.2
* Bugfix - more improvements and bugfixes for RTMP handling
* Bugfix - for popup and redirection in Flash version of the player
* Bugfix - for admin front-end check of the videos 

= 2.1.9 - 2013/05/27 =
* improvements and bugfixes for RTMP handling
* improved styling of insert video dialog box
* bugfix for autoplay is off for video when autoplay is on globally

= 2.1.8 - 2013/05/23 =
* quick bugfix for Flowplayer script loading

= 2.1.7 - 2013/05/22 =
* support for responsive layout enabled by default
* automated check of template added to settings screen - checks if your template loads Flowplayer and jQuery libraries properly
* automated check of video files added to setting screen - checks if your servers are using right mime type for videos

= 2.1.6 - 2013/05/21 =
* quick fix for player skin - time values not appearing properly for some font faces

= 2.1.5 - 2013/05/17 =
* player font face setting
* improved appearance of the embed dialog
* improved shortcode editor (does handle iframe in popup correctly)
* various CSS fixes

= 2.1.4 - 2013/05/16 =
* quick fix for shortcode parsing when there is a newline after src parameter

= 2.1.3 - 2013/05/15 =
* Flowplayer now by default uses Flash (for better compatibility)
* shortcode editor fixes
* when using HTML5, admins get warnings about videos with bad mime type as they browse the site.
* logged in admins see warnings above MP4 videos with bad mime type

= 2.1.2 - 2013/05/10 =
* fix for player alignment (center by default)
* fix for volume bar alignment (was not working properly when using obsolete &lt;center&gt; tags)

= 2.1.1 - 2013/05/08 =
* fix for browser caching
* upgrade to latest core Flowplayer (5.4.1)
* additional fixes for smooth install (more compatible default settings)
* lightening of branding
* apologies to anyone who faced difficulties with the initial 2.1 version: FV Flowplayer 5 should work for you now

= 2.1 - 2013/05/02 =
* small interface changes

= 2.0 - 2013/05/02 =
* upgrade to Flowplayer 5
* fixes in the shortcode editor

= 1.2.17 =
* bugfix for wp-content paths
* fix for some warnings
* bugfix for popups and splash image at the end

= 1.2.16 =
* Flowplayer shortcodes and placeholders removed from feed

= 1.2.14 =
* Fixed Sharing permalink
 
= 1.2.14 =
* Option in settings to prevent doubling the link in the popup box, default option is set to false (do not double)

= 1.2.13 =
* Loading javascripts only when video is present on the page - optional, see settings page

= 1.2.12 =
* XSS fix

= 1.2.11 =
* FV Flowplayer removed from RSS feeds

= 1.2.10 =
* fix for HTTPS, thanks to Scott Elkin

= 1.2.9 =
* Bug with flush rules fixed

= 1.2.8 =
* added options for default video size
* problem with splasscreen at the end fixed
* audio plugin installed foraudio tracks

= 1.2.7 =
* Problem with widgets fixed

= 1.2.6 =
* Support functions for future extensions added

= 1.2.5 =
* Support functions for future extensions added

= 1.2.4 =
* Wizard fixes
* Added option for showing splash image at the end

= 1.2.3 =
* HTML 5 suport for mobile browsers (Thanks for donation from [enterpriseIT](http://enterpriseit.com/))
* incorrect paths fixed

= 1.2.2 =
* Option for keeping the aspect ratio of videos
* Class 'flowplayer_frontend' not found bug fixed

= 1.2.1 =
* License key entering fixed
* Color entering fixed

= 1.2.0 =
* Compatibility with the commercial version - possibility to insert licence key and get completely unbranded version
* Fixed the conflict with media library

= 1.1.0 =
* Flowplayer logos reintroduced at request of WordPress.org

= 1.0.6 =
* widgets problems with splash image and controlbar fixed
* cyan background color fixed

= 1.0.5 =
* compatibility fixes
* HTTPS support added

= 1.0.4 =
* compatibility fixes
* configuration file replaced by WP options

= 1.0.3 =
* white spaces causing errors on some servers fixed

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

== Other Notes ==

This new version uses Flowplayer 5 running on HTML5, so we recommend you read first two questions of FAQ first.

Once the plugin is uploaded and activated, there will be a submenu of settings menu called FV WordPress Flowplayer. In that submenu, you can modify following settings:

* AutoPlay - decides whether the video starts playing automatically, when the page/post is displayed.
* AutoBuffering - decides whether te video starts buffering automatically, when the page/post is displayed. If AutoPlay is set to true, you can ignore this setting.
* Popup Box - decides whether a popup box with "replay" and "share" buttons will be displayed when video ends.
* Enable Full-screen Mode - select false if you do not wish the fullscreen option to be displayed.
* Allow User Uploads - select true if you like to upload new videos via Media Library.
* Enable Post Thumbnail - select true if you wish the screen shot appear as post thumbnail. Works only when uploading new splash image via Media Library.
* Convert old shortcodes with commas - older versions of this plugin used commas to sepparate shortcode parameters. This option will make sure it works with current version.
* Commercial Licence Key - enter your licence key here to get the completely unbranded version of the player
* Colors of all the parts of flowplayer instances on page/post (controlbar, canvas, sliders, buttons, mouseover buttons, time and total time, progress and buffer sliders).

On the right side of this screen, you can see the current visual configuration of flowplayer. If you click Apply Changes button, this player's looks refreshes.

== Upgrade Notice ==

= 6.0.3 =

* Brand new core Flowplayer 6!

= 2.4 =

* CSS styles are now loaded using WP API wp_enqueue_scripts(). Please check your player appearance.

= 2.3.16 =

* Check your videos using Amazon S3 download protection

= 2.3.13 =

* RTMP path fix - double check that you use RTMP file extensions properly - rtmp_path="mp4:example.mp4" for mp4 file and rtmp_path="example" for FLV/Flash video file.

= 2.3.8 =

* New core Flowplayer - fixed for HLS, Flash performance, Windows Phone 8.1

= 2.3.3 =

* Fix for ad and popup codes, please check!

= 2.2.22 =
* Fix for Amazon RTMP path parsing - plus signs in the path were handled incorrectly for Flash engine

= 2.2.14 =
* Important fix for share bar embed function in Chrome - it was triggering video loading on background in and thus causing extra traffic to the server

= 2.2.4 =
* Amazon S3 protected content playlist fixes. Please check you playlist after the upgrade.

= 2.2 =
* Big CSS optimization. If you notice any display issues, please go into plugin settings and re-save the options.

= 2.1.40 =
* Added support for playlists - beta

= 2.1.32 =
* New settings screen - engine preference, fixed player size and video checker preference changed to simple checkboxes.

= 2.1.27 =
* This new version includes a fix for autobuffering, which was not working properly. It will be disabled after you upgrade this plugin. Please test it carefully before enabling it back on, mainly check your hosting bandwidth.

= 2.1.16 =
* Feature - Added support for audio! Just put your MP3, OGG, or WAV into your shortcode.
* Feature - Added a function to report video not playing to Foliovision. Thank you for letting us know what videos don't play for you in our player.
* Fixes for RTMP parsing - please check your RTMP videos after upgrade.
* Upgrade to latest Flowplayer version - 5.4.3

= 2.1.16 =
* Feature - Added support for audio! Just put your MP3, OGG, or WAV into your shortcode.
* Feature - Added a function to report video not playing to Foliovision. Thank you for letting us know what videos don't play for you in our player.
* Styling - added some spacing below the video player
* Various bug fixes, check changelog

= 2.1.13 =
* Admin front-end video checker is not much smaller and can be disabled in options
* Support for subtitles added

= 2.1.11 =
* Upgrade to latest Flowplayer version - 5.4.2
* Fixes for RTMP parsing - please check your RTMP videos after upgrade.

= 2.1.10 =
* Upgrade to latest Flowplayer version - 5.4.2
* Fixes for RTMP parsing - please check your RTMP videos after upgrade.

= 2.1.9 =
* Fixes for RTMP parsing - please check your RTMP videos after upgrade.

= 2.1.5 =
* Default player font face set to Tahoma, Geneva, sans-serif. Change 'Player font face' setting to 'inherit from template' if you have your own CSS.

= 2.1.4 =
* Flowplayer now defaults to using Flash for Internet Explorer 9 and 10 (due to server compatibility issues when bad mime type is set).

= 2.1.3 =
* Flowplayer now defaults to using Flash for Internet Explorer 9 and 10 (due to server compatibility issues when bad mime type is set).

= 2.0 =
* Brand new version of Flowplayer! HTML5 compatible video player. Please check your videos thoroughly.
