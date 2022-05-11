<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MakeCsvseederCommandTest extends TestCase
{


    /** @test */
    function it_asserts_csvseeder_class_does_not_already_exist()
    {
        $csvseederClass = base_path('database/seeders/TestCSV.php');

        // make sure we're starting from a clean state
        if (File::exists($csvseederClass)) {
            unlink($csvseederClass);
        }

        $this->assertFalse(File::exists($csvseederClass));
    }

    /** @test */
    function it_creates_new_csvseeder_class()
    {
        $csvseederClass = base_path('database/seeders/TestCSV.php');

        // Run the make command
        Artisan::call('make:csvseeder tests [id,col1,col2,col3,col4,col5]');

        // Assert a new file is created
        $this->assertTrue(File::exists($csvseederClass));
    }

    /** @test */
    function it_creates_new_csvseeder_class_with_a_non_default_path()
    {
        $csvseederClass = base_path('db/seed/TestCSV.php');

         //  Run the make command to migrate a fresh table
         Artisan::call('migrate:fresh');

         //  Seed the table with the newly created csvseeder class
         Artisan::call('db:seed --class=TestCSV');

        // Assert a new file is created
        $this->assertTrue(File::exists($csvseederClass));
    }

    /** @test */
    function it_asserts_csvseeder_class_contents_are_correct()
    {

        $csvseederClass = base_path('database/seeders/TestCSV.php');

        // Assert the file contains the right contents
        $expectedContents = <<<CLASS
        <?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Piyook\Csvseeder\ImportDataContract;

class TestCSV extends Seeder
{
    /**
     * Run the CSV database seeds.
     *
     * @return void
     */
    public function run(ImportDataContract \$CSV)
    {

        \$rows = ["id","col1","col2","col3","col4","col5"];
        \$table = "tests";
        \$CSV->import(\$table, \$rows);
    }
}
CLASS;

        $this->assertEquals(trim(preg_replace('/\R+/', '', $expectedContents)), trim(preg_replace('/\R+/', '', file_get_contents($csvseederClass))));
    }
}
