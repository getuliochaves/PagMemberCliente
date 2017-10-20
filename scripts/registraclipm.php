<?php
require_once('wp-load.php');
global $wpdb;
//Define a base do Prefixo das tabelas
$base_prefixo = $wpdb->base_prefix;
//Define caminho padrao pasta
$caminhoPadraoPMC = 'wp-content/plugins/PagMemberCliente/';
//Nome de busca capacidades
$capacidades = $base_prefixo.'capabilities';
//Data atual
$dataGrava = date('d-m-Y');
//Pega o EOT Time

//Validacao ON
if(isset($_POST) && $_POST['newUserConfirm'] == 'newUserConfirm'){
include_once($caminhoPadraoPMC.'incs/inc_validapost.php');

//Validaçao OFF
/*
$validacaoOff = 'sim';
if($validacaoOff == 'sim'){
include_once($caminhoPadraoPMC.'incs/testesof.php');
*/
//Monta Busca do Token
$montaBuscaToken = 'tokenPagMemberCliente#'.$tipoProd;
//Pega token do Banco
$pegaToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$montaBuscaToken'");

//var_dump($pegaToken);

//Inicio Token validado com sucesso
if($pegaToken == $token){
//Pega o Id do Usuário
$idUsuario = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '$emailCli'");
//Conta se o usuário existe
$contaUsuario = count($idUsuario);

/*########################Se NAO usuario Existir###################*/
if($contaUsuario == 0){
	//Inclui o cadastro de cliente
	include_once($caminhoPadraoPMC.'incs/inc_cadcli.php');
};/*########################FIM Se usuario NAO Existir###################*/


/*########################Se usuario Existir###################*/
if($contaUsuario > 0){

	//inclui a validacao de Cliente
	include_once($caminhoPadraoPMC.'incs/inc_funcaodeusuario.php');

	//inclui a validacao de Cliente
	include_once($caminhoPadraoPMC.'incs/inc_valcliente.php');

	//inclui a validacao de pagamentos
	include_once($caminhoPadraoPMC.'incs/inc_valpag.php');

	//Se compra Cancelada
	include_once($caminhoPadraoPMC.'incs/inc_valcancelado.php');

	//Se compra Aprovada
	include_once($caminhoPadraoPMC.'incs/inc_valaprovado.php');

	//Se compra Aguardando Pagamento
	include_once($caminhoPadraoPMC.'incs/inc_valaguarda.php');

	//Validacao Final
	if($clienteNoSite != 'excluirCliente'){
		include_once($caminhoPadraoPMC.'incs/inc_valfinal.php');
	};//Fim //Excluir cliente no site mas modifica

};
/*########################FIM Se usuario Existir###################*/

};//Fim Token validado com sucesso
}; //Fim execu se existir um post
?>
