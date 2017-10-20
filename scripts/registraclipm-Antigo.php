<?php
require_once('wp-load.php');
global $wpdb;
//Define a base do Prefixo das tabelas
$base_prefixo = $wpdb->base_prefix;
//Nome de busca capacidades
$capacidades = $base_prefixo.'capabilities';
//Data atual
$dataGrava = date('d-m-Y');
//Recebe todos os dados do Post
$newUserConfirm = $_POST['newUserConfirm'];
//Excuta somente se existir um POST
if(isset($_POST) && $newUserConfirm == 'newUserConfirm'){
$token = $_POST['token'];
$tipoProd = $_POST['tipoProd'];
$valorProd = $_POST['valorProd'];
$statusTrasacao = $_POST['statusTrasacao'];
$statusCompra = $_POST['statusCompra'];
$nomeProd = $_POST['nomeProd'];
$idProd = $_POST['idProd'];
$emailCli = $_POST['emailCli'];
$senhaUsu = $_POST['senhaUsu'];
$pacoteProd = $_POST['pacoteProd'];
$nomeCli = $_POST['nomeCli'];
$userGratis = $_POST['userGratis'];
$nivelProd = $_POST['nivelProd'];
$nivelProdAguarda = $_POST['nivelProdAguarda'];
$clienteNoSite = $_POST['clienteNoSite'];
$eotCli = $_POST['eotCli'];
$eotProd = $_POST['eotProd'];
$idTransacao = $_POST['idTransacao'];

$pacoteProd = base64_decode($pacoteProd);
//echo $pacoteProd;

/*Dados retornado
$newUserConfirm = 'newUserConfirm';
$token = '204F42AA2C9C45C3A1490CD845EE3B9C';
$tipoProd = 'PagSeguro';
$tipoProd2 = 'Hotmart';
$valorProd = '97,90';
$statusTrasacao = '7';
//$statusCompra = 'Agurdando Pagamento';
$statusCompra = 'Cancelado';
//$statusCompra = 'Aprovado';
$nomeProd = 'Bem Vindo';
$idProd = '99';
//$emailCli = 'setordigital@gmail.com';
$emailCli = 'setor8@gmail.com';

$senhaUsu = '4146cc94cd';
$pacoteProd = 'a:2:{i:0;s:33:"access_optimizemember_ccap_wpages";i:1;s:36:"access_optimizemember_ccap_pagmember";}';
//$pacoteProd2 = 'a:2:{i:0;s:35:"access_optimizemember_ccap_optimize";i:1;s:34:"access_optimizemember_ccap_gdaulas";}';
$nomeCli = 'Ariana Chaves';
$userGratis = 'Permitir';
$nivelProd = 'optimizemember_level5';
$nivelProdAguarda = 'optimizemember_level1';
//$clienteNoSite = 'manterCliente';
$clienteNoSite = 'manterCliente';
$eotCli = 'Ativar';
$eotProd = '30';
//$idTransacao = '99999988777';
$idTransacao = '66775533';

//$idTransacao = '66775777788899';

//$idTransacao2 = '99999988700';
*/
//Monta Busca do Token
$montaBuscaToken = 'tokenPagMemberCliente#'.$tipoProd;
//Pega token do Banco
$pegaToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$montaBuscaToken'");

//Compara o Token com o Token Recebido, para executar a ação
if($pegaToken == $token){
//Pega o Id do Usuário
$idUsuario = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '$emailCli'");
//Conta se o usuário existe
$contaUsuario = count($idUsuario);


$sobrenomeCli = explode(' ',$nomeCli);
$primeiroNome = $sobrenomeCli[0];
$sobrenomeCli = $sobrenomeCli[1];

$pacoteProd = unserialize($pacoteProd);
$contaPacoteProd = count($pacoteProd);

//var_dump($pacoteProd);

/* ################QUANDO O USUÁRIO EXISTE#################### */
//Executa se o usuário existe
if($contaUsuario > 0){
	//Pega os dados do Usuário Existe
	global $current_user;
	$user_info = get_userdata($idUsuario);
	$niveisdeacessoGeral = $user_info->allcaps;	//Retorna niveis e capacidades permitidas
	$capacidadesGeral = $user_info->caps; //Retorna as capacidades
	$nivelAtualGeral2 = $user_info->roles; //retorna o nível atual
	//Foreach pra colocar o nivel atual numa string

	//var_dump($capacidadesGeral);

	foreach($nivelAtualGeral2 as $nivelAtualGeral1){
		$nivelAtualGeral = $nivelAtualGeral1;
	}//FIM Foreach pra colocar o nivel atual numa string

	//Faz uma busca no banco de dados pelos pagamentos
	$pegaPagamentosUsuario = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

	$pegaCliente = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'clientePagMember'");


	if(count($pegaCliente) == 0){
		$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'clientePagMember','meta_value' => 'sim'));
	}else{
		$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = 'sim' WHERE user_id = '$idUsuario' AND meta_key = 'clientePagMember'");
	}



	$contaPagamentos = count($pegaPagamentosUsuario);
	//Se nao existe o item de pagamentos ele irá criar com os dados atuais
	if($contaPagamentos == 0){
	//Monta array de pagamentos
	$pacoteProdInicio = serialize($pacoteProd);
	$pagamentosUsuario[$tipoProd][$idTransacao]['nomeProd'] = $nomeProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['idProd'] = $idProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['valorProd'] = $valorProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusTrasacao'] = $statusTrasacao;
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusCompra'] = $statusCompra;
	$pagamentosUsuario[$tipoProd][$idTransacao]['tipoProd'] = $tipoProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['idTransacao'] = $idTransacao;
	$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProd'] = $nivelProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProdAguarda'] = $nivelProdAguarda;
	$pagamentosUsuario[$tipoProd][$idTransacao]['userGratis'] = $userGratis;
	$pagamentosUsuario[$tipoProd][$idTransacao]['pacoteProd'] = $pacoteProdInicio;
	$pagamentosUsuario[$tipoProd][$idTransacao]['dataGrava'] = $dataGrava;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotCli'] = $eotCli;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotProd'] = $eotProd;


	$pagamentosUsuario = serialize($pagamentosUsuario);
	//Grava com os dados atuais
	$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'pagamentosPM','meta_value' => $pagamentosUsuario));
	}//FIM Se nao existe o item de pagamentos

	//Faz novamente a busca por pagamentos
	$pegaPagamentosUsuario = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

	//Pega dados do Pagamento já gravado
	$pagamentosUsuario = unserialize($pegaPagamentosUsuario);
	$dadosPagamento = $pagamentosUsuario[$tipoProd][$idTransacao];



	//Retornar Capacidades do Usuário
	$pegaCapacidadesUsuario = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");
	$capacidadesUsu = unserialize($pegaCapacidadesUsuario);



	//var_dump($capacidadesUsu);



/*
###############################################################
                        COMPRA APROVADA
###############################################################
*/
if($statusTrasacao == 3){
		//Adiciona o Comando nível Unico
		$nivelUnico = $nivelProd;
		//Caso seja subscriber, adiciona o level0 pra pesquisa
		if($nivelProd == 'subscriber'){
			$nivelUnico = 'optimizemember_level0';
		}
		//Verifica se o Nivel Enviado já tem acesso a plataforma
		$verificaNivel = array_key_exists('access_'.$nivelUnico,$niveisdeacessoGeral);
		//var_dump($verificaNivel);
		//Se o nível não existir, ele vai colocar o usuário no nível
		if($verificaNivel == false){
			unset($capacidadesUsu[$nivelAtualGeral]);
			$capacidadesUsu[$nivelProd] = true;
		}

	//	var_dump($pacoteProd);

		//Faz um loop pelos pacotes, e verifica se existe os pacotes enviados

		//Executa o Foreach se existir pacotes
		if($contaPacoteProd > 0){

		foreach($pacoteProd as $itemCap){
		//Faz uma busca no array do pacote
			$verificaCapacidade = array_key_exists($itemCap,$capacidadesGeral);
			//Se o pacote não existe, adiciona o array capacidades
			if($verificaCapacidade == false){
				$capacidadesUsu[$itemCap] = true;
			};
		};//Fim Foreach pacotes

		};//Fim IF /Executa o Foreach se existir pacotes

		//Serialize as capacides
		$capacidadeFinal = serialize($capacidadesUsu);
		//Grava Atualiza o Usuário no banco
	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");

	//Inicia a montagem do array de pagamentos
	$pacoteProdGrava = serialize($pacoteProd);
	$pagamentosUsuario[$tipoProd][$idTransacao]['nomeProd'] = $nomeProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['idProd'] = $idProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['valorProd'] = $valorProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusTrasacao'] = $statusTrasacao;
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusCompra'] = $statusCompra;
	$pagamentosUsuario[$tipoProd][$idTransacao]['tipoProd'] = $tipoProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['idTransacao'] = $idTransacao;
	$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProd'] = $nivelProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProdAguarda'] = $nivelProdAguarda;
	$pagamentosUsuario[$tipoProd][$idTransacao]['userGratis'] = $userGratis;
	$pagamentosUsuario[$tipoProd][$idTransacao]['pacoteProd'] = $pacoteProdGrava;
	$pagamentosUsuario[$tipoProd][$idTransacao]['dataGrava'] = $dataGrava;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotCli'] = $eotCli;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotProd'] = $eotProd;

	$gravaPagamentosAtualizado = serialize($pagamentosUsuario);
	//Atualiza no Banco os dados de pagamentos
$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamentosAtualizado' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");
}//Fim transacao aprovada





/*
###############################################################
                        COMPRA 'ADA
###############################################################
*/



/*
###############################################################
                        COMPRA Aguardando
###############################################################
*/
if(($statusTrasacao == 1 && $userGratis == 'Permitir') or ($statusTrasacao == 2 && $userGratis == 'Permitir')){
		//Adiciona o Comando nível Unico
		$nivelUnico = $nivelProdAguarda;
		//Caso seja subscriber, adiciona o level0 pra pesquisa
		if($nivelProdAguarda == 'subscriber'){
			$nivelUnico = 'optimizemember_level0';
		}
		//Verifica se o Nivel Enviado já tem acesso a plataforma
		$verificaNivel = array_key_exists('access_'.$nivelUnico,$niveisdeacessoGeral);
		//var_dump($verificaNivel);
		//Se o nível não existir, ele vai colocar o usuário no nível
		if($verificaNivel == false){
			unset($capacidadesUsu[$nivelAtualGeral]);
			$capacidadesUsu[$nivelProdAguarda] = true;
		}

	//	var_dump($pacoteProd);

		//Faz um loop pelos pacotes, e verifica se existe os pacotes enviados

		/*Executa o Foreach se existir pacotes
		if($contaPacoteProd > 0){


		foreach($pacoteProd as $itemCap){
		//Faz uma busca no array do pacote
			$verificaCapacidade = array_key_exists($itemCap,$capacidadesGeral);
			//Se o pacote não existe, adiciona o array capacidades
			if($verificaCapacidade == false){
				$capacidadesUsu[$itemCap] = true;
			};
		};//Fim Foreach pacotes

		};//Fim IF /Executa o Foreach se existir pacotes
		*/

		//Serialize as capacides
		$capacidadeFinal = serialize($capacidadesUsu);
		//Grava Atualiza o Usuário no banco
	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");

	//Inicia a montagem do array de pagamentos
	$pacoteProdGrava = serialize($pacoteProd);
	$pagamentosUsuario[$tipoProd][$idTransacao]['nomeProd'] = $nomeProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['idProd'] = $idProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['valorProd'] = $valorProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusTrasacao'] = $statusTrasacao;
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusCompra'] = $statusCompra;
	$pagamentosUsuario[$tipoProd][$idTransacao]['tipoProd'] = $tipoProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['idTransacao'] = $idTransacao;
	$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProd'] = $nivelProd;
	$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProdAguarda'] = $nivelProdAguarda;
	$pagamentosUsuario[$tipoProd][$idTransacao]['userGratis'] = $userGratis;
	$pagamentosUsuario[$tipoProd][$idTransacao]['pacoteProd'] = $pacoteProdGrava;
	$pagamentosUsuario[$tipoProd][$idTransacao]['dataGrava'] = $dataGrava;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotCli'] = $eotCli;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotProd'] = $eotProd;

	$gravaPagamentosAtualizado = serialize($pagamentosUsuario);
	//Atualiza no Banco os dados de pagamentos
$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamentosAtualizado' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");
}//Fim transacao aprovada





/*
###############################################################
                       FIM COMPRA Aguardando
###############################################################
*/







//Inicio IF Se a compra for Cancelada
if($statusTrasacao == 6 or $statusTrasacao == 7){
	//Exclui o aluno site
	if($clienteNoSite == 'excluirCliente'){

		$wpdb->query("DELETE FROM $wpdb->users WHERE ID = '$idUsuario'");
		$wpdb->query("DELETE FROM $wpdb->usermeta WHERE user_id = '$idUsuario'");
	};

	//Mantem cliente no site mas modifica
	if($clienteNoSite != 'excluirCliente'){
		//Faz um loop pelos pacotes, e verifica se existe os pacotes enviados
		foreach($pacoteProd as $itemCap){

				//Faz uma busca no array do pacote
			$verificaCapacidade = array_key_exists($itemCap,$capacidadesGeral);
			//Se o pacote não existe, adiciona o array capacidades



			if($verificaCapacidade == true){
				unset($capacidadesUsu[$itemCap]);
				//$capacidadesUsu[$itemCap] = true;
			}
		}//Fim Foreach pacotes




		var_dump($capacidadesUsu);

		//Conta as capacidades restantes
		$contaCapacidades = count($capacidadesUsu);
	//	var_dump($contaCapacidades);
		//Se as capacidades forem menores ou igual a 1
		if($contaCapacidades <= 1){
			unset($capacidadesUsu[$nivelAtualGeral]);
			$capacidadesUsu['subscriber'] = true;
		}

		//serialize dos dados
		$capacidadeCancela = serialize($capacidadesUsu);
		//Grava no no usuário
	//	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeCancela' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");


	//Inicia a montagem do array de pagamentos cabcelado
	$pacoteProdGrava = serialize($pacoteProd);
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusTrasacao'] = $statusTrasacao;
	$pagamentosUsuario[$tipoProd][$idTransacao]['statusCompra'] = $statusCompra;
	$pagamentosUsuario[$tipoProd][$idTransacao]['dataCancela'] = $dataGrava;
	$gravaPagamentosCancelado = serialize($pagamentosUsuario);

	//var_dump($gravaPagamentosCancelado);

	//Atualiza no Banco os dados de pagamentos
//	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamentosCancelado' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");







	};	//FIM IF Manter Usuário

};//FIM IF Se a compra for Cancelada


########################################################################
//Valida final
########################################################################






	$base_prefixo = $wpdb->base_prefix;
	//Nome de busca capacidades
	$NomeMetaCapacidades = $base_prefixo.'capabilities';




	global $infoUsuario;
	$infoUsuario = get_userdata($idUsuario);
	$niveisAcesso = $infoUsuario->allcaps;
	$capacidades = $infoUsuario->caps;

	$nivelAtualGeral2 = $infoUsuario->roles; //retorna o nível atual
	//Foreach pra colocar o nivel atual numa string

	//var_dump($capacidadesGeral);

	foreach($nivelAtualGeral2 as $nivelAtualGeral1){
		$nivelAtualGeral = $nivelAtualGeral1;
	}//FIM Foreach pra colocar o nivel atual numa string

	//var_dump($nivelAtualGeral);


	$pegaPagamentosUsuario = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");



	//INICIo conta se existe a meta pagamentosPM
	if(count($pegaPagamentosUsuario) > 0){
	//Pega dados do Pagamento já gravado
	$pagamentosUsuario = unserialize($pegaPagamentosUsuario);


	//Foreach Geral
	foreach($pagamentosUsuario as $idTransacao){

		//var_dump($pagamentosUsuario);

		//var_dump($idTransacao);
		//INICIO Foreach ID da transacao

	//	var_dump($idTransacao);

		foreach($idTransacao as $dadosCompra){
			$statusCompra = $dadosCompra[statusCompra];
			$nivelProd = $dadosCompra[nivelProd];
			$tipoProd = $dadosCompra[tipoProd];
			$pacoteProd = $dadosCompra[pacoteProd];
			$idTransacao = $dadosCompra[idTransacao];
			$dataGrava = $dadosCompra[dataGrava];
			$statusUsuarioT = $dadosCompra[statusUsuarioT];
			$statusTrasacao = $dadosCompra[statusTrasacao];
			$clienteNoSite = $dadosCompra[clienteNoSite];

			//var_dump($dadosCompra);

			$pacoteProd = unserialize($pacoteProd);


		//	var_dump($pacoteProd );
			$contaPacote = count($pacoteProd);
			if($contaPacote > 0 && $pacoteProd != false && $pacoteProd != ''){//IF Conta Pacotes


				foreach($pacoteProd as $itensCap){//Inciio Foreach Verifica
					$verificaPacote = array_key_exists($itensCap,$niveisAcesso);


					if($statusTrasacao == 3){
						$arrayCapsAprovadas[$itensCap] = true;
					};



					if($statusTrasacao == 6 or $statusTrasacao == 7){
						$arrayCapsCanceladas[$itensCap] = true;
					};

					//if(strtotime($ultimaData) > strtotime($dataGrava)){
					//}
					}//Fim Foeach Verifica


			}//Fim IF conta pacotes


			$verificaNivel = array_key_exists('access_'.$nivelProd,$niveisAcesso);
	//		var_dump($verificaNivel);
		//	var_dump($nivelAtualGeral);

			if($verificaNivel == false){
				unset($capacidades[$nivelAtualGeral]);
				$capacidades[$nivelProd] = true;
				}

		//	var_dump($pacoteProd);
			};//FIM Foreach ID da transacao
	};//FIM Foreach Geral

	if(count($arrayCapsCanceladas) > 0){
	foreach($arrayCapsCanceladas as $cancelados => $valor){
		//var_dump($chaveCancelados);
		$verificaCancelados = array_key_exists($cancelados,$niveisAcesso);
		//var_dump($verificaCancelados);
		if($verificaCancelados == true){
			unset($capacidades[$cancelados]);
		}

	}
	}//Fim conta cancelados

	//$con = count($arrayCapsAprovadas);
	//var_dump($con);
	//CapsAprovadas
	if(count($arrayCapsAprovadas) > 0){


	foreach($arrayCapsAprovadas as $aprovados => $valor){
		//var_dump($aprovados);
		$verificaAprovados = array_key_exists($aprovados,$niveisAcesso);
	//	var_dump($verificaAprovados);
		//var_dump($statusTrasacao);
		if($verificaAprovados == false){
			$capacidades[$aprovados] = true;
		}

		if($verificaAprovados == true && $statusTrasacao == 3){
		//var_dump($aprovados);
		//echo 'Chegou aqui 2';
			$capacidades[$aprovados] = true;
		}


	}//Fim Foreach
	}//Fim Conta CapsAprovadas

	//unset($capacidades['optimizepress_level8']);

	//var_dump($capacidades);

	$novaCapacidades = serialize($capacidades);



	//Grava as capacidades
	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$novaCapacidades' WHERE user_id = '$idUsuario' AND meta_key = '$NomeMetaCapacidades'");


	};//Fim conta se existe a meta pagamentosPM

	$verificaUsuarioPM2['verificacao']=0;
	$gravaVerifica2 = serialize($verificaUsuarioPM2);
	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaVerifica2' WHERE user_id = '$idUsuario' AND meta_key = 'verificaUsuarioPM'");



########################################################################
//FIM Valida final
########################################################################
};//FIM Executa se o usuário existe
/* ################QUANDO O USUÁRIO NÃO EXISTE#################### */
//Executa se o usuário Nao existe
if($contaUsuario == 0){



	if(($statusTrasacao == 1 && $userGratis == 'Permitir') or ($statusTrasacao == 2 && $userGratis == 'Permitir')){
		//Se estiver aguardando pagamento e o tiver permitindo usuário grátis
		echo 'Aqui aguarda pagamento';
		$dadosNovoUsuario =  array(
				 'first_name'  =>  $primeiroNome,
				 'user_email'  =>  $emailCli,
				 'display_name' => $nomeCli,
				 'last_name'   =>  $sobrenomeCli,
    			 'user_login'  =>  $emailCli,
   				 'user_pass'   =>  $senhaUsu,
		);

		$pacoteProdGrava = serialize($pacoteProd);
		$pagamentosUsuario[$tipoProd][$idTransacao]['nomeProd'] = $nomeProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['idProd'] = $idProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['valorProd'] = $valorProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['statusTrasacao'] = $statusTrasacao;
		$pagamentosUsuario[$tipoProd][$idTransacao]['statusCompra'] = $statusCompra;
		$pagamentosUsuario[$tipoProd][$idTransacao]['idTransacao'] = $idTransacao;
		$pagamentosUsuario[$tipoProd][$idTransacao]['tipoProd'] = $tipoProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProd'] = $nivelProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProdAguarda'] = $nivelProdAguarda;
		$pagamentosUsuario[$tipoProd][$idTransacao]['userGratis'] = $userGratis;
		$pagamentosUsuario[$tipoProd][$idTransacao]['pacoteProd'] = $pacoteProdGrava;
		$pagamentosUsuario[$tipoProd][$idTransacao]['dataGrava'] = $dataGrava;
		$pagamentosUsuario[$tipoProd][$idTransacao]['eotCli'] = $eotCli;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotProd'] = $eotProd;
		//var_dump($pagamentosUsuario);
		//Adiciona o Usuário
		$idUsuario = wp_insert_user($dadosNovoUsuario);
		//Adiciona Senha padrao no perfil do usuario
		$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'senhaClientePagMember','meta_value' => $senhaUsu));
		//Adicona as meta com os dados do pagamento
		$pagamentosUsuarioInicial = serialize($pagamentosUsuario);
		$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'pagamentosPM','meta_value' => $pagamentosUsuarioInicial));

		//add_user_meta($idUsuario, 'pagamentosPM', $pagamentosUsuarioInicial);
		//Atualiza o nível do usuário, com a opção de aguarda pagamento
		$nivelAguarda[$nivelProdAguarda] = true;
		$capacidadeInicial = serialize($nivelAguarda);
$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeInicial' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");


		//var_dump($dadosNovoUsuario);



		//$idUsuario = wp_insert_user($newUserDados);


	}














	/*
###############################################################
                        COMPRA APROVADA
###############################################################
*/
if($statusTrasacao == 3){

		//echo 'O total de pacotes é: '.$contaPacoteProd;

		$dadosNovoUsuario =  array(
				 'first_name'  =>  $primeiroNome,
				 'user_email'  =>  $emailCli,
				 'display_name' => $nomeCli,
				 'last_name'   =>  $sobrenomeCli,
    			 'user_login'  =>  $emailCli,
   				 'user_pass'   =>  $senhaUsu,
		);

		$pacoteProdGrava = serialize($pacoteProd);
		$pagamentosUsuario[$tipoProd][$idTransacao]['nomeProd'] = $nomeProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['idProd'] = $idProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['valorProd'] = $valorProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['statusTrasacao'] = $statusTrasacao;
		$pagamentosUsuario[$tipoProd][$idTransacao]['statusCompra'] = $statusCompra;
		$pagamentosUsuario[$tipoProd][$idTransacao]['tipoProd'] = $tipoProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['idTransacao'] = $idTransacao;
		$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProd'] = $nivelProd;
		$pagamentosUsuario[$tipoProd][$idTransacao]['nivelProdAguarda'] = $nivelProdAguarda;
		$pagamentosUsuario[$tipoProd][$idTransacao]['userGratis'] = $userGratis;
		$pagamentosUsuario[$tipoProd][$idTransacao]['pacoteProd'] = $pacoteProdGrava;
		$pagamentosUsuario[$tipoProd][$idTransacao]['dataGrava'] = $dataGrava;
		$pagamentosUsuario[$tipoProd][$idTransacao]['eotCli'] = $eotCli;
	$pagamentosUsuario[$tipoProd][$idTransacao]['eotProd'] = $eotProd;
		//Adiciona o Usuário
		$idUsuario = wp_insert_user($dadosNovoUsuario);
		$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'senhaClientePagMember','meta_value' => $senhaUsu));
		//Monta os Pacotes
		if($contaPacoteProd > 0 && $pacoteProd != false){
			foreach($pacoteProd as $itemCap){
			$capacidadesNovoUsuario[$itemCap] = true;
			}
		}
		//Monta o Nível
		$capacidadesNovoUsuario[$nivelProd] = true;
		$capacidadeInicial = serialize($capacidadesNovoUsuario);

		//Adicona as meta com os dados do pagamento
		$pagamentosUsuarioInicial = serialize($pagamentosUsuario);
		$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'pagamentosPM','meta_value' => $pagamentosUsuarioInicial));

		//Atualiza o nível do usuário, com a opção de aguarda pagamento
		$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeInicial' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");
}//Fim transacao aprovada
};//FIM Executa se o usuário Nao existe

$verificaUsuarioPM['verificacao']=0;
$gravaVerifica = serialize($verificaUsuarioPM);
$verificaUsuarioPM = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'verificaUsuarioPM'");

if(count($verificaUsuarioPM) == 0){
$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'verificaUsuarioPM','meta_value' => $gravaVerifica));
}else{
$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaVerifica' WHERE user_id = '$idUsuario' AND meta_key = 'verificaUsuarioPM'");
}

$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'clientePagMember','meta_value' => 'sim'));

};//FIM Compara o Token com o Token Recebido, para executar a ação
};//FIM Excuta somente se existir um POST
?>
