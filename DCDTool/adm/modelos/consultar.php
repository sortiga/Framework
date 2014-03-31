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
        $_SESSION['modelo'] = $id;
		
		$SQL = "SELECT * FROM modelos WHERE idModelos = $id;";
		//echo "SQL = $SQL";
		//exit;
		$resultado = mysqli_query($conexao,$SQL);
		
	    $linhas = mysqli_affected_rows($conexao);
		//echo "Linhas = $linhas";
		//exit;
        if($linhas > 0){
  		   $linha = mysqli_fetch_array($resultado);
		   extract($linha);		   

		   $SQL2 = "SELECT nome as nmtabela FROM tabelas WHERE idTabelas = $idFactTable;";
		   //echo "SQL = $SQL";
		   //exit;
		   $resultado2 = mysqli_query($conexao,$SQL2);
		   $linhas2 = mysqli_affected_rows($conexao);
           if($linhas > 0){
				$linha2 = mysqli_fetch_array($resultado2);
				extract($linha2);		   
			}else{
				$_SESSION['msg'] = "Falha - Não foi possível recuperar a Tabela Fato do modelo informado.";
				header("location: index_01.php");
			}		
	    }else{
		   $_SESSION['msg'] = "Falha - Não foi possível recuperar o modelo informado.";
		   header("location: index_01.php");
        }		

	    //echo "<pre>";
		//print_r($linha);
		//echo "</pre>";
		//extract($_GET);
		//echo "ID = $id";
		//exit;
	}

	if($_POST){
	  If (isset($_POST['retornar'])){
         header("location: index_01.php");
	  }
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Consultar Modelo</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

<?
        if(isset($_POST['selcateg'])){
		   $categ = $_POST['categ'];
           $_SESSION['categ'] = $categ;		   
           $modelo = $_SESSION['modelo'];		   
		}
?>   
    <div class="mws-form-row">
      <label for="nome">Modelo</label>
      <div class="mws-form-item large">
        <input type="text" id ="nome" name="nome" value="<?=$nome;?>" class="mws-textinput" disabled="disabled"/>
      </div>
      <label for="descricao">Descri&ccedil;&atilde;o</label>
      <div class="mws-form-item large">
        <input type="text" id ="descricao" name="descricao" value="<?=$descricao;?>" class="mws-textinput" disabled="disabled"/>
      </div>
      <label for="nmtabela">Tabela Fato do Modelo</label>
      <div class="mws-form-item large">
        <input type="text" id ="nmtabela" name="nmtabela" value="<?=$nmtabela;?>" class="mws-textinput" disabled="disabled" />
      </div>
	    <?
?>


	  <label for="categ">Categorias</label>
      <div class="mws-form-item large">
	  <select name="categ" size="1">
	    <?
        $SQL = "SELECT a.id as idcateg, a.nome as nmcateg FROM categoria_assunto a where ";
   		$SQL = $SQL. " a.id in (select id_categoria from assuntos where idAssuntos in (Select idAssuntos from Assuntos_Modelos where idModelos = $id )) order by nome;";
        //echo $SQL;exit;

 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		if($total == 0){
			echo "Modelo sem assuntos vinculados.";		
		}else{
   		    while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				//echo "ID ".$id_database;echo "<br>";
				//echo "Tipo ".$tipodb;echo "<br>";
				//exit;
        ?>
		           <option value=<?=$idcateg;?>><?=$nmcateg;?></option>
			<?   
			    
            }
		}	
		?>
		</select>
      </div>
      <input type="submit" name="selcateg" value="Obter Assuntos" class="mws-button orange" /> 
<?
	  if(isset($_POST['selcateg'])){
?>
    	  <label for="tipodb">Assuntos</label>
          <div class="mws-form-item large">
	    	<?
   		     //echo $categ;
		     //exit;
		     //Colocar aqui o código para carregar as opções 
		if(!isset($modelo)){
		   $modelo = $_SESSION['modelo'];		       
		}
		if(!isset($categ)){
		   $categ = $_SESSION['categ'];		       
		}
   	    $SQL = "SELECT a.idAssuntos as idassunto, a.descricao as descassunto, b.idAssuntos ";
		$SQL = $SQL . " FROM Assuntos a LEFT JOIN assuntos_modelos b ON a.idAssuntos = b.idAssuntos AND b.idModelos = $modelo";  
        $SQL = $SQL . " WHERE id_categoria = $categ order by descricao; ";

 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		if($total == 0){
			echo "Não existem assuntos cadastrados para esta categoria! Favor escolher outra";		
		}else{
   		    while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				//echo "ID ".$id_database;echo "<br>";
				//echo "Tipo ".$tipodb;echo "<br>";
				//exit;
				
				If ($idAssuntos == $idassunto) { 
        ?>
                    <input type="checkbox" checked="checked" disabled="disabled" name="assunto[]" value=<?=$idassunto;?>><?=$descassunto;?><br>
			<?   
                } else {
        ?>
                    <input type="checkbox" name="assunto[]" disabled="disabled" value=<?=$idassunto;?>><?=$descassunto;?><br>
			<?  
			    }
            }
		}	
		?>
      </div>
<? }
?>  
    </div>
</div>
<div class="mws-button-row">
    <input type="submit" name="retornar" value="Retornar" class="mws-button orange" />
	<input type="hidden" name="id" value="<?=$id;?>"/>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>
