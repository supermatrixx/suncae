FROM php:8.2.20-apache AS final
RUN apt-get update && apt-get install -y \
     python3 \
 && rm -rf /var/lib/apt/lists/* \
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY .  /var/www
RUN mkdir -p /var/www/data && chown www-data:www-data /var/www
USER www-data

# docker build -t suncae:2024-9-14 .
# docker run -p 9000:80 suncae:2024-9-14
# docker ps
# docker exec -it <container> bash
