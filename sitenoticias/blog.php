<?php
session_start();
require_once("./engine/conexao.php");
require_once("./engine/funcoes.php");
include("topo.php");
?>  
  <div id="contentWrap">
    <div id="breadcrumb">
      <h4>You are here <span class="breadcrumb_link"><a href="index.html">Home</a></span> / <span class="breadcrumb_link"><a href="#">Blog</a></span></h4>
    </div>
    <!-- end breadctum -->
    <div class="hr_line"></div>
    <div id="content-two-third">

      <?php
	      $SQL = "SELECT n.id, n.titulo, DATE_FORMAT(n.data,'%d/%m/%Y') as dataFormatada, substring(n.texto,1,100) as textoFormatado, u.nome as categoria, c.nome as autor, n.imagem  FROM NOTICIAS n, categorias c, usuarios u where n.categoria_id = c.id and n.autor_id = u.id ORDER BY DATA DESC;";
		  $resultado = mysqli_query($conexao,$SQL);
          $total = mysqli_num_rows($resultado);
		  $linha = mysqli_fetch_array($resultado);
          if($total == 0){
		  } else {
   		    while($linha = mysqli_fetch_array($resultado)){
			    extract($linha);
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
                            <p><?=$textoFormatado;?>
                            <br />
                            <a href="detalhes.php?id=<?=$id;?>" class="more">Leia mais</a></p>
					   </div>
                     </div>
                     <div class="hr"></div>
				<?php
            }				
		  } 
	  ?>
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
      
        <h4>Categories</h4>
        <div>
        
          <ul class="sidenav">
            <li><a href="#">Economy</a></li>
            <li><a href="#">Business</a></li>
            <li><a href="#">Nature</a></li>
            <li><a href="#">Design</a></li>
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
      
        <h4>Latest blog posts</h4>
        
        <div class="recent_post_main">
        
          <div class="recent_post">
            <div> <a href="#"><img src="images/blog/blog-recent-01.jpg" alt="First blog post" /></a>
              <p><a href="#">First blog post</a><br />
                <span class="recent_post_date">23 december 2010</span></p>
            </div>
          </div>
          
          <div class="recent_post">
            <div> <a href="#"><img src="images/blog/blog-recent-02.jpg" alt="Second blog post" /></a>
              <p><a href="#">Second blog post</a><br />
                <span class="recent_post_date">21 december 2010</span></p>
            </div>
          </div>
          
          <div class="recent_post">
            <div> <a href="#"><img src="images/blog/blog-recent-03.jpg" alt="Third blog post" /></a>
              <p><a href="#">Third blog post</a><br />
                <span class="recent_post_date">19 december 2010</span></p>
            </div>
          </div>
          
          <div class="recent_post">
            <div> <a href="#"><img src="images/blog/blog-recent-04.jpg" alt="Fourth blog post" /></a>
              <p><a href="#">Fourth blog post</a><br />
                <span class="recent_post_date">17 december 2010</span></p>
            </div>
          </div>
          
          <div class="recent_post">
            <div> <a href="#"><img src="images/blog/blog-recent-05.jpg" alt="Fifth blog post" /></a>
              <p><a href="#">Fifth blog post</a><br />
                <span class="recent_post_date">15 december 2010</span></p>
            </div>
          </div>
          
        </div>
      </div>
      <div class="blog_widget">
        <h4>Latest comments</h4>
        <div>
        
          <ul class="sidenav">
            <li><a href="#">Alex Gurghis</a> on <a href="#">Third blog post</a></li>
            <li><a href="#">John Doe</a> on <a href="#">First blog post</a></li>
            <li><a href="#">John Doe</a> on <a href="#">Fifth blog post</a></li>
            <li><a href="#">John Doe</a> on <a href="#">Second blog post</a></li>
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
    <div id="page-nav"> <span class="pages">page 3 of 6</span>
      <ul>
        <li><a href="#">&lt;</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li class="current"><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">&gt;</a></li>
      </ul>
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