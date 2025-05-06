# 💸 API de Gestão de Parcelas

## 📋 Visão Geral
A API de Gestão de Parcelas é uma solução completa para empresas que operam com:
- Venda de produtos por créditos.
- Controle de estoque.
- Gestão de clientes.
- Múltiplos usuários com diferentes níveis de acesso.

Cada módulo foi projetado para ser intuitivo e seguro, garantindo a integridade das operações e dados.

---

## 🚀 Funcionalidades Principais

### 🔑 Acesso Inicial e Autenticação
- O primeiro acesso é realizado por um **usuário administrador** utilizando credenciais padrão.
- Administradores podem criar outros usuários com permissões específicas, definidas para cada módulo (Criar, Ler, Atualizar, Deletar - C, R, U, D).

---

### 👥 Gestão de Usuários
- **Administradores podem:**
  - Criar novos usuários.
  - Definir permissões detalhadas por módulo.
  - Gerenciar acessos ao sistema.
- **Usuários:** 
  - Terão acesso apenas aos módulos permitidos conforme suas permissões.

---

### 📆 Fluxo de Trabalho Diário

#### a) **Cadastro de Produtos**
- Usuários com permissão podem:
  - Cadastrar produtos com valores em moeda e créditos.
  - Estabelecer limites de estoque (mínimo e máximo).
  - Monitorar o estoque atual.

#### b) **Gestão de Clientes**
- Funcionalidades incluem:
  - Cadastro de novos clientes.
  - Atualização de dados cadastrais.
  - Acompanhamento do saldo de créditos.
  - Consulta ao histórico de transações.

#### c) **Venda de Créditos**
- Fluxo:
  1. Cliente solicita compra de créditos.
  2. Usuário registra a venda.
  3. O sistema:
     - Atualiza o saldo do cliente.
     - Gera o histórico da transação.

#### d) **Gestão de Remessas**
- Fluxo:
  1. Cliente solicita produtos.
  2. O sistema verifica:
     - Saldo de créditos do cliente.
     - Disponibilidade em estoque.
  3. Usuário registra a remessa.
  4. O sistema:
     - Deduz os créditos do cliente.
     - Atualiza o estoque.
     - Gera a documentação necessária.

---

### 📊 Controles e Relatórios
- Acompanhamento de:
  - Estoque.
  - Histórico de vendas de créditos.
  - Movimentação de remessas.
  - Saldos dos clientes.

---

### 🔒 Fluxo de Segurança
- Registro de logs para todas as ações.
- Validações implementadas em cada operação.
- Controle de acesso baseado em permissões.
- Proteção contra operações inválidas.
