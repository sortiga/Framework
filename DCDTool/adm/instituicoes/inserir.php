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
		//echo $id;
		//exit;
    }
	
	if($_POST){
		extract($_POST);
		$erros = array();
		
		if($descricao == ""){
			$erros['descricao'] = "Campo obrigatório.";
		}
		
		if($nome == ""){
			$erros['nome'] = "Campo obrigatório.";
		}
				
		if($dominio == ""){
			$erros['dominio'] = "Campo obrigatório.";
		}
		
		if($erros == null){

			$SQL = "Select * from instituicao where nome = '$nome'; ";
			mysqli_query($conexao,$SQL);
		    $linhas = mysqli_affected_rows($conexao);
            if($linhas > 0){
			     $_SESSION['msg'] = "Falha na Inserção. A instituição $nome já se encontra cadastrada.";
			}else{
   		        $SQL = "INSERT INTO instituicao (nome, sigla, dominio, descricao, url_web_service)  ";
			    $SQL = $SQL." values ( '$nome','$sigla','$dominio','$descricao','$url_web_service'); ";
                //echo "SQL = $SQL";
                //echo "<br>";			
			    //exit;
			    mysqli_autocommit($conexao, FALSE);
			    mysqli_query($conexao,$SQL);
			    
			    $linhas_inserted = mysqli_affected_rows($conexao);
			    //$linhas_inserted = 0;
			    If ($linhas_inserted <> 1) {
		            mysqli_rollback($conexao);
		            $_SESSION['msg'] = "Falha na Inserção.  Tentativa de inserção afetaria $linhas_inserted linha(s).";
                } else {
			    	mysqli_commit($conexao);
			        $_SESSION['msg'] = "Sucesso na inclusão da nova Instituição.";
			    }	
			    //mysqli_autocommit($conexao, TRUE);
		    }
		    header("location: index.php");		
		} 
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<?php
   if (!isset($nome)){
      $nome = null;
	}
   if (!isset($sigla)){
      $sigla = null;
	}
   if (!isset($dominio)){
      $dominio = null;
	}
   if (!isset($descricao)){
      $descricao = null;
	}
   if (!isset($url_web_service)){
      $url_web_service = null;
	}
?>			                          
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Inserir Instituição</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="nome">Instituição</label>
      <div class="mws-form-item large">
        <input type="text" id ="nome" name="nome" value="<?=$nome;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['nome'])){
			   exibeErros($erros['nome']);
			}
		?>			                          
      </div>
      <label for="sigla">Sigla</label>
      <div class="mws-form-item large">
        <input type="text" id ="sigla" name="sigla" value="<?=$sigla;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['sigla'])){
			   exibeErros($erros['sigla']);
			}
		?>			                          
      </div>
      <label for="descricao">Descricao</label>
      <div class="mws-form-item large">
        <input type="text" id ="descricao" name="descricao" value="<?=$descricao;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['descricao'])){
			   exibeErros($erros['descricao']);
			}
		?>			                          
      </div> 
      <label for="dominio">Dominio</label>
      <div class="mws-form-item large">
        <input type="text" id ="dominio" name="dominio" value="<?=$dominio;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['dominio'])){
			   exibeErros($erros['dominio']);
			}
		?>			                          
      </div> 
      <label for="url_web_service">URL do Web Service</label>
      <div class="mws-form-item large">
        <input type="text" id ="url_web_service" name="url_web_service" value="<?=$url_web_service;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['url_web_service'])){
			   exibeErros($erros['url_web_service']);
			}
		?>			                          
      </div> 
    </div>
</div>
<div class="mws-button-row">
    <input type="submit" value="Inserir" class="mws-button red" />
	<input type="reset" value="Limpar" class="mws-button gray" />
	<input type="hidden" name="idCatalogo_Database" value="<?=$id;?>"/>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>

