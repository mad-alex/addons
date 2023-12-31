<?php




/*
de facut 

incarcare mia eficienta script si css

incarcare de slideer multiple in pagina 

*/


new new_content_slider;

class new_content_slider
{ 

    //add_option
    /* in media se adauga Slide link
    [banner_rotativ ids='1,33,2']
     */
    public function __construct()
    {
        // [banner_rotativ]
        add_shortcode('new_content_slider', array(
            $this,
            'new_content_slider_func',
        ));
    }

    public function style()
    {
        ?><style><?php echo file_get_contents(__DIR__ . '/css.css'); ?></style><?php
}

    public function script()
    {
        ?><script>
		
		$ = jQuery;
		<?php echo file_get_contents(__DIR__ . '/slider.js'); ?></script><?php
}
    public function custom_script()
    {
        ?>
			<script type="text/javascript">
$ = jQuery;
var HTMLButtonElement = "ELEM";

	var splide = new Splide('.splide', {
							  type   : 'loop',


							  //
							  pauseOnHover: false,
							  pauseOnFocus: true,


                                 
							  //
							  // gap        : 10,

							   //
							 ///  rewind     : true,

							  //
							    //pagination  : true,

								//
								cover       : true,

							  // !!!
							  //autoplay:'play',

							  // nr containere pe monitor
							  perPage: 1,
							  //  text sageti
							 arrows: { prev  : HTMLButtonElement, next  : HTMLButtonElement },

							 // clase special sageti
							  classes: {
									arrows: 'splide__arrows your-class-arrows',
									arrow : 'splide__arrow your-class-arrow',
									prev  : 'splide__arrow--prev your-class-prev',
									next  : 'splide__arrow--next your-class-next',
							  },

							},
							
							);
							
		splide.on( 'move', function () {
  // do something
  //MyTransition( splide, Components )
} );
						
 // new Splide( '#splide' ).mount( {}, MyTransition );

 function MyTransition( Splide, Components ) {
  const { bind } = EventInterface( Splide );
  const { Move } = Components;
  const { list } = Components.Elements;

  let endCallback;

  function mount() {
    bind( list, 'transitionend', e => {
      if ( e.target === list && endCallback ) {
        // Removes the transition property
        cancel();

        // Calls the `done` callback
        endCallback();
      }
    } );
  }

  function start( index, done ) {
    // Converts the index to the position
    const destination = Move.toPosition( index, true );

    // Applies the CSS transition
    list.style.transition = 'transform 800ms cubic-bezier(.44,.65,.07,1.01)';

    // Moves the slider to the destination.
    Move.translate( destination );

    // Keeps the callback to invoke later.
    endCallback = done;
  }

  function cancel() {
    list.style.transition = '';
  }

  return {
    mount,
    start,
    cancel,
  };
}  //////////////////

splide.mount(); // 344 342

</script>
		<?php
}
    public function new_content_slider_func($atts)
    {
        $atts = array_change_key_case((array) $atts, CASE_LOWER);
		
		if( !isset( $atts['ids'] )){
			return  ;
		}
		
//print_r( $atts);
        // $atts['ids']
        $this->style();
        $this->script();
        $this->content( $atts['ids']);
        $this->custom_script();

    }
    public function content($ids)
    {
        if ($ids == '') {return '';}
        $data = explode(',', $ids);
        if (count($data) > 0) {
            if ($data[0] != '') {

                ?>
		<div class="splide avada_content_slider_wrap">
  <div class="splide__track">
		<ul class="splide__list">
		<?php
foreach ($data as $id) {
                    ?><li class="splide__slide"><?php echo do_shortcode("[continut_post id='$id']"); ?></li><?php
}
                ?>
		</ul>
  </div>

</div><?php
}
        }

    }

}