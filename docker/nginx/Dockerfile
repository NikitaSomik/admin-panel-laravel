########################
### Stage - "base"
########################
FROM nginx:1.17.6

ENV TZ=Europe/Oslo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY nginx.conf /etc/nginx/nginx.conf

COPY nginx-site.conf /etc/nginx/conf.d/default.conf


