# Symfony Sandbox: project integrated with util bundles

This project is a symfony based application with multiples customized elements. It integrates well known projects like Sonata Admin, Sonata User, FOS User, FOS Rest and others dependencies. It provides a custom and extended configuration based on sonata sandbox project.

You only need download it and use it with a little effort. 

We hope that this project contribute to your work with Symfony.

# Instalation

Composer Installation
---------------------

Open a console window and execute following commands:

    mkdir workspace

    cd workspace

    php composer.phar create-project frnklnrd/symfony-sandbox sf-project

    cd sf-project

    php composer.phar update


# Configuration

For custom database and other options edit files:

    /app/config/parameters.yml

    /app/config/parameters_dev.yml

Create database, executing following command:

    php bin/console doctrine:schema:create

Create/Update tables from entities definitions, executing following command:

    php bin/console doctrine:schema:update --force

Create an user for access to application, executing following command:

    php bin/console fos:user:create

Add ROLE permission to created user (recommended ROLE_SUPER_ADMIN), executing following command:

    php bin/console fos:user:promote

Force bundles to copy all assets in web/bundles/, executing following command:

    php bin/console assets:install web

Run server in development mode, executing following command:

    php bin/console server:run

Access to application:

    Frontend area: http://127.0.0.1:8000

    Backend area: http://127.0.0.1:8000/admin





