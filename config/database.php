<?php
/**
 * Configuração de conexão com o banco de dados
 * Ajuste as credenciais conforme o seu ambiente (XAMPP/WAMP/MySQL local)
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'cadastro_amigos');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Retorna uma conexão PDO com o banco de dados
 */
function conectar(): PDO
{
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die('Erro de conexão com o banco de dados: ' . $e->getMessage());
    }
}
