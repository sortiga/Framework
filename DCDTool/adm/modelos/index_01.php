<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	//adm();
	mantemLogin();
	extract($_SESSION);

	If (isset($_SESSION['database'])){
  	   $id_database = $_SESSION['database'];
	   $SQL = "Select * from catalogo_database where idCatalogo_Database = $id_database;";
	   //echo $SQL;
	   //exit;
	   If ($resultado = mysqli_query($conexao, $SQL)){
		// retorna o numero de linha da consulta.
		   $total = mysqli_num_rows($resultado);
		} else {
		   $total = 0;
		}
		if($total == 0){
			$_SESSION['msg'] = "Não existem Databases cadastrados.";	
            header("location: index.php");			
		}else{
		   $linha = mysqli_fetch_array($resultado);
		   extract($linha);		   
		}
	   //echo $SQL;
	   //exit;
	   $nm_categ = $descricao;
	   //unset($_SESSION['categoria']);
    }
	//echo $id_categoria;
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
			?>
		
<div class="mws-panel grid_8">
   <div class="mws-panel-header">
      <span class="mws-i-24 i-table-1">Modelos do Database <?=$database." - ".$schema;?></span>
   </div>
   <div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
    </div>
	<?php
		$SQL = "Select * from Modelos where Catalogo_Database_idCatalogo_Database = $id_database;";
		//echo $SQL;
		//exit;	
		If ($resultado = mysqli_query($conexao, $SQL)){
		// retorna o numero de linha da consulta.
		   $total = mysqli_num_rows($resultado);
		} else {
		   $total = 0;
		}
		if($total == 0){
			echo "Não existem Tabelas cadastradas para este database.";		
		}else{
		?>
		 <table class="mws-datatable mws-table"> 
			<thead>
				<tr>
					<th>Modelo</th>                        
					<th colspan="3">Op&ccedil;&otilde;es</th>
				</tr>
			</thead>
			<tbody>
			<?php 				
				while($linha = mysqli_fetch_array($resultado)){
					extract($linha);
					//echo "idAssuntos: $idAssuntos";
					//exit;					
					?>
					<tr>
						<td><?=$nome;?></td>
						<td><center><a href="alterar.php?id=<?=$idModelos;?>&id2=<?=$id_database;?>">Alterar</a></center></td>
						<td><center><a href="excluir.php?id=<?=$idModelos;?>">Excluir</a></center></td>
						<td><center><a href="consultar.php?id=<?=$idModelos;?>">Consultar</a></center></td>
					</tr>					
					<?php	
				}			
			?>					
			</tbody>
		</table>	
		<?php		
		}	
	?>  
</div>
</div>
</form>
</div>

<?php
	include_once("../rodape.php");
?>
