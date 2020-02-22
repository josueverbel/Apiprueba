<?php

namespace App\Http\Controllers;

use Validator;
use App\Trip\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
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
            return Trip:: destroy($id);
        }catch (\Exception $e) {
            return  response()->json('Fail to deactivate registration:' .$e->getMessage());
        }
    }
    public function storeListValidate(Request $request)
    {
       
        $xml= $request->getContent();
        $trips = simplexml_load_string($xml);
        $tripsToSave = [];
        $errors = [];
        
        foreach ($trips as $trip) {
            $arrayTrip['email'] = (string) $trip[0]->email;
            $arrayTrip['country'] = (string) $trip[0]->country;
            $arrayTrip['city'] = (string) $trip[0]->city;
            $arrayTrip['dateofservice'] = (string) $trip[0]->dateofservice;
            $v = Validator::make($arrayTrip, [
                'country'      => 'required|string',
                'city'       => 'required|string',
                'email'          => 'required|string|email|exists:customers,email',
                'dateofservice'          => 'required|date',
                
            ]);
        if ($v->fails()) {
        $errors [] = ['trip' =>$arrayTrip ,'errors' =>$v->errors()];
        
        } else {
            $tripsToSave[] = $arrayTrip;
        }
        
    } 
    try {
        Trip::insert($tripsToSave);
        return  response()->json(['Result' => 'success', 'saved records' => count($tripsToSave), 'errors' =>  $errors  ]);
    }catch (QueryException $e) {
        return  response()->json(['Result' => 'fail', 'error' => $e->getMessage()]);
    }
       
     
    }
}
