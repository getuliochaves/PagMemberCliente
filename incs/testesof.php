<?php
//Dados retornado

$newUserConfirm = 'newUserConfirm';
$token = 'EAD41B09E6B8486CADB9EBDF98434FFA';
//$token = '654321';
$tipoProd = 'PagSeguro';
//$tipoProd = 'Hotmart';
/*
$valorProd = '150,90';
$nomeProd = 'Produto 56';
$idProd = '81';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto6";}';
$statusTrasacao = '1';
$statusCompra = 'Aguardando Pagamento';
$nivelProd = 'contributor';
$idTransacao = '9880943';

*/

$valorProd = '420,90';
$nomeProd = 'Produto 7';
$idProd = '80';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto7";}';
$statusTrasacao = '3';
$statusCompra = 'Aprovado';
$nivelProd = 'contributor';
$idTransacao = '81310943';



/*
$valorProd = '420,90';
$nomeProd = 'Produto 7';
$idProd = '80';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto7";}';
$statusTrasacao = '3';
$statusCompra = 'Aprovado';
$nivelProd = 'contributor';
$idTransacao = '81310943';

*/
/*
$valorProd = '300,90';
$nomeProd = 'Produto PagSeguro';
$idProd = '58';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto9";}';
$statusTrasacao = '3';
$statusCompra = 'Aprovado';
$nivelProd = 'contributor';
$idTransacao = '750912';


/*
$valorProd = '55,90';
$nomeProd = 'Produo 1';
$idProd = '55';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto1";}';
$statusTrasacao = '6';
$statusCompra = 'Cancelada';
//$statusCompra = 'Aprovado';
$nivelProd = 'author';
$idTransacao = '77665599';

*/

/*

$valorProd = '97,90';
$nomeProd = 'Produo 2';
$idProd = '56';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto2";}';
$statusTrasacao = '3';
$statusCompra = 'Aprovado';
$nivelProd = 'contributor';
$idTransacao = '88773399';
*/


/*
$valorProd = '107,90';
$nomeProd = 'Produo 3';
$idProd = '57';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto3";}';
$statusTrasacao = '6';
$statusCompra = 'Cancelado';
$nivelProd = 'author';
$idTransacao = '33776655';

*/
/*
$valorProd = '110,90';
$nomeProd = 'Produo 4';
$idProd = '58';
$pacoteProd = 'a:1:{i:0;s:35:"access_optimizemember_ccap_produto4";}';
$statusTrasacao = '6';
$statusCompra = 'Cancelado';
$nivelProd = 'administrator';
$idTransacao = '2266554';
*/


$emailCli = 'setordigital20@gmail.com';
$senhaUsu = 'aa6a292dd6';
$nomeCli = 'Ariana Chaves';
$userGratis = 'Permitir';
$nivelProdAguarda = 'subscriber';
$clienteNoSite = 'manterCliente';
//$clienteNoSite = 'excluirCliente';

$eotCli = 'naoAtivar';
$eotProd = '';

//Sobrenome do Cliente
$sobrenomeCli = explode(' ',$nomeCli);
$primeiroNome = $sobrenomeCli[0];
$sobrenomeCli = $sobrenomeCli[1];

//Pacotes do cliente
$pacoteProd = unserialize($pacoteProd);
$contaPacoteProd = count($pacoteProd);
?>
