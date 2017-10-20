<?php
include_once('../../../../wp-load.php');
global $wpdb;
global $usuarioLogado;
$usuarioLogado = wp_get_current_user();
$dadosUsuario = get_userdata($usuarioLogado->ID);
$IDLogado = $dadosUsuario->ID;
$vefificaLogado = current_user_can('administrator');

$novaVar = $_SERVER;
$dados = $_SERVER['QUERY_STRING'];
$dadosURL = explode('&',$dados);

$idUsuario1 = explode('=',$dadosURL[0]);
$idUsuario = $idUsuario1[1];

$acao1 = explode('=',$dadosURL[1]);
$acao = $acao1[1];

$pegaPagamentoCli = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$idUsuario' AND meta_key = 'pagamentosPM'");
$pegaPagamentoCli = unserialize($pegaPagamentoCli);
$urlRetorno = get_site_url().'/wp-admin/user-edit.php?user_id='.$idUsuario.'#infopagmember';
//Inicio do Conta pagamentos
if(count($pegaPagamentoCli)>0){
?>
<table class="table table-bordered">
    <thead>
        <tr class="success" style="text-align:center;">
            <th>Data Transação</th>
            <th>Transação</th>
            <th>Produto</th>
            <th>Valor</th>
            <th>Nível de Acesso</th>
            <th>Pacotes</th>
            <th>Tipo de Pagamento</th>
            <th>Status Compra</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		//Inicio Foreach lista pagamentos
    
    if($pegaPagamentoCli != false){
   		 foreach($pegaPagamentoCli as $idTransacao){
			 foreach($idTransacao as $dadosTransacao){
			// var_dump($dadosTransacao);
					$dataTransacao = $dadosTransacao['dataGrava'];
					$idTransacao = $dadosTransacao['idTransacao'];
					$nomeProd = $dadosTransacao['nomeProd'];
					$valorProd = $dadosTransacao['valorProd'];
					$nivelProd = $dadosTransacao['nivelProd'];
					$pacoteProd = $dadosTransacao['pacoteProd'];
					$tipoProd = $dadosTransacao['tipoProd'];
					$statusCompra = $dadosTransacao['statusCompra'];

            //var_dump($dadosTransacao);

		?>
        <tr style="font-size:11.4px;">
            <td><?php echo $dataTransacao; ?></td>
            <td><?php echo $idTransacao; ?></td>
            <td><?php echo $nomeProd; ?></td>
            <td><?php echo $valorProd; ?></td>
            <td><?php echo $nivelProd; ?></td>
            <td><?php
			$pacotes = unserialize($pacoteProd);
			if(count($pacotes) > 0){
			echo '<strong>Pacotes:</strong>';

			$contaPacote = (count($pacotes));

			$ct = 1;
      //Inicio Foeach pacotes
			foreach($pacotes as $pacote){
				$pacote0 = explode('access_optimizemember_ccap_',$pacote);
					if(count($pacote0) > 1){
						$mostraPacote = $pacote0[1];
						echo $mostraPacote;
						if($ct < $contaPacote){
							echo ', ';
							}
						$ct++;
					}
				}//FIm   Foeach pacotes
			}//Conta
			?></td>
            <td><?php echo $tipoProd; ?></td>
            <td><?php echo $statusCompra; ?></td>
        </tr>
        <?php
			 };
		};//Fim do foreach lista pagamentos

  };
		?>
    </tbody>
</table>

<a style="float:right;" href="<?php echo $urlRetorno;?>" target="_blank" class="btn btn-success btn-largue">Editar Transações deste Usuário</a>
<?php
};//Fim do Conta pagamentos
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
