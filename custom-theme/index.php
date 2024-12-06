<?php
/**
* Template Name: Home
*
* This template will be assigned to a "Home" page in WordPress.
* Then, you can edit the content of that page (including custom fields) from the WordPress admin.
*/
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <title>AIBOS WP Template</title>
    <?php wp_head(); ?> <!-- This is important to load any necessary styles or scripts -->
</head>
<body>
<?php get_header(); ?> <!-- Include the header -->

<?php 
// Start the loop to display the content from the assigned "Home" page
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post(); 
        // Display the main content from the page editor
        the_content(); 

        // If using ACF (Advanced Custom Fields), you can display a custom field like this:
        // the_field('your_custom_field_name');

        // If using standard custom fields:
        // echo get_post_meta(get_the_ID(), 'your_custom_field_name', true);
    endwhile;
endif;
?>

<?php get_footer(); ?> <!-- Include the footer -->
<?php wp_footer(); ?> <!-- This is important to load scripts added by WordPress or plugins -->
</body>
</html>
