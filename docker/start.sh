#!/bin/sh

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migration (attention : seulement si tu veux migrer automatiquement)
php artisan migrate --force

# Démarrage
supervisord -c /etc/supervisord.conf
