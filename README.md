# Finanças - Mattos & Cia
### Bruno Carvalho - brunofullstack@gmail.com

Teste de conhecimento implementando um fluxo de trabalho simplificado com Docker Compose que configura uma rede de contêineres Laravel para desenvolvimento local de Laravel com Adminer & PGAdmin.

## Uso

Para começar, certifique-se de ter o [Docker instalado](https://docs.docker.com/docker-for-mac/install/) em seu sistema e, em seguida, clone este repositório.

Em seguida, navegue no terminal até o diretório em que você clonou este repositório e inicie os contêineres para o servidor web executando `docker compose up -d --build`.

Após isso, siga as etapas do arquivo [src/README.md](src/README.md) para adicionar seu projeto Laravel (ou criar um novo aplicativo Laravel em branco).

**Nota**: O nome do host do banco de dados Postgres deve ser `postgres`, **não** `localhost`. O nome de usuário e o banco de dados devem ser ambos `homestead` com uma senha de `secret`.

Os seguintes serviços são configurados para nosso servidor web, com suas portas expostas detalhadas:

-   **nginx** - `:88`
-   **postgres** - `:5433`
-   **php** - `:9000`
-   **adminer** - `:8091`
-   **pgadmin** - `:8090`

Três contêineres adicionais estão incluídos para lidar com comandos do Composer, NPM e Artisan _sem_ precisar ter essas plataformas instaladas no seu computador local. Use os exemplos de comandos a seguir a partir da raiz do projeto, modificando-os para se adequar ao seu caso específico.

-   `docker compose run --rm composer install`
-   `docker compose run --rm npm run dev`
-   `docker compose run --rm artisan migrate`

## Makefile

Há um `makefile` que pode ajudá-lo a executar facilmente todos os comandos do docker ou artisan. Se você não estiver familiarizado com [GNU Makefile](https://www.gnu.org/software/make/manual/make.html), tudo bem, você ainda pode usar este repositório (inclusive pode excluir o `makefile`), mas com o `makefile` você pode gerenciar diferentes comandos de forma mais fácil e eficiente! Antes de usar um `makefile`, basta instalá-lo a partir de [GNU Makefile](https://www.gnu.org/software/make/manual/make.html) e executar o comando `make` na raiz do repositório, onde você verá uma ajuda para usá-lo. Alguns exemplos de comandos `make` para simplificar o fluxo de trabalho:

```
# executar docker compose up -d
make up

# executar docker compose down --volumes
make down-volumes

# executar migrações
make migrate

# executar tinker
make tinker

# executar comandos artisan
make art db:seed
```

## Execução de contêiner Docker

Acesse o contêiner como shell interativo e veja a saída:

```
docker exec -it <container id> sh
```

Dica: Você pode usar /bin/bash ou apenas bash, então, após instalar o bash, você deve inspecionar sua imagem para entender a parte CMD e alterar a opção atual para o que desejar. Para isso, execute:

```
docker inspect [imageID]
```