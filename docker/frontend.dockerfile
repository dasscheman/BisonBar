FROM node:20-alpine
# set workdir
RUN mkdir -p /var/www/
WORKDIR /var/www

# copy webapp files
COPY .. /var/www
RUN npm install

# entrypoint
COPY ./docker/frontend-entrypoint.sh /entrypoint.sh
RUN chmod ugo+x /entrypoint.sh
RUN dos2unix /entrypoint.sh

ENTRYPOINT /entrypoint.sh
