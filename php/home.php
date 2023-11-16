<?php
session_start();
if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['pass']) == true)) {
  unset($_SESSION['login']);
  unset($_SESSION['pass']);
  header('Location: login.php');
} else {
  $logado = $_SESSION['login'];
}

if (isset($_POST['logout'])) {
  unset($_SESSION['login']);
  unset($_SESSION['pass']);
  header('Location: index.php');
}
// TO-DO ---------- SELECT PARA PREENCHIMENTO DO GRID PG HOME
// include_once('connection.php');

// $SQL = 'SELECT INV.* FROM INVESTIMENTO INV WHERE INV.ID_USUARIO = ? AND STATUS="Ativo" ORDER BY INV.VALOR_TOTAL_APORTADO DESC';
// $PARAMETERS = array($emailOrUser, $emailOrUser, md5($password));
// $QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/home.css" />

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <title>Home</title>
  <script src="https://kit.fontawesome.com/0abe9d2537.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="HeaderApplication">
    <div>
      <img class="TopHeaderLogo" src="../assets/images/tracker_logo_transparente.png" />
    </div>
  </div>
  <!---------------------- END OF HEADER ---------------------->
  <div class="container">
    <aside>
      <div class="top">
        <div class="logo">
          <img src="../assets/images/tracker_logo_transparente.png" />
          <h2>Tra<span class="golden">cker</span></h2>
        </div>
      </div>
      <form id='sidebar' action='home.php' method='POST'>
        <div class="sidebar">
          <a href="#">
            <span class="material-symbols-outlined">home</span>
            <h3>Dashboard</h3>
          </a>

          <a href="#">
            <span class="material-symbols-outlined">manage_search</span>
            <h3>History</h3>
          </a>

          <a href="#">
            <span class="material-symbols-outlined">person</span>
            <h3>Account</h3>
          </a>
          <button class="btnLeftSide" name="logout" type="submit">
            <span class="material-symbols-outlined">logout</span>
            <h3>Logout</h3>
          </button>

        </div>
      </form>
    </aside>

    <main>
      <div class="frame">
        <h1>Dashboard</h1>
        <div class="insights">
          <div class="variable">
            <span class="material-symbols-outlined">account_balance_wallet</span>
            <div class="middle">
              <div class="lef">
                <h3>Variable Income</h3>
                <h1>$25,00</h1>
              </div>
              <div class="progress">
                <svg>
                  <circle cx="38" cy="38" r="36"></circle>
                </svg>
                <div class="number">
                  <p>81%</p>
                </div>
              </div>
            </div>
          </div>
          <!---------------------- END OF STOCKS ---------------------->
          <div class="fixed">
            <span class="material-symbols-outlined">attach_money</span>
            <div class="middle">
              <div class="lef">
                <h3>Fixed Income</h3>
                <h1>$25,00</h1>
              </div>
              <div class="progress">
                <svg>
                  <circle cx="38" cy="38" r="36"></circle>
                </svg>
                <div class="number">
                  <p>81%</p>
                </div>
              </div>
            </div>
          </div>
          <!---------------------- END OF FIXED INCOME ---------------------->
          <div class="cripto">
            <span class="material-symbols-outlined">currency_bitcoin</span>
            <div class="middle">
              <div class="lef">
                <h3>Cripto</h3>
                <h1>$25,00</h1>
              </div>
              <div class="progress">
                <svg>
                  <circle cx="38" cy="38" r="36"></circle>
                </svg>
                <div class="number">
                  <p>81%</p>
                </div>
              </div>
            </div>
          </div>
          <!---------------------- END OF CRIPTO ---------------------->
        </div>
        <!---------------------- END OF INSIGHTS ---------------------->
        <div class="investments">
          <h2>Investments</h2>
          <table>
            <thead>
              <tr>
                <th>Investments</th>
                <th>Quantity</th>
                <th>Average Price</th>
                <th>Total Value</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Vale</td>
                <td>42</td>
                <td>62.77</td>
                <td class="money">10.000</td>
                <td class="primary">Details</td>
              </tr>
              <tr>
                <td>Vale</td>
                <td>42</td>
                <td>62.77</td>
                <td class="money">10.000</td>
                <td class="primary">Details</td>
              </tr>
              <tr>
                <td>Vale</td>
                <td>42</td>
                <td>62.77</td>
                <td class="money">10.000</td>
                <td class="primary">Details</td>
              </tr>
              <tr>
                <td>Vale</td>
                <td>42</td>
                <td>62.77</td>
                <td class="money">10.000</td>
                <td class="primary">Details</td>
              </tr>
              <tr>
                <td>Vale</td>
                <td>42</td>
                <td>62.77</td>
                <td class="money">10.000</td>
                <td class="primary">Details</td>
              </tr>
            </tbody>
          </table>
          <a href="#">Show All</a>
        </div>
      </div>
    </main>
    <!---------------------- END OF MAIN ---------------------->
    <div class="right">
      <div class="top">
        <button id="menu-btn">
          <span class="material-symbols-outlined">menu</span>
        </button>
      </div>
      <div class="recent-updates">
        <h2>Indicators</h2>
        <div class="updates">
          <div class="update">
            <div class="profile-photo"></div>
            <div class="message">
              <p><b>Ibovespa</b> 145.000</p>
              <small class="money">Em alta</small>
            </div>
          </div>
          <div class="update">
            <div class="profile-photo"></div>
            <div class="message">
              <p><b>Nasdaq</b> 145.000</p>
              <small class="money">Em alta</small>
            </div>
          </div>
          <div class="update">
            <div class="profile-photo"></div>
            <div class="message">
              <p><b>Bitcoin</b> 145.000</p>
              <small class="money">Em alta</small>
            </div>
          </div>
          <div class="update">
            <div class="profile-photo"></div>
            <div class="message">
              <p><b>Ethereum</b> 145.000</p>
              <small class="money">Em alta</small>
            </div>
          </div>
        </div>
      </div>
      <div class="actions">
        <h2>Actions</h2>
      </div>
      <button class="AddButtons" id="openCadInvestment">
        <h2 class="AddText">Add Investments</h2>
      </button>
      <button class="AddButtons">
        <h2 class="AddText" id="openCadType">Add Type</h2>
      </button>
      <button class="AddButtons">
        <h2 class="AddText" id="openCadTag">Add Tag</h2>
      </button>
    </div>
    <!---------------------- END OF RECENT UPDATES ---------------------->
  </div>
  <!---------------------- JANELAS POP UP CADASTROS ---------------------->
  <div id="cadInvestment">
    <div id="cadInvestmentContent">
      <h2 class="formTitle">Add Investment</h2>
      <form class="fieldDiv" style="margin-top:25px;">
        <ul class="fieldList">
          <li class="signinItem">
            <i class="fa-solid fa-signature"></i>
            <input type="text" name="invDescription" placeholder="Description" required />
          </li>
          <li class="signinItem">
            <i class="fa-solid fa-list"></i>
            <input type="text" name="invTipo" placeholder="Tipo" required />
          </li>
          <li class="signinItem">
            <i class="fa-solid fa-tag"></i>            
            <input type="text" name="invTag" placeholder="Tag" />
          </li>
          <li class="signinItem">
            <i class="fa-solid fa-arrow-up-9-1"></i>
            <input name="invQuantity" type="number" id="decimalInput" step="0.01" placeholder="Quantity" />
          </li>
          <li class="signinItem">
            <i class="fa-solid fa-dollar-sign"></i>
            <input name="invValue" type="number" id="decimalInput" step="0.01" placeholder="Total Value" />
          </li>
        </ul>
      </form>

      <div class="btnCtrlCads">
        <button id="closeCadInvestment" class="btnCancel"><i class="fa-solid fa-xmark"></i>Cancel</button>
        <button class="btnConfirm"><i class="fa-solid fa-check"></i>Confirm </button>
      </div>
    </div>
  </div>
  <div id="cadType">
    <div id="cadTypeContent">


    </div>
  </div>
  <div id="cadTag">
    <div id="cadTagContent">

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../js/home.js"></script>
</body>

</html>