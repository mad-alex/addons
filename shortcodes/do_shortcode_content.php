<?php
 
add_shortcode('content_post','do_shortcode_content_function');

add_shortcode('do_shortcode_content','do_shortcode_content_function');

function do_shortcode_content_function($atts = [], $content = null, $tag = '' ) {
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	// override default attributes with user attributes
	$wporg_atts = shortcode_atts(
		array(
			'id' => '',
		), $atts, $tag
	);
	
	if($wporg_atts['id'] != 0){
		$post_obj = get_post($wporg_atts['id']);
		
		if( is_object($post_obj )){
			if(property_exists($post_obj,'post_content')){
				 return do_shortcode($post_obj->post_content);
			}
		}
		
	}
	
	
}