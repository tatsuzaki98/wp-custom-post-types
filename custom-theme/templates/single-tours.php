<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    // Get this tour's slug
    $tour_slug = get_post_field('post_name', get_the_ID());
?>

    <h1><?php the_title(); ?></h1>
    <div><?php the_content(); ?></div>
    
    <hr>
    <h2>Itineraries for this Tour</h2>
    <?php
    // Query itineraries that have a tour_tag matching this tour's slug
    $args = array(
        'post_type' => 'itineraries',
        'tax_query' => array(
            array(
                'taxonomy' => 'tour_tag',
                'field'    => 'slug',
                'terms'    => $tour_slug,
            ),
        ),
        'posts_per_page' => -1,
    );
    $itineraries_query = new WP_Query($args);
    ?>

    <?php if ( $itineraries_query->have_posts() ) : ?>
        <ul>
        <?php while ( $itineraries_query->have_posts() ) : $itineraries_query->the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </li>
        <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata(); ?>
    <?php else: ?>
        <p>No itineraries found for this tour.</p>
    <?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
