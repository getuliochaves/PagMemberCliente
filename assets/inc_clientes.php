<?php
if(!isset($_GET['edit'])){
global $wpdb;
global $wp_roles;
//  var_dump($wp_roles);
$pegaUsuarios = $wpdb->get_results("SELECT ID FROM $wpdb->users ORDER BY ID DESC");
$loadingImg = get_site_url().'/wp-content/plugins/PagMemberCliente/imagens/loading.gif';


$contaUsuario = 0;
foreach($pegaUsuarios as $idUsuarios){
$idUsuario = $idUsuarios->ID;
$metasUsuario = get_user_meta($idUsuario);
$clientePagMember = $metasUsuario['clientePagMember'][0];
  if($clientePagMember == 'sim'){
  $contaUsuario = $contaUsuario + 1;
};
};
?>
</br>
</br>
<div class="alert alert-success" style="padding: 10px; ">
  <h4 style="padding:0; margin: 0;"><strong>Total de Clientes:</strong> <?php echo $contaUsuario; ?> Clientes Cadastrados no seu site.</h4>  
</div>

<table class="table table-bordered">
        <thead>
          <tr class="success" style="text-align:center;">
           <th width="10%">Data</th>
            <th style="overflow:auto;" width="10%">Nome</th>
			<th width="20%">Email</th>
             <th width="7%">Nível de Acesso</th>
            <th width="23%">Alterações</th>
          </tr>
        </thead>
        <tbody>

        <?php
		//Foreach lista usuarios

    foreach($pegaUsuarios as $idUsuarios){
		$idUsuario = $idUsuarios->ID;

		$dadosUsuario = get_userdata($idUsuario);
		$metasUsuario = get_user_meta($idUsuario);
		$clientePagMember = $metasUsuario['clientePagMember'][0];



		//echo $clientePagMember;
		//var_dump($dadosUsuario);
			//Verifica se é cliente
			if($clientePagMember == 'sim'){



			$chaveRole = key($dadosUsuario->roles);
			$funcaoUsuario = $dadosUsuario->roles[$chaveRole];
			$dataRegistro0 = $dadosUsuario->user_registered;
			$dataRegistro = new DateTime($dataRegistro0);
			$dataRegistro = $dataRegistro->format("d-m-Y");

			$nomeCliente = $dadosUsuario->display_name;
			$user_email = $dadosUsuario->user_email;

			$pacotes = $dadosUsuario->caps;

			//var_dump($dadosUsuario);
		?>

        <tr style="font-size:11.4px;">
          	<td><?php echo $dataRegistro; ?></td>
            <td><?php echo $nomeCliente; ?></td>
             <td><?php echo $user_email; ?></td>
            <td><?php
              $role = $wp_roles->roles[$funcaoUsuario]['name'];

            echo $role;

unset($pacotes[$funcaoUsuario]);
//var_dump($pacotes);
      $contaPac = 0;
			if(count($pacotes) > 0){
        echo '<br/>
        <div style="display:block; background-color:#eee; padding:3px;">';
  			echo '<strong>Pacotes Ativos:<br></strong>';

        foreach($pacotes as $pacote => $valor){
          $pacote0 = explode('access_optimizemember_ccap_',$pacote);
        //  echo $pacote0[1];
          //var_dump($pacote);
          $contaPac += count($pacote);
          if($contaPac > 1){
            echo '<br/> =>'.$pacote0[1];
          }else{
            echo '=>'.$pacote0[1];
          };
        };
        echo '</div>';
			}//Conta




        $deletaUsaurio = wp_nonce_url( "users.php?action=delete&user=".$idUsuario, 'bulk-users' );


			?>
            </td>
              <td style="text-align:center;">
              <a href="#" class="btn btn-success btnModal apagaMouse" data-target="#modalTransacoes" nameCliente="<?php echo $nomeCliente; ?>" emailCliente="<?php echo $user_email;?>" idCliente="<?php echo $idUsuario;?>" data-toggle="modal">Transações</a>
              <a href="user-edit.php?user_id=<?php echo $idUsuario; ?>" class="btn btn-primary" target="_blank">Editar</a>
              <a href="<?php echo $deletaUsaurio; ?>" class="btn btn-danger" target="_blank">Excluir</a>




              </td>
          </tr>

          <?php
				}//Fim IF verifica se é cliente
			}//Fim do Foreach
		  ?>

        </tbody>
      </table>







  <!-- Modal -->
  <div class="modal fade" id="modalTransacoes" role="dialog" style="margin-top:50px; z-index:9999999999999 !important;">
    <div class="modal-dialog modal-lg" style="width:90% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Transações do Cliente <spam class="emailCli"></spam></h4>
        </div>
        <div class="modal-body">
        <div class="conteudoFrame">
       	 <div class="loading"><img src="<?php echo $loadingImg ; ?>"/></div>
        </div>

        </div>
        <div class="modal-footer">
          <a href="https://www.youtube.com/watch?v=8wXw7NLTNVY" target="_blank" class="btn btn btn-primary"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial sobre as Transações</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

<?php
};
?>
<script>
$h = jQuery.noConflict();
$h(document).ready(function(){

	$h('.btnModal').click(function(){
		var idUsuario = $h(this).attr('idCliente');
		var emailCliente = $h(this).attr('emailCliente');
		var nameCliente = $h(this).attr('nameCliente');
		var montaDadosCli = nameCliente+'('+emailCliente+')';
		var acao = 'ver';
		var urlFrame = '<?php echo get_site_url();?>/wp-content/plugins/PagMemberCliente/assets/inc_transacoes.php?idUsuario='+idUsuario+'&acao='+acao;
		//alert(urlFrame);
		//$h('.enviaFrame').attr('src',urlFrame).fadeIn("slow");
		$h('.emailCli').html(montaDadosCli);

		$h(".conteudoFrame").load(urlFrame, { 'action': 'ver' } );
		//alert(idUsuario);
	});

	$h('#modalTransacoes').on('hidden.bs.modal', function () {
		//$h('.enviaFrame').attr('src','Carregando...');
		$h('.conteudoFrame').html('<div class="loading"><img src="<?php echo $loadingImg ; ?>"/></div>');
	});



});
</script>

<style>
.conteudoFrame{
	overflow:auto;
	width:99.6%;
	height:300px;
}
.loading{
	text-align:center;
	margin:0 auto;
}
</style>
