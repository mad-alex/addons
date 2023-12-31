<?php 



foreach(scandir(__DIR__) as $dir){
	
	if(file_exists(__DIR__.'/'.$dir.'/'.$dir.'.php')){
		  require_once(__DIR__.'/'.$dir.'/'.$dir.'.php');
	}
	
}

 load_local_folder_files();

function load_local_folder_files(){
	foreach(scandir(__DIR__) as $dir){
	
	if(file_exists(__DIR__.'/'.$dir.'/'.$dir.'.php')){
		require_once(__DIR__.'/'.$dir.'/'.$dir.'.php');
	}
	
}
}


function load_local_files($folder_dir){
	foreach(scandir($folder_dir) as $dir){
	  /// echo $folder_dir.'/'.$dir.'.php'.'--';
	if(file_exists( $folder_dir.'/'.$dir ) && strpos($dir,'.php') !== false){
		require_once( $folder_dir.'/'.$dir );
	}
	
}
}

function porc2(){
	
	return 'wfwef';
}

add_shortcode('porc2','porc2');

//
// instalare in tema

// 
// require '/home/softbric/wpbakery.softbricks.ro/addons/addons.php';
// 

 


add_shortcode('continut_post','continut_post_sh_functions');

/*
TODO:  1 w wefefefa cawef e efw ewefe; efef efe efe eefe ee e efe efeef wefwe
*/

function continut_post_sh_functions($atts){
	
		$a = shortcode_atts( array(
		'id' => '',
		'comm' => '',
		//'bar' => 'something else',
	), $atts );
	
	if($a['id']!=''){ 
	$data = get_post($a['id']);
		if(is_object($data) ){
		 return     do_shortcode($data->post_content);
		}
	}
} /*
TODO*:efwefwef
TODO*:efwefweefe e  f  w

TODO: w w
TODO: w wefefef
BUG:
FIX:
REFACTOR:
DONE:
INFO:

*/

/*
TODO:  2 w wefefefa cawef e efw ewefe; efef efe efe eefe ee e efe efeef wefwe
*/