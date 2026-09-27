<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if (usuarioLogado()) {
    header('Location: listar.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $pdo = conectar();
        $stmt = $pdo->prepare('SELECT id, nome, senha FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: listar.php');
            exit;
        } else {
            $erro = 'E-mail ou senha inválidos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Cadastro de Amigos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1>Cadastro de Amigos</h1>
            <p class="subtitle">Faça login para continuar</p>

            <?php if ($erro): ?>
                <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required autofocus>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>

                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>

            <p class="link-secundario">
                Não tem conta? <a href="registrar.php">Crie uma agora</a>
            </p>
        </div>
    </div>
</body>
</html>
