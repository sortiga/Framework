<?php



  $maior_dim[0]["owner"] = "BASE_PCC"; 
  $maior_dim[0]["table"] = "TAB1";

  $maior_dim[1]["owner"] = "BASE_PCC"; 
  $maior_dim[1]["table"] = "TAB2";

  $maior_dim[2]["owner"] = "BASE_PCC"; 
  $maior_dim[2]["table"] = "TAB3";

  $maior_dim[3]["owner"] = "BASE_PCC"; 
  $maior_dim[3]["table"] = "TAB4";

  $maior_dim[4]["owner"] = "BASE_PCC"; 
  $maior_dim[4]["table"] = "TAB5";
  
  $top = sizeof($maior_dim) - 1;
  
  echo $top;
  exit;
  
  echo "<pre>";
  print_r($maior_dim);
  echo "</pre>";

  if (in_array_table("TAB","BASE_PCC",$maior_dim)){
     echo "achou";
  }else{
     echo "NÃO achou";
  }
  
?>