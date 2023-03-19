<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Address;
use Illuminate\Support\Facades\Artisan;


class PacientControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config(['database.connections.sqlite_testing' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]]);

        Artisan::call('migrate');
    }

    public function test_list_all_patients()
    {
        Artisan::call('db:seed');

        $response = $this->getJson('api/patients');
        $response->assertStatus(200);
    }

    public function test_pacient_store()
    {
        $dataPatient = [
            'full_name' => fake()->name,
            'mother_full_name' => fake()->name('female'),
            'date_of_birth' => '24/10/1984',
            'cpf' => '83202919253',// is valid
            'cns' => '218135648290009', // is valid
        ];

        $dataAddress = [
            'street' => fake()->streetName,
            'number' => fake()->numberBetween(1, 100),
            'zip_code' => fake()->numerify('########'),
            'complement' => fake()->secondaryAddress,
            'district' => fake()->text(10),
            'city' => fake()->city,
            'state' => mb_strtoupper(fake()->lexify('??')),
        ];

        $dataPatient['address'] = $dataAddress;

        $response = $this->postJson('api/patients', $dataPatient);
        $response->assertCreated();
    }

    public function test_pacient_store_unsuccessfully_cns_invalid()
    {
        $dataPatient = [
            'full_name' => fake()->name,
            'mother_full_name' => fake()->name('female'),
            'date_of_birth' => '24/10/1984',
            'cpf' => '83202919253',// is valid
            'cns' => '111111111111111', // is invalid
        ];

        $dataAddress = [
            'street' => fake()->streetName,
            'number' => fake()->numberBetween(1, 100),
            'zip_code' => fake()->numerify('########'),
            'complement' => fake()->secondaryAddress,
            'district' => fake()->text(10),
            'city' => fake()->city,
            'state' => mb_strtoupper(fake()->lexify('??')),
        ];

        $dataPatient['address'] = $dataAddress;

        $response = $this->postJson('api/patients', $dataPatient);
        $response->assertStatus(422);
    }

    public function test_patient_update()
    {
        $pacientWithAddress = Address::factory()->create();

        $patientId = $pacientWithAddress->patient_id;

        $data = [
            'full_name' => 'Edited',
            'mother_full_name' => 'Edited',
            'date_of_birth' => '11/11/1998',
            'cpf' => '82638514403', // is valid
            'cns' => '747208698020002', // is valid
            'address' => [
                'street' => 'Edited',
                'number' => '1',
                'zip_code' => '111111111',
                'district' => 'Edited',
                'city' => 'Edited',
                'state' => 'EE',
            ]
        ];

        $response = $this->putJson("api/patients/{$patientId}", $data);
        $response->assertOk();
    }

    public function test_patient_delete()
    {
        $pacientWithAddress = Address::factory()->create();
        $patientId = $pacientWithAddress->patient_id;
        $response = $this->deleteJson("api/patients/{$patientId}");
        $response->assertOk();
    }

    public function tearDown(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }
}
