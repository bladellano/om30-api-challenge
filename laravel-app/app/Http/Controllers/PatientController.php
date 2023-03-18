<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Address;
use App\Models\Patient;
use App\Rules\CnsValidation;
use App\Rules\CpfValidation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $patients = Patient::with('address')
        ->where('full_name', 'like', '%'.$search.'%')
        ->orWhere('cpf', 'like', '%'.$search.'%')
        ->paginate(10);

        if (!$patients->total()) {
            return response()->json(['message' => 'No record found.'], 404);
        }

        return response()->json($patients);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'mother_full_name' => 'required',
            'date_of_birth' => 'required|date_format:d/m/Y',
            'cpf' => ['required','unique:patients',new CpfValidation()],
            'cns' => ['required','unique:patients',new CnsValidation()],

            'address.street' => 'required',
            'address.number' => 'required',
            'address.zip_code' => 'required',
            'address.district' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
            ], 422);
        }

        // Proccess
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $data['photo'] = $path;
        }

        $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');

        $address = $data['address'];
        unset($data['address']);

        // Create Patient
        $patient = Patient::create($data);

        // Create Address
        $address['patient_id'] = $patient->id;
        $addressPatient = Address::create($address);

        return response()->json(Patient::with('address')->find($patient->id), 201);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $patient->address;
        return response()->json($patient);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'mother_full_name' => 'required',
            'date_of_birth' => 'required|date_format:d/m/Y',
            'cpf' => ['required',new CpfValidation()],
            'cns' => ['required',new CnsValidation()],

            'address.street' => 'required',
            'address.number' => 'required',
            'address.zip_code' => 'required',
            'address.district' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
            ], 422);
        }

        $data = $request->all();
        $dataAddress = $data['address'];

        unset($data['_method']);
        unset($data['photo']);
        unset($data['address']);

        if ($request->hasFile('photo')) {

            if($patient->photo)
                Storage::disk('public')->delete($patient->photo);

            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $data['photo'] = $path;
        }

        $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');

        if ($patient->update($data) && $patient->address->update($dataAddress)) {
            return response()->json(Patient::with('address')->find($patient->id));
        }

        return response()->json(['message' => 'Unsuccessful update.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        if($patient->photo)
            Storage::disk('public')->delete($patient->photo);

        $patient->delete();

        return response()->json(['message' => 'Record removed successfully.']);
    }
}
