<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
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




















// // Register Custom Post Type for Properties
// function create_property_post_type() {
//     $labels = array(
//         'name'                  => 'Properties',
//         'singular_name'         => 'Property',
//         'menu_name'             => 'Properties',
//         'all_items'             => 'All Properties',
//         'add_new_item'          => 'Add New Property',
//         'edit_item'             => 'Edit Property',
//         'new_item'              => 'New Property',
//         'view_item'             => 'View Property',
//         'search_items'          => 'Search Properties',
//     );

//     $args = array(
//         'labels'                => $labels,
//         'public'                => true,
//         'has_archive'           => true,
//         'menu_icon'             => 'dashicons-building',
//         'supports'              => array('title', 'editor','author', 'thumbnail'),
//         'rewrite'               => array('slug' => 'properties'),
//     );

//     register_post_type('property', $args);
// }
// add_action('init', 'create_property_post_type');




// // Register Custom Taxonomy for Property Types
// function create_property_taxonomy() {
//     $labels = array(
//         'name'              => 'Property Types',
//         'singular_name'     => 'Property Type',
//         'search_items'      => 'Search Property Types',
//         'all_items'         => 'All Property Types',
//         'parent_item'       => 'Parent Property Type',
//         'edit_item'         => 'Edit Property Type',
//         'update_item'       => 'Update Property Type',
//         'add_new_item'      => 'Add New Property Type',
//         'menu_name'         => 'Property Types',
//     );

//     $args = array(
//         'labels'            => $labels,
//         'hierarchical'      => true,
//         'public'            => true,
//         'rewrite'           => array('slug' => 'property-type'),
//     );

//     register_taxonomy('property_type', array('property'), $args);
// }
// add_action('init', 'create_property_taxonomy');












// Register Custom Post Type for Properties
// function create_property_post_type() {
//     $labels = array(
//         'name'                  => 'Properties',
//         'singular_name'         => 'Property',
//         'menu_name'             => 'Properties',
//         'all_items'             => 'All Properties',
//         'add_new_item'          => 'Add New Property',
//         'edit_item'             => 'Edit Property',
//         'new_item'              => 'New Property',
//         'view_item'             => 'View Property',
//         'search_items'          => 'Search Properties',
//     );

//     $args = array(
//         'labels'                => $labels,
//         'public'                => true,
//         'has_archive'           => true,
//         'menu_icon'             => 'dashicons-building',
//         'supports'              => array('title', 'editor', 'author', 'thumbnail'),
//         'rewrite'               => array('slug' => 'properties'),
//     );

//     register_post_type('property', $args);
// }
// add_action('init', 'create_property_post_type');


// // Register Custom Taxonomy for Categories
// function create_property_category() {
//     $labels = array(
//         'name'              => 'Property Categories',
//         'singular_name'     => 'Property Category',
//         'search_items'      => 'Search Property Categories',
//         'all_items'         => 'All Property Categories',
//         'parent_item'       => 'Parent Property Category',
//         'edit_item'         => 'Edit Property Category',
//         'update_item'       => 'Update Property Category',
//         'add_new_item'      => 'Add New Property Category',
//         'menu_name'         => 'Property Categories',
//     );

//     $args = array(
//         'labels'            => $labels,
//         'hierarchical'      => true,
//         'public'            => true,
//         'rewrite'           => array('slug' => 'property-category'),
//     );

//     register_taxonomy('property_category', array('property'), $args);
// }
// add_action('init', 'create_property_category');





























// // Register Custom Post Type for Properties
// function create_property_post_type() {
//     $labels = array(
//         'name'                  => 'Properties',
//         'singular_name'         => 'Property',
//         'menu_name'             => 'Properties',
//         'all_items'             => 'All Properties',
//         'add_new_item'          => 'Add New Property',
//         'edit_item'             => 'Edit Property',
//         'new_item'              => 'New Property',
//         'view_item'             => 'View Property',
//         'search_items'          => 'Search Properties',
//     );

//     $args = array(
//         'labels'                => $labels,
//         'public'                => true,
//         'has_archive'           => true,
//         'menu_icon'             => 'dashicons-building',
//         'supports'              => array('title', 'editor', 'author', 'thumbnail'),
//         'rewrite'               => array(
//             'slug'       => 'properties',
//             'with_front' => false,
//             'pages'      => true,
//             'feeds'      => true,
//         ),
//         'taxonomies' => array( 'category', 'post_tag' ),
//     );

//     register_post_type('property', $args);
// }
// add_action('init', 'create_property_post_type');








//second post type

function create_property_post_type() {
    register_post_type('property',
        array(
            'labels' => array(
                'name' => __('Properties'),
                'singular_name' => __('Property')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'author','custom-fields'),
            'taxonomies' => array('category'), // Category ke liye taxonomy add karein
            'rewrite' => array('slug' => 'property'),

        )
    );
}
add_action('init', 'create_property_post_type');


function display_property_listing($atts) {
    $args = array(
        'post_type' => 'property',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    $output = '';

    if ($query->have_posts()) {
        $output .= '<div class="property-listing">';
        while ($query->have_posts()) {
            $query->the_post();
            $categories = wp_get_post_categories(get_the_ID(), array('fields' => 'names'));
            $category_list = implode(', ', $categories);
            $gallery = get_field('property_image_gallery');
            $balcony = get_field('balcony') ? 'Yes' : 'No';
            $parking = get_field('parking') ? 'Yes' : 'No';
            $garage = get_field('garage') ? 'Yes' : 'No';
            $size = get_field('flat_size');
            $price = get_field('flate_price');
            $location = get_field('location');
            $excerpt = get_the_excerpt();   // Excerpt
            // $author_name = get_the_author(); // Author
            
            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $link = get_field('product_image_link');
            $img_link = $link ? '<a href="' . esc_url($link) . '"><img src="' . esc_url($featured_image_url) . '" alt="' . get_the_title() . '" /></a>' : '<img src="' . esc_url($featured_image_url) . '" alt="' . get_the_title() . '" />';

            $output .= '<div class="property">';
            $output .= $img_link;
            // $output .= get_the_post_thumbnail(get_the_ID(), 'medium'); // Featured Image
            $output .= '<h2>' . get_the_title() . '</h2>';
            $output .= '<p>Category: ' . $category_list . '</p>';
            $output .= '<p>Location: ' . $location . '</p>';
            $output .= '<p>Size: ' . $size . ' sq.ft</p>';
            $output .= '<p>Price: ₹' . $price . '</p>';
            $output .= '<p>Balcony: ' . $balcony . '</p>';
            $output .= '<p>Parking: ' . $parking . '</p>';
            $output .= '<p>Garage: ' . $garage . '</p>';
            $output .= '<p>Owner: ' . $excerpt . '</p>';    // Excerpt
            // $output .= '<p>Author: ' . $author_name . '</p>'; // Author Name
            
            

            // Gallery images
            // if ($gallery) {
            //     $output .= '<div class="gallery">';
            //     foreach ($gallery as $image) {
            //         $output .= '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';
            //     }
            //     $output .= '</div>';
            // }

            // View Details Button
            $output .= '<a href="' . get_permalink() . '" class="view-details-button">View Details</a>';
            $output .= '</div>';
        }
        $output .= '</div>';
        wp_reset_postdata();
    } else {
        $output .= '<p>No properties found.</p>';
    }

    return $output;
}
add_shortcode('property_list', 'display_property_listing');
