<?php
//Cria usuario gratuito se o status da transacao for menor que 3 e usuario gratuito estiver ativadao
if(($statusTrasacao < 3 && $userGratis == 'Permitir') or ($statusTrasacao == 3)){
  if($statusTrasacao < 3){
    //monta Nivel aprovado
    $nivelUsuarioGrava2 = $nivelProdAguarda;
    //Monta array para atualizar
    $nivelUsuarioGrava[$nivelProdAguarda] = true;
  }else{
    //monta Nivel aprovado
    $nivelUsuarioGrava2 = $nivelProd;
    //Monta array para atualizar os pacotes
    $nivelUsuarioGrava[$nivelProd] = true;
    //if conta se tem 1 pacote ou mais
    if(count($pacoteProd) > 0){
      //FOREACH se tiver, inicia a verredura pelos pacotes
      foreach($pacoteProd as $lspacotes){
        $nivelUsuarioGrava[$lspacotes] = true;
      };//FIM //FOREACH se tiver, inicia a verredura pelos pacotes
    };//FIM //if conta se tem 1 pacote ou mais

  };
  //Cria um array com os dados vido do processador de pagamentos

  $dadosNovoUsuario =  array(
    'first_name'  =>  $primeiroNome,
    'user_email'  =>  $emailCli,
    'display_name' => $nomeCli,
    'last_name'   =>  $sobrenomeCli,
    'user_login'  =>  $emailCli,
    'user_pass'   =>  $senhaUsu,
    'role'        =>  $nivelUsuarioGrava2
  );

  //Insere o usuario
  $idUsuario = wp_insert_user($dadosNovoUsuario);

  //Inclui array de pagamentos $pagamentosUsuario
  include_once('inc_pgs.php');

  //Atualiza no Banco os dados de pagamentos
  $gravaPagamentosAtualizado = serialize($pagamentosUsuario);
  $wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'pagamentosPM','meta_value' => $gravaPagamentosAtualizado));

  //Define que é um cliente pagmember
  $wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'clientePagMember','meta_value' => 'sim'));

  //Adiciona Senha padrao no perfil do usuario
  $wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'senhaClientePagMember','meta_value' => $senhaUsu));

  include_once('inc_eottime.php');
  /*$dataAgoraEOT = time();
  $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$dataAgoraEOT' WHERE user_id = '$idUsuario' AND meta_key = 'wp_optimizemember_auto_eot_time'");

  //$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'Teste','meta_value' => 'Valor do Teste'));
 */

  //Atualiza as capacidades
  $capacidadeInicial = serialize($nivelUsuarioGrava);
  $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeInicial' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");

  };//Fim //Cria usuario gratuito se o status da transacao for menor que 3 e usuario gratuito estiver ativadao

?>
