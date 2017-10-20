<?php

$formasNotificacao = array('PagSeguro','Hotmart','Eduzz','Monetizze');
$contaFormas = count($formasNotificacao);

foreach($formasNotificacao as $valorNotificacao){
  $nTok = 'tokenPagMemberCliente#'.$valorNotificacao;
  $pegaDadosToken = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '$nTok'");

  if(($pegaDadosToken != '0') && ($pegaDadosToken != '')){
    $valorKey = array_search($valorNotificacao, $formasNotificacao);
    unset($formasNotificacao[$valorKey]);
  }
};//FIm Foreach Tokens e Apis

if(count($formasNotificacao) > 0){
?>

<!-- Inicio da DIV alert -->
<div class="alert alert-warning" style="width:93%; margin-top:20px;" role="alert">


<h4><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
<span class="sr-only">Erro:</span>
Configurações Pendentes</h4>

<!-- Inicio da Linha -->
<div class="row">
  <!-- Inicio Painel accordion -->
<div class="panel-group" id="accordion">
  <!-- Inicio Coluna 1 -->
  <div class="col-md-12" >


    <!-- Primeiro Panel -->
    <div class="panel panel-danger">
        <div class="panel-heading">
             <h4 class="panel-title"
                 data-toggle="collapse"
                 data-target="#collapseOne">
                 Cadastro de API Key e Tokens (Clique para ver os Detalhes)
             </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
          <ol style="padding:10px;">

            <?php
            foreach ($formasNotificacao as $TToken) {
            ?>

            <li>
              <a href="admin.php?page=pagmemberCliente&pg=configuracoes&pg2=config&pg3=novo&tipoToken=<?php echo $TToken; ?>&acao=gravar">
              <strong>Token <?php echo $TToken; ?>: </strong>Cadastre o Token <?php echo $TToken; ?>, Gerado na sua conta <?php echo $TToken; ?>.
              </a>
            </li>
            <?php
            };
            ?>

          </ol>
        </div>
    </div><!-- Fim Panel -->


  </div>   <!-- Fim Coluna 1 -->

</div> <!-- FIm Painel accordion -->

</div> <!-- Fim da Linha -->

</div> <!-- Fim da DIV alert -->

<script>
$a = jQuery.noConflict();
$a(document).ready(function(){

  var active = true;

  $a('#collapse-init').click(function () {
      if (active) {
          active = false;
          $a('.panel-collapse').collapse('show');
          $a('.panel-title').attr('data-toggle', '');
          $a(this).text('Enable accordion behavior');
      } else {
          active = true;
          $a('.panel-collapse').collapse('hide');
          $a('.panel-title').attr('data-toggle', 'collapse');
          $a(this).text('Disable accordion behavior');
      }
  });

  $a('#accordion').on('show.bs.collapse', function () {
      if (active) $a('#accordion .in').collapse('hide');
  });

});
</script>

<style>
.panel-heading{cursor: pointer;}
</style>
<?php
};
?>
