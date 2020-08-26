<?php

namespace App\Http\Controllers;

use App\Events\PatientEvent;
use App\Http\Resources\PatientResource;
use App\Notifications\BookingNoti;
use App\Patient;
use App\Treatment;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PatientResource::collection(Patient::latest()->paginate(7));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $patient= Patient::create([
            'name' => $request['name'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        ]);
        $user = User::where('id','=', 1)->get();
        broadcast(new PatientEvent($patient));
        return new PatientResource($patient);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PatientResource(Patient::findOrFail($id));
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
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isDoctor');
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return ['message' => 'OK'];
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function search(Request $request)
    {
        if ($search = $request->get('q')) {
            $users = Patient::where(function($query) use ($search){
                $query->where('name', 'Like', "%$search%")
                      ->orWhere('age', 'Like', "%$search%")
                      ->orWhere('address', 'Like', "%$search%");
            })->paginate(7);
        }else{
            $users = Patient::latest()->paginate(7);
        }
        
        return PatientResource::collection($users);
    } 

   public function findByFollowUp(Request $request)
   {
       $search = Carbon::parse($request->get('q'))->format('Y-m-d');
           $users = Treatment::where('follow_up', 'LIKE', "%$search%")->get('patient_id');
          foreach ($users as $user) {
              $id= $user['patient_id'];
              $patients =  Patient::where('id', '=', "$id")->get();
              
              return PatientResource::collection($patients);
          }
        //   foreach ($users as $key => $user) {
        //       $id = $key[$user];
        //       return $key;
        //   }
       
   }

    // public function index(Request $request)
    // {
    //     if ( $request->input('showdata') ) {
    //         return Patient::orderBy('created_at', 'desc')->get();
    //         }
    //         $columns = ['name', 'age','gender', 'address', 'created_at'];
    //         $length = $request->input('length');
    //         $column = $request->input('column');
    //         $search_input = $request->input('search');
    //         $query = Patient::select('name', 'age', 'gender', 'address')
    //         ->orderBy($columns[$column]);
    //         if ($search_input) {
    //         $query->where(function($query) use ($search_input) {
    //         $query->where('name', 'like', '%' . $search_input . '%')
    //         ->orWhere('age', 'like', '%' . $search_input . '%')
    //         ->orWhere('gender', 'like', '%' . $search_input . '%')
    //         ->orWhere('address', 'like', '%' . $search_input . '%');
    //         });
    //         }
    //         $patients = $query->paginate($length);
    //         return ['data' => $patients];
            
    // }
}
