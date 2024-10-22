<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Augusto Mizu">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-png" href="./imgens/icon_navegador2.png">
  <title>Início</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!--css menu-->
  <link rel="stylesheet" href="style_inicio.css">

</head>

<body style="background-color: #83dbc9;">
  <header>
    <div id="nav_bar_padrao" style="margin-bottom: 100px;"></div>
  </header>
  <main>
    <div class="config-container">
      <label for="" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        <h1>Menu Inicial</h1>
      </label>
      <div class="config-options">
        <div class="option">
          <label for="Estoque">Gerenciar Estoque</label>
          <div class="submenu">
            <h2>Gerenciar Estoque</h2>
            <ul>
              <a href="cadastroProduto.php">
                <li>Cadastrar Produto</li>
              </a>
              <a href="pesquisaProduto.php">
                <li>Visualizar/Consultar estoque</li>
              </a>
              <a href="consultarVendas.php">
                <li>Consultar vendas</li>
              </a>
            </ul>
          </div>
        </div>
        <a href="venderProduto.php">
          <div class="option">
            <label for="Vender">Vender</label>
          </div>
        </a>
        <a href="consultarVenda.php">
          <div class="option">
            <label for="produtos">Consultar vendas</label>
          </div>
        </a>
      </div>
    </div>
  </main>
  <script>
    // inclui a nav bar
    fetch('nav_bar_padrao.html')
      .then(response => response.text())
      .then(data => {
        document.getElementById('nav_bar_padrao').innerHTML = data;
      });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>