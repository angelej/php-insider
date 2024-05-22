FROM alpine:3.19

RUN adduser -H -D insider insider

RUN apk add \
    php82-cli \
    php82-dom \
    php82-simplexml \
    php82-tokenizer \
    php82-xml \
    php82-xmlwriter \
    composer=2.7.6-r0

USER insider:insider
WORKDIR /srv/php-insider

COPY --chown=insider:insider . /srv/php-insider

RUN composer install --no-interaction --optimize-autoloader

ENTRYPOINT ["/srv/php-insider/bin/insider"]