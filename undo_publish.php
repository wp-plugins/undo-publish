<?php
/*
Description: Undo Publish, inspired by Gmail Labs' "Undo Send". Let's you stop posts from being published for a few seconds after hitting Publish button.
Plugin Name: Undo Publish
Plugin URI: http://ign.com.uy/2010/wordpress-plugin-undo-publish
Author: ign
Author URI: http://ign.com.uy
Version: 0.1
*/


add_action( "admin_footer", 'undo_publish' );
define(TIME_LIMIT, 3000);

function undo_publish() {
	wp_enqueue_script('jquery');
	global $parent_file;
	global $post;

	if ( is_admin() && $parent_file == 'edit.php' && $post->post_status != 'publish'):

	?>
	
		<div id="undo-publish" style="display:none; position:absolute; top:0; left:50%; padding: 6px; background-color:#FFFFE0;">
			<a href="#" onclick="undoPublish();" >Cancel Publish</a>
		</div>
	
		<script type="text/javascript">
		
			jQuery(document).ready(function(){
				jQuery("#publish").hide();
				jQuery("#publishing-action").append('<input type="submit" value="Publish"  id="publish-alt" class="button-primary" name="publish-alt" />');
				
				jQuery('#publish-alt').click(function() {
					
					undo_publish = setTimeout("jQuery('#publish').click()", <?php echo TIME_LIMIT; ?>);
					jQuery('#undo-publish').show();
					jQuery('#ajax-loading').show();	
					return false;
				});
				
			});

			function undoPublish(){
				clearTimeout(undo_publish);
				jQuery('#undo-publish').hide();	
				jQuery('#ajax-loading').hide();	
				jQuery('#save-post').removeClass('button-disabled');
				jQuery('#publish-alt').removeClass('button-primary-disabled');
					
			}
			
		</script>
	<?php
	
	endif;
}