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
		echo "GET ";
		echo "<br>";
		echo $_SESSION['categoria'];
		//echo $id;
		//exit;
    }

	if($_POST){
	   extract($_POST);
		extract($_GET);
		echo "POST ";
		echo "<br>";
		echo $_SESSION['categoria'];
       //echo $id_categoria;echo "<br>";
       //echo $idcategoria;
       //exit;	   
	}

	If (isset($_SESSION['categoria'])){
  	   $id_categoria = $_SESSION['categoria'];
	   $SQL = "Select * from categoria_assunto where id = $id_categoria;";
	   If ($resultado = mysqli_query($conexao, $SQL)){
		// retorna o numero de linha da consulta.
		   $total = mysqli_num_rows($resultado);
		} else {
		   $total = 0;
		}
		if($total == 0){
			$_SESSION['msg'] = "Não existem Assuntos cadastrados para esta categoria.";	
            header("location: index.php");			
		}else{
		   $linha = mysqli_fetch_array($resultado);
		   extract($linha);		   
		}
	   //echo $SQL;
	   //exit;
	   $nm_categ = $nome;
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
      <span class="mws-i-24 i-table-1">Assuntos da Categoria <?=$nm_categ;?></span>
   </div>
   <div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
        <ul>
            <li><a href="inserir.php?idcateg=<?=$id_categoria;?>" class="mws-ic-16 ic-accept">Inserir Assunto</a></li>
        </ul>
    </div>
	<?php
		$SQL = "SELECT * FROM assuntos where id_categoria = ".$id_categoria." ORDER BY id_categoria;";
		//echo $SQL;
		//exit;	
		If ($resultado = mysqli_query($conexao, $SQL)){
		// retorna o numero de linha da consulta.
		   $total = mysqli_num_rows($resultado);
		} else {
		   $total = 0;
		}
		if($total == 0){
			echo "Não existem Assuntos cadastrados para esta categoria.";		
		}else{
		?>
		 <table class="mws-datatable mws-table"> 
			<thead>
				<tr>
					<th>Descri&ccedil;&atilde;o</th>                        
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
						<td><?=$descricao;?></td>
						<td><center><a href="alterar.php?id=<?=$idAssuntos;?>&id2=<?=$id_categoria;?>">Alterar</a></center></td>
						<td><center><a href="excluir.php?id=<?=$idAssuntos;?>">Excluir</a></center></td>
						<td><center><a href="consultar.php?id=<?=$idAssuntos;?>">Consultar</a></center></td>
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
