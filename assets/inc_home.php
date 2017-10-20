<?php
global $wpdb;
include_once('inc_core.php');
include_once('inc_filescli.php');
if($pegaVersaoBanco >= 5){
include_once('inc_inicio.php');
};
?>
<div class="panel panel-primary Geral" style="width:93%; margin-top:10px; ">
	<div class="panel-heading">
    	<h3><strong>PagMemberCliente - Versão <?php echo $versaoPlugin; ?></strong> <a href="https://www.youtube.com/watch?v=kdD2wtDER70" target="_blank" class="btn btn btn-default"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ver Vídeo Tutorial de Novidades</a></h3>
    </div>
	<div class="panel-body corpo">
		<ul class="nav nav-tabs" style="margin-bottom:20px !important;">
				<?php
					include_once(base64_decode('aW5jX21lbnVzLnBocA=='));
				?>

		</ul>




		<div class="panel panel-default">
			<div class="panel-body">

			<a class="btn btn-large btn-success" href="admin.php?page=pagmemberCliente&pg=convertecli&converte=sim">Colocar todos os Usuários como Alunos</a>
			<a class="btn btn-large btn-danger" href="admin.php?page=pagmemberCliente&pg=convertecli&converte=remove">Remover todos os Usuários como Alunos</a>



           <?php
		   switch($pg){

		   case 'configuracoes':
           include_once('inc_configuracoes.php');
		    break;

			  case 'relatorios':
           include_once('inc_relatorios.php');
		    break;

				case 'converterclientes':
					 include_once('inc_convertecli.php');
			 break;

			case 'clientes':
           include_once('inc_clientes.php');
		    break;

			case 'limparautores':
           include_once('inc_limparautores.php');
		    break;

			case 'convertecli':
           include_once('inc_convertecli.php');
		    break;

			case 'autoresponder':
           include_once('inc_autoresponder.php');
		    break;

			case 'perfilusuario':
           include_once('inc_perfilusuario.php');
		    break;

			default:
			include_once('inc_start.php');
		   	break;
			   }


		   ?>


			</div>
		</div>
	</div> <!-- Fim Div Corpo-->
</div> <!-- Fim Div Geral-->
