<?php
//Inicia a montagem do array de pagamentos
$pacoteProdGrava = serialize($pacoteProd);
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
?>
