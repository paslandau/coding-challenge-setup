ARG MYSQL_VERSION
FROM mysql:${MYSQL_VERSION}

MAINTAINER Pascal Landau <pascal.landau@aboutyou.de>

ARG SERVICE_DIR="./mysql"

COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# set timezone
ARG TZ=UTC
RUN /tmp/scripts/set_timezone.sh ${TZ}

RUN apt-get update && apt-get install -y procps

RUN chown -R mysql:root /var/lib/mysql/

COPY ${SERVICE_DIR}/my.cnf /etc/mysql/conf.d/my.cnf
COPY ${SERVICE_DIR}/docker-entrypoint-initdb.d /docker-entrypoint-initdb.d

RUN /tmp/scripts/cleanup.sh

CMD ["mysqld"]

EXPOSE 3306

