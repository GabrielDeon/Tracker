<?php
  //Método de Signup
  if(isset($_POST['signup'])){
    //Cria as variáveis e atribui a elas os valores informados no form.
    $user             = $_POST['user'];
    $email            = $_POST['email'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['password_2'];
    $terms            = $_POST['terms'];

    if($password != $confirm_password)
    {
      echo "<script>alert('The passwords are different. Please correct it.');</script>";      
    } 
    else {      
      //Inclui o arquivo de conexão.
      include_once('connection.php');
      
      $password = md5($password);
      //Prepara o SQL e executa a Query
      $SQL        = 'INSERT INTO USUARIO(LOGIN, EMAIL, SENHA, STATUS) VALUES(?,?,?,?)';
      $PARAMETERS = array($user, $email, $password, 'Ativo');               
      $QUERY      = sqlsrv_query($conn, $SQL, $PARAMETERS);

      if( $QUERY === false )
      {
        echo "<script>alert('Error in executing insert query for new user.</br>');</script>";      
        die( print_r( sqlsrv_errors(), true));
      }
      
      sqlsrv_free_stmt($QUERY);
      sqlsrv_close($conn);      
    }
  } 

  //Método de Signin
  if(isset($_POST['signin'])){
    if(!empty($_POST['inEmailUser']) && !empty($_POST['inPassword'])){   
      session_start();   
      include_once('connection.php');
      
      $emailOrUser = $_POST['inEmailUser'];
      $password    = $_POST['inPassword'];

      $SQL        = 'SELECT USU.* FROM USUARIO USU WHERE (USU.LOGIN = ? OR USU.EMAIL = ?) AND USU.SENHA = ?';
      $PARAMETERS = array($emailOrUser, $emailOrUser, md5($password));               
      $QUERY      = sqlsrv_query($conn, $SQL, $PARAMETERS);
      
      if( $QUERY === false )
      {
        echo "<script>alert('Error in executing query for Signin select user.</br>');</script>";      
        die( print_r( sqlsrv_errors(), true));
      }

      /* Retrieve and display the results of the query. */       
      if(sqlsrv_has_rows($QUERY) == true){
        $_SESSION['login'] = $emailOrUser;
        $_SESSION['pass']  = $password;
        
        header('Location: home.php');
      } else {
        unset($_SESSION['login']);
        unset($_SESSION['pass']);
        
        header('Location: login.php');
      }
      
      sqlsrv_free_stmt($QUERY);
      sqlsrv_close($conn);        
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css" />
    <script
      src="https://kit.fontawesome.com/0abe9d2537.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="TopHeader">
      <div>        
        <a href="../php/index.php">
          <img
           class="TopHeaderLogo"          
           src="../assets/images/tracker_logo_transparente.png"
          />
        </a>
      </div>
    </div>
    
    <div class="container">
      <div class="buttonsForm">
        <div class="btnColor"></div>
        <button id="btnSignin">Sign in</button>
        <button id="btnSignup">Sign up</button>
      </div>

      <div style="margin-top: -30px;">
        <form id="signin" action="login.php" method="POST">
          <ul>
            <li class="signinItem">
              <input type="text" name="inEmailUser" placeholder="Email/User" required />
              <i class="fas fa-envelope iEmail"></i>
            </li>
            <li class="signinItem">
              <input type="password" name="inPassword" placeholder="Password" required />
              <i class="fas fa-lock iPassword"></i>
            </li>
          </ul>

          <div class="divCheck">
            <input type="checkbox" />
            <span>Remember password</span>
          </div>          
          <button class="btnSignin" name="signin" type="submit" value="logar">Sign in</button>
        </form>

        <form id="signup" action="login.php" method="POST">
          <ul>
            <li class="signupItem">
              <input type="text" name="user" placeholder="User" required />
              <i class="fa-solid fa-user"></i>
            </li>
            <li class="signupItem">
              <input type="text" name="email" placeholder="Email" required />
              <i class="fas fa-envelope iEmail"></i>
            </li>
            <li class="signupItem">
              <input type="password" name="password" placeholder="Password" required />
              <i class="fas fa-lock iPassword"></i>
            </li>
            <li class="signupItem">
              <input type="password" name="password_2" placeholder="Confirm password" required />
              <i class="fas fa-lock iPassword2"></i>
            </li>
          </ul>
          <div class="divCheck">
            <input name="terms" type="checkbox" required/>
            <span>Terms</span>
          </div>
          <button class="btnSignup" name="signup" type="submit">Sign up</button>
        </form>
      </div>
    </div>
    <script src="../js/login.js"></script>
  </body>
</html>
