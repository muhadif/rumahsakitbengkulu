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
        $addresses = DB::select('select distinct address from data');
        $patient_count = count(DB::select('select name as count from data group by name'));
        
        $date = $request->input('date', 'NOW()');
        
        $query = DB::table('data')
            ->select(DB::raw('MONTH(DATE) AS month, COUNT(*) AS total'))
            ->whereBetween('date', [DB::raw("DATE_SUB('".$date."',INTERVAL 1 YEAR)"), $date])
            ->groupBy(DB::raw('MONTH(DATE)'));
        
        if(isset($request->address) && $request->address != 'all') {
            $query = $query->where('address', '=', $request->address);
        }
        if(isset($request->diagnosis) && $request->diagnosis != 'all') {
            $query = $query->where('diagnosis', '=', $request->diagnosis);
        }
        $result = $query->get(['month', 'total']);
        
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

        return view('dashboard', ['diagnoses'=>$diagnoses, 'addresses' => $addresses, 'patient_count'=>$patient_count, 'diagnosis_count'=>count($diagnoses), 'chart_data' => $chart_data]);
    }
}
