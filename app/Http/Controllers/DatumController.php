<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Datum;
use App\User;
use App\Doctor;
use App\Category;
use Phpml\Association\Apriori;
use DB;
use Auth;

class DatumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Auth::user()->authorize('admin');
        $data = Datum::paginate(10);
        $addresses = DB::select('select distinct address from data');
        if($request->action=='print') {
            $data = Datum::all();
        }
        return view('data.index', ['data' => $data, 'addresses'=>$addresses, 'action'=>$request->action]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->authorize('admin');
        $categories = Category::all();
        $doctors = Doctor::all();
        return view('data.create', ['categories' => $categories, 'doctors' => $doctors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->authorize('admin');
        $datum = new Datum();
        $datum->id = $request->id;
        $datum->name = $request->name;
        $datum->date = $request->date;
        $datum->category()->associate(Category::where('id', $request->category)->first());
        $datum->address = $request->address;
        $datum->doctor()->associate(Doctor::where('id', $request->doctor)->first());
        $datum->diagnosis = $request->diagnosis;
        $datum->employee()->associate(User::where('id', Auth::id())->first());
        $datum->save();
        return redirect('admin/data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Auth::user()->authorize('admin');
        $datum = Datum::where('id', $id)->first();
        return $datum;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->authorize('admin');
        $categories = Category::all();
        $doctors = Doctor::all();
        $datum = Datum::where('id', $id)->first();
        return view('data.edit', ['datum'=>$datum, 'categories' => $categories, 'doctors' => $doctors]);
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
        Auth::user()->authorize('admin');
        $datum = Datum::where('id', $id)->first();
        $datum->name = $request->name;
        $datum->date = $request->date;
        $datum->category()->associate(Category::where('id', $request->category)->first());
        $datum->address = $request->address;
        $datum->doctor()->associate(Doctor::where('id', $request->doctor)->first());
        $datum->diagnosis = $request->diagnosis;
        $datum->employee()->associate(User::where('id', Auth::id())->first());
        $datum->save();
        return redirect('admin/data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->authorize('admin');
        $datum = Datum::where('id', $id)->first();
        $datum->delete();
        return redirect('admin/data');
    }

    public function calculateApriori(Request $request) 
    {
        Auth::user()->authorize('admin');
        $associator = new Apriori($support = $request->support, $confidence = $request->confidence);
        $labels = [];
        $data = [];
        $datum = DB::select('select diagnosis from data where diagnosis <> "-"');
        $datum = array_map(function($value) {
            return (array)$value;
        }, $datum);
        $associator->train($datum, $labels);
        $result = $associator->apriori();
        if(count($result)<1) {
            return view('data.error.noresult');
        }
        return view('data.calculate', ['data'=>$result]);
    }

    public function getDataCounts(Request $request) {
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
        return response()->json($dataCounts);
    }

    public function search(Request $request) {
        $result = Datum::where([
            ['name', 'LIKE', '%'.$request->input('name', '').'%'],
            ['address', 'LIKE', '%'.($request->input('address','')=='all'?'':$request->input('address','')).'%']
        ])->paginate(10);
        Auth::user()->authorize('admin');
        $addresses = DB::select('select distinct address from data');
        if($request->action=='print') {
            $data = Datum::all();
        }
        $query_string = ['name' => $request->input('name', ''), 'address' => $request->input('address', '')];
        return view('data.index', ['data' => $result, 'query_string' => $query_string, 'addresses'=>$addresses, 'action'=>$request->action]);
    }
}
