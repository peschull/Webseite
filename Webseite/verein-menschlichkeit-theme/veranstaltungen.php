<?php /* Template Name: Veranstaltungen */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Veranstaltungen', 'verein-menschlichkeit'); ?></h1>
  <div class="event-list grid md:grid-cols-2 gap-8 mt-8">
    <?php
    $events = new WP_Query(['post_type' => 'event', 'posts_per_page' => -1, 'orderby' => 'meta_value', 'meta_key' => 'datum', 'order' => 'ASC']);
    if ($events->have_posts()) :
      while ($events->have_posts()) : $events->the_post(); ?>
        <div class="card">
          <h2 class="text-xl font-bold mb-2"><?php echo esc_html(get_the_title()); ?></h2>
          <div class="text-slate-600 mb-2"><?php echo esc_html(get_field('datum')); ?> | <?php echo esc_html(get_field('ort')); ?></div>
          <div><?php the_content(); ?></div>
        </div>
      <?php endwhile; wp_reset_postdata();
    else : ?>
      <p><?php esc_html_e('Keine Veranstaltungen gefunden.', 'verein-menschlichkeit'); ?></p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
