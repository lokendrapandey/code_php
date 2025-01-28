


//this is second file of updated code with sidebar and updated via category in property list 

<?php get_header(); ?>

<div class="property-taxonomy-main-container">
    <aside class="property-sidebar">
        
        <h3>Property Categories</h3>
        <ul class="property-category-list">
            <?php
            // Fetch all top-level categories (parent categories)
            $parent_terms = get_terms(array(
                'taxonomy' => 'properties_category',
                'hide_empty' => false,
                'parent' => 0, // Top-level categories only
            ));

            if (!empty($parent_terms)) {
                foreach ($parent_terms as $parent_term) {
                    $parent_link = get_term_link($parent_term);
                    
                    
                    echo '<li>';
                        echo '<a href="' . esc_url($parent_link) . '">' . esc_html($parent_term->name) . '</a>';

                        
                        // Fetch child categories of the current parent
                        $child_terms = get_terms(array(
                            'taxonomy' => 'properties_category',
                            'hide_empty' => false,
                            'parent' => $parent_term->term_id,   
                        ));

                        if (!empty($child_terms)) {
                            echo '<ul>';
                            foreach ($child_terms as $child_term) {
                                $child_link = get_term_link($child_term);
                             
                                echo '<li>';
                                echo '<a href="' . esc_url($child_link) . '">' . esc_html($child_term->name) .'</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        }

                    echo '</li>';
                }
            } else {
                echo '<li>No categories available.</li>';
            }
            ?>
        </ul>
    </aside>




    


    <!-- property-taxonomy-code start    -->
    <div class="property-taxonomy">
        <?php
        $current_term = get_queried_object();

        // Check if the current term has child categories
        $child_terms = get_terms(array(
            'taxonomy' => 'properties_category',
            'parent' => $current_term->term_id,
            'hide_empty' => false,
        ));

        if (!empty($child_terms)) {
            echo '<ul class="subcategories-list">';
            foreach ($child_terms as $child) {
                // echo '<li><a href="' . esc_url(get_term_link($child)) . '">' . esc_html($child->name) . '</a></li>';
            }
            


            // this code for showing post with category
            if (have_posts()) {
                echo '<div class="property-items">';
                while (have_posts()) {
                     the_post(); 
                ?>
                    <div class="property-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                            <h2><?php the_title(); ?></h2>
                        </a>
                        <a href="<?php the_permalink(); ?>">
                            <h6 class="view-detail-btn">View Details</h6>
                        </a>
                    </div>
                <?php 
                }
                echo '</div>';  
            }
            else {
                echo '<p>No properties found in this category.</p>';
            }
            // here code ending of showing post with category

            
            


        echo '</ul>';

        } else {
                // Display posts in the current category if there are no child categories
                if (have_posts()) {
                        echo '<div class="property-items">';
                        while (have_posts()) {
                             the_post(); 
                        ?>
                            <div class="property-item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                    <h2><?php the_title(); ?></h2>
                                </a>
                                <a href="<?php the_permalink(); ?>">
                                    <h6 class="view-detail-btn">View Details</h6>
                                </a>
                            </div>
                        <?php 
                        }
                    echo '</div>';  
                }
                else {
                    echo '<p>No properties found in this category.</p>';
                }
                
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>











































// this is first file old code 












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
