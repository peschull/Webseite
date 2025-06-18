<?php
/**
 * Template für Download-Button mit Dateityp
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$label = get_field('label');
$file = get_field('file');
$type = get_field('type');
$block_classes = 'download-button-dateityp';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($file) : ?>
        <a href="<?php echo esc_url($file); ?>" class="download-btn" download>
            <?php echo esc_html($label); ?>
            <?php if ($type) : ?>
                <span class="download-type">(<?php echo esc_html($type); ?>)</span>
            <?php endif; ?>
        </a>
    <?php endif; ?>
</div>
