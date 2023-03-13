FROM node:14 as node_builder

WORKDIR /app
COPY package.json package-lock.json /app/
RUN npm install

COPY ./resources/js /app/resources/js
COPY ./resources/css /app/resources/css
COPY vite.config.js /app/
RUN npm run build

FROM php:7.4-apache
COPY --from=node_builder /app/public /var/www/html
COPY . /var/www/html