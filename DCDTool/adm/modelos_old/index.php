<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	//adm();
	mantemLogin();
	extract($_SESSION);

	if($_GET){
	    //echo "<pre>";
		//print_r($_GET);
		//echo "</pre>";
		extract($_GET);
		//$_SESSION['user_instituicao']
		//echo $id;
		//exit;
    }

	if($_POST){
	   extract($_POST);
       //echo $id_categoria;echo "<br>";
       //echo $idcategoria;   
	   
	   //PERCY É O COMANDO ABAIXO QUE TÁ DANDO MERDA...		
		
 	    //$resultado = mysqli_query($conexao,$SQL);
		//$total = mysqli_num_rows($resultado);
		//if($total == 0){
			//$_SESSION['msg'] = 'Categoria não cadastrada ou erro no acesso ao banco de dados.';		
   	        //header("location: index.php");	   
		//}else{
	        $_SESSION['database']=$iddatabase;
	        header("location: index_01.php");	   
		//}	
	   //echo $nmcategoria;
	   //exit;
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->

<?php
//	session_start();
//	require_once("../../engine/conexao.php");
//	require_once("../../engine/funcoes.php");
//	mantemLogin();
//	logado();
//	adm();
//  extract($_SESSION);	
   
//	include_once("../topo.php");
?>

<!-- Inner Container Start -->
         <!--   <div class="container"> -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
	 
		  	<?php
			    If (array_key_exists('msg',$_SESSION) AND $_SESSION['msg'] != null) {
				    exibeMSG($_SESSION['msg']);
				    unset($_SESSION['msg']);
				}
			    If (array_key_exists('user_instituicao',$_SESSION) AND $_SESSION['user_instituicao'] != null) {
				    $idInstituicao = $_SESSION['user_instituicao'];
				}				
				If (!(isset($id_database))){
				   If (!(isset($iddatabase))){ 
				      $id_database = 1;
				   }else{
				      $id_database = $iddatabase;
				   }
				}				
				
			?>
		
<div class="mws-panel grid_8">
   <div class="mws-panel-header">
      <span class="mws-i-24 i-table-1">Modelos</span>
   </div>
   <div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
	  <label for="idcategoria"><p style="font-size:16px">Database</p></label>
      <div class="mws-form-item large">
        <select name="idcategoria" size="1">
		<?
		//Colocar aqui o código para carregar as opções 
   	    $SQL = "SELECT idCatalogo_Database as iddatabase, database as nmdatabase, ´schema´ FROM catalogo_database Where id_instituicao = $idInstituicao order by database;";
 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		if($total == 0){
			echo "Tabela Catalogo_Database está VAZIA!!!";		
		}else{
   		    while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				//echo $id_database;echo "<br>";
				//echo "Tipo ".$tipodb;echo "<br>";
				//exit;
				?>
			   <option value=<?=$iddatabase;?> <?php marcaSelect($iddatabase,$id_database);?>><?=$nmdatabase;?></option>
        <?php
			   }
		}	
		?>
		</select>
      </div>
	<div class="mws-button-row">
		  <input type="submit" value="Consultar" class="mws-button orange" />
          <input type="hidden" name="id_database" value="<?=$iddatabase;?>"/>
		  <input type="hidden" name="nm_database" value="<?=$nmdatabase;?>"/>
    </div>	
</div>
</div>
</form>
</div>

<?php
	include_once("../rodape.php");
?>
