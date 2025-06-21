import { test, expect } from '@playwright/test';

//       await expect(skipLinks.first()).toBeVisible();
//     } else {
//       console.warn('No skip links found, this may affect accessibility.');
//     }
//   });
// 
//   test('should have proper ARIA roles and attributes', async ({ page }) => {
//     // Check for ARIA roles in main content
//     const mainContent = page.locator('main, .site-main, #main');
//     await expect(mainContent).toHaveAttribute('role', 'main');
//     
//     // Check for ARIA landmarks
//     const landmarks = ['banner', 'navigation', 'contentinfo'];
//     for (const role of landmarks) {
//       await expect(page.locator(`[role="${role}"]`)).toBeVisible();
//     }
//   });
// });
// Visual regression tests for a web application using Playwright

// Ensure you have Playwright installed and configured in your project
// npm install -D @playwright/test

// This file is used to run visual regression tests on a web application
// It captures screenshots of various elements and pages to compare against baseline images

test.describe('Visual Regression Tests', () => {
  test.beforeEach(async ({ page }, testInfo) => {
    console.log(`Running: ${testInfo.title}`);
  });

  test('homepage visual test', async ({ page }) => {
    await page.goto('/');
    await page.waitForLoadState('networkidle');
    // 100% exakter Screenshot-Abgleich
    await expect(page).toHaveScreenshot('homepage.png', { maxDiffPixelRatio: 0 });
  });

  test('accessibility test page visual test', async ({ page }) => {
    await page.goto('/accessibility-test');
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveScreenshot('accessibility-test.png', { maxDiffPixelRatio: 0 });
  });

  test('responsive design - mobile', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/');
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveScreenshot('homepage-mobile.png', { maxDiffPixelRatio: 0 });
  });

  test('responsive design - tablet', async ({ page }) => {
    await page.setViewportSize({ width: 768, height: 1024 });
    await page.goto('/');
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveScreenshot('homepage-tablet.png', { maxDiffPixelRatio: 0 });
  });

  test('button hover state', async ({ page }) => {
    await page.goto('/');
    const button = page.locator('.btn').first();
    await button.waitFor({ state: 'visible' });
    await button.hover();
    await expect(button).toHaveScreenshot('button-hover.png', { maxDiffPixelRatio: 0 });
  });

  test('navigation menu', async ({ page }) => {
    await page.goto('/');
    const nav = page.locator('nav').first();
    await nav.waitFor({ state: 'visible' });
    await expect(nav).toHaveScreenshot('navigation.png', { maxDiffPixelRatio: 0 });
  });

  test('hero section', async ({ page }) => {
    await page.goto('/');
    const hero = page.locator('.hero').first();
    await hero.waitFor({ state: 'visible' });
    await expect(hero).toHaveScreenshot('hero-section.png', { maxDiffPixelRatio: 0 });
  });

  test('feature cards', async ({ page }) => {
    await page.goto('/');
    const features = page.locator('.features').first();
    await features.waitFor({ state: 'visible' });
    await expect(features).toHaveScreenshot('feature-cards.png', { maxDiffPixelRatio: 0 });
  });
});
