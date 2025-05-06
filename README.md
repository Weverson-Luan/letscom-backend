# 💸 API de Gestão de Créditos e Remessas

Bem-vindo ao **Sistema de Gestão de Créditos e Remessas**, uma solução completa para gerenciamento de créditos, produtos e remessas. Este projeto foi desenvolvido utilizando **Laravel**, seguindo as melhores práticas de desenvolvimento.

## 🚀 Sumário

-   [🔧 Pré-requisitos](#pré-requisitos)
-   [📥 Instalação](#instalação)
-   [🗂️ Módulos Principais](#módulos-principais)
-   [🔐 Autenticação e Segurança](#autenticação-e-segurança)
-   [✅ Boas Práticas Adotadas](#boas-práticas-adotadas)
-   [🖥️ Executando o Projeto](#executando-o-projeto)

## 🔧 Pré-requisitos

-   **PHP >= 8.1**
-   **Composer**
-   **MySQL**
-   **Git**

## 📥 Instalação

1. **Clone o Repositório:**

    ```bash
    git clone https://github.com/viniciusGTeixeira/backend_letscom.git
    cd backend_letscom
    ```

2. **Instale as Dependências:**

    ```bash
    composer install
    ```

3. **Configure o Ambiente:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Subir banco de dados com docker**

    ```bash
    docker-compose up -d
    ```

5. **Rode as seeders:**

    ```bash
    php artisan db:seed
    php artisan db:seed --class=UserSeeder
    ```

6. **Configure o Banco de Dados:**

    - Edite o arquivo `.env` com suas credenciais do banco de dados
    - Execute as migrações:
        ```bash
        php artisan migrate
        ```

7. **Rode aplicação:**

    ```bash
    php artisan serve
    ```

## 🗂️ Módulos Principais

### 1. Gestão de Usuários

-   Cadastro e gerenciamento de usuários
-   Controle de permissões por módulo (CRUD)
-   Autenticação segura

### 2. Gestão de Clientes

-   Cadastro completo de clientes
-   Controle de saldo de créditos
-   Histórico de transações

### 3. Produtos

-   Cadastro de produtos
-   Controle de estoque
-   Definição de valores em créditos

### 4. Vendas de Créditos

-   Registro de vendas de créditos
-   Atualização automática de saldos
-   Histórico de transações

### 5. Remessas

-   Criação de remessas
-   Controle de estoque automático
-   Débito automático de créditos
-   Gestão de status (pendente/confirmado/cancelado)

## 🔐 Autenticação e Segurança

-   **Autenticação JWT**
-   **Controle de Permissões por Módulo**
-   **Validação de Dados**
-   **Transações Seguras**

## ✅ Boas Práticas Adotadas

-   **Arquitetura em Camadas:**

    -   Controllers
    -   Services
    -   Repositories
    -   Models
    -   Form Requests

-   **Segurança:**
    -   Validação de entrada
    -   Controle de acesso
    -   Logs de operações
    -   Transações em banco de dados

## 🖥️ Executando o Projeto

1. **Inicie o Servidor:**

    ```bash
    php artisan serve
    ```

2. **Endpoints Principais:**

    - **Autenticação:**

        - Login: `POST /api/auth/login`
        - Refresh Token: `POST /api/auth/refresh`

    - **Usuários:**

        - Listar: `GET /api/users`
        - Criar: `POST /api/users`
        - Atualizar: `PUT /api/users/{id}`

    - **Clientes:**

        - Listar: `GET /api/clients`
        - Criar: `POST /api/clients`
        - Atualizar: `PUT /api/clients/{id}`

    - **Produtos:**

        - Listar: `GET /api/products`
        - Criar: `POST /api/products`
        - Atualizar: `PUT /api/products/{id}`

    - **Vendas de Créditos:**

        - Listar: `GET /api/credit-sales`
        - Criar: `POST /api/credit-sales`
        - Atualizar: `PUT /api/credit-sales/{id}`

    - **Remessas:**
        - Listar: `GET /api/remessas`
        - Criar: `POST /api/remessas`
        - Atualizar: `PUT /api/remessas/{id}`

### Headers Necessários:

```
Authorization: Bearer {seu_token_jwt}
Content-Type: application/json
Accept: application/json
```

---

📝 **Nota:** Este sistema foi desenvolvido para gerenciar operações de créditos e remessas de forma segura e eficiente. Para mais informações ou suporte, entre em contato com a equipe de desenvolvimento.
