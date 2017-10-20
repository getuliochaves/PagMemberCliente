<?php
//Retorna dados do usuario existente
global $current_user;
$user_info = get_userdata($idUsuario);
$niveisdeacessoGeral = $user_info->allcaps;	//Retorna niveis e capacidades permitidas
$capacidadesGeral = $user_info->caps; //Retorna as capacidades
$nivelAtualGeral2 = $user_info->roles; //retorna o nível atual

//Foreach pra colocar o nivel atual numa string
foreach($nivelAtualGeral2 as $nivelAtualGeral1){
  $nivelAtualGeral = $nivelAtualGeral1;
}//FIM Foreach pra colocar o nivel atual numa string
?>
