<?php /* Template Name: Newsletter */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Newsletter', 'verein-menschlichkeit'); ?></h1>
  <div class="newsletter-form mt-8">
    <!-- Beispiel: CiviCRM- oder Mailchimp-Shortcode -->
    <?php echo do_shortcode('[civicrm component="profile" gid="1" mode="create" ]'); ?>
  </div>
</main>
<?php get_footer(); ?>
