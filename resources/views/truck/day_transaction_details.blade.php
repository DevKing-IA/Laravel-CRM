@extends('layout.main') 
@section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center">{{trans('file.Transaction Details')}}</h3>
                <h3 class="text-center">{{trans('file.Maximum Capacity')}} [ {{$get_truck_data->capacity}} kg]</h3>
            </div>
            {!! Form::open(['route' => 'trucks.daytransaction', 'method' => 'post']) !!}
            <div class="row">
                <div class="col-md-4 offset-md-2 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} To {{$end_date}}" id="title_date" required />
                                <input type="hidden" name="start_date" id="sstart" value="{{$start_date}}" />
                                <input type="hidden" name="end_date" id="estart" value="{{$end_date}}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>{{trans('file.Choose Trucks')}}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <select id="trucks_myid" name="trucks_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                               @foreach($truck_data as $key=>$truck)
                               <option 
                                @if($truck_id == $truck->id)
                                {{"selected"}}
                                @endif
                               value="{{$truck->id}}">{{$truck->name}}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <div class="form-group">
                        <button class="btn btn-success" type="button" data-toggle="modal" id="qty" data-target="#myModal">Add Qty</button>
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="table-responsive mb-4">
                <table id="transation-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="not-exported-transaction"></th>
                            <th>{{trans('file.product')}} {{trans('file.name')}}</th>
                            <th>{{trans('file.product')}} ({{trans('file.qty')}})</th> 
                            <th>{{trans('file.weight')}}</th>
                            <th>{{trans('file.Delivery')}} {{trans('file.reference')}}</th>                           
                            <th>{{trans('file.grand total')}}</th>                            
                            <th>{{trans('file.qty')}} * {{trans('file.weight')}}</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $total_grand=0;
                         $toal_qty_w=0;
                         ?>
                         
                        @foreach($lims_truck_data as $k=>$item)                       
                        <tr>
                            <?php 
                            $total_grand += $item->total;
                            $toal_qty_w += $item->qty*$item->weight;
                             ?>
                            <td>{{$k}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->weight}}</td>
                            <td>{{$item->reference_no}}</td>
                            <td>{{$item->total}}</td>                            
                            <td>{{$item->qty*$item->weight}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="tfoot active">                       
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ number_format($total_grand,2)}}</th>
                            <th 
                            @if($toal_qty_w > $get_truck_data->capacity)
                            style="color:red"
                            @endif
                            >{{ number_format($toal_qty_w,2)}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <div class="modal-header">
          <h5 class="modal-title">ADD Qty</h5>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <div class="modal-body">
                {!! Form::open(['route' => 'delivery.store', 'method' => 'post', 'files' => true]) !!}
                <?php 
                    $lims_product_list = \App\Product::all();
                ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Delivery Reference')}}</strong></label>
                        <p id="dr"></p>
                    </div>
<!--                      <div class="col-md-6 mt-2 form-group">
                        <label><strong>Product Name</strong></label>
                        <input type="text" name="delivered_by" class="form-control" value="{{$item->name}}">
                    </div> -->



                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Product Name')}}</strong> &nbsp;</label>
                            <select id="trucks_id" name="trucks_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                               @foreach($lims_product_list as $key=>$truck)
                               <option 
                                @if($truck_id == $truck->id)
                                {{"selected"}}
                                @endif
                               value="{{$truck->id}}">{{$truck->name}}</option>
                               @endforeach
                            </select>
                    </div>



                    <div class="col-md-6 mt-2 form-group">
                        <label><strong>Add Product(Qty)</strong></label>
                        <input type="number" name="delivered_by" class="form-control">
                        <input type="hidden" class="hidden" value="">
                    </div>
                </div>

        </div>
        
        <div class="modal-footer">
              <button type="submit" class="btn btn-danger">SUBMIT</button>
          {{ Form::close() }}
        
        </div>
        
      </div>
    </div>
  </div>
<script type="text/javascript">

    $("#qty").click(function(){
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var yyyy = today.getFullYear();

        today ="dr" + "-" + yyyy + mm + dd + "-" + new Date().getHours("hh") + new Date().getMinutes("mm") + new Date().getSeconds("ss");
        $("#dr").text(today);
    });



    var titleTimerId = setInterval(function(){


        document.title = "Prodecon-Demacol" + "(" + $("#trucks_myid option:selected" ).text() + ", "+ $("#sstart").val() + " to " + $("#estart").val() + ")";
        
    }, 800);


    $('#transation-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-transaction)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-transaction)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-transaction)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
           console.log("tue");
        }
    } );
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    var prev_date = new Date();
    console.log(prev_date);
prev_date.setDate(prev_date.getDate() + 30000);    
    $(".daterangepicker-field").daterangepicker({
        maxDate: prev_date,
    callback: function(startDate, endDate, period){
        var start_date = startDate.format('YYYY-MM-DD');
        var end_date = endDate.format('YYYY-MM-DD');
        var title = start_date + ' To ' + end_date;
        $(".daterangepicker-field").val(title);
        $('input[name="start_date"]').val(start_date);
        $('input[name="end_date"]').val(end_date);
    }
    });
</script>
@endsection