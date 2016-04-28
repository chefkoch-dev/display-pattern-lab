FROM debian:8

RUN \
    export DEBIAN_FRONTEND=noninteractive && \
    apt-get update && \
    apt-get install -y apt-transport-https curl && \
    echo 'deb http://packages.dotdeb.org jessie all' > /etc/apt/sources.list.d/dotdeb.list && \
    curl http://www.dotdeb.org/dotdeb.gpg | apt-key add - && \
    apt-get update && \
    apt-get install -y nodejs npm php7.0 zip git && \
    ln -s /usr/bin/nodejs /usr/bin/node && \
    php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '7228c001f88bee97506740ef0888240bd8a760b046ee16db8f4095c0d8d525f2367663f22a46b48d072c816e7fe19959') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer --version=1.0.1 && \
    php -r "unlink('composer-setup.php');" && \
    chmod a+x /usr/bin/composer

ADD entrypoint.sh /entrypoint.sh

RUN chmod a+x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

WORKDIR /app