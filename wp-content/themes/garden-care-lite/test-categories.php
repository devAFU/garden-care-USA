<?php
/*
Plugin Name: Category Posts with Tags
Plugin URI: http://yourwebsite.com/
Description: A plugin to display posts from specific categories along with their tags using a shortcode.
Version: 1.0
Author: Your Name
Author URI: http://yourwebsite.com/
License: GPL2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register the shortcode
function category_posts_with_tags_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'category' => '',
        'posts' => 5,
    ), $atts, 'category_posts_with_tags' );

    $category = sanitize_text_field( $atts['category'] );
    $posts = intval( $atts['posts'] );

    // Query for posts in the specified category
    $query = new WP_Query( array(
        'category_name'  => $category,
        'posts_per_page' => $posts,
        'post_status'    => 'publish',
    ) );

    if ( $query->have_posts() ) {
        ob_start();
        ?>
        <div class="category-posts-with-tags">
            <ul>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <p><?php echo get_the_date(); ?></p>
                        <p><?php the_tags( 'Tags: ', ', ', '<br>' ); ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    } else {
        return '<p>No posts found in this category.</p>';
    }
}
add_shortcode( 'category_posts_with_tags', 'category_posts_with_tags_shortcode' );

// Enqueue the plugin styles
function category_posts_with_tags_styles() {
    wp_enqueue_style( 'category-posts-with-tags-style', plugin_dir_url( __FILE__ ) . 'css/category-posts-with-tags.css' );
}
add_action( 'wp_enqueue_scripts', 'category_posts_with_tags_styles' );

?>
