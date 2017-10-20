<?php
include_once('../../../../wp-load.php');
global $wpdb;
$idUsuario = $_GET['idUsuario'];
$idRemetente = $_GET['idRemetente'];
$emailCliente = $wpdb->get_var("SELECT user_email FROM $wpdb->users WHERE ID = '$idUsuario'");
$nomeCliente = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE ID = '$idUsuario'");
$nomeRemetenteDB = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE ID = '$idRemetente'");
$emailRemetenteDB = $wpdb->get_var("SELECT user_email FROM $wpdb->users WHERE ID = '$idRemetente'");

$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra
$urlcompleta = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$novaurl = explode('PagMemberCliente', $urlcompleta);
$urlValidaPMC = $novaurl[0].'PagMemberCliente/';

$linkSite0 = explode('wp-content',$urlcompleta);
$linkSite = $linkSite0[0].'wp-admin/admin.php?page=pagmemberCliente&pg=clientes';

?>  
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

	<div class="panel-body corpo">
		
		<div class="panel panel-default">
			<div class="panel-body">
            
<?php
if(!isset($_GET['enviaMsg'])){
?>
<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo $urlValidaPMC; ?>assets/inc_msg.php?idUsuario=<?php echo $idUsuario ?>&enviaMsg=sim" name="formularioEnvio" id="formularioEnvio">

<div class="form-group">
    <label for="inputText" class="col-sm-3 control-label">Nome Cliente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" readonly required value="<?php echo $nomeCliente; ?>" name="nomeCliente">
    </div>
  </div> 
  

<div class="form-group">
    <label for="inputText" class="col-sm-3 control-label">Email Cliente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" readonly required placeholder="Ex: contato@ariana.com" value="<?php echo $emailCliente; ?>" name="emailCliente">
    </div>
  </div> 
  
  <div class="form-group">
    <label for="inputText" class="col-sm-3 control-label">Email Remetente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required value="<?php echo $emailRemetenteDB; ?>" name="emailRemetente">
    </div>
  </div> 
  
  
   <div class="form-group">
    <label for="inputText" class="col-sm-3 control-label">Nome Remetente:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required value="<?php echo $nomeRemetenteDB; ?>" name="nomeRemetente">
    </div>
  </div> 
  
 
  
  <div class="form-group">
    <label for="inputText" class="col-sm-3 control-label">Assunto:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: Aguardamos seu Pagamento" value="" name="assuntoEnvia">
    </div>
  </div>
  
  
  
  
  <div class="form-group">
    <label for="inputText" class="col-sm-3 control-label">Mensagem:</label>
    <div class="col-sm-8">
 <textarea class="form-control" required placeholder="Digite sua mensagem" rows="5" id="msgEnvia" name="msgEnvia"></textarea>
    </div>
  </div>
  
  
  
<div class="form-group">
    <div class="col-sm-12">
    
      <button type="submit" class="btn btn-primary btn-lg col-sm-12" id="btnCad">Enviar Mensagem para Cliente</button>
    </div>
  </div> 
 </form>
<?php
}
if(isset($_GET['enviaMsg'])){
	
$assuntoEnvia = $_POST['assuntoEnvia'];
$msgEnvia = $_POST['msgEnvia'];
$nomeCliente = $_POST['nomeCliente'];
$emailCliente = $_POST['emailCliente'];
$nomeRemetente = $_POST['nomeRemetente'];
$emailRemetente = $_POST['emailRemetente'];

$headers .= 'From: '.$nomeRemetente.'<'.$emailRemetente.'>';
$quebra_linha = '<br/>';	
if(!mail($emailCliente, $assuntoEnvia, $msgEnvia, $headers ,"-r".$emailRemetente)){ // Se for Postfix
	$headers .= "Return-Path: " . $emailRemetente . $quebra_linha; // Se "não for Postfix"			
	mail($emailRemetente, $assuntoEnvia, $msgEnvia, $headers);
}

$grava = $wpdb->insert($wpdb->usermeta, array('user_id' => $idUsuario,'meta_key' => 'msgContatoPagMember','meta_value' => $msgEnvia));	
?>

<div class="alert alert-success"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>Mensagem Enviada com Sucesso. Aguarde... Estamos redirecionando.</div>
<div id="tempo" align="center">REDIRECIONANDO EM 5</div>

<script>


var numero = 5;
var redD = 'REDIRECIONANDO EM '
 function chamar(){if(numero>0){document.getElementById('tempo').innerHTML = redD + (--numero);}}
setInterval("chamar();", 1000);


setTimeout(function() {	
 var url = '<?php echo $linkSite; ?>';
window.parent.closeModal(url);
}, 5000);

</script>

<?php
};
?>

			</div>
		</div> 
	</div> <!-- Fim Div Corpo--> 


