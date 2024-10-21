<?php
require "CRUDestoque.php";
$p = new crudEstoque();

// Verifica se a chave 'produtos' existe na query string
if (isset($_GET['produtos'])) {
    $produtos = $_GET['produtos'];
   // $sudecido = [];
    // Exemplo de como iterar sobre os produtos
    foreach ($produtos as $idProduto => $quantidade) {
       $sudecido = $p->venderProduto($idProduto, $quantidade);
       /// colocar a função de salvar registro de venda
    }
    //var_dump($sudecido);
   // var_dump($produtos);
    header("Location: venderProduto.php");
    exit();
} else {
    echo "Nenhum produto foi selecionado.";
}
?>
