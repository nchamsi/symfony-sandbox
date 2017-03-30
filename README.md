# Symfony2 Sandbox with multiples integrated bundles
===================================================

# Instalation

Composer Installation
---------------------

Open a console window and execute following commands:

mk dir workspace

cd workspace

php composer.phar create-project frnklnrd/symfony2-sandbox sf2-project

cd sf2-project

php composer.phar update


# Configuration

For custom database and other options edit files:

/app/config/parameters.yml
/app/config/parameters_dev.yml

Create database, executing following command:

php app/console doctrine:schema:create

Create/Update tables from entities definitions, executing following command:

php app/console doctrine:schema:update --force

Create an user for access to application, executing following command:

php app/console fos:user:create

Add ROLE permission to created user (recommended ROLE_SUPER_ADMIN), executing following command:

php app/console fos:user:promote

Force bundles to copy all assets in web/bundles/, executing following command:

php app/console assets:install web

Run server in development mode, executing following command:

php app/console server:run

Access to application:

Frontend area: http://127.0.0.1:8000

Backend area: http://127.0.0.1:8000/admin





