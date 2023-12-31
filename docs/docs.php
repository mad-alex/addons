<?php


add_shortcode('doc_list','doc_list_functions');

function doc_list_functions(){
	
	$args = array(
    'post_type' => 'custom_doc',
    'post_status' => 'publish',
    'posts_per_page' => -1, // -1 to fetch all posts, or set the number of posts to show
);

$loop = new WP_Query($args);

// Initialize the variable to store all posts
$all_posts = array();

// Check if there are posts
if ($loop->have_posts()) {
    while ($loop->have_posts()) {
        $loop->the_post();

        // Get post title and permalink
        $post_title = get_the_title();
        $post_permalink = get_permalink();

        // Store post data in the $all_posts array
        $all_posts[] = array(
            'title' => $post_title,
            'permalink' => $post_permalink,
        );
    }
}

// Restore original post data
wp_reset_postdata();
	return html_for_doc_list($all_posts);
}

function html_for_doc_list($data){
	
	$html = '';
	
	foreach($data as $item){ 
		$html .= "<a href='".$item['permalink']."'>".$item['title']."</a><br>";
	}
	
	return $html;
}