<?php
/**
 * Template für Blog Kachelgrid
 *
 * @package Verein_Menschlichkeit
 */

defined('ABSPATH') || exit;

$titel = get_field('titel');
$anzahl = get_field('anzahl');
$block_classes = 'blog-kachelgrid';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
// Query für Blogbeiträge
$args = array(
    'post_type' => 'post',
    'posts_per_page' => $anzahl ? intval($anzahl) : 6,
    'post_status' => 'publish',
);
$query = new WP_Query($args);
?>
<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($titel) : ?>
        <h2 class="bloggrid-titel"><?php echo esc_html($titel); ?></h2>
    <?php endif; ?>
    <div class="bloggrid-grid">
        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
            <article class="bloggrid-item">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="bloggrid-thumb">
                        <?php the_post_thumbnail('medium_large'); ?>
                    </a>
                <?php endif; ?>
                <div class="bloggrid-content">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="bloggrid-excerpt"><?php the_excerpt(); ?></div>
                </div>
            </article>
        <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
</div>
