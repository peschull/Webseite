<?php
// Template für den Zählbalken Engagement Ziel-Block
$wert = get_field('wert');
$ziel = get_field('ziel');
?>
<div class="block-zaehlbalken-engagement-ziel">
    <div class="balken" style="width:<?php echo esc_attr(($wert/$ziel)*100); ?>%"></div>
    <div class="zahlen">
        <span><?php echo esc_html($wert); ?> / <?php echo esc_html($ziel); ?></span>
    </div>
</div>
