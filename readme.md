## Laravel boilerplate
Simple boilerplate project with:
* Laravel 5.4
* Predis 
* Docker Compose/[Ambientum](https://github.com/codecasts/ambientum)
* VueJs 
* Bootstrap Sass

### Configuration
>Replace all occurences of boilerplate with your project's name
#### Laravel docker-compose.yml
```yaml
version: '2'

volumes:
  # MySQL Data
  boilerplate-database-data:
    driver: local

  # Redis Data
  boilerplate-redis-data:
    driver: local

services:

  # MySQL (5.7)
  database:
    image: ambientum/mysql:5.7
    container_name: boilerplate-database
    volumes:
      - boilerplate-database-data:/var/lib/mysql
    ports:
      - "3306:3306"
    environment:
      - MYSQL_ROOT_PASSWORD=${DB_PASSWORD}
      - MYSQL_DATABASE=${DB_DATABASE}
      - MYSQL_USER=${DB_USERNAME}
      - MYSQL_PASSWORD=${DB_PASSWORD}

  # Redis
  cache:
    image: ambientum/redis:3.2
    container_name: boilerplate-redis
    command: --appendonly yes
    volumes:
      - boilerplate-redis-data:/data
    ports:
      - "6379:6379"

  # PHP (with Ngnix)
  app:
    image: ambientum/php:7.1-nginx
    container_name: boilerplate-app
    volumes:
      - .:/var/www/app
    ports:
      - "80:8080"
    links:
      - database
      - cache

  # Laravel Queues
  queue:
    image: ambientum/php:7.1
    container_name: boilerplate-queue
    command: php artisan queue:listen
    volumes:
      - .:/var/www/app
    links:
      - database
      - cache

```
####.env
```yaml
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=boilerplate
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_DRIVER=queue

REDIS_HOST=cache
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=

```