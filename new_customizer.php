<?php
/**
 * AMT-Spice Customizer functionality
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AMT_Spice_Customizer {

    public function __construct() {
        add_action('customize_register', array($this, 'amt_spice_customize_register'));
    }

    public function amt_spice_customize_register($wp_customize) {
        // Theme Options Panel
        $wp_customize->add_panel('amt_theme_options', array(
            'title' => __('AMT-Spice Theme Options', 'amt-spice'),
            'priority' => 1,
        ));

        $this->add_header_section($wp_customize);
        $this->add_hero_section($wp_customize);
        $this->add_intro_section($wp_customize);
        $this->add_services_section($wp_customize);
        $this->add_testimonials_section($wp_customize);
        $this->add_impact_section($wp_customize);
        $this->add_social_counters($wp_customize);
        $this->add_footer_sections($wp_customize);
        $this->add_legal_links($wp_customize);
        $this->add_page_settings($wp_customize);
    }

    private function add_header_section($wp_customize) {
        $wp_customize->add_section('amt_header', array(
            'title' => __('Header Settings', 'amt-spice'),
            'panel' => 'amt_theme_options',
            'priority' => 10,
        ));

        // Logo
        $wp_customize->add_setting('amt_logo', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'amt_logo', array(
            'label' => __('Upload Logo', 'amt-spice'),
            'section' => 'amt_header',
        )));

        // Donate Button
        $wp_customize->add_setting('amt_donate_text', array(
            'default' => __('Donate', 'amt-spice'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_setting('amt_donate_link', array(
            'default' => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('amt_donate_text_control', array(
            'label' => __('Donate Button Text', 'amt-spice'),
            'section' => 'amt_header',
            'settings' => 'amt_donate_text',
            'type' => 'text',
        ));
        
        $wp_customize->add_control('amt_donate_link_control', array(
            'label' => __('Donate Button Link', 'amt-spice'),
            'section' => 'amt_header',
            'settings' => 'amt_donate_link',
            'type' => 'url',
        ));
    }

    private function add_hero_section($wp_customize) {
        $wp_customize->add_section('amt_hero', array(
            'title' => __('Hero Section', 'amt-spice'),
            'panel' => 'amt_theme_options',
            'priority' => 20,
        ));

        $settings = array(
            'title' => array(
                'default' => __('Book us today', 'amt-spice'),
                'type' => 'text',
            ),
            'text' => array(
                'default' => __('Get blush-free facts and stories about love, sex, and relationships.', 'amt-spice'),
                'type' => 'textarea',
            ),
            'button_text' => array(
                'default' => __('Get Started', 'amt-spice'),
                'type' => 'text',
            ),
            'button_link' => array(
                'default' => '#',
                'type' => 'url',
            ),
            'background' => array(
                'default' => '',
                'type' => 'image',
            )
        );

        foreach ($settings as $key => $config) {
            $wp_customize->add_setting("amt_hero_{$key}", array(
                'default' => $config['default'],
                'sanitize_callback' => ($config['type'] === 'url' || $config['type'] === 'image') ? 'esc_url_raw' : 
                                      ($config['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
            ));

            if ($config['type'] === 'image') {
                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "amt_hero_{$key}", array(
                    'label' => __("Hero " . str_replace('_', ' ', ucfirst($key)), 'amt-spice'),
                    'section' => 'amt_hero',
                )));
            } else {
                $wp_customize->add_control("amt_hero_{$key}_control", array(
                    'label' => __("Hero " . str_replace('_', ' ', ucfirst($key)), 'amt-spice'),
                    'section' => 'amt_hero',
                    'settings' => "amt_hero_{$key}",
                    'type' => $config['type'],
                ));
            }
        }
    }

    private function add_footer_sections($wp_customize) {
        $wp_customize->add_section('amt_footer', array(
            'title' => __('Footer Settings', 'amt-spice'),
            'panel' => 'amt_theme_options',
            'priority' => 100,
        ));

        // Footer Logo
        $wp_customize->add_setting('amt_footer_logo', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'amt_footer_logo', array(
            'label' => __('Footer Logo', 'amt-spice'),
            'section' => 'amt_footer',
        )));

        // Footer Description
        $wp_customize->add_setting('amt_footer_description', array(
            'default' => __('Love Matters Africa provides easy-to-access information...', 'amt-spice'),
            'sanitize_callback' => 'wp_kses_post',
        ));
        
        $wp_customize->add_control('amt_footer_description_control', array(
            'label' => __('Footer Description', 'amt-spice'),
            'section' => 'amt_footer',
            'settings' => 'amt_footer_description',
            'type' => 'textarea',
        ));

        // Column Titles
        foreach (range(1, 3) as $col) {
            $wp_customize->add_setting("amt_footer_col{$col}_title", array(
                'default' => __("Column {$col} Title", 'amt-spice'),
                'sanitize_callback' => 'sanitize_text_field',
            ));
            
            $wp_customize->add_control("amt_footer_col{$col}_title_control", array(
                'label' => __("Footer Column {$col} Title", 'amt-spice'),
                'section' => 'amt_footer',
                'settings' => "amt_footer_col{$col}_title",
                'type' => 'text',
            ));
        }

        // Social Media
        $socials = array(
            'facebook' => __('Facebook', 'amt-spice'),
            'twitter' => __('Twitter', 'amt-spice'),
            'instagram' => __('Instagram', 'amt-spice'),
            'youtube' => __('YouTube', 'amt-spice'),
            'linkedin' => __('LinkedIn', 'amt-spice')
        );

        foreach ($socials as $platform => $label) {
            $wp_customize->add_setting("amt_social_{$platform}", array(
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
            
            $wp_customize->add_control("amt_social_{$platform}_control", array(
                'label' => sprintf(__('%s URL', 'amt-spice'), $label),
                'section' => 'amt_footer',
                'settings' => "amt_social_{$platform}",
                'type' => 'url',
            ));
        }
    }

    private function add_legal_links($wp_customize) {
        $wp_customize->add_section('amt_legal_links', array(
            'title' => __('Legal Links', 'amt-spice'),
            'panel' => 'amt_theme_options',
            'priority' => 110,
        ));

        $links = array(
            'privacy' => __('Privacy Policy', 'amt-spice'),
            'terms' => __('Terms of Use', 'amt-spice'),
            'contact' => __('Contact Us', 'amt-spice')
        );

        foreach ($links as $key => $title) {
            $wp_customize->add_setting("amt_{$key}_text", array(
                'default' => $title,
                'sanitize_callback' => 'sanitize_text_field',
            ));
            
            $wp_customize->add_setting("amt_{$key}_link", array(
                'default' => '#',
                'sanitize_callback' => 'esc_url_raw',
            ));
            
            $wp_customize->add_control("amt_{$key}_text_control", array(
                'label' => sprintf(__('%s Text', 'amt-spice'), $title),
                'section' => 'amt_legal_links',
                'settings' => "amt_{$key}_text",
                'type' => 'text',
            ));
            
            $wp_customize->add_control("amt_{$key}_link_control", array(
                'label' => sprintf(__('%s Link', 'amt-spice'), $title),
                'section' => 'amt_legal_links',
                'settings' => "amt_{$key}_link",
                'type' => 'url',
            ));
        }
    }

    private function add_page_settings($wp_customize) {
        $wp_customize->add_section('amt_page_settings', array(
            'title' => __('Page/Sidebar Settings', 'amt-spice'),
            'panel' => 'amt_theme_options',
            'priority' => 120,
        ));

        $wp_customize->add_setting('amt_page_header_image', array(
            'default' => get_template_directory_uri() . '/assets/images/default-header.jpg',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'amt_page_header_image',
            array(
                'label' => __('Default Header Image', 'amt-spice'),
                'section' => 'amt_page_settings',
            )
        ));

        $wp_customize->add_setting('amt_default_sidebar_title', array(
            'default' => __('About Us', 'amt-spice'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('amt_default_sidebar_title', array(
            'label' => __('Default Sidebar Title', 'amt-spice'),
            'section' => 'amt_page_settings',
            'type' => 'text',
        ));
    }

    // Add other sections (intro, services, testimonials, etc.) following the same pattern...
private function add_intro_section($wp_customize) {
    $wp_customize->add_section('amt_intro', array(
        'title' => __('Intro Section', 'amt-spice'),
        'panel' => 'amt_theme_options',
        'priority' => 30,
    ));

    $settings = array(
        'title' => array(
            'default' => __('Blush-free facts and stories...', 'amt-spice'),
            'type' => 'text',
        ),
        'text' => array(
            'default' => __('Learn more about Blush-free facts...', 'amt-spice'),
            'type' => 'textarea',
        ),
        'button_text' => array(
            'default' => __('Learn More', 'amt-spice'),
            'type' => 'text',
        ),
        'button_link' => array(
            'default' => '#',
            'type' => 'url',
        ),
        'image' => array(
            'default' => '',
            'type' => 'image',
        )
    );

    foreach ($settings as $key => $config) {
        $wp_customize->add_setting("amt_intro_{$key}", array(
            'default' => $config['default'],
            'sanitize_callback' => ($config['type'] === 'url' || $config['type'] === 'image') ? 'esc_url_raw' : 
                                  ($config['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
        ));

        if ($config['type'] === 'image') {
            $wp_customize->add_control(new WP_Customize_Image_Control(
                $wp_customize,
                "amt_intro_{$key}",
                array(
                    'label' => __("Intro " . str_replace('_', ' ', ucfirst($key)), 'amt-spice'),
                    'section' => 'amt_intro',
                )
            ));
        } else {
            $wp_customize->add_control("amt_intro_{$key}_control", array(
                'label' => __("Intro " . str_replace('_', ' ', ucfirst($key)), 'amt-spice'),
                'section' => 'amt_intro',
                'settings' => "amt_intro_{$key}",
                'type' => $config['type'],
            ));
        }
    }
}

private function add_services_section($wp_customize) {
    $wp_customize->add_section('amt_services', array(
        'title' => __('Services Section', 'amt-spice'),
        'panel' => 'amt_theme_options',
        'priority' => 40,
    ));

    // Main Title
    $wp_customize->add_setting('amt_services_title', array(
        'default' => __('Our Services', 'amt-spice'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('amt_services_title_control', array(
        'label' => __('Services Section Title', 'amt-spice'),
        'section' => 'amt_services',
        'settings' => 'amt_services_title',
        'type' => 'text',
    ));

    // Service Items
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("amt_service_title_{$i}", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_setting("amt_service_text_{$i}", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        
        $wp_customize->add_setting("amt_service_link_{$i}", array(
            'default' => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));

        // Controls
        $wp_customize->add_control("amt_service_title_{$i}_control", array(
            'label' => sprintf(__('Service %d Title', 'amt-spice'), $i),
            'section' => 'amt_services',
            'settings' => "amt_service_title_{$i}",
            'type' => 'text',
        ));
        
        $wp_customize->add_control("amt_service_text_{$i}_control", array(
            'label' => sprintf(__('Service %d Text', 'amt-spice'), $i),
            'section' => 'amt_services',
            'settings' => "amt_service_text_{$i}",
            'type' => 'textarea',
        ));
        
        $wp_customize->add_control("amt_service_link_{$i}_control", array(
            'label' => sprintf(__('Service %d Link', 'amt-spice'), $i),
            'section' => 'amt_services',
            'settings' => "amt_service_link_{$i}",
            'type' => 'url',
        ));
    }
}

private function add_testimonials_section($wp_customize) {
    $wp_customize->add_section('amt_testimonials', array(
        'title' => __('Testimonials Section', 'amt-spice'),
        'panel' => 'amt_theme_options',
        'priority' => 50,
    ));

    $settings = array(
        'title' => array(
            'default' => __('Testimonials Get Blush-free facts...', 'amt-spice'),
            'type' => 'text',
        ),
        'text' => array(
            'default' => __('Visit our website...', 'amt-spice'),
            'type' => 'textarea',
        ),
        'button_text' => array(
            'default' => __('Learn More', 'amt-spice'),
            'type' => 'text',
        ),
        'button_link' => array(
            'default' => '#',
            'type' => 'url',
        )
    );

    foreach ($settings as $key => $config) {
        $wp_customize->add_setting("amt_testimonials_{$key}", array(
            'default' => $config['default'],
            'sanitize_callback' => ($config['type'] === 'url') ? 'esc_url_raw' : 
                                  ($config['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
        ));

        $wp_customize->add_control("amt_testimonials_{$key}_control", array(
            'label' => __("Testimonials " . str_replace('_', ' ', ucfirst($key)), 'amt-spice'),
            'section' => 'amt_testimonials',
            'settings' => "amt_testimonials_{$key}",
            'type' => $config['type'],
        ));
    }
}

private function add_impact_section($wp_customize) {
    $wp_customize->add_section('amt_impact', array(
        'title' => __('Impact Section', 'amt-spice'),
        'panel' => 'amt_theme_options',
        'priority' => 60,
    ));

    $settings = array(
        'title' => array(
            'default' => __('Our Impact', 'amt-spice'),
            'type' => 'text',
        ),
        'text' => array(
            'default' => __('Our trained health educators...', 'amt-spice'),
            'type' => 'textarea',
        ),
        'button_text' => array(
            'default' => __('Chat Now', 'amt-spice'),
            'type' => 'text',
        ),
        'button_link' => array(
            'default' => '#',
            'type' => 'url',
        ),
        'image' => array(
            'default' => '',
            'type' => 'image',
        )
    );

    foreach ($settings as $key => $config) {
        $wp_customize->add_setting("amt_impact_{$key}", array(
            'default' => $config['default'],
            'sanitize_callback' => ($config['type'] === 'url' || $config['type'] === 'image') ? 'esc_url_raw' : 
                                  ($config['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
        ));

        if ($config['type'] === 'image') {
            $wp_customize->add_control(new WP_Customize_Image_Control(
                $wp_customize,
                "amt_impact_{$key}",
                array(
                    'label' => __("Impact " . str_replace('_', ' ', ucfirst($key)), 'amt-spice'),
                    'section' => 'amt_impact',
                )
            ));
        } else {
            $wp_customize->add_control("amt_impact_{$key}_control", array(
                'label' => __("Impact " . str_replace('_', ' ', ucfirst($key)), 'amt-spice'),
                'section' => 'amt_impact',
                'settings' => "amt_impact_{$key}",
                'type' => $config['type'],
            ));
        }
    }
}

private function add_social_counters($wp_customize) {
    $wp_customize->add_section('amt_social_counters', array(
        'title' => __('Social Media Counters', 'amt-spice'),
        'panel' => 'amt_theme_options',
        'priority' => 70,
    ));

    $platforms = array(
        'facebook' => array(
            'default' => 15000,
            'label' => __('Facebook Followers', 'amt-spice')
        ),
        'instagram' => array(
            'default' => 9500,
            'label' => __('Instagram Followers', 'amt-spice')
        ),
        'tiktok' => array(
            'default' => 12000,
            'label' => __('TikTok Followers', 'amt-spice')
        ),
        'website' => array(
            'default' => 500000,
            'label' => __('Monthly Visitors', 'amt-spice')
        )
    );

    foreach ($platforms as $platform => $data) {
        // Counter Setting
        $wp_customize->add_setting("amt_counter_{$platform}", array(
            'default' => $data['default'],
            'sanitize_callback' => 'absint',
        ));
        
        $wp_customize->add_control("amt_counter_{$platform}_control", array(
            'label' => $data['label'],
            'section' => 'amt_social_counters',
            'settings' => "amt_counter_{$platform}",
            'type' => 'number',
        ));

        // Label Setting
        $wp_customize->add_setting("amt_counter_{$platform}_label", array(
            'default' => $data['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("amt_counter_{$platform}_label_control", array(
            'label' => sprintf(__('%s Label', 'amt-spice'), ucfirst($platform)),
            'section' => 'amt_social_counters',
            'settings' => "amt_counter_{$platform}_label",
            'type' => 'text',
        ));
    }
}

}

new AMT_Spice_Customizer();