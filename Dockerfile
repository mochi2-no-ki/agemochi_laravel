FROM php:8.2-apache

# 必要なパッケージとPHP拡張のインストール
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libpng-dev libonig-dev tzdata \
    && ln -snf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
    && echo "Asia/Tokyo" > /etc/timezone \
    && docker-php-ext-install pdo_mysql zip pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apacheのmod_rewriteを有効化
RUN a2enmod rewrite

# Apacheの仮想ホスト設定をコピー
COPY ./apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# 作業ディレクトリをLaravelのルートに設定
WORKDIR /var/www/html
