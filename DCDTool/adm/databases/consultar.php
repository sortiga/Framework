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
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Consultar Database</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="database">Database</label>
      <div class="mws-form-item large">
        <input type="text" id ="database" name="database" value="<?=$database;?>" class="mws-textinput" disabled="disabled"/>
      </div>
      <label for="schema">Schema</label>
      <div class="mws-form-item large">
        <input type="text" id ="schema" name="schema" value="<?=$schema;?>" class="mws-textinput" disabled="disabled" />
      </div>
      <label for="descricao">Descricao</label>
      <div class="mws-form-item large">
        <input type="text" id ="descricao" name="descricao" value="<?=$descricao;?>" class="mws-textinput" disabled="disabled" />
      </div>
		<?php
		   //Colocar aqui o c�digo para obter a descricao da option default
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
        <select name="tipodb" size="1" disabled="disabled">
		<?
		//Colocar aqui o c�digo para carregar as op��es 
   	    $SQL = "SELECT id_database, nm_database as nmdatabase FROM tipo_database order by id_database;";
 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		if($total == 0){
			echo "Tabela Tipo de Databases est� VAZIA!!!";		
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
