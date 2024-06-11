# Utiliser une version stable et spécifique de Node plutôt que la version 'latest'
FROM node:16-alpine as builder

WORKDIR /vue-ui

# Copier les fichiers package.json et package-lock.json pour une meilleure gestion des caches
COPY app/package*.json ./

# Installer les dépendances en utilisant npm ci, qui est mieux pour les builds de production
RUN npm ci

# Copier le reste du code source de l'application
COPY app/ ./

# Construire l'application
RUN npm run build

# Serveur NGINX pour servir l'application Vue.js
FROM nginx:latest

COPY conf/nginx.conf /etc/nginx/nginx.conf

COPY ssl /usr/share/nginx/ssl

RUN rm -rf /usr/share/nginx/html/*

COPY --from=builder /vue-ui/dist /usr/share/nginx/html

EXPOSE 80

ENTRYPOINT ["nginx", "-g", "daemon off;"]