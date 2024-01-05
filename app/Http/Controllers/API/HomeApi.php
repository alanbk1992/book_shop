<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeModel;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


$rows = array();
$token_header = "";
$version_code_header = ""; 
$version_name_header = ""; 
$version_name_header = ""; 
$userid_header = "";
$modeHeader = 1;

class HomeApi extends Controller
{

//  /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }

//     /**
//      * Show the application dashboard.
//      *
//      * @return \Illuminate\Contracts\Support\Renderable
//      */
    public function index()
    {

       
        return view('API/HomeApi');

    }



    public function get_home () 
    {

 
        $db = new HomeModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);
        $customers = array();

        if (isset($post['id']) || isset($post['token']) ) {

       $id = $post['id'];
       $token = $post['token'];

       $getData = $db->cekCustomer($id,$token);

      if ($getData != 1) {

        $getTotalBillUnpaid = $db->getTotalBillUnpaid();

        if ($getTotalBillUnpaid != 1) {


     foreach($getTotalBillUnpaid as $billUnpaid)
        {
        
 
                 $total_bill_unpaid =  number_format($billUnpaid->total_bill_unpaid, 0, '.');

        }
        $total_bill_unpaid = $total_bill_unpaid;

        }else{


            $total_bill_unpaid = 0;
        }

    
        $return = array(
            "status" => 200,
            "message" => "Success",
            "total_bill_unpaid" => $total_bill_unpaid
         
             );
        
  } else {
                         
    $return = array(
     "status" => 404,
     "message" => "Error"
   );
                                
  }

        }else {

            $return = array(
                               "status" => 404,
                               "message" => "Ada yang salah"
                           );
        }

        
       
        echo json_encode($return);
    }



}
