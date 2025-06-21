<?php
/**
 * Template für den Projektmatrix Block
 *
 * @package Verein-Menschlichkeit
 */

$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$projects = get_field('projects');
$categories = get_field('categories');
$show_filters = get_field('show_filters');
?>

<div class="projektmatrix <?php echo esc_attr($class_name); ?>">
    <?php if ($show_filters && $categories): ?>
        <div class="matrix-filters">
            <div class="filter-group">
                <?php foreach ($categories as $category): ?>
                    <button class="filter-button" data-category="<?php echo esc_attr($category['value']); ?>">
                        <?php echo esc_html($category['label']); ?>
                    </button>
                <?php endforeach; ?>
                <button class="filter-button active" data-category="all">
                    <?php _e('Alle anzeigen', 'verein-menschlichkeit'); ?>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <div class="projects-grid">
        <?php if ($projects): ?>
            <?php foreach ($projects as $project): ?>
                <div class="project-card" 
                     data-categories='<?php echo esc_attr(json_encode($project['categories'])); ?>'>
                    
                    <?php if ($project['image']): ?>
                        <div class="project-image">
                            <img src="<?php echo esc_url($project['image']['url']); ?>"
                                 alt="<?php echo esc_attr($project['image']['alt']); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="project-content">
                        <h3 class="project-title">
                            <?php echo esc_html($project['title']); ?>
                        </h3>
                        
                        <?php if ($project['description']): ?>
                            <p class="project-description">
                                <?php echo wp_kses_post($project['description']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($project['status']): ?>
                            <div class="project-status <?php echo esc_attr($project['status']); ?>">
                                <?php echo esc_html(get_status_label($project['status'])); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($project['link']): ?>
                            <a href="<?php echo esc_url($project['link']); ?>" 
                               class="project-link">
                                <?php _e('Mehr erfahren', 'verein-menschlichkeit'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-projects">
                <?php _e('Aktuell sind keine Projekte verfügbar.', 'verein-menschlichkeit'); ?>
            </p>
        <?php endif; ?>
    </div>
</div>

<?php
function get_status_label($status) {
    $labels = array(
        'active' => __('Aktiv', 'verein-menschlichkeit'),
        'planned' => __('Geplant', 'verein-menschlichkeit'),
        'completed' => __('Abgeschlossen', 'verein-menschlichkeit'),
    );
    return isset($labels[$status]) ? $labels[$status] : $status;
}
