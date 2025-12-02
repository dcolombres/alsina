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

Una vez configurado el entorno y las dependencias, tienes dos opciones para inicializar la base de datos.

### Opción 1: Restaurar desde Backup (Recomendado)

Este método cargará la base de datos con datos de producción actualizados, incluyendo proyectos, staff, clientes y usuarios pre-configurados.

1.  **Crear una base de datos vacía:** Asegúrate de que la base de datos configurada en tu archivo `.env` (ej. `alsina`) exista y esté vacía.

2.  **Importar el archivo de backup:** Ejecuta el siguiente comando en tu terminal. Reemplaza `[usuario]` y `[contraseña]` por tus credenciales de MySQL si es necesario. El archivo de backup es `alsina_backup_20251201.sql.gz`.

    ```bash
    gunzip < alsina_backup_20251201.sql.gz | mysql -u [usuario] -p[contraseña] alsina
    ```
    *(Nota: Si tu usuario no tiene contraseña, puedes omitir `-p[contraseña]` y el sistema te la pedirá, o si no hay clave, simplemente `-p` y presionar Enter).*

### Opción 2: Crear Base de Datos desde Cero

Este método creará la estructura de la base de datos y la llenará con datos de prueba básicos. Es útil para un entorno completamente limpio.

1.  **Ejecutar las migraciones y seeders:**
    ```bash
    php artisan migrate:fresh --seed
    ```

## 4. Iniciar los Servidores de Desarrollo

Independientemente de la opción que hayas elegido para la base de datos, los siguientes pasos son los mismos. Debes tener dos terminales abiertas para ejecutar los siguientes comandos concurrentemente.

- En la **primera terminal**, inicia el servidor de Vite para el frontend:
  ```bash
  npm run dev
  ```
- En la **segunda terminal**, inicia el servidor de Laravel para el backend:
  ```bash
  php artisan serve
  ```

## 5. Acceso a la Aplicación

- **URL:** Una vez iniciados los servidores, la aplicación estará disponible en: **http://127.0.0.1:8000**

- **Usuarios:**
    - Si has restaurado la base de datos desde el backup (**Opción 1**), ya existen usuarios de prueba:
        - **Administrador:** `admin@alsina.com` (contraseña: `password`)
        - **Usuario Estándar:** `user@alsina.com` (contraseña: `password`)
    - Si has creado la base de datos desde cero (**Opción 2**), no hay usuarios creados. Debes utilizar la opción **"Register"** en la pantalla de login para crear tu propio usuario.
