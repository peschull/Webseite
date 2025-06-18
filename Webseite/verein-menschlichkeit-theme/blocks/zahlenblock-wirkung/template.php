<?php
// Template für den Zahlenblock Wirkung-Block
$zahlen = get_field('zahlen');
?>
<div class="block-zahlenblock-wirkung">
    <?php if( is_array($zahlen) ) foreach($zahlen as $zahl): ?>
        <div class="zahl">
            <span class="wert"><?php echo esc_html($zahl['wert']); ?></span>
            <span class="beschreibung"><?php echo esc_html($zahl['beschreibung']); ?></span>
        </div>
    <?php endforeach; ?>
</div>
