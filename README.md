![Requisitos](requisitos.png)

### Tecnologias uyilizadas:

    - PHP 8.2
    - Laravel 11
    - Postgresql
    - Bootstrap 5.3.6
    - jQuery 3.7.1

### Funcionalidades:

    - Sistema de autenticação com registro/login/logout e atualização de perfil;
    - Dashboard:
        - Criação de quadros/edição/deleção/listagem/busca PAGINADA e com Ajax;
        - Listagem resumida das 3 últimas tasks atribuídas ao usuário logado;
    - Visualização do board:
        - Editar titulo e descrição;
        - Adicionar/editar/deletar categorias com nome e cor;
        - Mover posição da categoria dinamicamente;
        - Adicionar membros para o quadro;
        - Adicionar/deletar/editar tasks;
        - Atribuir tasks a membros do quadro;
        - Reordenar a task dentro da categoria com arrasta e solta;
        - Mover a task entre as categorias com arrasta e solta;
        - Avançar task "rápido" para a próxima categoria com um click ->.

### Instruções para servir aplicação:

-   Clone o repositório <code> git clone https://github.com/EdmilsonMedeiros/TaskFlow.git </code>
-   Instale o composer <code> composer install </code>
-   Copie o arquivo .env.example como .env <code> cp .env.example .env </code>
-   Configure o banco de dados no arquivo .env
-   Gere a APP_KEY <code> php artisan key:generate </code>

<code>
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=dev
</code>

-   Execute as migrations <code> php artisan migrate </code>
-   Sirva a aplicação <code> php artisan serve </code>
-   Acesse a URL na qual a aplicação foi servida, crie uma conta e pronto.
