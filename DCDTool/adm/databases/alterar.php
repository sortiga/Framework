<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	adm();
	mantemLogin();
	
	if($_GET){
	    //echo "<pre>";
		//print_r($_GET);
		//echo "</pre>";
		extract($_GET);
		//echo "ID = $id";
		//exit;
		
		$SQL = "SELECT * FROM catalogo_database_clientsite WHERE idCatalogo_Database = $id;";
		//echo "SQL = $SQL";
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
	
	
	if($_POST){
	    //echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		extract($_POST);
		$erros = array();
		
		if($descricao == ""){
			$erros['descricao'] = "Campo obrigatório.";
		}
		
		if($porta == ""){
			$erros['porta'] = "Campo obrigatório.";
		} else {
		  if (!(is_numeric($porta))){
			$erros['porta'] = "Campo aceita apenas valores numéricos.";
		  } else {
		    if ((strlen($porta)>4) or (strlen($porta)<4)){
			   $erros['porta'] = "Porta é um campo de 4 dígitos numéricos.";
			}
		  }
		}

		if($Host == ""){
			$erros['Host'] = "Campo obrigatório.";
		}
		
		if($string_conexao == ""){
			$erros['stringconect'] = "Campo obrigatório.";
		}
		
		
		if($erros == null){
					
			$SQL = "UPDATE catalogo_database_clientsite SET string_conexao= '$string_conexao', descricao ='$descricao', host = '$Host', porta = '$porta' WHERE idCatalogo_Database =$idCatalogo_Database;";	
            //echo "SQL = $SQL";
            //echo "<br>";			
			//exit;
			mysqli_query($conexao,$SQL);
			$_SESSION['msg'] = "Database alterado com sucesso.";
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
    <span class="mws-i-24 i-list">Alterar Database</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="host">Host</label>
      <div class="mws-form-item large">
        <input type="text" id ="Host" name="Host" value="<?=$Host;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['Host'])){
			   exibeErros($erros['Host']);
			}
		?>			                          
      </div>
      <label for="host">Porta</label>
      <div class="mws-form-item large">
        <input type="text" id ="porta" name="porta" value="<?=$porta;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['porta'])){
			   exibeErros($erros['porta']);
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
      <label for="stringconect">String de Conexão</label>
      <div class="mws-form-item">
        <input type="text" id ="stringconect" name="stringconect" value="<?=$string_conexao;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['stringconect'])){
			   exibeErros($erros['stringconect']);
			}
		?>			                          
      </div>
    </div>
</div>
<div class="mws-button-row">
  <input type="submit" value="Alterar" class="mws-button red" />
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
