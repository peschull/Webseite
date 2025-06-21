<?php
/**
 * Template für den Mini-Podcast-Player Block
 *
 * @package Verein-Menschlichkeit
 */

$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$episode_title = get_field('episode_title');
$audio_url = get_field('audio_url');
$episode_duration = get_field('episode_duration');
$episode_description = get_field('episode_description');
?>

<div class="mini-podcast-player <?php echo esc_attr($class_name); ?>" data-audio-url="<?php echo esc_url($audio_url); ?>">
    <div class="podcast-header">
        <button class="play-button" type="button" aria-label="<?php esc_attr_e('Abspielen/Pause', 'verein-menschlichkeit'); ?>">
            <span class="play-icon">▶</span>
            <span class="pause-icon" style="display: none;">⏸</span>
        </button>
        
        <div class="episode-info">
            <h4 class="episode-title"><?php echo esc_html($episode_title); ?></h4>
            <?php if ($episode_duration): ?>
                <span class="episode-duration"><?php echo esc_html($episode_duration); ?></span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="player-controls">
        <div class="progress-bar">
            <div class="progress-background"></div>
            <div class="progress-current"></div>
            <input type="range" class="progress-slider" value="0" min="0" max="100" step="0.1">
        </div>
        
        <div class="time-display">
            <span class="current-time">00:00</span>
            <span class="duration-time"><?php echo esc_html($episode_duration); ?></span>
        </div>
    </div>
    
    <?php if ($episode_description): ?>
        <div class="episode-description">
            <?php echo wp_kses_post($episode_description); ?>
        </div>
    <?php endif; ?>
    
    <audio style="display: none;">
        <source src="<?php echo esc_url($audio_url); ?>" type="audio/mpeg">
        <?php _e('Ihr Browser unterstützt das Audio-Element nicht.', 'verein-menschlichkeit'); ?>
    </audio>
</div>
