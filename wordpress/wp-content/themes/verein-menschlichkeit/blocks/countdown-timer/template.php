<?php
/**
 * Template für Countdown Timer
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$datum = get_field('datum');
$block_classes = 'countdown-timer';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>" data-datum="<?php echo esc_attr($datum); ?>">
    <?php if ($titel) : ?>
        <h2 class="countdown-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="countdown-anzeige">
        <span class="countdown-tage">00</span> Tage
        <span class="countdown-stunden">00</span> Std
        <span class="countdown-minuten">00</span> Min
        <span class="countdown-sekunden">00</span> Sek
    </div>
</div>
