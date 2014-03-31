<?php

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
<?
	  if(isset($_POST['submit'])){
?>
	  <select name="categ" size="1"  disabled="disabled">

<?
 }else{ 
?>
	  <select name="categ" size="1">
<?
}
?>
		<?
		//Colocar aqui o código para carregar as opções 
   	    $SQL = "SELECT id as idcateg, nome as nmcateg FROM categoria_assunto order by nome;";
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
        ?>
		        <option value=<?=$idcateg;?>><?=$nmcateg;?></option>
			<?   
            }
		}	
		?>
		</select>
      </div>
<?
	  if(isset($_POST['submit'])){
?>
<input type="submit" name="submit" value="submit" disabled="disabled" > 
<?
 }else{ 
?>
<input type="submit" name="submit" value="submit"> 
<?
}
?>
<br>
<?
 if(isset($_POST['submit'])){
?>
	  <label for="tipodb">Assuntos</label>
      <div class="mws-form-item large">
		<?
		$categ = $_POST['categ'];	
        $modelo = 1;		
		//echo $categ;
		//exit;
		//Colocar aqui o código para carregar as opções 
   	    $SQL = "SELECT a.idAssuntos as idassunto, a.descricao as descassunto, b.idAssuntos ";
		$SQL = $SQL . " FROM Assuntos a LEFT JOIN assuntos_modelos b ON a.idAssuntos = b.idAssuntos AND b.idModelos = $modelo";  
        $SQL = $SQL . " WHERE id_categoria = $categ order by descricao; ";

 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		if($total == 0){
			echo "Sem Assuntos para esta categoria!!!";		
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
		}	
		?>
   <input type="submit" name="submit2" value="submit2" onclick="return confirm('Are you shure?')"> 
      </div>

   
<? }
?>  
<?
 if(isset($_POST['submit2'])){
   $assunto = $_POST['assunto'];

   foreach ($assunto as $hobys=>$value) {
             echo "Assunto : ".$value."<br />";
        }
  }
?>
	  
</form>