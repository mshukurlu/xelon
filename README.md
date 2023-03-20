
Note : this project using laravel-web-socket which is replacment of pusher with own web socker server

## Install and launch guide

- Copy from github repository
- Add those lines to your machine's host file 127.0.0.1 site.local.com
- Go to the project folder 
- COPY .env-example file to .env and SET application keyword with php artisan key:generate
- SET pusher credentials with random data
- then run docker-compose up
- Browse site.local.com and wait for new updates :) 
