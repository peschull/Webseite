<?php
/**
 * Template für den Timeline Meilensteine Block
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$meilensteine = get_field('meilensteine');
$titel = get_field('titel');
$block_classes = 'timeline-meilensteine';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="timeline-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <ul class="timeline-list">
        <?php if ($meilensteine) : foreach ($meilensteine as $meilenstein) : ?>
            <li class="timeline-item">
                <div class="timeline-date"><?php echo esc_html($meilenstein['datum']); ?></div>
                <div class="timeline-content">
                    <h3><?php echo esc_html($meilenstein['titel']); ?></h3>
                    <p><?php echo esc_html($meilenstein['beschreibung']); ?></p>
                </div>
            </li>
        <?php endforeach; endif; ?>
    </ul>
</div>
