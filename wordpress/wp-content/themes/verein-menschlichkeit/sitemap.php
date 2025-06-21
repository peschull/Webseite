<?php /* Template Name: Sitemap */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Sitemap', 'verein-menschlichkeit'); ?></h1>
  <?php echo do_shortcode('[verein_sitemap]'); ?>
</main>
<?php get_footer(); ?>
