<?php /* Template Name: Partner */ get_header(); ?>
<main id="main-content" class="container py-10 px-4">
  <h1><?php esc_html_e('Partner & Unterstützer', 'verein-menschlichkeit'); ?></h1>
  <div class="partner-list grid md:grid-cols-3 gap-8 mt-8">
    <?php
    $partner = get_field('partner'); // ACF Repeater Field
    if ($partner) :
      foreach ($partner as $item) : ?>
        <div class="card text-center">
          <?php if (!empty($item['logo'])) : ?>
            <img src="<?php echo esc_url($item['logo']['sizes']['medium']); ?>" alt="<?php echo esc_attr($item['name']); ?>" class="mx-auto mb-2" style="max-height:80px;" />
          <?php endif; ?>
          <h2 class="text-lg font-bold mb-1"><?php echo esc_html($item['name']); ?></h2>
          <?php if (!empty($item['url'])) : ?>
            <a href="<?php echo esc_url($item['url']); ?>" target="_blank" rel="noopener" class="text-blue-600 underline">Website</a>
          <?php endif; ?>
        </div>
      <?php endforeach;
    else : ?>
      <p><?php esc_html_e('Noch keine Partner eingetragen.', 'verein-menschlichkeit'); ?></p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
