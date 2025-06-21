<?php
// Template für den Zustimmungsbarometer-Block
$zustimmung = get_field('zustimmung');
$gesamt = get_field('gesamt');
?>
<div class="block-zustimmungsbarometer">
    <div class="bar" style="width:<?php echo esc_attr(($zustimmung/$gesamt)*100); ?>%"></div>
    <div class="zahlen">
        <span><?php echo esc_html($zustimmung); ?> / <?php echo esc_html($gesamt); ?></span>
    </div>
</div>
