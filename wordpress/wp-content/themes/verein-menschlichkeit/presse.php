<?php /* Template Name: Presse */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Presse', 'verein-menschlichkeit'); ?></h1>
  <div class="presse-list mt-8">
    <?php
    $presse = new WP_Query(['category_name' => 'presse', 'posts_per_page' => 10]);
    if ($presse->have_posts()) :
      while ($presse->have_posts()) : $presse->the_post(); ?>
        <article class="mb-8">
          <h2 class="text-xl font-bold mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <div class="text-slate-600 mb-2"><?php the_time('d.m.Y'); ?></div>
          <div><?php the_excerpt(); ?></div>
        </article>
      <?php endwhile; wp_reset_postdata();
    else : ?>
      <p><?php esc_html_e('Keine Pressemitteilungen gefunden.', 'verein-menschlichkeit'); ?></p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
