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
		
		$SQL = "SELECT descricao, Tipo_Database_idTipo_Database as tipodb, ";
		$SQL = $SQL." `database`, `schema` FROM catalogo_database WHERE idCatalogo_Database = $id;";
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
		$desc_old = $descricao;$schema_old = $schema;$tpdb_old = $tipodb;$db_old=$database;
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
		
		if($tipodb == ""){
			$erros['tipodb'] = "Campo obrigatório.";
		}// else { 
          //  $SQL = "SELECT id_database FROM tipo_database WHERE nm_database = $tipodb ";
 	      //  $resultado = mysqli_query($conexao,$SQL);
		  //  $linha = mysqli_fetch_array($resultado);
		  //  extract($linha);	
          //  $tipodb = $id_database;
        //}
		
		if($database == ""){
			$erros['database'] = "Campo obrigatório.";
		}
		
		if($schema == ""){
			$erros['schema'] = "Campo obrigatório.";
		}
		
		
		if($erros == null){
					
			$SQL = "UPDATE catalogo_database SET `schema`= '$schema', descricao ='$descricao', `database` = '$database', ";
			$SQL = $SQL."Tipo_Database_idTipo_Database = $tipodb  WHERE idCatalogo_Database =$id;";	
            //echo "SQL = $SQL";
            //echo "<br>";			
			//exit;
			mysqli_autocommit($conexao, FALSE);
			mysqli_query($conexao,$SQL);
			
			$linhas_updated = mysqli_affected_rows($conexao);
			//$linhas_updated = 0;
			If ($linhas_updated <> 1) {
			    if (!($desc_old = $descricao AND $schema_old = $schema AND $tpdb_old = $tipodb AND $db_old=$database)){
			        mysqli_rollback($conexao);
			        $_SESSION['msg'] = "Falha na atualização.  Tentativa de atualização afetaria $linhas_updated linha(s).";
				}
            } else {
				mysqli_commit($conexao);
			    $_SESSION['msg'] = "Sucesso na alteração do Database.";
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
    <span class="mws-i-24 i-list">Alterar Database</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="database">Database</label>
      <div class="mws-form-item large">
        <input type="text" id ="database" name="database" value="<?=$database;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['database'])){
			   exibeErros($erros['database']);
			}
		?>			                          
      </div>
      <label for="schema">Schema</label>
      <div class="mws-form-item large">
        <input type="text" id ="schema" name="schema" value="<?=$schema;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['schema'])){
			   exibeErros($erros['schema']);
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
		<?php
		   //Colocar aqui o código para obter a descricao da option default
		   $SQL = "SELECT nm_database FROM tipo_database WHERE id_database = $tipodb ";
		   //echo "SQL = $SQL";
		   //exit;
		   $resultado = mysqli_query($conexao,$SQL);
		   $linha = mysqli_fetch_array($resultado);
	       //echo "<pre>";
		   //print_r($linha);
		   //echo "</pre>";
		   //exit;
		   extract($linha);	
		?>			                          	  
	  <label for="tipodb">Tipo do Database</label>
      <div class="mws-form-item large">
        <select name="tipodb" size="1">
		<?
		//Colocar aqui o código para carregar as opções 
   	    $SQL = "SELECT id_database, nm_database as nmdatabase FROM tipo_database order by id_database;";
 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		if($total == 0){
			echo "Tabela Tipo de Databases está VAZIA!!!";		
		}else{
   		    while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				//echo "ID ".$id_database;echo "<br>";
				//echo "Tipo ".$tipodb;echo "<br>";
				//exit;
				if ($id_database == $tipodb) { 
        ?>
		           <option value=<?=$id_database;?> selected><?=$nmdatabase;?></option>
			<?  } else { ?>
		           <option value=<?=$id_database;?>><?=$nmdatabase;?></option>
			<?  } 
            }
		}	
		?>
		</select>
		<?php		    
            if (isset($erros['tipodb'])){
			   exibeErros($erros['tipodb']);
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
