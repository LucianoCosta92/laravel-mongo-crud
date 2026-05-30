# Sobe todos os containers
up:
	docker compose up -d

# Derruba todos os containers
down:
	docker compose down

# Rebuild completo (após mudar Dockerfile)
build:
	docker compose up -d --build

# Entra no container do Laravel
shell:
	docker compose exec app bash

# Logs em tempo real
logs:
	docker compose logs -f

# Logs só do app
logs-app:
	docker compose logs -f app

# ── Laravel ───────────────────────────────────────────────────────────────────
# Primeira configuração do projeto
setup:
	cp .env.docker .env
	docker compose up -d --build
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan cache:clear

# Limpar todos os caches
clear:
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear

# Rodar artisan dentro do container
artisan:
	docker compose exec app php artisan $(cmd)

# Instalar dependências
install:
	docker compose exec app composer install

# Dump autoload
autoload:
	docker compose exec app composer dump-autoload

# ── Redis ──────────────────────────────────────────────────────────────────────
# Entrar no Redis CLI
redis:
	docker compose exec redis redis-cli

# Ver chaves do cache (banco 1)
redis-keys:
	docker compose exec redis redis-cli -n 1 KEYS "*"

# Limpar cache Redis
redis-flush:
	docker compose exec redis redis-cli -n 1 FLUSHDB

# ── MongoDB ───────────────────────────────────────────────────────────────────
# Entrar no Mongo shell
mongo:
	docker compose exec mongodb mongosh -u root -p secret

.PHONY: up down build shell logs logs-app setup clear artisan install autoload redis redis-keys redis-flush mongo
