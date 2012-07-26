<?php
/*
Plugin Name: Drop Shadow Boxes
Plugin URI: http://www.stevenhenty.com
Description: Drop Shadow Boxes provides an easy way to highlight important content on your posts and pages. Includes a shortcode builder with a preview so you can test your box before adding it.
Version: 1.0
Author: stevehenty
Author URI: http://www.stevenhenty.com

------------------------------------------------------------------------
Copyright 2012 Steven Henty

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/




//------------------------------------------
 

require_once(DropShadowBoxes::get_base_path() . "/widget.php");

if(!defined("DSB_CURRENT_PAGE"))
    define("DSB_CURRENT_PAGE", basename($_SERVER['PHP_SELF']));
if(!defined("IS_ADMIN"))
    define("IS_ADMIN",  is_admin());

add_action('init',  array('DropShadowBoxes', 'init'));




//------------------------------------------
class DropShadowBoxes {

    private static $path = "dropshadowboxes/dropshadowboxes.php";
    private static $url = "http://www.stevenhenty.com";
    private static $slug = "dropshadowboxes";
    private static $version = "1.0";

	static $add_scripts;
	
	
    //Plugin starting point. Will load appropriate files
    public static function init(){
		
		
		load_plugin_textdomain( 'dropshadowboxes', false, '/dropshadowboxes/languages' );
			
		//register scripts
		
		add_filter('the_posts', array('DropShadowBoxes', 'conditionally_add_scripts_and_styles')); // the_posts gets triggered before wp_head
		
		
		
		if(IS_ADMIN){
			if(in_array(DSB_CURRENT_PAGE, array('post.php', 'page.php', 'page-new.php', 'post-new.php'))){
                        add_action('admin_footer',  array('DropShadowBoxes', 'add_mce_popup'));
						add_action('admin_enqueue_scripts', array('DropShadowBoxes', 'load_styles'));
                    }
			//Adding "box" button
            add_action('media_buttons_context', array('DropShadowBoxes', 'add_box_button'));
			
			add_action('wp_ajax_dropshadowboxes_ajax_get_preview', array('DropShadowBoxes', 'dropshadowboxes_ajax_get_preview'));
			
		} else {
			if( is_active_widget( '', '', 'dropshadowboxes_widget' ) ) { // check if search widget is used
				 wp_enqueue_style('dropshadowboxes_css', plugins_url( 'css/dropshadowboxes.css', __FILE__ ));
			}

		}
		
		add_shortcode( 'dropshadowbox', array('DropShadowBoxes', 'render_shortcode') );
		add_shortcode( 'dropshadowboxes', array('DropShadowBoxes', 'render_shortcode') );
				

    } //end function init
	
	function load_styles(){
       wp_enqueue_style('dropshadowboxes_css', plugins_url( 'css/dropshadowboxes.css', __FILE__ ));
}

	
	public static function dropshadowboxes_ajax_get_preview() {
		// TO DO - check ajax referrer
		$shortcode = $_POST['shortcode'];
		
		$outputarray = array();
		
		$outputarray["preview"] = do_shortcode( stripslashes($shortcode) );
		$outputarray["status"] = "ok";
		echo json_encode($outputarray);
		die();
		 
	}
	
	
	function conditionally_add_scripts_and_styles($posts){
		if (empty($posts)) return $posts;
	 
		$shortcode_found = false;
		foreach ($posts as $post) {
			if (stripos($post->post_content, '[dropshadowbox') !== false) {
				$shortcode_found = true;
				break;
			}
		}
	 
		if ($shortcode_found) {
			wp_enqueue_style('dropshadowboxes_css', plugins_url( 'css/dropshadowboxes.css', __FILE__ ));
		}
	 
		return $posts;
	}
	
	function render_shortcode( $attributes, $content = null) {
		 
		extract(shortcode_atts(array(
			'align' => "none",
			'width' => "300px",
			'border_width' => "2",
			'border_color' => "#DDD",
			'rounded_corners' => true,
			'inside_shadow' => true,
			'outside_shadow' => true,
			'effect' => "lifted-both"

		), $attributes));
		 
		$rounded_corners = strtolower($rounded_corners) == "false" ? false : true;
		$inside_shadow = strtolower($inside_shadow) == "false" ? false : true;
		$outside_shadow = strtolower($outside_shadow) == "false" ? false : true;
		$effect = strtolower($effect);

	
		$box_classes = "";
		$box_style = "";
		$container_classes = "";
		$container_style = "";
		
		if ( $align == "left" )	{
			$container_classes .= "dropshadowboxes-left ";
			$container_style .= 'width:' . $width .';';
		} elseif ( $align == "right" ) {
			$container_classes .= "dropshadowboxes-right ";
			$container_style .= 'width:' . $width . ';';
		} elseif ( $align == "none" ) {
			$container_style .= 'width:' . $width . ';';
		} elseif ( $align == "center" ) {
			$container_classes .= "dropshadowboxes-center ";
			$container_style .= 'width:100%;';
			$box_style .= 'width:' . $width . ';';
		}
		
		if ( $rounded_corners === true )	
			$box_classes .= "dropshadowboxes-rounded-corners ";
			
			
		if ( $inside_shadow === true && $outside_shadow === true)	
			$box_classes .= "dropshadowboxes-inside-and-outside-shadow ";
		elseif ( $inside_shadow === true )	
			$box_classes .= "dropshadowboxes-inside-shadow ";
		elseif ( $outside_shadow === true )	
			$box_classes .= "dropshadowboxes-outside-shadow ";
			

		if ( $effect == "lifted" )	
			$box_classes .= "dropshadowboxes-lifted-both ";
		elseif ( $effect == "lifted-both" )	
			$box_classes .= "dropshadowboxes-lifted-both ";
		elseif ( $effect == "lifted-bottom-left" )	
			$box_classes .= "dropshadowboxes-lifted-bottom-left ";
		elseif ( $effect == "lifted-bottom-right" )	
			$box_classes .= "dropshadowboxes-lifted-bottom-right ";
		elseif ( $effect == "curled" )
			$box_classes .= "dropshadowboxes-curled ";
		elseif ( $effect == "perspective-left" )
			$box_classes .= "dropshadowboxes-perspective-left ";
		elseif ( $effect == "perspective-right" )
			$box_classes .= "dropshadowboxes-perspective-right ";
		elseif ( $effect == "raised" ) {
			
			if ( $inside_shadow === false && $outside_shadow === false ) {
				$box_classes .= "dropshadowboxes-raised-no-inside-shadow-no-outside-shadow ";	
			} elseif ( $inside_shadow === true &&  $outside_shadow === false ) {
				$box_classes .= "dropshadowboxes-raised-with-inside-shadow-no-outside-shadow ";
			} elseif ( $inside_shadow === false &&  $outside_shadow === true ) {
				$box_classes .= "dropshadowboxes-raised-no-inside-shadow-with-outside-shadow ";
			} elseif ( $inside_shadow === true &&  $outside_shadow === true ) {
				$box_classes .= "dropshadowboxes-raised-with-inside-shadow-with-outside-shadow ";
			}
			
		} elseif ( $effect == "vertical-curve-left" )
			$box_classes .= "dropshadowboxes-curved ";
		elseif ( $effect == "vertical-curve-both" )
			$box_classes .= "dropshadowboxes-curved dropshadowboxes-curved-vertical-2 ";
		elseif ( $effect == "horizontal-curve-bottom" )
			$box_classes .= "dropshadowboxes-curved dropshadowboxes-curved dropshadowboxes-curved-horizontal-1 ";
		elseif ( $effect == "horizontal-curve-both" )
			$box_classes .= "dropshadowboxes-curved dropshadowboxes-curved dropshadowboxes-curved-horizontal-2 ";
		

		
		$content = '<div class="dropshadowboxes-container ' . $container_classes. '" style="' . $container_style . '"><div class="dropshadowboxes-drop-shadow ' . $box_classes . '" style="' . $box_style . 'border:' . $border_width . 'px solid ' . $border_color. '">' . do_shortcode( $content ) . '</div></div>';
		
		return $content;
				  
	} // end function gf_polls_poll_shortcode

	//Action target that adds the "Insert dropshadowbox" button to the post/page edit screen
    public static function add_box_button($context){
	
        $is_post_edit_page = in_array(DSB_CURRENT_PAGE, array('post.php', 'page.php', 'page-new.php', 'post-new.php'));
        if(!$is_post_edit_page)
            return $context;

        $image_btn = self::get_base_url() . "/images/box-button.png";
        $out = '<a href="#TB_inline?&height=555&width=640&inlineId=add_dropshadowbox" class="thickbox" id="add_box" title="' . __("Add Drop Shadow Box", 'dropshadowboxes') . '"><img src="'.$image_btn.'" alt="' . __("Add Drop-Shadow Box", 'dropshadowboxes') . '" /></a>';
        return $context . $out;
    }
	
	 //Action target that displays the popup to insert a form to a post/page
    function add_mce_popup(){
        ?>
		<script>
            function BuildDropShadowBoxShortcode(){
                var box_alignment = jQuery("#box_alignment").val();
				var box_effect = jQuery("#box_effect").val();
				var box_width = jQuery("#box_width").val();
				var box_width_units = jQuery("#box_width_units").val();
				var border_width = jQuery("#border_width").val();
				var border_color = jQuery("#border_color").val();

                var rounded_corners = jQuery("#rounded_corners").is(":checked");
				var inside_shadow = jQuery("#inside_shadow").is(":checked");
				var outside_shadow = jQuery("#outside_shadow").is(":checked");

				var box_alignment_qs = "align=\"" + box_alignment + "\" ";
				var box_effect_qs = "effect=\"" + box_effect + "\" ";
				var box_width_qs = "width=\"" + box_width + box_width_units + "\" ";
				var border_width_qs = "border_width=\"" + border_width + "\" ";
				var border_color_qs = "border_color=\"" + border_color + "\" ";
				
                var rounded_corners_qs = !rounded_corners ? "rounded_corners=\"false\" " : "";
				var inside_shadow_qs = !inside_shadow ? "inside_shadow=\"false\" " : "";
				var outside_shadow_qs = !outside_shadow ? "outside_shadow=\"false\" " : "";
				
				var box_content = jQuery("#box_content").val();

               return "[dropshadowbox " + box_alignment_qs + box_effect_qs + box_width_qs + border_width_qs + border_color_qs + rounded_corners_qs + inside_shadow_qs + outside_shadow_qs + "]" + box_content + "[/dropshadowbox]";
            }
			function SendDropShadowShortCodeToEditor(){
				 window.send_to_editor( BuildDropShadowBoxShortcode() );
			}
			
			function RefreshPreview(){
			
				jQuery.ajax({
					url:ajaxurl,
					type:'POST',
					dataType: 'json',
					data:'action=dropshadowboxes_ajax_get_preview&shortcode=' + BuildDropShadowBoxShortcode(),
					success:function(results) {
						if (results === -1){
							//permission denied
						}
						else {

							var ajaxresults = results;

							jQuery("#dropshadowboxes_preview-placeholder").html(ajaxresults.preview);

						}
						
					}
					
				});	
			
			}
			
        </script>
        <div id="add_dropshadowbox" style="display:none;width:640px;overflow:auto">
            <div id="dropshadowbox_shortcode_builder_container" class="wrap">
                
                    <div style="padding:15px 15px 0 15px;">
                        <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;margin-top:0"><?php _e("Insert a Drop-Shadow Box", "dropshadowboxes"); ?></h3>
                        <span>
                            <?php _e("Select the options below for your drop-shadow box.", "dropshadowboxes"); ?>
                        </span>
                    </div>
					 <div style="padding:15px 15px 0 15px;"><?php _e("Effect:", "dropshadowboxes"); ?>
                        <select id="box_effect">
							<option value="lifted-both"><?php _e("Lifted (Both)", "dropshadowboxes"); ?> </option>
							<option value="lifted-bottom-left"><?php _e("Lifted (Left)", "dropshadowboxes"); ?> </option>
							<option value="lifted-bottom-right"><?php _e("Lifted (Right)", "dropshadowboxes"); ?> </option>
							
                           <option value="curled"><?php _e("Curled", "dropshadowboxes"); ?> </option>
						   <option value="perspective-left"><?php _e("Perspective (Left)", "dropshadowboxes"); ?> </option>
						   <option value="perspective-right"><?php _e("Perspective (Right)", "dropshadowboxes"); ?> </option>
						   <option value="raised"><?php _e("Raised", "dropshadowboxes"); ?> </option>
						   <option value="vertical-curve-left"><?php _e("Vertical Curve (Left)", "dropshadowboxes"); ?> </option>
						   <option value="vertical-curve-both"><?php _e("Vertical Curve (Both)", "dropshadowboxes"); ?> </option>
						   <option value="horizontal-curve-bottom"><?php _e("Horizontal Curve (Bottom)", "dropshadowboxes"); ?> </option>
						   <option value="horizontal-curve-both"><?php _e("Horizontal Curve (Both)", "dropshadowboxes"); ?> </option>
                        </select>
						
						<?php _e("Alignment:", "dropshadowboxes"); ?>
						<select id="box_alignment">
							<option value="none"><?php _e("None", "dropshadowboxes"); ?> </option>
							<option value="left"><?php _e("Left", "dropshadowboxes"); ?> </option>
							<option value="right"><?php _e("Right", "dropshadowboxes"); ?> </option>
							<option value="center"><?php _e("Center", "dropshadowboxes"); ?> </option>
                        </select>
						
						<?php _e("Width:", "dropshadowboxes"); ?>
						<input id="box_width" value="250" class="small-text" type="text" />
						<select id="box_width_units">
							<option value="px"><?php _e("pixels", "dropshadowboxes"); ?> </option>
							<option value="%"><?php _e("%", "dropshadowboxes"); ?> </option>
                        </select>
						
                    </div>


					<div style="padding:15px 15px 0 15px;">
                        <?php _e("Border width (pixels):", "dropshadowboxes"); ?><input id="border_width" value="1" class="small-text" type="text" /> &nbsp;&nbsp;&nbsp;
                        <?php _e("Border color:", "dropshadowboxes"); ?>  
						<select id="border_color">
							<option value="#DDD"><?php _e("Gray", "dropshadowboxes"); ?> </option>
							<option value="red"><?php _e("Red", "dropshadowboxes"); ?> </option>
							<option value="blue"><?php _e("Blue", "dropshadowboxes"); ?> </option>
							<option value="green"><?php _e("Green", "dropshadowboxes"); ?> </option>
							<option value="black"><?php _e("Black", "dropshadowboxes"); ?> </option>
							<option value="white"><?php _e("White", "dropshadowboxes"); ?> </option>
                        </select>
                    </div>
					
                    <div style="padding:15px 15px 0 15px;">
                        <input type="checkbox" id="rounded_corners" checked='checked' /> <label for="rounded_corners"><?php _e("Rounded corners", "dropshadowboxes"); ?></label> &nbsp;&nbsp;&nbsp;
						<input type="checkbox" id="inside_shadow" checked='checked' /> <label for="inside_shadow"><?php _e("Inside shadow", "dropshadowboxes"); ?></label> &nbsp;&nbsp;&nbsp;
						<input type="checkbox" id="outside_shadow" checked='checked' /> <label for="outside_shadow"><?php _e("Outside shadow", "dropshadowboxes"); ?></label> &nbsp;&nbsp;&nbsp;
                        
                    </div>
					
					<div style="padding:15px 15px 0 15px;">
                        <textarea style="width:100%" id="box_content"><?php _e("Enter your content here.", "dropshadowboxes"); ?></textarea> &nbsp;&nbsp;&nbsp;
                        
                    </div>
                    <div style="padding:0px 15px 15px 15px;">
						<input type="button" class="button-primary" value="<?php _e("Refresh Preview", "dropshadowboxes"); ?>" onclick="RefreshPreview();"/>&nbsp;&nbsp;&nbsp;
                        <input type="button" class="button-primary" value="<?php _e("Insert Box", "dropshadowboxes"); ?>" onclick="SendDropShadowShortCodeToEditor();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "dropshadowboxes"); ?></a>
                    </div>
					<fieldset style="border: 4px dashed #DDDDDD;width:90%;margin:0 15px 0 15px;">
						<legend style="color:#CCC;font-weight:bold;font-family: Helvetica, Arial;font-size: 1.8em"><?php _e("Preview", "dropshadowboxes"); ?></legend>
						<div id="dropshadowboxes_preview_box" style="height: 200px;padding:15px;overflow:auto;">
							<div id="dropshadowboxes_preview_container" style="width:95%;">
							Tellus vestibulum tempus tellus ullamcorper amet egestas varius sollicitudin ut tellus ac sollicitudin dolor. 
							<span id="dropshadowboxes_preview-placeholder"></span>
							Curabitur auctor dignissim dignissim tellus at ligula facilisis et varius sit ullamcorper egestas sit hendrerit vestibulum in. Donec amet lorem amet id velit amet id ut nec nulla dignissim. Tortor morbi varius iaculis lorem vestibulum amet dignissim facilisis in. 
							</div>
						</div>
					</fieldset>
            </div>
        </div>
		<script>
		jQuery(document).ready(function(){
			RefreshPreview();
		});
		</script>
        <?php
    }
	
	
	//helper functions
	 public function get_base_url(){
        $folder = basename(dirname(__FILE__));
        return plugins_url($folder);
    }
	
	//Returns the physical path of the plugin's root folder
    public function get_base_path(){
        $folder = basename(dirname(__FILE__));
        return WP_PLUGIN_DIR . "/" . $folder;
    }
	
	public static function _log( $message ) {
		if( WP_DEBUG === true ){
		  if( is_array( $message ) || is_object( $message ) ){
			error_log( print_r( $message, true ) );
		  } else {
			error_log( $message );
		  }
		}
	  }
	
} //end class


?>
