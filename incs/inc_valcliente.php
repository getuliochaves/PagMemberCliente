<?php
//pega o campo clientePagMember
$pegaCliente = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'clientePagMember'");

//Valida se o Cliente Existe
if(count($pegaCliente) == 0){
	$wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario, 'meta_key' => 'clientePagMember','meta_value' => 'sim'));
}else{
	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = 'sim' WHERE user_id = '$idUsuario' AND meta_key = 'clientePagMember'");
}
?>
