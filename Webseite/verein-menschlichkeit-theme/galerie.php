<?php /* Template Name: Galerie */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Galerie', 'verein-menschlichkeit'); ?></h1>
  <div class="gallery grid md:grid-cols-3 gap-6 mt-8">
    <?php
    $images = get_field('galerie_bilder'); // ACF Gallery Field
    if ($images) :
      foreach ($images as $img) : ?>
        <a href="<?php echo esc_url($img['url']); ?>" data-lightbox="verein-galerie">
          <img src="<?php echo esc_url($img['sizes']['medium']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="rounded shadow" />
        </a>
      <?php endforeach;
    else : ?>
      <p><?php esc_html_e('Noch keine Bilder vorhanden.', 'verein-menschlichkeit'); ?></p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
