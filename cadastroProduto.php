<?php
$cadastrado = isset($_GET['cadastrado']) ? $_GET['cadastrado'] : null;
session_start(); // Inicie a sessão
// Verifica o tipo de usuário
$tipoUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['tipo'] : null;

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Augusto Mizu">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-png" href="./imgens/icon_navegador2.png">
  <title>Estoque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="margin-left: 25%; margin-right: 25%; background-color: #83dbc9;">
  <div id="nav_bar_padrao" style="margin-bottom: 100px;"></div>
  <main class="border border-3 rounded p-5 shadow" style="border: rgba(255, 0, 0, .5); background-color: #BFF7A3;">
    <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">CADASTRAR PRODUTOS</h1>
    <form action="cadastroProduto_action.php" method="post" id="formCadastro">
      <div class="mb-2 w-75">
        <label for="nomeInput">Nome do produto</label>
        <input type="text" name="nomeInput" class="form-control" maxlength="30" placeholder="Nome" required>
      </div>
      <div class="mb-2 d-flex col">
        <div class="w-50">
          <label for="precoInput">Preço</label>
          <input type="number" name="precoInput" step="0.01" min="0.01" placeholder="Preço" class="form-control w-50" required>
        </div>
        <div class="w-50">
          <label for="quantidadeInput">Quantidade</label>
          <input type="number" name="quantidadeInput" step="1" min="1" placeholder="Quantidade" class="form-control w-50" required>
        </div>
      </div>
      <div class="mb-2 d-flex col">
        <div class="w-50">
          <label for="categoriaInput">Categoria</label>
          <select name="categoriaSelect" id="categoriaSelect" class="form-control w-50" required>
            <option value="" disabled selected>Selecione...</option>
            <option value="ANALGÉSICOS">ANALGÉSICOS</option>
            <option value="ANTI-INFLAMATÓRIOS">ANTI-INFLAMATÓRIOS</option>
            <option value="ANTIBIÓTICOS">ANTIBIÓTICOS</option>
            <option value="ANTIVIRAIS">ANTIVIRAIS</option>
            <option value="ANTIFÚNGICOS">ANTIFÚNGICOS</option>
            <option value="ANTIDEPRESSIVOS">ANTIDEPRESSIVOS</option>
            <option value="ANSIOLÍTICOS">ANSIOLÍTICOS</option>
            <option value="ANTIPSICÓTICOS">ANTIPSICÓTICOS</option>
            <option value="ANTIHISTAMÍNICOS">ANTIHISTAMÍNICOS</option>
            <option value="ANTIHIPERTENSIVOS">ANTIHIPERTENSIVOS</option>
            <option value="DIURÉTICOS">DIURÉTICOS</option>
            <option value="IMUNOSSUPRESSORES">IMUNOSSUPRESSORES</option>
            <option value="OUTROS">OUTROS</option>
          </select>
        </div>
        <div class="w-50">
          <label for="dataInput">Validade</label>
          <input type="date" name="dataInput" class="form-control w-50" min="<?php echo date('Y-m-d'); ?>" placeholder="Selecione uma data..." required>
        </div>
      </div>
      <input type="submit" id="salvar" value="SALVAR" class="btn btn-success btn-lg mt-4 ">
    </form>
  </main>
  <script>
    const tipoUsuario = "<?php echo $tipoUsuario; ?>";

    if (tipoUsuario === 'COMUM') {
      // Carrega a barra de navegação comum
      fetch('nav_bar_comum.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('nav_bar_padrao').innerHTML = data;
        });
    } else {
      // Carrega a barra de navegação padrão
      fetch('nav_bar_padrao.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('nav_bar_padrao').innerHTML = data;
        });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
<script>
  // Alerta de produto cadastrado com sucesso
  document.addEventListener('DOMContentLoaded', function() {
    var cadastrado = <?php echo json_encode($cadastrado); ?> ?? null;

    if (cadastrado == "1") {
      alert('CADASTRADO COM SUCESSO!! (*^_^*)');
    } else if (cadastrado != null) {
      alert('ERRO: PRODUTO IDÊNTICO JÁ CADASTRADO TENTE NOVAMENTE (｡>﹏<｡)');
    }
  });
</script>