<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\IncidentResponse;
use App\Notification;

class Agency extends Model
{
    //
    
    public static function headcount($id){
        $agency=Agency::where('id',$id)->first();
        $latest=IncidentResponse::orderBy('id','DESC')->first();
        
        $users=User::where('agency_id',$agency->id)->pluck('id');
        
        $count=Notification::where('incident_id',$latest->id)->whereIn('user_id',$users)->where('status',1)->get();
        
        return $count;
        
    }
}
