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
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '92102166af5abdb03f49ce52a40591073a7b859a86e8ff13338cf7db58a19f7844fbc0bb79b2773bf30791e935dbd938') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    chmod a+x /usr/bin/composer

WORKDIR /app
