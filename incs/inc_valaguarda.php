<?php
//Inicio Se compra Aguardando Pagamento
if($statusTrasacao < 3){

	//Inclui array de pagamentos $pagamentosUsuario
  include_once('inc_pgs.php');

	//Atualiza no Banco os dados de pagamentos
	$gravaPagamentosAtualizado = serialize($pagamentosUsuario);
	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamentosAtualizado' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

	//var_dump($pagamentosUsuario);

};//FIM Se compra Aguardando Pagamento
?>
