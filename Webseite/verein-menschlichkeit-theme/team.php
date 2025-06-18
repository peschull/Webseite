<?php /* Template Name: Team */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Unser Team', 'verein-menschlichkeit'); ?></h1>
  <div class="team-list grid md:grid-cols-3 gap-8 mt-8">
    <?php
    $team = new WP_Query(['post_type' => 'team', 'posts_per_page' => -1]);
    if ($team->have_posts()) :
      while ($team->have_posts()) : $team->the_post(); ?>
        <div class="card">
          <?php if (has_post_thumbnail()) : ?>
            <div class="mb-4"><?php the_post_thumbnail('medium', ['class' => 'rounded-full w-32 h-32 mx-auto']); ?></div>
          <?php endif; ?>
          <h2 class="text-xl font-bold text-center"><?php echo esc_html(get_the_title()); ?></h2>
          <div class="text-center text-slate-600 mb-2"><?php echo esc_html(get_field('funktion')); ?></div>
          <div class="text-center"><?php the_content(); ?></div>
        </div>
      <?php endwhile; wp_reset_postdata();
    else : ?>
      <p><?php esc_html_e('Noch keine Teammitglieder eingetragen.', 'verein-menschlichkeit'); ?></p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
