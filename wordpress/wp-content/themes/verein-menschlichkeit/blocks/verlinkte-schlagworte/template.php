<?php
/**
 * Template für den Verlinkte-Schlagworte Block
 *
 * @package Verein-Menschlichkeit
 */

$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$title = get_field('title');
$tags = get_field('tags');
$style = get_field('tag_style') ?: 'default';
$size = get_field('tag_size') ?: 'medium';
$show_count = get_field('show_count');
?>

<div class="verlinkte-schlagworte <?php echo esc_attr($class_name); ?> style-<?php echo esc_attr($style); ?> size-<?php echo esc_attr($size); ?>">
    <?php if ($title): ?>
        <h3 class="tags-title"><?php echo esc_html($title); ?></h3>
    <?php endif; ?>
    
    <?php if ($tags): ?>
        <div class="tags-container">
            <?php foreach ($tags as $tag): ?>
                <a href="<?php echo esc_url($tag['link']); ?>" 
                   class="tag-item"
                   data-count="<?php echo esc_attr($tag['count']); ?>">
                    <?php echo esc_html($tag['label']); ?>
                    <?php if ($show_count && $tag['count']): ?>
                        <span class="tag-count"><?php echo esc_html($tag['count']); ?></span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <?php if (get_field('show_more_button') && count($tags) > get_field('initial_show')): ?>
            <button class="show-more-tags" type="button">
                <span class="show-text"><?php _e('Mehr anzeigen', 'verein-menschlichkeit'); ?></span>
                <span class="hide-text"><?php _e('Weniger anzeigen', 'verein-menschlichkeit'); ?></span>
                <span class="toggle-icon">▼</span>
            </button>
        <?php endif; ?>
        
    <?php else: ?>
        <p class="no-tags">
            <?php _e('Keine Schlagworte verfügbar.', 'verein-menschlichkeit'); ?>
        </p>
    <?php endif; ?>
</div>
