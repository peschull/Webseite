<?php
// Template für den Statuten Accordion-Block
$statuten = get_field('statuten');
?>
<div class="block-statuten-accordion">
    <?php if( is_array($statuten) ) foreach($statuten as $item): ?>
        <details>
            <summary><?php echo esc_html($item['titel']); ?></summary>
            <div><?php echo esc_html($item['text']); ?></div>
        </details>
    <?php endforeach; ?>
</div>
