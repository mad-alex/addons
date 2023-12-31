<?php 


add_action('wp',function(){
	add_shortcode('slider_ddsd','ddsd55');
});


function ddsd55(){
	
$aa = '';

ob_start();


echo '	<style>';
echo file_get_contents(__DIR__.'/css.css');
echo '	</style>';	

 echo file_get_contents(__DIR__.'/html.html');
 
echo '<script>';
echo file_get_contents(__DIR__.'/js.js');
echo '	</script>';

$aa = ob_get_clean();

ob_end_clean();
	
	
return $aa;

}