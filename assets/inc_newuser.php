<?php
global $wpdb;
echo '<div style="margin:0 auto; text-align:center; width:100%;">
<h3>Atualizando Banco de Dados, por favor aguarde!</h3>;
<img src="'.$pastaImg.'loading.gif" align="center"/>
</div>';

$metasUsuario = array('IDTransacaoPagMember',
'PrecoPagMember',
'DataCompraPagMember',
'StatusCompraPagMember',
'clientePagMember',
'TipoPagamentoPagMember',
);

$pegaUsuario = $wpdb->get_results("SELECT ID FROM $wpdb->users");
//Inicio Foreach Lista IDs
foreach ($pegaUsuario as $dadosU => $dadosUID) {
 $idUsuario = $dadosUID->ID;
//Inicio se é cliente
 $pegaClientePagMember = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'clientePagMember' AND user_id = '$idUsuario'");
 if($pegaClientePagMember == 'sim'){
   $pagamentosUsuario = '';

 foreach ($metasUsuario as $meta) {
   $pm[$meta] = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = '$meta' AND user_id = '$idUsuario'");
 };


 $infoUsuario = get_userdata($idUsuario);
 $niveisAcesso = $infoUsuario->allcaps;
 $capacidades = $infoUsuario->caps;
 $nivelAtualGeral2 = $infoUsuario->roles;
 foreach($nivelAtualGeral2 as $nivelAtualGeral1){
   $nivelAtualGeral = $nivelAtualGeral1;
 }//FIM Foreach pra colocar o nivel atual numa string

 $mCaps = $capacidades;

 foreach ($mCaps as $aCAP) {
   unset($mCaps[$nivelAtualGeral]);
 }

$pmEOT = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'wp_optimizemember_auto_eot_time' AND user_id = '$idUsuario'");
if($pmEOT == ''){
  $eotCli = 'naoAtivar';
  $eotProd = '';
}else{
  $eotCli = 'Ativar';
  $eotProd = '';
}


  $valorProd = $pm['PrecoPagMember'];
  $tipoProd = $pm['TipoPagamentoPagMember'];
  $idTransacao = $pm['IDTransacaoPagMember'];
  $dataGrava = $pm['DataCompraPagMember'];
  $nivelProd = $nivelAtualGeral;
  $nivelProdAguarda = 'subscriber';
  $userGratis = 'Permitir';


$pacoteProdGrava2 = array('');
if($mCaps != false){
  //var_dump($mCaps);
  $ct = 0;
  foreach ($mCaps as $nomepacote => $valorP) {
    if(!in_array($nomepacote, $pacoteProdGrava2)){
      $pacoteProdGrava2[$ct] = $nomepacote;
      $ct++;
    }
  }



}
  $pacoteProdGrava = serialize($pacoteProdGrava2);

  switch ( $pm['StatusCompraPagMember']) {
  case 'Aprovado':
  $statusTrasacao = 3;
  $statusCompra = 'Aprovado';
  break;
  case 'Aguardando Pagamento':
  $statusTrasacao = 1;
  $statusCompra = 'Aprovado';
  break;
  case 'Aguardando Pagto':
  $statusTrasacao = 1;
  $statusCompra = 'Aguardando Pagamento';
  break;
  case 'Upgrade':
  $statusTrasacao = 3;
  $statusCompra = 'Aprovado';
  break;
  case 'Devolvido':
  $statusTrasacao = 6;
  $statusCompra = 'Aguardando Pagamento';
  break;
  case 'Cancelado':
  $statusTrasacao = 6;
  $statusCompra = 'Aguardando Pagamento';
  break;
  case 'Cancelada':
  $statusTrasacao = 6;
  $statusCompra = 'Aguardando Pagamento';
  break;
  default:
  $statusTrasacao = 1;
  $statusCompra = 'Aprovado';
  break;
  }

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
 $wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'pagamentosPM','meta_value' => $gravaPagamentosAtualizado));
// var_dump($pagamentosUsuario);

 };//Fim se é cliente

};

echo '<meta http-equiv="refresh" content="3; url=admin.php?page=pagmemberCliente">';

?>
