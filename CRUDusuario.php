<?php
require "configPDO.php";
date_default_timezone_set('America/Sao_Paulo'); //define um fuso horario padão para o data_cadastro

class usuario
{
    private $ID_usuario;
    private $email;
    private $senha;
    private $tipo;
    private $data_cadastro;

    function __construct($ID_usuario, $email, $senha, $tipo)
    {   //sanitiza os dados para evitar ataques XSS
        $this->$ID_usuario = $ID_usuario;
        $this->email = htmlspecialchars($email);
        $this->senha =  password_hash(htmlspecialchars($senha), PASSWORD_DEFAULT); // Criptografa a senha para armazenamento seguro. usar password_verify para comparar senhas
        $this->tipo = htmlspecialchars(strtoupper($tipo)); //no banco o tipo é um string em upper case
        $this->data_cadastro = date('Y-m-d H:i:s'); //ver se funciona no sql
    }

    //cadastra um usuario se não hover um email cadastrato com o mesmo tipo
    function cadastrar(usuario $u)
    {
        $c = new config();
        $pdo = $c->getPDO();
        
        // Consulta se o email com esse tipo já está cadastrado
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND tipo = :tipo");
        $sql->bindValue(':email', $u->email);
        $sql->bindValue(':tipo', $u->tipo);
        $sql->execute();
        
        if ($sql->rowCount() == 0) {
            // Cadastra novo usuário
            $sql = $pdo->prepare("INSERT INTO usuarios (email, senha, tipo, data_cadastro) VALUES (:email, :senha, :tipo, :data_cadastro);");
            $sql->bindValue(':email', $u->email);
            $sql->bindValue(':senha', $u->senha);
            $sql->bindValue(':tipo', $u->tipo);
            $sql->bindValue(':data_cadastro', date('Y-m-d H:i:s')); // Defina a data de cadastro
    
            $sql->execute();
    
            // Retorna os dados do usuário cadastrado
            $usuarioId = $pdo->lastInsertId(); // Obtém o ID do último usuário cadastrado
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE ID_usuario = :id");
            $sql->bindValue(':id', $usuarioId);
            $sql->execute();
            
            return $sql->fetch(PDO::FETCH_ASSOC); // Retorna os dados do usuário
        } else {
            // Email com tipo já cadastrado
            return false;
        }        
    }
    // realiza login apos validar cadastro no banco de dados
    function login(usuario $u, $senha_digitada)
    {
        $c = new config();
        $pdo = $c->getPDO();
    
        // Consulta apenas pelo email
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(':email', $u->email);
        $sql->execute();
    
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    
        // Verifica se o usuário foi encontrado e se a senha está correta
        if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
            // Login com sucesso
            return $usuario; // Retorna os dados do usuário
        } else {
            // Email ou senha incorretos
            return false;
        }
    }
}
