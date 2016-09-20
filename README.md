# Symfony2 Sandbox with Sonata Bundles integrated
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

Edit app/config/parameters.yml and app/config/parameters_dev.yml for custom database options.

Execute following commands:

php app/console assets:install web   (forces copy bundles assets in web/bundles/)

php app/console doctrine:schema:create   (creates database)

php app/console doctrine:schema:update --force   (creates/updates database tables)

php app/console fos:user:create   (add user)

php app/console fos:user:promote   (add role to user (recommended add ROLE_SUPER_ADMIN))

php app/console server:run   (run server in dev mode on http://127.0.0.1:8000)


Access to:

Frontend area: http://127.0.0.1:8000

Backend area: http://127.0.0.1:8000/admin





