<?php
// Template für den Zwei-Spalten-Zitat-Bild-Block
$zitat = get_field('zitat');
$autor = get_field('autor');
$bild = get_field('bild');
?>
<div class="block-zwei-spalten-zitat-bild">
    <div class="spalte zitat">
        <blockquote><?php echo esc_html($zitat); ?></blockquote>
        <cite><?php echo esc_html($autor); ?></cite>
    </div>
    <div class="spalte bild">
        <?php if($bild): ?>
            <img src="<?php echo esc_url($bild['url']); ?>" alt="<?php echo esc_attr($bild['alt']); ?>" />
        <?php endif; ?>
    </div>
</div>
