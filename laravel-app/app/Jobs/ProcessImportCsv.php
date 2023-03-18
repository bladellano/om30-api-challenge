<?php

namespace App\Jobs;

use App\Models\Address;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessImportCsv implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $rowData) {
            try {
                DB::beginTransaction();

                $patient = Patient::create([
                    'full_name' => $rowData[0],
                    'mother_full_name' => $rowData[1],
                    'date_of_birth' => implode('-', array_reverse(explode('/', $rowData[2]))),
                    'cpf' => preg_replace('/[^0-9]/', '', $rowData[3]),
                    'cns' => $rowData[4],
                ]);

                $address = Address::create([
                    'street' => $rowData[5],
                    'number' => $rowData[6],
                    'zip_code' => $rowData[7],
                    'complement' => $rowData[8],
                    'district' => $rowData[9],
                    'city' => $rowData[10],
                    'state' => $rowData[11],
                    'patient_id' => $patient->id,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage()], 404);
            }
        }

        return response()->json(['message' => 'File imported successfully.']);
    }
}
