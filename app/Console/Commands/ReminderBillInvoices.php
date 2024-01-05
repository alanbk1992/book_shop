<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InvoicesModel;

class ReminderBillInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder-bill-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       
        //cari invoices yang belum bayar
        $search = "";
        $getData = $db->getInvoices($search);
        if ($getData != 1) {

              
            foreach($getData as $invoice)
            {
               
             $price = number_format($invoice->price, 0, '.');
             $fee_device = number_format($invoice->fee_device, 0, '.');
             $ppn = number_format($invoice->ppn, 0, '.');
       
       
           $total_price = $invoice->price +  $invoice->fee_device + $invoice->ppn;
       
       
           $invoices[] =  array(
       
             "invoice_id" => $invoice->invoice_id,
              "customer_id" => $invoice->customer_id,
              "customer_name" => $invoice->customer_name,
              "phone" => $invoice->phone,
              "service_member_id" => $invoice->service_member_id,
             "service_item_name" => $invoice->service_item_name,
             "price" => $price,
             "total_price" => number_format($total_price, 0, '.'),
             "service_name" => $invoice->service_name,
             "time" => $invoice->time,
             "type" =>$invoice->type,
             "speed" =>$invoice->speed,
             "quota" => $invoice->quota,
             "fee_device" => $fee_device,
             "ppn" => $ppn,
             "payment_type" => $invoice->payment_type,
             "bank_name" => $invoice->bank_name,
             "account_number" => $invoice->account_number,
             "remarks" => $invoice->remarks,
             "status_id" => $invoice->status_id,
             "created_at" => $invoice->created_at,
             "updated_at" => $invoice->updated_at
              );
            
         }
       
       
          $return = array(
          "status" => 200,
          "total_rows" => COUNT($invoices),
         "message" => "Success",
          "data" => $invoices
           );
               
         } else {
                                
           $return = array(
            "status" => 200,
            "total_rows" => 0,
            "message" => "Belum ada tagihan"
          );
                                       
         }
            
              
        //echo json_encode($return);

        $this->info(json_encode($return));
    }
    
}
