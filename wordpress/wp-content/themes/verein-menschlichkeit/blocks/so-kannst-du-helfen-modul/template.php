<?php
/**
 * Template für das So kannst du helfen Modul
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$hilfemöglichkeiten = get_field('hilfemöglichkeiten');
$block_classes = 'so-kannst-du-helfen-modul';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="helfen-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="helfen-liste">
        <?php if ($hilfemöglichkeiten) : foreach ($hilfemöglichkeiten as $hilfe) : ?>
            <div class="helfen-item">
                <?php if (!empty($hilfe['icon'])) : ?>
                    <span class="helfen-icon"><img src="<?php echo esc_url($hilfe['icon']['url']); ?>" alt="" /></span>
                <?php endif; ?>
                <div class="helfen-content">
                    <h3><?php echo esc_html($hilfe['titel']); ?></h3>
                    <p><?php echo esc_html($hilfe['beschreibung']); ?></p>
                    <?php if (!empty($hilfe['link'])) : ?>
                        <a href="<?php echo esc_url($hilfe['link']); ?>" class="helfen-link" target="_blank" rel="noopener noreferrer">
                            <?php _e('Mehr erfahren', 'menschlichkeit'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
