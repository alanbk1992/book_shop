<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CustomersModel extends Model
{

 
    
    	 /**
     * Check if user exist
     */
    public function checkCustomerRegister($phone)
    {
        $query = DB::select("SELECT * FROM customers WHERE phone = '" . $phone . "' ");

       if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }											 
		

    public function createCustomer($gender,$fullname,$password,$phone,$identity_type,$identity_id,$address,$created_by)
 {

    $date = Carbon::now();
    $date->tz('Asia/Bangkok');
    $dateInGMT7 = $date->format('Y-m-d H:i:s');


$passwordHash = Hash::make($password);
//echo $passwordHash;die;
    
 $insert = DB::insert("INSERT INTO customers 
(gender,
fullname,
password,
phone,
identity_type, 
identity_id, 
address,
status_id,
created_by,
created_at
) 
VALUES 
('" . $gender . "', 
'" . $fullname . "', 
'" . $passwordHash . "', 
'" . $phone . "', 
'" . $identity_type . "', 
'" . $identity_id . "', 
'" . $address . "',
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


public function getPasswordGenerator($length = 12) {
    // {

  
            // Define the characters that can be used in the password
            $characters = 'abcdefghijkmnpqrstuvwxyz123456789';
        
            // Get the total number of characters available
            $charLength = strlen($characters);
        
            // Initialize the password variable
            $password = '';
        
            // Generate the password
            for ($i = 0; $i < $length; $i++) {
                // Use a random number to pick a character from the list
                $randomIndex = mt_rand(0, $charLength - 1);
        
                // Append the selected character to the password
                $password .= $characters[$randomIndex];
            }
        
            return $password;
      
        
        // Usage example:
        // $generatedPassword = generatePassword(12);
        // echo $generatedPassword;
     
    
    }

    

    public function getCustomerByPhoneName($phone,$fullname)
    {

    

     $query_get = DB::select("SELECT
     *
     from
     customers
     where phone = '" . $phone . "' and fullname = '" . $fullname . "'
     ");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }

    public function getCustomerByID($customer_id)
    {

    

     $query_get = DB::select("SELECT
     *
     from
     customers
     where customer_id = '" . $customer_id . "'
     ");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }

    public function getCustomers()
    {

    

     $query_get = DB::select("SELECT
     a.customer_id,
     a.fullname,
     a.gender,
     a.phone,
     a.email,
     a.address,
     a.latitude,
     a.longitude,
     a.remarks,
     a.created_at,
     a.no_identity,
     a.type_identity,
     b.name AS rt,
     c.name AS rw,
     d.name AS village,
     e.name AS subdistrict,
     f.name AS city,
     g.name AS zipcode,
     h.username AS created_by,
     i.name AS status_id
     FROM customers a
     INNER JOIN rt b
     ON a.rt_id = b.rt_id
     INNER JOIN rw c
     ON a.rw_id = c.rw_id
     INNER JOIN village d
     ON a.village_id = d.village_id
     INNER JOIN subdistrict e
     ON a.subdistrict_id = e.subdistrict_id
     INNER JOIN city f
     ON a.city_id = f.city_id
     INNER JOIN zipcode g
     ON a.zipcode_id = g.zipcode_id
     INNER JOIN users h
     ON a.created_by = h.id
     INNER JOIN status_name i
     ON a.status_id = i.status_id
     order by a.customer_id desc
     
     limit 10
     ");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
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