<?php
/**
 * Template für Projekt-Scroller
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$projekte = get_field('projekte');
$block_classes = 'projekt-scroller';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="projekt-scroller-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="projekt-scroller-liste">
        <?php if ($projekte) : foreach ($projekte as $projekt) : ?>
            <div class="projekt-scroller-item">
                <?php if (!empty($projekt['bild'])) : ?>
                    <img src="<?php echo esc_url($projekt['bild']['url']); ?>" alt="<?php echo esc_attr($projekt['bild']['alt']); ?>" />
                <?php endif; ?>
                <div class="projekt-scroller-content">
                    <strong><?php echo esc_html($projekt['titel']); ?></strong><br />
                    <?php echo esc_html($projekt['beschreibung']); ?>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
