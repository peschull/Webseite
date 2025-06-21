<?php
/**
 * Template für den Petitions-Block
 *
 * @package Verein-Menschlichkeit
 */

// Block-Inhalte
$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}
?>

<div class="petition-block <?php echo esc_attr($class_name); ?>">
    <div class="petition-container">
        <h2 class="petition-title">
            <?php echo esc_html(get_field('petition_title')); ?>
        </h2>
        <div class="petition-content">
            <?php echo wp_kses_post(get_field('petition_content')); ?>
        </div>
        <div class="petition-progress">
            <?php
            $current = get_field('current_signatures');
            $goal = get_field('signature_goal');
            $percentage = ($current / $goal) * 100;
            ?>
            <div class="progress-bar">
                <div class="progress" style="width: <?php echo esc_attr($percentage); ?>%"></div>
            </div>
            <div class="signature-count">
                <?php echo esc_html($current); ?> von <?php echo esc_html($goal); ?> Unterschriften
            </div>
        </div>
        <div class="petition-actions">
            <button class="sign-petition-button">
                Petition unterschreiben
            </button>
        </div>
    </div>
</div>
