<?php
/*
Plugin Name: PagMemberCliente
Plugin URI: http://www.pagmember.com
Description: Versão Cliente do Plugin PagMember, usado para integração com o Hotmart e PagSeguro e área de Membros. Após a aprovação do pagamento, gera o usuário e a senha para o cliente e envia para o email automaticamente.
Version: 5.2
Author: Getulio Chaves
Author URI: http://www.geracaodigital.com
License: GPLv2
*/
?>
<?php

if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
		$config = array(
			'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
			'proper_folder_name' => 'PagMemberCliente', // this is the name of the folder your plugin lives in
			'api_url' => 'https://api.github.com/repos/getuliochaves/PagMemberCliente', // the GitHub API url of your GitHub repo
			'raw_url' => 'https://raw.github.com/getuliochaves/PagMemberCliente/master', // the GitHub raw url of your GitHub repo
			'github_url' => 'https://github.com/getuliochaves/PagMemberCliente', // the GitHub url of your GitHub repo
			'zip_url' => 'https://github.com/getuliochaves/PagMemberCliente/zipball/master', // the zip url of the GitHub repo
			'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
			'requires' => '3.0', // which version of WordPress does your plugin require?
			'tested' => '4.7.5', // which version of WordPress is your plugin tested up to?
			'readme' => 'README.md', // which file to use as the readme for the version number
			'access_token' => '', // Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed
		);
		new WP_GitHub_Updater($config);
	}

global $wpdb;
add_action( 'edit_user_profile', 'camposExtras');
add_action( 'show_user_profile', 'camposExtras');
add_action('init','pm_insertuser' );
function pm_insertuser() {
$newUserConfirm = $_POST['newUserConfirm'];
//if(!empty($newUserConfirm)){
//include_once('assets/inc_newuser.php');
//}
add_action( 'template_redirect', 'admin_bar_skolbloggen' );
function admin_bar_skolbloggen() {
	if ( is_user_logged_in() )
	{
	add_action( 'admin_bar_menu', 'admin_bar_skolbloggen_menu' );
	}
}

function admin_bar_skolbloggen_menu( $wp_admin_bar )
{
include_once('assets/inc_emailloged.php');
}
}
function camposExtras($user){
include_once('assets/inc_cliente.php');
}
add_thickbox();
add_action('init', 'UsuarioAtualFuncao');
function UsuarioAtualFuncao(){
global $wpdb;
$usuarioAtual  = get_current_user_id();
$prefix = $wpdb->prefix;
$ccaptab = $prefix.'capabilities';


$pegaAdmS = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$usuarioAtual' AND meta_key = '$ccaptab'");
$pegaAdm = unserialize($pegaAdmS);
$adm = $pegaAdm['administrator'];
if($adm == true){
add_action( 'personal_options_update', 'update_profile_fields');
add_action( 'edit_user_profile_update', 'update_profile_fields');
$user_id = $_GET['user_id'];
function update_profile_fields($user_id){
update_user_meta($user_id, 'TipoPagamentoPagMember', $_POST['TipoPagamento']);
update_user_meta($user_id, 'IDTransacaoPagMember', $_POST['IDTransacao']);
update_user_meta($user_id, 'PrecoPagMember', $_POST['PrecoPagMember']);
update_user_meta($user_id, 'DataCompraPagMember', $_POST['DataCompraPagMember']);
update_user_meta($user_id, 'StatusCompraPagMember', $_POST['StatusCompraPagMember']);
update_user_meta($user_id, 'DataCancelamentoPagMember', $_POST['DataCancelamentoPagMember']);
update_user_meta($user_id, 'ValorUpgradePagMember', $_POST['ValorUpgradePagMember']);
update_user_meta($user_id, 'DataUpgradePagMember', $_POST['DataUpgradePagMember']);
update_user_meta($user_id, 'senhaClientePagMember', $_POST['senhaClientePagMember']);
$clientePM = $_POST['clientePagMember'];
if($clientePM == 'sim'){
add_user_meta($user_id, 'clientePagMember', 'sim', true);
	}else{
delete_user_meta( $user_id, 'clientePagMember');
}
}
}
}
add_action('admin_menu', 'menu_pagMemberCliente');
function menu_pagMemberCliente(){
add_menu_page('PagMember - Plugin Cliente', 'PagMemberC', 10, 'pagmemberCliente', 'cliente',plugins_url("logo.png", __FILE__), 41);
}
function cliente(){
	include_once('assets/inc_home.php');
	}
global $wp_roles;
if ( ! isset( $wp_roles ) )
    $wp_roles = new WP_Roles();
?>
