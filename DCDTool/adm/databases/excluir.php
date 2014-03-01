<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	adm();
	mantemLogin();
	
	if($_GET){
		extract($_GET);
		if(is_numeric($id)){
			$SQL = "DELETE FROM categorias WHERE id = $id"; 
			mysqli_query($conexao,$SQL);
			$_SESSION['msg'] = "Categoria excluida com sucesso.";
			header("location:index.php");
		}else{
			header("location: index.php");
		}
	}
	
	





?>