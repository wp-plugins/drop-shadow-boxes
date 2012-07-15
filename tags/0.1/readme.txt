=== Drop Shadow Boxes ===
Contributors: stevehenty
Tags: drop shadow,box shadow,perspective,raised,curl,lifted
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 0.1

Add boxes with drop shadows to your posts and pages.

== Description ==

Drop Shadow Boxes provides an easy way to highlight important content on your posts and pages. Includes a shortcode builder with a preview so you can test your box before adding it.

== Installation ==

1.  Download the zipped file.
1.  Extract and upload the contents of the folder to /wp-contents/plugins/ folder
1.  Go to the Plugin management page of WordPress admin section and enable the 'Drop Shadow Boxes' plugin

**Configuration**

This plugin itself doesn't require any configuration. 

= Shortcode Builder =
While you're editing a post or page you can open the shortcode builder by clicking on the box icon next to the upload media button above the toolbar.

= Shortcode Reference =
Example usage:
[dropshadowbox]your content[/dropshadowbox]

[dropshadowbox align="left"]your content[/dropshadowbox]

[dropshadowbox effect="raised"]your content[/dropshadowbox]

[dropshadowbox effect="horizontal-curve-bottom" rounded_corners="false"]your content[/dropshadowbox]

Attributes:
align = [left/right/center/none] default: "none"
width = [width plus units e.g. "250px" or "50%"] default: "300px"
border_width = [width in pixels] default "2"
border_color = [colour code or name e.g. "#A8A8A8" or "blue"] default:"#DDD"
rounded_corners = [true/false] default: "true"
inside_shadow = [true/false] default: "true"
outside_shadow = [true/false] default: "true"
effect = [lifted/curled/perspective-left/perspective-right/raised/vertical-curve-left/vertical-curve-both/horizontal-curve-bottom/horizontal-curve-both] default: "lifted"


== Frequently Asked Questions ==

= Will the shadows work in all browser? =
It will work on the latest versions of all browsers. Older versions are not supported.

= Can I edit the shadow effect? =
The shortcode builder offers quite a few options. If you need further customisation you'll need to edit the css file.

= Will the css file be loaded on all pages or only when it's needed? =
The css file will only be loaded when it's needed - when there's a [dropshadowbox] shortcode on the page or post.

== Screenshots ==

Please see the following page for screenshots and examples:
http://www.stevenhenty.com/products/wordpress-plugins/drop-shadow-boxes/examples/


== ChangeLog ==

= 0.1 =
* Initial beta release.

