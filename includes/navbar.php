<nav class="navbar">
    <span class="navbar-brand">Cadastro de Amigos</span>
    <span class="navbar-user">
        Olá, <?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?>
        &middot; <a href="logout.php">Sair</a>
    </span>
</nav>
