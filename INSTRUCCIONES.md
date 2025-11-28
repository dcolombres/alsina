# Instrucciones de Instalación y Uso del Sistema "Alsina"

Este documento proporciona las instrucciones necesarias para configurar y ejecutar el proyecto en un entorno de desarrollo local.

## 1. Requisitos Previos

Asegúrate de tener instalado el siguiente software en tu sistema:

- **PHP >= 8.0.2**
- **Composer** (Gestor de dependencias de PHP)
- **Node.js y npm** (Gestor de paquetes de JavaScript)
- Una base de datos (ej. MySQL, MariaDB, PostgreSQL)

## 2. Configuración del Proyecto

1.  **Clonar el repositorio:**
    Si estás leyendo esto, es probable que ya lo hayas hecho. Si no, clona el repositorio en tu máquina local.
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd <NOMBRE_DEL_DIRECTORIO>
    ```

2.  **Crear el fichero de entorno:**
    Copia el fichero de ejemplo `.env.example` a un nuevo fichero llamado `.env`. Este fichero contendrá las variables de entorno específicas de tu máquina.
    ```bash
    cp .env.example .env
    ```

3.  **Configurar la base de datos:**
    Abre el fichero `.env` y modifica las siguientes variables con los datos de tu base de datos local. Asegúrate de que la base de datos (en este ejemplo, `alsina`) exista.
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=alsina
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Instalar dependencias:**
    - Instala las dependencias de PHP con Composer:
      ```bash
      composer install
      ```
    - Instala las dependencias de JavaScript con npm:
      ```bash
      npm install
      ```

5.  **Generar la clave de la aplicación:**
    Este paso es crucial para la seguridad de la aplicación (sesiones, encriptación, etc.).
    ```bash
    php artisan key:generate
    ```

## 3. Puesta en Marcha

1.  **Ejecutar las migraciones:**
    Para crear toda la estructura de tablas en la base de datos, ejecuta:
    ```bash
    php artisan migrate:fresh
    ```
    *(Se recomienda `migrate:fresh` para un entorno de desarrollo para asegurar un estado limpio de la base de datos, ya que borra todas las tablas antes de volver a crearlas).*

2.  **Iniciar los servidores de desarrollo:**
    Debes tener dos terminales abiertas para ejecutar los siguientes comandos concurrentemente.

    - En la **primera terminal**, inicia el servidor de Vite para el frontend (compila y actualiza los assets de Vue, CSS, etc.):
      ```bash
      npm run dev
      ```
    - En la **segunda terminal**, inicia el servidor de Laravel para el backend:
      ```bash
      php artisan serve
      ```

## 4. Acceso a la Aplicación

- **URL:** Una vez iniciados los servidores, la aplicación estará disponible en: **http://127.0.0.1:8000**

- **Usuarios:** No hay usuarios creados por defecto. Debes utilizar la opción **"Register"** en la pantalla de login para crear tu propio usuario y poder acceder al sistema.
