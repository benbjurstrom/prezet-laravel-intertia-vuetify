# Prezet [Laravel + Intertia + Vuetify]
An opinionated [Laravel](https://laravel.com) preset with [Inertia.js](https://inertiajs.com/) and [Vuetify](https://vuetifyjs.com/en/getting-started/quick-start/)

[![Test Status](https://github.com/benbjurstrom/prezet-laravel-intertia-vuetify/workflows/tests/badge.svg?branch=master)](https://github.com/benbjurstrom/prezet-laravel-intertia-vuetify)


## Includes
The following features are preconfigured. Check out the demo at [prezet.com]('https://prezet.com').

### User Features
- Registration
- Email Verification
- Email Change w/ Verification
- Password Change
- Password Recovery
- Two Factor Authentication [darkghosthunter/laraguard](https://github.com/DarkGhostHunter/Laraguard)
- Reauthentication [mpociot/reauthenticate](https://github.com/mpociot/reauthenticate)

### Frontend Developer Features
- Vuetify 2.2+
- Inline form validation
- Eslint w/ eslint-plugin-vue
- Font Awesome 5

### Backend Developer Features
- PHP 7.4
- Laravel 6
- Postgres
- Github workflow running tests and code quality
- UUID primary keys
- Example phpunit tests
- Inline form validation
- Docker compose development environment

#### Docker Compose Features
- Postgres Database
- Redis Server
- Mail Hog Dashboard
- Laravel Queue Worker
- Laravel Jobs Container

## Quickstart
Clone this repo into new project folder
```shell
git clone https://rezet-intertia-vuetify.git  prezet
cd prezet
```
Start the docker containers
```shell
docker-compose up
```
Install the dependencies
```shell
cp .env.example .env
docker exec prezet-phpfpm artisan key:generate
docker exec prezet-phpfpm composer install
docker exec prezet-phpfpm yarn install
```
Create the database, run the migrations, and seed the data
```shell
docker exec prezet-phpfpm php artisan db:create
docker exec prezet-phpfpm php artisan migrate:fresh --seed
```
Login at http://localhost:8000
```shell
email: admin@example.com
password: 123
```
