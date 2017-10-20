<?php
include_once('../../../../wp-load.php');
global $wpdb;
global $usuarioLogado;

$base_prefixo = $wpdb->base_prefix;
$capacidades = $base_prefixo.'capabilities';

$usuarioLogado = wp_get_current_user();
$dadosUsuario = get_userdata($usuarioLogado->ID);
$IDLogado = $dadosUsuario->ID;
$vefificaLogado = current_user_can('administrator');

$novaVar = $_SERVER;
$dados = $_SERVER['QUERY_STRING'];
$dadosURL = explode('&',$dados);

$idUsuario1 = explode('=',$dadosURL[0]);
$idUsuario = $idUsuario1[1];

$idTransacao1 = explode('=',$dadosURL[1]);
$idTransacao = $idTransacao1[1];

$tipoProd1 = explode('=',$dadosURL[2]);
$tipoProd99 = $tipoProd1[1];
$tipoProd55 = explode('%20',$tipoProd);

if(count($tipoProd55) > 0){
	$tipoProd = str_replace('%20', ' ',$tipoProd99);
}else{
	$tipoProd = $tipoProd99;
}







$acao1 = explode('=',$dadosURL[3]);
$acao = $acao1[1];

?>
<style>
.futuaDiv{
	position:fixed;
	right:0;
	bottom:-20px;
	background:#FFF;
	width:100%;
	padding-top:10px;
	padding-left:10px;
	border-top:1px solid #f2f2f2;
	}

.gravarConfig{
	width:30% !important;
	padding:10px !important;

}
.formTransacao{
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
}
.formTransacao input,select{
	width:97%;
	padding:5px;
	font-size:12px;
	margin-bottom:20px;
	background-color:#FFF;
	border:1px solid #CCC;
	border-radius:5px;
}

<?php
if($vefificaLogado == false){
?>
.formTransacao input,select{
	background-color:#f2f2f2;s
}
<?php
};
?>

</style>

<?php
$pegaPagamentoCli = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");
$pegaPagamentoCli = unserialize($pegaPagamentoCli);
$urlRetorno = get_site_url().'/wp-admin/user-edit.php?user_id='.$idUsuario.'#infopagmember';

if($vefificaLogado == false){
$desabilita = 'disabled';
}else{
$desabilita = '';
}

global $wp_roles;
$pega_options = get_option('ws_plugin__optimizemember_options');



if($acao == 'ver'){

	if($vefificaLogado == true){
		$urlFormularioGrava = get_site_url().'/wp-content/plugins/PagMemberCliente/assets/inc_transacao.php?idUsuario='.$idUsuario.'&idTransacao='.$idTransacao.'&tipoProd='.$tipoProd.'&acao=gravar';
		}else{
			$urlFormularioGrava = '';
		}



?>

<form class="formTransacao" action="<?php echo $urlFormularioGrava; ?>" method="post" enctype="multipart/form-data">
<?php
$dadosTransacao = $pegaPagamentoCli[$tipoProd][$idTransacao];




if(count($dadosTransacao) > 0){
foreach($dadosTransacao as $dados=>$valor){




	switch($dados){
		case 'nomeProd':
			echo 'Nome Produto';
			echo '<input '.$desabilita.'  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;

		case 'idProd'  :
			echo 'ID do Produto';
			echo '<input '.$desabilita.'  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;

		case 'valorProd'  :
			echo 'Valor Produto';
			echo '<input '.$desabilita.'  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;


		case 'statusTrasacao':
			echo '<input type="hidden" '.$desabilita.'  name="'.$dados.'" value="'.$valor.'" />';
			break;


		case 'statusCompra':
			echo 'Status da Compra';
			if($valor == 'Aguardando Pagamento'){$select1 = 'selected="selected"';}
			if($valor == 'Aprovado'){$select2 = 'selected="selected"';}
			if($valor == 'Cancelado'){$select3 = 'selected="selected"';}
			echo
			'<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">
				<option '.$select1.' value="Aguardando Pagamento">Aguardando Pagamento</option>
				<option '.$select2.' value="Aprovado">Aprovado</option>
				<option '.$select3.' value="Cancelado">Cancelado</option>
			</select><br><br>';
			break;

		case 'tipoProd':
			echo 'Tipo de Pagamento';
			echo '<input '.$desabilita.'  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;


		case 'idTransacao':
			echo 'ID do Pagamento';
			echo '<input '.$desabilita.'  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;

		case 'nivelProdAguarda':
		echo 'Nível Enquanto Aguarda Pagamento:';
			echo '<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">';
			foreach($wp_roles->roles as $key=>$value){
				$retonarlevel2 = explode('_',$key);
				$retonarlevel = $retonarlevel2[1];

				if($key == $valor){
					$selectnivel0 = 'selected="selected"';
				}else{
					$selectnivel0 = '';
					}


				if($retonarlevel != null){
					$pegalevel = $pega_options[$retonarlevel.'_label'];
					echo '<option '.$selectnivel0.' value="'.$key.'">'.$pegalevel.'</option>';
					}else{
					echo '<option '.$selectnivel0.' value="'.$key.'">'.$value['name'].'</option>';
					}
			}
			echo '</select><br><br>';
			break;


		case 'nivelProd':
			echo 'Nível Após Pagamento Aprovado:';
			echo '<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">';
			foreach($wp_roles->roles as $key=>$value){
				$retonarlevel2 = explode('_',$key);
				$retonarlevel = $retonarlevel2[1];

				if($key == $valor){
					$selectnivel = 'selected="selected"';
				}else{
					$selectnivel = '';
					}


				if($retonarlevel != null){
					$pegalevel = $pega_options[$retonarlevel.'_label'];
					echo '<option '.$selectnivel.' value="'.$key.'">'.$pegalevel.'</option>';
					}else{
					echo '<option '.$selectnivel.' value="'.$key.'">'.$value['name'].'</option>';
					}
			}
			echo '</select><br><br>';
			break;



		case 'pacoteProd':
			echo 'Pacotes do Aluno:';
			$pegaPacotes = unserialize($valor);
			if($pegaPacotes != false && count($pegaPacotes) > 0){
			//Inicio Foreach
				foreach($pegaPacotes as $chavePacote => $valorPacote){
					$valorPacote1 = explode('access_optimizemember_ccap_',$valorPacote);
					$retornaPacote = $valorPacote1[1];
					$listaPacote .= $retornaPacote.',';
				}//Fim Foreach
			}
			echo '<input '.$desabilita.'  name="'.$dados.'" value="'.$listaPacote.'" /><br>';
			break;

		case 'userGratis':

			echo 'Permitir Usuário Grátis:';
			if($valor == 'Permitir'){$p1 = 'selected="selected"';}
			if($valor == 'naoPermitir'){$p2 = 'selected="selected"';}
			echo
			'<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">
				<option '.$p1.' value="Permitir">Permitir</option>
				<option '.$p2.' value="naoPermitir">Não Permitir</option>
			</select><br><br>';
			break;

		case 'dataGrava':
			echo 'Data da Transação:';
			echo '<input '.$desabilita.' name="'.$dados.'" class="'.$dados.'"  value="'.$valor.'" /><br>';
			break;


		case 'eotCli':
		echo 'Ativar EOT:';
			if($valor == 'Ativar'){$eot1 = 'selected="selected"'; $displayEot = 'style="display:block;"';}
			if($valor == 'naoAtivar'){$eot2 = 'selected="selected"'; $displayEot = 'style="display:none;"';}
			echo
			'<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">
				<option '.$eot1.' value="Ativar">Ativar</option>
				<option '.$eot2.' value="naoAtivar">Não Ativar</option>
			</select><br><br>';
			break;


		case 'eotProd':
			echo '<div class="divEotProd" '.$displayEot.'>';
			echo 'Tempo do EOT(Em dias. Ex: 30):';
			echo '<input '.$desabilita.' name="'.$dados.'"  class="'.$dados.'" value="'.$valor.'" /><br>';
			echo '</div>';
			break;
	};
    };
};
//var_dump($dadosTransacao);
?>
</br></br>
<div class="futuaDiv">
<?php
if($vefificaLogado == true){
?>
<input class="gravarConfig btn btn-success" type="submit" value="Gravar Configurações" />
<?php
};
?>
</div>
</form>

<?php
};//Fim Visualiza Itens
?>

<?php
if($acao == 'gravar' && $vefificaLogado == true){
$dadosGrava = $_POST;

//var_dump($dadosGrava);

if($idTransacao == 'nova'){
	$idTransacao = $_POST['idTransacao'];
	$tipoProd = $_POST['tipoProd'];
}
//var_dump($dadosGrava);

//$dadosTransacao = $pegaPagamentoCli[$tipoProd][$idTransacao];

foreach($dadosGrava as $chave => $valor){
	if($chave == 'pacoteProd'){
		$novoPacote = explode(',',$valor);
		//If Novo Pacote
		if(count($novoPacote)>0){
			foreach($novoPacote as $dadosPacotes){
				if($dadosPacotes != ''){
					$pacote[] = 'access_optimizemember_ccap_'.$dadosPacotes;
				}
			}
		};//FIM If Novo Pacote

		$pacoteGrava = serialize($pacote);
		$pegaPagamentoCli[$tipoProd][$idTransacao][$chave]= $pacoteGrava;

	}else{
	$pegaPagamentoCli[$tipoProd][$idTransacao][$chave]= $valor;
	}
}


$gravaPagamento = serialize($pegaPagamentoCli);
$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamento' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

$verificaUsuarioPM3['verificacao']=0;
$gravaVerifica3 = serialize($verificaUsuarioPM3);
$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaVerifica3' WHERE user_id = '$idUsuario' AND meta_key = 'verificaUsuarioPM'");

include_once('inc_upusuario.php');


echo '<h2>Transação Atualizada Com Sucesso. Redirecionando...</h2>';
echo '<meta http-equiv="refresh" content="2; url='.$urlRetorno.'">';
echo '<script> window.parent.location.reload(); </script>';

}//Fim do IF Grava


if($acao == 'excluir'){

	unset($pegaPagamentoCli[$tipoProd][$idTransacao]);
	$gravaPagamento = serialize($pegaPagamentoCli);
	$wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$gravaPagamento' WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");

//inclui a exclusao da transacao
include_once('inc_upusuario.php');
	//var_dump($pegaPagamentoCli);



echo '<h2>Transação Excluida Com Sucesso. Redirecionando...</h2>';
echo '<meta http-equiv="refresh" content="2; url='.$urlRetorno.'">';
echo '<script>
window.parent.location.reload();
</script>';

};




if($acao == 'nova'){
	$dadosNovo['nomeProd']='';
	$dadosNovo['idProd']='';
	$dadosNovo['valorProd']='';
	$dadosNovo['statusTrasacao']='';
	$dadosNovo['statusCompra']='';
	$dadosNovo['tipoProd']='';
	$dadosNovo['idTransacao']='';
	$dadosNovo['pacoteProd']='';
	$dadosNovo['nivelProdAguarda']='';
	$dadosNovo['nivelProd']='';
	$dadosNovo['userGratis']='';
	$dadosNovo['dataGrava']='';
	$dadosNovo['eotCli']='';
	$dadosNovo['eotProd']='';


	?>
    <form class="formTransacao" action="<?php echo get_site_url();?>/wp-content/plugins/PagMemberCliente/assets/inc_transacao.php?idUsuario=<?php echo $idUsuario;?>&idTransacao=<?php echo $idTransacao; ?>&tipoProd=<?php echo $tipoProd; ?>&acao=gravar" method="post" enctype="multipart/form-data">
    <?php
	foreach($dadosNovo as $dados => $valor){
switch($dados){
		case 'nomeProd':
			echo 'Nome Produto';
			echo '<input '.$desabilita.' required  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;

		case 'idProd'  :
			echo 'ID do Produto';
			echo '<input '.$desabilita.'  required name="'.$dados.'" value="'.$valor.'" /><br>';
			break;

		case 'valorProd'  :
			echo 'Valor Produto';
			echo '<input '.$desabilita.' required  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;


		case 'statusTrasacao':
			echo '<input type="hidden"  '.$desabilita.'  name="'.$dados.'" value="'.$valor.'" />';
			break;


		case 'statusCompra':
			echo 'Status da Compra';
			if($valor == 'Aguardando Pagamento'){$select1 = 'selected="selected"';}
			if($valor == 'Aprovado'){$select2 = 'selected="selected"';}
			if($valor == 'Cancelado'){$select3 = 'selected="selected"';}
			echo
			'<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">
				<option '.$select1.' value="Aguardando Pagamento">Aguardando Pagamento</option>
				<option '.$select2.' value="Aprovado">Aprovado</option>
				<option '.$select3.' value="Cancelado">Cancelado</option>
			</select><br><br>';
			break;

		case 'tipoProd':
			echo 'Tipo de Pagamento';
			echo '<input '.$desabilita.' required  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;


		case 'idTransacao':
			echo 'ID do Pagamento';
			echo '<input '.$desabilita.' required  name="'.$dados.'" value="'.$valor.'" /><br>';
			break;

		case 'nivelProdAguarda':
		echo 'Nível Enquanto Aguarda Pagamento:';
			echo '<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">';
			foreach($wp_roles->roles as $key=>$value){
				$retonarlevel2 = explode('_',$key);
				$retonarlevel = $retonarlevel2[1];

				if($key == $valor){
					$selectnivel0 = 'selected="selected"';
				}else{
					$selectnivel0 = '';
					}


				if($retonarlevel != null){
					$pegalevel = $pega_options[$retonarlevel.'_label'];
					echo '<option '.$selectnivel0.' value="'.$key.'">'.$pegalevel.'</option>';
					}else{
					echo '<option '.$selectnivel0.' value="'.$key.'">'.$value['name'].'</option>';
					}
			}
			echo '</select><br><br>';
			break;


		case 'nivelProd':
			echo 'Nível Após Pagamento Aprovado:';
			echo '<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">';
			foreach($wp_roles->roles as $key=>$value){
				$retonarlevel2 = explode('_',$key);
				$retonarlevel = $retonarlevel2[1];

				if($key == $valor){
					$selectnivel = 'selected="selected"';
				}else{
					$selectnivel = '';
					}


				if($retonarlevel != null){
					$pegalevel = $pega_options[$retonarlevel.'_label'];
					echo '<option '.$selectnivel.' value="'.$key.'">'.$pegalevel.'</option>';
					}else{
					echo '<option '.$selectnivel.' value="'.$key.'">'.$value['name'].'</option>';
					}
			}
			echo '</select><br><br>';
			break;



		case 'pacoteProd':
			echo 'Pacotes do Aluno:';
			$pegaPacotes = unserialize($valor);

			//var_dump($pegaPacotes);

			if($pegaPacotes != false && count($pegaPacotes) > 0){
			//Inicio Foreach
				foreach($pegaPacotes as $chavePacote => $valorPacote){
					$valorPacote1 = explode('access_optimizemember_ccap_',$valorPacote);
					$retornaPacote = $valorPacote1[1];
					$listaPacote .= $retornaPacote.',';
				}//Fim Foreach
			}
			echo '<input '.$desabilita.'  name="'.$dados.'" value="'.$listaPacote.'" /><br>';
			break;

		case 'userGratis':

			echo 'Permitir Usuário Grátis:';
			if($valor == 'Permitir'){$p1 = 'selected="selected"';}
			if($valor == 'naoPermitir'){$p2 = 'selected="selected"';}
			echo
			'<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">
				<option '.$p1.' value="Permitir">Permitir</option>
				<option '.$p2.' value="naoPermitir">Não Permitir</option>
			</select><br><br>';
			break;

		case 'dataGrava':
			echo 'Data da Transação:';
			echo '<input '.$desabilita.' required name="'.$dados.'" class="'.$dados.'"  value="'.$valor.'" /><br>';
			break;


		case 'eotCli':
		echo 'Ativar EOT:';
			if($valor == 'Ativar'){$eot1 = 'selected="selected"'; $displayEot = 'style="display:block;"';}
			if($valor == 'naoAtivar'){$eot2 = 'selected="selected"'; $displayEot = 'style="display:none;"';}
			echo
			'<select '.$desabilita.' name="'.$dados.'" class="'.$dados.'">
				<option '.$eot1.' value="Ativar">Ativar</option>
				<option '.$eot2.' value="naoAtivar">Não Ativar</option>
			</select><br><br>';
			break;


		case 'eotProd':
			echo '<div class="divEotProd" '.$displayEot.'>';
			echo 'Tempo do EOT(Em dias. Ex: 30):';
			echo '<input '.$desabilita.' name="'.$dados.'"  class="'.$dados.'" value="'.$valor.'" /><br>';
			echo '</div>';
			break;
	};





















	}
?>
</br></br>
<div class="futuaDiv">
<input class="gravarConfig btn btn-success" type="submit" value="Gravar Configurações" />
</div>
</form>

<?php
};
?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

$k = jQuery.noConflict();
//Incio ready
$k(document).ready(function(){

	//Inicio btnModal
	$k('.statusCompra').change(function(){
		var pegaStatusCompra = $k(this).val();

		if(pegaStatusCompra == 'Aguardando Pagamento'){
			var statusTransacao = 1;
		}

		if(pegaStatusCompra == 'Aprovado'){
			var statusTransacao = 3;
		}

		if(pegaStatusCompra == 'Cancelado'){
			var statusTransacao = 6;
		}

		$k('input[name="statusTrasacao"]').attr('value',statusTransacao);
		//statusTrasacao
	});//Fin btnModal

	$k('.eotCli').change(function(){
		var eotCli = $k(this).val();
		if(eotCli == 'naoAtivar'){
			$k('.divEotProd').hide();
		}else{
			$k('.divEotProd').show();
		}
	//	alert(eotCli);

		//eotProd
	});



	//Inicio dataGrava
	$k(".dataGrava").datepicker({
		dateFormat: 'dd-mm-yy',
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior'
	});	//dataGrava
});//Fim do Ready




</script>
