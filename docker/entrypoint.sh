#!/bin/sh
set -e

# O container sobe como root. Antes de iniciar o PHP-FPM (que roda como www-data),
# garantimos que www-data consiga escrever em storage/ e bootstrap/cache.
#
# Necessário em PRODUÇÃO (arquivos vêm da imagem com dono root) e em
# DESENVOLVIMENTO (o bind mount ./:/var/www sobrescreve as permissões da imagem).
# Sem isso, o Laravel falha ao escrever em storage/logs/laravel.log e devolve 500.
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true
chmod -R ug+rwX /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

# Executa o comando do container (php-fpm por padrão, ou o command: do compose)
exec "$@"
