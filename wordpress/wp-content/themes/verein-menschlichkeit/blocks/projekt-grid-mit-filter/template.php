<?php
/**
 * Template für das Projekt Grid mit Filter
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$heading = get_field('heading');
$subheading = get_field('subheading');
$projects = get_field('projects');
$categories = array();

// Sammle alle einzigartigen Kategorien
if ($projects) {
    foreach ($projects as $project) {
        if (!empty($project['category'])) {
            $categories[$project['category']] = $project['category'];
        }
    }
}
?>

<div class="projekt-grid-module" data-aos="fade-up">
    <?php if ($heading || $subheading) : ?>
        <div class="projekt-grid-header">
            <?php if ($heading) : ?>
                <h2 class="projekt-heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            
            <?php if ($subheading) : ?>
                <div class="projekt-subheading"><?php echo wp_kses_post($subheading); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($categories)) : ?>
        <div class="projekt-filter-container">
            <button class="filter-button active" data-filter="all">
                <?php _e('Alle', 'verein-menschlichkeit'); ?>
            </button>
            <?php foreach ($categories as $category) : ?>
                <button class="filter-button" data-filter="<?php echo esc_attr($category); ?>">
                    <?php echo esc_html($category); ?>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($projects) : ?>
        <div class="projekt-grid">
            <?php foreach ($projects as $project) : 
                $image = $project['image'];
                $title = $project['title'];
                $excerpt = $project['excerpt'];
                $category = $project['category'];
                $link = $project['link'];
                $status = $project['status'];
            ?>
                <article class="projekt-card" data-category="<?php echo esc_attr($category); ?>">
                    <?php if ($image) : ?>
                        <div class="projekt-image">
                            <img src="<?php echo esc_url($image['url']); ?>" 
                                 alt="<?php echo esc_attr($title); ?>"
                                 loading="lazy">
                            <?php if ($status) : ?>
                                <div class="projekt-status <?php echo esc_attr(sanitize_title($status)); ?>">
                                    <?php echo esc_html($status); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="projekt-content">
                        <h3 class="projekt-title">
                            <?php if ($link) : ?>
                                <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
                            <?php else : ?>
                                <?php echo esc_html($title); ?>
                            <?php endif; ?>
                        </h3>

                        <?php if ($category) : ?>
                            <div class="projekt-category"><?php echo esc_html($category); ?></div>
                        <?php endif; ?>

                        <?php if ($excerpt) : ?>
                            <div class="projekt-excerpt"><?php echo wp_kses_post($excerpt); ?></div>
                        <?php endif; ?>

                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link); ?>" class="projekt-link">
                                <?php _e('Mehr erfahren', 'verein-menschlichkeit'); ?> →
                            </a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="no-projects"><?php _e('Aktuell sind keine Projekte verfügbar.', 'verein-menschlichkeit'); ?></p>
    <?php endif; ?>
</div>
