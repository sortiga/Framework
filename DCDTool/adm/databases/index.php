<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	mantemLogin();
	logado();
	adm();
    extract($_SESSION);	
    
	include_once("../topo.php");
?>

        	<!-- Inner Container Start -->
         <!--   <div class="container"> -->
		  	<?php
			    If (array_key_exists('msg',$_SESSION) AND $_SESSION['msg'] != null) {
				    exibeMSG($_SESSION['msg']);
				    unset($_SESSION['msg']);
				}
			?>
		
<div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-table-1">Databases</span>
</div>
<div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
        <ul>
            <li><a href="inserir.php?id=<?=$user_instituicao;?>" class="mws-ic-16 ic-accept">Inserir Database</a></li>
        </ul>
    </div>
	<?php
		$SQL = "SELECT * FROM catalogo_database where id_instituicao = ".$user_instituicao." ORDER BY idCatalogo_Database;";
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
					<th>Descri&ccedil;&atilde;o</th>                        
					<th colspan="5">Op&ccedil;&otilde;es</th>
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
						<td><center><a href="alterar.php?id=<?=$idCatalogo_Database;?>&id2=<?=$user_instituicao;?>">Alterar</a></center></td>
						<td><center><a href="excluir.php?id=<?=$idCatalogo_Database;?>">Excluir</a></center></td>
						<td><center><a href="consultar.php?id=<?=$idCatalogo_Database;?>">Consultar</a></center></td>
						<td><center><input type="submit" value="Sincronizar" class="mws-button blue"/></center></td>
						<td><center><input type="submit" value="Importar" class="mws-button blue"/></center></td>
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
