<?php
    $dbHost = '127.0.0.1';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'traker';
     
    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

   //if($conexao -> connect_errno){
   //     echo "ERRO";
   // }else{

   //     echo "FUNCIONOU";
   // }

?>