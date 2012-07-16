=== Drop Shadow Boxes ===
Contributors: stevehenty
Tags: drop shadow,box shadow,perspective,raised,curl,lifted
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 0.1

Drop Shadow Boxes provides an easy way to highlight important content on your posts and pages. Includes a shortcode builder with a preview so you can test your box before adding it.

== Description ==

Drop Shadow Boxes provides an easy way to highlight important content on your posts and pages. Includes a shortcode builder with a preview so you can test your box before adding it. It will work on the latest versions of all browsers. Some older browsers may not display the shadows - but they will display the box with the content. Please see the following page for examples to see how it performs on your browser:
http://www.stevenhenty.com/products/wordpress-plugins/drop-shadow-boxes/examples/

Drop Shadow Boxes is currently in beta. If you find any that needs fixing, or if you have any ideas for improvements, please get in touch:
http://www.stevenhenty.com/contact/ 

== Installation ==

1.  Download the zipped file.
1.  Extract and upload the contents of the folder to /wp-contents/plugins/ folder
1.  Go to the Plugin management page of WordPress admin section and enable the 'Drop Shadow Boxes' plugin

== Instructions ==

This plugin itself doesn't require any configuration. There isn't a setting page, just a shortcode builder which you can access from the media toolbar while you're editing the post/page by clicking on the box icon next to the upload/insert media button.

= Shortcode Reference =
If you prefer not to use the shortcode builder, or if you'd like to modify an existing drop shadow box here's the 
Example usage:
[dropshadowbox]your content[/dropshadowbox]

[dropshadowbox align="left"]your content[/dropshadowbox]

[dropshadowbox effect="raised"]your content[/dropshadowbox]

[dropshadowbox effect="horizontal-curve-bottom" rounded_corners="false"]your content[/dropshadowbox]

Attributes:
align = [left/right/center/none] default: "none" <br />
width = [width plus units e.g. "250px" or "50%"] default: "300px" <br />
border_width = [width in pixels] default "2" <br />
border_color = [colour code or name e.g. "#A8A8A8" or "blue"] default:"#DDD" <br />
rounded_corners = [true/false] default: "true" <br />
inside_shadow = [true/false] default: "true" <br />
outside_shadow = [true/false] default: "true" <br />
effect = [lifted/curled/perspective-left/perspective-right/raised/vertical-curve-left/vertical-curve-both/horizontal-curve-bottom/horizontal-curve-both] default: "lifted"<br />

Drop Shadow Boxes is currently in beta. If you find any that needs fixing, or if you have any ideas for improvements, please get in touch:
http://www.stevenhenty.com/contact/ 

== Frequently Asked Questions ==

= Will the shadows work in all browser? =
It will work on the latest versions of all browsers. Some older browsers may not display the shadows - but they will display the box with the content. Please see the following page for examples to see how it performs on your browser:
http://www.stevenhenty.com/products/wordpress-plugins/drop-shadow-boxes/examples/

= How do I open the shortcode builder? =
While you're editing a post or page you can open the shortcode builder by clicking on the box icon next to the upload media button above the toolbar.

= Can I edit the shadow effect? =
The shortcode builder offers quite a few options. If you need further customisation you'll need to edit the css file.

= Will the css file be loaded on all pages or only when it's needed? =
The css file will only be loaded when it's needed - when there's a [dropshadowbox] shortcode on the page or post.

= Are images used to display the shadows? =
No. It uses CSS3 only to prodcue the effects.

== Screenshots ==

Please see the following page for examples to see how it performs on your browser:
http://www.stevenhenty.com/products/wordpress-plugins/drop-shadow-boxes/examples/

1. Example boxes
2. Shortcode builder


== ChangeLog ==

= 0.1 =
* Initial beta release.

