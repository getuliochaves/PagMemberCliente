<?php
global $wpdb;
?>
<li <?php if($pg == ''){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmemberCliente">Home</a></li>
<li <?php if($pg == 'clientes'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmemberCliente&pg=clientes">Clientes</a></li>
<li <?php if($pg == 'autoresponder'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmemberCliente&pg=autoresponder">AutoResponder</a></li>
<li <?php if($pg == 'configuracoes'){ ?>class="active" <?php }; ?>><a href="admin.php?page=pagmemberCliente&pg=configuracoes">Configurações</a></li>
