<?php /* Template Name: FAQ */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Häufige Fragen', 'verein-menschlichkeit'); ?></h1>
  <div class="faq-list mt-8">
    <?php echo do_shortcode('[verein_faq frage="Wie kann ich Mitglied werden?"]Fülle das Online-Formular auf der Seite "Mitglied werden" aus oder kontaktiere uns direkt.[/verein_faq]'); ?>
    <?php echo do_shortcode('[verein_faq frage="Wie kann ich spenden?"]Nutze das Spendenformular oder überweise direkt auf unser Vereinskonto.[/verein_faq]'); ?>
    <?php echo do_shortcode('[verein_faq frage="Wie kann ich mich ehrenamtlich engagieren?"]Melde dich über das Kontaktformular oder sprich uns bei einer Veranstaltung an.[/verein_faq]'); ?>
  </div>
</main>
<?php get_footer(); ?>
