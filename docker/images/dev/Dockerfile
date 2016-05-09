FROM debian:8

RUN \
    export DEBIAN_FRONTEND=noninteractive && \
    apt-get update && \
    apt-get install -y apt-transport-https curl && \
    curl http://www.dotdeb.org/dotdeb.gpg | apt-key add - && \
    echo 'deb http://packages.dotdeb.org jessie all' > /etc/apt/sources.list.d/dotdeb.list && \
    apt-get update && \
    curl -sL https://deb.nodesource.com/setup_5.x | bash - && \
    apt-get install -y nodejs php7.0-cli php7.0-xdebug zip git

RUN \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
    chmod a+x /usr/bin/composer

ADD ssh.config /etc/ssh/ssh_config

WORKDIR /app
