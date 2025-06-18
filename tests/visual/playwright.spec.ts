import { test, expect } from '@playwright/test';

const urls = ['/', '/spenden', '/team', '/events'];

for (const url of urls) {
  test(`snapshot ${url}`, async ({ page }) => {
    await page.goto(url);
    expect(await page.screenshot({ fullPage: true })).toMatchSnapshot(`${url.replace(/\//g, '_')}.png`, { maxDiffPixelRatio: 0.001 });
  });
}
