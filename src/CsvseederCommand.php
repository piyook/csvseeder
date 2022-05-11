<?php

namespace Piyook\Csvseeder;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

#[AsCommand(name: 'make:csvseeder')]

class CsvseederCommand extends GeneratorCommand
{

    protected $name = 'make:csvseeder';
    protected $type = 'seeder';
    /**
     * The name and signature of the console command.
     *
     * @var string
     * 
     */
    protected $signature = 'make:csvseeder {name : the name of DB table to seed} {columns : array of columns to import E.g [col1,col2,col3,...]} {path? : (optional) non-default save location E.g db/seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CSV seeder class';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

    }


    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }


    /**
     * Return the stub file path
     * @return string
     *
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/csvseeder.stub';
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {

        return [
            'NAMESPACE'         => 'Database\Seeders',
            'CLASS_NAME'        => $this->getSingularClassName($this->argument('name')).'CSV',
            'TABLE_NAME'        => $this->argument('name'),
            'COLUMN_NAMES'      => json_encode(preg_split("/,/", trim($this->argument('columns'),"/\]\[/")))
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStub(), $this->getStubVariables());
    }


    /**
     * Replace the stub variables(key) with the desired value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */

    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('{{' . $search . '}}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    
    {
        $base_path = $this->argument('path') ?? 'database/seeders';

        return base_path($base_path) . '/' . $this->getSingularClassName($this->argument('name')) . 'CSV.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    
}
