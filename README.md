# 📇 Cadastro de Amigos — CRUD com Login

Sistema web para cadastro e gerenciamento de amigos (CRUD completo), com autenticação de usuários por login.

> Projeto desenvolvido para a disciplina de **Programação WEB II**, como parte da atividade prática de apresentação de projeto, contemplando cadastro de amigos (Create, Read, Update, Delete) e sistema de login.

---

## 📌 Sobre o projeto

O sistema permite que cada usuário crie sua própria conta, faça login e gerencie sua lista pessoal de amigos, podendo:

- ✅ Cadastrar novos amigos (nome, telefone, e-mail, data de nascimento e observações)
- ✅ Listar todos os amigos cadastrados, com busca por nome
- ✅ Editar os dados de um amigo já cadastrado
- ✅ Excluir um amigo da lista
- ✅ Criar conta e fazer login/logout de forma segura (senha criptografada)

Cada usuário só visualiza e gerencia os amigos que ele mesmo cadastrou.

---

## 🚀 Tecnologias utilizadas

| Camada | Tecnologia |
|---|---|
| Back-end | PHP 7.4+ (PDO para acesso ao banco) |
| Banco de dados | MySQL / MariaDB |
| Front-end | HTML5, CSS3 |
| Autenticação | Sessões PHP (`session`) + hash de senha (`password_hash`) |
| Servidor local | Apache (XAMPP/WAMP/MAMP) ou servidor embutido do PHP |

---

## 🗂️ Estrutura do projeto

```
cadastro-amigos-gabi/
├── assets/
│   └── css/
│       └── style.css          # Estilos da aplicação
├── config/
│   └── database.php           # Configuração de conexão com o banco (PDO)
├── database/
│   └── schema.sql             # Script de criação do banco e tabelas
├── includes/
│   ├── auth.php                # Funções de sessão/proteção de rotas
│   └── navbar.php              # Menu superior reutilizável
├── index.php                   # Redireciona para login ou listagem
├── login.php                   # Tela de login
├── registrar.php                # Tela de criação de conta
├── logout.php                   # Encerra a sessão
├── listar.php                   # Listagem de amigos (Read) + busca
├── criar.php                    # Cadastro de novo amigo (Create)
├── editar.php                   # Edição de amigo (Update)
├── excluir.php                  # Remoção de amigo (Delete)
├── LICENSE
├── .gitignore
└── README.md
```

---

## ⚙️ Como executar o projeto localmente

### Pré-requisitos

- PHP 7.4 ou superior
- MySQL ou MariaDB
- Servidor local, como [XAMPP](https://www.apachefriends.org/), WAMP, MAMP ou o servidor embutido do próprio PHP

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/cadastro-amigos-gabi.git
cd cadastro-amigos-gabi
```

### 2. Crie o banco de dados

Importe o script `database/schema.sql` no seu MySQL. Você pode fazer isso pelo phpMyAdmin ou via terminal:

```bash
mysql -u root -p < database/schema.sql
```

Isso vai criar o banco `cadastro_amigos`, as tabelas `usuarios` e `amigos`, além de um usuário de teste:

- **E-mail:** `gabi@teste.com`
- **Senha:** `123456`

### 3. Configure a conexão com o banco

Edite o arquivo `config/database.php` caso seu usuário/senha do MySQL sejam diferentes do padrão:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cadastro_amigos');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Execute o projeto

**Opção A — usando XAMPP/WAMP:**
Copie a pasta do projeto para `htdocs` (XAMPP) ou `www` (WAMP) e acesse:
```
http://localhost/cadastro-amigos-gabi/
```

**Opção B — usando o servidor embutido do PHP:**
```bash
php -S localhost:8000
```
E acesse `http://localhost:8000/` no navegador.

### 5. Faça login

Use o usuário de teste (`gabi@teste.com` / `123456`) ou clique em **"Crie uma agora"** para registrar uma nova conta.

---

## 🔒 Segurança

- Senhas nunca são armazenadas em texto puro — são criptografadas com `password_hash()` (bcrypt) e verificadas com `password_verify()`.
- Todas as consultas ao banco usam *prepared statements* (PDO), prevenindo SQL Injection.
- Todas as páginas de gerenciamento de amigos são protegidas por sessão: só é possível acessá-las estando logado.
- Cada usuário só enxerga e manipula os próprios registros (filtro por `usuario_id` em todas as consultas).

---

## 🖼️ Screenshots

> Adicione aqui prints das telas de login, listagem, cadastro e edição para ilustrar a apresentação do projeto.

---

## 📄 Licença

Este projeto está sob a licença MIT — veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## ✍️ Autoria

Projeto desenvolvido por **Gabi** como atividade prática da disciplina de Programação WEB II.
