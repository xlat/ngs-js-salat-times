<?php

defined( 'ABSPATH' ) or die( 'Bas les pattes!' );

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

delete_option('njs_js_salat_times_options');

?>