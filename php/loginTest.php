<?php
session_start();


    if(isset($_POST['submit']) && !empty($_POST['Login']) && !empty($_POST['Senha']) ){
        include_once('config.php');
        $Login =   $_POST['Login'];     
        $Senha=  $_POST['Senha'];

        $sql = "SELECT * FROM usuarios WHERE Login = '$Login' and Senha = '$Senha'";
        $result = $conexao  -> query($sql);

        if(mysqli_num_rows($result)<1){
            unset($_SESSION['Login']);
            unset($_SESSION['Senha']);
            header('Location: index.php');

        }else{
            $_SESSION['Login'] = $Login;
            $_SESSION['Senha'] = $Senha;

            header('Location: home.php');
        }
        
    }
    else{
        header('Location: Login.php');
    }

?>