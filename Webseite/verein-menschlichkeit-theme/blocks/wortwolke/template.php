<?php
// Template für den Wortwolke-Block
$text = get_field('text');
?>
<div class="block-wortwolke">
    <p><?php echo esc_html($text); ?></p>
</div>
