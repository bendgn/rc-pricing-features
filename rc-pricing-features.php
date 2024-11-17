<?php
/**
 * Plugin Name: RaveCapture Pricing Features Table
 * Plugin URI: https://github.com/bendgn/rc-pricing-features
 * Description: A simple pricing features table for RaveCapture Pricing Page.
 * Version: 1.0.0
 * Author: Benjie Dagunan
 * Author URI: https://benjiedagunan.me
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rc-pricing-features
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Enqueue styles and scripts for the pricing table
function rc_pricing_features_enqueue_assets() {
    global $post;

    // Ensure this runs only on posts/pages with the shortcode
    if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'rc_pricing_table' ) ) {
        // Load CSS
        $css_file = 'assets/css/classic-style.css';
        if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
            $css_file = 'assets/css/divi-style.css';
        } elseif ( get_post_meta( $post->ID, '_et_pb_use_builder', true ) ) {
            $css_file = 'assets/css/divi-style.css';
        }

        // Enqueue the determined CSS file
        wp_enqueue_style(
            'rc-pricing-features-style',
            plugin_dir_url( __FILE__ ) . $css_file,
            array(),
            '1.0.0'
        );

        // Enqueue the custom tab interaction script
        wp_enqueue_script(
            'rc-tabs-interaction',
            plugin_dir_url( __FILE__ ) . 'assets/js/tabs-interaction.js',
            array(), // No dependencies
            '1.0.0',
            true // Load in footer
        );

        // Debugging Script (Optional)
        add_action( 'wp_footer', function () {
            // echo '<script>console.log("Custom Tab Interaction script loaded successfully.");</script>';
        }, 100 );
    }
}
add_action( 'wp_enqueue_scripts', 'rc_pricing_features_enqueue_assets' );



// Shortcode to display the pricing table
function rc_pricing_features_shortcode() {
    $template_path = plugin_dir_path( __FILE__ ) . 'templates/pricing-table.php';
    if ( file_exists( $template_path ) ) {
        ob_start();
        include $template_path;
        return ob_get_clean();
    } else {
        return '<p>Pricing table template not found. Please check your plugin setup.</p>';
    }
}
add_shortcode( 'rc_pricing_table', 'rc_pricing_features_shortcode' );



// Add "View Details" link to plugins page
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'rc_pricing_features_action_links' );

function rc_pricing_features_action_links( $links ) {
    $details_link = '<a href="#" class="thickbox" onclick="tb_show(\'Plugin Details\', \'' . plugin_dir_url( __FILE__ ) . 'plugin-details.php?TB_iframe=true&width=600&height=550\'); return false;">View Details</a>';
    array_unshift( $links, $details_link );
    return $links;
}

// Enqueue Thickbox for the modal
add_action( 'admin_enqueue_scripts', 'rc_pricing_features_enqueue_thickbox' );

function rc_pricing_features_enqueue_thickbox( $hook ) {
    if ( $hook !== 'plugins.php' ) {
        return;
    }
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_style( 'thickbox' );
}
