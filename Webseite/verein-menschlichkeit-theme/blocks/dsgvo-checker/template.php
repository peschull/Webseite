<?php
/**
 * Template für DSGVO-Checker
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$checklist = get_field('checklist');
$block_classes = 'dsgvo-checker-block';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($checklist) : ?>
        <ul class="dsgvo-checklist">
            <?php foreach ($checklist as $item) : ?>
                <li class="dsgvo-check-item <?php echo $item['status'] ? 'checked' : 'unchecked'; ?>">
                    <span class="check-status">
                        <?php echo $item['status'] ? '✔️' : '❌'; ?>
                    </span>
                    <span class="check-text"><?php echo esc_html($item['item']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
