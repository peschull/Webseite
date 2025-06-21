<?php
/**
 * Template für Chat-Rückmeldeblock
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$message = get_field('chat_message');
$user = get_field('chat_user');
$block_classes = 'chat-rueckmeldeblock';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <div class="chat-message">
        <?php if ($user) : ?>
            <span class="chat-user"><?php echo esc_html($user); ?>:</span>
        <?php endif; ?>
        <span class="chat-text"><?php echo esc_html($message); ?></span>
    </div>
</div>
