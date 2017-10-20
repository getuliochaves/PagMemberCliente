<?php
$diretorioR = ABSPATH;
$diretorioCopy = ABSPATH.'wp-content/plugins/PagMemberCliente/scripts/';

//gera o arquivo de origem
$caminhoRegCopy = $diretorioCopy.'registraclipm.php';
$caminhoTestCopy = $diretorioCopy.'testclipm.php';

//Gera o arquivo destino
$destinoRegCopy = $diretorioR.'registraclipm.php';
$destinoTestCopy = $diretorioR.'testclipm.php';

//Caso nao exista, cria o arquivo
if(!file_exists($diretorioR.'/registraclipm.php')){
copy($caminhoRegCopy, $destinoRegCopy);
}
if(!file_exists($diretorioR.'/testclipm.php')){
copy($caminhoTestCopy, $destinoTestCopy);
}

//Pega Versao do banco de dados
$pegaVersaoBanco = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'ultimaVersaoArquivosPM'");

//se a versao for diferente atualiza os arquivos
if(count($pegaVersaoBanco) > 0 && $pegaVersaoBanco != $versaoPlugin){
$atualizaVersaoPlugin = $wpdb->query("UPDATE $wpdb->options SET option_value = '$versaoPlugin' WHERE option_name = 'ultimaVersaoArquivosPM'");
if(file_exists($diretorioR.'/testclipm.php')){
	unlink($destinoTestCopy);
}
if(file_exists($diretorioR.'/registraclipm.php')){
unlink($destinoRegCopy);
}
copy($caminhoRegCopy, $destinoRegCopy);
copy($caminhoTestCopy, $destinoTestCopy);
}

//Se não existir o item ultima versao, cria os arquivos
if(count($pegaVersaoBanco) == 0){
$gravaVersaoPlugin = $wpdb->insert($wpdb->options, array('option_name' => 'ultimaVersaoArquivosPM','option_value' => $versaoPlugin));	
}

?>