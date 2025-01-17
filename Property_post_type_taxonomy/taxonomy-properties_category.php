<?php get_header(); ?>
<div class="property-taxonomy-main-container">



<div class="property-taxonomy">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="property-taxonomy-child">
            <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('medium'); ?> </a>
              <a href="<?php the_permalink(); ?>"> <h2><?php the_title(); ?></h2>  </a>
                    

                <div class="slider_second_description_box">
                            <?php
                                $categories = wp_get_post_terms(get_the_ID(), 'properties_category');

                                if (!is_wp_error($categories) && !empty($categories)) {
                                    $category_names = wp_list_pluck($categories, 'name'); // Extracts only the names of the categories
                                    echo '<p><span>Category:</span> ' . esc_html(implode(', ', $category_names)) . '</p>';
                                } else {
                                    echo '<p><strong>Category:</strong> No category assigned</p>';
                                }
                            ?>


                    <p><span>Price: ₹</span><?php echo esc_html(get_field('property_price')); ?></p>
                    <p><span>Size:</span> <?php echo esc_html(get_field('property_size')); ?> sq ft</p>
                    <p><span>Parking:</span> <?php echo get_field('parking') ? 'Yes' : 'No'; ?></p>
                    <p><span>Balcony:</span> <?php echo get_field('balcony') ? 'Yes' : 'No'; ?></p>
                    <p><span>Garage:</span> <?php echo get_field('garage') ? 'Yes' : 'No'; ?></p>
                    <a class="property-link" href="<?php the_permalink(); ?>"> view detail</a>
                </div>
                
                
            </div>
            <?php endwhile; endif; ?>
 </div>


        <aside class="property-sidebar">
            <h3 class="widget-title">Property Categories</h3>
            <ul class="property-category-list">
                <?php
                $terms = get_terms(array(
                    'taxonomy' => 'properties_category',
                    'hide_empty' => false, // if we set true, then empty category will display
                    'parent' => 0, // Only get top-level (parent) categories
                    'order'      => 'ASC',
                ));

                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $term_link = get_term_link($term);
                        $active_class = '';

                        // Check if we're on a category page for the current term
                        if (is_tax('properties_category', $term->term_id)) {
                            $active_class = ' class="active"'; // Add active class if this category is the current one
                        }

                        if (!is_wp_error($term_link)) {
                            echo '<li' . $active_class . '><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
                        }
                    }
                } else {
                    echo '<li>No categories available.</li>';
                }
                ?>
            </ul>        
        </aside>
                                
                <!-- <?php
                // $taxonomies = get_terms(array(
                //     'taxonomy' => 'properties_category',
                //     'hide_empty' => false
                // ));

                // if (!empty($taxonomies)) :
                //     $output = '<select id="category-select">';
                //     $output .= '<option value="">Select a category</option>'; 
                //     foreach ($taxonomies as $category) {
                //         if ($category->parent == 0) {
                //             $output .= '<optgroup label="' . esc_attr($category->name) . '">';
                //             foreach ($taxonomies as $subcategory) {
                //                 if ($subcategory->parent == $category->term_id) {
                //                     $output .= '<option value="' . esc_url(get_term_link($subcategory)) . '">'
                //                         . esc_html($subcategory->name) . '</option>';
                //                 }
                //             }
                //             $output .= '</optgroup>';
                //         }
                //     }
                //     $output .= '</select>';
                //     echo $output;
                // endif;
                ?> -->
                <!-- <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const selectElement = document.getElementById('category-select');
                        selectElement.addEventListener('change', function() {
                            const selectedValue = this.value;
                            if (selectedValue) {
                                window.location.href = selectedValue; 
                            }
                        });
                    });
                </script> -->

                        




    
    </div>
    


            
<?php get_footer(); ?>
