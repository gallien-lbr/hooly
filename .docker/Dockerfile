FROM php:8.1-alpine3.16

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install -j$(nproc) pdo_mysql

WORKDIR /app

EXPOSE 8000

CMD ["./entrypoint.sh"]
