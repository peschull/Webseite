<?php
// Template für den Wegweiser-Block
$punkte = get_field('punkte');
?>
<div class="block-wegweiser">
    <?php if( is_array($punkte) ) foreach($punkte as $punkt): ?>
        <div class="wegweiser-punkt">
            <span class="titel"><?php echo esc_html($punkt['titel']); ?></span>
            <span class="beschreibung"><?php echo esc_html($punkt['beschreibung']); ?></span>
        </div>
    <?php endforeach; ?>
</div>
