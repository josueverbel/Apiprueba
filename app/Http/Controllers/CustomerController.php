<?php

namespace App\Http\Controllers;
use Validator;
use App\Customer\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($key1 = null , $value1 = null, $key2 = null, $value2 = null, $key3 = null, $value3 = null)
    {
        $validkeys = ["phone", "email", "firstname", "lastname"];
        $filters = [
            ['key' => $key1,'value' => $value1],
            ['key' => $key2,'value' => $value2],
            ['key' => $key3,'value' => $value3],
        ];
        $customer = new Customer();
        $customer->query();
        foreach ($filters as &$filter) {
            $key = $filter["key"];
            $value = $filter["value"];
            if($key)
            {
                if (in_array($key, $validkeys)) { 
                    $customer = $customer->where($key, $value);
                }else{
                    return  response()->json('no se reconoce el filtro '.$key, 400);
                   
                }
            }
         }
        
       
        return $customer->paginate(5);
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
       
        $so = $request->header('x-requested-with');
       
        $v = Validator::make($request->all(), [
            'firstname'         => 'required|string',
            'lastname'          => 'required|string',
            'email'             => 'required|string|email|unique:customers',
            'phone'             => 'required|string',
            'address'           => 'required|string',
            'file'             => 'required',
            
        ]);
        if ($v->fails()) return response()->json($v->errors(), 400);
        $file;
        $ext="jpg";
        if($request->file('file'))
        {
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $file = \File::get($file);
        }else{
            if ($so == 'io.ionic.starter'){
                try {
                    $image = $request->file;  // your base64 encoded
                    $image = str_replace('data:image/jpeg;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $file =  base64_decode($image);
                }catch (\Exception $e) {
                    return  response()->json('Error when decode :' .$e->getMessage());
                
                }
                
            }else{
                return response()->json('El formato de archivo no es legible', 400);
            }
        }
      
       
        $customer = new  Customer($request->all());
        try {
         \Storage::disk('local')->put($customer->phone.'.'.$ext,  $file);
         $public_path = public_path();
        $url ='storage/'.$customer->phone.'.'.$ext;
        $customer->photo = $url;
        $customer->save();
        return $customer;
        }catch (\Exception $e) {
            return  response()->json('Error when saving:' .$e->getMessage());
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $customer = Customer::with('trips')->find($id);
            $path = $customer->photo;
           
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $customer->image =  $base64;
            return $customer;
        }catch (\Exception $e) {
            return  response()->json('Error when returning record:' .$e->getMessage());
           
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
