<?php
/**
 * Template für den Parallax-Header Block
 *
 * @package Verein-Menschlichkeit
 */

$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$background_image = get_field('background_image');
$overlay_opacity = get_field('overlay_opacity') ?: 0.3;
$heading = get_field('heading');
$subheading = get_field('subheading');
$text_color = get_field('text_color') ?: 'light';
$parallax_speed = get_field('parallax_speed') ?: 0.5;
$min_height = get_field('min_height') ?: 500;
?>

<div class="parallax-header <?php echo esc_attr($class_name); ?> text-<?php echo esc_attr($text_color); ?>"
     style="min-height: <?php echo esc_attr($min_height); ?>px;"
     data-parallax-speed="<?php echo esc_attr($parallax_speed); ?>">
    
    <?php if ($background_image): ?>
        <div class="parallax-background"
             style="background-image: url('<?php echo esc_url($background_image['url']); ?>');">
        </div>
        <div class="overlay" style="opacity: <?php echo esc_attr($overlay_opacity); ?>;"></div>
    <?php endif; ?>
    
    <div class="header-content">
        <?php if ($heading): ?>
            <h1 class="header-title"><?php echo wp_kses_post($heading); ?></h1>
        <?php endif; ?>
        
        <?php if ($subheading): ?>
            <div class="header-subtitle"><?php echo wp_kses_post($subheading); ?></div>
        <?php endif; ?>
        
        <?php if (have_rows('buttons')): ?>
            <div class="header-buttons">
                <?php while (have_rows('buttons')): the_row(); 
                    $button_text = get_sub_field('button_text');
                    $button_link = get_sub_field('button_link');
                    $button_style = get_sub_field('button_style');
                ?>
                    <a href="<?php echo esc_url($button_link); ?>" 
                       class="header-button <?php echo esc_attr($button_style); ?>">
                        <?php echo esc_html($button_text); ?>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
