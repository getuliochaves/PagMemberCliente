<?php
global $wpdb;
if($pg == 'relatorios'){	


$ChegouPost = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '80000000' AND meta_key = 'ChegouPOSTCLiente'");
$DadosPostCliente = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '80000000' AND meta_key = 'DadosPostCliente'");
$UsuariojaExiste = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '80000000' AND meta_key = 'UsuariojaExiste'");

if($ChegouPost == 'sim' && $UsuariojaExiste == ''){
	$UsuariojaExiste = 'nao';
	}
?>

<style>
.conteudoStatus{
	width:700px;
	height:100px;
	overflow:auto;
	}
</style>
<h4>Status do Relatório</h4>
<table class="table table-bordered">
        <thead>
          <tr class="success">
            <th width="30%">Item Teste</th>
			<th width="60%">Resultado</th>
          </tr>
        </thead>
        <tbody>
    
       
          <tr>
            <td><strong>Chegou o Post</strong></td>
            <td><?php echo $ChegouPost ?></td> 
		  </tr>
          
           <tr>
            <td><strong>DadosPostCliente</strong></td>
            <td><div class="conteudoStatus"><?php print_r(unserialize($DadosPostCliente)); ?></div></td> 
		  </tr>
          
           <tr>
            <td><strong>Usuario Ja Existe</strong></td>
            <td><?php echo $UsuariojaExiste ?></div></td> 
		  </tr>
          
      
		 
 
        </tbody>
      </table>	
      
   


<?php
};
?>