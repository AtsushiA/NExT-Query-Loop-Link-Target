<?php
/**
 * PHPUnit bootstrap file for Unit tests.
 */

// nqllt.php の ABSPATH チェックが exit しないよう定義する.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', '/tmp/' );
}

require_once dirname( __DIR__, 2 ) . '/../vendor/autoload.php';
