<?php
add_action('init','redireciona_login');

function redireciona_login(){
 global $pagenow;
 if( 'wp-login.php' == $pagenow ) {
 // wp_redirect('http://pagmember.com/login');
  exit();
 }
}
?>