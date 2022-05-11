<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class MigrateCSVFileTest extends TestCase

{
    use RefreshDatabase;

    /** @test */
    public function testDefaultDatabaseIsSqlite()
    {
        $this->assertSame('sqlite', config('database.default'));
    }

    /** @test */
    function it_asserts_csvseeder_class_exist()
    {
        $csvseederClass = base_path('database/seeders/TestCSV.php');

        $this->assertTrue(File::exists($csvseederClass));
    }


    /** @test */
    public function it_asserts_that_a_test_migration_file_is_present()
    {
        $migrationFile = base_path('database/migrations/0000_00_00_000000_create_tests_table.php');

        $this->assertTrue(File::exists($migrationFile));
    }


    /** @test */
    public function it_migrates_and_seeds_a_test_table_with_csv_data()
    {
         //  Run the make command to migrate a fresh table
         Artisan::call('migrate:fresh');

         //  Seed the table with the newly created csvseeder class
         Artisan::call('db:seed --class=TestCSV');

        // test database contains expected values
        $this->assertDatabaseHas('tests', [
            'col1' => '10'
        ]);

        $this->assertDatabaseHas('tests', [
            'col3' => '32'
        ]);

        $this->assertDatabaseHas('tests', [
            'col4' => '23'
        ]);

        $this->assertDatabaseHas('tests', [
            'col5' => '14'
        ]);
    }
}
