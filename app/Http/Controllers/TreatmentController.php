<?php

namespace App\Http\Controllers;

use App\Http\Resources\TreatmentResource;
use App\Notifications\NewTreatment;
use App\Notifications\TreatmentNoti;
use App\Patient;
use App\Treatment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return TreatmentResource::collection(Treatment::where('patient_id', '=', $id)->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
             'prescription' => 'required',
             'fees' => 'required'
        ]);
        $treatment = new Treatment;
        $treatment->prescription = $request->input('prescription');
        $treatment->fees = $request->input('fees');
        $treatment->patient_id = $id;
        $treatment->save();
        $users = User::where('id','!=', 1)->get();
        $users->each->notify(new NewTreatment($treatment));  
        // auth('api')->user()->notify(new NewTreatment($treatment));   
        return new TreatmentResource($treatment);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $treatmentId)
    {
        $this->validate($request, [
            'prescription' => 'required',
            'fees' => 'required'
       ]);
       $treatment = Treatment::findOrFail($treatmentId);
       $treatment->update($request->all());
       $users = User::all()->except(auth('api')->id());
       $users->each->notify(new NewTreatment($treatment));  
    //    auth('api')->user()->notify(new NewTreatment($treatment));   
       return new TreatmentResource($treatment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$treatmentId)
    {
        $treatment = Treatment::findOrFail($treatmentId);
        $treatment->delete();

        return ['message' => 'OK'];
    }

        public function getMonthlySum()
    {
        
        $data = DB::table('treatments')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTHNAME(created_at) as month'),
            DB::raw('SUM(fees) as sum')
        )
        ->groupBy('year', 'month')
        ->get(); 

        return $data;
    }

    public function dailyIncome()
    {
        $data = DB::table('treatments')
        ->select(
            DB::raw('MONTHNAME(created_at) as month'),
            DB::raw('DAY(created_at) as day'),
            DB::raw('SUM(fees) as sum')
        )
        ->groupBy('day','month')
        ->latest()
        ->get(); 

        return $data;
    }

    public function yearlyIncome()
    {
        $data = DB::table('treatments')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(fees) as sum')
        )
        ->groupBy('year')
        ->get(); 

        return $data;
    }
}
