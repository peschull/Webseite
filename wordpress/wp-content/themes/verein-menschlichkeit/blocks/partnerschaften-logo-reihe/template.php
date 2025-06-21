<?php
/**
 * Template für den Partnerschaften Logo-Reihe Block
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$beschreibung = get_field('beschreibung');
$partner_logos = get_field('partner_logos');
$block_classes = 'partnerschaften-logo-reihe';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="partner-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    
    <?php if ($beschreibung) : ?>
        <div class="partner-beschreibung"><?php echo wp_kses_post($beschreibung); ?></div>
    <?php endif; ?>

    <?php if ($partner_logos) : ?>
        <div class="partner-logos">
            <?php foreach ($partner_logos as $logo) : ?>
                <div class="partner-logo-item">
                    <?php if (!empty($logo['link'])) : ?>
                        <a href="<?php echo esc_url($logo['link']); ?>" target="_blank" rel="noopener">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($logo['logo']['url']); ?>" 
                         alt="<?php echo esc_attr($logo['logo']['alt']); ?>"
                         title="<?php echo esc_attr($logo['name']); ?>" />
                    
                    <?php if (!empty($logo['link'])) : ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($logo['name'])) : ?>
                        <div class="partner-name"><?php echo esc_html($logo['name']); ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
