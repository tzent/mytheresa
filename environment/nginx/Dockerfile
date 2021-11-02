FROM nginx:1.21-alpine

ARG SERVICE

COPY environment/nginx/nginx.conf /etc/nginx/nginx.conf
COPY environment/nginx/$SERVICE/default.conf /etc/nginx/conf.d/default.conf
COPY environment/nginx/$SERVICE/ssl /etc/nginx/ssl

EXPOSE 443