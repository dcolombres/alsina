# Gestor Alsina

Este es un sistema de gestión interna para Alsina, diseñado para administrar Proyectos, Staff y Clientes. La aplicación está construida con Laravel y utiliza Inertia.js con Vue.js para el frontend.

## Descripción del Proyecto

El panel principal proporciona un resumen y acceso rápido a las siguientes secciones:

*   **Proyectos:** Permite la gestión de todos los proyectos, su estado, tecnologías, clientes y personal asignado.
*   **Staff:** Administración del personal, roles, seniority y asignaciones a proyectos.
*   **Clientes:** Gestión de la información de contacto y los proyectos asociados a cada cliente.

## Instalación y Puesta en Marcha

Sigue estos pasos para configurar el entorno de desarrollo local.

### 1. Prerrequisitos

*   PHP >= 8.0
*   Composer
*   Node.js & NPM
*   Una base de datos MySQL

### 2. Clonar el Repositorio

```bash
git clone <URL-del-repositorio>
cd Alsina
```

### 3. Instalar Dependencias

Instala las dependencias de PHP y JavaScript.

```bash
composer install
npm install
```

### 4. Configuración del Entorno

Copia el archivo de ejemplo para el entorno y genera la clave de la aplicación.

```bash
cp .env.example .env
php artisan key:generate
```

Abre el archivo `.env` y configura las credenciales de tu base de datos local:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alsina
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 5. Base de Datos

Ejecuta las migraciones para crear la estructura de la base de datos y los seeders para poblarla con datos de ejemplo.

```bash
php artisan migrate:fresh --seed
```
Este comando creará todas las tablas y te dejará un usuario de prueba para que puedas ingresar.

### 6. Iniciar los Servidores

Necesitas dos procesos corriendo en terminales separadas:

1.  **Servidor de Laravel:**
    ```bash
    php artisan serve
    ```
2.  **Servidor de Vite (Frontend):**
    ```bash
    npm run dev
    ```

### 7. Acceso a la Aplicación

Una vez que los servidores estén corriendo, podrás acceder a la aplicación.

*   **URL:** `http://127.0.0.1:8000` (o la que indique el comando `php artisan serve`).
*   **Usuario:** `admin@admin.com`
*   **Contraseña:** `password`

## Guía de Estilo (Poncho)

El proyecto utiliza una identidad visual personalizada basada en el sistema de diseño Poncho.

### Paleta de Colores

La paleta de colores está definida en `tailwind.config.js`.

| Color | Hexadecimal | Clase de Tailwind |
| :--- | :--- | :--- |
| Azul (Primario) | `#232D4F` | `bg-arg-azul` / `text-arg-azul` |
| Azul Cobalto (Secundario) | `#3E5A7E` | `bg-arg-secundario` / `text-arg-secundario` |
| Amarillo (Foco/Alerta) | `#E7BA61` | `bg-arg-amarillo` / `text-arg-amarillo` |
| Verde (Éxito) | `#2E7D33` | `bg-arg-verde` / `text-arg-verde` |
| Rojo (Peligro) | `#C62828` | `bg-arg-rojo` / `text-arg-rojo` |
| Azul Acero (Info) | `#5A7290` | `bg-arg-info` / `text-arg-info` |

### Tipografía

La fuente principal del proyecto es **Encode Sans**, importada desde Google Fonts. Está configurada como la fuente por defecto (`font-sans`) en `tailwind.config.js`.

## Licencia

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).