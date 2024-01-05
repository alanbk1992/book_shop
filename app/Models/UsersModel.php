<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersModel extends Model
{

    public function authUsers($id,$token)
    {

     $query_get = DB::select("SELECT
    *
    from users
    WHERE id = '" . $id . "' AND token = '" . $token . "'
     ");

     if (!empty($query_get)) {
    return true;
     } else {
    
      return false;
     }
    }
    public function getRoleUsers()
    {


     $query_get = DB::select("select 
     user_role_id,
     name,
     code
     from user_role
     limit 20");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }


    public function getUsers()
    {


     $query_get = DB::select('select 
     id,
     name,
     phone,
     email,
     address
     from users
	');

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }


   
    public function checkUserLogin($email, $password,$firebase_id,$device_brand,$device_model,$firebase_time)
    {
    
       

     $check = DB::select(  "SELECT * FROM users WHERE email = '" . $email . "' AND status_id=1 ");
   
      //echo json_encode($check);die();
    
      if (!empty($check)) {



           $get_pass = DB::select("SELECT password FROM users WHERE email = '" . $email . "' and status_id=1");
          
           foreach ($get_pass as $row) { 
            $password_hash = $row->password;
 
        }
         
           if (Hash::check($password, $password_hash)) {
       
            $new_token = $this->generateToken();
            $upd = DB::select("UPDATE users SET is_login=1, firebase_time = '" . $firebase_time . "', firebase_id='" . $firebase_id . "',device_brand='" . $device_brand . "',device_model='" . $device_model . "',token='" . $new_token . "' WHERE email='" . $email . "' AND status_id=1 ");
      
           return true;
           

        } else {
            return false;
        }



        } else {
            return false;
        }
    }


        /**
     * Process Logout
     */
    public function processLogout($id)
    {

        $upd = DB::select("UPDATE users SET 
        is_login = '0',
        firebase_id = '',
        token 	= ''
    WHERE 
        id= '" . $id . "'");
        

//  echo Json_encode($upd);die;

        if ($upd == [])
        {
            return true;
        }
        else
        {
            return false;
        }
    }

     /**
     * Get user data by email
     */
    public function getUserByEmail($email)
    {

        $check = $this->checkUserRegister($email);

        if (!empty($check)) {
            // $query_get = $this->conn->query("SELECT *, '' AS Password FROM master_users WHERE Phone = '".$phone."' AND Active=1 ");

            // edit by elim
            $query_get = DB::select("SELECT 
                                              *
                                          FROM 
                                                    users a	
                                   
                                         
                                          WHERE 
                                          email = '" . $email . "' 
                                          AND status_id=1");
            return $query_get;
        } else {
            return null;
        }
    }

      /**
     * Get user data by email
     */
    public function getUser($user_id)
    {

      
            $query_get = DB::select("SELECT
            user_id,
            role_id,
            first_name,
            last_name,
            username,
            email,
            phone,
            active
            FROM 
            users
            WHERE user_id = '" . $user_id . "'");
            return $query_get;
       
    }

     /**
     * Get user data by email
     */
    public function getFarm($user_id)
    {

      
            $query_get = DB::select("SELECT
            a.farm_id,
            a.farm_name,
            a.address,
            a.phone,
            a.membership_id,
            b.follower,
            a.active
            FROM
            farm a
            LEFT JOIN farm_detail b ON b.farm_id = a.farm_id
            WHERE b.user_id = '" . $user_id . "' and b.is_default=1");
            return $query_get;
       
    }
    public function getShop($user_id)
    {

      
            $query_get = DB::select("SELECT
            a.shop_id,
            a.shop_name,
            a.address,
            a.phone,
            a.membership_id,
            a.active
            FROM
            shop a
            LEFT JOIN shop_detail b ON b.shop_id = a.shop_id
            WHERE b.user_id = '" . $user_id . "'");
            return $query_get;
       
    }


    /**
     * Check profile is complete
     */
    public function checkIsProfileComplete($email)
    {
        $check_pass = DB::select("SELECT
        a.shop_id,
        a.shop_name,
        a.address,
        a.phone,
        a.membership_id,
        a.active
        FROM
        shop a
        LEFT JOIN shop_detail b ON b.shop_id = a.shop_id
        WHERE b.user_id = '" . $email . "'");

        if (!empty($check_pass)) {
            //profile not complete
            return 0;
        } else {
            //profile complete
            return 1;
        }
    }

     /**
     * Check login by new generated pass (forgot pass)
     */
    public function checkUserLoginByForgot($email, $password)
    {

        $now = $this->get_chat_time();

        $check_pass =DB::select("SELECT * FROM users WHERE email = '" . $email . "' AND forgot_password='" . $password . "' AND forgot_password_expired > STR_TO_DATE('" . $now . "', '%Y-%m-%d %H:%i:%s') AND status_id=1 ");

        if (!empty($check_pass)) {
            $new_token = $this->generateToken();
            $upd = DB::select("UPDATE users SET is_login=1, token='" . $new_token . "' WHERE email='" . $email . "' AND status_id=1 ");
            if ($upd) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Update FirebaseID
     */
    public function updateFirebase($email, $firebase_id)
    {

        $update = DB::select("UPDATE master_users SET 
										FirebaseID 		= '" . $firebase_id . "'
									WHERE 
										Email = '" . $email . "'");

        if ($update) {
            return true;
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

   
	 /**
     * Function Generate API Token
     * @param : Num Digits (optional)
     * returns code
     */
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

																		 
	 /**
     * Check if user exist
     */
    public function checkUserRegister($email)
    {
        $query = DB::select("SELECT * FROM users WHERE email = '" . $email . "' AND status_id=1 ");

       if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }											 
		
			
			

    function get_chat_time()
    {
        // $myDateTime = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('GMT'));
        // $myDateTime->setTimezone(new DateTimeZone('Asia/Jakarta'));
        // $now = $myDateTime->format('Y-m-d H:i:s');

        $now = date("Y-m-d H:i:s");
        return $now;
    }
	
    public function hashSSHA($password)
    {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array(
            "salt" => $salt,
            "encrypted" => $encrypted
        );
        return $hash;
    }

    function generatePIN($digits = 6)
    {
        $i = 0;
        $pin = "";
        while ($i < $digits)
        {
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }

	
     /**
     * Create New User
     */
    public function createUser($firstname, $lastname, $username  , $email, $password, $phone ,$reff)
    {

        //Generate Encrypt Password
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"];
        $salt_password = $hash["salt"];
        $code = $this->generatePIN();

        //Generate Token
        $token = $this->generateToken();

        $ref = "";
        if ($reff != "")
        {
            $ref = $reff;
        }

   
        $insert = DB::insert("INSERT INTO users 
									(FirstName, 
									LastName, 
                                    Username, 
									Email,
									Password,
									PasswordSalt,
									Token,	
									ActivationCode,
                                    Phone,
									ReferralBy,
									active
									) 
								VALUES 
									('" . $firstname . "', 
									'" . $lastname . "',
                                    '" . $username . "',
									'" . $email . "',
									'" . $encrypted_password . "',
									'" . $salt_password . "',
									'" . $token . "',
									'" . $code . "',
                                    '" . $phone . "',
									'" . $ref . "',
									'1'
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