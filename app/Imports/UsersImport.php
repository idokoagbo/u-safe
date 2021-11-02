<?php 

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {   
        
        //echo $rows;
        $data;
        
        
        foreach ($rows as $row) 
        {
            
            if($row['agency']!=null){
                $agency=$row['agency'];
            }
            
            if($row['name_of_sm']!=null||$row['conatct_no_cellphone']!=null){
                $data[]=[
                    'name'=>$row['name_of_sm'],
                    'phone'=>$row['conatct_no_cellphone'],
                    'agency'=>$agency,
                    'staff_code'=>$row['radio_call_sign'],
                    'status'=>$row['inout']
                ];
            }
            
                
        }
        
        echo json_encode($data);
        
        exit();
        
    }
    
    public function headingRow(): int
    {
        return 2;
    }
}