## Instalação

Clone o repositório:

```
git clone https://github.com/Bonot/contact-list.git
```

### Dentro da pasta backend

Crie o arquivo `.env` a partir de `.env.example`.

Rode os seguintes comandos:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

`vendor/bin/sail up -d`

`vendor/bin/sail php artisan migrate`

`vendor/bin/sail php artisan db:seed`

### Dentro da pasta frontend

`yarn install`

`yarn run dev`

----

### Primeiro acesso

Dados do usuário criado pela seed


```
Email: admin@admin.com.br
Senha: admin123
```

A API roda em `http://localhost:90/`

Para acessar o frontend usar url geral pelo `yarn run dev`

----

### Executando testes

Para executar os testes:

- Criar arquivo `.env.test` a partir de `.env`;
  - Alterar `DB_DATABASE` para `portal_noticias_teste`;
- Criar banco de dados `portal_noticias_teste` manualmente;
- Rodar comando `vendor/bin/sail php artisan migrate --env=test`;
- Para executar os testes, rodar o comando `vendor/bin/sail php artisan test`;
