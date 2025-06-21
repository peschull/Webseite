<?php
// Template für den Wichtige Zahlen 2024-Block
$zahlen = get_field('zahlen');
?>
<div class="block-wichtige-zahlen-2024">
    <?php if( is_array($zahlen) ) foreach($zahlen as $zahl): ?>
        <div class="zahl">
            <span class="wert"><?php echo esc_html($zahl['wert']); ?></span>
            <span class="beschreibung"><?php echo esc_html($zahl['beschreibung']); ?></span>
        </div>
    <?php endforeach; ?>
</div>
