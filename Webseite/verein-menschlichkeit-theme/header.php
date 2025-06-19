<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php // Title tag is handled via add_theme_support( 'title-tag' ) ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <a class="skip-link" href="#main-content"><?php esc_html_e('Zum Inhalt springen', 'verein-menschlichkeit'); ?></a>
  <header>
    <div class="container flex items-center justify-between py-4">
      <div class="flex items-center gap-3">
        <?php if (function_exists('the_custom_logo') && has_custom_logo()) {
          the_custom_logo();
        } else { ?>
          <h1 class="site-title"><a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a></h1>
        <?php } ?>
      </div>
      <nav role="navigation" aria-label="<?php esc_attr_e('Hauptmenü', 'verein-menschlichkeit'); ?>">
        <?php
        wp_nav_menu([
          'theme_location' => 'main-menu',
          'container' => false,
          'menu_class' => 'main-menu',
          'fallback_cb' => false
        ]);
        ?>
      </nav>
      <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <label>
          <span class="screen-reader-text"><?php esc_html_e('Suche nach:', 'verein-menschlichkeit'); ?></span>
          <input type="search" class="search-field" placeholder="<?php esc_attr_e('Suche …', 'verein-menschlichkeit'); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
        </label>
        <button type="submit" class="search-submit"><?php esc_html_e('Suchen', 'verein-menschlichkeit'); ?></button>
      </form>
      <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e('Menü öffnen', 'verein-menschlichkeit'); ?>" onclick="document.querySelector('.main-menu').classList.toggle('open')">☰</button>
    </div>
  </header>
