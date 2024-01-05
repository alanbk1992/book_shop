<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config\config_type;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;


$rows = array();
$rows2 = array();

$current_app_version_code = "1"; //App Version Code
$current_app_version_name = "0.1.0"; //App Version Name

$token_header = ""; //Header Token
$version_code_header = ""; //Header Version Code
$version_name_header = ""; //Header Version Name
$version_name_header = ""; //Header Version Name
$userid_header = "";
$modeHeader = 1;


class AuthApi extends Controller
{
    //
    



    public function index()
    {

       
        return view('API/AuthApi');

    }


    public function login () 
    {
 
        $db = new UsersModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);



        if (isset($post['email']) && isset($post['password']) ) {
            
            
            
        $email = $post['email'];
        $password = $post['password'];
        $firebase_id = $post['firebase_id'];
        $firebase_time = $post['firebase_time'];
        $device_brand = $post['device_brand'];
        $device_model = $post['device_model'];
      
        

            $user = $db->checkUserLogin($email, $password,$firebase_id,$device_brand,$device_model,$firebase_time);

           // echo json_encode($user);die;
            if ($user == true) {

                $getData = $db->getUserByEmail($email);

                if ($getData != null) {

             
                      foreach ($getData as $row) { 
                        $rows[] = $row;
             
                    }


                    $return = array(
                        "status" => 200,
                        "message" => "ok",
                        "data" => $rows
                    );
                } else {
                    $return = array(
                        "status" => 404,
                        "message" => "Pelanggan tidak ditemukan"
                    );
                }

            } else {
        
                    $return = array(
                        "status" => 404,
                        "message" => "No Telpon atau password salah"
                    );
              
            }
        } else {
            $return = array(
                "status" => 404,
                "message" => "Ada kesalahan!"
            );
        }
        echo json_encode($return);
    }


    public function logout () 
    {
 
 
        $db = new UsersModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);


                    if (isset($post['id'])) {

                        $id = $post['id'];

        
                        $process = $db->processLogout($id);
                        if ($process == true) {
                            $return = array(
                                "status" => 200,
                                "message" => "ok"
                            );
                        } else {
                            $return = array(
                                "status" => 404,
                                "message" => "Gagal keluar dari akun, mohon coba beberapa saat lagi!"
                            );
                        }
                    } else {
                        $return = array(
                            "status" => 404,
                            "message" => "Method not found!"
                        );
                    }
                    echo json_encode($return);
                }


  

    

     public function get_completion_summary () 
    {
 
        $db = new Accounts_Model;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);

        if (isset($post['id']) || isset($post['guid']) || isset($post['_upline']) ) {

            $id = $post['id'];
            $guid = $post['guid'];
            $_upline = $post['_upline'];

            $technicians = [];

            $getDataTechnician = $db->getTechnicians($_upline);
           
             if ($getDataTechnician != null) {
       
                     
           foreach($getDataTechnician as $technician)
             {
       
                   $rows [] = $technician;
                   $id = $technician->id;
                 
                  
                   $getCompletionSummary= $db->getCompletionSummary($id);
                   $getServiceLevelSummary= $db->getServiceLevelSummary($id);

                    $technicians[$technician->id]['id'] = $technician->id;
                    $technicians[$technician->id]['_upline'] = $technician->_upline;
                    $technicians[$technician->id]['fullname'] = $technician->fullname;
                    $technicians[$technician->id]['completion_summary'] = $getCompletionSummary;
                    $technicians[$technician->id]['service_level_summary'] = $getServiceLevelSummary;
       
              }
       
       
                    $results = array_values($technicians);
       
            
                    
                           $return = array(
                               "status" => 200,
                               "message" => "success",
                               "data" => $results
                           );
                       } else {
                           $return = array(
                               "status" => 404,
                               "message" => "Data tidak ditemukan, mohon coba beberapa saat lagi!"
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

    public function get_technicians () 
    {
 
        $db = new Accounts_Model;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);

        if (isset($post['id']) || isset($post['guid']) || isset($post['_upline']) ) {

            $id = $post['id'];
            $guid = $post['guid'];
            $_upline = $post['_upline'];

            $dataTechnicians = [];

            $getTechnician= $db->GetTechnicians($_upline);
           
             if ($getTechnician != null) {
       
                     
           foreach($getTechnician as $dataTechnician)
             {
       
                $id = $dataTechnician->id;
                
                $getCompletionSummary= $db->GetCompletionSummary($id);

                 $dataTechnicians[$dataTechnician->id]['id'] = $dataTechnician->id;
                 $dataTechnicians[$dataTechnician->id]['_upline'] = $dataTechnician->_upline;
                 $dataTechnicians[$dataTechnician->id]['fullname'] =  $dataTechnician->fullname;
                 $dataTechnicians[$dataTechnicians->id]['completion_summary'] = $getCompletionSummary;
           
              }

            
              
              $results = array_values($dataTechnicians);

            
             
                    
                           $return = array(
                               "status" => 200,
                               "message" => "success",
                               "total_rows" => COUNT($results),
                               "data" => $results
                           );
                       } else {
                           $return = array(
                               "status" => 404,
                               "message" => "Data tidak ditemukan, mohon coba beberapa saat lagi!"
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

    public function get_last_update_task () 
    {
 
        $db = new Accounts_Model;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);

        if (isset($post['id']) || isset($post['guid']) || isset($post['_upline']) ) {

            $id = $post['id'];
            $guid = $post['guid'];
            $_upline = $post['_upline'];


            $getData = $db->GetLasUpdateTask($_upline);
           
             if ($getData != null) {
       
                     
           foreach($getData as $data)
             {
       
                   $rows [] = $data;
                 
       
              }
       
       
        
            
                    
                           $return = array(
                               "status" => 200,
                               "message" => "success",
                               "data" => $rows
                           );
                       } else {
                           $return = array(
                               "status" => 404,
                               "message" => "Data tidak ditemukan, mohon coba beberapa saat lagi!"
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
