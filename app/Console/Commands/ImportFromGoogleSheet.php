<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\LazyCollection;
use App\Models\Cliente;
use App\Models\Staff;
use App\Models\Proyecto;
use Throwable;

class ImportFromGoogleSheet extends Command
{
    protected $signature = 'import:google-sheet';
    protected $description = 'Importa y sincroniza datos desde hojas de cálculo de Google.';
    private $projectsUrl = 'https://docs.google.com/spreadsheets/d/1vIYftIFVlSWkh0wZf7C6oMoLSpVhzXrGhk66bC1HHnw/export?format=csv&gid=624172062';
    private $staffUrl = 'https://docs.google.com/spreadsheets/d/1vIYftIFVlSWkh0wZf7C6oMoLSpVhzXrGhk66bC1HHnw/export?format=csv&gid=1414011816';

    public function handle()
    {
        if (!$this->confirm('Esto borrará todos los proyectos, staff y clientes existentes y los reemplazará con los datos de la hoja de cálculo. ¿Deseas continuar?')) {
            $this->info('Importación cancelada.');
            return 0;
        }

        try {
            $this->importProjectsAndInitialStaff();
            $this->syncStaffData();
            $this->info("\n¡Proceso de importación y sincronización completado con éxito!");
        } catch (Throwable $e) {
            $this->error("\nOcurrió un error: " . $e->getMessage());
            $this->error('En el archivo: ' . $e->getFile() . ' línea: ' . $e->getLine());
            return 1;
        }

        return 0;
    }

    private function importProjectsAndInitialStaff()
    {
        $this->info('Limpiando la base de datos...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('proyecto_staff')->truncate();
        DB::table('cliente_proyecto')->truncate();
        Proyecto::truncate();
        Staff::truncate();
        Cliente::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->info('Base de datos limpiada.');

        $this->info('Descargando datos de proyectos...');
        $response = Http::get($this->projectsUrl);
        if ($response->failed()) {
            throw new \Exception('No se pudo descargar el archivo CSV de proyectos.');
        }
        
        $this->info('Procesando datos de proyectos y creando staff inicial...');
        $data = $response->body();

        LazyCollection::make(function () use ($data) {
            $lines = preg_split('/\r\n|\r|\n/', $data);
            foreach ($lines as $line) { yield $line; }
        })
        ->skip(1)
        ->each(function ($line) {
            $csvRow = str_getcsv($line);
            if (empty(array_filter($csvRow)) || empty(trim($csvRow[0] ?? ''))) {
                return; // Reemplaza 'continue'
            }

            $defaultStaffValues = [
                'apellidos' => '', 'rol' => 'Sin Asignar', 'tipo' => 'Indefinido', 
                'seniority' => 'Sin Asignar', 'contrato' => 'Indefinido', 'modalidad' => 'Remoto', 'activo' => true
            ];

            $cliente = Cliente::firstOrCreate(['nombre' => trim($csvRow[10] ?? 'No especificado')], ['apellido' => '(Organismo)']);
            
            $responsable = null;
            if (!empty(trim($csvRow[11] ?? ''))) {
                $responsableName = trim($csvRow[11]);
                $responsable = Staff::firstOrCreate(
                    ['nombres' => $responsableName],
                    array_merge($defaultStaffValues, ['email' => strtolower(str_replace(' ', '.', $responsableName)) . '@example.com'])
                );
            }

            $proyecto = Proyecto::create([
                'nombre' => trim($csvRow[0] ?? ''), 'descripcion' => trim($csvRow[1] ?? ''), 'origen' => trim($csvRow[2] ?? ''),
                'dependencia' => trim($csvRow[3] ?? ''), 'tier' => trim($csvRow[4] ?? ''), 'cliente_id' => $cliente->id,
                'estado' => strtolower(trim($csvRow[8] ?? 'Operativo')), 'responsable_id' => $responsable->id ?? null,
                'observacion' => trim($csvRow[12] ?? ''),
            ]);

            if (!empty(trim($csvRow[6] ?? ''))) {
                $equipoNombres = explode(',', trim($csvRow[6]));
                $staffIds = [];
                foreach ($equipoNombres as $nombre) {
                    $nombre = trim($nombre);
                    if (!empty($nombre)) {
                        $miembro = Staff::firstOrCreate(
                            ['nombres' => $nombre],
                            array_merge($defaultStaffValues, ['email' => strtolower(str_replace(' ', '.', $nombre)) . '@example.com'])
                        );
                        $staffIds[] = $miembro->id;
                    }
                }
                $proyecto->staff()->sync($staffIds);
            }
            $this->output->write('.');
        });
    }

    private function syncStaffData()
    {
        $this->info("\nSincronizando emails y nombres del personal...");
        $response = Http::get($this->staffUrl);
        if ($response->failed()) {
            throw new \Exception('No se pudo descargar el archivo CSV de personal.');
        }

        $data = $response->body();
        LazyCollection::make(function () use ($data) {
            $lines = preg_split('/\r\n|\r|\n/', $data);
            foreach ($lines as $line) { yield $line; }
        })
        ->skip(2)
        ->each(function ($line) {
            $csvRow = str_getcsv($line);
            if (empty(array_filter($csvRow))) {
                return; // Reemplaza 'continue'
            }

            $email = trim($csvRow[1] ?? '');
            $fullName = trim($csvRow[0] ?? '');

            if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($fullName)) {
                $parts = explode(' ', $fullName, 2);
                $nombres = $parts[0] ?? '';
                $apellidos = $parts[1] ?? '';

                $defaultValues = [
                    'rol' => 'Sin Asignar', 'tipo' => 'Indefinido', 'seniority' => 'Sin Asignar',
                    'contrato' => 'Indefinido', 'modalidad' => 'Remoto', 'activo' => true
                ];

                Staff::updateOrCreate(
                    ['email' => $email],
                    array_merge($defaultValues, ['nombres' => $nombres, 'apellidos' => $apellidos])
                );
                $this->output->write('s');
            }
        });
    }
}
