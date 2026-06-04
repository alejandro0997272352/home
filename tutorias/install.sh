#!/bin/bash
set -euo pipefail

echo "========================================="
echo "  Instalación - Sistema de Tutorías"
echo "========================================="
echo ""

# 1. Instalar PHP 8.3 y extensiones
echo "[1/6] Instalando PHP 8.3 y extensiones..."
apt update -qq
apt install -y -qq php8.3 php8.3-cli php8.3-mbstring php8.3-xml php8.3-bcmath \
  php8.3-curl php8.3-mysql php8.3-zip php8.3-gd unzip curl git 2>&1 | tail -2
echo "  ✓ PHP 8.3 instalado"

# 2. Instalar Composer
echo "[2/6] Instalando Composer..."
if ! command -v composer &>/dev/null; then
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php composer-setup.php --quiet --install-dir=/usr/local/bin --filename=composer
  rm composer-setup.php
  echo "  ✓ Composer instalado"
else
  echo "  → Composer ya instalado"
fi

# 3. Configurar MySQL
echo "[3/6] Configurando MySQL..."
if ! mysql --version &>/dev/null; then
  apt install -y -qq mysql-server 2>&1 | tail -1
fi
if ! systemctl is-active --quiet mysql; then
  systemctl start mysql
fi
mysql -u root -e "CREATE DATABASE IF NOT EXISTS tutorias CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || true
echo "  ✓ MySQL configurado"

# 4. Instalar dependencias Laravel
echo "[4/6] Instalando dependencias del proyecto..."
DIR="/home/alejandro/home/tutorias"
cd "$DIR"
composer install --no-interaction --prefer-dist -q 2>&1 | tail -2
echo "  ✓ Dependencias instaladas"

# 5. Configurar .env
echo "[5/6] Configurando entorno..."
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate --quiet
  echo "  ✓ .env creado y APP_KEY generada"
else
  echo "  → .env ya existe"
fi

# 6. Migraciones y seeders
echo "[6/6] Ejecutando migraciones y seeders..."
php artisan migrate --force --seed --quiet 2>&1 | tail -2
php artisan storage:link --quiet 2>/dev/null || true
echo "  ✓ Base de datos lista"

echo ""
echo "========================================="
echo "  ¡Instalación completada!"
echo "========================================="
echo ""
echo "  Inicia el servidor:"
echo "  cd $DIR && php artisan serve"
echo ""
echo "  Credenciales de prueba:"
echo "  Admin:      admin@tutorias.com / admin123"
echo "  Tutor:      juan@tutorias.com / tutor123"
echo "  Estudiante: maria@tutorias.com / estudiante123"
echo ""
