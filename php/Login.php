<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/Login.css">

</head>
<body>
<a href="index.php">Voltar</a>

    <div class="BoxLogin">
        <form action="loginTest.php" method="POST">
        <fieldset>
        <legend>Login</legend>
        <br><br>
        <div class="inputBox">
            <input type="text" name="Login" id="Login" class="inputUser" required>
            <label for="Login " class="LabelInput"> Login</label>
        </div>
        <br><br>
        <div class="inputBox">
            <input type="password" name="Senha" id="Senha" class="inputUser" required>
            <label for="Senha " class="LabelInput"> Senha</label>
            <br><br>
        <input class="inputSubmit" type="submit" name="submit" value="Enviar">
        </fieldset>
    </form>
    </div>
    <img align="bottom" src="C:\xampp\htdocs\Traker\Images\TRAKER.png"/>
</body>

</html>