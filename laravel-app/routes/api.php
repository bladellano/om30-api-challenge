<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CepController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ImportCsvController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return 'Working...';
});

Route::resource('patients', PatientController::class);

// Route::get('cep/{cep}', [CepController::class,'get']);

// Route::post('import-csv', [ImportCsvController::class,'store']);
