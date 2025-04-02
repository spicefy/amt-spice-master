<?php
/**
 * AMT-Spice functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme version
define('AMT_SPICE_VERSION', '1.0.0');

// Theme setup
function amt_spice_setup() {
    load_theme_textdomain('amt-spice', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo');
    
    // Register menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'amt-spice'),
        'footer1' => __('Footer Column 1', 'amt-spice'),
        'footer2' => __('Footer Column 2', 'amt-spice'),
        'footer3' => __('Footer Column 3', 'amt-spice'),
    ));
}
add_action('after_setup_theme', 'amt_spice_setup');

// Enqueue scripts and styles
function amt_spice_scripts() {
    // Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
    
    // Theme styles
    wp_enqueue_style('amt-spice-style', get_stylesheet_uri());
    wp_enqueue_style('amt-spice-custom', get_template_directory_uri() . '/assets/css/styles.css');
    wp_enqueue_style('amt-spice-timeline', get_template_directory_uri() . '/assets/css/timeline.css');
    
    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true);
    
    // Chart.js
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, true);
    
    // Counter JS
    wp_enqueue_script('counter-js', get_template_directory_uri() . '/assets/js/counter.js', array(), '1.0', true);
    
    // Customizer preview JS
    if (is_customize_preview()) {
        wp_enqueue_script('amt-spice-customizer-preview', get_template_directory_uri() . '/assets/js/customizer-preview.js', array('jquery', 'customize-preview'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'amt_spice_scripts');

// Include required files
require_once get_template_directory() . '/inc/class-bootstrap-navwalker.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';

// Register navigation menus
function amt_spice_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'amt-spice'),
        'footer'  => __('Footer Menu', 'amt-spice')
    ]);
}
add_action('init', 'amt_spice_menus');
function amtspice_customize_register($wp_customize) {
    // Footer Section
    $wp_customize->add_section('footer_section', array(
        'title' => __('Footer Settings', 'amtspice'),
        'priority' => 120,
    ));

    // Footer Logo
    $wp_customize->add_setting('footer_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
        'label' => __('Footer Logo', 'amtspice'),
        'section' => 'footer_section',
    )));

    // Footer Text
    $wp_customize->add_setting('footer_text', array(
        'default' => '© 2025 Africa Media Trust',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_text', array(
        'label' => __('Footer Copyright Text', 'amtspice'),
        'section' => 'footer_section',
        'type' => 'text',
    ));
//about us block
add_action('init', function() {
    register_block_type(__DIR__ . '/blocks/about-banner');
  });
//sidebar menu registration// Include WP_Bootstrap_Navwalker
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

// Register Sidebar Menu
function register_my_menus() {
    register_nav_menus(array(
        'sidebar-menu' => __('Sidebar Menu'),
    ));
}
add_action('init', 'register_my_menus');


  
    // Social Media Links
    $socials = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'];
    foreach ($socials as $social) {
        $wp_customize->add_setting("{$social}_link", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("{$social}_link", array(
            'label' => ucfirst($social) . ' URL',
            'section' => 'footer_section',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'amtspice_customize_register');
