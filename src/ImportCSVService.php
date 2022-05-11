<?php

namespace Piyook\Csvseeder;

use Piyook\Csvseeder\ImportDataContract;
use Illuminate\Support\Facades\DB;

/**
 * Handles CSV data files stored in local folder in app\database\data
 */
class ImportCSVService implements ImportDataContract{
    
    /**
     * Import a local CSV file and insert 
     * into DB table with same name
     * @param string $path
     * Relative path to folder containing data file
     * @param  string $table
     * Table/CSV file name 
     * @param  array $columns
     * Column names 
     * @return void
     */
    public function import(string $table, array $columns, string $path="database/data")
    {
        
        $csvFile = fopen(base_path("$path/$table.csv"), "r");

        

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            $query = [];
            if (!$firstline) {
                foreach ($columns as $index => $column) {
                    $query += [$column => $data[$index]];
                }
                DB::table($table)->insert($query);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}