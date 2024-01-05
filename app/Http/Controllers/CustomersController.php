<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\CustomersModel;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use Carbon\Carbon;
class CustomersController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
	public function index()
	{
       

        $db = new CustomersModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);
        $customers = array();
        $getData = $db->getCustomers();

        // var_dump ($getData);die;
        if ($getData != 1) {

              
            foreach($getData as $customer)
            {
    
    

           $created_at = Carbon::parse($customer->created_at)->format('d-m-Y');
           
           
             $customers []= array(
                        "customer_id" => $customer->customer_id,
                         "fullname" => $customer->fullname,
                        "gender" => $customer->gender,
                        "phone" => $customer->phone,
                        "address" => $customer->address,
                        "rt" => $customer->rt,
                        "rw" => $customer->rw,
                        "village" => $customer->village,
                        "subdistrict" => $customer->subdistrict,
                        "city" => $customer->city,
                        "zipcode" => $customer->zipcode,
                        "email" => $customer->email,
                        "no_identity" => $customer->no_identity,
                        "type_identity" => $customer->type_identity,
                        "latitude" => $customer->latitude,
                        "longitude" => $customer->longitude,
                        "remarks" => $customer->remarks,
                        "created_at" => $created_at,
                        "created_by" => $customer->created_by,
                        "status_id" =>  $customer->status_id
                         );
    
            }

           $data = [
            
            'totalcustomer' => count($customers),
            'customer' => $customers,
        
        ];   
        // var_dump ($data);die;
           return view('pages.customers', $data);
    
            } else {

              return view('pages.customers');
                
             }

		
	}
	


}

 error_reporting(0);
