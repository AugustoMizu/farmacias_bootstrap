<?php 
require "CRUDestoque.php";
$p = new crudEstoque(urldecode($_GET['id']));

$excluir = $p->excluirProduto($p);
header("Location: pesquisaProduto.php?excluir=" . $excluir);
exit();
?>