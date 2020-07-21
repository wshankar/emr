<?php

namespace App\Http\Controllers;

use App\Events\PatientEvent;
use App\Http\Resources\PatientResource;
use App\Notifications\BookingNoti;
use App\Patient;
use App\User;
use Illuminate\Http\Request;

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
        return PatientResource::collection(Patient::latest()->paginate(5));
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
            'fatherName' => 'required'
        ]);

        $patient= Patient::create([
            'name' => $request['name'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'fatherName' => $request['fatherName']
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
            'fatherName' => 'required'
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

    public function search()
    {
        if ($search = \Request::get('q')) {
            $users = Patient::where(function($query) use ($search){
                $query->where('name', 'Like', "%$search%")
                      ->orWhere('address', 'Like', "%$search%")
                      ->orWhere('fatherName', 'Like', "%$search%");
            })->paginate(5);
        }else{
            $users = Patient::latest()->paginate(5);
        }
        
        return PatientResource::collection($users);
    } 
}
