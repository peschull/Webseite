<?php
// Template für den Live-Suchfeld-Block
$placeholder = get_field('placeholder');
?>
<div class="block-live-suchfeld">
    <input type="text" placeholder="<?php echo esc_attr($placeholder); ?>" />
</div>
