<?php
global $wpdb;
echo '<h3>Removendo Dados de AutoResponder do PagMember</h3>';
$idUser = $_GET['idUser'];
if($_GET['pg'] == 'limparautores'){	
	$wpdb->query("DELETE FROM $wpdb->usermeta WHERE meta_key = 'autoResponderUser' AND user_id = '$idUser'");
echo '<div class="alert alert-success">Dados de AutoResponder Removidos do PagMember. Aguarde, Redirecionando...</div>';
}
echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente">';
?>