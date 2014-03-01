<?php

if($_POST){
	extract($_POST);
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
	  $assunto= "Mensagem enviada pelo Site. Enviado por $nome.";
	  $valor = mail($email,$assunto,$mensagem);
	  if (!$valor) {
	     echo "Falha de envio...";
	  }
	}
}
include("topo.php");
?>  
  <div id="contentWrap">
    <div id="breadcrumb">
      <h4>You are here <span class="breadcrumb_link"><a href="index.html">Home</a></span> / <span class="breadcrumb_link"><a href="#">Contact</a></span></h4>
    </div>
    <!-- end breadctum -->
    <div class="hr_line"></div>
    <div class="intro">
      <h2>Contact us</h2>
      <p>During the rest of that day there was no other adventure to mar the peace of their journey. Once, indeed, the Tin Woodman stepped upon a beetle that was crawling along the road, and killed the poor little thing. This made the Tin Woodman very unhappy, for he was always careful not to hurt any living creature; and as he walked along he wept several tears of sorrow and regret. These tears ran slowly down his face and over the hinges of his jaw, and there they rusted.</p>
    </div>
    <div class="hr_line"></div>
    <div id="content-two-third">
    <div class="contact-img"><img src="images/images/contact.jpg" alt="Map" /></div>
    <div class="two-third portfolio-detail">
        <p> Is that the way they heave in the marchant service? he roared. Spring, thou sheep-head; spring, and break thy backbone! Why don't ye spring, I say, all of ye&amp;mdash;spring! Quohog! spring, thou chap with the red <a href="#">whiskers</a>; spring there, Scotch-cap; spring, thou green pants. Spring, I say, all of ye, and spring your eyes out! And so saying, he moved along the windlass, here and there using his leg very freely, while imperturbable Bildad kept leading off with his psalmody.</p>
    </div>
    
    <div class="contact_form">
    
            <form action="mailer.php" method="post" class="contactform" />
            
              <input type="text" onfocus="if(this.value=='Name')this.value='';" onblur=
			  "if(this.value=='')this.value='Name';" name="nome" class="input-textarea"
			  value="Name" id="bname" />
              <?php exibeErros($erros['nome']);?>               
              <br />
              <br />
              
              <input type="text" onfocus="if(this.value=='Email')this.value='';" onblur=
			  "if(this.value=='')this.value='Email';" name="email" class="input-textarea" 
			  value="Email" id="bemail" />
              <?php exibeErros($erros['email']);?> 
              <br />
              <br />
              
              <textarea name="mensagem" cols="8" rows="5"></textarea>
              
              <br />
              
              <input name="Submit" type="submit" value="Submit" class="input-submit"/>
              <?php exibeErros($erros['mensagem']);?> 
      </div>
      
    </div>
    
    <div id="column" class="right">
      <div class="blog_widget">
        <h4>Sidebar menu</h4>
        <div>
            <ul class="sidenav">
              <li><a href="#">Our Mission</a></li>
              <li><a href="#">Our Philosophy</a></li>
              <li><a href="#">Our Services</a></li>
              <li><a href="#">Our Vision</a></li>
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