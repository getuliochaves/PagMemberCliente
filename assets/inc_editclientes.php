<?php
global $wpdb;
$iduser = $_GET['edit'];
?>
<h2>Editar Usuário</h2>


<?php
if(isset($_GET['atualizar']) && $_GET['atualizar'] == 'nao'){
echo '<div class="alert alert-success">Cliente Atualizado Com Sucesso.</div>';
}
$email = $wpdb->get_var("SELECT user_email FROM $wpdb->users WHERE ID = '$iduser'");
$usuario = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE ID = '$iduser'");

$senhaPadrao = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$iduser' AND meta_key = 'senhaClientePagMember'");

$dataCompra = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$iduser' AND meta_key = 'DataCompraPagMember'");

$tipoPagamento = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$iduser' AND meta_key = 'TipoPagamentoPagMember'");

$idTrasacao = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$iduser' AND meta_key = 'IDTransacaoPagMember'");

$valorProduto = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$iduser' AND meta_key = 'PrecoPagMember'");
?>



<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmemberCliente&pg=clientes&edit=<?php echo $iduser; ?>&atualizar=sim" name="formularioProd">

<hr>

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Nome de Usuário:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required value="<?php echo $usuario; ?>" name="usuario">
    </div>
  </div>  
  
  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Email:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required value="<?php echo $email; ?>" name="email">
    </div>
  </div>  
  
  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Senha:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required value="<?php echo $senhaPadrao; ?>" name="senhaClientePagMember">
    </div>
  </div>  
  
  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Data da Compra:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required value="<?php echo $dataCompra; ?>" name="DataCompraPagMember">
    </div>
  </div>  
  
  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Forma de Pagamento:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required value="<?php echo $tipoPagamento; ?>" name="TipoPagamentoPagMember">
    </div>
  </div>  
  
   <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Valor:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required value="<?php echo $valorProduto; ?>" name="PrecoPagMember">
    </div>
  </div>  
  
  <div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">ID da Transação:</label>
    <div class="col-sm-6">
<input type="text" class="form-control" required value="<?php echo $idTrasacao; ?>" name="IDTransacaoPagMember">
    </div>
  </div>  
  


<div class="form-group">
    <div class="col-sm-offset-5 col-sm-6">
      <button type="submit" class="btn btn-primary btn-lg">Atualizar Cliente</button>
    </div>
  </div> 
 </form>
 <?php
if(isset($_GET['atualizar']) && $_GET['atualizar'] == 'sim'){

$prefix = $wpdb->base_prefix;
$ccaptab = $prefix.'capabilities';

$ccaptab2 = $prefix.'optimizemember_paid_registration_times';
$pegaLevel1 = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$iduser' AND meta_key = '$ccaptab'");

$pegaLevel = unserialize($pegaLevel1);
$achalevel = array_search('optimizemember_',$pegaLevel);
$explolevel = explode('optimizemember_',$achalevel);
$levelDoAutor = $explolevel[1];


$email = $_POST['email'];
$usuario = $_POST['usuario'];


$senhaClientePagMember = $_POST['senhaClientePagMember'];
$DataCompraPagMember = $_POST['DataCompraPagMember'];
$TipoPagamentoPagMember = $_POST['TipoPagamentoPagMember'];
$IDTransacaoPagMember = $_POST['IDTransacaoPagMember'];
$PrecoPagMember = $_POST['PrecoPagMember'];


$dataCompraPM = $_POST['DataCompraPagMember'];
$converteDataCompra = strtotime($dataCompraPM);
$arrayL = array('level' => $converteDataCompra, $levelDoAutor => $converteDataCompra);
$levelCorreto = serialize($arrayL);


$grava = $wpdb->query("UPDATE $wpdb->users SET user_email = '$email' WHERE ID = '$iduser'");
$grava = $wpdb->query("UPDATE $wpdb->users SET user_login = '$usuario' WHERE ID = '$iduser'");


$grava = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$senhaClientePagMember' WHERE user_id = '$iduser' AND meta_key='senhaClientePagMember'");

$grava = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$DataCompraPagMember' WHERE user_id = '$iduser' AND meta_key='DataCompraPagMember'");

$grava = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$TipoPagamentoPagMember' WHERE user_id = '$iduser' AND meta_key='TipoPagamentoPagMember'");

$grava = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$IDTransacaoPagMember' WHERE user_id = '$iduser' AND meta_key='IDTransacaoPagMember'");

$grava = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$PrecoPagMember' WHERE user_id = '$iduser' AND meta_key='PrecoPagMember'");

$grava = $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$levelCorreto' WHERE user_id = '$iduser' AND meta_key='$ccaptab2'");
echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente&pg=clientes&edit='.$iduser.'&atualizar=nao">';
}
	
 ?>