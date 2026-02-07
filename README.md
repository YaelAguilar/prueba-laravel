# Módulo de Utilidades - Gas Diamante REPSA

Sistema para el cálculo y visualización de utilidad bruta, con gestión completa de proveedores, ingresos y gastos.

## Requisitos Previos

- PHP 8.2 o superior
- Composer
- MySQL 8.0 o superior
- Node.js y NPM

## Instalación

1. Clonar el repositorio
   ```bash
   git clone <url-del-repositorio>
   cd prueba-tecnica-laravel
   ```

2. Copiar `.env.example` a `.env` y configurar base de datos
   ```bash
   cp .env.example .env
   ```
   
   Editar el archivo `.env` y configurar:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=utilities_db
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

3. Instalar dependencias de PHP
   ```bash
   composer install
   ```

4. Instalar dependencias de Node.js
   ```bash
   npm install
   ```

5. Generar clave de aplicación
   ```bash
   php artisan key:generate
   ```

6. Crear la base de datos en MySQL
   ```sql
   CREATE DATABASE utilities_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

7. Ejecutar migraciones y seeders
   ```bash
   php artisan migrate --seed
   ```
   
   Esto creará las tablas y poblará la base de datos con datos de ejemplo:
   - 30+ proveedores
   - 35+ ingresos
   - 35+ gastos

8. Compilar assets (Tailwind CSS)
   ```bash
   npm run dev
   ```
   
   O para producción:
   ```bash
   npm run build
   ```

9. Iniciar servidor de desarrollo
   ```bash
   php artisan serve
   ```
   
   La aplicación estará disponible en `http://localhost:8000`

## Uso

### Vista de Utilidades

- **Ruta:** `/utilities` o `/` (página principal)
- **Funcionalidades:**
  - Ver resumen global con totales de ingresos, gastos y utilidad bruta
  - Filtrar por rango de fechas y/o proveedor
  - Ver tabla detallada por proveedor con ingresos, gastos y utilidad bruta
  - Expandir/contraer detalle de ingresos y gastos por proveedor
  - Indicadores visuales: verde para utilidad positiva, rojo para negativa

### Gestión de Proveedores

- **Ruta:** `/providers`
- **Funcionalidades:**
  - Listar proveedores con paginación (15 por página)
  - Buscar proveedores por nombre
  - Crear nuevos proveedores
  - Editar proveedores existentes
  - Eliminar proveedores (con validación: no permite eliminar si tiene ingresos o gastos asociados)

### Gestión de Ingresos

- **Ruta:** `/incomes`
- **Funcionalidades:**
  - Listar ingresos con paginación (15 por página)
  - Filtrar por rango de fechas y/o proveedor
  - Crear nuevos ingresos
  - Editar ingresos existentes
  - Eliminar ingresos con confirmación

### Gestión de Gastos

- **Ruta:** `/expenses`
- **Funcionalidades:**
  - Listar gastos con paginación (15 por página)
  - Filtrar por rango de fechas y/o proveedor
  - Crear nuevos gastos
  - Editar gastos existentes
  - Eliminar gastos con confirmación

## Características

- Cálculo automático de utilidad bruta
- Filtros dinámicos por fecha y proveedor
- Indicadores visuales (verde para ganancia, rojo para pérdida)
- Diseño responsive con Tailwind CSS
- Validaciones completas en todos los formularios
- Mensajes de confirmación y feedback al usuario
- Paginación con persistencia de filtros
- Búsqueda y filtrado avanzado
- Optimización de consultas (evita N+1 queries)

## Estructura de Base de Datos

### Tabla: `providers`
- `id` (PK)
- `name` (unique)
- `created_at`, `updated_at`

### Tabla: `incomes`
- `id` (PK)
- `provider_id` (FK)
- `amount` (decimal 12,2)
- `concept` (string)
- `date` (date)
- `description` (text, nullable)
- `created_at`, `updated_at`

### Tabla: `expenses`
- `id` (PK)
- `provider_id` (FK)
- `amount` (decimal 12,2)
- `concept` (string)
- `date` (date)
- `description` (text, nullable)
- `created_at`, `updated_at`

## Tecnologías

- Laravel 12.x
- PHP 8.2+
- Tailwind CSS 4.x
- MySQL 8.0+
- Blade Templates
- Vite

## Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recrear base de datos desde cero
php artisan migrate:fresh --seed

# Compilar assets en modo desarrollo (watch)
npm run dev

# Compilar assets para producción
npm run build
```

## Notas de Desarrollo

- El proyecto usa Laravel 12 con PHP 8.2+
- Tailwind CSS está configurado con Vite
- Los seeders generan datos realistas usando Faker
- Las fechas de los seeders están distribuidas en los últimos 3 meses
- Todas las validaciones están implementadas en los controladores
- El diseño es completamente responsive usando Tailwind CSS

## Autor

Desarrollado para Gas Diamante REPSA

## Licencia

Este proyecto es privado y confidencial.
