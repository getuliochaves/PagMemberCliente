<?php
global $wpdb;

$tipoToken = $_GET['tipoToken'];
$acao = $_GET['acao'];
$nomeToken = 'tokenPagMemberCliente#'.$tipoToken;

$itemToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$nomeToken'");
if(count($itemToken) == 0){
$grava = $wpdb->insert($wpdb->options, array('option_name' => $nomeToken,'option_value' => '0'));
$cadItemName = 'Cadastrar';	
	}else{
$cadItemName = 'Editar';		
		}
if($itemToken == '0'){
	$itemToken = '';
	}	
$txtCad = $cadItemName.' Tokem do '.$tipoToken;



?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<h3><?php echo $txtCad; ?></h3>
<br>


<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmemberCliente&pg=configuracoes&pg2=config&pg3=cad&tipoToken=<?php echo $tipoToken; ?>" name="formularioEnvio" id="formularioEnvio">

<div class="form-group">
    <label for="inputText" class="col-sm-2 control-label">Tokem <?php echo $tipoToken; ?>:</label>
    <div class="col-sm-8">
<input type="text" class="form-control" required placeholder="Ex: 2xpo89864ldk90ldi9907" value="<?php echo $itemToken; ?>" name="itemToken">
    </div>
  </div> 


 

<div class="form-group">
    <div class="col-sm-12">
    
      <button type="submit" class="btn btn-primary btn-lg col-sm-10" id="btnCad"><?php echo $txtCad; ?></button>
    </div>
  </div> 
 </form>

<script>
$a = jQuery.noConflict();
$a(document).ready(function(){
	
	
		$a('input[name=itemToken]').keyup(function(){
			$a(this).val($a(this).val().trim());	
		
	});
	
	
});
</script>