<style>
html,body { background:#f2f2f2 !important;}
  .fecharModal{
	  margin-top:-70px !important;
	  margin-left:200px !important;

  }
  .tabTransacoes{
	 padding:50px;
	  background-color:#FFF;
  }
  .tabTransacoes tr{
	  border-bottom:1px solid #ccc !important;

  }
  .tabTransacoes tr td{
	  padding:10px;
  }
  .tabTransacoes tr th{
	  padding:5px;
	  background-color:#ddd;
  }
</style>
<a style="margin-top:-200px;" name="infopagmember"></a>
<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>
<h3>Informações de Compra PagMember</h3>
<table width="100%" class="tabTransacoes">
	<tr>
    	<th scope="col">Data da Compra</th>
        <th scope="col">ID da Transaçao:</th>
        <th scope="col">Valor</th>
        <th scope="col">Nome Produto</th>
        <th scope="col">Pacotes de Acesso</th>
        <th scope="col">Status Compra</th>
        <th scope="col">Tipo de Pagamento</th>
        <th scope="col" style="text-align:center;">Alterações</th>
     </tr>
<?php
$loadingImg = get_site_url().'/wp-content/plugins/PagMemberCliente/imagens/loading.gif';
$idUsuario = $user->ID;
$senhaClientePagMember = get_the_author_meta('senhaClientePagMember', $user->ID );
$clientePagMember = get_the_author_meta('clientePagMember', $user->ID );

if($clientePagMember == 'sim'){
$chekado = 'checked';
}else{
$chekado2 = 'checked';
	}

//$usuarioLogado = get_user_info();

global $usuarioLogado;
$usuarioLogado = wp_get_current_user();
$dadosUsuario = get_userdata($usuarioLogado->ID);
$IDLogado = $dadosUsuario->ID;
//$first_name = $user_info->first_name;
//$user_email = $user_info->user_email;
$vefificaLogado = current_user_can('administrator');
if($vefificaLogado == true){
	$funcaoSite = 'Editar';
}else{
	$funcaoSite = 'Ver Transação';
}
$pegaPagamentoCli = get_the_author_meta('pagamentosPM', $user->ID );
$pegaPagamentos = get_user_meta($idUsuario, 'pagamentosPM');
if(count($pegaPagamentos) == 0){
add_user_meta( $idUsuario, 'pagamentosPM', '');
}
//IF conta pagamentos
if($pegaPagamentoCli != ''){
//Incio Busca Pagamentos
foreach($pegaPagamentoCli as $idTransacao){
	foreach($idTransacao as $dadosCompra){
	$pegaID = $dadosCompra[idTransacao];
	$statusCompra = $dadosCompra[statusCompra];
	$nivelProd = $dadosCompra[nivelProd];
	$tipoProd = $dadosCompra[tipoProd];
	$nomeProd = $dadosCompra[nomeProd];
	$valorProd = $dadosCompra[valorProd];
	$pacoteProd = $dadosCompra[pacoteProd];
	$dataGrava = $dadosCompra[dataGrava];
	$statusUsuarioT = $dadosCompra[statusUsuarioT];
	$statusTrasacao = $dadosCompra[statusTrasacao];
	$clienteNoSite = $dadosCompra[clienteNoSite];
?>

<?php
$pacoteProd2 = unserialize($pacoteProd);
if($pacoteProd2 != false){
	foreach($pacoteProd2 as $pacote){
		$pacote2 = explode('access_optimizemember_ccap_',$pacote);
				$nomePacote[$pegaID] .= $pacote2[1].'<br>';
		}
	}
?>


     <tr>
       <td><?php echo $dataGrava; ?></td>
       <td><?php echo $pegaID; ?></td>
       <td><?php echo $valorProd; ?></td>
       <td><?php echo $nomeProd; ?></td>
       <td><?php echo $nomePacote[$pegaID]; ?></td>
       <td><?php echo $statusCompra; ?></td>
       <td><?php echo $tipoProd; ?></td>
       <td style="text-align:center;"><a href="#" data-toggle="modal" acao="ver"  name="<?php echo $pegaID;?>" accesskey="<?php echo $tipoProd; ?>" class="btnModal btn btn-primary" data-target="#modal_<?php echo $pegaID;?>" ><?php echo $funcaoSite; ?></a>
       <?php
       if($vefificaLogado == true){
	   ?>
       <a href="#" data-toggle="modal" name="<?php echo $pegaID;?>" acao="excluir" accesskey="<?php echo $tipoProd; ?>" class="btnModal btn btn-danger" data-target="#modal_<?php echo $pegaID;?>" >Excluir</a></td>
       <?php
	   };
	   ?>
 	 </tr>
<?php
	};
	//var_dump($idTransacao);
}//FIM Incio Busca Pagamentos
};//FIM IF conta pagamentos

?>

<?php
if($vefificaLogado == true){
?>
<tr>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td style="text-align:center;"><a href="#" data-toggle="modal" name="nova" accesskey="novo" class="btnModal btn btn-success" data-target="#modal_nova" >Nova Transação</a></td>
 	 </tr>
<?php
};
?>


</table>

<!-- Modal -->
<div id="modal_" class="modal fade modalChave" role="dialog" style="margin-top:50px;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      		<div class="enviaFrame">
            	<div class="loading">Carregando... </div>
            </div>

            <?php
            if($vefificaLogado == true){
			?>

            <button type="button" class="btn btn-default fecharModal" data-dismiss="modal">Fechar</button>

           <?php
			};
		   ?>
      </div>
       <?php
            if($vefificaLogado == false){
			?>
          <div class="modal-footer">
      		  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
     	 </div>
           <?php
			};
		   ?>


    </div>

  </div>
</div>

<?php
echo '
<table class="form-table">
<tr>
            <th><label for="senhaClientePagMember">Senha Padrão Gerada:</label></th>

            <td>
                <input type="text" name="senhaClientePagMember" id="senhaClientePagMember" value="'.$senhaClientePagMember.'" class="regular-text" /><br />
                <span class="description">Primeira senha gerada para este usuário.</span>
            </td>
        </tr>

		<th><label for="clientePagMember">Esse Usuário é um Aluno?</label></th>

            <td>
                <input type="radio" name="clientePagMember" value="sim" '.$chekado.' /> Sim
				<input type="radio" name="clientePagMember" value="nao" '.$chekado2.'/> Não
				<br>
                <span class="description">Defina se este usuário seja um Aluno ou Não.</span>
            </td>
        </tr>
		</table>';

add_action( 'personal_options_update', 'update_profile_fields');
add_action( 'edit_user_profile_update', 'update_profile_fields');
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
$h = jQuery.noConflict();
$h(document).ready(function(){

	$h('.btnModal').click(function(){
		//alert('Passou o Mouse');
		var idFormulario = $h(this).attr('name');

		var tipoProd = $h(this).attr('accesskey');
		var acao = $h(this).attr('acao');



		$h('.modalChave').attr('id','modal_'+idFormulario)
		$h('.modal-title').html('Detalhes do Pagamento #'+idFormulario);


		if(idFormulario == 'nova'){
			acao = 'nova';
		}

	//	alert(acao);

		if(acao == 'excluir'){
			confirmaEx = confirm("Ao excluir essa transação ela não poderá ser recumperada!\nDeseja mesmo Exluir essa transação?\n\nClique em OK para Excluir!");

			if(confirmaEx){
				acao = 'excluir';
			}else{
			acao = '';
			$h('.modalChave').modal('toggle');
			}
		}


		var urlFrame = '<?php echo get_site_url();?>/wp-content/plugins/PagMemberCliente/assets/inc_transacao.php?idUsuario=<?php echo $idUsuario;?>&idTransacao='+idFormulario+'&tipoProd='+tipoProd+'&acao='+acao;
		//alert(urlFrame);
		$h('.enviaFrame').html('<iframe  src="'+urlFrame+'" style="zoom:0.60" width="99.6%" height="600" frameborder="0"></iframe>');



		//modalChave
		//alert(idFormulario);
	});

	$h('.modalChave').on('hidden.bs.modal', function () {
		$h('.enviaFrame').html('<div class="loading"><img src="<?php echo $loadingImg; ?>"/></div>');
		//$h('.conteudoFrame').html('<div class="loading"><img src=""/></div>');
	});


	/*
	$h('.botaoEnvia').live('click',function(){
		var urlEnvio = 'admin.php?page=pagmemberCliente&pg=perfilusuario';
		var idFormulario = $h(this).attr('name');

	});

	*/

});

</script>

<style>
.loading{
	margin:0 auto;
	margin-top:100px;
	text-align:center;
}
</style>
