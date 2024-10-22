<?php
require "CRUDestoque.php";
$p = new crudEstoque();

session_start();
$idUsuario = $_SESSION['id_usuario']; // Recupere o ID do usuário da sessão

// Verifica se a chave 'produtos' existe na query string
if (isset($_GET['produtos'])) {
    $produtos = $_GET['produtos'];

    foreach ($produtos as $idProduto => $dados) {
        $quantidade = $dados['quantidade']; // Captura a quantidade
        $preco = $dados['preco']; // Captura o preço

        $p->registrarVenda($idUsuario, $idProduto, $quantidade, $preco);
    }
    // Redireciona de volta para a página de vendas
    header("Location: venderProduto.php");
    exit();
} else {
    echo "Nenhum produto foi selecionado.";
}
