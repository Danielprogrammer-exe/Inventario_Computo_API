# Usa la imagen oficial de PHP con Apache
FROM php:8.0-apache

# Establece el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Instala las extensiones necesarias de PHP
RUN docker-php-ext-install pdo pdo_mysql

# Configuración de Apache
RUN a2enmod rewrite
RUN service apache2 restart
