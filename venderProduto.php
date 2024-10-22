<?php
require "crudEstoque.php";

session_start(); // Inicie a sessão
// Verifica o tipo de usuário
$tipoUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['tipo'] : null;

$p = new crudEstoque();
$lista = [];
if (!empty($_GET['nomeInput'])) {
    $nome = trim($_GET['nomeInput']);
    $lista = $p->retornaPorNome($nome); // Passa o nome diretamente
}
if ($lista == false || empty($_GET['nomeInput'])) {
    $lista = $p->retornaTodosProdutos(); // Retorna todos os produtos se nenhum nome foi fornecido
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Augusto Mizu">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-png" href="./imgens/icon_navegador2.png">
    <title>Vender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<<body style="margin-left: 20%; margin-right: 20%; background-color: #83dbc9;">
    <div id="nav_bar_padrao" style="margin-bottom: 100px;"></div>
    <main>
        <section class="border border-3 rounded p-5 shadow" style="border: rgba(255, 0, 0, .5); background-color: #BFF7A3;">
            <form action="venderProduto.php" method="get">
                <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                    VENDER</h1>
                <div class="mb-3 w-50">
                    <label for="nomeInput">Digite um nome</label>
                    <div class="input-group">
                        <input type="text" name="nomeInput" id="nomeInput" class="form-control" placeholder="Nome" maxlength="30">
                        <button type="submit" class="btn btn-info ms-2">Consultar</button>
                        <button type="button" id="comprar" class="btn btn-success ms-2">Comprar</button>
                    </div>
                </div>
            </form>
            <form action="#" method="post">
                <table class="table table-bordered table-sm table-hover table-responsive text-center">
                    <thead>
                        <tr class="table-dark">
                            <th class="table-info">UNDs.</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Categoria</th>
                            <th>Validade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista as $pd) : ?>
                            <tr>
                                <td><input type="number" name="produtos[<?= $pd["ID_produto"] ?>][quantidade]" min="0" max="<?= $pd["quantidade"] ?>" placeholder="0" style="width: 50px;"></td>
                                <td><?= $pd["nome"] ?></td>
                                <td><?= $pd["preco"] ?></td>
                                <td><?= $pd["quantidade"] ?></td>
                                <td><?= $pd["categoria"] ?></td>
                                <td><?= $pd["data_validade"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </section>
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
    <script>
        document.getElementById('comprar').addEventListener('click', function() {
            const produtos = {};
            const inputs = document.querySelectorAll('input[name^="produtos["]');

            inputs.forEach(input => {
                const idProduto = input.name.match(/\[(.*?)\]/)[1]; // Captura o ID do produto no name do input
                const quantidade = parseInt(input.value);
                const preco = input.closest('tr').querySelector('input[type="hidden"]').value; // Captura o preço do produto do value

                // Verifica se a quantidade é maior que 0
                if (quantidade > 0) {
                    produtos[idProduto] = {
                        quantidade: quantidade,
                        preco: preco // Adiciona o preço ao objeto produtos
                    };
                }
            });

            // Verifica se há produtos selecionados
            if (Object.keys(produtos).length > 0) {
                // Constrói a query string manualmente
                const queryString = Object.keys(produtos)
                    .map(key => `produtos[${key}][quantidade]=${produtos[key].quantidade}&produtos[${key}][preco]=${produtos[key].preco}`)
                    .join('&');

                // Redireciona para a página de ação
                window.location.href = `venderProduto_action.php?${queryString}`;
            } else {
                alert("Por favor, selecione pelo menos um produto com quantidade maior que 0.");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>

</html>