
FROM somnambulist/php-ppm:8.1-latest
ENV TERM=xterm-256color

RUN apk --update add ca-certificates \
    && apk update \
    && apk upgrade \
    && apk --no-cache add -U \
    php81-pdo_pgsql \
    php81-pgsql \
    php81-pecl-amqp \
    && rm -rf /var/cache/apk/* /tmp/*

# setup custom PHP ini files
COPY config/docker/test/app/conf.d/zz-custom.ini /etc/php81/conf.d/

# app will be mounted here, so set this as our working directory
WORKDIR /app

COPY config/docker/test/app/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod 755 /docker-entrypoint.sh
RUN composer selfupdate

COPY ppm*.json ./
COPY composer.* ./
COPY .env* ./

RUN composer install --no-scripts --quiet && rm -rf /tmp/*

COPY . .

EXPOSE 8080

# run php-pm on the custom ip so it is externally available
CMD [ "/docker-entrypoint.sh", "start", "--workers=2", "--cgi-path=/usr/bin/php-cgi81", "--host=0.0.0.0" ]
