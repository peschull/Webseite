<?php
// Template für den Vor-Ort-Galerie-Block
$bilder = get_field('bilder');
?>
<div class="block-vor-ort-galerie">
    <?php if( is_array($bilder) ) foreach($bilder as $bild): ?>
        <img src="<?php echo esc_url($bild['url']); ?>" alt="<?php echo esc_attr($bild['alt']); ?>" />
    <?php endforeach; ?>
</div>
