<?php
/**
 * Template für Downloadbereich mit Vorschau und Filter
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$downloads = get_field('downloads');
$block_classes = 'downloadbereich-vorschau-filter';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($downloads) : ?>
        <div class="download-filter">
            <!-- Hier könnte ein Filter-UI platziert werden -->
        </div>
        <div class="downloadliste">
            <?php foreach ($downloads as $download) : ?>
                <div class="download-item">
                    <?php if ($download['vorschau']) : ?>
                        <img src="<?php echo esc_url($download['vorschau']); ?>" class="download-vorschau" alt="Vorschau" />
                    <?php endif; ?>
                    <div class="download-info">
                        <span class="download-titel"><?php echo esc_html($download['titel']); ?></span>
                        <span class="download-kategorie"><?php echo esc_html($download['kategorie']); ?></span>
                        <a href="<?php echo esc_url($download['file']); ?>" target="_blank" rel="noopener noreferrer" class="download-link">Download</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
