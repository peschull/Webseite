import { test, expect } from '@playwright/test';

// Beispielhafter E2E-Test für den Textsplitter-Block im Gutenberg-Editor

test.describe('Textsplitter Block', () => {
	test('Block kann eingefügt und editiert werden', async ({ page }) => {
		// WordPress-Login (ggf. anpassen)
		await page.goto('http://localhost/wp-login.php');
		await page.fill('#user_login', 'admin');
		await page.fill('#user_pass', 'password');
		await page.click('#wp-submit');

		// Editor öffnen
		await page.goto('http://localhost/wp-admin/post-new.php');
		await page.click('button[aria-label="Block hinzufügen"]');
		await page.fill('input[placeholder="Suche"]', 'Textsplitter');
		await page.click('button[aria-label="Textsplitter Block"]');

		// Titel editieren
		await page.fill('h2.block-editor-rich-text__editable', 'E2E Test Titel');
		await expect(page.locator('h2.block-editor-rich-text__editable')).toHaveText('E2E Test Titel');

		// Beitrag veröffentlichen
		await page.click('button.editor-post-publish-panel__toggle');
		await page.click('button.editor-post-publish-button');
		await expect(page.locator('div.components-snackbar__content')).toContainText('veröffentlicht');
	});
});
