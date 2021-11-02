<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Agency;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'staff_code', 'phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public static function name($id){
        return User::where('id',$id)->value('name');
    }
    
    public static function photo($id){
        return asset('/admin/dist/img/avatar.png');
    }
    
    public static function agency($id){
        $agency_id=User::where('id',$id)->value('agency_id');
        
        if($agency_id!=null){
            return Agency::where('id',$agency_id)->value('name');
        }else{
            return '';
        }
    }
    
    //converting lat and long to dms
    
    public static function beliefmedia_dec_dms($dec) {
 
      $vars = explode(".", $dec);
      $deg = $vars[0];
      $tempma = '0.' . $vars[1];

      $tempma = $tempma * 3600;
      $min = floor($tempma / 60);
      $sec = $tempma - ($min * 60);

     return array('deg' => $deg, 'min' => $min, 'sec' => $sec);
    }
    
    public static function beliefmedia_lat_lng($lat, $lng) {
 
       $latpos = (strpos($lat, '-') !== false) ? 'S' : 'N';
       $lat = User::beliefmedia_dec_dms($lat);

       $lngpos = (strpos($lng, '-') !== false) ? 'W' : 'E';
       $lng = User::beliefmedia_dec_dms($lng);

     return $latpos . abs($lat['deg']) . '&deg;' . $lat['min'] . '&apos;' . $lat['sec'] . '&quot ' . $lngpos . abs($lng['deg']) . '&deg;' . $lng['min'] . '&apos;' . $lng['sec'] . '&quot';
    }
}
