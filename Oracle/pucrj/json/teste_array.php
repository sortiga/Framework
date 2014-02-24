<?php

function in_array_table($text, $array)
{
    $column = "table"; 
    if (!empty($array) && is_array($array))
    {
        for ($i=0; $i < count($array); $i++)
        {
            if ($array[$i][$column]==$text || strcmp($array[$i][$column],$text)==0) return $i;
        }
    }
    return -1;
}

function in_array_owner($text, $posic, $array)
{
    if (!empty($array) && is_array($array))
    {
       if ($array[$posic]["owner"]==$text || strcmp($array[$posic]["owner"],$text)==0) return true;
    }
    return false;
}

function in_array_column($text, $column, $array)
{
    if (!empty($array) && is_array($array))
    {
        for ($i=0; $i < count($array); $i++)
        {
            if ($array[$i][$column]==$text || strcmp($array[$i][$column],$text)==0) return true;
        }
    }
    return false;
}

 function in_multiarray($elem, $array)
    {
        $top = sizeof($array) - 1;
        $bottom = 0;
        while($bottom <= $top)
        {
            if($array[$bottom] == $elem)
                return true;
            else 
                if(is_array($array[$bottom]))
                    if(in_multiarray($elem, ($array[$bottom])))
                        return true;
                    
            $bottom++;
        }        
        return false;
    }



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
  
  echo "<pre>";
  print_r($maior_dim);
  echo "</pre>";

  $posic = in_array_table("TAB1",$maior_dim);
  echo "Posic = $posic";
  echo "</br>";
  
  If ($posic > -1){
     If (in_array_owner("BASE_PCC",$posic,$maior_dim)) {
       echo "achou";
     }else{
       echo "NÃO achou";
     }
     echo "</br>";
  }else{
    echo "Posic retornou null";
	echo "</br>";
  }

  
?>