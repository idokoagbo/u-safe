<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseCode extends Model
{
    //
    
    public static function code($incidence){
        return ResponseCode::where('id',$incidence)->value('name');
    }
}
