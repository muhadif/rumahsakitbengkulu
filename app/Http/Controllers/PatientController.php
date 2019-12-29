<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\User;
use Phpml\Association\Apriori;
use DB;
use Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients = Patient::paginate(10);
        return view('patient.index', ['patients' => $patients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->date = $request->date;
        $patient->category = $request->category;
        $patient->address = $request->address;
        $patient->doctor = $request->doctor;
        $patient->diagnosis = $request->diagnosis;
        $patient->employee()->associate(User::where('id', Auth::id())->first());
        $patient->save();
        return redirect('patients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::where('id', $id)->first();
        return $patient;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = Patient::where('id', $id)->first();
        return view('patient.edit', ['patient'=>$patient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $patient = Patient::where('id', $id)->first();
        $patient->name = $request->name;
        $patient->date = $request->date;
        $patient->category = $request->category;
        $patient->address = $request->address;
        $patient->doctor = $request->doctor;
        $patient->diagnosis = $request->diagnosis;
        $patient->employee()->associate(User::where('id', Auth::id())->first());
        $patient->save();
        return redirect('patients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $patient = Patient::where('id', $id)->first();
        $patient->delete();
        return redirect('patients');
    }

    public function calculate_apriori(Request $request) 
    {
        $associator = new Apriori($support = $request->support, $confidence = $request->confidence);
        $labels = [];
        $datas = [];
        // for($i = 0; $i < 12; $i++) 
        // {
        //     $data = DB::select('select date_format(date, "%m %Y") as date, diagnosis from patients where month(date) = ?', [$i+1]);
        //     $data = array_map(function($value) {
        //         return (array)$value;
        //     }, $data);
        //     array_push($datas, $data);
        // }
        // $samples = [['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta']];
        $data = DB::select('select diagnosis from patients');
        $data = array_map(function($value) {
            return (array)$value;
        }, $data);
        $associator->train($data, $labels);
        $result = $associator->apriori();
        if(count($result)<1) {
            return view('patient.error.noresult');
        }
        return view('patient.calculate', ['data'=>$result]);
    }
}
