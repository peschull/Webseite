<?php
/**
 * Template für Ehrenamtliche Übersicht
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$ehrenamtliche = get_field('ehrenamtliche');
$block_classes = 'ehrenamtliche-uebersicht-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($ehrenamtliche) : ?>
        <div class="ehrenamtliche-liste">
            <?php foreach ($ehrenamtliche as $person) : ?>
                <div class="ehrenamtlicher">
                    <?php if ($person['bild']) : ?>
                        <img src="<?php echo esc_url($person['bild']); ?>" class="ehrenamtlicher-bild" alt="<?php echo esc_attr($person['name']); ?>" />
                    <?php endif; ?>
                    <div class="ehrenamtlicher-info">
                        <span class="ehrenamtlicher-name"><?php echo esc_html($person['name']); ?></span>
                        <span class="ehrenamtlicher-rolle"><?php echo esc_html($person['rolle']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
