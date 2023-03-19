FROM php:8.1-fpm
LABEL maintainer="Murad Shukurlu shukurlu.murad@gmail.com"
# INSTALL ZIP TO USE COMPOSER
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    git \
    vim

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install nodejs
RUN apt-get -y install cron
RUN apt install -y --no-install-recommends supervisor

#RUN touch /var/run/supervisor.sock

#RUN chmod 777 /var/run/supervisor.sock
RUN service supervisor restart

COPY ./app_supervisor_conf.conf /etc/supervisor/conf.d/app_supervisor_conf.conf

RUN echo_supervisord_conf > /etc/supervisord.conf
RUN supervisord -c /etc/supervisord.conf
RUN docker-php-ext-install pdo pdo_mysql
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update
WORKDIR /var/www/html/site
COPY . .
RUN echo "* * * * * root cd /var/www/html/site && php artisan schedule:run >> /var/log/cron.log 2>&1" >> /etc/crontab;
RUN touch /var/log/cron.log

RUN npm install --force
RUN npm run build
EXPOSE 9000
EXPOSE 6001
RUN echo user=root >>  /etc/supervisor/supervisord.conf
CMD bash -c "composer install && /usr/bin/supervisord -c /etc/supervisor/supervisord.conf -n "

