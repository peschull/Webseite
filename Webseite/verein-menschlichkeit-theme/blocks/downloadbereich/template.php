<?php
/**
 * Template für Downloadbereich
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$downloads = get_field('downloads');
$block_classes = 'downloadbereich';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($downloads) : ?>
        <ul class="downloadliste">
            <?php foreach ($downloads as $download) : ?>
                <li>
                    <a href="<?php echo esc_url($download['file']); ?>" target="_blank" rel="noopener noreferrer">
                        <?php echo esc_html($download['titel']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
