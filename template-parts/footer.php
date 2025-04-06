<footer class="bg-dark text-white p-5">
    <div class="container text-center">
        <div class="row text-start">
            <!-- Logo and Description Column -->
            <div class="col-md-5">
                <?php
                $footer_logo = get_theme_mod('amt_footer_logo');
                if ($footer_logo) {
                    echo '<img src="' . esc_url($footer_logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="mb-3 footer-logo" style="max-width: 110px;">';
                }
                ?>
                <p class="footer-description">
                    <?php echo wp_kses_post(get_theme_mod('amt_footer_description', 'Love Matters Africa provides easy-to-access information and news on sexuality and sexual health.')); ?>
                </p>
            </div>

            <!-- Footer Menu Columns -->
            <?php 
            $footer_columns = [
                'footer_col1' => [
                    'title' => 'Get Involved', 
                    'col_class' => 'col-md-2',
                    'theme_location' => 'footer-1'
                ],
                'footer_col2' => [
                    'title' => 'Resources', 
                    'col_class' => 'col-md-2',
                    'theme_location' => 'footer-2'
                ],
                'footer_col3' => [
                    'title' => 'About This Site', 
                    'col_class' => 'col-md-3',
                    'theme_location' => 'footer-3'
                ]
            ];
            
            foreach ($footer_columns as $key => $settings) : 
                if (has_nav_menu($settings['theme_location'])) : ?>
                    <div class="<?php echo esc_attr($settings['col_class']); ?>">
                        <h5 class="footer-column-title">
                            <?php echo esc_html(get_theme_mod('amt_' . $key . '_title', $settings['title'])); ?>
                        </h5>
                        <?php
                        wp_nav_menu([
                            'theme_location' => $settings['theme_location'],
                            'menu_class' => 'footer-menu list-unstyled',
                            'container' => false,
                            'depth' => 1,
                            'walker' => new Footer_Menu_Walker(),
                            'fallback_cb' => false
                        ]);
                        ?>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>

        <hr class="footer-divider bg-light">

        <!-- Social Media Links -->
        <div class="social-icons text-center mb-3">
            <?php
            $social_platforms = [
                'facebook' => ['icon' => 'facebook-f', 'class' => 'fb', 'label' => __('Facebook', 'amt-spice')],
                'twitter' => ['icon' => 'twitter', 'class' => 'tw', 'label' => __('Twitter', 'amt-spice')],
                'instagram' => ['icon' => 'instagram', 'class' => 'ig', 'label' => __('Instagram', 'amt-spice')],
                'youtube' => ['icon' => 'youtube', 'class' => 'yt', 'label' => __('YouTube', 'amt-spice')],
                'linkedin' => ['icon' => 'linkedin-in', 'class' => 'li', 'label' => __('LinkedIn', 'amt-spice')]
            ];
            
            foreach ($social_platforms as $platform => $data) {
                $url = get_theme_mod('amt_social_' . $platform);
                if ($url) {
                    echo '<a href="' . esc_url($url) . '" class="social-icon ' . esc_attr($data['class']) . '" 
                          target="_blank" rel="noopener noreferrer" 
                          aria-label="' . esc_attr($data['label']) . '">';
                    echo '<i class="fab fa-' . esc_attr($data['icon']) . '"></i>';
                    echo '</a>';
                }
            }
            ?>
        </div>

        <!-- Legal Links -->
        <div class="footer-legal-links text-center">
            <?php
            $legal_links = [
                'privacy' => ['default' => __('Privacy Notice', 'amt-spice')],
                'terms' => ['default' => __('Terms of Use', 'amt-spice')],
                'contact' => ['default' => __('Contact Us', 'amt-spice')]
            ];
            
            $links_output = [];
            foreach ($legal_links as $key => $data) {
                $url = get_theme_mod('amt_' . $key . '_link');
                $text = get_theme_mod('amt_' . $key . '_text', $data['default']);
                
                if ($url) {
                    $current_url = home_url($_SERVER['REQUEST_URI']);
                    $is_current = (untrailingslashit($current_url) === untrailingslashit($url));
                    
                    $links_output[] = sprintf(
                        '<a href="%s" class="footer-legal-link %s">%s</a>',
                        esc_url($url),
                        $is_current ? 'current' : '',
                        esc_html($text)
                    );
                }
            }
            
            echo implode('<span class="link-separator" aria-hidden="true"> | </span>', $links_output);
            ?>
        </div>

        <!-- Copyright -->
        <p class="footer-copyright text-center mt-3">
            &copy; <?php echo date('Y'); ?> 
            <?php echo esc_html(get_theme_mod('amt_copyright_text', get_bloginfo('name'))); ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

<?php
class Footer_Menu_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
        $output .= '<li class="footer-menu-item">';
        
        $attributes = '';
        $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
        
        $item_output = $args->before;
        $item_output .= '<a class="footer-menu-link"' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}