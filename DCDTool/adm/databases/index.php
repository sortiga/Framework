﻿<?php
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
		//echo $id;
		//exit;
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
		  	<?php
			    If (array_key_exists('msg',$_SESSION) AND $_SESSION['msg'] != null) {
				    exibeMSG($_SESSION['msg']);
				    unset($_SESSION['msg']);
				}
			    If (array_key_exists('user_instituicao',$_SESSION) AND $_SESSION['user_instituicao'] != null) {
				    $idInstituicao = $_SESSION['user_instituicao'];
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
		If ($resultado = mysqli_query($conexao, $SQL)){
		// retorna o numero de linha da consulta.
		   $total = mysqli_num_rows($resultado);
		} else {
		   $total = 0;
		}
		if($total == 0){
			echo "Não existem Databases cadastrados no sistema.";		
		}else{
		?>
		 <table class="mws-datatable mws-table"> 
			<thead>
				<tr>
					<th>Descri&ccedil;&atilde;o</th>                        
					<th colspan="4">Op&ccedil;&otilde;es</th>
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
						<!--<td><center><input type="submit" value="Sincronizar2" name='Sincronizar2' class="mws-button blue"/></center></td>-->
						<!--<td><center><input type="submit" value="Importar" name='Importar' class="mws-button blue"/></center></td>-->
						<td><center><a href="importar2.php?id=<?=$idCatalogo_Database;?>&inst=<?=$idInstituicao;?>">Importar Modelos</a></center></td>
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
<div class="mws-button-row">
<?php
   if($total == 0){
?>   
      <a href="#">Sincronizar Databases</a>		
<?php
   } else{
?>
      <a href="sincronizar.php?inst=<?=$idInstituicao;?>">Sincronizar Databases</a>		
<?php
   }
?>
</div>

<?php
	include_once("../rodape.php");
?>
