<?php
/**
 * Template für Vorlese-Block
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$text = get_field('text');
$block_classes = 'vorlese-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="vorlese-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="vorlese-text" id="vorlese-text-<?php echo esc_attr($block['id']); ?>">
        <?php echo esc_html($text); ?>
    </div>
    <button class="vorlese-button" data-target="vorlese-text-<?php echo esc_attr($block['id']); ?>">
        <span class="dashicons dashicons-megaphone"></span> Text vorlesen
    </button>
</div>
