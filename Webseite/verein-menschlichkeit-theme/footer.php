<footer role="contentinfo">
    <div class="container">
      <?php if (is_active_sidebar('footer-1')) : ?>
        <div class="footer-widgets">
          <?php dynamic_sidebar('footer-1'); ?>
        </div>
      <?php endif; ?>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('rechtliches'))); ?>"><?php esc_html_e('Impressum & Datenschutz', 'verein-menschlichkeit'); ?></a>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>
</html>
