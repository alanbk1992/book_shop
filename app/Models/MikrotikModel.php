<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class MikrotikModel extends Model
{

 
    
    public function getPppoeNonActive () {

        $host = '10.20.30.1'; // Replace with your MikroTik's IP address
        $username = 'kimora'; // Replace with your username
        $password = 'Kimora112013!'; // Replace with your password
        
        // Fetch the list of PPPoE server interfaces
        $interfaceUrl = "http://$host/rest/ppp/secret";
        $ch = curl_init($interfaceUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $interfaceResponse = curl_exec($ch);
        
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
            $jsonString1 = mb_convert_encoding($interfaceResponse, 'UTF-8', 'UTF-8');
            $interfaces = json_decode($jsonString1, true);
       
            // Extract the PPPoE server interface names into an array
            $pppoeAll = [];
            foreach ($interfaces as $interface) {
                $pppoeAll[] = $interface['name'];
            }
            
            // Fetch the list of currently active PPPoE connections
            $activeUrl = "http://$host/rest/ppp/active";
            $ch = curl_init($activeUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            $activeResponse = curl_exec($ch);
         
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
                $jsonString = mb_convert_encoding($activeResponse, 'UTF-8', 'UTF-8');
                $activeConnections = json_decode($jsonString, true);

                
                // Find non-active (disconnected) connections
                $pppoeActive = [];
                foreach ($activeConnections as $interface2) {
                    $pppoeActive[] = $interface2['name'];
                }

                
                $hasil = array_diff($pppoeAll, $pppoeActive);

               $converte_array_to_string = implode(', ',   $hasil);
               $remove_koma = str_replace(",", "", $converte_array_to_string);
            
                if (empty($hasil)) {
                    return 1;
                } else {
                    $convert_to_array = explode(" ", $remove_koma);
                    return  $convert_to_array;
             
                }

               
            } else {
                return 1;
            }
        } else {
            return 1;
        }
        
        curl_close($ch);

    }

    public function getPppoeActive () {

        $username = 'kimora';
        $password = 'Kimora112013!';
        $api_url = 'http://10.20.30.1/rest/ppp/active';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // Mengatur header untuk Basic Authentication
        $headers = [
            'Authorization: Basic ' . base64_encode("$username:$password")
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Eksekusi CURL dan simpan responsnya dalam variabel $response
        $response = curl_exec($ch);
        
        // Periksa apakah pengambilan data berhasil
        if (curl_errno($ch)) {

            return 1;

        }else{

        return $response;
        
      
        }
        

       curl_close($ch);

    }


    public function createdUserHotspot ($name , $pwd , $service_profile_name , $comment , $quota,$time)  {


        $username = 'kimora';
        $password = 'Kimora112013!';
        $api_url = 'http://10.20.30.1/rest/ip/hotspot/user/add';
        // $api_url = 'http://mikrotik.kimora.net/rest/ip/hotspot/user/add';
        $bytes = $quota * pow(1024, 3);
        $data = [
            'name' => $name,
            'password' => $pwd,
            'profile' => $service_profile_name,  // Removed extra space here
            'comment' => $comment,
            'limit-bytes-total' => $bytes,
            'limit-uptime' => $time,
        ];
        
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("$username:$password"),
        ]);
        
        $response = curl_exec($ch);
        // echo $response;die;
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            return $response;
        }
        
        curl_close($ch);



    }
    
    public function createdUserPPPOE ($name , $pwd , $service_profile_name , $comment)  {


        $username = 'kimora';
        $password = 'Kimora112013!';
        // $api_url = 'http://mikrotik.kimora.net/rest/ppp/secret/add';
        $api_url = 'http://10.20.30.1/rest/ppp/secret/add';
       
        $data = [
            'name' => $name,
            'password' => $pwd,
            'service' => 'pppoe',
            'profile' => $service_profile_name,  // Removed extra space here
            'comment' => $comment,
        
        ];
        
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("$username:$password"),
        ]);
        
        $response = curl_exec($ch);
        // echo $response;die;
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            return $response;
        }
        
        curl_close($ch);



    }
    public function editPppoe ($id , $profile , $comment)  {

        $username = 'kimora';
        $password = 'Kimora112013!';
        $api_url = 'http://10.20.30.1/rest/ppp/secret';


// Data to be sent in the PATCH request (in JSON format)
$data = json_encode([
    'profile' => $profile,
    'comment' => $comment,
]);

// Initialize cURL session
$ch = curl_init($api_url . $id);
// Set the HTTP request method to PATCH
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');

// Set the request headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode("$username:$password")
    // Add any other headers you may need, such as authentication headers
]);

// Set the request data
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Return the response instead of printing it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and get the response
$response = curl_exec($ch);

echo $response;die;
// Check for cURL errors
// if (curl_errno($ch)) {
//     echo 'cURL error: ' . curl_error($ch);
// }
 // Periksa apakah pengambilan data berhasil
 if (curl_errno($ch)) {

    return 1;

}else{

    return 0;


}


// Close the cURL session
curl_close($ch);

// Output the response from the server
// echo $response;


    }

    public function getPppoe ($id) {

        $username = 'kimora';
        $password = 'Kimora112013!';
        $api_url = 'http://10.20.30.1/rest/ppp/secret';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url . $id );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // Mengatur header untuk Basic Authentication
        $headers = [
            'Authorization: Basic ' . base64_encode("$username:$password")
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Eksekusi CURL dan simpan responsnya dalam variabel $response
        $response = curl_exec($ch);
        
        // Periksa apakah pengambilan data berhasil
        if (curl_errno($ch)) {

            return 1;

        }else{

        return $response;
        
      
        }
        

       curl_close($ch);

    }
    public function updateServiceMembers($id , $remote_address , $local_address  , $profile)
    {

        $date = Carbon::now();
        $date->tz('Asia/Bangkok');
        $dateInGMT7 = $date->format('Y-m-d H:i:s');

     $update = DB::select("UPDATE
     service_members
     SET 
     remote_address ='" . $remote_address . "' ,
     local_address = '" . $local_address . "',
     profile = '" . $profile . "',
     updated_at = '" . $dateInGMT7 . "'
     where ret = '" . $id . "'

     ");

     if ($update) {
        return true;
     } else {
    
        return false;
     }
    }
    public function updateServiceMembersByid($service_member_id)
    {
       // echo $service_member_id;die;
        $date = Carbon::now();
        $date->tz('Asia/Bangkok');
        $dateInGMT7 = $date->format('Y-m-d H:i:s');

     $update = DB::select("UPDATE
     service_members
     SET 
     network_status ='2' ,
     updated_at = '" . $dateInGMT7 . "'
     where service_member_id = '" . $service_member_id . "'

     ");

     if ($update) {
        return true;
     } else {
    
        return false;
     }
    }

    

    public function getServiceMembers($id)
    {
       

     $query_get = DB::select("SELECT
    *
    from service_members
    where
    ret = '" . $id . "';
     
     ");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }




}


?>