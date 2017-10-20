<?php
	//Se compra Aprovada
	if($statusTrasacao == 3){

		  include_once('inc_eottime.php');


		//Caso seja subscriber, adiciona o level0 pra pesquisa
		if($nivelProd == 'subscriber'){
			$nivelUnico = 'optimizemember_level0';
		}else{
			$nivelUnico = $nivelProd;
		}
		//Verifica se o Nivel Enviado já tem acesso a plataforma
		$verificaNivel = array_key_exists('access_'.$nivelUnico,$niveisdeacessoGeral);
		if($verificaNivel == false){
			$verificaNivel = array_key_exists($nivelUnico,$niveisdeacessoGeral);
		}

		if($verificaNivel == false){
			unset($capacidadesGeral[$nivelAtualGeral]);
			$capacidadesGeral[$nivelProd] = true;
		}


		//Executa o Foreach se existir pacotes
		if(count($pacoteProd) > 0){
		foreach($pacoteProd as $itemCap){
		//Faz uma busca no array do pacote
			$verificaCapacidade = array_key_exists($itemCap,$capacidadesGeral);
			//Se o pacote não existe, adiciona o array capacidades
			if($verificaCapacidade == false){
				$capacidadesGeral[$itemCap] = true;
			};
		};//Fim Foreach pacotes
		};//Fim IF /Executa o Foreach se existir pacotes


		//Inclui array de pagamentos $pagamentosUsuario
	  include_once('inc_pgs.php');



		$capacidadeFinal = serialize($capacidadesGeral);
		$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");
		var_dump($capacidadesGeral);

		//Atualiza no Banco os dados de pagamentos
		$gravaPagamentosAtualizado = serialize($pagamentosUsuario);
		$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamentosAtualizado' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

		//$dataAgoraEOT = time();
		//update_user_meta( $idUsuario, 'wp_optimizemember_auto_eot_time', $dataAgoraEOT);


};//Fim transacao aprovada
?>
