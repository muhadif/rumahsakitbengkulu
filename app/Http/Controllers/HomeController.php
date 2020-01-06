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
        $diagnoses = DB::select('select distinct diagnosis from data where diagnosis <> "-"');
        $patient_count = count(DB::select('select name as count from data group by name'));
        
        $date = $request->input('date', 'NOW()');
        if(isset($request->diagnosis)) {
            $result = DB::select("SELECT MONTH(DATE) AS month, COUNT(*) AS total FROM data WHERE diagnosis = ? AND DATE BETWEEN DATE_SUB('".$date."',INTERVAL 1 YEAR) AND '".$date."' GROUP BY MONTH(DATE)", [$request->diagnosis]);
        }
        else {
            $result = DB::select("SELECT MONTH(DATE) AS month, COUNT(*) AS total FROM data WHERE DATE BETWEEN DATE_SUB(".$date.",INTERVAL 1 YEAR) AND ".$date." GROUP BY MONTH(DATE)");
        }
        $convertedResult = [];
        foreach($result as $key => $value) {
            $convertedResult[$value->month] = $value->total;
        }
        $dataCounts = [];
        for($i = 0; $i < 12; $i++) {
            if(array_key_exists($i+1, $convertedResult)) {
                $dataCounts[$i] = $convertedResult[$i+1];
            } else {
                $dataCounts[$i] = 0;
            }
        }
        $chart_data = "[".implode(",", $dataCounts)."]";

        return view('dashboard', ['diagnoses'=>$diagnoses, 'patient_count'=>$patient_count, 'diagnosis_count'=>count($diagnoses), 'chart_data' => $chart_data]);
    }
}
