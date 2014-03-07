<?php
	session_start();
	require_once("../engine/conexao.php");
	require_once("../engine/funcoes.php");
	
	if($_POST){
		extract($_POST);
		$erros = array();
		//echo "POST";
        //echo "</br>";
		//echo "<pre>";
		//echo print_r($_POST);
		//echo "</pre>";
        //exit;
		if(!isset($conectado)){
		  $conectado = 0;
		}
		
		if($email == ""){
			$erros['email'] = "Campo obrigatório.";
			//echo "email";
			//echo "</br>";
		}
		
		if($senha == ""){
			$erros['senha'] = "Campo obrigatório.";
			//echo "senha";
			//echo "</br>";
		}
		
		if($erros == null){
			
			$SQL = "SELECT a.id, a.nome, a.tipo, a.instituicao_id, b.nome as instituicao_nome, b.sigla, b.dominio, b.url_web_service FROM usuario a, instituicao b WHERE email = '$email' AND senha = SHA1('$senha') AND a.instituicao_id = b.id;";
			//echo "SQL = $SQL";
			//echo "</br>";
			$resultado = mysqli_query($conexao,$SQL);
			
			//$query = $conexao->prepare($SQL);
            //$query->execute();
            //$query->store_result();

			//if ($result = $conexao->query($SQL)) {
            //   /* determine number of rows result set */
            //   $total = $result->num_rows;

            //   printf("Result set has %d rows.\n", $total);
            //   /* close result set */
			//	$result->close();
            //}
            //exit;
			
			
			$total = mysqli_num_rows($resultado); ///$query->num_rows;
			//echo "Total = $total";
			//echo "</br>";
			//exit;
			
			if($total != 1){
				$erros['senha'] = "Email e Senha Incorretos.";			
			}else{
				$linha = mysqli_fetch_array($resultado);				
				extract($linha);
				$_SESSION['user_id'] = $id;
				$_SESSION['user_name'] = $nome;
				$_SESSION['user_tipo'] = $tipo;
				$_SESSION['user_instituicao'] = $instituicao_id;
				$_SESSION['user_instituicao_nome'] = $instituicao_nome;
				$_SESSION['user_instituicao_sigla'] = $sigla;
				$_SESSION['user_instituicao_dominio'] = $dominio;
				$_SESSION['user_instituicao_webservice'] = $url_web_webservice;
				$_SESSION['autenticado'] = true;
				//$_SESSION['msg'] = "Teste de Mensagem";
				//echo "Criou SESSÃO";
				//echo "</br>";
				//echo "<pre>";
				//print_r($_SESSION);
				//echo "</pre>";
				//echo "Conectado = $conectado";
				//exit;
				if($conectado == 1){
				    //echo "Cookie criado";
					    setcookie("cookie","1234",time()+3600);  /* expire in 1 hour */	
					    setcookie("permissao",$tipo,time()+3600);  /* expire in 1 hour */	
					
				}
				//exit;
				if($tipo == 1){
					header("location: ./databases/index.php");			
				}else{
					header("location: ./databases/index.php");			
				}				
			}
		
		}	
	//exit;
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Apple iOS and Android stuff (do not remove) -->
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="../engine/css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../engine/css/text.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../engine/css/fonts/ptsans/stylesheet.css" media="screen" />

<link rel="stylesheet" type="text/css" href="../engine/css/core/form.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../engine/css/core/login.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../engine/css/core/button.css" media="screen" />

<link rel="stylesheet" type="text/css" href="../engine/css/mws.theme.css" media="screen" />

<!-- JavaScript Plugins -->
<script type="text/javascript" src="../engine/js/jquery-1.7.1.min.js"></script>

<!-- jQuery-UI Dependent Scripts -->
<script type="text/javascript" src="../engine/js/jquery-ui-effecs.min.js"></script>


<!-- Login Script -->

<title>ADM | Login</title>

</head>

<body>

    <div id="mws-login-wrapper">
        <div id="mws-login">
            <h1>Login</h1>
            <div class="mws-login-lock"><img src="../engine/css/icons/24/locked-2.png" alt="" /></div>
            <div id="mws-login-form">
                <form class="mws-form" action="" method="post">
                    <div class="mws-form-row">
                        <div class="mws-form-item large">
                            <input type="text" name="email" value="" class="mws-login-username mws-textinput required" placeholder="email" />
							<?php if(isset($erros['email'])){
		                             echo "<div class='error'>".$erros['email']."</div>";
		                             unset($erros['email']);	
	                              }
						    ?>
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <div class="mws-form-item large">
                            <input type="password" name="senha" class="mws-login-password mws-textinput required" placeholder="senha" />
							<?php if(isset($erros['senha'])){
		                             echo "<div class='error'>".$erros['senha']."</div>";
		                             unset($erros['senha']);	
	                              }
						    ?>
                        </div>
                    </div>
				
                    <div class="mws-form-row">
                        <input type="submit" value="Login" class="mws-button green mws-login-button" />
                    </div>	 
					<div class="mws-form-row">
                        <input type="checkbox" name="conectado" value="1"/><span  style="color:white;text-decoration:none;"> Manter logado</span>					
                        
                    </div>
						<a href="esqueci-senha.php" style="color:white;text-decoration:none;">Lembrar Senha</a>
					                    
                    
                </form>
            </div>
        </div>
    </div>

</body>
</html>
