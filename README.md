# TaskManager

Aplicação de gerenciamento de tarefas construída com **Laravel 12**, **MongoDB** e **Redis**, com interface web em Blade.

---

## Stack

- **PHP 8.4** + Laravel 12
- **MongoDB 7** — banco de dados principal
- **Redis 7** — cache e sessões
- **Nginx** — servidor web
- **Docker** + Docker Compose

---

## Pré-requisitos

Antes de começar, você precisa ter instalado:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Make](https://www.gnu.org/software/make/) *(opcional, para usar os atalhos)*

---

## Instalação e execução

### 1. Clone o repositório

```bash
git clone https://github.com/LucianoCosta92/laravel-mongo-crud.git
cd laravel-mongo-crud
```

### 2. Configure o ambiente

Copie o arquivo de exemplo:

```bash
cp .env.example .env
```

> As configurações padrão já funcionam com o Docker — não é necessário alterar nada para rodar localmente.

### 3. Suba os containers

```bash
# Com Make (recomendado):
make setup

# Ou manualmente:
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
```

### 4. Acesse a aplicação

http://localhost:8000/login

---

## Estrutura dos containers

| Container | Imagem | Função |
|---|---|---|
| `taskmanager_app` | PHP 8.4-FPM Alpine | Processa o Laravel |
| `taskmanager_nginx` | Nginx Alpine | Servidor HTTP na porta 8000 |
| `taskmanager_mongodb` | MongoDB 7 | Banco de dados |
| `taskmanager_redis` | Redis 7 Alpine | Cache e sessões |

---

## Funcionalidades

- Cadastro e login de usuários
- Dashboard com contadores de tarefas
- Gerenciamento de tarefas com status e prioridade
- Filtros por status e prioridade
- Gerenciamento de categorias com cores
- Tema claro e escuro
- Cache com Redis

---

## Comandos úteis

### Com Make

```bash
make up           # sobe os containers
make down         # derruba os containers
make build        # rebuild completo
make shell        # entra no container do Laravel
make logs         # logs em tempo real
make clear        # limpa todos os caches do Laravel
make redis-keys   # lista chaves do Redis
make redis-flush  # limpa o cache do Redis
make mongo        # entra no Mongo shell
```

### Sem Make

```bash
# Subir containers
docker compose up -d

# Derrubar containers
docker compose down

# Entrar no container
docker compose exec app bash

# Rodar comandos Artisan
docker compose exec app php artisan <comando>

# Limpar caches
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear

# Ver logs
docker compose logs -f
docker compose logs -f app
```

---

## Variáveis de ambiente

| Variável | Descrição | Padrão |
|---|---|---|
| `APP_KEY` | Chave da aplicação (gerada pelo artisan) | — |
| `DB_HOST` | Host do MongoDB | `mongodb` |
| `DB_DATABASE` | Nome do banco | `taskmanager` |
| `REDIS_HOST` | Host do Redis | `redis` |
| `CACHE_STORE` | Driver de cache | `redis` |
| `SESSION_DRIVER` | Driver de sessão | `redis` |

> **Atenção:** dentro do Docker os hosts dos serviços são os nomes dos containers (`mongodb`, `redis`), não `localhost`.

---

## Solução de problemas

**Porta já em uso:**
```bash
sudo lsof -i :8000
sudo lsof -i :27017

sudo systemctl stop mongod
sudo systemctl stop redis
```

**Erro de permissão no storage:**
```bash
docker compose exec --user root app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app php artisan view:clear
```

**Rebuild completo:**
```bash
docker compose down -v
docker compose up -d --build
```

---

## Licença

MIT
