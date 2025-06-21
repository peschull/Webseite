<?php
/**
 * Template für das Kartenmodul mit GPX
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$gpx = get_field('gpx_datei');
$marker = get_field('marker');
$block_classes = 'kartenmodul-mit-gpx';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="kartenmodul-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="kartenmodul-map" data-gpx="<?php echo esc_url($gpx['url']); ?>">
        <!-- Die Karte und der GPX-Track werden per JS gerendert -->
    </div>
    <?php if ($marker) : ?>
        <div class="kartenmodul-marker-list">
            <?php foreach ($marker as $m) : ?>
                <div class="kartenmodul-marker">
                    <strong><?php echo esc_html($m['titel']); ?></strong><br />
                    <?php echo esc_html($m['beschreibung']); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
