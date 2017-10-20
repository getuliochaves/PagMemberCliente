<?php
global $wpdb;
$nomeEOT = $base_prefixo.'optimizemember_paid_registration_times';
$nomeAutoEOT = $base_prefixo.'optimizemember_auto_eot_time';
//Define um array pra data Agora
$dataAgoraEOT = time();

//Executa somente se o eot estiver ativado
if($eotCli == 'Ativar'){

  $pegaEOT = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = '$nomeEOT'");
  $pegaEOT = unserialize($pegaEOT);
  $nTimeDB = $pegaEOT['level'];

  //SE for Aprovado
  if($statusTrasacao == 3){
    $nTimeNovo = $nTimeDB + (86400 * $eotProd);
    $gdNTime = array('level' => $nTimeNovo, $nivelProd => $nTimeNovo);


    $grNtimeFinal = serialize($gdNTime);
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$grNtimeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$nomeEOT'");
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$nTimeNovo' WHERE user_id = '$idUsuario' AND meta_key = '$nomeAutoEOT'");

    $pegaAutoEOT = $wpdb->get_var("SELECT umeta_id FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = '$nomeAutoEOT'");
    if(count($pegaAutoEOT) == 0){
      $wpdb->insert($wpdb->usermeta, array('meta_key' => $nomeAutoEOT,'meta_value' => $nTimeNovo, 'user_id' => $idUsuario));
    }else{
      $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$nTimeNovo' WHERE user_id = '$idUsuario' AND meta_key = '$nomeAutoEOT'");
    }



  }; //FIM SE for Aprovado




  //SE for cacenlado
  if($statusTrasacao >= 6){

    $dataCompra = $pagamentosUsuario[$tipoProd][$idTransacao]['dataGrava'];
    $totalComprado = $pagamentosUsuario[$tipoProd][$idTransacao]['eotProd'];

    $totalComprado = $totalComprado - 1;

    $dCompra = strtotime($dataCompra);
    $diasPassados = $dCompra - $dataAgoraEOT;
    $diasASerReduzidos = ($totalComprado * 86400) - $diasPassados;

    $nTimeDB = $pegaEOT['level'];

    $nTimeNovo = $nTimeDB - $diasASerReduzidos;
    $gdNTime = array('level' => $nTimeNovo, $nivelProd => $nTimeNovo);

    $grNtimeFinal = serialize($gdNTime);
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$grNtimeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$nomeEOT'");
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$nTimeNovo' WHERE user_id = '$idUsuario' AND meta_key = '$nomeAutoEOT'");



  };//FIM  SE for cacenlado
};//FIM somente se o eot estiver ativado
?>
