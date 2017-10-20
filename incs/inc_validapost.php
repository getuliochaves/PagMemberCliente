<?php

//Excuta somente se existir um POST
$token = $_POST['token'];
$tipoProd = $_POST['tipoProd'];
$valorProd = $_POST['valorProd'];
$statusTrasacao = $_POST['statusTrasacao'];
$statusCompra = $_POST['statusCompra'];
$nomeProd = $_POST['nomeProd'];
$idProd = $_POST['idProd'];
$emailCli = $_POST['emailCli'];
$senhaUsu = $_POST['senhaUsu'];
$pacoteProd = $_POST['pacoteProd'];
$nomeCli = $_POST['nomeCli'];
$userGratis = $_POST['userGratis'];
$nivelProd = $_POST['nivelProd'];
$nivelProdAguarda = $_POST['nivelProdAguarda'];
$clienteNoSite = $_POST['clienteNoSite'];
$eotCli = $_POST['eotCli'];
$eotProd = $_POST['eotProd'];
$idTransacao = $_POST['idTransacao'];

$pacoteProd = base64_decode($pacoteProd);

//Sobrenome do Cliente
$sobrenomeCli = explode(' ',$nomeCli);
$primeiroNome = $sobrenomeCli[0];
$sobrenomeCli = $sobrenomeCli[1];

//Pacotes do cliente
$pacoteProd = unserialize($pacoteProd);
$contaPacoteProd = count($pacoteProd);
 ?>
