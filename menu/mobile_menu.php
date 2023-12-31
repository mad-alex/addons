<?php 

  
  add_shortcode('mobile_menu','mobile_menu_sh_function');
  
  function mobile_menu_sh_function(){
	 return  mobile_menu_v1();
  }
  
function mobile_menu_v1(){
	 
	$timp_deschidere = 40;
	 
	 
	?>
	
	

<!--
	logo

iconuri 

menu deschis la click pe  'sandvish'

---------------------

elemente principale cu butoane de toggle
 elemente secundare
   elemente nivel 3 confor menu  
-->

<style type="text/css">
 

:root{
  --red:red;
--font-icon: 24px;
--font-menu-item: 24px;
--font-menu-button: 24;
--font-family: Arial;

--border_color_menu_item: #ddd;
}

@media(min-width:<?php  echo CM_MENU_WIDTH;?>){
  .menu_mobile_custom,.menu_mobile_custom_relative{
    display:none
  }
}


.menu_mobile_custom{ 
background: #fff;


position: sticky; /*fixed*/;
	  left:0px;
	    
	width:100%;
	z-index:333;

  border-bottom:1px solid #333;
  box-shadow:0px 3px 10px  #333;
}
 
.menu_mobile_custom .logo img{
   max-width:40px !important;
}



 
 
.menu_mobile_custom *{
   font-family:  var(--font-family)
}

 

.menu_mobile_custom .menu_header  { 
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: space-between;
  align-items: center;
  align-content: stretch;

}

.menu_mobile_custom .logo{ 
  padding:10px
}

.menu_mobile_custom .menu_icon_list{
   display:table;
   width:50%; 
}

.menu_mobile_custom .menu_item{
 font-size: var(--font-icon);
}

.menu_mobile_custom .menu_item{
 float:left;
 width:auto;
 display:table;
 padding:10px; 
}
 
 
 
.menu_mobile_custom .menu_list_items { 
display:table;
 width:100%;}

.menu_mobile_custom .menu_list_items .label{
   display : flex ;  
   justify-content: space-between;
   align-items: center; 
}

.menu_mobile_custom .menu_list_items .label .text{
  padding:10px;
}

.menu_mobile_custom .menu_list_items .label .button{
  margin:0px;  padding:10px;
}


.menu_mobile_custom .main_item  *{
  display:table;
}
.menu_mobile_custom .main_item .label,
.menu_mobile_custom .secondary .label,
.menu_mobile_custom .tertiar .label{
    width:100%;
    border-bottom: 1px solid  var(--border_color_menu_item)
}

.menu_mobile_custom .secondary{
	display:none
}

.menu_mobile_custom .show_div .secondary{
	display:table
}

.menu_mobile_custom .show_div{
	display:table;
}


.menu_mobile_custom .main_item, .secondary,.tertiar{
  width:100%;

}

.menu_mobile_custom .main_item > .label > .text,
.menu_mobile_custom .secondary > .label > .text,
.menu_mobile_custom .tertiar   > .label > .text{
   font-size: var(--font-menu-item);  
}

.menu_mobile_custom  .menu_list_items .label .button{
   font-size: var(--font-menu-button);  !important; 
}
 

.menu_mobile_custom  .menu_mobile_custom{
	 
	width: 100%;
	background:#fff;  
}
 
.menu_mobile_custom  .menu_secundar { 
	width:100%;
	height:0px; 
	overflow : hidden ; 
}

 
.menu_mobile_custom_relative{
	height:0px;
	margin-bottom:-77px;
	width:100%;
	display:table;
	background: transparent;
}

@media(min-width:800px){
	.menu_mobile_custom_relative{
		display:none !important;
	}
}
</style>

<!--

decompletat manual

-->

<div class='menu_mobile_custom' id='menu_mobile_custom_id'>
	<div class='menu_header'>
		<div class='logo'>
			<div class='logo'><img src="https://wpbakery.softbricks.ro/wp-content/uploads/2023/11/31a92baf44f001c32c22a441cd023d54.png"/></div>
		</div>
		<div class='menu_icons'>  
					<div class='menu_item'>rr</div>
					<div class='menu_item'>rr</div>
					<div class='menu_item  ' id='open_menu_icon' data-menustate='closed'>rr</div>
				 
			 
		</div>
	</div>
	<div class='menu_secundar closed_menu' data-menustate='closed' id='mobile_menu_content'>
		 
			<div class='menu_list_items'>
				<div id='c1' class='main_item'>
					<div class='label'>
						<div class='text'>text</div>
						<div class='button' data-id='c1'>buton</div>
					</div>
					<div class='secondary'>
						<div class='label'>
							<div class='text'>text</div> 
					    </div>
						<div class='tertiar'>
							<div class='label'>
								<div class='text'>text</div> 
					   		</div>
						</div>
					</div>
				</div>
				<div id='c2' class='main_item'>
					<div class='label'>
						<div class='text'>text</div>
						<div class='button' data-id='c2'>buton</div>
					</div>
					<div class='secondary'>
						<div class='label'>
							<div class='text'>text</div> 
					    </div>
						<div class='tertiar'>
							<div class='label'>
								<div class='text'>text</div> 
					   		</div>
						</div>
					</div>
				</div> 
			</div> 
	</div>
</div>
<div class='menu_mobile_custom_relative' id='menu_mobile_custom_rel_id'>teste</div>
<script>


$ = jQuery;

$('#open_menu_icon').click(function(){
	let menu_state = $('#open_menu_icon').attr('data-menustate');
	let duration_in = <?php echo $timp_deschidere; ?>;
	let duration_out = <?php echo $timp_deschidere; ?>;;

	if(menu_state=='closed'){
	    menu_state = 'open'; 
	}else{
	    menu_state = 'closed'; 
	}

	$('#open_menu_icon').attr('data-menustate',menu_state)
	
	$('#mobile_menu_content').attr('data-menustate',menu_state)
	//$('#mobile_menu_content').toggleClass('closed_menu');
	 
	 console.log( menu_state )
	if( menu_state == 'open'  ){
		let h_menu = $('#mobile_menu_content .menu_list_items')[0].offsetHeight;
		$('#mobile_menu_content').animate({'height':h_menu+'px'},duration_in)
	}else{
		$('#mobile_menu_content').animate({'height':'0px' },duration_out);
		console.log('menu_state')
	}

})


function toggleHeight(element) {
    const content = element.querySelector('div');
    const contentHeight = content.offsetHeight;

    element.style.maxHeight = element.classList.toggle('expanded') ? contentHeight + 'px' : 0;
  }
  
  // Stilizare dinamica pt asezare menu mobil
  let var_height_menu_header = $('.menu_mobile_custom')[0].offsetHeight;
  $('.menu_mobile_custom_relative').css('height',var_height_menu_header + 'px')
  
 $('.label .button').click(function(){
    let id_name = $(this).attr('data-id') 
	console.log(id_name);
    $('#'+id_name ).toggleClass('show_div')
    $('#mobile_menu_content').css('height','auto');
 })
  
  ///////////////////////////
  ////////////////////////////
  // control pentru meniu sticky

setInterval(function(){
	if(! $('.menu_mobile_custom_relative').visible(true)){
		$('.menu_mobile_custom').hide()
	}else{
		$('.menu_mobile_custom').show()
	}
},100)  
  
  
  $(window).scroll(function() {
	    if( $(window).width() <= 800){
    var top_of_element = $("#menu_mobile_custom_rel_id").offset().top;
    var bottom_of_element = $("#menu_mobile_custom_rel_id").offset().top + $("#menu_mobile_custom_rel_id").outerHeight();
    var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
    var top_of_screen = $(window).scrollTop();

    if ( !((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element))){
        // the element is visible, do something
		//$('.menu_mobile_custom').fadeOut().hide();
		$('.menu_mobile_custom').addClass('fixed')
    } else {
        // the element is not visible, do something else
		//$('.menu_mobile_custom').fadeIn().show()
	
	    $('.menu_mobile_custom').removeClass('fixed')
	
    }
		}else{
			 $('.menu_mobile_custom').hide()
		}
		
});
  
</script>
	
	<?php  
}