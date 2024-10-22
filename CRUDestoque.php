<?php
require "configPDO.php";



class produtos
{

    protected $ID_produto;
    protected $nome;
    protected $preco;
    protected $quantidade;
    protected $categoria;
    protected $data_validade;

    function __construct($ID_produto = null, $nome = null, $preco = null, $quantidade = null, $categoria = null, $data_validade = null)
    {
        $this->ID_produto = $ID_produto;
        $this->nome = htmlspecialchars($nome);
        $this->preco = htmlspecialchars($preco);
        $this->quantidade = htmlspecialchars($quantidade);
        $this->categoria = htmlspecialchars($categoria);
        $this->data_validade = htmlspecialchars($data_validade);
    }
}
class crudEstoque extends produtos
{
    function cadastrarProduto(produtos $p)
    {

        $c = new Config();
        $pdo = $c->getPDO();

        $sql = $pdo->prepare("SELECT * FROM produtos WHERE nome = :nome AND categoria = :categoria AND data_validade = :data_validade");
        $sql->bindValue(':nome', $p->nome);
        $sql->bindValue(':categoria', $p->categoria);
        $sql->bindValue(':data_validade', $p->data_validade);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            // produto com nome, categoria e validade já cadastradas
            return false;
        } else {
            //cadastra o produto novo 
            $sql = $pdo->prepare("INSERT INTO produtos (nome, preco, quantidade, categoria, data_validade) VALUES (:nome, :preco, :quantidade, :categoria, :data_validade);");
            $sql->bindValue(':nome', $p->nome);
            $sql->bindValue(':preco', $p->preco);
            $sql->bindValue(':quantidade', $p->quantidade);
            $sql->bindValue(':categoria', $p->categoria);
            $sql->bindValue(':data_validade', $p->data_validade);

            if ($sql->execute()) {
                // cadastrardo com sucesso 
                return true;
            }
        }
    }

    function  retornaTodosProdutos() //retorna os protudos cadstrados como uma lista ordenada
    {
        $c = new Config();
        $pdo = $c->getPDO();

        $sql = $pdo->query("SELECT * FROM produtos");
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $lista = [];
            $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } else {
            //falha na consulta ao banco
            return false;
        }
    }

    function retornaPorNome($nome) // retorna todos regsitros encontrados com um mesmo nome
    {
        $c = new Config();
        $pdo = $c->getPDO();

        $sql = $pdo->prepare("SELECT * FROM produtos WHERE nome LIKE :nome");
        $sql->bindValue(':nome', $nome."%");
        $sql->execute();

        if ($sql->rowCount() > 0) {
            // retorna os registros encontrados
            $lista = [];
            $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } else {
            // nome não encontrado no banco
            return false;
        }
    }
    function excluirProduto(produtos $p){
        $c = new Config();
        $pdo = $c->getPDO();

        $sql = $pdo->prepare("DELETE FROM produtos WHERE ID_produto = :ID_produto");
        $sql->bindValue(':ID_produto', $p->ID_produto);

        if($sql->execute()){
            // excluido com sucesso
            return true;
        }else{
            // falhou
            return false;
        }
    }
    function editarProduto(produtos $p){
        $c = new Config();
        $pdo = $c->getPDO();

        $sql = $pdo->prepare("UPDATE produtos SET nome = :nome, preco = :preco, quantidade = :quantidade, categoria = :categoria, data_validade = :data_validade WHERE ID_produto = :ID_produto");
        $sql->bindValue(':nome' , $p->nome);
        $sql->bindValue(':preco', $p->preco);
        $sql->bindValue(':quantidade', $p->quantidade);
        $sql->bindValue(':categoria', $p->categoria);
        $sql->bindValue(':data_validade', $p->data_validade);
        $sql->bindValue(':ID_produto', $p->ID_produto);

        if($sql->execute()){
            // atualizado com sucesso
            return true;            
        }else{
            // falha na atualização
            return false;
        }
    }
    function registrarVenda($id_usuario, $id_produto, $quantidade, $preco) {
    $c = new Config();
    $pdo = $c->getPDO();

    //chama a procedure registrar venda
    $sql = $pdo->prepare("CALL registrarVenda(:id_usuario, :id_produto, :quantidade, :preco)"); 
    
    // Vincula os parâmetros
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->bindValue(':id_produto', $id_produto);
    $sql->bindValue(':quantidade', $quantidade);
    $sql->bindValue(':preco', $preco);

    // Executa a stored procedure
    if ($sql->execute()) {
        return true; // Venda registrada com sucesso
    } else {
        return false; // Falha ao registrar a venda
    }
}
}
