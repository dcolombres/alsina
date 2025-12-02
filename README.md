# Gestor Alsina

Este es un sistema de gestión interna para Alsina, diseñado para administrar Proyectos, Staff y Clientes. La aplicación está construida con Laravel y utiliza Inertia.js con Vue.js para el frontend.

## Descripción del Proyecto

El panel principal proporciona un resumen y acceso rápido a las siguientes secciones:

*   **Proyectos:** Permite la gestión de todos los proyectos, su estado, tecnologías, clientes y personal asignado.
*   **Staff:** Administración del personal, roles, seniority y asignaciones a proyectos.
*   **Clientes:** Gestión de la información de contacto y los proyectos asociados a cada cliente.

## Instalación y Puesta en Marcha

Para una guía detallada de instalación y configuración, por favor consulta el archivo [**INSTRUCCIONES.md**](INSTRUCCIONES.md).

Los pasos generales son:
1.  Clonar el repositorio.
2.  Instalar dependencias con `composer install` y `npm install`.
3.  Configurar el archivo `.env`.
4.  **Configurar la base de datos (ver INSTRUCCIONES.md para las opciones).**
5.  Iniciar los servidores con `php artisan serve` y `npm run dev`.

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