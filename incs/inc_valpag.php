<?php
	//Faz uma busca no banco de dados pelos pagamentos
	$pegaPagamentosUsuario = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

	$contaPagamentos = count($pegaPagamentosUsuario);
	//Se nao existe o item de pagamentos ele irá criar com os dados atuais
	if($contaPagamentos == 0){

		//Inclui array de pagamentos $pagamentosUsuario
	  include_once('inc_pgs.php');

	//Serializa os pagamentos
	$pagamentosUsuario = serialize($pagamentosUsuario);
	//Grava com os dados atuais
	$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'pagamentosPM','meta_value' => $pagamentosUsuario));
	}//FIM Se nao existe o item de pagamentos
	//Faz novamente a busca por pagamentos
	$pegaPagamentosUsuario = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

	//Pega dados do Pagamento já gravado
	$pagamentosUsuario = unserialize($pegaPagamentosUsuario);
	//Coloca tudo na variavel dadosPagamento
	$dadosPagamento = $pagamentosUsuario[$tipoProd][$idTransacao];

	//var_dump($dadosPagamento);
?>
