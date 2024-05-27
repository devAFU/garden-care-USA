<?php
/*
Plugin Name: Custom Greeting Shortcode
Plugin URI: http://yourwebsite.com/
Description: A simple plugin to display a personalized greeting message using a shortcode.
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
function custom_greeting_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name' => 'Guest',
    ), $atts, 'greeting' );

    $name = sanitize_text_field( $atts['name'] );

    ob_start();
    ?>
    <div class="custom-greeting">
        <p>Hello, <?php echo esc_html( $name ); ?>! Welcome to our website.</p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'greeting', 'custom_greeting_shortcode' );

// Enqueue the plugin styles
function custom_greeting_styles() {
    wp_enqueue_style( 'custom-greeting-style', plugin_dir_url( __FILE__ ) . 'css/custom-greeting.css' );
}
add_action( 'wp_enqueue_scripts', 'custom_greeting_styles' );

?>
