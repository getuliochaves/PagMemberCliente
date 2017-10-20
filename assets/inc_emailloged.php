<?php
global $current_user;
get_currentuserinfo();
global $wpdb;
//Pegando dados da Página Atual
$idPg = get_the_ID();
$ARAtivado = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'autoresponderpagmember'");
if($ARAtivado == 'sim'){
//Pegando dados do Usuario
$user_email = $current_user->user_email;
$user_login = $current_user->user_login;
$first_name = $current_user->first_name;
$user_id = $current_user->ID;
$pegaMetaUser = $wpdb->get_var("SELECT meta_key FROM $wpdb->usermeta WHERE meta_key = 'autoResponderUser' AND user_id = '$user_id'");

$pegaEmailUser = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'autoResponderUser' AND user_id = '$user_id'");

$dadosUsarioDB = array('emailUser' => $user_email, 'pgAutoResponder' => '');
if($dadosARUser == NULL or $dadosARUser == ''){
add_user_meta( $user_id, 'autoResponderUser', $dadosUsarioDB, true);
}

if($pegaEmailUser == $user_email or $pegaEmailUser == $user_login){
update_user_meta($user_id, 'autoResponderUser', $dadosUsarioDB);
}

$dadosARUser = $current_user->autoResponderUser;

if(is_array($dadosARUser)){

$emailUser = $dadosARUser['emailUser'];
$pgAutoResponder = $dadosARUser['pgAutoResponder'];

if($pgAutoResponder != ''){

	foreach($pgAutoResponder as $posicaoArray => $pgArray){
		if($pgArray == $idPg){
			$carregaCodigo = 'sim';
		}
	};
};

};//Fim Is Array
if($carregaCodigo != 'sim'){

//Verifica se o AutoResponder estar ativado
$ARAtivado = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'autoresponderpagmember'");


//Pega Nome do Produto no Banco
$nomeArProduto = 'ARPagMember#'.$idPg;
$pegaArPg = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$nomeArProduto'");
$dadosArPG = unserialize($pegaArPg);
$idPgForm =  $dadosArPG[$idPg];



//Verifica se Pode iniciar os scripts
if($ARAtivado == 'sim' && $pegaArPg != NULL){
	
	if(isset($_GET['bemvindo'])){
		
		if($pgAutoResponder != ''){
			$pegaPgsArray = $dadosARUser['pgAutoResponder'];
			array_push($pegaPgsArray, $idPg);
	
			$novosDadosUsuario = array('emailUser' => $user_email, 'pgAutoResponder' => $pegaPgsArray);
			
		}else{
			$novosDadosUsuario = array('emailUser' => $user_email, 'pgAutoResponder' => array($idPg));	
		}
			
			//$updateDados = serialize($novosDadosUsuario);
			update_user_meta($user_id, 'autoResponderUser', $novosDadosUsuario);
			echo '<meta http-equiv="refresh" content="0; url='.get_permalink($idPg).'"/>';
			
		
		}
		
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<style>
.modal-lg {margin: 0 auto; margin-top:10%;}
.meuModal{z-index:999999999999999 !important;}
.modal-content{height:400px !important;}
.frameAR{border:none;padding:10px;}
.container { width: 100% !important;}
#wpadminbar{display:none !important;}
</style>

<!-- Declara a variavel jquery para nao entrar em conflito -->
<script>
$pmember = jQuery.noConflict();
$pmember(window).load(function() {	 
$pmember('.meuModal').modal('show');
});
</script>

<?php

foreach($dadosArPG as $pgProduto => $pgFormulario){
if($pgidmodal != $pgFormulario){
?>
<!-- Mostra o formulario de Modal -->
<div class="modal fade meuModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <iframe src="<?php echo get_permalink($pgFormulario);?>" width="100%" height="100%" scrolling="no" class="frameAR"></iframe>
    </div>
  </div>
</div>

<script>
$pmember(document).ready(function() {
$pmember('.meuModal').modal({ backdrop: 'static', keyboard: false });
});

</script>
<!-- Fim o formulario de Modal -->
	
<?php			
					
				};
			};//Fim do If
		}; // Fim do ForEach
$PegaItemFormulario = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'formularioPm' AND post_id = '$idPg'");
if($PegaItemFormulario == 'sim'){
?>

<!-- Coloca os Dados no Formulario-->
<script>
$a = jQuery.noConflict();
var emailCli = '<?php echo $user_email; ?>';
var nomeAluno = '<?php echo $first_name; ?>';
$a(document).ready(function() {	
var emailC = $a('input[name="email"]').val(emailCli);
var nomeC = $a('input[name="name"]').val(nomeAluno);
$a('input[name="email"').attr('readonly', true);

$a('.text-box').hide();
$a('input').hide();
$a('.op-optin-validation').attr('target', '_parent');

var urlCompleta = window.parent.location.href.substring(1);
var sURLVariables = urlCompleta.split('?');
var pgBemVindo = sURLVariables['1'];

if(pgBemVindo == 'bemvindo'){
	$a('form').html('<h3 style="text-align:center;">Bem Vindo ao Treinamento. Redirecionando...</h3>');
}

});

</script>
<style>
#wpadminbar{display:none !important;}
</style>

<?php
	};
};
};
?>