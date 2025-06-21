<?php
// Template für den Laufleiste Partnerlogos-Block
$logos = get_field('logos');
?>
<div class="block-laufleiste-partnerlogos">
    <div class="logos">
        <?php if( is_array($logos) ) foreach($logos as $logo): ?>
            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
        <?php endforeach; ?>
    </div>
</div>
