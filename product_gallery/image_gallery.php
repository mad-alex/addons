<?php 


// Add this code to your theme's functions.php file or a custom plugin

// Remove default product image
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

// Add custom HTML in place of the product image
add_action('woocommerce_before_shop_loop_item_title', 'custom_product_listing_html', 10);

function custom_product_listing_html() {
    // Replace '123' with your actual product ID
    $product_id = 486;

    // Get the product object
    $product = wc_get_product($product_id);

    // Check if the product exists and is not null
    if ($product) {
        // Get the product gallery attachment IDs
        $gallery_attachment_ids = $product->get_gallery_image_ids();

        // Get the main product image ID
        $main_image_id = $product->get_image_id();

        // Output custom HTML or use your own HTML structure
        echo '<div class="custom-product-listing">';
        
        // Output custom HTML for the main image or do something else
        echo '<div class="custom-main-image">';
       /// echo wp_get_attachment_image($main_image_id, 'full'); // Display the main image
        echo '</div>';

        // Output custom HTML for the gallery images or do something else
        if (!empty($gallery_attachment_ids)) {
			 
           /// echo '<div class="custom-gallery-images">';
            foreach ($gallery_attachment_ids as $gallery_attachment_id) {
                //echo wp_get_attachment_image($gallery_attachment_id, 'thumbnail'); // Display gallery images
            }
           // echo '</div>';
        }

        echo '</div>';
		   img222();
    } else {
        echo "Product not found.";
    }
}



add_shortcode('imag11','img222');

function img222(){
	
	?>

 <style>
 body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.slideshow-container {
    max-width: 800px;
    position: relative;
    margin: auto;
}

.slide {
    display: none;
    position: absolute;
    width: 100%;
}

img {
    width: 100%;
}

.fade {
    ani mation: fade 0.3s ease-in-out infinite;
}

@keyframes fade {
    from {
        opacity: .4;
    }
    to {
        opacity: 1;
    }
}

 </style> 
 
    

    <div class="slideshow-container" id="slideshow2">
        <div class="slide fade">
            <img src="https://wpbakery.softbricks.ro/wp-content/uploads/2023/09/zwzdr9vw-cc-200x200.jpg" alt="Image 5">
        </div>
        <div class="slide fade">
            <img src="https://wpbakery.softbricks.ro/wp-content/uploads/2023/11/d03-Color-2-1-200x200.jpg" alt="Image 6">
        </div>
        <a class="prev" onclick="plusSlides(-1, 'slideshow2')">&#10094;</a>
        <a class="next" onclick="plusSlides(1, 'slideshow2')">&#10095;</a>
    </div>
 
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    


    <script>
	
	$(document).ready(function() {
    $('.slideshow-container').each(function() {
        let slideIndex = 0;
        let slides = $(this).find('.slide');

        function showSlides() {
            for (let i = 0; i < slides.length; i++) {
                $(slides[i]).css('display', 'none');
            }

            slideIndex++;

            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            $(slides[slideIndex - 1]).css('display', 'block');
            setTimeout(showSlides, 6000); // Change slide every 2 seconds
        }

        showSlides();

        // Function to navigate to the previous or next slide
        window.plusSlides = function(n, slideshowId) {
            let currentSlideIndex = slideIndex;
            showSlides(slideIndex += n);

            // Reset slideIndex to the current slide if the new index is out of bounds
            if (slideIndex > slides.length || slideIndex < 1) {
                slideIndex = currentSlideIndex;
            }
        };
    });
});

	
	</script>
 




	<?php
	
}