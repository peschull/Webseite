<?php
// Template für den Vorstandswahlmodul-Block
$wahl = get_field('wahl');
?>
<div class="block-vorstandswahlmodul">
    <div class="wahl">
        <?php echo esc_html($wahl); ?>
    </div>
</div>
