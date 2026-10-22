FROM php:8.3-apache

# Instalamos y activamos el driver PDO de MySQL (compatible con MariaDB)
RUN docker-php-ext-install pdo pdo_mysql