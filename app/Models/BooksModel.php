<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BooksModel extends Model
{

 
    
    public function getBooks()
    {

    

     $query_get = DB::select("SELECT  a.book_id, 
     a.title,
     GROUP_CONCAT(c.name ORDER BY c.name) authors
FROM    books a
     INNER JOIN book_author b
         ON a.book_id = b.book_id 
     INNER JOIN AUTHORS c
         ON b.author_id = c.author_id
GROUP   BY a.book_id, a.title
   
     ");

     if (!empty($query_get)) {
    return $query_get;
     } else {
    
      return 1;
     }
    }

    
    
       
   

}


?>