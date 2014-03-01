<?php
session_start();
require_once("./engine/conexao.php");
require_once("./engine/funcoes.php");

if($_GET){
	extract($_GET);
	if(!is_numeric($id)){
		header("location: blog.php");		
	}
}

if($_POST){
	extract($_POST);
	
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$mensagem = $_POST['mensagem'];
	
	$erros = array();
		
	if($nome == "" or $nome == "Nome"){
		$erros["nome"] = "Campo Obrigatório.";
	}
	if($email == "" or $email == "Email"){
    	$erros["email"] = "Campo Obrigatório.";	
	}
	if($mensagem == ""){
		$erros["mensagem"] = "Campo Obrigatório.";	
	}	
	

	if($erros == null){	
		$SQL = "INSERT INTO comentarios VALUES(DEFAULT, '".$nome."', '".$email."','$mensagem',$noticia_id, NOW());";
		mysqli_query($conexao, $SQL);
		header("location: detalhes.php?id=$noticia_id");	
	}
}

include("topo.php");

?>  
  <div id="contentWrap">
    <div id="breadcrumb">
      <h4>You are here <span class="breadcrumb_link"><a href="index.html">Home</a></span> / <span class="breadcrumb_link"><a href="#">Blog-detail</a></span></h4>
    </div>
    <!-- end breadctum -->
    <div class="hr_line"></div>
    <div id="content-two-third">
      <?php
	      $SQL = "SELECT n.id, n.titulo, DATE_FORMAT(n.data,'%d/%m/%Y') as dataFormatada, ";
		  $SQL = $SQL." n.texto as textonot, u.nome as categoria, c.nome as autor, ";
		  $SQL = $SQL." n.imagem, u.curriculo, u.id as usuario_id, u.imagem as usuario_imagem ";  
		  $SQL = $SQL."  FROM NOTICIAS n, categorias c, usuarios u ";
		  $SQL = $SQL." where n.categoria_id = c.id and n.autor_id = u.id and n.id = $id;";
		  
//	      echo $SQL;
	///	  exit;
		  $resultado2 = mysqli_query($conexao,$SQL);
          $total2 = mysqli_num_rows($resultado2);
		  $linha2 = mysqli_fetch_array($resultado2);
          extract($linha2);
				?>
                	 <div class="blog">
                       <h4><?=$titulo?></h4>
                       <span class="post_date"><?=$dataFormatada;?></span> 
					   <span class="post_elements">
					      <span class="post_author"><?=$autor;?></span> 
						  <span class="post_tags"><a href="#"><??=$categoria;?></a></span> 
					   </span> 
					   <a href="detalhes.php?id=<?=$id;?>">
					       <img src="./adm/noticias/arquivos/<?=$id;?>/<?=$imagem;?>" alt="<?=$titulo;?>" width="610px" />
					   </a>
                       <div class="blogpost">
                            <p><?=$textonot;?>
					   </div>
                     </div>
                     <div class="hr"></div>
                     <div class="about_author">
                     	<h3>Sobre o autor</h3>
                       <div class="post_about_author">
                         	<img src="./adm/usuarios/<?=$usuario_id;?>/<?=$usuario_imagem;?>" alt="<?=$autor;?>" />
                           <h3>Escrito por <a href="#"><?=$autor;?></a></h3>
                           <p><?=$curriculo;?></p>
                       </div>
                     </div>
   <div class="blog_comments">
      <?php
	      $SQL = "SELECT nome, email, DATE_FORMAT(data,'%d/%m/%Y') as dataFormatadaComent, texto ";
		  $SQL = $SQL."  FROM comentarios ";
		  $SQL = $SQL." where noticias_id = $id order by data desc;";
		  
		//  echo $SQL;
		 //exit;
		  
		  $resultado3 = mysqli_query($conexao,$SQL);
          $total3 = mysqli_num_rows($resultado3);
		  $linha3 = mysqli_fetch_array($resultado3);
          
		  if ($total3 == 0) {
		    $msg = "Não existem comentários para este post. Seja o primeiro a comentar!!!";
          }	else {
		    if ($total3 == 1) {
		        $msg = "Existe 1 comentário para este post.";
            }	else {
			    $msg = "Existem $total3 comentário para este post.";
		    }
          }		  
		  ?>
         <h3><?=$msg;?></h3>
		 <?php
          if($total3 == 0){
		  
		  } else {
   		    while($linha3 = mysqli_fetch_array($resultado3)){
			    extract($linha3);
          ?>
            	<div class="comment_block">
                	<img src="images/blog/person-large.jpg" alt="<?=$nome;?>" />
                  <h3><?=$nome;?> - <?=$dataFormatadaComent;?></h3>
                  <p><?=$texto;?></p><a class="reply" href="#">Reply</a>
                </div>
				 <?php
            }				
		  } 
	  ?>
        <div class="comment_here">
            <h3>Comente este Post</h3>
            
            <form action="" method="post" class="contactform" />
            
            	
				
				<input type="text" onfocus="if(this.value=='Nome')this.value='';" onblur="if(this.value=='')this.value='Nome';" name="nome" class="input-textarea"  value="Nome" id="bname" />
                 <?php exibeErros($erros['nome']);?>              	
                <br />
              	<br />
                
              	<input type="text" onfocus="if(this.value=='Email')this.value='';" onblur="if(this.value=='')this.value='Email';" name="email" class="input-textarea" value="Email" id="bemail" />
              	<?php exibeErros($erros['email']);?>
                <br />
              	<br />
                
              	<textarea name="mensagem" cols="8" rows="5"></textarea>
              	<?php exibeErros($erros['mensagem']);?>
                <br />
                
              	<input name="Submit" type="submit" value="Comentar" class="input-submit"/>
              	<input type="hidden" name="noticia_id" value="<?=$id;?>" />
                
        </div>
      </div>
   	</div>
    <div id="column" class="right">
      <div class="blog_widget">
        <h4>Sponsors</h4>
        <div class="sponsors"> 
        
        <a href="@"><img src="images/blog/sponsor.jpg" alt="Sponsor name" /></a> 
        <a href="@"><img src="images/blog/sponsor.jpg" alt="Sponsor name" /></a> 
        <a href="@"><img src="images/blog/sponsor.jpg" alt="Sponsor name" /></a>
        <a href="@"><img src="images/blog/sponsor.jpg" alt="Sponsor name" /></a>
        
        </div>
      </div>
      
      <div class="blog_widget">
        <h4>Categorias</h4>
        <div>
          <ul class="sidenav">
		  <?php
	      $SQL = "SELECT nome as nomecat";
		  $SQL = $SQL."  FROM categorias; ";
		  
		//  echo $SQL;
		 //exit;
		  
		  $resultado4 = mysqli_query($conexao,$SQL);
          $total4 = mysqli_num_rows($resultado4);
          if ($total4 > 0){
   		      while($linha4 = mysqli_fetch_array($resultado4)){
			       extract($linha4);
		  ?>
                   <li><a href="#"><?=$nomecat;?></a></li>
		  <?php
		       }
			}
          ?>		  
          </ul>
        </div>
      </div>
      
      <div class="blog_widget">
      
        <h4>Archive</h4>
        <div>
          <ul class="sidenav">
            <li><a href="#">December 2010</a></li>
            <li><a href="#">November 2010</a></li>
            <li><a href="#">October 2010</a></li>
            <li><a href="#">September 2010</a></li>
            <li><a href="#">August 2010</a></li>
          </ul>
        </div>
      </div>
      
      <div class="blog_widget">
        <h4>Últimos Posts</h4>
        <div class="recent_post_main">
		  <?php
	      $SQL = "SELECT id as last_post_id, titulo as last_post_titulo, DATE_FORMAT(data,'%d/%m/%Y') as dataFormatada, imagem as last_post_imagem ";
		  $SQL = $SQL."  FROM noticias  Order by data desc; ";
		  
		//  echo $SQL;
		 //exit;
		  
		  $resultado5 = mysqli_query($conexao,$SQL);
          $total5 = mysqli_num_rows($resultado5);
          if ($total5 > 0){
		      $total5 = 5;
   		      while($linha5 = mysqli_fetch_array($resultado5) and $total5 > 0){
			       extract($linha5);
				   $total5--;
		  ?>
                   <div class="recent_post">
                     <div> <a href="#"><img src="./adm/noticias/arquivos/<?=$last_post_id;?>/<?=$last_post_imagem;?>" alt="<?=$last_post_titulo;?>" width="60px" /></a>
                       <p><a href="#"><?=$last_post_titulo;?></a><br />
                         <span class="recent_post_date"><?=$dataFormatada?></span></p>
                     </div>
                   </div>
		  <?php
		        }
			}
           ?>			
        </div>
      </div>
      
      <div class="blog_widget">
        <h4>Latest comments</h4>
        <div>
          <ul class="sidenav">
		  <?php
	      $SQL = "SELECT a.nome as nomeautor, b.titulo as noticia, c.nome as nomecateg ";
		  $SQL = $SQL."  FROM comentarios as a, noticias b, categorias c where a.noticias_id = b.id and b.categoria_id = c.id order by a.data desc; ";
		  
		//  echo $SQL;
		 //exit;
		  
		  $resultado6 = mysqli_query($conexao,$SQL);
          $total6 = mysqli_num_rows($resultado6);
		  
          if ($total6 > 0){
		      $total6 = 5;
   		      while($linha6 = mysqli_fetch_array($resultado6) and $total6 > 0){
			       extract($linha6);
				   $total6--;
		  ?>
                   <li><a href="#"><?=$nomeautor;?></a> em <a href="#"><?=$noticia;?></a></li>
		  <?php
		       }
			}
          ?>		  
          </ul>
        </div>
      </div>
      
      <div class="blog_widget">
      
        <h4>What clients said</h4>
        <div class="blockquote">
          <p> The old man looked at him and silently began to cry.   The weak tears of age rolled down his cheeks and all the feebleness of his eighty-seven years showed in his grief-stricken countenance. <cite>– Jack London</cite></p>
        </div>
      </div>
      
      <div id="twitter">
        <h4> <span class="icon">Latest tweet</span> <span class="alltweets"> <a href="http://www.twitter.com/agurghis">All tweets</a></span></h4>
        <div id="twitter_right"> Please wait while our tweets load <img src="images/images/indicator.gif" alt="loader" /></div>
      </div>
    </div>
    
  </div>
  <div id="footer">
    <h4>Full Moon © 2010 All rights reserved. Powered by: <span class="link"><a href="http://themeforest.net/user/agurghis?ref=agurghis" class="footer_link">Alex Gurghis</a></span></h4>
  </div>
  <div id="social"> <a href="#"><img src="images/social_media_buttons/facebook_alt.png" alt="Facebook" class="social_icons" title="Facebook"/></a><a href="#"><img src="images/social_media_buttons/twitter.png" alt="Twitter" class="social_icons" title="Twitter"/></a><a href="#"><img src="images/social_media_buttons/flickr.png" alt="Flickr" class="social_icons" title="Flickr"/></a><a href="#"><img src="images/social_media_buttons/delicious.png" alt="Delicious" class="social_icons" title="Delicious" /></a><a href="#"><img src="images/social_media_buttons/diigo.png" alt="Diigo" class="social_icons" title="Diigo" /></a><a href="#"><img src="images/social_media_buttons/email.png" alt="Email" class="social_icons" title="Email" /></a><a href="#"><img src="images/social_media_buttons/google.png" alt="Google buzz" class="social_icons" title="Google buzz" /></a><a href="#"><img src="images/social_media_buttons/lastfm.png" alt="Lastfm" class="social_icons" title="Lastfm" /></a><a href="#"><img src="images/social_media_buttons/linkedin.png" alt="Linkedin" class="social_icons" title="Linkedin" /></a><a href="#"><img src="images/social_media_buttons/myspace.png" alt="Myspace" class="social_icons" title="Myspace" /></a><a href="#"><img src="images/social_media_buttons/picasa.png" alt="Picasa" class="social_icons" title="Picasa" /></a><a href="#"><img src="images/social_media_buttons/posterous.png" alt="Posterous" class="social_icons" title="Posterous" /></a><a href="#"><img src="images/social_media_buttons/rss.png" alt="RSS" class="social_icons" title="RSS" /></a><a href="#"><img src="images/social_media_buttons/sharethis.png" alt="sharethis" class="social_icons" title="Share this" /></a><a href="#"><img src="images/social_media_buttons/stumbleupon.png" alt="Stumbleupon" class="social_icons" title="Stumbleupon" /></a><a href="#"><img src="images/social_media_buttons/technorati.png" alt="Technocrati" class="social_icons" title="Technorati" /></a><a href="#"><img src="images/social_media_buttons/youtube.png" alt="Youtube" class="social_icons" title="Youtube" /></a><a href="#"><img src="images/social_media_buttons/skype_alt.png" alt="Skype" class="social_icons" title="Skype" /></a><a href="#"><img src="images/social_media_buttons/dribble_alt.png" alt="Dribble" class="social_icons" title="Dribble" /></a><a href="#"><img src="images/social_media_buttons/vimeoo.png" alt="Vimeo" class="social_icons" title="Vimeo" /></a><a href="#"><img src="images/social_media_buttons/wordpress.png" alt="Blog" class="social_icons" title="Blog" /></a></div>
</div>

<div class="bottom">
</div>

<!-- twitter -->
<script src="Scripts/twitter.js" type="text/javascript"></script>
<script src="http://www.twitter.com/statuses/user_timeline/agurghis.json?callback=twitterCallback1&amp;count=1" type="text/javascript"></script>
<script src="http://www.twitter.com/statuses/user_timeline/agurghis.json?callback=twitterCallback2&amp;count=1" type="text/javascript"></script>

</body>
</html>