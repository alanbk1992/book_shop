<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomersModel;
use App\Models\ServicesModel;
use App\Models\MessageModel;
use App\Models\UtilsModel;
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

class CustomersApi extends Controller
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

       
        return view('API/CustomersApi');

    }


    public function register_customer (Request $request) 
    {
 
        $db = new CustomersModel;
        $db_services = new ServicesModel;
		$db_message = new MessageModel;
		$db_utils= new UtilsModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);
        $customers = array();

        //echo json_encode($post['password']);die;
        if (isset($post['gender']) && isset($post['fullname']) && isset($post['phone']) && isset($post['identity_type'])&& isset($post['identity_id'])&& isset($post['address'])&& isset($post['created_by']) ) {
            
			$gender = $post['gender'];
			
            if($gender == "Bapak") {

                $gender = "Laki - Laki";

            }else {

                 $gender = "Perempuan";
            }

        
            $fullname = $post['fullname'];
            $phone = $post['phone'];
            $identity_type = $post['identity_type'];
            $identity_id = $post['identity_id'];
            $address = $post['address'];
            $created_by = $post['created_by'];
			
            $password = $db->getPasswordGenerator();
            $checkCustomerRegister = $db->checkCustomerRegister($phone);
				//echo json_encode($getData);die;
                if ($checkCustomerRegister == false) {

                    $createCustomer = $db->createCustomer($gender,$fullname,$password,$phone,$identity_type,$identity_id,$address,$created_by);
                //   echo json_encode($create);die;
                    if ($createCustomer == true) {

						$getCustomerByPhoneName = $db->getCustomerByPhoneName($phone,$fullname);

						if ($getCustomerByPhoneName) {
	 
							foreach($getCustomerByPhoneName as $customer)
                                {
                                    $customer_id = $customer -> customer_id;

                                    $customers []= array(

                                    "customer_id" => $customer->customer_id,
                                    "fullname" => $customer->fullname,
                                    "phone" => $customer->phone,
                                    "password" => $password
                                    );

                                }
								
							$sendMessageRegister = $db_message->sendMessageRegister($fullname,$phone, $password );	
							
                        if (isset($post['installation_date']) && isset($post['service_item_id'])) {
      
                            $installation_date = $post['installation_date'];
                            $service_item_id = $post['service_item_id'];

  
                           $getDataService = $db_services->getServiceItemsByID($service_item_id);

                            

                                if ($getDataService != 1) {

                                    foreach($getDataService as $service_items)
                                    {
										
									$price = $service_items->price;
									$time= $service_items->time;
									$type = $service_items->type;
									$speed = $service_items->speed;
									$fee_device = $service_items->fee_device;
									$fee_activation = $service_items->fee_activation;
									$fee_installation = $service_items->fee_installation;
									$service_item_name = $service_items->service_item_name;
				
                                    }
									
									$service_name = "Internet";
									
									$getServiceMemberId = $db_services->getServiceMemberIdNew();
									
									
									 foreach($getServiceMemberId as $serviceMemberIDNew)
										{
										$service_member_idNew = $serviceMemberIDNew->service_member_id;
										}
										
									if ($service_member_idNew == null) {
										
										$service_member_id = 1 ;
										
									}else {
										
										$service_member_id = "0" .$service_member_idNew;

									}
									
									//echo json_encode($service_member_id);die;
									
									
								$password_pppoe = $db->getPasswordGenerator();
									
                                 $createServiceMember = $db_services->createServiceMember($service_member_id , $customer_id   , $password_pppoe , $service_item_name , $price , $time , $type , $speed , $service_name , $installation_date   , $created_by);
              
								if ($createServiceMember == true) {
								
								if (isset($post['bank_id'])) {
									
								$bank_id = $post['bank_id'];
								$getPaymentAccount = $db_utils->getPaymentAccount($bank_id);
								
								//echo json_encode($getPaymentAccount);die;
								
								 if ($getPaymentAccount != false) {
									 
									 foreach($getPaymentAccount as $paymentAccount)
										{
											
										$account_name = $paymentAccount->account_name;
										$account_number = $paymentAccount->account_number;
										$bank_name = $paymentAccount->bank_name;
										
										}	 
								 }
								
										
								
								$payments_method = $bank_name;
								$status_id = 13;

                             
								}else{

								$payments_method = "";
								$status_id = 12;
								
								}
								
								$date = Carbon::now();
								$date->tz('Asia/Bangkok');
								$dateInGMT7 = $date->format('dmYHis');
								$invoice_id = "INV-" . $dateInGMT7;						
								$start_date = Carbon::parse($post['installation_date'])->format('Y-m-d');
								$end_date = Carbon::parse($post['installation_date'])->format('Y-m-28');
				
								$date_now = Carbon::parse($start_date);
								$due_date = Carbon::parse($end_date);
								$total_days = $date_now->diffInDays($due_date) + 1; // Selisih dalam hari
								$price_day = $price / 31;  //4500  
								$due_date = $installation_date;
                                $priceProrate = $total_days * $price_day;						
				                $total_bill = $priceProrate + $fee_device + $fee_activation + $fee_installation;
								$remarks ="Prorate Pembayaran Internet";
								
								$createInvoices = $db_services->createInvoices($invoice_id , $payments_method , $status_id , $remarks ,$customer_id , $service_item_name , $time , $type , $speed , $service_name , $priceProrate , $fee_device  , $fee_activation , $fee_installation , $total_bill , $service_member_id  , $due_date , $installation_date,$created_by);
									
								 if ($createInvoices == true) {
									 //echo $phone;die;
									$dueDate = Carbon::parse($due_date)->format('d-m-Y');
									$totalBill = number_format($total_bill, 0, '.');
                                    $status = "MENUNGGU PEMBAYARAN";
									$sendMessageInvoice = $db_message->sendMessageInvoice($invoice_id,$fullname, $service_member_id , $service_item_name, $totalBill, $dueDate ,  $remarks , $status,  $phone);
									
									$return = array(
									"status" => 200,
									"message" => "Data berhasil dikirim, Tunggu konfirmasi dari admin",
									"data" => []
									//"data" => json_encode($sendMessageInvoice)
									);
         
								echo json_encode($return);die;
								
								} else {
                         
								$return = array(
								"status" => 404,
								"message" => "Gagal membuat invoice"
								);
								echo json_encode($return);die;
								}
					 
									$return = array(
                                        "status" => 200,
                                        "message" => "Pembelian paket berhasil",                       
                                        "data" => $customers
                                    );
                                    echo json_encode($return);die;
									
								}else{
									
									$return = array(
                                        "status" => 200,
                                        "message" => "Pendaftaran service member gagal",
                                        "data" => $customers
                                    );
                                    echo json_encode($return);die;
									
								}
				  
                                    
                                }else{


                                    $return = array(
                                        "status" => 200,
                                        "message" => "Paket yang anda pilih tidak tersedia"
                                    );

                                    echo json_encode($return);die;

                                }

     
          
                              }
							  
							
							$return = array(
                            "status" => 200,
                            "message" => "Pendaftaran berhasil",
							"status_send" => json_encode($sendMessageRegister),
                            "data" => $customers
                        
							);
							echo json_encode($return);die;
							

							}else{


                                $return = array(
                                    "status" => 200,
                                    "message" => "Customer tidak ditemukan"
                                );
                                echo json_encode($return);die;
                            }
							
                 
                    } else {
                        $return = array(
                            "status" => 404,
                            "message" => "Registrasi gagal, mohon coba beberapa saat lagi!"
                        );
                        echo json_encode($return);die;
                    }

                } else {
                    $return = array(
                        "status" => 404,
                        "message" => "No Handpone sudah digunakan , silahkan login atau reset password"
                    );
                    echo json_encode($return);die;
                }
		
		
		
        } else {
            $return = array(
                "status" => 404,
                "message" => "Data tidak lengkap"
            );
        }
        
    }

    public function add_customers () 
    {

 
        $db = new CustomersModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);
       
        $fullname = $post['fullname'];
     
 
       if ($post['gender'] == "1") {
      
       $gender = "Laki - Laki";
            
       }else {
            
        $gender = "Perempuan";
            
        }
 
        $phone = $post['phone'];
        $address = $post['address'];
        $remarks = $post['remarks'];
        $rt = $post['rt'];
        $rw = $post['rw'];
        $village = $post['village'];
        $subdistrict = $post['subdistrict'];
        $city = $post['city'];
        $zipcode = $post['zipcode'];
        $created_by = 1;

                $insert_data = $db->addCustomers($fullname , $gender , $phone ,  $address ,  $remarks , $rt , $rw , $village , $subdistrict , $city , $zipcode  ,$created_by);
                
                if ($insert_data == true) {

                    $return = array(
                        "status" => 200,
                        "message" => "Customer successfully added",
                        "data" => []
                    );
         
 
                     } else {
                         
                        $return = array(
                            "status" => 404,
                            "message" => "Gagal"
                        );
                        
                     }



     
       
        echo json_encode($return);
    }


    public function get_customers () 
    {

 
        $db = new CustomersModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);
        $customers = array();



       $getData = $db->getCustomers();

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
                            "created_at" => $created_at,
                            "created_by" => $customer->created_by,
                            "status_id" =>  $customer->status_id
                             );

     
  }


   $return = array(
   "status" => 200,
  "message" => "Success",
   "data" => $customers
    );
        
  } else {
                         
    $return = array(
     "status" => 404,
     "message" => "No Data"
   );
                                
  }
     
 
  

        echo json_encode($return);
    }



}
