<?php
// Template für den Stimmenblock-Block
$stimmen = get_field('stimmen');
?>
<div class="block-stimmenblock">
    <?php if( is_array($stimmen) ) foreach($stimmen as $stimme): ?>
        <blockquote><?php echo esc_html($stimme['text']); ?></blockquote>
        <cite><?php echo esc_html($stimme['autor']); ?></cite>
    <?php endforeach; ?>
</div>
