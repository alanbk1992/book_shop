<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class HomeModel extends Model
{

 
    	 /**
     * Check if user exist
     */
    public function getCustomerByPhone($phone)
    {
        $query = DB::select("SELECT * FROM customers WHERE phone = '" . $phone . "' AND status_id=1");

       if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }	

    public function cekCustomer($id,$token)
    {

     $query_get = DB::select("SELECT
    *
    from users
    WHERE id = '" . $id . "' AND token = '" . $token . "'
     ");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }

    public function getTotalBillUnpaid()
    {

     $query_get = DB::select("SELECT 
     SUM(price) + SUM(fee_device) + SUM(ppn) AS total_bill_unpaid
     FROM
     invoices
     WHERE 
     status_id != 11
     ");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }

    public function checkCustomerLogin($phone, $password)
    {
    
       

     $check = DB::select("SELECT * FROM customers WHERE phone = '" . $phone . "' AND status_id=1");
   
   //echo json_encode($check);die();
    
      if (!empty($check)) {

        
          //  $row = $check->fetch_assoc();
            //$salt = $row['PasswordSalt'];
			$salt = '38ebeaedce';
           $encrypted_password = $this->checkhashSSHA($salt, $password);

            $check_pass = DB::select("SELECT * FROM customers WHERE phone = '" . $phone . "' AND password='" . $password . "' AND status_id=1");
      
         // echo json_encode($check_pass);die();
            if (!empty($check_pass)) {
                //Generate new token
                $new_token = $this->generateToken();
                $upd = DB::select("UPDATE customers SET is_login=1, token='" . $new_token . "' WHERE phone='" . $phone . "' AND status_id=1 ");
               // if ($upd) {
                    return true;
               // } else {
                  //  return false;
              //  }
            } else {
                return false;
            }

        } else {
            return false;
        }
    }


     /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password)
    {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }


    function generateToken($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }	



public function addCustomers( $fullname , $gender , $phone ,  $address ,  $remarks , $rt , $rw , $village , $subdistrict , $city , $zipcode,$created_by)
 {
    $date = Carbon::now();
    $date->tz('Asia/Bangkok');
    $dateInGMT7 = $date->format('Y-m-d H:i:s');

 $insert = DB::insert("INSERT INTO customers 
(fullname,
gender,
phone,
address, 
remarks, 
rt_id, 
rw_id, 
village_id,
subdistrict_id,
city_id,
zipcode_id,
status_id,
created_by,
created_at
) 
VALUES 
('" . $fullname . "', 
'" . $gender . "', 
'" . $phone . "', 
'" . $address . "', 
'" . $remarks . "', 
'" . $rt . "',
'" . $rw . "',
'" . $village . "',
'" . $subdistrict . "',
'" . $city . "',
'" . $zipcode . "',
'1',
'" . $created_by . "',
'" . $dateInGMT7. "'
 ) ");

if ($insert)
{

return true;
}
else
{
return false;
}
	
	
	
}

}


?>