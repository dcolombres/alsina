<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ImportExcelData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-excel-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borra los datos actuales e importa nuevos datos desde un archivo Excel especificado.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = '/Users/dcolom/Local Sites/Alsina/plantilla_datos_DIC25.xlsx';
        $this->info("Iniciando la importación desde: {$path}");

        try {
            $this->info('Leyendo el archivo Excel en memoria...');
            $collection = Excel::toCollection(new \stdClass, $path);
            $this->info('Archivo leído. Empezando a importar (sin transacción)...');

            $this->info('Borrando datos antiguos...');

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            DB::table('proyecto_staff')->truncate();
            DB::table('cliente_proyecto')->truncate();
            DB::table('proyectos')->truncate();
            DB::table('staff')->truncate();
            DB::table('clientes')->truncate();
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->info('Datos antiguos eliminados.');

            // *** Hoja 0: Proyectos (Mapeo final y completo) ***
            $proyectosSheet = $collection[0];
            foreach ($proyectosSheet->skip(1) as $row) {
                DB::table('proyectos')->insert([
                    'id' => $row[0],
                    'nombre' => $row[1],
                    'descripcion' => $row[2],
                    'dependencia' => $row[4], // Mapeado desde 'area_funcional'
                    'tier' => $row[5],
                    'estado' => $row[7] ?? 'activo',
                    'categoria' => $row[8],
                    'referente' => $row[10], // Mapeado desde 'responsable'/'gerente_funcional'
                ]);
            }
            $this->info('Proyectos importados.');

            // *** Hoja 1: Staff (Mapeo final y completo) ***
            $staffSheet = $collection[1];
            foreach ($staffSheet->skip(1) as $row) {
                DB::table('staff')->insert([
                    'id' => $row[0],
                    'nombres' => $row[1] . ' ' . $row[2],
                    'email' => $row[3] ?? "sin-email-" . uniqid() . "@alsina.dev", // Placeholder único y aleatorio
                    'rol' => $row[5] ?? 'Sin rol',
                    'tipo' => $row[6] ?? 'General',
                    'seniority' => $row[7],
                    'tecnologia' => $row[8],
                    'contrato' => $row[9] ?? 'No especificado',
                    'modalidad' => $row[13] ?? 'No especificado',
                    'dias_presencial' => $row[15] ?? 0,
                    'dias_remoto' => $row[16] ?? 0,
                    'activo' => 1,
                ]);
            }
            $this->info('Staff importado.');

            // *** ASUNCIÓN: La hoja 2 contiene los Clientes ***
            $clientesSheet = $collection[2];
            foreach ($clientesSheet->skip(1) as $row) {
                DB::table('clientes')->insert([
                    'id' => $row[0],
                    'nombre_cliente' => $row[1],
                    'persona_contacto' => $row[2],
                    'email_contacto' => $row[3],
                    'telefono_contacto' => $row[4],
                ]);
            }
            $this->info('Clientes importados.');

            $this->info('¡Importación completada con éxito!');
            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error('Ha ocurrido un error durante la importación:');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
