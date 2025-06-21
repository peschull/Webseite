<?php
// Template für den Mitmach-Voting-Block
$frage = get_field('frage');
$optionen = get_field('optionen');
?>
<div class="block-mitmach-voting">
    <h3><?php echo esc_html($frage); ?></h3>
    <?php if( is_array($optionen) ) foreach($optionen as $option): ?>
        <div class="option"><?php echo esc_html($option); ?></div>
    <?php endforeach; ?>
</div>
