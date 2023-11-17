<?php
//Variáveis globais
$idLigacao = 0;

//Funções
function inserirTag($conexao, $descricao, $obs)
{
  if (empty($conexao) || $descricao == null) {
    return false;
  }

  $SQL = 'INSERT INTO TAG(DESCRICAO, STATUS, OBS) VALUES(?,?,?)';
  $PARAMETERS = array($descricao, 'Ativo', $obs);
  $QUERY = sqlsrv_prepare($conexao, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Erro na preparação da INSERÇÃO: " . print_r(sqlsrv_errors(), true) . "');</script>";
    return false;
  }

  $resultado = sqlsrv_execute($QUERY);

  if ($resultado === false) {
    echo "<script>alert('Erro na execução da INSERÇÃO: " . print_r(sqlsrv_errors(), true) . "');</script>";
    return false;
  }

  sqlsrv_free_stmt($QUERY); // Libera os recursos do statement

  return true;
}

function inserirTipo($conexao, $descricao, $obs)
{
  if (empty($descricao)) {
    return false;
  }

  $SQL = 'INSERT INTO TIPO_INVESTIMENTO (DESCRICAO, STATUS, OBS) VALUES(?,?,?)';
  $PARAMETERS = array($descricao, 'Ativo', $obs);
  $QUERY = sqlsrv_prepare($conexao, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Erro na preparação da INSERÇÃO: " . print_r(sqlsrv_errors(), true) . "');</script>";
    return false;
  }

  $resultado = sqlsrv_execute($QUERY);

  if ($resultado === false) {
    echo "<script>alert('Erro na execução da INSERÇÃO: " . print_r(sqlsrv_errors(), true) . "');</script>";
    return false;
  }

  return true;
}

function inserirInvestimento($conexao, $dados)
{
  if (empty($dados) || !is_array($dados)) {
    return false;
  }

  $SQL = 'INSERT INTO INVESTIMENTO (ID_USUARIO, ID_TIPO_INVESTIMENTO, ID_TAG, DESCRICAO, QUANTIDADE_TOTAL, VALOR_TOTAL_APORTADO, PRECO_MEDIO, STATUS) VALUES(?,?,?,?,?,?,?,?); SELECT SCOPE_IDENTITY() AS novo_id;';
  $PARAMETERS = array($dados['id_usuario'], $dados['id_tipo'], $dados['id_tag'], $dados['descricao'], $dados['qnt_total'], $dados['vl_total'], $dados['preco_medio'], $dados['status']);
  $QUERY = sqlsrv_query($conexao, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Erro na preparação da INSERÇÃO de INVESTIMENTO: " . print_r(sqlsrv_errors(), true) . "');</script>";
    return false;
  } else {
    sqlsrv_next_result($QUERY);

    $row = sqlsrv_fetch_array($QUERY, SQLSRV_FETCH_ASSOC);
    global $idLigacao;
    $idLigacao = $row['novo_id'];

    if ($idLigacao == 0) {
      echo "<script>alert('Erro na preparação da pegar o ID de ligação.');</script>";
    }

  }

  return true;
}

function inserirMovimentacao($conexao, $dados)
{
  if (empty($dados) || !is_array($dados)) {
    return false;
  }

  $SQL = 'INSERT INTO INVESTIMENTO_MOV (ID_INVESTIMENTO, VALOR, DATA, QUANTIDADE_TOTAL, PRECO_MEDIO, OBS, STATUS) VALUES(?,?,?,?,?,?,?)';
  $PARAMETERS = array($dados['id_investimento'], $dados['valor'], $dados['data'], $dados['qnt_total'], $dados['preco_medio'], $dados['obs'], $dados['status']);
  $QUERY = sqlsrv_prepare($conexao, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Erro na preparação da INSERÇÃO de MOVIMENTAÇÃO: " . print_r(sqlsrv_errors(), true) . "');</script>";
    return false;
  }

  $resultado = sqlsrv_execute($QUERY);

  if ($resultado === false) {
    echo "<script>alert('Erro na execução da INSERÇÃO DE MOVIMENTAÇÃO: " . print_r(sqlsrv_errors(), true) . "');</script>";
    return false;
  }

  return true;
}

//Códigos da página e gatilhos
session_start();
//Inclui o arquivo de conexão.
include_once('connection.php');

if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['pass']) == true)) {
  unset($_SESSION['login']);
  unset($_SESSION['pass']);
  header('Location: index.php');
} else {
  $logado = $_SESSION['login'];
}

if (isset($_POST['logout'])) {
  unset($_SESSION['login']);
  unset($_SESSION['pass']);
  header('Location: index.php');
}

$SQL = 'SELECT INV.ID, INV.DESCRICAO, INV.QUANTIDADE_TOTAL, INV.VALOR_TOTAL_APORTADO, INV.PRECO_MEDIO FROM INVESTIMENTO INV WHERE INV.ID_USUARIO = ? AND STATUS = ? ORDER BY INV.VALOR_TOTAL_APORTADO DESC';
$PARAMETERS = array($_SESSION['id_user'], 'Ativo');
$QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);






if (isset($_POST['confirmInvestment'])) {
  //Cria as variáveis e atribui a elas os valores informados no form.
  $invDescription = $_POST['invDescription'];
  $invTipo = $_POST['invTipo'];
  $invTag = $_POST['invTag'];
  $invQuantity = $_POST['invQuantity'];
  $invValue = $_POST['invValue'];

  $hasType = false;
  $hasTag = false;

  if ($invQuantity < 0) {
    $invQuantity = 0;
  }

  if ($invValue < 0) {
    $invValue = 0;
  }

  //Calcula Preco Médio
  if ($invValue / $invQuantity > 0) {
    $invPrecoMedio = $invValue / $invQuantity;
  } else {
    $invPrecoMedio = 0;
  }

  //Procura o Tipo 
  $SQL = 'SELECT TIPO.ID, TIPO.DESCRICAO FROM TIPO_INVESTIMENTO TIPO  WHERE TIPO.DESCRICAO = ? and TIPO.STATUS = ?';
  $PARAMETERS = array($invTipo, 'Ativo');
  $QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Error in executing query for select TIPO_INVESTIMENTO(1).</br>');</script>";
    die(print_r(sqlsrv_errors(), true));
  } else {
    if (sqlsrv_num_rows($QUERY) > 0) {
      $rowType = sqlsrv_fetch_array($QUERY);
      $hasType = true;
    } else {
      $hasType = false;
    }
  }

  //Procura a Tag 
  $SQL = 'SELECT TAG.ID, TAG.DESCRICAO FROM TAG WHERE TAG.DESCRICAO = ? AND TAG.STATUS = ?';
  $PARAMETERS = array($invTag, 'Ativo');
  $QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Error in executing query for select TAG(1).</br>');</script>";
    die(print_r(sqlsrv_errors(), true));
  } else {
    if (sqlsrv_num_rows($QUERY) > 0) {
      $rowTAG = sqlsrv_fetch_array($QUERY);
      $hasTag = true;
    } else {
      $hasTag = false;
    }
  }

  //Se necessário faz as inserções e tenta novamente pesquisar
  if ($hasType == false) {
    if (!inserirTipo($conn, $invTipo, '')) {
      echo "<script>alert('Error while inserting Type, function inserirTipo.</br>');</script>";
    }
  }

  if ($hasTag == false) {
    if (!inserirTag($conn, $invTag, '')) {
      echo "<script>alert('Error while inserting TAG, function inserirTag.</br>');</script>";
    }
  }

  //Pesquisa pelo registro de Tipo inserido
  $SQL = 'SELECT TIPO.ID, TIPO.DESCRICAO FROM TIPO_INVESTIMENTO TIPO  WHERE TIPO.DESCRICAO = ? AND TIPO.STATUS = ?';
  $PARAMETERS = array($invTipo, 'Ativo');
  $QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Error in executing last resort select in TIPO_INVESTIMENTO.</br>');</script>";
    die(print_r(sqlsrv_errors(), true));
  } else {
    if (sqlsrv_has_rows($QUERY)) {
      $rowType = sqlsrv_fetch_array($QUERY);
    }
  }

  //Pesquisa pelo registro de TAG inserido
  $SQL = 'SELECT TAG.ID, TAG.DESCRICAO FROM TAG WHERE TAG.DESCRICAO = ? AND TAG.STATUS = ?';
  $PARAMETERS = array($invTag, 'Ativo');
  $QUERY = sqlsrv_query($conn, $SQL, $PARAMETERS);

  if ($QUERY === false) {
    echo "<script>alert('Error in executing last resort select in TAG.</br>');</script>";
    die(print_r(sqlsrv_errors(), true));
  } else {
    if (sqlsrv_has_rows($QUERY)) {
      $rowTAG = sqlsrv_fetch_array($QUERY);
    }
  }

  //Por final faz o cadastro de INVESTIMENTO
  if ($rowTAG !== null && $rowType !== null) {
    $dadosInvestimento = array(
      'id_usuario' => $_SESSION['id_user'],
      'id_tipo' => $rowType[0],
      'id_tag' => $rowTAG[0],
      'descricao' => $invDescription,
      'qnt_total' => $invQuantity,
      'vl_total' => $invValue,
      'preco_medio' => $invPrecoMedio,
      'status' => 'Ativo',
    );

    if (inserirInvestimento($conn, $dadosInvestimento)) {
      //Seleciona o último ID gerado.
      $sql = "SELECT SCOPE_IDENTITY() AS id";
      $stmt = sqlsrv_query($conn, $sql);

      if ($stmt !== false) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $idMestre = $row['id'];
      } else {
        // Trate o erro ao obter o último ID
        echo "ID Master selection failed: " . print_r(sqlsrv_errors(), true);
      }

      $dadosMovimentacao = array(
        'id_investimento' => $idLigacao,
        'valor' => $invValue,
        'data' => date("Y/m/d"),
        'qnt_total' => $invQuantity,
        'preco_medio' => $invPrecoMedio,
        'obs' => 'Primeira movimentação - Referente a criação do Investimento.',
        'status' => 'Ativo',
      );

      if (!inserirMovimentacao($conn, $dadosMovimentacao)) {
        echo "<script>alert('Error! Insertion at INVESTIMENTO_MOV failed.</br>');</script>";
      }

      $idLigacao = 0;

      echo "<script>alert('Investment registeres sucessfully.</br>');</script>";
      header('Location: home.php');
    } else {
      echo "<script>alert('Investment could not be registered.</br>');</script>";
    }
  } else {
    echo "Failed to insert record into INVESTMENT table. Do not has all the necessary data.";
  }

  sqlsrv_free_stmt($QUERY);
  sqlsrv_close($conn);
}

if (isset($_POST['confirmTag'])) {
  //Cria as variáveis e atribui a elas os valores informados no form.
  $tagDescription = $_POST['tagDescription'];
  $tagObservation = $_POST['tagObservation'];
  include_once('connection.php');

  if (inserirTag($conn, $tagDescription, $tagObservation)) {
    echo "<script>alert('Tag Record inserted sucessfully!');</script>";
  } else {
    echo "<script>alert('Error in insertion of TAG record!');</script>";
  }
}

if (isset($_POST['confirmType'])) {
  //Cria as variáveis e atribui a elas os valores informados no form.
  $typeDescription = $_POST['typeDescription'];
  $typeObservation = $_POST['typeObs'];
  include_once('connection.php');

  if (inserirTipo($conn, $typeDescription, $typeObservation)) {
    echo "<script>alert('Type Record inserted sucessfully!');</script>";
  } else {
    echo "<script>alert('Error in insertion of Type record!');</script>";
  }
}
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
          <a href="../php/home.php">
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
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Value</th>
                <th scope="col">Average Price</th>
                <th scope="col">...</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($rowInvestments = sqlsrv_fetch_array($QUERY, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $rowInvestments['ID'] . "</td>";
                echo "<td>" . $rowInvestments['DESCRICAO'] . "</td>";
                echo "<td>" . $rowInvestments['QUANTIDADE_TOTAL'] . "</td>";
                echo "<td>" . $rowInvestments['VALOR_TOTAL_APORTADO'] . "</td>";
                echo "<td>" . $rowInvestments['PRECO_MEDIO'] . "</td>";
                // Adicione mais colunas conforme necessário
                echo "</tr>";
              }
              ?>

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
      <button class="AddButtons" id="openCadType">
        <h2 class="AddText">Add Type</h2>
      </button>
      <button class="AddButtons" id="openCadTag">
        <h2 class="AddText">Add Tag</h2>
      </button>
    </div>
    <!---------------------- END OF RECENT UPDATES ---------------------->
  </div>
  <!---------------------- JANELAS POP UP CADASTROS ---------------------->
  <div id="cadInvestment">
    <div id="cadInvestmentContent">
      <h2 class="formTitle">Add Investment</h2>
      <form id="investmentForm" class="fieldDiv" style="margin-top:25px;" action="home.php" method="POST">
        <ul class="fieldList">
          <li class="signinItem">
            <div class="inputWithIcon">
              <input type="text" name="invDescription" placeholder="Description" required="">
              <i class="fas fa-signature" aria-hidden="true"></i>
            </div>
          </li>
          <li class="signinItem">
            <div class="inputWithIcon">
              <i class="fa-solid fa-list"></i>
              <input type="text" name="invTipo" placeholder="Tipo" required />
            </div>
          </li>
          <li class="signinItem">
            <div class="inputWithIcon">
              <i class="fa-solid fa-tag"></i>
              <input type="text" name="invTag" placeholder="Tag" required />
            </div>
          </li>
          <li class="signinItem">
            <div class="inputWithIcon">
              <i class="fa-solid fa-arrow-up-9-1"></i>
              <input name="invQuantity" type="number" id="decimalInput" step="0.01" placeholder="Quantity" required />
            </div>
          </li>
          <li class="signinItem">
            <div class="inputWithIcon">
              <i class="fa-solid fa-dollar-sign"></i>
              <input name="invValue" type="number" id="decimalInput" step="0.01" placeholder="Total Value" required />
            </div>
          </li>
        </ul>
        <div class="btnCtrlCads">
          <button id="closeCadInvestment" class="btnCancel"><i class="fa-solid fa-xmark"></i>Cancel</button>
          <button id="confirmInvestment" name="confirmInvestment" class="btnConfirm"><i
              class="fa-solid fa-check"></i>Confirm </button>
        </div>
      </form>
    </div>
  </div>
  <!-------------------------------------------->
  <div id="cadType">
    <div id="cadTypeContent">
      <h2 class="formTitle">Add Type</h2>
      <form id="typeForm" class="fieldDiv" style="margin-top:25px;" action="home.php" method="POST">
        <ul class="fieldList">
          <li class="signinItem">
            <div class="inputWithIcon">
              <input type="text" name="typeDescription" placeholder="Description" required="">
              <i class="fas fa-signature" aria-hidden="true"></i>
            </div>
          </li>
          <li class="signinItem">
            <div class="inputWithIcon">
              <input type="text" name="typeObs" placeholder="Obs">
              <i class="fas fa-signature" aria-hidden="true"></i>
            </div>
          </li>
        </ul>
        <div class="btnCtrlCads">
          <button id="closeCadType" class="btnCancel"><i class="fa-solid fa-xmark"></i>Cancel</button>
          <button id="confirmType" name="confirmType" class="btnConfirm"><i class="fa-solid fa-check"></i>Confirm
          </button>
        </div>
      </form>
    </div>
  </div>
  </div>
  <!-------------------------------------------->
  <div id="cadTag">
    <div id="cadTagContent">
      <h2 class="formTitle">Add TAG</h2>
      <form id="typeForm" class="fieldDiv" style="margin-top:25px;" action="home.php" method="POST">
        <ul class="fieldList">
          <li class="signinItem">
            <div class="inputWithIcon">
              <input type="text" name="tagDescription" placeholder="Description" required="">
              <i class="fas fa-signature" aria-hidden="true"></i>
            </div>
          </li>
          <li class="signinItem">
            <div class="inputWithIcon">
              <input type="text" name="tagObservation" placeholder="Obs">
              <i class="fas fa-signature" aria-hidden="true"></i>
            </div>
          </li>
        </ul>
        <div class="btnCtrlCads">
          <button id="closeCadTag" class="btnCancel"><i class="fa-solid fa-xmark"></i>Cancel</button>
          <button id="confirmTag" name="confirmTag" class="btnConfirm"><i class="fa-solid fa-check"></i>Confirm
          </button>
        </div>
      </form>
    </div>
  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../js/home.js"></script>
</body>

</html>