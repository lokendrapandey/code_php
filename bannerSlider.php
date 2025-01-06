<?php
/**
 * Theme functions and definitions.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {
    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        HELLO_ELEMENTOR_CHILD_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

/**
 * Register Custom Post Types.
 */
function create_posttypes() {
    // Banner Post Type
    register_post_type( 'banner',
        array(
            'labels' => array(
                'name' => __( 'Banner' ),
                'singular_name' => __( 'Banner' ),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'banner' ),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ),
        )
    );

    // ImageSlider Post Type
    register_post_type( 'imageSlider',
        array(
            'labels' => array(
                'name' => __( 'Image Slider' ),
                'singular_name' => __( 'Image Slider' ),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'image-slider' ),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( 'category', 'post_tag' ),
        )
    );
}
add_action( 'init', 'create_posttypes' );

/**
 * Banner Shortcode
 */
function custom_banner() {
    $the_query = new WP_Query(array(
        'post_type' => 'banner',
        'posts_per_page' => 3,
    ));
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <div class="swiper mySwiper banner_slider">
        <div class="swiper-wrapper">
            <?php 
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
                <div class="swiper-slide" style="background: url('<?php echo get_the_post_thumbnail_url(); ?>'); background-size: cover;">
                    
                    <div class="banner_contant_parent">

                        <div class="banner_contant">
                            <span><?php the_field('post_sub_title'); ?></span>
                            <h1><?php the_title(); ?></h1>
                            <?php the_excerpt(); ?>
                            <div class="banner_button">
                                <a href="<?php echo esc_url( get_field('button_url') ); ?>"><?php the_field('button_text'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile; 
                wp_reset_postdata();
            else :
                echo '<p>No banners found.</p>';
            endif;
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".banner_slider ", {
            slidesPerView: 1,
            autoplay: {
           delay: 3000, // Time in ms (3 seconds)
           disableOnInteraction: false, // Keep autoplay running even after interaction
       },
            pagination: {
                
                el: ".swiper-pagination",
                clickable: true,

            },
            loop: true,
        });
    </script>
    <?php
}
add_shortcode('custom_banner', 'custom_banner');

/**
 * Image Slider Shortcode
 */

function image_slider() {
    $the_query = new WP_Query(array(
        'post_type' => 'imageSlider',
        'posts_per_page' => 10,
    ));
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <div class="swiper MySwiper_s" class="img_swiper" >
        <div class="swiper-wrapper" id="img_wrappper" >
            <?php 
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
            
               <div class="swiper-slide" id="img_slide" style="background: url('<?php echo get_the_post_thumbnail_url(); ?>'); background-size: cover;">
                   <div class="image_slider_content">
                        <h1><?php the_title(); ?></h1>
                        <?php the_excerpt(); ?>
                        <?php the_content(); ?>
                    </div> 
                    

                   <?php 
                    $link = get_field('product_category_link');
                    if( $link ): ?>
                        <a class="img_slider_link" href="<?php echo esc_url( $link ); ?>"></a>
                    <?php endif; ?>
                </div>
            
            <?php 
                endwhile; 
                wp_reset_postdata();
            else :
                echo '<p>No images found.</p>';
            endif;
            ?>
        </div>
        
        <!-- <div class="buttonn">
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div class="swiper-scrollbar"></div> -->
        <!-- <div class="swiper-pagination"></div> -->

    </div>

        <div class="button_next_prev">
           <div class="swiper-button-prev"><img class="left"  src="http://localhost/Ecommerce/wp-content/uploads/2025/01/Group-1000003686.svg" alt=""></div>
           <div class="swiper-button-next"><img     src="http://localhost/Ecommerce/wp-content/uploads/2025/01/Group-1000003686.svg" alt=""></div>
        </div>

        <div class="swiper-scrollbar"></div>
        <!-- <div class="swiper-pagination"></div> -->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".MySwiper_s", {
        slidesPerView: 5,
        spaceBetween: 10,
       
        scrollbar: {
          el: ".swiper-scrollbar",
          hide: true,
        },
          navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    </script>
    <!-- <script>
        var swiper = new Swiper(".MySwiper_s", {
          slidesPerView: 3,
          spaceBetween: 10,
          centeredSlides: true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          scrollbar: {
          el: ".swiper-scrollbar",
          hide: true,
        },
          navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        });
    </script> -->
    <?php
}
add_shortcode('image_slider', 'image_slider');


























// imageSlider post type code start here
// function create_posttype() {
  
//     register_post_type( 'imageSlider',
//     // CPT Options
//         array(
//             'labels' => array(
//                 'name' => __( 'ImageSlider' ),
//                 'singular_name' => __( 'ImageSlider' )
//             ),
//             'public' => true,
//             'has_archive' => true,
//             'rewrite' => array('slug' => 'imageSlider'),
//             'show_in_rest' => true,
// 			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail',  'custom-fields', ),
  
//         )
//     );
// }

// add_action( 'init', 'create_posttype' );
