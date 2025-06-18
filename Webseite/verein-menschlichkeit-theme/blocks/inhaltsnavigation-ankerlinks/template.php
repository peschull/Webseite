<?php
/**
 * Template für den Inhaltsnavigation-Ankerlinks Block
 *
 * @package Verein-Menschlichkeit
 */

$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$heading_selector = get_field('heading_selector') ?: 'h2';
$smooth_scroll = get_field('smooth_scroll');
$sticky_navigation = get_field('sticky_navigation');
$show_numbers = get_field('show_numbers');
?>

<div class="inhaltsnavigation-ankerlinks <?php echo esc_attr($class_name); ?> <?php echo $sticky_navigation ? 'sticky' : ''; ?>"
     data-selector="<?php echo esc_attr($heading_selector); ?>"
     data-smooth-scroll="<?php echo $smooth_scroll ? 'true' : 'false'; ?>">
    
    <div class="nav-header">
        <h3 class="nav-title"><?php _e('Inhaltsverzeichnis', 'verein-menschlichkeit'); ?></h3>
        <button class="toggle-nav" type="button" aria-expanded="true">
            <span class="screen-reader-text"><?php _e('Navigation ein-/ausblenden', 'verein-menschlichkeit'); ?></span>
            <span class="toggle-icon">▼</span>
        </button>
    </div>
    
    <nav class="contents-nav" aria-label="<?php esc_attr_e('Inhaltsverzeichnis', 'verein-menschlichkeit'); ?>">
        <ol class="nav-list <?php echo $show_numbers ? 'numbered' : ''; ?>">
            <!-- Wird dynamisch via JavaScript befüllt -->
            <li class="nav-placeholder"><?php _e('Navigation wird geladen...', 'verein-menschlichkeit'); ?></li>
        </ol>
    </nav>
    
    <?php if ($sticky_navigation): ?>
        <button class="scroll-top" type="button" aria-label="<?php esc_attr_e('Nach oben scrollen', 'verein-menschlichkeit'); ?>">
            ↑
        </button>
    <?php endif; ?>
</div>
