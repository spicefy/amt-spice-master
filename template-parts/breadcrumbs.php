<?php
// Dynamic Breadcrumb Function
function the_dynamic_breadcrumbs() {
    echo '<div class="breadcrumbs-wrapper">';
    echo '<nav aria-label="breadcrumbs">';
    echo '<ul class="breadcrumbs-list d-flex">';

    // Home link is always the first item
    echo '<li><a href="' . esc_url( home_url() ) . '">Home</a></li>';

    // Check if we're not on the front page
    if ( !is_front_page() ) {
        // For single posts
        if ( is_single() ) {
            $categories = get_the_category();
            if ( $categories ) {
                // Use the first category
                $category = $categories[0];
                echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
            }
            echo '<li class="fw-bold">' . esc_html( get_the_title() ) . '</li>';
        }
        // For pages
        elseif ( is_page() ) {
            global $post;
            if ( $post->post_parent ) {
                $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
                foreach ( $ancestors as $ancestor ) {
                    echo '<li><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
                }
            }
            echo '<li class="fw-bold">' . esc_html( get_the_title() ) . '</li>';
        }
        // For category archive pages
        elseif ( is_category() ) {
            $category = get_queried_object();
            echo '<li class="fw-bold">' . esc_html( $category->name ) . '</li>';
        }
        // For tag archive pages
        elseif ( is_tag() ) {
            $tag = get_queried_object();
            echo '<li class="fw-bold">' . esc_html( $tag->name ) . '</li>';
        }
        // For archive pages (date, author, etc.)
        elseif ( is_archive() ) {
            echo '<li class="fw-bold">Archive</li>';
        }
        // For search results
        elseif ( is_search() ) {
            echo '<li class="fw-bold">Search Results</li>';
        }
    } else {
        // When on the homepage, you can either show nothing or just a simple Home label
        echo '<li class="fw-bold">Home</li>';
    }

    echo '</ul>';
    echo '</nav>';
    echo '</div>';
}
?>
