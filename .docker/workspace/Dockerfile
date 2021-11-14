ARG TARGET_PHP_VERSION
FROM php:${TARGET_PHP_VERSION}-cli

ARG SERVICE_DIR="./workspace"
COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# add users
ARG APP_USER
ARG APP_GROUP
ARG APP_USER_ID
ARG APP_GROUP_ID

RUN apt-get update -yqq && apt-get install -yqq \
    bash \
;

# use bash for building the docker image
# @see https://github.com/moby/moby/issues/7281#issuecomment-389440503
SHELL ["/bin/bash", "-c"]

RUN /tmp/scripts/create_user.sh ${APP_USER} ${APP_GROUP} ${APP_USER_ID} ${APP_GROUP_ID}

RUN /tmp/scripts/install_php_extensions.sh

RUN /tmp/scripts/install_software.sh

# set up ssh
RUN apt-get update -yqq && apt-get install -yqq openssh-server \
 && mkdir /var/run/sshd \
;

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
 && chmod +x -R /bin/docker-entrypoint/ \
;

RUN /tmp/scripts/cleanup.sh

# @see https://docs.docker.com/engine/examples/running_ssh_service/
CMD ["/usr/sbin/sshd", "-D"]
ENTRYPOINT ["/bin/docker-entrypoint/resolve-docker-host-ip.sh"]

