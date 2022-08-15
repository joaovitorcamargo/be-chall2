# Instalação

- Rode o comando docker-compose up -d ou docker-compose up (Escolha de sua preferencia)
- Rode o comando composer install.
- Copie o arquivo .env.example e o renomeie para .env
- Configure o seu .env para estabelecer com suas respectivas conexões.
- A api fast forex necessita de uma key para funcionar, key essa também especificada no arquivo .env.example
- Para a execução do sqlite, vá ao seguinte caminho src/database/ e dentro da pasta database crie um arquivo chamado sqlite.db, para funcionar aqui no meu ambiente precisei remover o DB_DATABASE do .env
- Caso exista um erro de permissão a pasta logs, no seu terminal se vc estiver na root do projeto, digite cd src (para acessar a pasta src via terminal) e rode o seguinte comando sudo chmod -R 777 ./storage/logs caso a pasta storage/logs não exista crie elas manualmente.
- Rode o comando php artisan migrate (para criar as respectivas tabelas no seu sqlite).
- Ao realizar a request e ocorrer o erro de readonly no banco, executar o seguinte comando no terminal chmod -R 775 database

# Documentação
- https://documenter.getpostman.com/view/10580830/VUjSFj7n

# Observação
- O arquivo composer.lock, decidi inseri-lo no versionamento para que não haja conflito de versões entre ambientes

# Informações Adicionais
- Fast Forex Api = https://www.fastforex.io/
- MakeUp Api = http://makeup-api.herokuapp.com/