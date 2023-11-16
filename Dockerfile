# Usa una imagen de PHP con Apache
FROM php:7.4-apache

# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copia el contenido del directorio actual al contenedor en /var/www/html
COPY . /var/www/html

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql \
    && a2enmod rewrite

# Exponer el puerto 80 para Apache
EXPOSE 80

# Comando para ejecutar el servidor Apache en primer plano
CMD ["apache2-foreground"]
