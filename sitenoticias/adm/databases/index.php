<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	mantemLogin();
	logado();
	adm();
	

	include_once("../topo.php");
?>

        	<!-- Inner Container Start -->
         <!--   <div class="container"> -->
		  	<?php
				//exibeMSG($_SESSION['msg']);
				//unset($_SESSION['msg']);
			?>
		
<div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-table-1">Databases</span>
</div>
<div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
        <ul>
            <li><a href="inserir.php" class="mws-ic-16 ic-accept">Inserir Database</a></li>
        </ul>
    </div>
	
	<?php
	
		$SQL = "SELECT * FROM catalogo_database_clientsite ORDER BY idCatalogo_Database;";
		$resultado = mysqli_query($conexao, $SQL);
		// retorna o numero de linha da consulta.
		$total = mysqli_num_rows($resultado);
		
		if($total == 0){
			echo "Não existem Databases cadastrados no sistema.";		
		}else{
		?>
		 <table class="mws-datatable mws-table">
			<thead>
				<tr>
					<th>Descricao</th>                        
					<th colspan="2">Op&ccedil;&otilde;es</th>
				</tr>
			</thead>
			<tbody>
			<?php 				
				while($linha = mysqli_fetch_array($resultado)){
					extract($linha);
					//echo "Descricao: $descricao";
					//exit;					
					?>
					<tr>
						<td><?=$descricao;?></td>
						<td><a href="alterar.php?id=<?=$idCatalogo_Database;?>">Alterar</a></td>
						<td><a href="excluir.php?id=<?=$idCatalogo_Database;?>">Excluir</a></td>
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

<?php
	include_once("../rodape.php");
?>
