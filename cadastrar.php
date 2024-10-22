<?php
require "CRUDusuario.php";
session_start(); // Inicie a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    $usuario = new usuario(null, $email, $senha, $tipo);
    $dados = $usuario->cadastrar($usuario);

    if (isset($dados) && $dados != false) {
        $_SESSION['usuario'] = [
            'id' => $dados['ID_usuario'],
            'email' => $dados['email'],
            'tipo' => $dados['tipo'],
        ]; // Armazene o ID do usuário na sessão
        if ($_SESSION['usuario']['tipo'] == "ADMINISTRADOR") {
            header("Location: inicio.php");
        }else{
            header("Location: inicio_comum.php");
        }
    } else {
        echo "Email já cadastrado com esse tipo.";
        header("Location: login_cadastro.php");
    }
}
