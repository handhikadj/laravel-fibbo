FROM php:8-cli

ENV APP_ROOT=/home/app QUEUE_DRIVER=database NUM_PROCS=4 OPTIONS=

ADD ./supervisor/supervisord.conf /etc/

RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pdo pdo_mysql bcmath pcntl \
    && apt-get update \ 
    && apt-get install -y --no-install-recommends supervisor

CMD ["supervisord", "-c", "/etc/supervisord.conf"]