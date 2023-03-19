<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportCsvControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        config(['database.connections.sqlite_testing' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]]);

        $this->app['config']->set('database.default', 'sqlite_testing');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_import_csv()
    {
        $file = dirname(__FILE__, 4) . "/import.csv";

        $response = $this->postJson('api/import-csv', [
            'csv' => new UploadedFile($file, '')
        ]);

        $response->assertOk();
    }

    public function test_import_csv_unsuccessfully_empty_file()
    {
        $response = $this->postJson('api/import-csv');
        $response->assertStatus(404);
    }
}
