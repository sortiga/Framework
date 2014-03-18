<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Apple iOS and Android stuff (do not remove) -->
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="../../engine/css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../engine/css/text.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../engine/css/fonts/ptsans/stylesheet.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../engine/css/fluid.css" media="screen" />

<link rel="stylesheet" type="text/css" href="../../engine/css/mws.style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../engine/css/icons/16x16.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../engine/css/icons/24x24.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../engine/css/icons/32x32.css" media="screen" />

<link rel="stylesheet" type="text/css" href="../../engine/css/sunny/jquery-ui-1.10.4.custom.css" media="screen" />


<!-- Demo and Plugin Stylesheets -->
<link rel="stylesheet" type="text/css" href="../../engine/css/demo.css" media="screen" />



<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="../../engine/css/mws.theme.css" media="screen" />

<!-- JavaScript Plugins -->
<script type="text/javascript" src="../../engine/js/jquery-1.7.2.min.js"></script>

<!-- jQuery-UI Dependent Scripts -->
<script type="text/javascript" src="../../engine/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="../../engine/js/jquery-ui-1.10.4.custom.min.js"></script>



<!-- Core Script -->
<script type="text/javascript" src="../../engine/js/core/mws.js"></script>

<!-- Themer Script (Remove if not needed) -->
<title>Painel | Meu Tema</title>

</head>

<body>
	<!-- Header -->
	<div id="mws-header" class="clearfix">

    	<!-- Logo Container -->
    	<div id="mws-logo-container">

        	<!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
        	<div id="mws-logo-wrap">
                   <h1 class="tit-topo">DCDTool</h1>
                    <!--
            	<img src="images/mws-logo.png" alt="mws admin" />
		-->
			</div>
        </div>

        <!-- User Tools (notifications, logout, profile, change password) -->
        <div id="mws-user-tools" class="clearfix">

            <!-- User Information and functions section -->
            <div id="mws-user-info" class="mws-inset">

            	
            	<!--<div id="mws-user-photo">
                	<img src="" alt="User Photo" />
                </div>-->
                 
                <!-- Username and Functions -->
                <div id="mws-user-functions">
                    <div id="mws-username">
                        Bem Vindo, <?php echo $_SESSION['user_name'];?>
                    </div>
                    <ul>
						<li><a href="../usuarios/alterar.php?id=<?=$_SESSION['user_id'];?>">Perfil</a></li>
                        <li><a href="../logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">

    	<!-- Necessary markup, do not remove -->
		<div id="mws-sidebar-stitch"></div>
		<div id="mws-sidebar-bg"></div>

        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">

        	       	
            <!-- Main Navigation -->
            <div id="mws-navigation">
                <ul>
					<?php
						if($_SESSION['user_tipo'] == 1){
					?>
                            <li><a href="../instituicoes/" class="mws-i-24 i-tag">Instituições</a></li>
					<?php						
						}					
					?>
                    <li><a href="../databases/" class="mws-i-24 i-tag">Databases</a></li>
					<li><a href="../modelos/" class="mws-i-24 i-tag">Modelos</a></li>
					<li><a href="../assuntos/" class="mws-i-24 i-tag">Assuntos</a></li>
                    
					<?php
						if($_SESSION['user_tipo'] == 1){
					?>
							<li><a href="../usuarios/" class="mws-i-24 i-user">Usuários</a></li>
					<?php						
						}					
					?>
					
                </ul>
            </div>
        </div>
        <div id="mws-container" class="clearfix">