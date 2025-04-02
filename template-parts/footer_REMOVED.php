<?php
//removed section of footer in functions.php
// Footer Logo
    $wp_customize->add_setting('footer_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
        'label' => __('Footer Logo', 'amt-spice'),
        'section' => 'footer_section',
    )));

    // Footer Text
    $wp_customize->add_setting('footer_text', array(
        'default' => '© 2025 Africa Media Trust',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_text', array(
        'label' => __('Footer Copyright Text', 'amt-spice'),
        'section' => 'footer_section',
        'type' => 'text',
    ));

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

    // Register about us block
    add_action('init', function() {
        register_block_type(__DIR__ . '/blocks/about-banner');
    });
}
?>