# 1. Utilizziamo l'immagine ufficiale di PHP basata su Debian Bookworm
# Puoi cambiare '8.3' con la versione di PHP che preferisci (es. 8.2, 8.4)
FROM php:8.3-cli-bookworm

# Aggiorna gli indici ed installa le dipendenze di sistema necessarie (incluso wget per zsh)
RUN apt-get update && apt-get install -y \
    openssl \
    openssh-client \
    mariadb-client \
    git \
    unzip \
    wget \
    && rm -rf /var/lib/apt/lists/*

# 2. Installiamo xdebug tramite PECL
RUN pecl install xdebug && docker-php-ext-enable xdebug

# 3. Installiamo e abilitiamo le estensioni PHP per i database
RUN docker-php-ext-install pdo pdo_mysql mysqli && \
    docker-php-ext-enable pdo pdo_mysql mysqli

# 4. Installiamo Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 5. Configurazione finale di Zsh
RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.5/zsh-in-docker.sh)"
