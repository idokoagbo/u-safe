<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncidentResponse;
use App\ResponseCode;
use App\User;
use App\Notification;
use App\Location;
use Auth;
use DB;
use Hash;
use Carbon\Carbon;

class ApiController extends Controller
{
    //
    
    public function login(Request $request){
		
		if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
			// The user is active, not suspended, and exists.
			return Auth::user()->id;
		}else{
            return 'false';
        }
    }
    
    /*password reset*/
    
    public function reset_password(Request $request){
        $user=User::where('email',$request->username)->first();
        
        //return $request->username;
        
        if($user!=null){
            $password=str_random(8);
            
            $user->password=bcrypt($password);
            $user->save();
            
            $email=$user->email;
            
            $headers = "From: UNDSS STT NEA <info@ireport.ng> \r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
            $msg="Hello there! <br/><p>Your new password is <b>$password</b></p> <p>If this was not your request, then please contact support immediately.</p> <br/><p>Regards,</p><p>UNDSSS Team.</p>";

            mail($email,"Reset Password",$msg,$headers);
            
            return 'true';
        }else{
            return 'false';
        }
    }
    
    /*people near by*/
    public function nearby($id){
        
        $users=User::where('id','!=',$id)->get();
        $data=array();
        $x=0;
        foreach($users as $user){
            $data[]=[$user->staff_code,$user->latitude,$user->longitude,$x++];
        }
        
        $locations=$data;
        
        return json_encode($locations);
    }
	
	public function update_location($user_id,$lat,$lng){
		
		$user=User::where('id',$user_id)->first();
		
		if($lat!=0 && $lng!=0){
			$user->latitude=$lat;
			$user->longitude=$lng;
			$user->save();
            
            $location=new Location;
            $location->user_id=$user->id;
            $location->latitude=$lat;
            $location->longitude=$lng;
            
            $location->save();
			
			return 'true';
		}
	}
    
    //get location
    
    public function get_location($id){
        $user=User::where('id',$id)->first();
        
        return $user;
    }
    
    //add notification
    
    public function add_notification($player_id,$user_id){
        $user=User::where('id',$user_id)->first();
        
        if($user->notification_id!=$player_id && $player_id!=null && $player_id!='null'){
            $user->notification_id=$player_id;
            $user->save();
            
            $content = array(
                "en" => 'You have subscribed to receive notifications'
                );

            $fields = array(
                'app_id' => "405d4fc3-134c-4d95-9fa7-b1bf200dc625",
                'include_player_ids' => array("$user->notification_id"),
                'data' => array("foo" => "bar"),
                'contents' => $content
            );

            $fields = json_encode($fields);
            print("\nJSON sent:\n");
            print($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        }
        
        
    }

	//headcount
	
	public function headcount($incidence_id,$user_id){
		
		$user=User::where('id',$user_id)->first();
		
		$incidence=IncidentResponse::where('id',$incidence_id)->first();
		
		return view('welcome')->with('message',"<script>alert('Thank you for responding')</script>");
		
		if($user->id==$incidence->user_id){
			return "<script>alert('Thank you for responding')</script>";
		}else{
			return "<script>alert('Thank you for responding')</script>";
		}
		
		return $user_id;
	}
    
    //get notifications
    
    public function notifications($id){
        $notifications=Notification::where('user_id',$id)->orderBy('id','DESC')->get();
        
        return $notifications;
    }
    
    public function notifications_count($id){
        $notifications=Notification::where('user_id',$id)->where('status',0)->orderBy('id','DESC')->get();
        
        return count($notifications);
    }
    
    //report incidence
    
    public function report(Request $request){
        
        $user_id=$request->user_id;
        $lat=$request->lat;
        $lng=$request->lng;
        $event=ResponseCode::where('id',$request->incidence)->value('name');
        
        $circle_radius = 3959;
        $max_distance = 5;
        
        $sender=User::where('id',$user_id)->first();
        
        if(($request->notification_id!=null||$request->incident_id!=null) && $request->response_id!=null){
            
            if($request->notification_id!=null){
                $notification=Notification::where('id',$request->notification_id)->first();
            }else{
                $notification=Notification::where('user_id',$request->user_id)->where('incident_id',$request->incident_id)->where('status',0)->orderBy('id','DESC')->first();
            }            
            
            $notification->status=$request->response_id;
            if($lat!=0 && $lng!=0){
                $notification->geolocation="$lat,$lng";
            }
            $notification->message=$notification->message." - ".$request->message;
            /*process file upload*/
            if($request->img1!=null){
                $file_1="UP1_".time().".".$request->img1->getClientOriginalExtension();
                $request->img1->move(public_path('/uploads'),$file_1);

                $notification->img1=$file_1;
            }

            if($request->img2!=null){
                $file_2="UP2_".time().".".$request->img2->getClientOriginalExtension();
                $request->img2->move(public_path('/uploads'),$file_2);

                $notification->img2=$file_2;
            }
            $notification->save();
            
            return "true";
            exit();
        }
        
        if($request->incidence=='safe'){
            return "true";
            exit();
        }        
        
        if($lat==0||$lng==0){
            
            if($sender->latitude!=null && $sender->latitude!=0 && $sender->longitude!=null && $sender->longitude!=0){
                
                //use last known location
                
                $lat=$sender->latitude;
                $lng=$sender->longitude;
                
            }else{
                
                
                //get geolocation from ip address
                
                //$ip=$_SERVER["REMOTE_ADDR"];
                // Get real visitor IP behind CloudFlare network
                if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                    $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                }
                $client  = @$_SERVER['HTTP_CLIENT_IP'];
                $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
                $remote  = $_SERVER['REMOTE_ADDR'];

                if(filter_var($client, FILTER_VALIDATE_IP))
                {
                    $ip = $client;
                }
                elseif(filter_var($forward, FILTER_VALIDATE_IP))
                {
                    $ip = $forward;
                }
                else
                {
                    $ip = $remote;
                }

                $ip='197.211.61.133';

                //$location=var_export(unserialize());
                $geoPlugin_array = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
                $lat=$geoPlugin_array['geoplugin_latitude'];
                $lng=$geoPlugin_array['geoplugin_longitude'];
                
            }
            
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=true");
        curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=true&key=AIzaSyBJFgs3x_JMVh4lvBcqRD42uW7vBohkavY");
        $location = curl_exec($ch);
        curl_close($ch);
        
        //return $location;
        
        $address_json=json_decode($location);
        
        if($address_json->results[2]->address_components){
            $address_data = $address_json->results[2]->address_components;
            
            if(is_numeric($address_data[0]->short_name)){
                $address_data[0]->short_name=$address_data[2]->short_name;
            }
            
        }else{
            $address_data[0]->short_name='Unknown Location';
        }
        
        //return $address_data;
        
        /*get response code*/
        $response_code=ResponseCode::where('name','LIKE',"$event")->first();
        
        /*store incidence report*/
        
        $response=new IncidentResponse;
        
        $response->response_type=2;
        $response->user_id=$sender->id;
        $response->response_code=$response_code->id;
        $response->geolocation="$lat,$lng";
        $response->description="$event around ".$address_data[0]->short_name." - ".$request->message;
        
        /*process file upload*/
        if($request->img1!=null){
            $file_1="UP1_".time().".".$request->img1->getClientOriginalExtension();
            $request->img1->move(public_path('/uploads'),$file_1);
            
            $response->file_attach1=$file_1;
        }
        
        if($request->img2!=null){
            $file_2="UP2_".time().".".$request->img2->getClientOriginalExtension();
            $request->img2->move(public_path('/uploads'),$file_2);
            
            $response->file_attach2=$file_2;
        }
        
        $response->save();
        
        
        $candidates = DB::select(
            'SELECT * FROM
                    (SELECT id, name, address, phone, notification_id, latitude, longitude, (' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(' . $lng . ')) +
                    sin(radians(' . $lat . ')) * sin(radians(latitude))))
                    AS distance
                    FROM users) AS distances
                WHERE distance < ' . $max_distance . '
                ORDER BY distance ASC;
            ');
        
        
        /*check for recent incidence report*/
        
        $check_incidence=IncidentResponse::where('id','!=',$response->id)->where('response_code',$response->response_code)->where('description','LIKE',"%".$address_data[0]->short_name."%")->where('created_at','>=',Carbon::now()->subMinute(15))->get();
        
        if($check_incidence->isNotEmpty()){
            
            //return $check_incidence;
            
            return 'true';
            exit();
        }
        
        /*alerting every personels*/
        if($candidates==null){
            
            $player_ids=User::pluck('notification_id');
            
        }
        /*alerting personells nearby*/
        else{
            $player_ids;
            foreach($candidates as $candidate){
                $player_ids[]=$candidate->notification_id;
            }
        }
        
        //return $player_ids;
        
        $content = array(
            "en" => "$event around ".$address_data[0]->short_name
        );
        
        $hashes_array = array();
        array_push($hashes_array, array(
            "id" => "safe-button",
            "text" => "I am Safe",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
        ));
        array_push($hashes_array, array(
            "id" => "danger-button",
            "text" => "I am in Danger",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
        ));
        
        $fields = array(
            'app_id' => "405d4fc3-134c-4d95-9fa7-b1bf200dc625",
            'include_player_ids' => $player_ids,
            'data' => array("incident_id" => "$response->id"),
            'contents' => $content,
            'buttons' => $hashes_array,
            'priority'=> 10
        );
        
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response2 = curl_exec($ch);
        curl_close($ch);
        
        /*save notification*/
        $message="$event around ".$address_data[0]->short_name;
        Notification::create_notification($player_ids,$response->id,$message);
        
        return 'true';
    }
    
    //admin
    
    public function get_new_notifications(){
        $notifications=IncidentResponse::where('status',0)->orderBy('id','DESC')->limit(5)->get();
        
        return $notifications;
    }
    
    public function send_mail($email){
        
        $headers = "From: Apple Test <hello@apple.com> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
        $msg="Hello there! this is a test mail</p>";

        mail($email,"Mail Test",$msg,$headers);
        
    }
    
    public function change_password(Request $request){
        
        $user=User::where('id',$request->user_id)->first();
        
        $current_password=$user->password;
        
        $request_data=$request->all();
        
        if(Hash::check($request_data['old_password'],$current_password)){
            
            if($request_data['new_password']===$request_data['confirm_password']){

                $user->password=Hash::make($request_data['new_password']);
                $user->save();

                return "true";
            }else{
                return "Password Mis-match";
            }
            
            
        }else{
            return "Password Incorrect";
        }
        
    }
}
