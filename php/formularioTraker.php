<?php
    if(isset($_POST['submit'])){
        include_once('config.php');
        $nome = $_POST['Nome'];
        $login =$_POST['Login'];
        $senha = $_POST['Senha'] ;
        $result = mysqli_query($conexao,"INSERT INTO usuarios (nome,login,senha) VALUES('$nome', '$login', '$senha')");
    }

?>

<!DOCTYPE html>
<html lang ='en'>
<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE.edge">
    <meta name="viewport" content="width= device-width", initial-scale="1.0">
    <title>Formulario | Traker</title>

    <link rel="stylesheet" type="text/css" href="../css/formularioTraker.css" />
 </head>
 <body>
 <a href="index.php">Voltar</a>

       <div class="box">
            <form action="formularioTraker.php" method="POST">
                <fieldset>
                    <legend>
                        <b>Fazer Cadastro na Traker</b>
                    </legend>
                    <br><br>
                    <div class="inputBox">
                        <input type="text" name="Nome" id="Nome" class="inputUser" required>
                        <label for="nome "class="LabelInput"> Nome completo</label>
                    </div>
                    <br><br>
                    <div class="inputBox">
                        <input type="text" name="Login" id="Login" class="inputUser" required>
                        <label for="Login " class="LabelInput"> Login</label>
                    </div>
                    <br><br>
                    <div class="inputBox">
                        <input type="password" name="Senha" id="Senha" class="inputUser" required>
                        <label for="Senha " class="LabelInput"> Senha</label>
                    </div>
                    <br><br>
                    <p> Status: </p>
                    
                    <br><br>
                        <input type="submit" name="submit" id="submit" >
                </fieldset>
            </form> 
        </div>
        <img align="bottom" src="C:\xampp\htdocs\Traker\Images\TRAKER.png"/>

 </body>
</html>