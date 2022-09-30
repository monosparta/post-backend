# See here for image contents: https://github.com/microsoft/vscode-dev-containers/tree/v0.245.2/containers/ubuntu/.devcontainer/base.Dockerfile

# [Choice] Ubuntu version (use ubuntu-22.04 or ubuntu-18.04 on local arm64/Apple Silicon): ubuntu-22.04, ubuntu-20.04, ubuntu-18.04
ARG VARIANT="jammy"
FROM mcr.microsoft.com/vscode/devcontainers/base:0-${VARIANT}

# [Optional] Uncomment this section to install additional OS packages.
RUN apt update && export DEBIAN_FRONTEND=noninteractive \
    && apt -y install --no-install-recommends php php-zip php-dom php-curl php-mysql php-mbstring

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN apt install -y mariadb-server && systemctl enable mariadb
# RUN mariadb -u root -e "CREATE USER 'root'@'%' IDENTIFIED BY 'root';"
# RUN mariadb -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;"
# RUN mariadb -u root -e "FLUSH PRIVILEGES;"
# RUN mariadb -u root -e "CREATE DATABASE IF NOT EXISTS monochrome;"

EXPOSE 8000


