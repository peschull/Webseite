import { test, expect } from '@playwright/test';

test.describe('WordPress Theme Accessibility Tests', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('http://localhost:3000/Webseite/verein-menschlichkeit-theme/index.html');
  });

  test('should have WordPress semantic structure', async ({ page }) => {
    // Basic page structure
    await expect(page.locator('body')).toBeVisible();
    await expect(page.locator('html')).toHaveAttribute('lang', 'de');
    await expect(page).toHaveTitle(/Verein Menschlichkeit/);
    
    // WordPress specific structure
    await expect(page.locator('body')).toHaveClass(/home|blog|logged-in/);
    await expect(page.locator('header, .site-header')).toBeVisible();
    await expect(page.locator('main, .site-main, #main')).toBeVisible();
    await expect(page.locator('footer, .site-footer')).toBeVisible();
  });

  test('should have proper WordPress heading hierarchy', async ({ page }) => {
    const h1Count = await page.locator('h1').count();
    expect(h1Count).toBeGreaterThan(0);
    
    // Check for proper heading hierarchy
    const headings = await page.locator('h1, h2, h3, h4, h5, h6').count();
    expect(headings).toBeGreaterThan(0);
  });

  test('should have WordPress block elements with proper accessibility', async ({ page }) => {
    // Test WordPress blocks - check that at least one exists
    await expect(page.locator('.wp-block').first()).toBeVisible();
    
    // Test custom blocks from theme
    await expect(page.locator('.cta-block')).toBeVisible();
    await expect(page.locator('.team-block')).toBeVisible();
    await expect(page.locator('.werte-block')).toBeVisible();
  });

  test('should have images with alt attributes (WordPress media)', async ({ page }) => {
    const images = page.locator('img');
    const imageCount = await images.count();
    
    for (let i = 0; i < imageCount; i++) {
      const img = images.nth(i);
      await expect(img).toHaveAttribute('alt');
    }
  });

  test('should have WordPress navigation accessibility', async ({ page }) => {
    // WordPress navigation - check for main navigation first
    await expect(page.locator('nav').first()).toBeVisible();
    
    // Also check for specific WordPress navigation classes
    const navElements = page.locator('nav, .navigation, .nav-menu');
    await expect(navElements.first()).toBeVisible();
    
    // Skip links for accessibility
    const skipLinks = page.locator('.screen-reader-text, .skip-link');
    if (await skipLinks.count() > 0) {
      await expect(skipLinks.first()).toBeVisible();
    }
    
    // Menu accessibility
    const navLinks = page.locator('nav a, .menu-item a');
    const linkCount = await navLinks.count();
    
    for (let i = 0; i < linkCount; i++) {
      const link = navLinks.nth(i);
      await expect(link).not.toBeEmpty();
    }
  });

  test('should have proper form accessibility (WordPress forms)', async ({ page }) => {
    const forms = page.locator('form');
    const formCount = await forms.count();
    
    for (let i = 0; i < formCount; i++) {
      const form = forms.nth(i);
      const inputs = form.locator('input, textarea, select');
      const inputCount = await inputs.count();
      
      for (let j = 0; j < inputCount; j++) {
        const input = inputs.nth(j);
        const id = await input.getAttribute('id');
        
        if (id) {
          await expect(page.locator(`label[for="${id}"]`)).toBeVisible();
        }
      }
    }
  });

  test('should have proper ARIA landmarks', async ({ page }) => {
    // Test for ARIA landmarks
    await expect(page.locator('[role="banner"]')).toBeVisible(); // header
    await expect(page.locator('[role="main"]')).toBeVisible(); // main content
    await expect(page.locator('[role="contentinfo"]')).toBeVisible(); // footer
    await expect(page.locator('[role="navigation"]')).toBeVisible(); // navigation
  });

  test('should have keyboard navigation support', async ({ page }) => {
    // Test keyboard navigation
    await page.keyboard.press('Tab');
    
    // Check if focus is visible
    const focusedElement = page.locator(':focus');
    await expect(focusedElement).toBeVisible();
  });
});
