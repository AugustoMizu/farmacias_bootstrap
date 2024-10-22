<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
  <meta name="author" content="Augusto Mizu">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-png" href="./imgens/icon_navegador2.png">
    <title>Login e Cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="margin-left: 25%; margin-right: 25%; background-color: #83dbc9;">
    <main class="border border-3 rounded p-5 shadow" style="border: rgba(255, 0, 0, .5); background-color: #BFF7A3;">
        <div class="container mt-5">
            <h2 class="text-center">Login</h2>
            <form id="loginForm" method="POST" action="login.php">
                <div class="form-group">
                    <label for="emailLogin">Email:</label>
                    <input type="email" class="form-control" id="emailLogin" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senhaLogin">Senha:</label>
                    <input type="password" class="form-control" id="senhaLogin" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
    
            <hr>
    
            <h2 class="text-center">Cadastro</h2>
            <form id="cadastroForm" method="POST" action="cadastrar.php">
                <div class="form-group">
                    <label for="emailCadastro">Email:</label>
                    <input type="email" class="form-control" id="emailCadastro" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senhaCadastro">Senha:</label>
                    <input type="password" class="form-control" id="senhaCadastro" name="senha" required>
                </div>
                <div class="form-group">
                    <label for="tipoCadastro">Tipo:</label>
                    <select class="form-control" id="tipoCadastro" name="tipo" required>
                        <option value="COMUM">Comum</option>
                        <option value="ADMINISTRADOR">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Cadastrar</button>
            </form>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>