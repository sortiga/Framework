<?php 

	$servidor = "localhost";
	$usuario = "root";
	$senha = "zanfre";
	$banco = "pucrj";
	
	//$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
	
	$conexao = new mysqli($servidor, $usuario, $senha, $banco);
	
	if (mysqli_connect_errno()) {
       printf("Falha na conex�o ao banco local: %s\n", mysqli_connect_error());
       exit();
    }
//	if(mysqli_connect_error()){
//		echo "Erro de Conex�o ".mysqli_connect_error();
//		exit;
//	}
	
	mysqli_set_charset($conexao, "utf8");

?>