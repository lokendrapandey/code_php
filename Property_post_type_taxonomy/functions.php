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










/**
 * Register widget area.
 *
 * @return void
 */
// function hello_elementor_child_widgets_init() {
// 	register_sidebar( array(
// 		'name'          => __( 'Sidebar', 'hello-elementor-child' ),
// 		'id'            => 'sidebar-1',
// 	) );
// }
// add_action( 'widgets_init', 'hello_elementor_child_widgets_init' );
function register_properties_taxonomy_sidebar() {
    register_sidebar(array(
        'name'          => 'Properties Taxonomy Sidebar',
        'id'            => 'properties_taxonomy_sidebar',
    ));
}
add_action('widgets_init', 'register_properties_taxonomy_sidebar');








// post type for property




// Our custom post type function
function create_posttype() {
  
    register_post_type( 'properties',
        array(
            'labels' => array(
                'name' => __( 'Properties' ),
                'singular_name' => __( 'Property' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'properties'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields' ),
  
        )
    );

    register_taxonomy(
        'properties_category', // Taxonomy name
        'properties',          // Post type the taxonomy applies to
        array(
            'labels' => array(
                'name' => __( 'Property Categories' ),
                'singular_name' => __( 'Property Category' ),
                'search_items' => __( 'Search Property Categories' ),
                'all_items' => __( 'All Property Categories' ),
                'parent_item' => __( 'Parent Property Category' ),
                'parent_item_colon' => __( 'Parent Property Category:' ),
                'edit_item' => __( 'Edit Property Category' ),
                'update_item' => __( 'Update Property Category' ),
                'add_new_item' => __( 'Add New Property Category' ),
                'new_item_name' => __( 'New Property Category Name' ),
                'menu_name' => __( 'Property Categories' ),
            ),
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array( 'slug' => 'property-category' ),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );







    // Add meta box for image gallery
    function add_property_meta_boxes() {
        add_meta_box(
            'property_gallery_meta_box',
            __('Property Image Gallery'),
            'render_property_gallery_meta_box',
            'properties',
            'normal',
            'default'
        );
    }
    add_action('add_meta_boxes', 'add_property_meta_boxes');


    // Render the meta box
    function render_property_gallery_meta_box($post) {
        wp_nonce_field(basename(__FILE__), 'property_gallery_nonce');
        $gallery = get_post_meta($post->ID, '_property_gallery', true);
        ?>
        <div id="property-gallery-wrapper">
            <ul id="property-gallery-list" style="display: flex; flex-wrap: wrap; gap: 10px; list-style-type: none; padding: 0;">
                <?php
                if (!empty($gallery)) {
                    foreach ($gallery as $image_id) {
                        $image_url = wp_get_attachment_url($image_id);
                        echo '<li style="position: relative;">';
                        echo '<img src="' . esc_url($image_url) . '" style="max-width:100px; max-height:100px; object-fit: cover; border: 1px solid #ddd; padding: 2px;">';
                        echo '<input type="hidden" name="property_gallery[]" value="' . esc_attr($image_id) . '">';
                        echo '<button class="remove-image" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none; border-radius: 50%; cursor: pointer; padding: 2px 6px;">&times;</button>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
            <button id="add-gallery-images" class="button">Add Images</button>
        </div>


        <script>
            (function($) {
                $(document).on('click', '#add-gallery-images', function(e) {
                    e.preventDefault();
                    const frame = wp.media({
                        title: 'Select or Upload Images',
                        button: { text: 'Use Images' },
                        multiple: true
                    }).open().on('select', function() {
                        const attachments = frame.state().get('selection').toJSON();
                        attachments.forEach(function(attachment) {
                            const html = `
                                <li style="position: relative;">
                                    <img src="${attachment.url}" style="max-width:100px; max-height:100px; object-fit: cover; border: 1px solid #ddd; padding: 2px;">
                                    <input type="hidden" name="property_gallery[]" value="${attachment.id}">
                                    <button class="remove-image" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none; border-radius: 50%; cursor: pointer; padding: 2px 6px;">&times;</button>
                                </li>`;
                            $('#property-gallery-list').append(html);
                        });
                    });
                });

                $(document).on('click', '.remove-image', function(e) {
                    e.preventDefault();
                    $(this).parent().remove();
                });
            })(jQuery);
        </script>
      <?php
    }


    // Save the gallery meta data
    function save_property_gallery_meta($post_id) {
        if (!isset($_POST['property_gallery_nonce']) || !wp_verify_nonce($_POST['property_gallery_nonce'], basename(__FILE__))) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        if (isset($_POST['property_gallery'])) {
            update_post_meta($post_id, '_property_gallery', array_map('sanitize_text_field', $_POST['property_gallery']));
        } else {
            delete_post_meta($post_id, '_property_gallery');
        }
    }

    add_action('save_post', 'save_property_gallery_meta');

    // Display the gallery on the front end
    function display_property_gallery($content) {
        if (is_singular('property')) {
            $gallery = get_post_meta(get_the_ID(), '_property_gallery', true);
            if (!empty($gallery)) {
                $content .= '<div class="property-gallery">';
                foreach ($gallery as $image_id) {
                    $content .= '<img src="' . esc_url(wp_get_attachment_url($image_id)) . '" style="max-width:100%; margin-bottom:10px;">';
                }
                $content .= '</div>';
            }
        }
        return $content;
    }
    add_filter('the_content', 'display_property_gallery');


    


    function properties_data() {
        $prop = array(
            'post_type' => 'properties',
            'posts_per_page' => -1, 
        );
        $query = new WP_Query($prop);
    
        if ($query->have_posts()) {
            echo '<div class="properties-list">';
    
            while ($query->have_posts()) {
                $query->the_post();
    
                ?>
                <div class="property-item">
                    <div class="property-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <div>
                        <?php
                        $categories = wp_get_post_terms(get_the_ID(), 'properties_category');
                        if (!is_wp_error($categories) && !empty($categories)) {
                            $category_names = wp_list_pluck($categories, 'name');
                            echo '<p><span>Category:</span> ' . esc_html(implode(', ', $category_names)) . '</p>';
                        } else {
                            echo '<p><strong>Category:</strong> No category assigned</p>';
                        }
                        ?>
                    </div>
                    <p>Price: ₹<?php echo esc_html(get_field('property_price')); ?></p>
                    <p>Size: <?php echo esc_html(get_field('property_size')); ?></p>
                    <div class="view-details-btn"> <a href="<?php the_permalink(); ?>" class="property-link">View Details</a> </div>

                
                </div>
                <?php
            }
    
            echo '</div>';
        } else {
            echo '<p>No properties found.</p>';
        }
    
        wp_reset_postdata();
    }
    
    // Register shortcode to display properties
    add_shortcode('properties_data', 'properties_data');
    