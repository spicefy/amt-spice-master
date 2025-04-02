// blocks/about-banner/render.php
<?php
function render_about_banner_block($attributes) {
  $gradient = sprintf(
    'linear-gradient(135deg, %s, %s)',
    sanitize_hex_color($attributes['gradientStart'] ?? '#009bbe'),
    sanitize_hex_color($attributes['gradientEnd'] ?? '#0061ff')
  );

  $image_html = '';
  if (!empty($attributes['mediaUrl'])) {
    $image_html = sprintf(
      '<div class="banner-image"%s>
        <img src="%s" alt="%s" loading="lazy" decoding="async" class="banner-img" />
      </div>',
      !empty($attributes['imageWidth']) ? ' style="max-width:' . absint($attributes['imageWidth']) . 'px"' : '',
      esc_url($attributes['mediaUrl']),
      esc_attr($attributes['mediaAlt'])
    );
  }

  return sprintf(
    '<section class="about-banner-block" style="background:%s">
      <div class="banner-container">
        <div class="banner-content">
          <h1>%s</h1>
          %s
        </div>
        %s
      </div>
    </section>',
    $gradient,
    wp_kses_post($attributes['title']),
    !empty($attributes['content']) ? '<p>' . wp_kses_post($attributes['content']) . '</p>' : '',
    $image_html
  );
}