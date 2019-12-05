Installation
------------

Services will be available under following FQDNs, so update /etc/hosts file with following records:

```
127.0.0.1	pma.laravel-admin.local
127.0.0.1	web.laravel-admin.local
127.0.0.1	mailhog.laravel-admin.local
```

```bash
$ git clone git@github.com:nikolicaleksa/laravel-admin.git
$ cd laravel-admin
$ git submodule init
$ git submodule update
$ sudo chmod -R 777 storage/ bootstrap/cache
$ cp .env.example .env
$ vim .env
```

Database configuration
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel-admin
DB_USERNAME=root
DB_PASSWORD=root
```
Mailhog configuration
```
MAIL_DRIVER=smtp
MAIL_HOST=0.0.0.0
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

Setup application
------------------------------------
```bash
$ cp .php-docker-env php-docker/.env
$ cd php-docker
$ make build
$ make up
$ make ssh HOST=web
$ php artisan key:generate
$ php artisan migrate
$ php artisan admin:install
$ php artisan db:seed
$ npm install
$ npm run dev
$ exit
```

Open http://web.laravel-admin.local

Available commands
---------------
```
make build - build the project 
make up - run the docker containers
make update - update containers in case of configuration changes
make down - shutdown all docker containers
make kill - force shutdown all docker containers
make rm-all - after killing this will remove all the presistent data (volumes)
make ssh HOST=name-of-the-service - ssh to the specific host/service (web, pma, mysql....)
make composer-require PKG=name-of-the-package - add new bundle
```

This set of commands will be expended depending on the needs and usage of particular docker 'specific' commands
