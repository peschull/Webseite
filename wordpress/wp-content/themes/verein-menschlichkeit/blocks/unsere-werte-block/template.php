<?php
/**
 * Template für den Unsere Werte Block
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$heading = get_field('heading');
$subheading = get_field('subheading');
$values = get_field('values');
$layout_style = get_field('layout_style') ?: 'grid';
$animation_style = get_field('animation_style') ?: 'fade';
?>

<div class="werte-block-module <?php echo esc_attr($layout_style); ?>" data-animation="<?php echo esc_attr($animation_style); ?>">
    <?php if ($heading || $subheading) : ?>
        <div class="werte-header">
            <?php if ($heading) : ?>
                <h2 class="werte-heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            
            <?php if ($subheading) : ?>
                <div class="werte-subheading"><?php echo wp_kses_post($subheading); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($values) : ?>
        <div class="werte-container">
            <?php foreach ($values as $index => $value) : 
                $icon = $value['icon'];
                $title = $value['title'];
                $description = $value['description'];
                $link = $value['link'];
            ?>
                <div class="wert-card" data-index="<?php echo esc_attr($index); ?>">
                    <?php if ($icon) : ?>
                        <div class="wert-icon">
                            <?php if ($icon['type'] === 'custom') : ?>
                                <img src="<?php echo esc_url($icon['custom_icon']['url']); ?>"
                                     alt="<?php echo esc_attr($title); ?> Icon"
                                     loading="lazy">
                            <?php else : ?>
                                <i class="<?php echo esc_attr($icon['font_awesome_icon']); ?>"
                                   aria-hidden="true"></i>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="wert-content">
                        <h3 class="wert-title"><?php echo esc_html($title); ?></h3>
                        
                        <?php if ($description) : ?>
                            <div class="wert-description">
                                <?php echo wp_kses_post($description); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link['url']); ?>" 
                               class="wert-link"
                               <?php if ($link['target']) : ?>target="<?php echo esc_attr($link['target']); ?>"<?php endif; ?>>
                                <?php echo esc_html($link['title']); ?> →
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
