<?php
global $wpdb;
global $post;
$pg2 = $_GET['pg2'];
$salva = $_GET['salva'];
if($pg == 'autoresponder'){	
$pegaAutoResponder = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'autoresponderpagmember'");
if($pegaAutoResponder == ''){
	$grava = $wpdb->insert($wpdb->options, array('option_name' => 'autoresponderpagmember','option_value' => 'nao'));	
}

$idPaginaAutoResponder = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'paginaAutoReponderCli'");
if($idPaginaAutoResponder == ''){
	$grava = $wpdb->insert($wpdb->options, array('option_name' => 'paginaAutoReponderCli','option_value' => 'nao'));	
}

	if($pegaAutoResponder == '' or $pegaAutoResponder == 'nao' or $pg2 == ''){
		$msgnot = 'O AutoResponder Automático está desativado. Clique no botão ao lado para ativar.';
		$itemRel = 'Ativar';
		$itemRelAT = 'sim';
		$corRel = 'danger';
		$corRelRev = 'success';
		}
		
	if($pegaAutoResponder == 'sim'){
		$msgnot = 'O AutoResponder Automático está ativado. Clique no botão ao lado para Desativar.';
		$itemRel = 'Desativar';
		$itemRelAT = 'nao';
		$corRel = 'success';
		$corRelRev = 'danger';
	}
	
	if($_GET['editar'] == 'sim'){
		$msgAtualiza = 'Aguarde... Atualizando a página de Formulário!';
		$mostra = 'style="display:block;"';		
	}else{
		$mostra = 'style="display:none;"';	
		}


}
if($pg == 'autoresponder' && $pg2 != '' && $pg3 == 'grava'){
	if($pg2 == 'sim'){
	$msgnot = 'O AutoResponder Automático foi Ativado com Sucesso.';	
	$display = 'style="display:none;"';		
	$corRel = 'success';
}else{
	$msgnot = 'O AutoResponder Automático foi Desativado com Sucesso.';
	$display = 'style="display:none;"';	
	$corRel = 'success';	
	}
	
	$grava = $wpdb->query("UPDATE $wpdb->options SET option_value = '".$pg2."' WHERE option_name = 'autoresponderpagmember'");
	$pegaAutoResponder = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'autoresponderpagmember'");	
	
	echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente&pg=autoresponder">';
};
?>

<div class="alert alert-<?php echo $corRel; ?>"><?php echo $msgnot; ?> <a <?php echo $display; ?> href="admin.php?page=pagmemberCliente&pg=autoresponder&pg2=<?php echo $itemRelAT; ?>&pg3=grava" class="btn btn-<?php echo $corRelRev; ?>"><?php echo $itemRel; ?> AutoResponder Automático</a></div>


<?php 
if($pg == 'autoresponder' && $pegaAutoResponder == 'sim' && $pg2 != 'nova'){	
$nomeArProduto = 'ARPagMember#';
$pegaArProduto = $wpdb->get_results("SELECT option_value FROM $wpdb->options WHERE option_name like '%$nomeArProduto%'");

?>
<h4>Página do AutoResponder Automático</h4>

<table class="table table-bordered">
        <thead>
          <tr class="success">
           <th width="20%">Página do Produto</th>
            <th width="60%">Página do Formulário Autoresponder</th>
			<th width="20%">Remover</th>                    	
          </tr>
        </thead>
        <tbody>
        
        <?php
        foreach($pegaArProduto as $pegaOption){
			foreach($pegaOption as $valor){
				$listaAr0 = $pegaOption->option_value;
				$listaAr = unserialize($listaAr0);
				
				foreach($listaAr as $pgProduto => $pgFormulario){
					
								
				
								
		?>
        
        <tr>
          	<td width="20%"><a target="_blank" href="<?php echo get_permalink($pgProduto); ?>"><?php echo get_the_title($pgProduto); ?></a></td>
            <td width="60%"><a target="_blank" href="<?php echo get_permalink($pgFormulario); ?>"><?php echo get_the_title($pgFormulario); ?></a><br>
            <strong>Link Página Obrigado:</strong><br><?php echo get_permalink($pgProduto); ?>?bemvindo</td>
            
              <td width="20%">
              
              <a href="admin.php?page=pagmemberCliente&pg=autoresponder&pg2=nova&salva=excluir&id=<?php echo $pgProduto; ?>&idFormPm=<?php echo $pgFormulario; ?>" class="btn btn-danger btEnviaMsg">Excluir</a>
              </td>     
             
          </tr>
          
          <?php
				};
			};
		};
		  ?>
        
        
  </tbody>
      </table>
      
      <div class="form-group">
    <div class="col-sm-6">
      <a href="admin.php?page=pagmemberCliente&pg=autoresponder&pg2=nova&salva=criar" class="btn btn-primary btn-lg">Cadastrar AutoResponder</a>
    </div>
  </div>
      

<div class="alert alert-<?php echo $corRel; ?>" <?php echo $mostra; ?>><?php echo $msgAtualiza; ?></div>

<?php
if($_GET['editar']=='sim' && !empty($_POST)){
$idPagina = $_POST['paginaAutoReponderCli'];
$grava = $wpdb->query("UPDATE $wpdb->options SET option_value = '".$idPagina."' WHERE option_name = 'paginaAutoReponderCli'");
echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente&pg=autoresponder">';
}
?> 



<?php
};
if($pg == 'autoresponder' && $pegaAutoResponder == 'sim' && $pg2 == 'nova'){
if($salva == 'criar'){
?>

<h4>Selecione as Páginas do Seu Autoresponder e do Seu Produto</h4>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="admin.php?page=pagmemberCliente&pg=autoresponder&pg2=nova&salva=sim"> 

	<div class="form-group">   
    <label for="inputText" class="col-sm-4 control-label">Página do Formulário AutoResponder:</label>    
    <div class="col-sm-4">
      <select class="form-control" name="pgFormulario">
      
      <?php
	  
      $listaAutoResponder = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'publish'");	
		
		foreach($listaAutoResponder as $linhaEnvio){
		$nomePagina = $linhaEnvio->post_title;	
		$idPagina = $linhaEnvio->ID;	
	
		?>  
          <option value="<?php echo $idPagina; ?>"><?php echo $nomePagina; ?></option>         
          
          <?php
		};
		  ?>      
       </select>
       
    </div>
  </div>
  
  
  
  <div class="form-group">   
    <label for="inputText" class="col-sm-4 control-label">Página do produto deste AutoResponder:</label>    
    <div class="col-sm-4">
      <select class="form-control" name="pgProduto">
      
      <?php
	  
      $listaAutoResponder = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'publish'");	
		
		foreach($listaAutoResponder as $linhaEnvio){
		$nomePagina = $linhaEnvio->post_title;	
		$idPagina = $linhaEnvio->ID;	
	
		?>  
          <option value="<?php echo $idPagina; ?>"><?php echo $nomePagina; ?></option>         
          
          <?php
		};
		  ?>      
       </select>
       
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-6">
      <button type="submit" class="btn btn-primary btn-lg">Cadastrar Autoresponder para Este Produto</button>
    </div>
  </div>
  
</form> 
<?php
};
if($salva == 'excluir'){
	$idAr = $_GET['id'];
	$idFormulariopm = $_GET['idFormPm'];
	$nomeAr = 'ARPagMember#'.$idAr;
$deleta = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name = '$nomeAr'");
$deleta = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = 'formularioPm' AND post_id = '$idFormulariopm'");


echo 'Autoresponder removido com sucesso. Redirecionando...';
echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente&pg=autoresponder">';
}

if($salva == 'sim'){
$pgFormulario = $_POST['pgFormulario'];
$pgProduto = $_POST['pgProduto'];
$nomeArProduto = 'ARPagMember#'.$pgProduto;
$pegaArProduto = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$nomeArProduto'");
if($pegaArProduto == ''){
	
	$criaProduto = array($pgProduto => $pgFormulario);
	$produtoSer = serialize($criaProduto);
	$grava = $wpdb->insert($wpdb->options, array('option_name' => $nomeArProduto,'option_value' => $produtoSer));	
	$grava = $wpdb->insert($wpdb->postmeta, array('post_id' => $pgFormulario, 'meta_key' => 'formularioPm','meta_value' => 'sim'));	
	
	echo 'Autoresponder gravado com sucesso, redirecionando...';
	echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente&pg=autoresponder">';
	
}else{
	echo 'Autoresponder já Cadastrado para este produto.';
	echo '<meta http-equiv="refresh" content="0; url=admin.php?page=pagmemberCliente&pg=autoresponder">';
	}


	
	
}
	
	
};
  ?> 