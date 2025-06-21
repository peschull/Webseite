<?php
// Template für den Mitgliederkarte-Block
$karte = get_field('karte');
?>
<div class="block-mitgliederkarte">
    <div class="karte">
        <?php echo esc_html($karte); ?>
    </div>
</div>
