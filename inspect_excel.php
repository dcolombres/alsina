<?php

require __DIR__.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = '/media/colombres/DATOS/dev/alsina/plantilla_datos_nov25.xlsx';

try {
    $spreadsheet = IOFactory::load($file);
    
    echo "Sheet names:\n";
    foreach ($spreadsheet->getSheetNames() as $sheetName) {
        echo "- $sheetName\n";
    }
    
    echo "\n";
    
    foreach ($spreadsheet->getAllSheets() as $sheet) {
        echo "=== Sheet: " . $sheet->getTitle() . " ===\n";
        
        // Get headers (first row)
        $headers = [];
        $firstRow = $sheet->getRowIterator(1, 1)->current();
        foreach ($firstRow->getCellIterator() as $cell) {
            $headers[] = $cell->getValue();
        }
        
        echo "Columns: " . implode(', ', array_filter($headers)) . "\n";
        echo "Total rows: " . $sheet->getHighestRow() . "\n";
        
        // Show first 3 data rows
        echo "\nFirst 3 rows:\n";
        $rowNum = 0;
        foreach ($sheet->getRowIterator() as $row) {
            if ($rowNum > 3) break;
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            echo implode(' | ', array_map(function($v) { 
                return substr((string)$v, 0, 30); 
            }, $rowData)) . "\n";
            $rowNum++;
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
