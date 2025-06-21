<?php get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1>Suchergebnisse</h1>
  <?php if (have_posts()) : ?>
    <ul>
      <?php while (have_posts()) : the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
      <?php endwhile; ?>
    </ul>
  <?php else : ?>
    <p>Keine Ergebnisse gefunden.</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
