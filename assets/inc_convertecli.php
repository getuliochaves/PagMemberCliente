<?php
global $wpdb;
echo '<h3>Coversão de Usuários em Alunos</h3>';
$idUsuarios = $wpdb->get_results("SELECT ID FROM $wpdb->users");
if($_GET['pg'] == 'convertecli' && $_GET['converte'] == 'sim'){

foreach($idUsuarios as $posicaoID => $idUser){
	$idUsuario = $idUser->ID;
   $clientePagMember = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'clientePagMember' AND user_id = '$idUsuario'");

   $pegaAdmin = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'wp_capabilities' AND user_id = '$idUsuario'");
    $extraiUser = unserialize($pegaAdmin);
	$eadmin = $extraiUser['administrator'];


   if($clientePagMember != 'sim' && $eadmin != true){
	  $deleta = $wpdb->query("DELETE FROM $wpdb->usermeta WHERE meta_key = 'clientePagMember' AND user_id = '$idUsuario'");
	  $grava = $wpdb->insert($wpdb->usermeta,array('meta_key' => 'clientePagMember', 'user_id' => $idUsuario, 'meta_value'=>'sim'));
   }
}
echo '<div class="alert alert-success">Todos os Usuários foram alterados para Alunos. Aguarde, Redirecionando...</div>';
}


if($_GET['pg'] == 'convertecli' && $_GET['converte'] == 'remove'){

foreach($idUsuarios as $posicaoID => $idUser){
	$idUsuario = $idUser->ID;
   $clientePagMember = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'clientePagMember' AND user_id = '$idUsuario'");

   $pegaAdmin = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'wp_capabilities' AND user_id = '$idUsuario'");
    $extraiUser = unserialize($pegaAdmin);
	$eadmin = $extraiUser['administrator'];


   if($clientePagMember == 'sim'){
	  $deleta = $wpdb->query("DELETE FROM $wpdb->usermeta WHERE meta_key = 'clientePagMember' AND user_id = '$idUsuario'");
   }
}
echo '<div class="alert alert-success">Todos os Alunos foram Removidos do PagMember. Aguarde, Redirecionando...</div>';
}
echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente">';
?>
