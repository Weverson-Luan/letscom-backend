criar um modelo
php artisan make:model Role

admin =>Responsável por gerenciar todo o sistema, incluindo usuários, permissões, configurações globais e dados operacionais. Possui acesso irrestrito a todos os recursos da plataforma.

cleinte =>Usuário que contrata os serviços da plataforma. Pode cadastrar dados próprios, consultar informações relacionadas à sua conta e gerenciar seus usuários internos.

funcionario => Usuário vinculado a um cliente, com permissões limitadas. Executa tarefas operacionais, como registro de atividades, consultas e atualizações dentro do escopo autorizado pelo cliente.
