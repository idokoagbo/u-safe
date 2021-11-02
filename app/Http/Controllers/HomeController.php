<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncidentResponse;
use App\ResponseCode;
use App\User;
use Auth;
use DB;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function response_handler(Request $request){
        
        if($request->type==1){
            
            $response=new IncidentResponse;
        
            $response->response_type=1;
            $response->user_id=Auth::user()->id;
            $response->response_code=0;
            $response->geolocation=Auth::user()->latitude.", ".Auth::user()->longitude;;
            $response->save();
            
            return redirect('/upload/'.$response->id)->with('message','Notification Sent');
            
        }else{
            return view('danger');
        }
        
    }
    
    public function response_store(Request $request){
        //return $request->all();
        
        //$user_latitude=Auth::user()->latitude;
        //$user_longitude=Auth::user()->longitude;
        
        $circle_radius = 3959;
        $max_distance = 3;
        $lat = $request->lat;
        $lng = $request->lng;
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?latlng=$request->lat,$request->lng&sensor=true");
        //curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?latlng=$request->lat,$request->lng&sensor=true&key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU");
        $location = curl_exec($ch);
        curl_close($ch);
        
        //return $location;
        
        $address_json=json_decode($location);
        
        if($address_json->results[2]->address_components){
            $address_data = $address_json->results[2]->address_components;
            
        }else{
            $address_data[0]->short_name='Unknown Location';
        }
        
        $response=new IncidentResponse;
        
        $response->response_type=2;
        $response->user_id=Auth::user()->id;
        $response->response_code=ResponseCode::code($request->incidence);
        $response->geolocation="$request->lat,$request->lng";
        $response->description="$request->incidence attack around ".$address_data[0]->short_name;
        $response->save();
        
        $candidates = DB::select(
            'SELECT * FROM
                    (SELECT id, name, address, phone, latitude, longitude, (' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(' . $lng . ')) +
                    sin(radians(' . $lat . ')) * sin(radians(latitude))))
                    AS distance
                    FROM users) AS distances
                WHERE distance < ' . $max_distance . '
                ORDER BY distance ASC;
            ');
        
        if($candidates==null){
            
            foreach(User::all() as $user){
                //return $candidate->phone;

                if($user->phone!=null){
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, "http://justsms.com.ng/components/com_spc/smsapi.php?username=idoko&password=liberty%1&balance=true");
                    $check = curl_exec($ch);
                    curl_close($ch);
                    
                    //$check = file_get_contents("http://justsms.com.ng/components/com_spc/smsapi.php?username=idoko&password=liberty%1&balance=true");
                    
                    if($check>=1.8){

                        $msg="$request->incidence attack around ".$address_data[0]->short_name." ".url('/headcount?incidence='.$response->id.'&id='.$user->id);
                        $url="http://justsms.com.ng/index.php?option=com_spc&comm=spc_api&username=idoko&password=liberty%1&sender=U-SAFE&recipient=$user->phone&message=$msg&";
                        $url = preg_replace("/ /", "%20", $url);
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, "http://justsms.com.ng/components/com_spc/smsapi.php?username=idoko&password=liberty%1&balance=true");
                        $xml = curl_exec($ch);
                        curl_close($ch);
                        
                        //$xml = file_get_contents($url);

                        if(strpos($xml,'OK')!==false){
                            //return $msg;
                        }
                    }else{
                        //return back()->with('status','Unable to send');
                    }
                }else{

                    $email=$user->email;

                    $headers = "From: U-SAFE <no-reply@u-safe.com> \r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $msg="$request->incidence attack around ".$address_data[0]->short_name." ".url('/headcount?incidence='.$response->id.'&id='.$user->id);

                    mail($email,"U-SAFE Incidence Notification",$msg,$headers);
                }
            }
            
            return redirect('/upload/'.$response->id)->with('message','Notification Sent');
            
        }else{
            foreach ($candidates as $user){
                //return $candidate->phone;

                if($user->phone!=null){
                    $ch1 = curl_init();
                    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch1, CURLOPT_URL, "http://justsms.com.ng/components/com_spc/smsapi.php?username=idoko&password=liberty%1&balance=true");
                    $check = curl_exec($ch1);
                    curl_close($ch1);
                    
                    //$check = file_get_contents("http://justsms.com.ng/components/com_spc/smsapi.php?username=idoko&password=liberty%1&balance=true");
                    
                    if($check>=1.8){

                        $msg="$request->incidence attack around ".$address_data[0]->short_name." ".url('/headcount?incidence='.$response->id.'&id='.$user->id);
                        $url="http://justsms.com.ng/index.php?option=com_spc&comm=spc_api&username=idoko&password=liberty%1&sender=U-SAFE&recipient=$user->phone&message=$msg&";
                        $url = preg_replace("/ /", "%20", $url);
                        
                        $ch2 = curl_init();
                        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch2, CURLOPT_URL, "http://justsms.com.ng/components/com_spc/smsapi.php?username=idoko&password=liberty%1&balance=true");
                        $xml = curl_exec($ch2);
                        curl_close($ch2);
                        
                        //$xml = file_get_contents($url);

                        if(strpos($xml,'OK')!==false){
                            //return $msg;
                        }
                    }else{
                        //return back()->with('status','Unable to send');
                    }
                }else{

                    $email=$user->email;

                    $headers = "From: U-SAFE <no-reply@u-safe.com> \r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $msg="$request->incidence attack around ".$address_data[0]->short_name." ".url('/headcount?incidence='.$response->id.'&id='.$user->id);

                    mail($email,"U-SAFE Incidence Notification",$msg,$headers);
                }
            }
            
            return redirect('/upload/'.$response->id)->with('message','Notification Sent');
        }
        
        /*$data = DB::select('SELECT id,( 3959 * acos( cos( radians(latitude) ) * cos( radians( $user_latitude ) ) * cos( radians( $user_longitude ) - radians(longitude) )+ sin( radians($user_latitude) ) * sin( radians( latitude ) ) ) ) AS distance FROM markers HAVING distance < 31.0686 ORDER BY distance LIMIT 0 , 20');*/
    }
    
    public function upload($incidence){
        
        $event=IncidentResponse::where('id',$incidence)->first();
        
        if($event==null){
            abort(404);
        }
        
        
        return view('upload',compact('event'));
    }
    
    public function upload_store(Request $request){
        //return $request->all();
        
        $event=IncidentResponse::where('id',$request->incidence_id)->first();
        
        if($request->file_1!=null){
            $file_1="UP1_".time().".".$request->file_1->getClientOriginalExtension();
            $request->file_1->move(public_path('/uploads'),$file_1);
            
            $event->file_attach1=$file_1;
        }
        
        if($request->file_2!=null){
            $file_2="UP2_".time().".".$request->file_2->getClientOriginalExtension();
            $request->file_2->move(public_path('/uploads'),$file_2);
            
            $event->file_attach2=$file_2;
        }
        
        if($request->file_3!=null){
            $file_3="UP3_".time().".".$request->file_3->getClientOriginalExtension();
            $request->file_3->move(public_path('/uploads'),$file_3);
            
            $event->file_attach3=$file_3;
        }
        
        if($request->file_4!=null){
            $file_4="UP4_".time().".".$request->file_4->getClientOriginalExtension();
            $request->file_4->move(public_path('/uploads'),$file_4);
            
            $event->file_attach4=$file_4;
        }
        
        $event->save();
        
        return redirect('/home')->with('status','Successful');
    }
}
