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
		//echo $id;
		//exit;
    }
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<?php
   if (!isset($nome)){
      $nome = null;
	}
   if (!isset($sigla)){
      $sigla = null;
	}
   if (!isset($dominio)){
      $dominio = null;
	}
   if (!isset($descricao)){
      $descricao = null;
	}
   if (!isset($url_web_service)){
      $url_web_service = null;
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
    <span class="mws-i-24 i-table-1">Instituições</span>
</div>
<div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
        <ul>
            <li><a href="inserir.php" class="mws-ic-16 ic-accept">Inserir Instituição</a></li>
        </ul>
    </div>
	<?php
		$SQL = "SELECT * FROM instituicao ORDER BY id;";
		If ($resultado = mysqli_query($conexao, $SQL)){
		// retorna o numero de linha da consulta.
		   $total = mysqli_num_rows($resultado);
		} else {
		   $total = 0;
		}
		if($total == 0){
			echo "Não existem Instituições cadastradas no sistema.";		
		}else{
		?>
		 <table class="mws-datatable mws-table"> 
			<thead>
				<tr>
					<th>Nome</th>                        
					<th colspan="3">Op&ccedil;&otilde;es</th>
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
						<td><?=$Nome;?></td>
						<td><center><a href="alterar.php?id=<?=$id;?>">Alterar</a></center></td>
						<td><center><a href="excluir.php?id=<?=$id;?>">Excluir</a></center></td>
						<td><center><a href="consultar.php?id=<?=$id;?>">Consultar</a></center></td>
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
