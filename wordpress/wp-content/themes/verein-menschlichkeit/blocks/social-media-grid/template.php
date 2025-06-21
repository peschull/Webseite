<?php
// Template für den Social Media Grid-Block
$links = get_field('links');
?>
<div class="block-social-media-grid">
    <?php if( is_array($links) ) foreach($links as $link): ?>
        <a href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener">
            <?php echo esc_html($link['plattform']); ?>
        </a>
    <?php endforeach; ?>
</div>
