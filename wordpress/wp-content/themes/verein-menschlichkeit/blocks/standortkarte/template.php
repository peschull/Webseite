<?php
/**
 * Template für den Standortkarte-Block
 *
 * @package Verein-Menschlichkeit
 */

// Block-Inhalte
$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$location = get_field('location');
$zoom = get_field('zoom_level') ?: 13;
?>

<div class="standortkarte-block <?php echo esc_attr($class_name); ?>">
    <div class="map-container" 
         data-lat="<?php echo esc_attr($location['lat']); ?>" 
         data-lng="<?php echo esc_attr($location['lng']); ?>"
         data-zoom="<?php echo esc_attr($zoom); ?>">
        <div id="map" style="height: 400px;"></div>
    </div>
    <?php if (get_field('show_address')): ?>
        <div class="location-info">
            <h3><?php echo esc_html(get_field('location_name')); ?></h3>
            <p><?php echo wp_kses_post(get_field('address')); ?></p>
        </div>
    <?php endif; ?>
</div>
