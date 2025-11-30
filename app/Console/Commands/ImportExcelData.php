<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Proyecto;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class ImportExcelData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel-data {file=plantilla_datos_nov25.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from Excel file into proyectos and staff tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = base_path($this->argument('file'));
        
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Loading Excel file: {$filePath}");
        
        try {
            $spreadsheet = IOFactory::load($filePath);
            
            // Clear existing data
            if ($this->confirm('This will delete all existing records in proyectos and staff tables. Continue?', true)) {
                $this->info('Clearing existing data...');
                DB::table('proyecto_staff')->delete();
                DB::table('proyectos')->delete();
                DB::table('staff')->delete();
                $this->info('✓ Existing data cleared');
            } else {
                $this->info('Import cancelled.');
                return 0;
            }
            
            // Import Staff
            $this->info("\nImporting Staff data...");
            $staffSheet = $spreadsheet->getSheetByName('Staff');
            $this->importStaff($staffSheet);
            
            // Import Proyectos
            $this->info("\nImporting Proyectos data...");
            $proyectosSheet = $spreadsheet->getSheetByName('Proyectos');
            $this->importProyectos($proyectosSheet);
            
            $this->info("\n✓ Import completed successfully!");
            $this->info("Staff records: " . Staff::count());
            $this->info("Proyectos records: " . Proyecto::count());
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
    
    private function importStaff($sheet)
    {
        $headers = [];
        $firstRow = $sheet->getRowIterator(1, 1)->current();
        foreach ($firstRow->getCellIterator() as $cell) {
            $headers[] = $cell->getValue();
        }
        
        $rowNum = 0;
        $imported = 0;
        
        foreach ($sheet->getRowIterator(2) as $row) {
            $rowData = [];
            $cellIndex = 0;
            
            foreach ($row->getCellIterator() as $cell) {
                if (isset($headers[$cellIndex])) {
                    $rowData[$headers[$cellIndex]] = $cell->getValue();
                }
                $cellIndex++;
            }
            
            // Skip empty rows
            if (empty($rowData['email']) || trim($rowData['email']) === '') {
                continue;
            }
            
            try {
                Staff::create([
                    'nombres' => $rowData['nombres'] ?? null,
                    'apellidos' => $rowData['apellidos'] ?? null,
                    'email' => $rowData['email'],
                    'celular' => $rowData['celular'] ?? null,
                    'rol' => $rowData['rol'] ?? 'N/A',
                    'tipo' => $rowData['tipo'] ?? 'N/A',
                    'seniority' => $rowData['seniority'] ?? 'N/A',
                    'tecnologia' => $rowData['tecnologia'] ?? null,
                    'contrato' => $rowData['contrato'] ?? 'N/A',
                    'remuneracion' => $rowData['remuneracion'] ?? null,
                    'ur' => $this->convertToBoolean($rowData['ur'] ?? false),
                    'urgencia' => $rowData['urgencia'] ?? null,
                    'extras' => $this->convertToBoolean($rowData['extras'] ?? false),
                    'modalidad' => $rowData['modalidad'] ?? 'N/A',
                    'activo' => $this->convertToBoolean($rowData['activo'] ?? true),
                    'dias_presencial' => (int)($rowData['dias_presencial'] ?? 0),
                    'dias_remoto' => (int)($rowData['dias_remoto'] ?? 0),
                ]);
                
                $imported++;
                
                if ($imported % 50 == 0) {
                    $this->info("  Imported {$imported} staff records...");
                }
            } catch (\Exception $e) {
                $this->warn("  Skipped row {$rowNum}: " . $e->getMessage());
            }
            
            $rowNum++;
        }
        
        $this->info("✓ Imported {$imported} staff records");
    }
    
    private function importProyectos($sheet)
    {
        $headers = [];
        $firstRow = $sheet->getRowIterator(1, 1)->current();
        foreach ($firstRow->getCellIterator() as $cell) {
            $headers[] = $cell->getValue();
        }
        
        $rowNum = 0;
        $imported = 0;
        
        foreach ($sheet->getRowIterator(2) as $row) {
            $rowData = [];
            $cellIndex = 0;
            
            foreach ($row->getCellIterator() as $cell) {
                if (isset($headers[$cellIndex])) {
                    $rowData[$headers[$cellIndex]] = $cell->getValue();
                }
                $cellIndex++;
            }
            
            // Skip empty rows
            if (empty($rowData['nombre']) || trim($rowData['nombre']) === '') {
                continue;
            }
            
            try {
                Proyecto::create([
                    'nombre' => $rowData['nombre'],
                    'descripcion' => $rowData['descripcion'] ?? null,
                    'origen' => $rowData['origen'] ?? null,
                    'dependencia' => $rowData['dependencia'] ?? null,
                    'tier' => $rowData['tier'] ?? null,
                    'cliente_id' => !empty($rowData['cliente_id']) ? (int)$rowData['cliente_id'] : null,
                    'estado' => $rowData['estado'] ?? 'activo',
                    'categoria' => $rowData['categoria'] ?? null,
                    'subcategoria' => $rowData['subcategoria'] ?? null,
                    'responsable_id' => !empty($rowData['responsable_id']) ? (int)$rowData['responsable_id'] : null,
                    'observacion' => $rowData['observacion'] ?? null,
                    'urls' => $rowData['urls'] ?? null,
                    'captura' => $rowData['captura'] ?? null,
                    'nube' => $rowData['nube'] ?? null,
                    'ticketera_interna' => $rowData['ticketera_interna'] ?? null,
                    'ticketera_externa' => $rowData['ticketera_externa'] ?? null,
                    'changelog' => $rowData['changelog'] ?? null,
                    'ano' => !empty($rowData['ano']) ? (int)$rowData['ano'] : null,
                    'usuarios_internos' => !empty($rowData['usuarios_internos']) ? (int)$rowData['usuarios_internos'] : null,
                    'usuarios_externos' => !empty($rowData['usuarios_externos']) ? (int)$rowData['usuarios_externos'] : null,
                    'versionado' => $rowData['versionado'] ?? null,
                    'vms' => $rowData['vms'] ?? null,
                    'instrucciones_deploy' => $rowData['instrucciones_deploy'] ?? null,
                    'referente' => $rowData['referente'] ?? null,
                    'notas_infraestructura' => $rowData['notas_infraestructura'] ?? null,
                    'lenguaje_principal_backend' => $rowData['lenguaje_principal_backend'] ?? null,
                    'version_backend' => $rowData['version_backend'] ?? null,
                    'otro_lenguaje_backend' => $rowData['otro_lenguaje_backend'] ?? null,
                    'librerias_backend' => $rowData['librerias_backend'] ?? null,
                    'framework_backend' => $rowData['framework_backend'] ?? null,
                    'lenguaje_principal_frontend' => $rowData['lenguaje_principal_frontend'] ?? null,
                    'version_frontend' => $rowData['version_frontend'] ?? null,
                    'otro_lenguaje_frontend' => $rowData['otro_lenguaje_frontend'] ?? null,
                    'librerias_frontend' => $rowData['librerias_frontend'] ?? null,
                    'framework_frontend' => $rowData['framework_frontend'] ?? null,
                    'tecnologia_bd' => $rowData['tecnologia_bd'] ?? null,
                    'version_bd' => $rowData['version_bd'] ?? null,
                    'bd_2' => $rowData['bd_2'] ?? null,
                    'tamaño_bd' => $rowData['tamaño_bd'] ?? null,
                    'servidor_bd' => $rowData['servidor_bd'] ?? null,
                    'backup_bd' => $this->convertToBoolean($rowData['backup_bd'] ?? null),
                    'repositorio' => $rowData['repositorio'] ?? null,
                    'url_repositorio' => $rowData['url_repositorio'] ?? null,
                    'instrucciones_stack' => $this->convertToBoolean($rowData['instrucciones_stack'] ?? null),
                    'alojamiento_productivo' => $rowData['alojamiento_productivo'] ?? null,
                    'alojamiento_hml' => $rowData['alojamiento_hml'] ?? null,
                    'alojamiento_tst' => $rowData['alojamiento_tst'] ?? null,
                    'contenedor' => $this->convertToBoolean($rowData['contenedor'] ?? null),
                ]);
                
                $imported++;
                
                if ($imported % 50 == 0) {
                    $this->info("  Imported {$imported} proyecto records...");
                }
            } catch (\Exception $e) {
                $this->warn("  Skipped row {$rowNum}: " . $e->getMessage());
            }
            
            $rowNum++;
        }
        
        $this->info("✓ Imported {$imported} proyecto records");
    }
    
    private function convertToBoolean($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        
        if (is_bool($value)) {
            return $value;
        }
        
        $value = strtolower(trim($value));
        return in_array($value, ['1', 'true', 'yes', 'si', 'sí']);
    }
}
