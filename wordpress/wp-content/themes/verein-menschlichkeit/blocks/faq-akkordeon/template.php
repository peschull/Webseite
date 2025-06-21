<?php
/**
 * Template für den FAQ Akkordeon Block
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$faq_liste = get_field('faq_liste');
$titel = get_field('titel');
$block_classes = 'faq-akkordeon';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="faq-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="faq-akkordeon-liste">
        <?php if ($faq_liste) : foreach ($faq_liste as $faq) : ?>
            <div class="faq-item">
                <button class="faq-frage" aria-expanded="false">
                    <?php echo esc_html($faq['frage']); ?>
                    <span class="faq-toggle">+</span>
                </button>
                <div class="faq-antwort" hidden>
                    <?php echo esc_html($faq['antwort']); ?>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
