import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe( 'NExT Query Loop Link Target', () => {
	test( 'プラグインが有効化されている', async ( { admin, page } ) => {
		await admin.visitAdminPage( 'plugins.php' );
		const pluginRow = page.locator(
			'tr[data-slug="next-query-loop-link-target"]'
		);
		await expect( pluginRow ).toHaveClass( /active/ );
	} );
} );
