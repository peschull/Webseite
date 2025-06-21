<?php
/**
 * Template für Mitmach-Checkliste
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$aufgaben = get_field('aufgaben');
$block_classes = 'mitmach-checkliste';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="checkliste-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <ul class="checkliste-liste">
        <?php if ($aufgaben) : foreach ($aufgaben as $aufgabe) : ?>
            <li class="checkliste-item">
                <label>
                    <input type="checkbox" class="checkliste-checkbox" />
                    <span class="checkliste-text"><?php echo esc_html($aufgabe['text']); ?></span>
                </label>
            </li>
        <?php endforeach; endif; ?>
    </ul>
</div>
