<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ImportCsvControllerTest extends TestCase
{

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
