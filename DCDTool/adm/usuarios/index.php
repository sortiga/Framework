<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
//adm();
	mantemLogin();

	
/*	$servidor = "localhost";
	$usuario = "root";
	$senha = "zanfre";
	$banco = "aulaphp";
	
	$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
	
	if(mysqli_connect_error()){
		echo "Erro de Conexão ".mysqli_connect_error();
		exit;
	}
	
	mysqli_set_charset($conexao, "utf8");


	if($_COOKIE['cookie'] == "1234"){
		$_SESSION['autenticado'] = true;
		$_SESSION['user_tipo'] = $_COOKIE['permissao'];		
	}
	if($_SESSION['autenticado'] != true){
		header("location: ../index.php");	
	}
	if($_SESSION['user_tipo'] != 1){
		header("location: ../index.php");	
	}
*/	

	include_once("../topo.php");
?>


        	<!-- Inner Container Start -->
            <div class="container">
		  	<?php
			    If (array_key_exists('msg',$_SESSION) AND $_SESSION['msg'] != null) {
				    exibeMSG($_SESSION['msg']);
				    unset($_SESSION['msg']);
				}
			?>


			
<div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-table-1">Usuarios</span>
</div>
<div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
        <ul>
            <li><a href="inserir.php" class="mws-ic-16 ic-accept">Inserir Usuarios</a></li>
        </ul>
    </div>
	
	<?php
	
		$SQL = "SELECT * FROM usuario ORDER BY nome;";
		$resultado = mysqli_query($conexao, $SQL);
		// retorna o numero de linha da consulta.
		$total = mysqli_num_rows($resultado);
		
		if($total == 0){
			echo "Não existem usuários cadastrados no sistema.";		
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
					?>
					<tr>
						<td><?=$nome;?></td>
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
</div>

<?php
	include_once("../rodape.php");
?>
