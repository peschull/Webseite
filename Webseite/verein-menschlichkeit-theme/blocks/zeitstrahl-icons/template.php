<?php
// Template für den Zeitstrahl Icons-Block
$eintraege = get_field('eintraege');
?>
<div class="block-zeitstrahl-icons">
    <?php if( is_array($eintraege) ) foreach($eintraege as $eintrag): ?>
        <div class="zeitstrahl-eintrag">
            <span class="icon"><?php echo esc_html($eintrag['icon']); ?></span>
            <span class="text"><?php echo esc_html($eintrag['text']); ?></span>
        </div>
    <?php endforeach; ?>
</div>
