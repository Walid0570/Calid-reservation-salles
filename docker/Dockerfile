FROM ubuntu:latest
LABEL authors="walid"

ENTRYPOINT ["top", "-b"]

FROM php:8.2-apache

# Installation de PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Active mod_rewrite (utile si tu veux utiliser un routeur plus tard)
RUN a2enmod rewrite

# Copie des fichiers dans le dossier web
COPY ../public/ /var/www/html/

# Set les bons droits
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Active l'affichage des erreurs (dev uniquement)
RUN echo "display_errors=On\nerror_reporting=E_ALL" > /usr/local/etc/php/conf.d/dev.ini

COPY ./public/ /var/www/html/


