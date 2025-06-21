<?php
/**
 * Template für Pressebereich Downloadboxen
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$downloads = get_field('downloads');
$block_classes = 'pressebereich-downloadboxen';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="presse-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="downloadboxen-liste">
        <?php if ($downloads) : foreach ($downloads as $download) : ?>
            <div class="downloadbox">
                <div class="downloadbox-info">
                    <strong><?php echo esc_html($download['titel']); ?></strong><br />
                    <?php echo esc_html($download['beschreibung']); ?>
                </div>
                <a href="<?php echo esc_url($download['datei']['url']); ?>" class="downloadbox-link" download>
                    <?php _e('Download', 'menschlichkeit'); ?>
                </a>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
