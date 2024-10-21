<?php
require "crudEstoque.php";

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
    <title>Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .input-hover:hover {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }
    </style>
</head>

<body style="margin-left: 20%; margin-right: 20%; background-color: #83dbc9;">
    <div id="nav_bar_padrao" style="margin-bottom: 100px;"></div>
    <main>
        <section class="border border-3 rounded p-5" style="border: rgba(255, 0, 0, .5); backdrop-filter: blur(5px); backdrop-filter: hue-rotate(80deg);">
            <form action="pesquisaProduto.php" method="get">
                <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                    CONSULTAR PRODUTOS CADASTRADOS</h1>
                <div class="mb-3 w-50">
                    <label for="nomeInput">Digite um nome</label>
                    <div class="input-group">
                        <input type="text" name="nomeInput" id="nomeInput" class="form-control" placeholder="Nome" maxlength="30">
                        <button type="submit" class="btn btn-success ms-2">Consultar</button>
                    </div>
                    <div class="mb-3">
                        <label for="">Ordenar por:</label>
                        <div class="input-group">
                            <input type="button" value="Nome" class="form-control input-hover" onclick="sortData('nome')">
                            <input type="button" value="Validade" class="form-control input-hover" onclick="sortData('data_validade')">
                            <input type="button" value="Quantidade" class="form-control input-hover" onclick="sortData('quantidade')">
                        </div>
                    </div>
                </div>
            </form>
            <form action="#" method="post">
                <table class="table table-bordered table-sm table-hover table-responsive text-center">
                    <thead>
                        <tr class="table-dark">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Categoria</th>
                            <th>Validade</th>
                            <th class="table-danger" colspan="2">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista as $pd) : ?>
                            <tr>
                                <td><?= $pd["ID_produto"] ?></td>
                                <td><?= $pd["nome"] ?></td>
                                <td><?= $pd["preco"] ?></td>
                                <td><?= $pd["quantidade"] ?></td>
                                <td><?= $pd["categoria"] ?></td>
                                <td><?= $pd["data_validade"] ?></td>
                                <td><a style="margin-right: 2em;" href="editarProduto.php?id=<?= urlencode($pd["ID_produto"]); ?>&nome=<?= urlencode($pd["nome"]); ?>&quantidade=<?= urlencode($pd["quantidade"]); ?>&preco=<?= urlencode($pd["preco"]) ?>&categoria=<?= urlencode($pd["categoria"]) ?>&validade=<?= urlencode($pd["data_validade"]) ?>">Editar</a></td>
                                <td><a href="#" onclick='confirmarExclusao(<?= $pd["ID_produto"] ?>)'>Excluir</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </section>
    </main>

    </main>
    <script>
        // inclui a nav bar
        fetch('nav_bar_padrao.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('nav_bar_padrao').innerHTML = data;
            });
    </script>
    <script>
        ////////////////////// ordena a tabela por tipo
        function sortData(sortBy) {
            fetch(`sort.php?sortBy=${sortBy}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('tbody');
                    tableBody.innerHTML = null; // Limpa a tabela atual

                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${item.ID_produto}</td>
                        <td>${item.nome}</td>
                        <td>${item.preco}</td>
                        <td>${item.quantidade}</td>
                        <td>${item.categoria}</td>
                        <td>${item.data_validade}</td>
                        <td><a style="margin-right: 2em;" href="editarProduto.php?id=${encodeURIComponent(item.ID_produto)}&nome=${encodeURIComponent(item.nome)}&quantidade=${encodeURIComponent(item.quantidade)}&preco=${encodeURIComponent(item.preco)}&categoria=${encodeURIComponent(item.categoria)}&validade=${encodeURIComponent(item.data_validade)}">Editar</a></td>
                        <td><a href="#" onclick='confirmarExclusao(${encodeURIComponent(item.ID_produto)})'>Excluir</a></td>
                    `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Erro:', error));
        }
    </script>
    <script>
        ////////// caixa para corfirmar exclusão
        function confirmarExclusao(id) {
            const confirmacao = confirm("Você tem certeza que deseja excluir este produto? (ㆆ_ㆆ)");
            if (confirmacao) {
                // Redireciona para o script de exclusão com confirmação
                window.location.href = `excluirProduto.php?id=${id}&confirmar=true`;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>