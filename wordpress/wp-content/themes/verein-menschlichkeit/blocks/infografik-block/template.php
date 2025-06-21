<?php
/**
 * Template für den Infografik Block
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$infografik = get_field('infografik');
$text_oben = get_field('text_oben');
$text_unten = get_field('text_unten');
$block_classes = 'infografik-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="infografik-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <?php if ($text_oben) : ?>
        <div class="infografik-text oben"><?php echo esc_html($text_oben); ?></div>
    <?php endif; ?>
    <?php if ($infografik) : ?>
        <div class="infografik-grafik">
            <img src="<?php echo esc_url($infografik['url']); ?>" alt="<?php echo esc_attr($infografik['alt']); ?>" />
        </div>
    <?php endif; ?>
    <?php if ($text_unten) : ?>
        <div class="infografik-text unten"><?php echo esc_html($text_unten); ?></div>
    <?php endif; ?>
</div>
