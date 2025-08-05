#!/bin/bash

# Aguardar o banco de dados ficar disponível
echo "Aguardando banco de dados..."
until php -r "
try {
    new PDO('mysql:host=db;port=3306', 'root', 'root');
    echo 'Conectado!' . PHP_EOL;
    exit(0);
} catch (Exception \$e) {
    echo 'Aguardando...' . PHP_EOL;
    sleep(1);
    exit(1);
}
"; do
  sleep 1
done

echo "Banco de dados disponível!"

# Copiar .env se não existir
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Arquivo .env criado"
fi

# Gerar APP_KEY se não existir
if ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate
    echo "APP_KEY gerado"
fi

# Rodar migrations
echo "Executando migrations..."
php artisan migrate --force

# Rodar seeders (se existir)
if php artisan db:seed --dry-run &>/dev/null; then
    echo "Executando seeders..."
    php artisan db:seed --force
fi

# Limpar e cachear configurações
php artisan config:clear
php artisan config:cache
php artisan route:cache

echo "Aplicação pronta!"

# Executar comando passado como argumento
exec "$@"