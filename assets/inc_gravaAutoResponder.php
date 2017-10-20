<?php
if(isset($_POST) && !empty($_POST)){
define( 'SHORTINIT', true );
$pagePath = explode('wp-content', dirname(__FILE__));	
include_once($pagePath[0].'/wp-load.php');
global $wpdb;
$dados = $_POST;

$emailAR = $dados['email'];
$idCliente = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_email = '$emailAR'");
$grava = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$emailAR' WHERE meta_key = 'autoResponderUser' AND user_id = '$idCliente'");
var_dump($dados);
}


?>