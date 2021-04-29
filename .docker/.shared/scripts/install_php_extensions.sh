#!/bin/sh

# add wget
apt-get update -yqq && apt-get -f install -yyq wget

# download helper script
# @see https://github.com/mlocati/docker-php-extension-installer/

wget -q -O /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/download/1.2.24/install-php-extensions \
    || (echo "Failed while downloading php extension installer!"; exit 1)

# install extensions
chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions \
    xdebug \
    pdo_mysql \
;
