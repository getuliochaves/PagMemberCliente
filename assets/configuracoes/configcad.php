<?php
global $wpdb;
$tipoToken = $_GET['tipoToken'];
$txtCad = 'Cadastrando Tokem do '.$tipoToken;
$nomeToken = 'tokenPagMemberCliente#'.$tipoToken;
$itemToken = $_POST['itemToken'];
if($itemToken == ''){
	$itemToken = '0';
	}
$msgenvio = 'Tokem Envio Gravado com Sucesso. Estamos redirecionamento para a lista de Tokens Cadastrados.';

$grava = $wpdb->query("UPDATE $wpdb->options SET option_value = '$itemToken' WHERE option_name = '$nomeToken'");	
		
?>
<h3><?php echo $txtCad; ?></h3>
<div class="alert alert-success"><?php echo $msgenvio; ?></div>
<?php
echo '<meta http-equiv="refresh" content="3; url=admin.php?page=pagmemberCliente&pg=configuracoes">';
?>
