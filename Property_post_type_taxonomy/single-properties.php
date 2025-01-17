<!-- <div class="property-single">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <h1 class="property-title"><?php the_title(); ?></h1>
            <div class="property-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
            <div class="property-content">
                <?php the_content(); ?>
            </div>
            <div class="property-meta">
                <p><strong>Author:</strong> <?php the_author(); ?></p>
                <p><strong>Published on:</strong> <?php the_date(); ?></p>
                <?php if (get_the_terms(get_the_ID(), 'properties_category')) : ?>
                    <p><strong>Category:</strong>
                        <?php
                        $categories = get_the_terms(get_the_ID(), 'properties_category');
                        foreach ($categories as $category) {
                            echo $category->name . ' ';
                        }
                        ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endwhile;
    else :
        echo '<p>No property found.</p>';
    endif;
    ?>
</div> -->






<?php get_header(); ?>




<div class="property-details_seconde_slider">

 <div class="property_images_seconde_slider">

   <div class="seconde_slider_box">
        <!-- seconde slider work start -->
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

           <div  class="swiper mySwiper2">

              <div class="swiper-wrapper  ">
                   <?php
                   $gallery_images = get_post_meta(get_the_ID(), '_property_gallery', true); // Fetch the property gallery images
                   if (!empty($gallery_images)) :
                       foreach ($gallery_images as $image_id) :
                           $image_url = wp_get_attachment_url($image_id);
                           ?>
                           <div class="swiper-slide">
                               <img src="<?php echo esc_url($image_url); ?>" alt="Property Image">
                           </div>
                       <?php endforeach;
                   else : ?>
                       <p>No gallery images available for this property.</p>
                   <?php endif; ?>


                

                </div>
                   <div thumbsSlider="" class="swiper mySwiper">
                       <div class="swiper-wrapper">
                       <?php
                       if (!empty($gallery_images)) :
                           foreach ($gallery_images as $image_id) :
                               $image_url = wp_get_attachment_url($image_id);
                               ?>
                               <div class="swiper-slide">
                                   <img src="<?php echo esc_url($image_url); ?>" alt="Thumbnail Image">
                               </div>
                           <?php endforeach;
                       endif; ?>
                       </div>
                   </div>

       <!-- Swiper JS -->
       <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

       <!-- Initialize Swiper -->
       <script>
           var swiper = new Swiper(".mySwiper", {
           loop: true,
           spaceBetween: 5,
           slidesPerView: 4,
           freeMode: true,
           watchSlidesProgress: true,

        

           });
           var swiper2 = new Swiper(".mySwiper2", {
           loop: true,
           spaceBetween: 10,
           navigation: {
               nextEl: ".swiper-button-next",
               prevEl: ".swiper-button-prev",
           },
           thumbs: {
               swiper: swiper,
           },
           });
       </script>
  </div>


</div>  
<div class="slider_second_description_box">
    
    <h3><?php the_title(); ?></h3>
   <p><span>Price: ₹</span><?php echo esc_html(get_field('property_price')); ?></p>
   <p><span>Size:</span> <?php echo esc_html(get_field('property_size')); ?> sq ft</p>
   <p><span>Parking:</span> <?php echo get_field('parking') ? 'Yes' : 'No'; ?></p>
   <p><span>Balcony:</span> <?php echo get_field('balcony') ? 'Yes' : 'No'; ?></p>
   <p><span>Garage:</span> <?php echo  get_field('garage') ? 'Yes' : 'No'; ?></p>
</div>
</div>

   <div class="seconde_slider_description">
   <p> <h3>Description</h3><span>Description:</span> <?php echo esc_html(get_field('description')); ?></p>
   </div>    


<?php get_footer(); ?>




















