<?php
function my_custom_post_types() {
    // Register 'tours' custom post type
    $labels_tours = array(
        'name'               => 'Tours',
        'singular_name'      => 'Tour',
        'add_new'            => 'Add New Tour',
        'add_new_item'       => 'Add New Tour',
        'edit_item'          => 'Edit Tour',
        'new_item'           => 'New Tour',
        'all_items'          => 'All Tours',
        'view_item'          => 'View Tour',
        'search_items'       => 'Search Tours',
        'not_found'          => 'No tours found',
        'not_found_in_trash' => 'No tours found in Trash',
        'parent_item_colon'  => '',
        'menu_name'          => 'Tours'
    );
    
    $args_tours = array(
        'labels'             => $labels_tours,
        'public'             => true,
        // Use a 'tours' slug and ensure pretty permalinks are active
        'rewrite'            => array( 'slug' => 'tours', 'with_front' => false ),
        'has_archive' => true,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-palmtree',
        'show_in_rest'       => true,
    );
    register_post_type( 'tours', $args_tours );

    // Register 'itineraries' custom post type
    $labels_itineraries = array(
        'name'               => 'Itineraries',
        'singular_name'      => 'Itinerary',
        'add_new'            => 'Add New Itinerary',
        'add_new_item'       => 'Add New Itinerary',
        'edit_item'          => 'Edit Itinerary',
        'new_item'           => 'New Itinerary',
        'all_items'          => 'All Itineraries',
        'view_item'          => 'View Itinerary',
        'search_items'       => 'Search Itineraries',
        'not_found'          => 'No itineraries found',
        'not_found_in_trash' => 'No itineraries found in Trash',
        'parent_item_colon'  => '',
        'menu_name'          => 'Itineraries'
    );

    $args_itineraries = array(
        'labels'             => $labels_itineraries,
        'public'             => true,
        // No own archive, placed under tours/%tour_tag%/itineraries
        'has_archive'        => false,
        'rewrite'            => array(
            'slug' => 'tours/%tour_tag%/itineraries',
            'with_front' => false
        ),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-site-alt3',
        'show_in_rest'       => true,
    );
    register_post_type( 'itineraries', $args_itineraries );

    // Register 'tour_tag' taxonomy for itineraries
    $args_tax = array(
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => true,
        'label'             => 'Tour Tags',
        'singular_label'    => 'Tour Tag',
    );
    register_taxonomy( 'tour_tag', 'itineraries', $args_tax );
}
add_action( 'init', 'my_custom_post_types' );


// Filter permalink for itineraries to replace %tour_tag% with the actual taxonomy term slug
function my_itineraries_permalink( $permalink, $post, $leavename ) {
    if ( $post->post_type == 'itineraries' ) {
        $terms = get_the_terms( $post->ID, 'tour_tag' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $slug = $terms[0]->slug;
            return str_replace( '%tour_tag%', $slug, $permalink );
        } else {
            return str_replace( '%tour_tag%', 'no-tour', $permalink );
        }
    }
    return $permalink;
}
add_filter( 'post_type_link', 'my_itineraries_permalink', 10, 3 );

function my_template_include( $template ) {
    // If this is the tours archive page, look for 'archive-tours.php' in the 'templates' folder
    if ( is_post_type_archive( 'tours' ) ) {
        $new_template = locate_template( array( 'templates/archive-tours.php' ) );
        if ( !empty( $new_template ) ) {
            return $new_template;
        }
    }

    // If this is a single tours page, look for 'single-tours.php' in the 'templates' folder
    if ( is_singular( 'tours' ) ) {
        $new_template = locate_template( array( 'templates/single-tours.php' ) );
        if ( !empty( $new_template ) ) {
            return $new_template;
        }
    }

    // If this is a single itineraries page, look for 'single-itineraries.php' in the 'templates' folder
    if ( is_singular( 'itineraries' ) ) {
        $new_template = locate_template( array( 'templates/single-itineraries.php' ) );
        if ( !empty( $new_template ) ) {
            return $new_template;
        }
    }

    // Otherwise, return the original template.
    return $template;
}
add_filter( 'template_include', 'my_template_include' );
