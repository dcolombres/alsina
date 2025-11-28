<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->bs,
            'descripcion' => $this->faker->paragraph,
            'origen' => $this->faker->company,
            'dependencia' => $this->faker->company,
            'tier' => $this->faker->randomElement(['Tier 1', 'Tier 2', 'Tier 3']),
            'cliente_id' => Cliente::factory(),
            'estado' => $this->faker->randomElement(['activo', 'inactivo', 'en desarrollo']),
            'categoria' => $this->faker->word,
            'subcategoria' => $this->faker->word,
            'responsable_id' => Staff::factory(),
            'observacion' => $this->faker->sentence,
            'urls' => json_encode(['produccion' => $this->faker->url, 'desarrollo' => $this->faker->url]),
            'captura' => $this->faker->imageUrl,
            'nube' => $this->faker->randomElement(['AWS', 'GCP', 'Azure']),
            'ticketera_interna' => $this->faker->url,
            'ticketera_externa' => $this->faker->url,
            'changelog' => $this->faker->text,
            'ano' => $this->faker->year,
            'usuarios_internos' => $this->faker->numberBetween(1, 100),
            'usuarios_externos' => $this->faker->numberBetween(100, 10000),
            'versionado' => 'Git',
            'vms' => $this->faker->numberBetween(1, 5),
            'instrucciones_deploy' => $this->faker->text,
            'referente' => $this->faker->name,
            'notas_infraestructura' => $this->faker->text,

            // New fields
            'lenguaje_principal_backend' => $this->faker->randomElement(['PHP', 'Node.js', 'Python']),
            'version_backend' => $this->faker->semver,
            'otro_lenguaje_backend' => null,
            'librerias_backend' => $this->faker->words(3, true),
            'framework_backend' => $this->faker->randomElement(['Laravel', 'Express', 'Django']),
            'lenguaje_principal_frontend' => $this->faker->randomElement(['React', 'Angular', 'VUE js', 'Otro']),
            'version_frontend' => $this->faker->semver,
            'otro_lenguaje_frontend' => null,
            'librerias_frontend' => $this->faker->words(3, true),
            'framework_frontend' => $this->faker->randomElement(['Next.js', 'Nuxt.js', 'Gatsby']),
            'tecnologia_bd' => $this->faker->randomElement(['MySQL', 'PostgreSQL', 'MongoDB']),
            'version_bd' => $this->faker->semver,
            'bd_2' => null,
            'tamaño_bd' => $this->faker->numberBetween(1, 100) . 'GB',
            'servidor_bd' => $this->faker->domainName,
            'backup_bd' => $this->faker->boolean,
            'repositorio' => $this->faker->randomElement(['git.produccion.gob.ar', 'Otro Gitlab', 'Github', 'BitBucket', 'Subversion', 'Otro']),
            'url_repositorio' => $this->faker->url,
            'instrucciones_stack' => $this->faker->boolean,
            'alojamiento_productivo' => $this->faker->domainName,
            'alojamiento_hml' => $this->faker->domainName,
            'alojamiento_tst' => $this->faker->domainName,
            'contenedor' => $this->faker->boolean,
        ];
    }
}