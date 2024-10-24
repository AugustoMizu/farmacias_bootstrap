<?php
require "CRUDusuario.php";
session_start(); // Inicie a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha_digitada = $_POST['senha'];
    $tipo = $_POST['tipo']; // O tipo pode não ser necessário no login

    // Cria uma nova instância da classe usuario
    $u = new usuario(null, $email, $senha_digitada, null);

    // Tenta realizar o login
    $dados = $u->login($u, $senha_digitada);

    if (isset($dados) && $dados != false) {
        $_SESSION['usuario'] = [
            'id' => $dados['ID_usuario'],
            'email' => $dados['email'],
            'tipo' => $dados['tipo'],
        ]; // Armazene o ID do usuário na sessão
        if ($_SESSION['usuario']['tipo'] == "ADMINISTRADOR") {
            header("Location: inicio.php");
        } else {
            header("Location: inicio_comum.php");
        }
    } else {
        // Falha no login
        echo "Email ou senha incorretos.";
        header("Location: login_cadastro.php");
    }
}
