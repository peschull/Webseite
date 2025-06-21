<?php
// Template für den Zitat des Monats-Block
$zitat = get_field('zitat');
$autor = get_field('autor');
?>
<div class="block-zitat-des-monats">
    <blockquote><?php echo esc_html($zitat); ?></blockquote>
    <cite><?php echo esc_html($autor); ?></cite>
</div>
