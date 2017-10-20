<?php
global $wpdb;
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
  die();
unlink(ABSPATH.'/registraclipm.php');
unlink(ABSPATH.'/testclipm.php');
?>
