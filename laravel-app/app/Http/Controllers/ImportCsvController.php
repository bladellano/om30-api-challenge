<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessImportCsv;

class ImportCsvController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('csv');

        if (!$file)
            return response()->json(['message' => 'CSV file missing.'], 404);

        $csv    = file($file);
        $chunks = array_chunk($csv, 1000);

        foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);
            if ($key == 0) unset($data[0]);
        }

        ProcessImportCsv::dispatch($data)->delay(now()->addSeconds(10));

        return response()->json(['message' => 'Total rows '.count($data).'. File in processing...']);
    }

}
