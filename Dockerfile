# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilita el módulo de Apache mod_rewrite (necesario para Laravel)
RUN a2enmod rewrite

# Copia el archivo de configuración de Apache personalizado
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo de Apache mod_headers para permitir CORS
RUN a2enmod headers

# Reinicia el servicio de Apache
RUN service apache2 restart  # Reiniciar el servicio en el Dockerfile puede no ser necesario

# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Instala las dependencias de PHP necesarias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip && \
    docker-php-ext-install zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala las extensiones de PHP necesarias para Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Exponer el puerto 81
EXPOSE 81

# Inicia Apache cuando se ejecute el contenedor
CMD ["apache2-foreground"]
