<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\User;

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
        return Patient::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $patient->employee()->attach(User::where('id', $request->employee_id)->first());
        $patient->save();
        return $patient;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
        $patient = Patient::where('id', $id)->first();
        
        return $patient;
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
        $patient->employee()->attach(User::where('id', $request->employee_id)->first());
        $patient->save();
        return $patient;
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
        return $patient;
    }
}
