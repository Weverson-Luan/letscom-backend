# Comando Docker

1. **Start banco de dados com docker**

    ```bash
    docker start backend_letscom-db-1
    ```

2. **Subir banco de dados com docker**

    ```bash
    docker-compose up -d
    ```

3. **Remover uma image especifica:**

    ```bash
    docker rmi -f 09aaa2e8a4a0
    ```

4. **Remover volumes especifica:**

    ```bash
    docker system prune -a --volumes
    ```

5. **Remover tudo containers, volumes:**

    ```bash
    docker system prune -a --volumes
    ```

6. **Remover todas images:**

    ```bash
    docker rmi -f $(docker images -aq)
    ```

7. **Remover todos volumes:**

    ```bash
    docker volume rm $(docker volume ls -q)
    ```

8. **Limpar cache de build:**

    ```bash
    docker builder prune
    ```
