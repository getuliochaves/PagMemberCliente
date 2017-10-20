<?php
$eotCli = $dadosGrava['eotCli'];
$eotProd = $dadosGrava['eotProd'];
$nomeEOT = $base_prefixo.'optimizemember_paid_registration_times';
$nomeAutoEOT = $base_prefixo.'optimizemember_auto_eot_time';
//Define um array pra data Agora
$dataAgoraEOT = time();
//Se $eotCli for Ativar, ele manipula o EOT TIme


//var_dump($eotCli);

if($eotCli == 'Ativar'){
  $pegaAutoEOT = $wpdb->get_var("SELECT umeta_id FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = '$nomeAutoEOT'");

  $pegaEOT2 = $wpdb->get_var("SELECT umeta_id FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = '$nomeEOT'");

  $pegaEOT = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = '$nomeEOT'");
  $pegaEOT = unserialize($pegaEOT);

  //var_dump($pegaEOT2);

  //Se existir EOT time,
  if(count($pegaEOT) > 0){

    $nTimeDB = $pegaEOT['level'];
    $nTimeNovo = $nTimeDB + ((60 * 60 * 24) * $eotProd);

    $gdNTime = array('level' => $nTimeNovo, $nivelPr => $nTimeNovo);

    $grNtimeFinal = serialize($gdNTime);
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$grNtimeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$nomeEOT'");

    if(count($pegaAutoEOT) == 0){
      $wpdb->insert($wpdb->usermeta, array('meta_key' => $nomeAutoEOT,'meta_value' => $nTimeNovo, 'user_id' => $idUsuario));
    }else{
      $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$nTimeNovo' WHERE user_id = '$idUsuario' AND meta_key = '$nomeAutoEOT'");
    }

  //Fim se existir EOT time,
  }else{
    //Se não exitir EOT TIme
    $nTimeNovo = $dataAgoraEOT + ((60 * 60 * 24) * $eotProd);
    $gdNTime =  array('level' => $nTimeNovo, $nivelPr => $nTimeNovo);

    $grNtimeFinal = serialize($gdNTime);

    if(count($pegaEOT2) == 0){
    $wpdb->insert($wpdb->usermeta, array('meta_key' => $nomeEOT,'meta_value' => $grNtimeFinal, 'user_id' => $idUsuario));
  }else{
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$grNtimeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$nomeEOT'");
  }

  if(count($pegaAutoEOT) == 0){
    $wpdb->insert($wpdb->usermeta, array('meta_key' => $nomeAutoEOT,'meta_value' => $nTimeNovo, 'user_id' => $idUsuario));
  }else{
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$nTimeNovo' WHERE user_id = '$idUsuario' AND meta_key = '$nomeAutoEOT'");
  }


  };//FIM Se não exitir EOT TIme

};//FIm Se $eotCli for Ativar, ele manipula o EOT TIme

?>
