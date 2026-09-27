-- Script de criação do banco de dados
-- Sistema de Cadastro de Amigos (CRUD) com Login
-- Projeto: Programação WEB II

CREATE DATABASE IF NOT EXISTS cadastro_amigos
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE cadastro_amigos;

-- Tabela de usuários do sistema (login)
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabela de amigos cadastrados (CRUD principal)
CREATE TABLE IF NOT EXISTS amigos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  nome VARCHAR(100) NOT NULL,
  telefone VARCHAR(20),
  email VARCHAR(150),
  data_nascimento DATE,
  observacoes TEXT,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_amigos_usuario FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Usuário de exemplo para testes rápidos
-- Email: gabi@teste.com | Senha: 123456
INSERT INTO usuarios (nome, email, senha) VALUES
('Gabi', 'gabi@teste.com', '$2b$10$26HfYIvMmDRC0IQ04djEd.1N1Gq/EUAzCXuno9dYACI/wg8A9ppmu')
ON DUPLICATE KEY UPDATE nome = VALUES(nome);
