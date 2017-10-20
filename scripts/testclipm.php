<?php
require_once('wp-load.php');
global $wpdb;
ob_start();
session_start();
ini_set('default_charset','UTF-8');
if(isset($_POST) && (!empty($_POST))){
$validacao = $_POST['validacao'];
var_dump($_POST);
$tipoPagamento = $_POST['tipoPagamento'];
$montaBuscaToken = 'tokenPagMemberCliente#'.$tipoPagamento;
$tokenExterno = $_POST['tokenExterno'];
$tokenCliente = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$montaBuscaToken'");
if($validacao == 'sim' && $tokenExterno == $tokenCliente){
$email = $_POST['email'];
	$pegaUsuarioExiste = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '$email'");
	$contaUsuarioExiste = count($pegaUsuarioExiste);
if($contaUsuarioExiste > 0){
	echo 'Existeeeee';
}
	}
}
?>
