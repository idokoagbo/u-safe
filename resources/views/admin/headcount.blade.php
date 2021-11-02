@extends('layouts.admin.app')


@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Headcount
      </h1>
      <!--ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol-->
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div id="alert-area"></div>
        
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Headcount</h3>
            
          <div class="box-tools pull-right">
            <a href="#" onclick="PrintElem('print-area')" class="btn btn-warning btn-sm"><i class="fa fa-print"></i> Print Report</a>  
          </div>            
            
        </div>
        <div class="box-body" id="print-area">
            <table class="table table-bordered" cellspacing="10" style="width:100%">
                <thead>
                    <tr><th>S/N</th> <th>Agency</th> <th>Response</th></tr>
                </thead>
                
                <tbody style="text-align:center">
                    <?php $x=1;?>
                    @forelse(App\Agency::all() as $agency)
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$agency->name}}</td>
                        <td>{{count(App\Agency::headcount($agency->id))}}</td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

<script>
function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>

@endsection