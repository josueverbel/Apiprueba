<?php

namespace App\Http\Controllers;

use Validator;
use App\Trip\Trip;
use App\Customer\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TripWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Trip::all();
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
        $v = Validator::make($request->all(), [
            'country'        => 'required|string',
            'city'           => 'required|string',
            'email'          => 'required|string|email|exists:customers,email',
            'dateofservice'  => 'required|date',
            
        ]);
        if ($v->fails()) return response()->json($v->errors());
   
        try {
            return Trip::create($request->all());
        }catch (\Exception $e) {
            return  response()->json('Error when saving:' .$e->getMessage());
            
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trip\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
        try {
            return Trip::find($trip);
        }catch (\Exception $e) {
            return  response()->json('Error when returning record:' .$e->getMessage());
           
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trip\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trip\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {
        try {
            return Trip::update($request->all(), $trip);
        }catch (\Exception $e) {
            return  response()->json('Error updating record:' .$e->getMessage());
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trip\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
       
        try {
            $customer = Customer::where('email', $trip->email)->first();
        
            $trip->delete();
            Session::flash('message', 'El Viaje ha sido eliminado');
             return redirect()->route('customers.show', $customer->id);
        }catch (\Exception $e) {
            return  response()->json('Fail to deactivate registration:' .$e->getMessage());
        }
    }
    
}
