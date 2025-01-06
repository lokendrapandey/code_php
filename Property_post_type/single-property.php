<?php get_header(); ?>

<!-- <div class="property-details">
    <h1><?php the_title(); ?></h1>

    <?php if (has_post_thumbnail()) : ?>
        <div class="featured-image">
            <?php the_post_thumbnail('large'); ?>
        </div>
    <?php endif; ?>

    <div class="content">
        <?php the_content(); ?>
    </div>

    <p><strong>Address:</strong> <?php echo get_field('property_address'); ?></p>
    <p><strong>Flat Size:</strong> <?php echo get_field('flat_size'); ?> sq. ft.</p>
    <p><strong>Price:</strong> ₹<?php echo number_format(get_field('flate_price')); ?></p>

    <p><strong>Parking:</strong> <?php echo get_field('parking') ? 'Yes' : 'No'; ?></p>
    <p><strong>Gym:</strong> <?php echo get_field('gym') ? 'Yes' : 'No'; ?></p>
    <p><strong>Balcony:</strong> <?php echo get_field('balcony') ? 'Yes' : 'No'; ?></p>

    
    <?php if (have_rows('gallery')) : ?>
        <div class="gallery">
            <h3>Gallery</h3>
            <?php while (have_rows('gallery')) : the_row(); ?>
                <?php $image = get_sub_field('image'); ?>
                <?php if ($image) : ?>
                    <img src="<?php echo esc_url($image); ?>" alt="Property Image">
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>


    <h3>Contact Us</h3>
    <?php echo do_shortcode('[contact-form-7 id="123" title="Contact Form"]'); ?>
</div>

<?php get_footer(); ?> -->












<!-- <?php get_header(); ?> -->

<div class="single-property">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
        <div class="single_property_page_box_1">

            <?php the_post_thumbnail('large'); ?>
            <div class="single_property_images_box"> 
        <?php
        // Fetch individual image fields
        $image1 = get_field('image_1');
        $image2 = get_field('image_2');
        $image3 = get_field('image_3');
        ?>
        <div class="property-images">
            <?php if ($image1): ?>
                <img src="<?php echo esc_url($image1['url']); ?>" alt="<?php echo esc_attr($image1['alt']); ?>">
            <?php endif; ?>

            <?php if ($image2): ?>
                <img src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>">
            <?php endif; ?>

            <?php if ($image3): ?>
                <img src="<?php echo esc_url($image3['url']); ?>" alt="<?php echo esc_attr($image3['alt']); ?>">
            <?php endif; ?>
        </div>
        </div>

        </div>
        <div class="single_property_data">
            <h1><?php the_title(); ?></h1>
            <p><strong>Category:</strong> <?php echo implode(', ', wp_get_post_categories(get_the_ID(), array('fields' => 'names'))); ?></p>
            <p><strong>Location:</strong> <?php the_field('location'); ?></p>
            <p><strong>Size:</strong> <?php the_field('flat_size'); ?> sq.ft</p>
            <p><strong>Price:</strong> ₹<?php the_field('flate_price'); ?></p>
            <p><strong>Balcony:</strong> <?php echo get_field('balcony') ? 'Yes' : 'No'; ?></p>
            <p><strong>Parking:</strong> <?php echo get_field('parking') ? 'Yes' : 'No'; ?></p>
            <p><strong>Garage:</strong> <?php echo get_field('garage') ? 'Yes' : 'No'; ?></p>
        </div>                    

        <!-- Property Images -->
        <!-- <h2>Property Images</h2> -->

         <!-- <div class="single_property_images_box"> 
        <?php
        $image1 = get_field('image_1');
        $image2 = get_field('image_2');
        $image3 = get_field('image_3');
        ?>
        <div class="property-images">
            <?php if ($image1): ?>
                <img src="<?php echo esc_url($image1['url']); ?>" alt="<?php echo esc_attr($image1['alt']); ?>">
            <?php endif; ?>

            <?php if ($image2): ?>
                <img src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>">
            <?php endif; ?>

            <?php if ($image3): ?>
                <img src="<?php echo esc_url($image3['url']); ?>" alt="<?php echo esc_attr($image3['alt']); ?>">
            <?php endif; ?>
        </div>
        </div> -->


         <!-- Contact Form 7 -->
         <!-- <?php echo do_shortcode('[contact-form-7 id="f1666a2" title="Contact form 1"]'); ?> -->
         
         
         <?php endwhile; endif; ?>
        </div>
        
        <?php get_footer(); ?>
        





