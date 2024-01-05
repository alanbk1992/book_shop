<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\BooksModel;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use Carbon\Carbon;
class BooksController extends Controller
{

          /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
	public function index()
	{
       

        $db = new BooksModel;
        $modeHeader = 0;
        $post = json_decode(file_get_contents("php://input"), true);
        $customers = array();

        $getData = $db->getBooks();

        // var_dump ($getData);die;
        if ($getData != 1) {

              
            foreach($getData as $customer)
            {
    
  
             $books []= array(
                        "book_id" => $customer->book_id,
                         "authors" => $customer->authors
                         );
    
            }

           $data = [
            
           'books' => $customers,
        
        ];   
        // var_dump ($data);die;
           return view('pages.books', $data);
    
            } else {

              return view('pages.books');
                
             }

		
	}
	


}

 error_reporting(0);
