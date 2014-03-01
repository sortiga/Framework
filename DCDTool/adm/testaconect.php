<?php

$mysqli = new mysqli("localhost","root", "zanfre", "pucrj");

$query = $mysqli->prepare("SELECT * FROM usuario");
$query->execute();
$query->store_result();

$rows = $query->num_rows;
echo $rows;
?>