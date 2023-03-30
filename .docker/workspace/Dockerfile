ARG TARGET_PHP_VERSION
FROM php:${TARGET_PHP_VERSION}-cli

ARG SERVICE_DIR="./workspace"
COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

RUN apt-get update -yqq && apt-get install -yqq \
       bash \
       curl \
       dnsutils \
       git \
       make \
       openssh-server \
       procps \
       sudo \
       unzip \
       vim \
       wget \
    && mkdir -p /var/run/sshd \
    && apt-get clean

# add users
ARG APP_USER
ARG APP_GROUP
ARG APP_USER_ID
ARG APP_GROUP_ID

RUN /tmp/scripts/create_user.sh ${APP_USER} ${APP_GROUP} ${APP_USER_ID} ${APP_GROUP_ID}

RUN /tmp/scripts/install_php_extensions.sh

ARG WORKSPACE_SSH_PASSWORD
RUN echo "${APP_USER}:${WORKSPACE_SSH_PASSWORD}" | chpasswd

# php config
COPY ./.shared/config/php/conf.d/*  /usr/local/etc/php/conf.d/

# install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# workdir
ARG APP_CODE_PATH
WORKDIR "$APP_CODE_PATH"

# entrypoint
RUN mkdir -p /bin/docker-entrypoint/ \
 && cp /tmp/scripts/docker-entrypoint/* /bin/docker-entrypoint/ \
 && chmod +x -R /bin/docker-entrypoint/

# @see https://docs.docker.com/engine/examples/running_ssh_service/
CMD ["/usr/sbin/sshd", "-D"]
ENTRYPOINT ["/bin/docker-entrypoint/resolve-docker-host-ip.sh"]

