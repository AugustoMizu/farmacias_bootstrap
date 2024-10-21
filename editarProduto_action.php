<?php 
require "CRUDestoque.php";

$id = $_POST['idInput'];
$nome = $_POST['nomeInput'];
$preco = $_POST['precoInput'];
$quantidade = $_POST['quantidadeInput'];
$categoria = $_POST['categoriaSelect'];
$validade = $_POST['dataInput'];

$p = new crudEstoque($id, $nome, $preco, $quantidade, $categoria, $validade);

$editar = $p->editarProduto($p);
header("Location: pesquisaProduto.php?editar=" . $editar);
 exit();
?>