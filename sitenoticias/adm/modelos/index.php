<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	mantemLogin();
	logado();
	adm();
	

	include_once("../topo.php");
?>
<div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-table-1">Noticias</span>
</div>
<div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
        <ul>
            <li><a href="inserir.php" class="mws-ic-16 ic-accept">Inserir Noticias</a></li>
        </ul>
    </div>

			
			<table class="mws-datatable mws-table">
					<thead>
						<tr>
							<th><a href="index.php?tit=1">Titulo</a></th>                        
							<th><a href="index.php?ord=1">Data</a></th>                        
							<th colspan="2">Op&ccedil;&otilde;es</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($_GET['ord'] == 1){							
								$SQL = "SELECT id, titulo, DATE_FORMAT(data,'%d/%m/%Y') AS data FROM noticias ORDER BY data ASC;";
							}else{
								if($_GET['tit'] == 1){								
									$SQL = "SELECT id, titulo, DATE_FORMAT(data,'%d/%m/%Y') AS data FROM noticias ORDER BY titulo DESC;";
								}else{
									$SQL = "SELECT id, titulo, DATE_FORMAT(data,'%d/%m/%Y') AS data FROM noticias";
								}							
							}
							
							
							$resultado = mysqli_query($conexao,$SQL);
							while($linha = mysqli_fetch_array($resultado)){
								extract($linha);
								?>
								<tr>
									<td><?=$titulo?></td>
									<td><?=$data?></td>
									<td><a href="alterar.php?id=<?=$id;?>">Alterar</a></td>
									<?php
										if($_SESSION["user_tipo"] == 1){
										?><td><a href="excluir.php?id=<?=$id;?>">Excluir</a></td><?php								
										}									
									?>									
								</tr>								
								<?php
							}	
							?>
										
					</tbody>
				</table>			
		

</div>
</div>
<?php include("../rodape.php")?>
