# Comando Migartions

1. **Criar migration:**

    ```bash
    php artisan make:migration create_nome_migration
    ```

1. **Rodar migrations:**

    ```bash
    php artisan migrate
    ```

1. **Voltar migrations:**

    ```bash
    php artisan migrate:rollback
    ```

1. **Remover todas migrations:**

    ```bash
    php artisan migrate:fresh
    ```

1. **Rode as seeders:**

    ```bash
    php artisan db:seed
    php artisan db:seed --class=UserSeeder
    ```

user ->
produto ->
tecnologia ->
modelos_tecnicos->
usuario_clientes ->
