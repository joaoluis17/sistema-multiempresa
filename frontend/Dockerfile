# Dockerfile para Vue.js 2
FROM node:16-alpine

# Definir diretório de trabalho
WORKDIR /app

# Copiar package files
COPY package*.json ./

# Instalar dependências
RUN npm install

# Copiar código fonte
COPY . .

# Expor porta
EXPOSE 8080

# Comando para desenvolvimento
CMD ["npm", "run", "serve"]