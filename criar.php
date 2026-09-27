<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

protegerPagina();

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dataNascimento = $_POST['data_nascimento'] ?? null;
    $observacoes = trim($_POST['observacoes'] ?? '');

    if ($nome === '') {
        $erro = 'O nome é obrigatório.';
    } else {
        $pdo = conectar();
        $stmt = $pdo->prepare(
            'INSERT INTO amigos (usuario_id, nome, telefone, email, data_nascimento, observacoes)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            usuarioIdLogado(),
            $nome,
            $telefone ?: null,
            $email ?: null,
            $dataNascimento ?: null,
            $observacoes ?: null,
        ]);

        header('Location: listar.php?msg=' . urlencode('Amigo cadastrado com sucesso!'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo amigo - Cadastro de Amigos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main class="container container-form">
        <h1>Novo amigo</h1>

        <?php if ($erro): ?>
            <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="criar.php" class="form-card">
            <label for="nome">Nome *</label>
            <input type="text" id="nome" name="nome" required autofocus
                   value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000"
                   value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label for="data_nascimento">Data de nascimento</label>
            <input type="date" id="data_nascimento" name="data_nascimento"
                   value="<?= htmlspecialchars($_POST['data_nascimento'] ?? '') ?>">

            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="3"><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>

            <div class="form-acoes">
                <a href="listar.php" class="btn btn-secundario">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </main>
</body>
</html>
