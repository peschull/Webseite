<?php get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
      echo '<h1>' . esc_html(get_the_title()) . '</h1>';
      the_content();
    endwhile;
  else :
    echo '<p>Kein Beitrag gefunden.</p>';
  endif;
  ?>
</main>
<?php get_footer(); ?>
