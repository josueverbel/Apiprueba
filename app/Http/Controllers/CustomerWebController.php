<?php

namespace App\Http\Controllers;
use Validator;
use App\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class CustomerWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $customers =  Customer::paginate(2);
        
        return view('customer', compact ('customers'));
        //return $customer->paginate(1);
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
          
            return view('CustomerDetail',  compact ('customer'));
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
    public function destroy($id)
    {
      //en la migracion de la tabla trip definimos el metodo de eliminacion en cascada
      //en caso de no hacerlo asi, se consultaria el cliente con su detalle y se procederia a eliminar antes el detalle
        $customer = Customer::find($id);
        $photo = public_path().$customer->photo;
        if (@getimagesize($photo)) {
        unlink($photo);
        }
        $customer->delete();
        Session::flash('message', 'El cliente ' . $customer->firstname .' ha sido eliminado');
         return redirect()->route('customers.index');
    }
}
