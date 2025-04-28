# cached stage
FROM php:8.2-cli as dependencies

RUN apt-get update

#postgres
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get install -y libicu-dev
RUN docker-php-ext-install intl

RUN apt-get install curl

# composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -y git

# symphony
RUN apt-get install -y unzip
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin

# zsh
RUN apt-get install -y zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended

RUN git clone --depth 1 -- https://github.com/marlonrichert/zsh-autocomplete.git ~/.zsh/zsh-autocomplete
RUN echo "source ~/.zsh/zsh-autocomplete/zsh-autocomplete.plugin.zsh" >> ~/.zshrc
RUN sed -i 's/robbyrussell/lukerandall/g' ~/.zshrc

ENV LC_CTYPE C.UTF-8

# to rebuild without cache
FROM dependencies as final

WORKDIR /var/www/html

# creating symphony project
RUN git config --global --add safe.directory /var/www/html
RUN git config --global user.email "some@mail.com"
RUN git config --global user.name "some name"

#RUN useradd -u 1000 devuser && chown -R devuser /var/www
#USER devuser

RUN symfony new .