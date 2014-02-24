<?php
$fatos["FATO1"] = 5;

/*        if(isset($variavel)) {
            echo $variavel;
        } else{
		echo "Não existe";
		}
*/
if(isset($dimensao["DIM1"])){
   $DIMENSAO["DIM1"]++;
   echo "Existe.  Total = ".$DIMENSAO['DIM1']; 
}else{
   $DIMENSAO["DIM1"] = 1;
   echo "Não Existe.  Total = ".$DIMENSAO['DIM1'];
}
?>

