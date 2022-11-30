# Nome

Descrição

### Tecnologias

- MariaDB 10.6

- PHP 8.0
 

### Montagem do ambiente utilizando Docker

A partir do arquivo **.env.example**, criar um arquivo **.env**, alterar os valores das variáveis, caso necessário.

```bash
# Subir containers do docker
$ docker-compose -f docker-compose-local.yaml up -d
```

```bash
# Monitorar logs
$ docker-compose -f docker-compose-local.yaml logs -f
```

```bash
# Parar containers
$ docker-compose -f docker-compose-local.yaml stop
```

```bash
# Remover containers
$ docker-compose -f docker-compose-local.yaml down
```

```bash
# Remover containers e volumes (apaga todos os dados do docker!)
$ docker-compose -f docker-compose-local.yaml down --remove-orphans -v
```

```bash
# Instalar o npm e suas dependências
$ npm i
```

```bash
# Montagem dos arquivos Css e Js utilizados no tema
$ npm run build
```

### Desenvolvimento Front-end
Os arquivos Scss e Js devem ser adicionados dentro das respectivas pastas
```bash
# Para arquivos disponíveis no front-end do site:
$ cd assets/public/src/scss
$ cd assets/public/src/js

# Para arquivos disponíveis no painel administrativo do WordPress:
$ cd assets/admin/src/scss
$ cd assets/admin/src/js

# Rebuildar os arquivos Scss e Js alterados
$ npm run watch
```

### Padrões de desenvolvimento

- Git Flow
    - [Indicadores](docs/flow-indicators.png)

    - [Flow](docs/flow.png)

    - Padrão de versionamento: [Semantic Versioning 2.0.0](https://semver.org/lang/pt-BR/)


- Padrões de branchs, escritas em inglês
    ```bash
    # Exemplos de branchs:
    $ git checkout -b feature/branch-test
    $ git checkout -b refactor/branch-test
    $ git checkout -b chore/branch-test
    $ git checkout -b bugfix/branch-test
    $ git checkout -b fix/branch-test
    ```

- Padrões de commits, escritos em inglês e seguindo a doc: [Conventional Commits](https://www.conventionalcommits.org/pt-br/v1.0.0/)
    ```bash
    # Exemplos de commits:
    $ git commit -q -m "feat: commit description"
    $ git commit -q -m "refactor: commit description"
    $ git commit -q -m "chore: commit description"
    $ git commit -q -m "bugfix: commit description"
    $ git commit -q -m "fix: commit description"
    ```

- Padrões de Merge requests, escritos em português (prefixo + breve descrição do mr)
    ```bash
    # Exemplos de merge requests:
    Adicionada a função "custom_get_posts"
    Refatorada a função "custom_get_posts"
    Alterada a função "custom_get_posts"
    Removida a função "custom_get_posts"
    Corrigida a função "custom_get_posts"
    ```