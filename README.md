# Lumen-MicroServices

Lumen-Micro-services-Monorepo
A practical Laravel Lumen implementation of the micro‑service pattern. This repository contains three independent services that work together:

Screenshot 2025-06-27 at 9 07 48 PM
auth-service calls user-service with Guzzle after every successful registration so the profile table stays in sync. All services are 100 % decoupled and can be scaled and deployed independently.

Repository layout

├── lumen-auth-service/

├── lumen-user-service/

├── lumen-article-service/

├── docker-compose.yml # optional: MySQL & Redis for local dev

└── docs/

└── postman_collection.json
⚙️ Prerequisites

PHP ≥ 8.1
Composer
MySQL 8 or MariaDB
Redis 6/7 (for queues, optional)
Optional — Docker Desktop if you want to spin up MySQL/Redis quickly
🚀 Quick start (local dev)

1  Clone & enter repo
git clone https://github.com/<your‑user>/.git cd

2  Copy example env‑files & edit credentials
cp lumen-auth-service/.env.example lumen-auth-service/.env cp lumen-user-service/.env.example lumen-user-service/.env cp lumen-article-service/.env.example lumen-article-service/.env

3  Install Composer deps for every service
for d in lumen-*; do (cd $d && composer install); done

4  (Optional) spin up MySQL + Redis via Docker
docker compose up -d

5  Run migrations
for d in lumen-*; do (cd $d && php artisan migrate); done

6  Serve each service (in separate terminals)
php -S localhost:8001 -t public -d variables_order=EGPCS ./lumen-auth-service/public/index.php php -S localhost:8002 -t public -d variables_order=EGPCS ./lumen-user-service/public/index.php php -S localhost:8003 -t public -d variables_order=EGPCS .

🔑 Environment variables (.env)

APP_NAME=AuthService APP_ENV=local APP_KEY= APP_PORT=8001

DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=auth_db DB_USERNAME=root DB_PASSWORD=

USER_SERVICE_URL=http://localhost:8002 # where Guzzle will POST profiles

Duplicate and adjust for the other services (user_db, article_db, ports 8002/8003).

🔌 Inter‑service communication After a successful registration the Auth service executes:

$client = new \GuzzleHttp\Client(['base_uri' => env('USER_SERVICE_URL')]); $client->post('/api/users', [ 'json' => [ 'auth_id' => $user->id, 'name' => $user->name, 'email' => $user->email, ], ]);

This keeps profile data in user_db synced without sharing a database.

Screenshot 2025-06-27 at 9 14 47 PM Screenshot 2025-06-27 at 9 15 00 PM
🧪 Running tests

Each service ships with its own PHPUnit tests:

(cd lumen-auth-service && ./vendor/bin/phpunit) (cd lumen-user-service && ./vendor/bin/phpunit) (cd lumen-article-service && ./vendor/bin/phpunit)

📤 Deploying Deploy services independently (e.g. three Railway apps) or together with Docker Compose / Kubernetes. Each service is stateless; attach its own MySQL database instance (or schema) and optional Redis.

🔒 Security notes Always hash passwords (Hash::make) and hide them ($hidden in model). Add JWT or Laravel Sanctum for real auth tokens (out of scope of this demo). Never expose internal endpoints (POST /api/users) publicly.
