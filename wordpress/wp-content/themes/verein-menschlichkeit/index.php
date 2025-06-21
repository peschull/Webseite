<?php get_header(); ?>

<main class="px-10 lg:px-20 py-12 flex flex-1 justify-center">
  <div class="layout-content-container flex flex-col max-w-7xl flex-1">
    
    <!-- Hero Section -->
    <div class="@container">
      <div class="@[480px]:p-4">
        <div class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-start justify-end px-4 pb-10 @[480px]:px-10"
             style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url("https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1973&q=80");'>
          <div class="flex flex-col gap-2 text-left">
            <h1 class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]">
              Gemeinsam für mehr Menschlichkeit
            </h1>
            <h2 class="text-white text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">
              Unterstützen Sie Menschen in Not und werden Sie Teil unserer Gemeinschaft
            </h2>
          </div>
          <div class="flex-wrap gap-3 flex">
            <a href="<?php echo home_url('/spenden'); ?>" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-5 @[480px]:h-12 @[480px]:px-5 bg-blue-600 text-slate-50 text-sm font-semibold leading-normal @[480px]:text-base @[480px]:font-semibold @[480px]:leading-normal hover:bg-blue-700 transition-colors shadow-lg">
              <span class="truncate">Jetzt spenden</span>
            </a>
            <a href="<?php echo home_url('/mitglied-werden'); ?>" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-5 @[480px]:h-12 @[480px]:px-5 bg-slate-100 text-slate-900 text-sm font-semibold leading-normal @[480px]:text-base @[480px]:font-semibold @[480px]:leading-normal hover:bg-slate-200 transition-colors shadow-lg">
              <span class="truncate">Mitglied werden</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Unsere Mission -->
    <div class="flex flex-col gap-10 px-4 py-10 @container">
      <div class="flex flex-col gap-4">
        <h2 class="text-slate-900 tracking-light text-[32px] font-bold leading-tight @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] max-w-[720px]">
          Unsere Mission
        </h2>
        <p class="text-slate-700 text-base font-normal leading-normal max-w-[720px]">
          Der Verein Menschlichkeit setzt sich für Menschen in schwierigen Lebenssituationen ein. Mit gezielten Hilfsprojekten, 
          Beratung und gemeinschaftlichem Engagement schaffen wir Perspektiven und unterstützen dort, wo Hilfe am dringendsten benötigt wird.
        </p>
      </div>
    </div>

    <!-- Aktuelle Projekte/News -->
    <?php if (have_posts()) : ?>
    <div class="grid grid-cols-1 gap-3 @container">
      <div class="flex overflow-hidden rounded-lg bg-slate-50 @[480px]:gap-4">
        <div class="flex flex-col gap-4 px-4 py-10 @[480px]:min-w-[400px] @[480px]:px-10 @[480px]:py-10">
          <div class="flex flex-col gap-1">
            <h2 class="text-slate-900 text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]">
              Aktuelles
            </h2>
            <p class="text-slate-700 text-base font-normal leading-normal">Erfahren Sie mehr über unsere aktuellen Projekte und Erfolge</p>
          </div>
        </div>
      </div>
      
      <div class="grid grid-cols-1 @[480px]:grid-cols-2 @[960px]:grid-cols-3 gap-6 px-4">
        <?php while (have_posts()) : the_post(); ?>
        <div class="flex flex-col gap-3 pb-3">
          <?php if (has_post_thumbnail()) : ?>
          <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-lg"
               style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>');">
          </div>
          <?php endif; ?>
          <div>
            <p class="text-slate-900 text-base font-medium leading-tight"><?php the_title(); ?></p>
            <p class="text-slate-700 text-sm font-normal leading-normal"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
          </div>
          <a href="<?php the_permalink(); ?>" class="text-blue-600 text-sm font-medium hover:text-blue-700">Weiterlesen</a>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
    <?php else : ?>
      <div class="text-center py-10">
        <h2 class="text-2xl font-bold text-slate-900 mb-4">Willkommen beim Verein Menschlichkeit</h2>
        <p class="text-slate-700 mb-6">Momentan sind noch keine Beiträge verfügbar. Schauen Sie bald wieder vorbei!</p>
      </div>
    <?php endif; ?>

    <!-- CTA Section -->
    <div class="flex flex-col gap-6 px-4 py-10 @container">
      <div class="flex flex-col gap-2 text-center">
        <h2 class="text-slate-900 text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]">
          Werden Sie aktiv
        </h2>
        <p class="text-slate-700 text-base font-normal leading-normal">
          Ihre Unterstützung macht den Unterschied. Werden Sie Teil unserer Gemeinschaft.
        </p>
      </div>
      <div class="flex flex-wrap justify-center gap-3">
        <a href="<?php echo home_url('/spenden'); ?>" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-blue-600 text-slate-50 text-base font-bold leading-normal tracking-[0.015em] hover:bg-blue-700 transition-colors">
          <span class="truncate">Jetzt spenden</span>
        </a>
        <a href="<?php echo home_url('/mitglied-werden'); ?>" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-slate-200 text-slate-900 text-base font-bold leading-normal tracking-[0.015em] hover:bg-slate-300 transition-colors">
          <span class="truncate">Mitglied werden</span>
        </a>
        <a href="<?php echo home_url('/ehrenamt'); ?>" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-slate-200 text-slate-900 text-base font-bold leading-normal tracking-[0.015em] hover:bg-slate-300 transition-colors">
          <span class="truncate">Ehrenamt</span>
        </a>
      </div>
    </div>

  </div>
</main>

<?php get_footer(); ?>
