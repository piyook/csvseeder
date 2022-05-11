<?php

namespace Piyook\CsvSeeder;

/**
 * Interface for importing local files into database
 */
interface ImportDataContract {
    
    /**
     * Import data from a local file and inserts into DB
     * @param string $path
     * Path to File
     * @param  string $table
     * Table File Name
     * @param  array $columns
     * Array of column headers
     * @return void
     */
    public function import(string $table, array $columns, string $path="");
}