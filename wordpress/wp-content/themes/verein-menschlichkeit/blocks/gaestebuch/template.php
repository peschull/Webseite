<?php
// Template für den Gästebuch-Block
$eintraege = get_field('eintraege');
?>
<div class="block-gaestebuch">
    <ul>
        <?php if( is_array($eintraege) ) foreach($eintraege as $eintrag): ?>
            <li><?php echo esc_html($eintrag); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
