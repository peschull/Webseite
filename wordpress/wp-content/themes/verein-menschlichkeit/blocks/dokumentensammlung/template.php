<?php
/**
 * Template für Dokumentensammlung
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$dokumente = get_field('dokumente');
$block_classes = 'dokumentensammlung';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($dokumente) : ?>
        <ul class="dokumentenliste">
            <?php foreach ($dokumente as $dokument) : ?>
                <li>
                    <a href="<?php echo esc_url($dokument['file']); ?>" target="_blank" rel="noopener noreferrer">
                        <?php echo esc_html($dokument['titel']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
