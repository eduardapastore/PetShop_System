<?php
include 'processa.php';

//CONSULTAR
$result = $conn->query("SELECT * FROM cliente");
$cliente = [];
whiçe($row = result ->fetch_assoc()){
    $cliente[] = $row; 
}
header

