<?php
    session_start();
	$servidor = "lod2.inf.puc-rio.br"; //"localhost";
	$usuario = "root";
	$senha = "casanova";//"zanfre";
	$banco = "pucrj";
	
	//$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
	
	$conexao = new mysqli($servidor, $usuario, $senha, $banco);
	
	if (mysqli_connect_errno()) {
       printf("Falha na conexão ao banco local: %s\n", mysqli_connect_error());
       exit();
    }
//	if(mysqli_connect_error()){
//		echo "Erro de Conexão ".mysqli_connect_error();
//		exit;
//	}

	mysqli_set_charset($conexao, "utf8");


?>

<form action="" name="frm" method="post">
	  <label for="categ">Categorias</label>
      <div class="mws-form-item large">
	  <select name="categ" size="1">
		<?
		//Colocar aqui o código para carregar as opções 
        if(isset($_POST['submit'])){
		   $categ = $_POST['categ'];
           $_SESSION['categ'] = $categ;		   
           $_SESSION['modelo'] = 1;
           $modelo = $_SESSION['modelo'];		   
		}
        if(isset($_POST['submit2'])){
		   $categ = $_SESSION['categ'];
           $modelo = $_SESSION['modelo'];		   
		}
        $SQL = "SELECT a.id as idcateg, a.nome as nmcateg FROM categoria_assunto a where (select count(*) from assuntos where id_categoria = a.id) order by nome;";
 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		if($total == 0){
			echo "Tabela Categoria_Assunto está VAZIA!!!";		
		}else{
   		    while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				//echo "ID ".$id_database;echo "<br>";
				//echo "Tipo ".$tipodb;echo "<br>";
				//exit;
				If ($idcateg == $categ){
        ?>
		           <option value=<?=$idcateg;?> selected><?=$nmcateg;?></option>
			<?
			    } else {
            ?>			
		           <option value=<?=$idcateg;?>><?=$nmcateg;?></option>
			<?   
			    }
            }
		}	
		?>
		</select>
      </div>
<input type="submit" name="submit" value="submit"> 
<br>
<?
 if(isset($_POST['submit2'])){
   $modelo = $_SESSION['modelo'];		       
   $categ = $_SESSION['categ'];		   
   $SQL = "Delete from assuntos_modelos where idModelos = $modelo and idAssuntos in (Select idAssuntos from assuntos where id_categoria = $categ);";
   $resultado = mysqli_query($conexao,$SQL);  
   if(isset($_POST['assunto'])){
      $assunto = $_POST['assunto'];
      foreach ($assunto as $hobys=>$value) {
        $SQL = "INSERT INTO assuntos_modelos (idModelos, idAssuntos) values ($modelo,$value);";
        $resultado = mysqli_query($conexao,$SQL);
      }
   } 
  }
?>

<?
 if(isset($_POST['submit']) or isset($_POST['submit2'])){
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
                    <input type="checkbox" checked="checked" name="assunto[]" value=<?=$idassunto;?>><?=$descassunto;?><br>
			<?   
                } else {
        ?>
                    <input type="checkbox" name="assunto[]" value=<?=$idassunto;?>><?=$descassunto;?><br>
			<?  
			    }
            }
		?>
			<input type="submit" name="submit2" value="submit2"> 
		<?  
		}	
		?>
      </div>
<? }
?>  
	  
</form>


