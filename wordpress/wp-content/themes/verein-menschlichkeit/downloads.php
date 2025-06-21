<?php /* Template Name: Downloads */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Downloads', 'verein-menschlichkeit'); ?></h1>
  <ul class="download-list mt-8">
    <?php
    $downloads = new WP_Query(['post_type' => 'download', 'posts_per_page' => -1]);
    if ($downloads->have_posts()) :
      while ($downloads->have_posts()) : $downloads->the_post(); ?>
        <li class="mb-4">
          <a href="<?php echo esc_url(get_field('datei_url')); ?>" class="btn-secondary" download><?php echo esc_html(get_the_title()); ?></a>
          <span class="text-slate-500 ml-2"><?php echo esc_html(get_field('beschreibung')); ?></span>
        </li>
      <?php endwhile; wp_reset_postdata();
    else : ?>
      <li><?php esc_html_e('Keine Downloads gefunden.', 'verein-menschlichkeit'); ?></li>
    <?php endif; ?>
  </ul>
</main>
<?php get_footer(); ?>
