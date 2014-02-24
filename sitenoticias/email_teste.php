<?php
//pega o servidor de email nativo do apache 

$headers1 = 'From: webmaster@example.com \r\n
            Reply-To: webmaster@example.com';
			

$headers = 'MIME-Version: 1.0 \r\n';
$headers .= 'Content-Type: text/html; charset=utf-8 \r\n';
$headers .= 'To: Mary<mary@example.com>, Kelly <kelly@example.com \r\n';
$headers .= 'From: Birthday Reminder <birthday@example.com> \r\n';
$headers .= 'Cc: birthdayarchive@example.com \r\n';
$headers .= 'Bcc: birthdaycheck@example.com \r\n';


phpmailer --> para poder colocar anexo 			

if(!mail($destinatario, $subject, $texto, $heders)){
  echo "Falha no envio do email ";
}
?>