#!/bin/bash
set -e

echo "========================================="
echo "  Tutorías Académicas - Setup"
echo "========================================="
echo ""

PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
echo "✓ PHP $PHP_VERSION detectado"

if ! command -v composer &> /dev/null; then
    echo "✗ Composer no encontrado. Instalando..."
    EXPECTED_CHECKSUM=$(php -r "copy('https://composer.github.io/installer.sig', 'php://stdout');")
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --quiet
    rm composer-setup.php
    mv composer.phar /usr/local/bin/composer
    echo "✓ Composer instalado"
else
    echo "✓ Composer detectado"
fi

if ! command -v mysql &> /dev/null; then
    echo "✗ MySQL no encontrado. Verifica que esté instalado."
    exit 1
fi
echo "✓ MySQL detectado"

echo ""
echo "Instalando dependencias de Laravel..."
composer install --no-interaction --prefer-dist

echo ""
echo "Configurando entorno..."
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
    echo "✓ .env creado y APP_KEY generada"
else
    echo "→ .env ya existe"
fi

echo ""
echo "Ejecutando migraciones..."
php artisan migrate --seed

echo ""
echo "Creando enlace de storage..."
php artisan storage:link 2>/dev/null || true

echo ""
echo "========================================="
echo "  ¡Instalación completada!"
echo "========================================="
echo ""
echo "  Credenciales de prueba:"
echo "  Admin:      admin@tutorias.com / admin123"
echo "  Tutor:      juan@tutorias.com / tutor123"
echo "  Estudiante: maria@tutorias.com / estudiante123"
echo ""
echo "  Inicia el servidor:"
echo "  php artisan serve"
echo ""
echo "========================================="
