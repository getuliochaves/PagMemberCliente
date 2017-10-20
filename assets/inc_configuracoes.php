<?php
global $wpdb;
if($pg == 'configuracoes' && $pg2 == ''){
?>
<?php
$listaToken = $wpdb->get_results("SELECT option_value FROM $wpdb->options WHERE option_name like '%tokenPagMemberCliente#%'");
$contaToken = count($listaToken);

if($contaToken == 0){
	$msgnot = 'Você não possui tokens Ativados. Clique nos botões abaixo para Cadastrar.';
	$cadItemName = 'Cadastrar';
	}else{
	$msgnot = 'Você já possui tokens Ativados. Clique nos botões abaixo para Editar.';
	$cadItemName = 'Editar';
		}


?>

<div class="alert alert-success"><?php echo $msgnot; ?></div>


<a href="admin.php?page=pagmemberCliente&pg=<?php echo $pg; ?>&pg2=config&pg3=novo&tipoToken=PagSeguro&acao=gravar" class="btn btn-primary" value="Verificar Formulário"><?php echo $cadItemName; ?> Token <strong>PagSeguro</strong></a>

<a href="admin.php?page=pagmemberCliente&pg=<?php echo $pg; ?>&pg2=config&pg3=novo&tipoToken=Hotmart&acao=gravar" class="btn btn-primary" value="Verificar Formulário"><?php echo $cadItemName; ?> Token <strong>Hotmart</strong></a>

<a href="admin.php?page=pagmemberCliente&pg=<?php echo $pg; ?>&pg2=config&pg3=novo&tipoToken=Eduzz&acao=gravar" class="btn btn-primary" value="Verificar Formulário"><?php echo $cadItemName; ?> Token <strong>Eduzz</strong></a>

<a href="admin.php?page=pagmemberCliente&pg=<?php echo $pg; ?>&pg2=config&pg3=novo&tipoToken=Monetizze&acao=gravar" class="btn btn-primary" value="Verificar Formulário"><?php echo $cadItemName; ?> Token <strong>Monetizze</strong></a>

<?php
};
if($pg = 'configuracoes' && $pg2 == 'config'){
$pg = 'configuracoes';
switch($pg3){
	case $pg3;
	include_once($pg.'/'.$pg2.$pg3.'.php');
}
?>
 <?php
};
 ?>
