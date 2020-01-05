<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $diagnoses = DB::select('select distinct diagnosis from data');
        $patient_count = count(DB::select('select name as count from data group by name'));
        return view('dashboard', ['diagnoses'=>$diagnoses, 'patient_count'=>$patient_count, 'diagnosis_count'=>count($diagnoses)]);
    }
}
