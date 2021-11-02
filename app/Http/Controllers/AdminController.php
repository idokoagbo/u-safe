<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\IncidentResponse;
use App\Notification;
use Auth;
use Carbon\Carbon;
use Excel;
use File;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Exports\IncidentExport;
use App\Exports\HeadcountExport;

class AdminController extends Controller
{
    //
    
    public function login(){
        return view('admin.login');
    }
    
    public function Authenticate(Request $request){
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role'=>'3'])) {
            // Authentication passed...
            return redirect()->intended('admin/dashboard');
        }
    }
    
    public function dashboard(){
        return view('admin.dashboard');
    }
    
    public function users(){
        return view('admin.users');
    }
    
    public function reports($filter=null){
        
        if($filter=='new'){
            $reports=IncidentResponse::where('status',0)->orderBy('id','desc')->get(); 
        }else if($filter=='seen'){
            $reports=IncidentResponse::where('status',1)->orderBy('id','desc')->get(); 
        }else{
            $reports=IncidentResponse::orderBy('id','desc')->get();
        }
        
        return view('admin.reports',compact('reports'));
    }
    
    public function single_report($id){
        $report=IncidentResponse::where('id',$id)->first();
        $sender=User::where('id',$report->user_id)->first();
        
        
        $report->status=1;
        $report->save();
        
        $staffs=Notification::where('incident_id',$report->id)->get();
        
        return view('admin.report-single',compact('report','sender','staffs'));
        return $report;
    }
    
    public function headcount(){
        return view('admin.headcount');
    }
    
    public function staff_location(){
        return view('admin.staff-location');
    }
    
    public function heatmap(){
        return view('admin.heatmap');
    }
    
    public function date_filter(Request $request){
        
        $start_date=Carbon::parse($request->start_date);
        $end_date=Carbon::parse($request->end_date)->addDays(1);
        
        $reports=IncidentResponse::where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
        
        return view('admin.reports',compact('reports'));
        
        return $request->all();
    }
    
    public function import(Request $request){
        //return $request->all();
        
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                
                return Excel::import(new UsersImport, request()->file('file'));
                
 
            }else {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
    }
    
    public function user_export(Request $request){
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function incident_export(Request $request){
        return Excel::download(new IncidentExport, 'incidents.xlsx');
    }
    public function response_export(Request $request){
        return Excel::download(new HeadcountExport, 'responses.xlsx');
    }
}
