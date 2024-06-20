FROM node:16-alpine as builder

WORKDIR /vue-ui


COPY FRONTmain/package*.json ./


RUN npm ci


COPY FRONTmain/ ./


RUN npm run build


FROM nginx:latest

COPY conf/nginx.conf /etc/nginx/nginx.conf

COPY ssl /usr/share/nginx/ssl

RUN rm -rf /usr/share/nginx/html/*

COPY --from=builder /vue-ui/dist /usr/share/nginx/html

EXPOSE 80

ENTRYPOINT ["nginx", "-g", "daemon off;"]