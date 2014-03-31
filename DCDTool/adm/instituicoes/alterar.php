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
		$total = mysqli_affected_rows($conexao);
	    //echo "<pre>";
		//print_r($linha);
		//echo "</pre>";
		//extract($_GET);
		//echo "ID = $id";
		//exit;
		extract($linha);	
        $desc_old = $descricao;
		$sigla_old = $sigla;
		$nome_old = $nome; 
		$dominio_old = $dominio;
		$url_web_service_old = $url_web_service;
	}
	
	
	if($_POST){
	    //echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		$tipodb = $_POST['tipodb'];
		
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
        
            If (!($desc_old == $descricao AND $sigla_old == $sigla AND $nome_old == $nome AND $dominio_old == $dominio AND $url_web_service_old == $url_web_service)){
			      $SQL = "UPDATE instituicao SET nome= '$nome', descricao ='$descricao', dominio = '$dominio', ";
			      $SQL = $SQL." sigla = '$sigla', url_web_service = '$url_web_service'  WHERE id =$id;";	
                  //echo "SQL = $SQL";
                  //echo "<br>";			
			      //exit;
			      mysqli_autocommit($conexao, FALSE);
			      mysqli_query($conexao,$SQL);
			         
			      $linhas_updated = mysqli_affected_rows($conexao);
			      //$linhas_updated = 0;
			      If ($linhas_updated <> 1) {
			         if (!($desc_old == $descricao AND $sigla_old == $sigla AND $nome_old == $nome AND $dominio_old == $dominio AND $url_web_service_old == $url_web_service)){
			             mysqli_rollback($conexao);
			             $_SESSION['msg'] = "Falha na atualização.  Tentativa de atualização afetaria $linhas_updated linha(s).";
			          }
                  } else {
			       	 mysqli_commit($conexao);
			         $_SESSION['msg'] = "Sucesso na alteração da Instituição.";
			      }	
			} else{
                $_SESSION['msg'] = "Falha - Nenhuma modificação foi realizada na definição da Instituição.";				
			}
			//mysqli_autocommit($conexao, TRUE);
			header("location: index.php");				
		} //else {
		  //echo "Entrei no Else";
		  //echo "<br>";
		//}
		
		
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Alterar Instituição</span>
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
  <?
     //$total = 0;
     if ($total == 0){ 
  ?>
        <input type="submit" value="Alterar" class="mws-button red" disabled="disabled" />
  <?
     }else{ 
  ?>
        <input type="submit" value="Alterar" class="mws-button red" />
  <?
     } 
  ?>

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
