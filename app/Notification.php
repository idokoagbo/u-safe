<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Notification extends Model
{
    //
    
    public static function create_notification($player_ids,$event_id,$message){
        $users=User::whereIn('notification_id',$player_ids)->get();
        
        foreach($users as $user){
            $notification=new Notification;
            
            $notification->user_id=$user->id;
            $notification->incident_id=$event_id;
            $notification->geolocation="$user->latitude,$user->longitude";
            $notification->message=$message;
            
            $notification->save();
        }
    }
    
    /*public static function getStatusAttribute($value){
        if($value==0){
            return "<label class='label label-warning'>Unknown</label>";
        }else if($value==1){
            return "<label class='label label-success'>Safe</label>";
        }else if($value==2){
            return "<label class='label label-danger'>Danger</label>";
        }
    }*/
}
