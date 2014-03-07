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
		$tipodb = $_POST['tipodb'];
		
		extract($_POST);
		$erros = array();
		
		if($descricao == ""){
			$erros['descricao'] = "Campo obrigatório.";
		}
		
		if($tipodb == ""){
			$erros['tipodb'] = "Campo obrigatório.";
		}
		
		if($database == ""){
			$erros['database'] = "Campo obrigatório.";
		}
		
		if($schema == ""){
			$erros['schema'] = "Campo obrigatório.";
		}
		
		if($erros == null){

			$SQL = "Select * from catalogo_database where `schema` = '$schema' and `database` = '$database' and id_instituicao = $id and Tipo_Database_idTipo_Database = $tipodb";
			mysqli_query($conexao,$SQL);
		    $linhas = mysqli_affected_rows($conexao);
            if($linhas > 0){
			     $_SESSION['msg'] = "Falha na Inserção. O esquema $schema do database $database já se encontra cadastrado nesta insttuição.";
			}else{
   		        $SQL = "INSERT INTO catalogo_database (`schema`, descricao, `database`, Tipo_Database_idTipo_Database, id_instituicao)  ";
			    $SQL = $SQL." values ( '$schema', '$descricao', '$database', $tipodb, $id); ";
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
			        $_SESSION['msg'] = "Sucesso na inclusão de um novo Database.";
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
   if (!isset($database)){
      $database = null;
	}
   if (!isset($schema)){
      $schema = null;
	}
   if (!isset($descricao)){
      $descricao = null;
	}
   if (!isset($tipodb)){
      $tipodb = 1;
	}
?>			                          
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Inserir Database</span>
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
