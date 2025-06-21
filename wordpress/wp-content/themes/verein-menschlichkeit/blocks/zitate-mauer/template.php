<?php
/**
 * Template für die Zitate-Mauer
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$zitate = get_field('zitate');
$block_classes = 'zitate-mauer';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="zitate-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="zitate-mauer-grid">
        <?php if ($zitate) : foreach ($zitate as $zitat) : ?>
            <blockquote class="zitat-item">
                <p class="zitat-text">“<?php echo esc_html($zitat['text']); ?>”</p>
                <?php if (!empty($zitat['autor'])) : ?>
                    <footer class="zitat-autor">— <?php echo esc_html($zitat['autor']); ?></footer>
                <?php endif; ?>
            </blockquote>
        <?php endforeach; endif; ?>
    </div>
</div>
