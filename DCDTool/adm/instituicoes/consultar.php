<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	//adm();
	mantemLogin();
	
	if($_GET){
	    //echo "<pre>";
		//print_r($_GET);
		//echo "</pre>";
		extract($_GET);
		//echo "ID = $id";
		//exit;
		
		$SQL = "Select Nome as nome, Sigla as sigla, descricao, url_web_service, dominio from instituicao where id = $id; ";
		//echo "SQL = $SQL";
		//exit;
		$resultado = mysqli_query($conexao,$SQL);
		$linha = mysqli_fetch_array($resultado);
	    //echo "<pre>";
		//print_r($linha);
		//echo "</pre>";
		//extract($_GET);
		//echo "ID = $id";
		//exit;
		extract($linha);	
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Consultar Instituição</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="nome">Instituição</label>
      <div class="mws-form-item large">
        <input type="text" id ="nome" name="nome" value="<?=$nome;?>" class="mws-textinput" disabled="disabled"/>
      </div>
      <label for="sigla">Sigla</label>
      <div class="mws-form-item large">
        <input type="text" id ="sigla" name="sigla" value="<?=$sigla;?>" class="mws-textinput" disabled="disabled"/>
      </div>
      <label for="descricao">Descricao</label>
      <div class="mws-form-item large">
        <input type="text" id ="descricao" name="descricao" value="<?=$descricao;?>" class="mws-textinput" disabled="disabled"/>
      </div> 
      <label for="dominio">Dominio</label>
      <div class="mws-form-item large">
        <input type="text" id ="dominio" name="dominio" value="<?=$dominio;?>" class="mws-textinput" disabled="disabled"/>
      </div> 
      <label for="url_web_service">URL do Web Service</label>
      <div class="mws-form-item large">
        <input type="text" id ="url_web_service" name="url_web_service" value="<?=$url_web_service;?>" class="mws-textinput" disabled="disabled"/>
      </div> 
    </div>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>
