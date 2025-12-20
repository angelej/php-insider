FROM alpine:3.23

RUN adduser -H -D insider insider

RUN apk add \
    php84-cli \
    php84-dom \
    php84-simplexml \
    php84-tokenizer \
    php84-xml \
    php84-xmlwriter \
    composer=2.9.2-r0

USER insider:insider
WORKDIR /srv/php-insider

COPY --chown=insider:insider . /srv/php-insider

RUN composer install --no-interaction --optimize-autoloader

ENTRYPOINT ["/srv/php-insider/bin/insider"]