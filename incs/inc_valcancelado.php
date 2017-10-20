<?php
	//Se compra Cancelada
	if($statusTrasacao >= 6){
		//Excluir cliente no site mas modifica
		if($clienteNoSite == 'excluirCliente'){
			$wpdb->query("DELETE FROM $wpdb->users WHERE ID = '$idUsuario'");
			$wpdb->query("DELETE FROM $wpdb->usermeta WHERE user_id = '$idUsuario'");
			exit;
		}//Fim //Excluir cliente no site mas modifica


		//Mantem cliente no site mas modifica
		if($clienteNoSite != 'excluirCliente'){
			//unset($capacidadesGeral['access_optimizemember_ccap_produto2']);

			//Loop para encontrar o intem do pacote
			foreach($pacoteProd as $itemCap){
			$verificaCapacidade = array_key_exists($itemCap,$capacidadesGeral);

			//Se encontrar a capacidade, ele ira remover
			if($verificaCapacidade){
				unset($capacidadesGeral[$itemCap]);
			};

		};//Fim FOREACH loop para encontrar o intem do pacote

		var_dump($capacidadesGeral);
		var_dump($nivelAtualGeral);

		if(count($capacidadesGeral) < 2){
			$capacidadesGeral = '';
			$capacidadesGeral['subscriber'] = true;
		}

		$capacidadeCancela = serialize($capacidadesGeral);
		$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeCancela' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");

		//var_dump($capacidadesGeral);

		 include_once('inc_eottime.php');

		$pacoteProdGrava = serialize($pacoteProd);
		$pagamentosUsuario[$tipoProd][$idTransacao]['statusTrasacao'] = $statusTrasacao;
		$pagamentosUsuario[$tipoProd][$idTransacao]['statusCompra'] = $statusCompra;
		$pagamentosUsuario[$tipoProd][$idTransacao]['dataCancela'] = $dataGrava;
		$gravaPagamentosCancelado = serialize($pagamentosUsuario);

		//var_dump($pagamentosUsuario);

		//Atualiza no Banco os dados de pagamentos
		$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamentosCancelado' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

		};//FIM Mantem cliente no site mas modifica

	};//FIM Se compra Cancelada
?>
