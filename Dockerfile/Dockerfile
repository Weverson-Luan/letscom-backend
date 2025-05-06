# 1 - Use Ubuntu 22.04 como a base para o PHP e Apache
FROM ubuntu:22.04 as php-apache

# 2 - Evitar interações durante a instalação de pacotes
ENV DEBIAN_FRONTEND=noninteractive

# 3 - Atualizar o sistema e instalar dependências
RUN apt-get update && apt-get install -y \
    software-properties-common \
    curl \
    gnupg2 \
    lsb-release \
    ca-certificates \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update && apt-get install -y \
    php8.3 \
    php8.3-fpm \
    php8.3-curl \
    php8.3-gd \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-zip \
    php8.3-intl \
    php8.3-mysql \
    apache2 \
    libapache2-mod-php8.3

# 4 -  Instalar o Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && HASH="$(curl -sS https://composer.github.io/installer.sig)" \
    && if [ "$(php -r "echo hash_file('sha384', 'composer-setup.php');")" != "$HASH" ]; then \
        echo 'Installer corrupt' && rm composer-setup.php && exit 1; \
    fi \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# 5 - Configurar Apache
RUN a2enmod php8.3
RUN a2enmod rewrite
# Adicionar configuração do ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configurar o DocumentRoot para apontar para a pasta public do Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf && \
    echo "<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/sites-available/000-default.conf

# 6 -  Configurar diretório de trabalho
WORKDIR /var/www/html

# 7 -  Copiar arquivos do projeto
COPY . /var/www/html

# 8 - Criar diretórios necessários e configurar permissões
RUN mkdir -p storage/framework/cache/data \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# 9 - Expor a porta 80 para o Apache
EXPOSE 80

# 10 - Iniciar Apache
CMD ["apache2ctl", "-D", "FOREGROUND"]