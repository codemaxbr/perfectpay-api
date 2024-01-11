# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Como rodar o projeto em Docker

1. Na raíz do projeto, execute: `docker-compose up -d`
2. Acesse o terminal do Container `api`, execute: `docker exec -it api bash`
3. Se o .env já não tiver sido copiado, execute: `cp .env.example .env`
4. Execute a migration com Seeder: `php artisan migrate --seed`
---

## Acesso de Homologação
* Documentação da API [Postman](https://documenter.getpostman.com/view/2571197/2s9YsM9WRn)
* URL da API (temporário): http://api.gerentepro.com.br
* Frontend (temporário): http://desafio.gerentepro.com.br

  O Ambiente temporário, é em minha conta AWS.
  Tudo em container com Docker, disponibilizei essa opção como alternativa mais rápida.
  
## Repositórios
* API - https://github.com/codemaxbr/perfectpay-api
* Frontend Laravel - https://github.com/codemaxbr/perfectpay-checkout
