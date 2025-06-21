<?php
/**
 * Template für Erfolgsbeispiele
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$beispiele = get_field('erfolgsbeispiele');
$block_classes = 'erfolgsbeispiele-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($beispiele) : ?>
        <div class="erfolgsbeispiele-liste">
            <?php foreach ($beispiele as $bsp) : ?>
                <div class="erfolgsbeispiel">
                    <span class="erfolgsbeispiel-titel"><?php echo esc_html($bsp['titel']); ?></span>
                    <span class="erfolgsbeispiel-text"><?php echo esc_html($bsp['text']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
