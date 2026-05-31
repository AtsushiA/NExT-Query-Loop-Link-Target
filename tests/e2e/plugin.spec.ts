import { test, expect } from '@playwright/test';

test.describe( 'NExT Query Loop Link Target', () => {
	test( 'プラグインが有効化されている', async ( { page, baseURL } ) => {
		await page.goto( `${ baseURL }/wp-admin/plugins.php` );
		const pluginRow = page.locator(
			'tr[data-slug="next-query-loop-link-target"]'
		);
		await expect( pluginRow ).toHaveClass( /active/ );
	} );
} );
