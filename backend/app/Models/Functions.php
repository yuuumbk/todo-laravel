<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;

    // public static function is_3_digits_binary($data) {
    //   if(is_string($data) || is_int($data)){
    //     $data = (string)$data;
    //     return preg_match('|\A[0-1]{3}\z|', $data) > 0;
    //   }else{
    //     return false;
    //   }
    // }
}
