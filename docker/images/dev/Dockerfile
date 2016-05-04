FROM debian:8

RUN \
    export DEBIAN_FRONTEND=noninteractive && \
    echo 'deb http://packages.dotdeb.org jessie all' > /etc/apt/sources.list.d/dotdeb.list && \
    apt-get update && \
    apt-get install -y apt-transport-https curl && \
    curl http://www.dotdeb.org/dotdeb.gpg | apt-key add - && \
    curl -sL https://deb.nodesource.com/setup_5.x | bash - && \
    apt-get install -y nodejs php7.0-cli php7.0-xdebug zip git

RUN \
    php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === 'a52be7b8724e47499b039d53415953cc3d5b459b9d9c0308301f867921c19efc623b81dfef8fc2be194a5cf56945d223') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    chmod a+x /usr/bin/composer

WORKDIR /app
