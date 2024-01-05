<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class MessageModel extends Model
{


    public function cekUser($id,$token)
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

   
    public function getWhatsapp($phone,$page, $limit)
    {


  

        $condition = '';
        if ($page != '' && $limit != '')
        {
            if ($page == 1)
            {
                $p = 0;
            }
            else
            {
                $p = ($page - 1) * $limit;
            }

            $condition .= "LIMIT " . $limit . " OFFSET " . $p . " ";
        }

        $filter = "";
     

        if ($phone != "")
        {
            $filter = "where phone =  '" . $phone . "' ";
        }


     $query_get = DB::select("SELECT
     *
     FROM
     whatsapp
    $filter
    -- GROUP BY phone
    -- ORDER BY MAX(chat_date) DESC
     " . $condition);

     if (!empty($query_get)) {

    return $query_get;

     } else {
    
      return 1;
     }
    }
	
    public function createChat($order_id, $message, $from, $to)
    {


        $date = Carbon::now();
        $date->tz('Asia/Bangkok');
        $dateInGMT7 = $date->format('Y-m-d H:i:s');


     $query_get = DB::select("INSERT INTO chat 
     (
     order_id,
     message, 
     chat_from,
     chat_to,
     chat_date
     ) 
 VALUES 
     (
    '" . $order_id . "',
     '" . $message . "',
     '" . $from . "',
     '" . $to . "',
     '" . $dateInGMT7 . "'
     ) ");

     if ($query_get==[]) {

     $this->chatNotification($order_id, $message, $to);


    return true;

     } else {
    
        return false;
     }
    }


    function sendNotification_customers($customer_id , $custom_data)
    {

          //Notify User
          $query = DB::select("SELECT
          *
          from customers
          WHERE customer_id ='" . $customer_id . "'
          ");
  
         
          foreach($query as $customer)
          {

        $firebase_id = $customer->firebase_id;

        $registrationIds = array(
            $firebase_id
        );

        $fields = array(
            'registration_ids' => $registrationIds,
            'data' => $custom_data
        );

        $headers = array(
            'Authorization: key=AAAALgL7evs:APA91bHKYfZOKdgYxhh-CHXYckYeQceHbFcDr9aaDGvBkCRDhdrk45Q0xNnKulNlnam8EuG6o9CHtCO4GIkjR0f6sT926zW2t4YmDEeLQ0t4uJiOXzk158ReuWRkRnlQkDmIYph8Rugn',

            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        //echo $result;exit;
        
        //return $result;
       
          
    }

    }

    function chatNotification($order_id, $message, $to, $url = '')
{

    $date = Carbon::now();
    $date->tz('Asia/Bangkok');
    $dateInGMT7 = $date->format('h:i');

    $custom_data = array(
        'type' => '2', //Notification Chat Nurse
        'body' => $message,
        'title' => "Pesan Baru",
        'chat_date' => $dateInGMT7 ,
        'chat_from' => '0',
        'message' => $message,
        'order_id' => $order_id,
        'url' => $url
    );

    $type = $this->str_before($to, ':');
    $send_to = $this->str_after($to, ':');

    if ($type == "usr")
    {
        //Notify User
        $query_usr = DB::select("SELECT
        *
        from customers
        WHERE customer_id = '" . $send_to . "' AND status_id = 1
        ");

       
        foreach($query_usr as $users)
        {

            $firebase = $users->firebase_id;
            $this->sendNotification($firebase, $custom_data);
        }

       
    
        
    }
    // else if ($type == "usr")
    // {
    //     //Notify User
    //     $query_nrz = $this
    //         ->conn
    //         ->query("SELECT * FROM master_users WHERE UserID='" . $send_to . "' AND Active=1 ");
    //     if (mysqli_num_rows($query_nrz) > 0)
    //     {
    //         $row_nrz = $query_nrz->fetch_assoc();

    //         $this->sendNotification_Patient($row_nrz['FirebaseID'], $custom_data);
    //     }
    // }


    
}

function sendNotification($firebase_id, $custom_data)
    {

        $registrationIds = array(
            $firebase_id
        );

        $fields = array(
            'registration_ids' => $registrationIds,
            'data' => $custom_data
        );

        $headers = array(
            'Authorization: key=AAAALgL7evs:APA91bHKYfZOKdgYxhh-CHXYckYeQceHbFcDr9aaDGvBkCRDhdrk45Q0xNnKulNlnam8EuG6o9CHtCO4GIkjR0f6sT926zW2t4YmDEeLQ0t4uJiOXzk158ReuWRkRnlQkDmIYph8Rugn',

            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        //echo $result;exit;
        
    }

    public function sendWhatsappNotification($phone, $message)
    {


     $auth = '29Nz4YZ5t5!2@Dia8XNZ';
    // $message = "*PEMBAYARAN%20BERHASIL*%0A%0AYth%20Bpk%2FIbu%20".$customer_name."%0A%0ATerimakasih%20atas%20kepercayaan%20anda%20untuk%20menjadi%20pelanggan%20Kimora%20Net.%20Internet%20Provider%20terbaik%20di%20area%20Anda.%0ABerikut%20rincian%20tagihan%20layanan%20internet%20%20anda%20%3A%0A%0AID%20Pelanggan%20%3A%20".$service_member_id."%0ANama%20Layanan%20%3A%20".$service_item_name."%0ATagihan%20Layanan%20%3A%20Rp.%20".$total_bill."%0ATanggal%20Jatuh%20Tempo%20%3A%20".$due_date."%0AKeterangan%20%3A%20".$remarks."%0AStatus%20%20%20%20%20%3A%20*TELAH%20DIBAYAR*%0A%0AApabila%20anda%20menemui%20kesulitan%20atau%20ada%20pertanyaan%2C%20silahkan%20menghubungi%20Customer%20Service%20Kimora%20Net%20di%0AWA%3A%20%2B62895367099939%20dengan%20menyebutkan%20ID%20Pelanggan%20Anda%20".$service_member_id."%0A%0AHormat%20Kami%2C%0APT%20Kimora%20Solusi%C2%A0Informatika";
 
  
    $data = array(
      'token' => $auth,
      'target' => $phone,
      'message' => $message
  );
  

  $encodedData = http_build_query(array_map('urldecode', $data));
  
  // URL tujuan
  $url = 'https://api.fonnte.com/send?' . $encodedData;


  $ch = curl_init($url);
// Atur opsi Curl
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Mengaktifkan opsi untuk mengembalikan respons

    $response = curl_exec($ch);

// Tutup sesi Curl
curl_close($ch);

// Respons dari server tersimpan di variabel $response
return $response;

    }

    public function sendMessageRegister($fullname,$phone, $password)
    {

        $date = Carbon::now();
        $date->tz('Asia/Bangkok');
        $dateInGMT7 = $date->format('Y-m-d H:i:s');
     $auth = '29Nz4YZ5t5!2@Dia8XNZ';
    $message = "*PENDAFTARAN%20BERHASIL*%0A%0AYth%20Bpk%2FIbu%20".$fullname."%0A%0ATerimakasih%20atas%20kepercayaan%20anda%20untuk%20menjadi%20pelanggan%20Kimora%20Net.%20Internet%20Provider%20terbaik%20di%20area%20Anda.%0ABerikut%20rincian%20akun%20anda%20%3A%0A%0ANo%20Handphone%20%3A%20".$phone."%0APassword%20%3A%20".$password."%0A%0ASilahkan%20download%20aplikasi%20Kimora%20net%20di%20playstore%0ALink%20download%0Ahttps%3A%2F%2Fplay.google.com%2Fstore%2Fapps%2Fdetails%3Fid%3Dproject.kimora.kimoranet%0A%0AApabila%20anda%20menemui%20kesulitan%20atau%20ada%20pertanyaan%2C%20silahkan%20menghubungi%20Customer%20Service%20Kimora%20Net%20di%0AWA%3A%20%2B62895367099939%0A%0AHormat%20Kami%2C%0APT%20Kimora%20Solusi%C2%A0Informatika%0A";
 
  
    $data = array(
      'token' => $auth,
      'target' => $phone,
      'message' => $message
  );
  

  $encodedData = http_build_query(array_map('urldecode', $data));
  

$url = 'https://api.fonnte.com/send?' . $encodedData;


$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Mengaktifkan opsi untuk mengembalikan respons

$response = curl_exec($ch);

curl_close($ch);

$jsonObject = json_decode($response);
$status = $jsonObject->status;

if ($status == 1) {

    $message_status = 8;

}else{

    $message_status = 7;

}

$insert = DB::select("INSERT INTO whatsapp 
(fullname,
phone, 
message,
message_status,
status_id,
chat_date,
created_at
) 
VALUES 
('" . $fullname . "', 
'" . $phone . "', 
'" . $message . "',
'" . $message_status . "',
'1',
'" . $dateInGMT7 . "',
'" . $dateInGMT7 . "'
) ");

return $response;

    }



public function sendMessageInvoice($invoice_id,$fullname, $service_member_id , $service_item_name, $total_price, $due_date ,  $remarks , $status,  $phone)
{

    $date = Carbon::now();
        $date->tz('Asia/Bangkok');
        $dateInGMT7 = $date->format('Y-m-d H:i:s');

$auth = '29Nz4YZ5t5!2@Dia8XNZ';
$message = "*INFORMASI*%0A%0AYth%20Bpk%2FIbu%20".$fullname."%0A%0ATerimakasih%20atas%20kepercayaan%20anda%20untuk%20menjadi%20pelanggan%20Kimora%20Net.%20Internet%20Provider%20terbaik%20di%20area%20Anda.%0ABerikut%20rincian%20tagihan%20layanan%20internet%20%20anda%20%3A%0A%0ANo%20Invoice%20%3A%20".$invoice_id."%0ANo%20Pelanggan%20%3A%20".$service_member_id."%0ANama%20Layanan%20%3A%20".$service_item_name."%0ATagihan%20Layanan%20%3A%20Rp.%20".$total_price."%0ATanggal%20Jatuh%20Tempo%20%3A%20".$due_date."%0AKeterangan%20%3A%20".$remarks."%0AStatus%20%20%20%20%20%3A%20*".$status."*%0A%0AAnda%20dapat%20melakukan%20pembayaran%20melalui%20channel%20yang%20tersedia%20berikut%20%3A%0A-%20Transfer%20Bank%2C%20%28BCA%201831061044%20an%20Alan%20Budi%20Kusumah%29%0A-%20Dana%20%28089519999390%29%0A-%20Ovo%20%28089519999390%29%0A-%20Cash%20di%20anter%20ke%20kantor%20Kimora.Net%0A%0AApabila%20anda%20menemui%20kesulitan%20atau%20ada%20pertanyaan%2C%20silahkan%20menghubungi%20Customer%20Service%20Kimora%20Net%20di%0AWA%3A%20%2B62895367099939%20dengan%20menyebutkan%20No%20Pelanggan%20Anda%20".$service_member_id."%0A%0ADownload%20Aplikasi%20Kimora%20Net%20di%20Playstore%0Ahttps%3A%2F%2Fplay.google.com%2Fstore%2Fapps%2Fdetails%3Fid%3Dproject.kimora.kimoranet%0A%0A%0AHormat%20Kami%2C%0APT%20Kimora%20Solusi%C2%A0Informatika%0A";
 
  
    $data = array(
      'token' => $auth,
      'target' => $phone,
      'message' => $message
  );
  

$encodedData = http_build_query(array_map('urldecode', $data));
  
$url = 'https://api.fonnte.com/send?' . $encodedData;

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

$response = curl_exec($ch);


curl_close($ch);

$jsonObject = json_decode($response);
$status = $jsonObject->status;

if ($status == 1) {

    $message_status = 8;

}else{

    $message_status = 7;

}

$insert = DB::select("INSERT INTO whatsapp 
(fullname,
phone, 
message,
message_status,
status_id,
chat_date,
created_at
) 
VALUES 
('" . $fullname . "', 
'" . $phone . "', 
'" . $message . "',
'" . $message_status . "',
'1',
'" . $dateInGMT7 . "',
'" . $dateInGMT7 . "'
) ");

return $response;

}


   /**
     * Get Doctor Data From Order ID
     */
    public function getAdmByOrderID($order_id)
    {

        $query_get = $this
            ->conn
            ->query("SELECT   
											a.OrderID,
											b.FirstName,
											b.LastName,
											b.DoctorID
										FROM doc_orders_current a
										INNER JOIN doc_doctors b ON a.DoctorID = b.DoctorID 
										WHERE a.Active=1 AND a.OrderID='" . $order_id . "' ");

        if (mysqli_num_rows($query_get) > 0)
        {
            return $query_get;
        }
        else
        {
            return null;
        }
    }

    public function getChatList($chat_from  , $page , $limit)
    {
    
        $condition = '';
        if ($page != '' && $limit != '')
        {
            if ($page == 1)
            {
                $p = 0;
            }
            else
            {
                $p = ($page - 1) * $limit;
            }

            $condition .= "LIMIT " . $limit . " OFFSET " . $p . " ";
        }

    $query_get = DB::select("
    SELECT   
    MAX(chat_id) AS chat_id,
    chat_from,
    chat_to,
    MAX(message) AS message,
    MAX(chat_date) AS chat_date
    FROM chat
    WHERE chat_from = '" . $chat_from . "'
    GROUP BY chat_to, chat_from
    ORDER BY chat_date ASC
     " . $condition);
    
     if (!empty($query_get)) {
    
    return $query_get;
    
     } else {
    
      return 1;
     }
    }
    
public function getChat($chat_from , $chat_to)
{

$query_get = DB::select("SELECT   
chat_id,
message,
chat_date,   
message_status, 
has_sent, 
(CASE WHEN LEFT(chat_from, 3) = 'adm' THEN '1' ELSE '0' END) AS chat_from,
(CASE WHEN LEFT(chat_from, 3) = 'adm' THEN 'right' ELSE 'left' END) AS position
FROM chat
WHERE chat_from = '" . $chat_from . "' and chat_to = '" . $chat_to . "'
ORDER BY chat_id ASC

 ");

 if (!empty($query_get)) {

return $query_get;

 } else {

  return 1;
 }
}


function str_before($string, $substring)
{
    $pos = strpos($string, $substring);
    if ($pos === false) return $string;
    else return (substr($string, 0, $pos));
}

function str_after($string, $substring)
{
    $pos = strpos($string, $substring);
    if ($pos === false) return $string;
    else return (substr($string, $pos + strlen($substring)));
}


	
	}

?>