<?php
//Inicio do Foreach lista pagamentos
foreach($pagamentosUsuario as $itemtransacoes){

  $statusTr = $itemtransacoes[statusTrasacao];
  $nivelPr = $itemtransacoes[nivelProd];
  $pacotesPr0 = $itemtransacoes[pacoteProd];
  $pacotesPr = unserialize($pacotesPr0);

  //Se a transação for aprovada, começa o lopp pelos pagamentos
  if($statusTr == 3){

    //Verifica se o Nivel Enviado já tem acesso a plataforma
    $verificaNivel = array_key_exists('access_'.$nivelPr,$niveisdeacessoGeral);

    //Faz outra verificacao sem a pre-nome 'access_'
    if($verificaNivel == false){
      $verificaNivel = array_key_exists($nivelPr,$niveisdeacessoGeral);
    };


    //Verifica se o Nivel Enviado já tem acesso a plataforma
    if($verificaNivel == false){

      //Se a variavel aCapacidade for diferente de vazia, apaga a ultima level de transacao. ex: author
      if($aCapacidade != ''){
        unset($capacidadesGeral[$aCapacidade]);
      }//FIm //Se a variavel aCapacidade for diferente de vazia, apaga a ultima level de transacao. ex: author

      //Apaga o nivel atual e adiciona a capacidade da transacao
      unset($capacidadesGeral[$nivelAtualGeral]);
      $capacidadesGeral[$nivelPr] = true;
      //Restaura a variaval aCapacidade
      $aCapacidade = $nivelPr;
    };

    


    //Executa o Foreach se existir pacotes
    if(count($pacotesPr) > 0){
    foreach($pacotesPr as $itemCap){
    //Faz uma busca no array do pacote
      $verificaCapacidade = array_key_exists($itemCap,$capacidadesGeral);
      //Se o pacote não existe, adiciona o array capacidades
      if($verificaCapacidade == false){
        $capacidadesGeral[$itemCap] = true;
      };
    };//Fim Foreach pacotes



    };//Fim IF /Executa o Foreach se existir pacotes



    /*array (size=2)
  'level' => int 1500388523
  'optimizemember_level5' => int 1500388523
18/07/2017
*/

  };//FIM   //Se a transação for aprovada, começa o lopp pelos pagamentos


};//Fim do Foreach lista pagamentos

//Grava as capacidades no Banco de dados
$capacidadeFinal = serialize($capacidadesGeral);
$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$capacidadeFinal' WHERE user_id = '$idUsuario' AND meta_key = '$capacidades'");


?>
