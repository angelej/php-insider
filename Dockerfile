FROM alpine:3.18.3

RUN adduser -H -D insider insider

RUN apk add \
    php81-cli \
    php81-dom \
    php81-simplexml \
    php81-tokenizer \
    php81-xml \
    php81-xmlwriter \
    composer=2.5.8-r0

USER insider:insider
WORKDIR /srv/php-insider

COPY --chown=insider:insider . /srv/php-insider

RUN composer install --no-interaction --optimize-autoloader

ENTRYPOINT ["/srv/php-insider/bin/insider"]