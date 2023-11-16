<?php
//Método de Signup
if (isset($_POST['signup'])) {
  //Cria as variáveis e atribui a elas os valores informados no form.
  $user = $_POST['user'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['password_2'];
  $terms = $_POST['terms'];

  if ($password != $confirm_password) {
    echo "<script>alert('The passwords are different. Please correct it.');</script>";
  } else {
    //Inclui o arquivo de conexão.
    include_once('connection.php');

    $password = md5($password);
    //Prepara o SQL e executa a Query
    $SQL = 'INSERT INTO USUARIO(LOGIN, EMAIL, SENHA, STATUS) VALUES(?,?,?,?)';
    $PARAMETERS = array($user, $email, $password, 'Ativo');
    $QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);

    if ($QUERY === false) {
      echo "<script>alert('Error in executing insert query for new user.</br>');</script>";
      die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($QUERY);
    sqlsrv_close($conn);
  }
}

//Método de Signin
if (isset($_POST['signin'])) {
  if (!empty($_POST['inEmailUser']) && !empty($_POST['inPassword'])) {
    session_start();
    include_once('connection.php');

    $emailOrUser = $_POST['inEmailUser'];
    $password = $_POST['inPassword'];

    $SQL = 'SELECT USU.* FROM USUARIO USU WHERE (USU.LOGIN = ? OR USU.EMAIL = ?) AND USU.SENHA = ?';
    $PARAMETERS = array($emailOrUser, $emailOrUser, md5($password));
    $QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);

    if ($QUERY === false) {
      echo "<script>alert('Error in executing query for Signin select user.</br>');</script>";
      die(print_r(sqlsrv_errors(), true));
    }

    /* Retrieve and display the results of the query. */
    if (sqlsrv_has_rows($QUERY) == true) {
      $_SESSION['login'] = $emailOrUser;
      $_SESSION['pass'] = $password;

      header('Location: home.php');
    } else {
      unset($_SESSION['login']);
      unset($_SESSION['pass']);

      header('Location: index.php');
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
  <link rel="stylesheet" href="../css/index.css" />
  <title>Tracker</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/0abe9d2537.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="TopHeader">
    <div>
      <button id="openPopupButton" class="Entrar">Login</button>
      <button id="openPopupButton1" class="Registrar">Register</button>
    </div>
    <div>
      <img class="TopHeaderLogo" src="../assets/images/tracker_logo_transparente.png" />
    </div>
  </div>
  <div class="WelcomeBlock">
    <h1 class="WelcomeText">Welcome to Tracker</h1>
    <p1 class="WelcomeFollowUp">An easy way to visualize your Wealth.</p1>
  </div>

  <div class="midle">
    <img class="SloganImage1" src="../assets/images/slogan_grapico.jpg" />
    <p class="Slogan">
      "Take Charge of Your Finances with Ease! Our Financial Control App -
      Where Your Money Finds Its Home. Empower your financial future with our
      user-friendly app that puts you in control of your money. Say goodbye to
      financial stress and hello to smart financial management. Use it now
      and start making your money work for you!" -Alvo Dumbledore
    </p>
    <img class="SloganImage2" src="../assets/images/empresário-está-empilhar-moedas.jpg" />
  </div>

  <div class="DivFooter">
    <div>
      <img class="LogoFooter" src="../assets/images/tracker_logo_transparente.png" />
    </div>
    <div>
      <ul class="ListasFooter">
        <li class="itens"><a class="Pidgeons"
            href="https://www.google.com/maps/@35.7040744,139.5577317,3a,75y,292.59h,72.2t/data=!3m6!1e1!3m4!1sgT28ssf0BB2LxZ63JNcL1w!2e0!7i13312!8i6656?entry=ttu">Tracker
            Business</a></li>
        <li class="itens"><a class="Pidgeons"
            href="https://www.google.com/maps/@35.7040744,139.5577317,3a,75y,292.59h,72.2t/data=!3m6!1e1!3m4!1sgT28ssf0BB2LxZ63JNcL1w!2e0!7i13312!8i6656?entry=ttu">Who
            We Are</a></li>
        <li class="itens"><a class="Pidgeons"
            href="https://www.google.com/maps/@35.7040744,139.5577317,3a,75y,292.59h,72.2t/data=!3m6!1e1!3m4!1sgT28ssf0BB2LxZ63JNcL1w!2e0!7i13312!8i6656?entry=ttu">Talk
            to Us</a></li>
      </ul>
      <ul class="ListasFooter">
        <li class="itens"><a class="Pidgeons"
            href="https://www.google.com/maps/@35.7040744,139.5577317,3a,75y,292.59h,72.2t/data=!3m6!1e1!3m4!1sgT28ssf0BB2LxZ63JNcL1w!2e0!7i13312!8i6656?entry=ttu">Use
            Terms</a></li>
        <li class="itens"><a class="Pidgeons"
            href="https://www.google.com/maps/@35.7040744,139.5577317,3a,75y,292.59h,72.2t/data=!3m6!1e1!3m4!1sgT28ssf0BB2LxZ63JNcL1w!2e0!7i13312!8i6656?entry=ttu">Privacy
            Policy</a></li>
        <li class="itens"><a class="Pidgeons"
            href="https://www.google.com/maps/@35.7040744,139.5577317,3a,75y,292.59h,72.2t/data=!3m6!1e1!3m4!1sgT28ssf0BB2LxZ63JNcL1w!2e0!7i13312!8i6656?entry=ttu">Socials</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- POP UP - Login/Register -->
  <div id="popup">
    <div id="popupContainer">
      <div class="buttonsForm">
        <div class="btnColor"></div>
        <button id="btnSignin">Sign in</button>
        <button id="btnSignup">Sign up</button>
      </div>
      <div>
        <form id="signin" action="index.php" method="POST">
          <ul style="margin-top: -30px">
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
          <button class="goBack" id="closePopupButton" formnovalidate>Back</button>
        </form>

        <form id="signup" action="index.php" method="POST">
          <ul style="margin-top: -30px">
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
            <input name="terms" type="checkbox" required />
            <span>Terms</span>
          </div>
          <button class="btnSignup" name="signup" type="submit">Sign up</button>
          <button class="goBack" id="closePopupButton" formnovalidate>Back</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../js/index.js"></script>

</body>

</html>