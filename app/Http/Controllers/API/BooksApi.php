<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BooksModel;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;



$rows = array();
$token_header = "";
$version_code_header = ""; 
$version_name_header = ""; 
$version_name_header = ""; 
$userid_header = "";
$modeHeader = 1;

class BooksApi extends Controller
{


    public function index()
    {

       
        return view('API/BooksApi');

    }


    public function get () 
    {
 
        $db = new BooksModel;
        $db_users = new UsersModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);

            
        if (isset($post['token']) && isset($post['user_id'])) {

            $authUser = $db_users->authUsers($user_id,$token);

            if ($authCustomer != false) {
                
                $getData = $db->getBooks();
                if ($getData != 1) {

            

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
                        "message" => "Belum ada data"
                    );
                }

            }else{


                $return = array(
                  "status" => 200,
                  "total_rows" => 0,
                  "message" => "Token Invalid"
              );
              }
            
            }else{
            
            
                $return = array(
                  "status" => 200,
                  "total_rows" => 0,
                  "message" => "Error"
              );
              }   
       
        echo json_encode($return);
    }


}
