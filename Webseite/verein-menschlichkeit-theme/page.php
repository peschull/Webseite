<?php get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
      the_content();
    endwhile;
  else :
    echo '<p>Keine Inhalte gefunden.</p>';
  endif;
  ?>
</main>
<?php get_footer(); ?>
