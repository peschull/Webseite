<?php
// Template für den Block "textzitat-grossinitial"
// Beispielhafte Ausgabe mit ACF-Feldern
?>
<div class="textzitat-grossinitial-block">
    <blockquote>
        <span class="grossinitial"><?php the_field('grossinitial'); ?></span><?php the_field('zitat_text'); ?>
    </blockquote>
    <cite><?php the_field('zitat_autor'); ?></cite>
</div>
