<?php
/**
 * Template für Statistikblock animiert
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$statistiken = get_field('statistiken');
$block_classes = 'statistikblock-animiert';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="statistikblock-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="statistikblock-liste">
        <?php if ($statistiken) : foreach ($statistiken as $stat) : ?>
            <div class="statistikblock-item">
                <div class="statistikblock-zahl" data-ziel="<?php echo esc_attr($stat['zahl']); ?>">0</div>
                <div class="statistikblock-label"><?php echo esc_html($stat['label']); ?></div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
