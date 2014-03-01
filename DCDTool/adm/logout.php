<?php
	session_start();
	unset($_SESSION['user_id']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_tipo']);
	$_SESSION['autenticado'] = false;
	unset($_SESSION['autenticado']);
	setcookie("cookie");
	setcookie("permissao");
	header("location: index.php");
?>