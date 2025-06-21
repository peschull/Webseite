<?php
// Template für den Block "externe-tools-einbettung"
// Beispielhafte Ausgabe mit ACF-Feldern
?>
<div class="externe-tools-einbettung-block">
    <h2><?php the_field('block_titel'); ?></h2>
    <div class="tool-embed">
        <?php the_field('tool_embed_code'); ?>
    </div>
</div>
