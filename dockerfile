FROM php:7.4-apache-buster

ENV LD_LIBRARY_PATH=/usr/local/instantclient
ENV ORACLE_HOME=/usr/local/instantclient

RUN sed -i 's|deb.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i '/security.debian.org/d' /etc/apt/sources.list

RUN apt-get update && \
    apt-get install -y libaio1 unzip wget make gcc && \
    wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-basic-linux.x64-21.6.0.0.0dbru.zip -O /tmp/instantclient.zip && \
    wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-sdk-linux.x64-21.6.0.0.0dbru.zip -O /tmp/instantclient-sdk.zip && \
    unzip /tmp/instantclient.zip -d /usr/local/ && \
    unzip /tmp/instantclient-sdk.zip -d /usr/local/ && \
    ln -s /usr/local/instantclient_21_6 /usr/local/instantclient && \
    pecl channel-update pecl.php.net && \
    printf "instantclient,/usr/local/instantclient\n" | pecl install oci8-2.2.0 && \
    echo "extension=oci8.so" > /usr/local/etc/php/conf.d/oci8.ini && \
    rm -rf /tmp/* /var/lib/apt/lists/*

COPY ./www /var/www/html

RUN chown -R www-data:www-data /var/www/html


EXPOSE 80

CMD ["apache2-foreground"]